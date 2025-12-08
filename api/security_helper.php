<?php
/**
 * Security Helper for API Endpoints
 * Implements headers, rate limiting, and input sanitization.
 */

class ApiSecurity {
    
    public static function applySecurityHeaders() {
        // Prevent clickjacking
        header('X-Frame-Options: DENY');
        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');
        // Enable XSS filtering
        header('X-XSS-Protection: 1; mode=block');
        // HSTS (Strict Transport Security) - 1 year
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        // Disable caching for sensitive API responses
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
    }

    public static function disableErrorDisplay() {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(E_ALL); // Log everything, display nothing
        ini_set('log_errors', 1);
        // Ensure error log file is secure (default PHP log or custom)
    }

    public static function enforceMethod($method = 'POST') {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode(['status' => 'fail', 'msg' => "Method Not Allowed: Only $method is accepted"]);
            exit();
        }
    }

    /**
     * Simple File-Based Rate Limiter
     * @param int $limit Number of requests
     * @param int $period Time period in seconds
     */
    public static function rateLimit($limit = 30, $period = 60) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $ip = preg_replace('/[^0-9a-fA-F:.]/', '', $ip); // Sanitize IP
        
        $tmpDir = sys_get_temp_dir() . '/api_ratelimit';
        if (!is_dir($tmpDir)) {
            @mkdir($tmpDir, 0777, true);
        }

        $file = $tmpDir . '/' . md5($ip) . '.json';
        $data = ['hits' => 0, 'start_time' => time()];

        if (file_exists($file)) {
            $content = @json_decode(file_get_contents($file), true);
            if ($content) {
                $data = $content;
            }
        }

        $currentTime = time();
        if ($currentTime - $data['start_time'] > $period) {
            // Reset window
            $data['hits'] = 1;
            $data['start_time'] = $currentTime;
        } else {
            $data['hits']++;
        }

        if ($data['hits'] > $limit) {
            header('HTTP/1.0 429 Too Many Requests');
            header('Retry-After: ' . $period);
            echo json_encode(['status' => 'fail', 'msg' => 'Too Many Requests. Please try again later.']);
            // Save before exit to persist the hit count (or could lock out)
            @file_put_contents($file, json_encode($data));
            exit();
        }

        @file_put_contents($file, json_encode($data));
    }

    public static function sanitizeInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitizeInput($value);
            }
        } elseif (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->$key = self::sanitizeInput($value);
            }
        } elseif (is_string($data)) {
            // Remove null bytes and trim
            $data = trim(str_replace(chr(0), '', $data));
            // Basic HTML escaping if we were outputting to HTML, but for API inputs meant for DB/Logic:
            // We mainly rely on PDO binding for DB security.
            // But stripping tags can be safer for some text fields.
            $data = strip_tags($data); 
        }
        return $data;
    }
}
?>

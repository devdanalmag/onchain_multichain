<?php

    class Airtime extends ApiAccess{

        //Purchase Airtime
        public function purchaseMyAirtime($body, $networkDetails) {
            try {
                $details = $this->model->getApiDetails();
                
                // Validate input parameters
                if (!is_object($body)) {
                    throw new Exception("Invalid request body");
                }
                
                if (!is_array($networkDetails)) {
                    throw new Exception("Invalid network details");
                }
        
                // Check Airtime Type
                if ($body->airtime_type == "VTU") {
                    $name = "Vtu";
                    $thenetworkId = $networkDetails["vtuId"] ?? null;
                } else {
                    $name = "Sharesell";
                    $thenetworkId = $networkDetails["sharesellId"] ?? null;
                }
        
                if (empty($thenetworkId)) {
                    throw new Exception("Network ID not found for airtime type: " . $body->airtime_type);
                }
        
                // Get Api Key Details
                $networkname = strtolower($networkDetails["network"] ?? '');
                $host = self::getConfigValue($details, $networkname.$name."Provider");
                $apiKey = self::getConfigValue($details, $networkname.$name."Key");
        
                if (empty($host) || empty($apiKey)) {
                    throw new Exception("API configuration not found for network: " . $networkname);
                }
        
                // Check If API Is Using N3TData Or Bilalsubs
                if (strpos($host, 'n3tdata') !== false) {
                    $hostuserurl = "https://n3tdata.com/api/user/";
                    return $this->purchaseAirtimeWithBasicAuthentication($body, $host, $hostuserurl, $apiKey, $thenetworkId);
                }
        
                if (strpos($host, 'bilalsadasub') !== false) {
                    $hostuserurl = "https://bilalsadasub.com/api/user/";
                    return $this->purchaseAirtimeWithBasicAuthentication($body, $host, $hostuserurl, $apiKey, $thenetworkId);
                }
        
                // Purchase Airtime
                $ported_number = (isset($body->ported_number) && $body->ported_number !== "false") ? "true" : "false";
        
                $postData = [
                    "network" => $thenetworkId,
                    "amount" => $body->amount,
                    "mobile_number" => $body->phone,
                    "Ported_number" => $ported_number,
                    "request-id" => $body->ref,
                    "airtime_type" => $body->airtime_type
                ];
        
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $host,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 60, // Set a reasonable timeout
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($postData),
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        "Authorization: Token $apiKey"
                    ],
                ]);
        
                $response = curl_exec($curl);
                $error = curl_error($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
        
                // Log the complete request and response for debugging
                $logData = [
                    'timestamp' => date('Y-m-d H:i:s'),
                    'request' => $postData,
                    'response' => $response,
                    'error' => $error,
                    'http_code' => $httpCode
                ];
        
                if ($error) {
                    $this->logErrors("CURL Error: " . $error, $logData);
                    return [
                        "status" => "fail",
                        "msg" => "Server Connection Error",
                        "error_details" => $error
                    ];
                }
        
                $result = json_decode($response);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->logErrors("Invalid JSON response", $logData);
                    return [
                        "status" => "fail",
                        "msg" => "Invalid server response",
                        "response" => $response
                    ];
                }
        
                if (isset($result->Status) && ($result->Status == 'successful' || $result->Status == 'processing')) {
                    return ["status" => "success"];
                } else {
                    $errorMsg = $result->message ?? "Server/Network Error";
                    $this->logErrors("API Error: " . $errorMsg, $logData);
                    return [
                        "status" => "fail",
                        "msg" => $errorMsg,
                        "api_response" => $result
                    ];
                }
            } catch (Exception $e) {
                $this->logErrors("Exception: " . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                    'body' => $body,
                    'networkDetails' => $networkDetails
                ]);
                return [
                    "status" => "fail",
                    "msg" => "System error occurred",
                    "error" => $e->getMessage()
                ];
            }
        }
        
        // private function logErrors($message, $context = []) {
        //     $logEntry = [
        //         'timestamp' => date('Y-m-d H:i:s'),
        //         'message' => $message,
        //         'context' => $context,
        //         'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        //         'user_id' => $this->userId ?? 'unknown'
        //     ];
        
        //     // Log to file
        //     file_put_contents(
        //         'airtime_errors.log',
        //         json_encode($logEntry) . PHP_EOL,
        //         FILE_APPEND
        //     );
        
        //     // Consider also logging to database or other systems
        // }

        //Purchase Airtime
        public function purchaseAirtimeWithBasicAuthentication($body, $host, $hostuserurl, $apiKey, $thenetworkId) {
            $response = [];
            
            // Validate input parameters
            if (!is_object($body)) {
                $this->logErrors("Invalid request body", ['host' => $host, 'apiKey' => '***'.substr($apiKey, -4)]);
                return ["status" => "fail", "msg" => "Invalid request"];
            }
        
            // ------------------------------------------
            //  Get User Access Token
            // ------------------------------------------
            $ported_number = (isset($body->ported_number) && $body->ported_number !== "false") ? true : false;
        
            try {
                $curlA = curl_init();
                curl_setopt_array($curlA, [
                    CURLOPT_URL => $hostuserurl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30, // Added reasonable timeout
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => [
                        "Authorization: Basic $apiKey",
                        'Content-Type: application/json'
                    ],
                ]);
        
                $exereqA = curl_exec($curlA);
                $err = curl_error($curlA);
                $httpCode = curl_getinfo($curlA, CURLINFO_HTTP_CODE);
                
                if ($err) {
                    $this->logErrors("Token API Connection Error", [
                        'error' => $err,
                        'http_code' => $httpCode,
                        'url' => $hostuserurl
                    ]);
                    curl_close($curlA);
                    return ["status" => "fail", "msg" => "Server Connection Error"];
                }
        
                $resultA = json_decode($exereqA);
                if (json_last_error() !== JSON_ERROR_NONE || !isset($resultA->AccessToken)) {
                    $this->logErrors("Invalid Token API Response", [
                        'response' => $exereqA,
                        'http_code' => $httpCode
                    ]);
                    curl_close($curlA);
                    return ["status" => "fail", "msg" => "Authentication failed"];
                }
        
                $apiKey = $resultA->AccessToken;
                curl_close($curlA);
        
                // ------------------------------------------
                //  Purchase Airtime
                // ------------------------------------------
                $postData = [
                    "network" => $thenetworkId,
                    "amount" => $body->amount,
                    "phone" => $body->phone,
                    "bypass" => $ported_number,
                    "request-id" => $body->ref,
                    "plan_type" => $body->airtime_type
                ];
        
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $host,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30, // Added reasonable timeout
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($postData), // Using json_encode instead of string concatenation
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        "Authorization: Token $apiKey"
                    ],
                ]);
        
                $exereq = curl_exec($curl);
                $err = curl_error($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                
                if ($err) {
                    $this->logErrors("Airtime API Connection Error", [
                        'error' => $err,
                        'http_code' => $httpCode,
                        'request' => $postData,
                        'url' => $host
                    ]);
                    curl_close($curl);
                    return ["status" => "fail", "msg" => "Server Connection Error"];
                }
        
                $result = json_decode($exereq);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->logErrors("Invalid Airtime API Response", [
                        'raw_response' => $exereq,
                        'http_code' => $httpCode
                    ]);
                    curl_close($curl);
                    return ["status" => "fail", "msg" => "Invalid server response"];
                }
        
                curl_close($curl);
        
                if (isset($result->status) && ($result->status == 'successful' || $result->status == 'success')) {
                    return ["status" => "success"];
                } else {
                    $errorMsg = $result->message ?? "Server/Network Error";
                    $this->logErrors("Airtime Purchase Failed", [
                        'api_response' => $result,
                        'request' => $postData
                    ]);
                    return [
                        "status" => "fail",
                        "msg" => $errorMsg,
                        "api_response" => $result // Returning full response for debugging
                    ];
                }
            } catch (Exception $e) {
                $this->logErrors("Exception in airtime purchase", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return ["status" => "fail", "msg" => "System error occurred"];
            }
        }
        
        private function logErrors($message, $context = []) {
            $logEntry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'From' => 'Controller:: Airtime',
                'message' => $message,
                'context' => $context,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                'user_id' => $this->userId ?? 'unknown'
            ];
        
            // Log to single file with append mode
            file_put_contents(
                __DIR__ . '/../../log_error/error_log.txt',
                json_encode($logEntry) . PHP_EOL,
                FILE_APPEND
            );
        }


    }

?>
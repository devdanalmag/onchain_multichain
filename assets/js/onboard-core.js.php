<?php
// Proxy loader for @web3-onboard/core UMD to avoid CDN MIME/CORS blocks
header('Content-Type: application/javascript; charset=UTF-8');
header('Cache-Control: public, max-age=86400');

$src = 'https://cdn.jsdelivr.net/npm/@web3-onboard/core@2.22.1/dist/umd/index.min.js';

function fetch_remote($url) {
  // Prefer cURL if available for better control
  if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_USERAGENT, 'AssetchainDEX/1.0');
    $out = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($out !== false && $code >= 200 && $code < 400) return $out;
  }
  // Fallback to file_get_contents
  $ctx = stream_context_create([
    'http' => [
      'method' => 'GET',
      'timeout' => 15,
      'header' => "User-Agent: AssetchainDEX/1.0\r\n",
    ]
  ]);
  return @file_get_contents($url, false, $ctx);
}

$js = fetch_remote($src);
if (!$js) {
  echo 'console.warn("Onboard core proxy failed: could not fetch remote script");';
  exit;
}
echo $js;
?>
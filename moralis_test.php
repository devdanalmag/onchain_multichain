<?php
// Test Moralis API directly

$configFile = __DIR__ . '/config/moralis.json';
if (!file_exists($configFile)) {
    die("Config file not found");
}

$config = json_decode(file_get_contents($configFile), true);
$apiKey = $config['api_key'] ?? '';

if (!$apiKey)
    die("API Key missing");

$tx_hash = '0x3c791b74a67e95b55d5832b684856af0e56fd37b896e61acddf2ec076b0a0ae1';
$chain = 'base'; // Trying 'base'
$baseUrl = 'https://deep-index.moralis.io/api/v2.2';

function requestMoralis($endpoint, $params, $baseUrl, $apiKey)
{
    $url = $baseUrl . $endpoint;
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }

    echo "Requesting: $url\n";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'X-API-Key: ' . $apiKey
    ]);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "HTTP Code: $httpCode\n";
    echo "Response: $result\n";
}

// Test with 'base'
requestMoralis("/transaction/$tx_hash", ['chain' => 'base'], $baseUrl, $apiKey);

// Test with hex '0x2105' (Base Mainnet)
requestMoralis("/transaction/$tx_hash", ['chain' => '0x2105'], $baseUrl, $apiKey);

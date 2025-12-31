<?php

$payload = [
    'network'    => 2,
    'phone'      => '09127406311',          // phone should be a string
    'plan_type'  => 'VTU',
    'bypass'     => false,
    'amount'     => 100,
    'request-id' => 'Airtime_12345678900'   // must be a string
];

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL            => 'https://bilalsadasub.com/api/topup',
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'Authorization: Token ad6208f57445d0a6ad38967f7dd2fe1dbb3e03921deecf8ad6cea5960007',
        'Content-Type: application/json'
    ]
]);

$response = curl_exec($ch);

if ($response === false) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    echo $response; // API response
}

curl_close($ch);

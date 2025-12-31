<?php

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL            => 'https://bilalsadasub.com/api/user',
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'Authorization: Basic ZGFuYWxtYWc6KkJpbGFsc2FkYXN1YjIwMjQj',
        'Content-Type: application/json'
    ],
]);

$response = curl_exec($ch);

if ($response === false) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    echo $response; // API response
}

curl_close($ch);

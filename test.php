<?php

function getAssetTransfers($txHash, $apiKey, $chainId = 56) {
    // Choose endpoint based on Chain ID (56 = BSC, 8453 = Base)
    $baseUrl = ($chainId == 8453) 
        ? "https://base-mainnet.nodereal.io/v1/" 
        : "https://bsc-mainnet.nodereal.io/v1/";
    
    $url = $baseUrl . $apiKey;

    // The payload for NodeReal Enhanced API
    $payload = json_encode([
        "jsonrpc" => "2.0",
        "id" => 1,
        "method" => "nr_getAssetTransfers",
        "params" => [[
            "transactionHash" => $txHash,
            "category" => ["external", "20", "721", "1155"] // BNB, ERC20, NFT
        ]]
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        return 'Error: ' . curl_error($ch);
    }

    curl_close($ch);
    return json_decode($response, true);
}

// --- Usage Example ---
$myApiKey = "43d2c7a688e24b339c1b12886210b758";
$txHash = "0x4ed9b8ef3780f1e2cc433e9336bf4bdb803760e03576aa73b70918d82cc2a642"; // Replace with a real transaction hash

$data = getAssetTransfers($txHash, $myApiKey, 56); // 56 for BSC

if (isset($data['result']['transfers'])) {
        // echo "No transfers found or error in request.";
    print_r(json_encode($data['result']['transfers'], JSON_PRETTY_PRINT));
    // foreach ($data['result']['transfers'] as $transfer) {
    //     echo "Asset: " . ($transfer['asset'] ?? 'Unknown') . "\n";
    //     echo "From: " . $transfer['from'] . "\n";
    //     echo "To: " . $transfer['to'] . "\n";
    //     echo "Value: " . $transfer['value'] . "\n";
    //     echo "--------------------------\n";
    // }
} else {
    echo "No transfers found or error in request.";
}
?>
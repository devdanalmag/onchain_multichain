<?php
require_once __DIR__ . '/api/autoloader.php';

$controller = new ApiAccess();

echo "Testing getBlockchainConfig('AssetChain')...\n";
$config = $controller->getBlockchainConfig('AssetChain');
if ($config && $config['name'] === 'AssetChain') {
    echo "PASS: Config retrieved. RPC URL: " . $config['rpc_url'] . "\n";
} else {
    echo "FAIL: Config not found or invalid.\n";
    print_r($config);
}

echo "\nTesting getTokenInfo('CNGN')...\n";
$token = $controller->getTokenInfo('CNGN');
if ($token && $token['token_name'] === 'CNGN') {
    echo "PASS: Token retrieved. Contract: " . $token['token_contract'] . "\n";
} else {
    echo "FAIL: Token not found.\n";
    print_r($token);
}

echo "\nTesting checkERC20Balance...\n";
// Use the site address from config as target
$address = $config['site_address'];
$contract = $token['token_contract'];
if ($address && $contract) {
    // Address might be 0x00... so balance might be 0, but call should succeed
    $balance = $controller->checkERC20Balance($address, $contract);
    if ($balance['status'] === 'success') {
        echo "PASS: Balance retrieved. Hex: " . $balance['balance_hex'] . "\n";
    } else {
        echo "FAIL: Balance check failed. Msg: " . $balance['msg'] . "\n";
    }
} else {
    echo "SKIP: Address or contract missing.\n";
}

<?php
// Quick local test of Assetchain airtime verification path
// Reads DEX token, sends a POST with sample tx_hash and amount_wei

$base = 'http://localhost:8001/api/airtime/';
$dexTokenPath = __DIR__ . '/dex/dex_token.json';
$token = null;
if (file_exists($dexTokenPath)) {
  $j = json_decode(file_get_contents($dexTokenPath), true);
  $token = $j['token'] ?? null;
}

$payload = [
  'network' => 'MTN',
  'phone' => '08030000000',
  'amount' => 100,
  'airtime_type' => 'VTU',
  'ref' => time(),
  'target_address' => '0x7B23491809D4d6F169920b572B11B15a10fDa13E',
  'user_address' => '0xE64A6368928a37f6580C47971f7A06f27e6Fd45e',
  'tx_hash' => '0x1ded15c377598bf7617de772391a25ccbbc6c26837d440539a4749fe8d52c018',
  // sample is coin transfer, so verification should fail due to no token_transfers
  'amount_wei' => '30000000000000000',
  'token_contract' => '0x7923C0f6FA3d1BA6EAFCAedAaD93e737Fd22FC4F',
];

$ch = curl_init($base);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array_filter([
  'Content-Type: application/json',
  $token ? ('Authorization: Token ' . $token) : null
]));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
$out = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

header('Content-Type: application/json');
echo json_encode(['http_code' => $code, 'response' => json_decode($out, true)], JSON_PRETTY_PRINT);
?>
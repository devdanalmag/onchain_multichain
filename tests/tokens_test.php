<?php
require_once(__DIR__ . '/../api/autoloader.php');

function assertTrue($cond, $msg){ echo ($cond?"PASS":"FAIL").": ".$msg."\n"; }

$dbh = AdminModel::connect();
$q = $dbh->prepare("SELECT COUNT(*) AS cnt FROM tokens"); $q->execute(); $cnt = (int)($q->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0);
assertTrue($cnt >= 1, 'tokens table exists and has rows');

// API getTokens
$url = 'http://localhost/onchain_multichain/api/access.php?action=getTokens';
$resp = @file_get_contents($url); $data = @json_decode($resp, true);
assertTrue(isset($data['status']) && $data['status']==='success', 'getTokens API returns success');
assertTrue(is_array($data['tokens'] ?? []), 'getTokens returns tokens array');

// Address format validation
$bad = 'not_an_address';
assertTrue(!preg_match('/^0x[a-fA-F0-9]{40}$/', $bad), 'invalid address fails regex');

echo "Done\n";

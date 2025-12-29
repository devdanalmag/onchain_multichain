<?php
// Auto Load Classes
require_once(__DIR__ . "/autoloader.php");
require_once(__DIR__ . "/security_helper.php");

// Apply Security Measures
ApiSecurity::disableErrorDisplay();
ApiSecurity::applySecurityHeaders();
// ApiSecurity::rateLimit(100, 60); // Higher limit for general access

// CORS and JSON headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Allow: GET, OPTIONS');
header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    echo json_encode(['status' => 'ok']);
    exit();
}

$action = isset($_GET['action']) ? trim($_GET['action']) : '';
$out = [ 'status' => 'fail', 'msg' => 'Invalid action' ];

try {
    // Instantiate controllers
    $admin = new AdminModel();
    $api = new ApiAccess();

    switch ($action) {
        case 'getNetworks':
            // Return minimal fields used by DEX
            $nets = $admin->getNetworks();
            $data = [];
            foreach ($nets as $n) {
                $data[] = [
                    'id' => $n->nId ?? null,
                    'network' => $n->network ?? null,
                    'name' => $n->network ?? null,
                    'code' => $n->nId ?? null,
                    'status' => $n->networkStatus ?? null
                ];
            }
            $out = [ 'status' => 'success', 'networks' => $data, 'data' => $data ];
            break;

        case 'getDataPlans':
            // Optional network filter; accept network id or name
            $plans = $admin->getDataPlans();
            $net = isset($_GET['network']) ? $_GET['network'] : null;
            // Build id->name map
            $networks = $admin->getNetworks();
            $idToName = [];
            foreach ($networks as $n) { $idToName[(string)($n->nId ?? '')] = $n->network ?? ''; }
            $netName = $net;
            if ($net && isset($idToName[(string)$net])) { $netName = $idToName[(string)$net]; }

            $data = [];
            foreach ($plans as $p) {
                // dataplans fields: pId, datanetwork, name, planid, type, day, price, userprice, agentprice, vendorprice
                if ($net && (string)($p->network ?? '') !== (string)$netName) { continue; }
                $data[] = [
                    'id' => $p->pId ?? null,
                    'plan_id' => $p->planid ?? null,
                    'name' => $p->name ?? null,
                    'network' => $p->datanetwork ?? null,
                    'type' => $p->type ?? null,
                    'day' => $p->day ?? null,
                    'userprice' => isset($p->userprice) ? (float)$p->userprice : null,
                ];
            }
            $out = [ 'status' => 'success', 'plans' => $data, 'data' => $data ];
            break;

        case 'getSiteSettings':
            $site = $admin->getSiteSettings();
            $cfgFile = __DIR__ . '/../config/assetchain.json';
            $cfg = null;
            if (file_exists($cfgFile)) {
                $cfg = json_decode(file_get_contents($cfgFile), true);
            }
            $out = [
                'status' => 'success',
                'walletaddress' => $site->walletaddress ?? null,
                'evm_address' => $site->walletaddress ?? null,
                'siteaddress' => $site->walletaddress ?? null,
                'sitename' => $site->sitename ?? null,
                'chain_id' => $cfg['chain_id'] ?? 42420,
                'rpc_url' => $cfg['rpc_url'] ?? 'https://mainnet-rpc.assetchain.org/',
            ];
            break;

        case 'checkNativePrice':
            // Convert NGN amount to Native (AssetChain/EVM) Wei using server price
            $amount = isset($_GET['amount']) ? (float)$_GET['amount'] : 0;
            $chain = isset($_GET['chain']) ? strtolower(trim($_GET['chain'])) : 'assetchain';
            
            // Map chain to CoinGecko ID
            $coinId = 'ethereum'; // default
            if ($chain === 'bnb' || $chain === 'bsc') { $coinId = 'binancecoin'; }
            elseif ($chain === 'base') { $coinId = 'ethereum'; }
            elseif ($chain === 'assetchain') { $coinId = 'ethereum'; } // AssetChain uses ETH or its own ID if listed

            $priceNgn = $api->getSiteSettings()->tonamount ?? null; // fallback if exists
            $apiModel = new ApiModel();
            
            // Pass mapped coinId
            $ngnPerNative = $apiModel->checkNativePrice($coinId);
            
            // Fallback logic if API returns 0 or fails but we have a DB price
            if ((!is_numeric($ngnPerNative) || $ngnPerNative <= 0) && $priceNgn > 0) {
                $ngnPerNative = (float)$priceNgn;
            }

            if (!is_numeric($ngnPerNative) || $ngnPerNative <= 0) {
                $out = [ 'status' => 'fail', 'msg' => 'Price unavailable' ];
                break;
            }
            $nativeAmount = $amount / $ngnPerNative; // Native amount (e.g. ETH/ASSET)
            // Convert to Wei (18 decimals)
            // Use number_format to avoid scientific notation for large numbers
            $wei = number_format($nativeAmount * 1e18, 0, '', '');
            
            $out = [ 
                'status' => 'success', 
                'amount' => $amount, 
                'ngn_per_native' => $ngnPerNative, 
                'native_amount' => $nativeAmount, 
                'weiamount' => (string)$wei, 
                'amount_in_wei' => (string)$wei 
            ];
            break;

        case 'checkDataPlanPrice':
            $network = isset($_GET['network']) ? $_GET['network'] : '';
            $plan = isset($_GET['plan']) ? $_GET['plan'] : '';
            // Assume public pricing (userprice). For agents/vendors, a tokenized endpoint would be needed.
            $plans = $admin->getDataPlans();
            // Resolve network id->name
            $networks = $admin->getNetworks();
            $idToName = [];
            foreach ($networks as $n) { $idToName[(string)($n->nId ?? '')] = $n->network ?? ''; }
            $netName = $network;
            if ($network && isset($idToName[(string)$network])) { $netName = $idToName[(string)$network]; }
            $selected = null;
            foreach ($plans as $p) {
                if ((string)($p->network ?? '') === (string)$netName && ((string)($p->pId ?? '') === (string)$plan || (string)($p->planid ?? '') === (string)$plan)) {
                    $selected = $p; break;
                }
            }
            if (!$selected) {
                $out = [ 'status' => 'fail', 'msg' => 'Plan not found' ];
                break;
            }
            $amount = isset($selected->userprice) ? (float)$selected->userprice : (float)$selected->price;
            $apiModel = new ApiModel();
            $ngnPerNative = $apiModel->checkNativePrice();
            
            // Fallback logic
            $priceNgn = $api->getSiteSettings()->tonamount ?? null;
            if ((!is_numeric($ngnPerNative) || $ngnPerNative <= 0) && $priceNgn > 0) {
                $ngnPerNative = (float)$priceNgn;
            }

            if (!is_numeric($ngnPerNative) || $ngnPerNative <= 0) {
                $out = [ 'status' => 'fail', 'msg' => 'Price unavailable' ];
                break;
            }
            $nativeAmount = $amount / $ngnPerNative;
            $wei = number_format($nativeAmount * 1e18, 0, '', '');
            
            $out = [ 
                'status' => 'success', 
                'amount' => $amount, 
                'ngn_per_native' => $ngnPerNative, 
                'native_amount' => $nativeAmount, 
                'weiamount' => (string)$wei, 
                'amount_in_wei' => (string)$wei 
            ];
            break;

        case 'getDexToken':
            // Return the DEX-specific authorization token
            $tokenFile = __DIR__ . '/../dex/dex_token.json';
            if (!file_exists($tokenFile)) {
                $out = [ 'status' => 'fail', 'msg' => 'DEX token not found' ];
                break;
            }
            $tokenData = json_decode(file_get_contents($tokenFile), true);
            if (!$tokenData || !isset($tokenData['token'])) {
                $out = [ 'status' => 'fail', 'msg' => 'Invalid DEX token file' ];
                break;
            }
            $out = [ 
                'status' => 'success', 
                'token' => $tokenData['token'],
                'generated_at' => $tokenData['generated_at'] ?? null
            ];
            break;

        case 'getTokenPrice':
            $address = $_GET['address'] ?? '';
            $chain = $_GET['chain'] ?? 'assetchain';
            if ($chain === 'base' || $chain === 'bnb' || $chain === 'bsc' || $chain === 'arbitrum') {
                 $moralis = new MoralisModel();
                 $priceData = $moralis->getTokenPrice($address, $chain);
                 if ($priceData && !isset($priceData['status'])) {
                     $out = ['status' => 'success', 'price' => $priceData['usdPrice'] ?? 0, 'data' => $priceData];
                 } else {
                     $out = ['status' => 'fail', 'msg' => 'Price unavailable'];
                 }
            } else {
                $out = ['status' => 'fail', 'msg' => 'Not implemented for this chain'];
            }
            break;

        case 'getTokens':
            $chain = isset($_GET['chain']) ? strtolower(trim($_GET['chain'])) : 'assetchain';
            $dbh = AdminModel::connect();
            
            // Join tokens with blockchain to get tokens for specific chain
            $sql = "SELECT t.token_name, t.token_contract, t.token_decimals 
                    FROM tokens t
                    JOIN blockchain b ON t.chain_id = b.id
                    WHERE b.chain_key = :chain AND t.is_active = 1 AND b.is_active = 1
                    ORDER BY t.token_name ASC";
            $q = $dbh->prepare($sql);
            $q->execute([':chain' => $chain]);
            $rows = $q->fetchAll(PDO::FETCH_ASSOC);
            
            $out = [ 'status' => 'success', 'tokens' => $rows, 'data' => $rows ];
            break;

        case 'getBlockchains':
            $dbh = AdminModel::connect();
            $sql = "SELECT id, chain_key, name, rpc_url, chain_id, chain_id_hex, explorer_url, native_symbol, site_address 
                    FROM blockchain 
                    WHERE is_active = 1 
                    ORDER BY id ASC";
            $rows = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            $out = [ 'status' => 'success', 'chains' => $rows, 'data' => $rows ];
            break;
        
        case 'getP2PCoins':
            // Merge p2pcoins with token metadata if contracts exist
            $dbh = AdminModel::connect();
            $coins = $dbh->query("SELECT cId, Symbol, status FROM p2pcoins ORDER BY cId ASC")->fetchAll(PDO::FETCH_ASSOC);
            $tokens = $dbh->query("SELECT LOWER(token_name) AS token_name, token_contract, token_decimals FROM tokens WHERE is_active=1")->fetchAll(PDO::FETCH_ASSOC);
            $tmap = [];
            foreach ($tokens as $t) {
                $tmap[strtolower($t['token_name'])] = [
                    'token_contract' => $t['token_contract'],
                    'token_decimals' => $t['token_decimals']
                ];
            }
            $result = [];
            foreach ($coins as $c) {
                $nameKey = strtolower($c['Symbol'] ?? '');
                $meta = isset($tmap[$nameKey]) ? $tmap[$nameKey] : ['token_contract' => null, 'token_decimals' => null];
                $result[] = [
                    'id' => $c['cId'],
                    'symbol' => $c['Symbol'],
                    'status' => $c['status'],
                    'token_contract' => $meta['token_contract'],
                    'token_decimals' => $meta['token_decimals']
                ];
            }
            $out = [ 'status' => 'success', 'coins' => $result, 'data' => $result ];
            break;

        case 'getWalletTransactions':
            $address = isset($_GET['address']) ? trim($_GET['address']) : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $chain = isset($_GET['chain']) ? strtolower(trim($_GET['chain'])) : 'assetchain';

            // Basic address validation (EVM or TON/Base64)
            // Allow 0x hex (42 chars) or longer strings (TON addresses ~48 chars)
            $isValid = (strlen($address) >= 40 && strlen($address) <= 100);
            if (!$isValid) {
                http_response_code(400);
                $out = [ 'status' => 'fail', 'msg' => 'Invalid address' ];
                break;
            }

            if ($chain === 'base' || $chain === 'bnb' || $chain === 'bsc' || $chain === 'arbitrum') {
                $moralis = new MoralisModel();
                $out = $moralis->getWalletTransactions($address, $chain, $page, $limit);
                break;
            }

            $page = max(0, $page); $limit = max(1, min(50, $limit));
            $result = $admin->getTransactionsByAddress($address, $page, $limit);
            $pages = $result['perPage'] > 0 ? (int)ceil($result['total'] / $result['perPage']) : 0;
            $out = [
                'status' => 'success',
                'total' => $result['total'],
                'page' => $result['page'],
                'perPage' => $result['perPage'],
                'pages' => $pages,
                'items' => array_map(function($r){
                    return [
                        'txhash' => $r->txhash ?? null,
                        'txref' => $r->transref ?? null,
                        'date' => $r->date ?? null,
                        'servicename' => $r->servicename ?? null,
                        'servicedesc' => $r->servicedesc ?? null,
                        'amount' => $r->amount ?? null,
                        'status' => isset($r->status) ? (int)$r->status : null,
                        'senderaddress' => $r->senderaddress ?? null,
                        'targetaddress' => $r->targetaddress ?? null,
                        'transaction_type' => $r->transaction_type ?? null,
                        'token_name' => $r->token_name ?? null,
                        'token_contract' => $r->token_contract ?? null,
                        'token_amount' => $r->token_amount ?? null,
                    ];
                }, $result['items'] ?? [])
            ];
            break;

        default:
            http_response_code(400);
            $out = [ 'status' => 'fail', 'msg' => 'Unknown action' ];
    }
} catch (Throwable $e) {
    http_response_code(500);
    $out = [ 'status' => 'fail', 'msg' => 'Server error', 'error' => $e->getMessage() ];
}

echo json_encode($out);
exit();
?>

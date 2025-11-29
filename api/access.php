<?php
// Auto Load Classes
require_once(__DIR__ . "/autoloader.php");

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
                if ($net && (string)($p->datanetwork ?? '') !== (string)$netName) { continue; }
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
            $out = [
                'status' => 'success',
                'walletaddress' => $site->walletaddress ?? null,
                'tonaddress' => $site->walletaddress ?? null,
                'siteaddress' => $site->walletaddress ?? null,
                'sitename' => $site->sitename ?? null,
            ];
            break;

        case 'checkTonPrice':
            // Convert NGN amount to TON nano using server price
            $amount = isset($_GET['amount']) ? (float)$_GET['amount'] : 0;
            $priceNgn = $api->getSiteSettings()->tonamount ?? null; // fallback if exists
            $apiModel = new ApiModel();
            $ngnPerTon = $apiModel->checkTonPrice();
            if (!is_numeric($ngnPerTon) || $ngnPerTon <= 0) {
                $out = [ 'status' => 'fail', 'msg' => 'Price unavailable' ];
                break;
            }
            $tonAmount = $amount / $ngnPerTon; // TON amount
            $nano = (int) round($tonAmount * 1e9);
            $out = [ 'status' => 'success', 'amount' => $amount, 'ngn_per_ton' => $ngnPerTon, 'ton_amount' => $tonAmount, 'nanoamount' => (string)$nano, 'amount_in_nano' => (string)$nano ];
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
                if ((string)($p->datanetwork ?? '') === (string)$netName && ((string)($p->pId ?? '') === (string)$plan || (string)($p->planid ?? '') === (string)$plan)) {
                    $selected = $p; break;
                }
            }
            if (!$selected) {
                $out = [ 'status' => 'fail', 'msg' => 'Plan not found' ];
                break;
            }
            $amount = isset($selected->userprice) ? (float)$selected->userprice : (float)$selected->price;
            $apiModel = new ApiModel();
            $ngnPerTon = $apiModel->checkTonPrice();
            if (!is_numeric($ngnPerTon) || $ngnPerTon <= 0) {
                $out = [ 'status' => 'fail', 'msg' => 'Price unavailable' ];
                break;
            }
            $tonAmount = $amount / $ngnPerTon;
            $nano = (int) round($tonAmount * 1e9);
            $out = [ 'status' => 'success', 'amount' => $amount, 'ngn_per_ton' => $ngnPerTon, 'ton_amount' => $tonAmount, 'nanoamount' => (string)$nano, 'amount_in_nano' => (string)$nano ];
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
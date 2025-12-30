<?php
// Auto Load Classes
require_once("../autoloader.php");
require_once("../security_helper.php");

// Apply Security Measures
ApiSecurity::disableErrorDisplay();
ApiSecurity::applySecurityHeaders();
ApiSecurity::rateLimit(30, 60); // Limit to 30 requests per minute

// Allowed API Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

$headers = apache_request_headers();
$response = array();
$controller = new ApiAccess;
$airtimeController = new Airtime;
date_default_timezone_set('Africa/Lagos');

// -------------------------------------------------------------------
//  Helper Functions
// -------------------------------------------------------------------

/**
 * Validate DEX token
 */
function validateDexToken($token)
{
    $tokenFile = __DIR__ . '/../../dex/dex_token.json';
    if (!file_exists($tokenFile)) {
        return false;
    }
    $tokenData = json_decode(file_get_contents($tokenFile), true);
    return ($tokenData && isset($tokenData['token']) && $tokenData['token'] === $token);
}

/**
 * Handle transaction failure with refund (ALWAYS refund if blockchain verified)
 */
function handleTransactionFailure($controller, $params)
{
    extract($params); // Extract all params
    
    // Record failed transaction
    $controller->recordchainTransaction(
        $userid, 
        $servicename, 
        $servicedesc, 
        $ref, 
        $amount, 
        $ftarget_address, 
        $tx_hash, 
        $fuser_address, 
        $tokenamount, 
        "1", // Failed status
        $transaction_type, 
        $token_name, 
        $normTokenContract,
        $blockchain_id
    );
    
    // ALWAYS attempt refund if we got this far (blockchain verified)
    $refundResult = $controller->refundTransaction(
        $ref,  
        $fuser_address, 
        $tokenamount, 
        $token_contract, 
        $token_name, 
        $token_decimals
    );
    
    // Record successful refund
    if ($refundResult["status"] === "success") {
        $refundDesc = "Refund For {$ref} Transactions";
        $reference = crc32($ref);
        $refundwallet = $refundResult["sender"] ?? $siteaddress;
        $targetwallet = $refundResult["receiver"] ?? $fuser_address;
        $refund_hash = $refundResult["hash"] ?? "N/A";
        
        $controller->recordrefundchainTransaction(
            $userid, 
            "Refund", 
            $refundDesc, 
            $reference, 
            "0.00", 
            $targetwallet, 
            $refund_hash, 
            $refundwallet, 
            $tokenamount, 
            "9", // Refunded status
            $transaction_type, 
            $token_name, 
            $normTokenContract,
            $blockchain_id
        );
    }
    
    return $refundResult;
}

/**
 * Validate and sanitize input parameters
 */
function validateInput($controller, $body, &$response)
{
    $requiredFields = [
        'network' => 'Network Id Required',
        'phone' => 'Phone Is Required',
        'amount' => 'Amount Is Required',
        'ref' => 'Ref Is Required',
        'airtime_type' => 'Airtime Type Is Required',
        'target_address' => 'Target Address Is Required',
        'tx_hash' => 'Onchain Transaction Hash Is Required',
        'user_address' => 'User Address Required',
        'amount_wei' => 'Token amount_wei is required'
    ];
    
    foreach ($requiredFields as $field => $error) {
        if (!isset($body->$field) || empty($body->$field)) {
            $response['status'] = "fail";
            $response['msg'] = $error;
            return false;
        }
    }
    
    // Validate amount format
    if (!is_numeric($body->amount) || $body->amount <= 0) {
        $response['status'] = "fail";
        $response['msg'] = "Amount must be a positive number";
        return false;
    }
    
    // Validate airtime type
    if ($body->airtime_type !== "VTU" && $body->airtime_type !== "Share And Sell") {
        $response['status'] = "fail";
        $response['msg'] = "Airtime Type can only be VTU or Share And Sell";
        return false;
    }
    
    return true;
}

// -------------------------------------------------------------------
//  Check Request Method
// -------------------------------------------------------------------
ApiSecurity::enforceMethod('POST');

// -------------------------------------------------------------------
//  Check For Api Authorization
// -------------------------------------------------------------------
$isDexToken = false;
$userid = 0;
$userbalance = 0;
$usertype = "";
$refearedby = "";
$referal = "";
$referalname = "";

if ((isset($headers['Authorization']) || isset($headers['authorization'])) || 
    (isset($headers['Token']) || isset($headers['token']))) {
    
    $token = "";
    if ((isset($headers['Authorization']) || isset($headers['authorization']))) {
        $raw = (isset($headers['Authorization'])) ? $headers['Authorization'] : $headers['authorization'];
        $token = trim(str_replace("Token", "", $raw));
        $token = trim(str_replace("Bearer", "", $token));
    }
    if ((isset($headers['Token']) || isset($headers['token']))) {
        $raw = (isset($headers['Token'])) ? $headers['Token'] : $headers['token'];
        $token = trim(str_replace("Token", "", $raw));
        $token = trim(str_replace("Bearer", "", $token));
    }

    // Check if it's a DEX token first
    if (validateDexToken($token)) {
        $isDexToken = true;
        $usertype = "dex";
        $userbalance = 999999999;
        $userid = 0;
        $refearedby = "";
        $referal = "dex";
        $referalname = "DEX User";
    } else {
        // Regular token validation
        $result = $controller->validateAccessToken($token);
        if ($result["status"] == "fail") {
            header('HTTP/1.0 401 Unauthorized');
            $response["status"] = "fail";
            $response["msg"] = "Authorization token not found";
            echo json_encode($response);
            exit();
        } else {
            $usertype = $result["usertype"];
            $userbalance = (float) $result["balance"];
            $userid = $result["userid"];
            $refearedby = $result["refearedby"];
            $referal = $result["username"];
            $referalname = $result["name"];
        }
    }
} else {
    header('HTTP/1.0 401 Unauthorized');
    $response["status"] = "fail";
    $response["msg"] = "Your authorization token is required.";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Get The Request Details
// -------------------------------------------------------------------
$input = @file_get_contents("php://input");
$body = json_decode($input);

// Support Other API Format
$body2 = array();
if (isset($body->Ported_number)) {
    $body2["ported_number"] = $body->Ported_number;
}
if (!isset($body->ported_number)) {
    $body2["ported_number"] = "false";
}
if (isset($body->mobile_number)) {
    $body2["phone"] = $body->mobile_number;
}
if (!isset($body->ref)) {
    $body2["ref"] = time();
}
if (!isset($body->airtime_type)) {
    $body2["airtime_type"] = "VTU";
}
$body = (object) array_merge((array)$body, $body2);

// Extract and sanitize inputs
$network = isset($body->network) ? trim($body->network) : "";
$phone = isset($body->phone) ? trim($body->phone) : "";
$amount = isset($body->amount) ? $body->amount : "";
$ported_number = isset($body->ported_number) ? $body->ported_number : "false";
$airtime_type = isset($body->airtime_type) ? trim($body->airtime_type) : "";
$ref = isset($body->ref) ? trim($body->ref) : "";
$target_address = isset($body->target_address) ? trim($body->target_address) : "";
$tx_hash = isset($body->tx_hash) ? trim($body->tx_hash) : "";
$user_address = isset($body->user_address) ? trim($body->user_address) : "";
$amount_wei = isset($body->amount_wei) ? trim($body->amount_wei) : "";
$token_contract = isset($body->token_contract) ? trim($body->token_contract) : "";
$blockchain_id = isset($body->blockchain_id) ? (int)$body->blockchain_id : 1;

// -------------------------------------------------------------------
//  Validate Input Parameters
// -------------------------------------------------------------------
if (!validateInput($controller, $body, $response)) {
    header('HTTP/1.0 400 Bad Request');
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Check For Duplicate Transaction Reference
// -------------------------------------------------------------------
$result = $controller->checkIfTransactionExist($ref);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Transaction Ref Already Exist";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Verify Assetchain Transaction (CNGN ERC-20)
// -------------------------------------------------------------------
// IMPORTANT: BOTH DEX and APP transactions need blockchain verification
// If verification fails, we just return error without refund
$chainresult = $controller->verifyBlockchainTransaction($target_address, $tx_hash, $user_address, $amount_wei, $token_contract, $blockchain_id);
if ($chainresult["status"] == "fail") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $erroresult = $controller->checkIfError();
    
    if ($erroresult) {
        $response['msg'] = $chainresult['msg'] ?? 'verification_failed';
        if (isset($chainresult['expected_value']) || isset($chainresult['transfer_value'])) {
            $response['msg'] .= " | expected: " . ($chainresult['expected_value'] ?? 'N/A') . ", got: " . ($chainresult['transfer_value'] ?? 'N/A');
        }
    } else {
        $response['msg'] = "Transaction Verification Failed, Please Check The Transaction Details And Try Again or Contact Support";
    }
    
    // DO NOT attempt refund - blockchain verification failed
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Token Validation
// -------------------------------------------------------------------
$dbh = AdminModel::connect();
$isNative = empty($token_contract) || strtolower($token_contract) === 'native' || $token_contract === '0x0000000000000000000000000000000000000000';

if ($isNative) {
    // Get native symbol from blockchain table
    $bcQ = $dbh->prepare("SELECT native_symbol FROM blockchain WHERE id = :id LIMIT 1");
    $bcQ->execute([':id' => $blockchain_id]);
    $bcRow = $bcQ->fetch(PDO::FETCH_ASSOC);
    
    $token_decimals = 18;
    $token_name = $bcRow['native_symbol'] ?? 'Native';
    $token_contract = 'native';
} else {
    $decQ = $dbh->prepare("SELECT token_decimals, token_name, token_contract FROM tokens WHERE LOWER(token_contract)=LOWER(:c) AND chain_id=:chain AND is_active=1 LIMIT 1");
    $decQ->bindParam(':c', $token_contract, PDO::PARAM_STR);
    $decQ->bindParam(':chain', $blockchain_id, PDO::PARAM_INT);
    $decQ->execute();
    $trow = $decQ->fetch(PDO::FETCH_ASSOC);

    if (!$trow) {
        header('HTTP/1.0 400 Bad Request');
        $response['status'] = "fail";
        $response['msg'] = "Token Not Found or Disabled on this Chain ($blockchain_id)";
        echo json_encode($response);
        exit();
    }

    $token_decimals = (int)($trow['token_decimals'] ?? 18);
    $token_name = $trow['token_name'] ?? 'Unknown';
}

$tokenamount = number_format($controller->convertWeiToToken($amount_wei, $token_decimals), 8, '.', '');
// -------------------------------------------------------------------
//  Address Normalization and Validation
// -------------------------------------------------------------------
$ftarget_address = $controller->normalizeEvmAddress($target_address);
$fuser_address = $controller->normalizeEvmAddress($user_address);

// Get blockchain configuration
$blockchainConfig = $controller->getBlockchainConfig($blockchain_id);
$siteaddress = $blockchainConfig['site_address'] ?? '';
$refundingAddress = $blockchainConfig['refunding_address'] ?? $siteaddress;

if (empty($siteaddress)) {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Site Address Is Empty, Please Contact Support";
    echo json_encode($response);
    exit();
}

$fsite_address = $controller->normalizeEvmAddress($siteaddress);

// Address validation checks
if ($ftarget_address == $fuser_address) {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Target Address Cannot Be Your Address";
    
    // Since blockchain is verified, we refund
    $transaction_type = $isDexToken ? 'dex' : 'app';
    $normTokenContract = $controller->normalizeEvmAddress($token_contract);
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Target = User Address)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
}

if ($fuser_address == $fsite_address) {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "User Address Cannot Be Site Address";
    
    // Since blockchain is verified, we refund
    $transaction_type = $isDexToken ? 'dex' : 'app';
    $normTokenContract = $controller->normalizeEvmAddress($token_contract);
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (User = Site Address)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
}

// Refunding Address Balance Check - ALWAYS check since we always refund
if (!empty($refundingAddress) && !empty($token_contract) && !empty($amount_wei)) {
    $balanceCheck = $controller->checkERC20Balance($refundingAddress, $token_contract, $blockchain_id);
    if ($balanceCheck['status'] === 'success') {
        $hexBal = $balanceCheck['balance_hex'];
        $decBal = hexdec($hexBal); 
        if ($decBal < (float)$amount_wei) {
            header('HTTP/1.0 400 Bad Request');
            $response['status'] = "fail";
            $response['msg'] = "Low Balance: Refunding address has insufficient funds";
            
            // Record but cannot refund
            $transaction_type = $isDexToken ? 'dex' : 'app';
            $normTokenContract = $controller->normalizeEvmAddress($token_contract);
            
            $controller->recordchainTransaction(
                $userid, 
                "Airtime",
                "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Insufficient Refund Balance)",
                $ref, 
                $amount, 
                $ftarget_address, 
                $tx_hash, 
                $fuser_address, 
                $tokenamount, 
                "1", 
                $transaction_type, 
                $token_name, 
                $normTokenContract,
                $blockchain_id
            );
            
            echo json_encode($response);
            exit();
        }
    } else {
        error_log("RPC Balance Check Failed: " . ($balanceCheck['msg'] ?? 'Unknown Error'));
        header('HTTP/1.0 500 Internal Server Error');
        $response['status'] = "fail";
        $response['msg'] = "Blockchain RPC Error: Unable to verify system balance.";
        echo json_encode($response);
        exit();
    }
}

// -------------------------------------------------------------------
//  Verify Network Id
// -------------------------------------------------------------------
$result = $controller->verifyNetworkId($network);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "The Network id is invalid";
    
    // Blockchain verified, so we refund
    $transaction_type = $isDexToken ? 'dex' : 'app';
    $normTokenContract = $controller->normalizeEvmAddress($token_contract);
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Invalid Network ID)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
} else {
    $networkDetails = $result;
}

// -------------------------------------------------------------------
//  Check If Network Is Available
// -------------------------------------------------------------------
$networkAvailable = true;
$errorMsg = "";

if ($airtime_type == "Share And Sell") {
    if ($networkDetails["networkStatus"] != "On" || $networkDetails["sharesellStatus"] != "On") {
        $networkAvailable = false;
        $errorMsg = "Sorry, {$networkDetails["network"]} is not available at the moment";
        if ($networkDetails["sharesellStatus"] == "Off") {
            $errorMsg = "Sorry, {$networkDetails["network"]} Share And Sell service is not available at the moment";
        }
    }
} elseif ($airtime_type == "VTU") {
    if ($networkDetails["networkStatus"] != "On" || $networkDetails["vtuStatus"] != "On") {
        $networkAvailable = false;
        $errorMsg = "Sorry, {$networkDetails["network"]} is not available at the moment";
        if ($networkDetails["vtuStatus"] == "Off") {
            $errorMsg = "Sorry, {$networkDetails["network"]} VTU service is not available at the moment";
        }
    }
}

if (!$networkAvailable) {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = $errorMsg;
    
    // Blockchain verified, so we refund
    $transaction_type = $isDexToken ? 'dex' : 'app';
    $normTokenContract = $controller->normalizeEvmAddress($token_contract);
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "Failed {$networkDetails['network']} Airtime purchase of N{$amount} for {$phone} (Network Unavailable)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Verify Phone Number
// -------------------------------------------------------------------
if ($ported_number == "false") {
    $result = $controller->verifyPhoneNumber($phone, $networkDetails["network"]);
    if ($result["status"] == "fail") {
        header('HTTP/1.0 400 Bad Request');
        $response['status'] = "fail";
        $response['msg'] = $result["msg"];
        
        // Blockchain verified, so we refund
        $transaction_type = $isDexToken ? 'dex' : 'app';
        $normTokenContract = $controller->normalizeEvmAddress($token_contract);
        
        $failureParams = [
            'userid' => $userid,
            'servicename' => "Airtime",
            'servicedesc' => "Failed {$networkDetails['network']} Airtime purchase of N{$amount} for {$phone} (Invalid Phone)",
            'amount' => $amount,
            'ref' => $ref,
            'ftarget_address' => $ftarget_address,
            'tx_hash' => $tx_hash,
            'fuser_address' => $fuser_address,
            'tokenamount' => $tokenamount,
            'transaction_type' => $transaction_type,
            'token_name' => $token_name,
            'normTokenContract' => $normTokenContract,
            'siteaddress' => $siteaddress,
            'isDexToken' => $isDexToken,
            'token_contract' => $token_contract,
            'token_decimals' => $token_decimals,
            'controller' => $controller
        ];
        
        handleTransactionFailure($controller, $failureParams);
        echo json_encode($response);
        exit();
    }
}

// -------------------------------------------------------------------
//  Check For Minimum And Maximum Amount
// -------------------------------------------------------------------
$airtimelimit = $controller->getSiteSettings();
$airtimemin = (int) $airtimelimit->airtimemin;
$airtimemax = (int) $airtimelimit->airtimemax;

if ($amount < $airtimemin) {
    header("HTTP/1.0 400 Bad Request");
    $response['status'] = "fail";
    $response['msg'] = "Minimum airtime you can purchase is $airtimemin";
    
    // Blockchain verified, so we refund
    $transaction_type = $isDexToken ? 'dex' : 'app';
    $normTokenContract = $controller->normalizeEvmAddress($token_contract);
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Below Min Amount)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
}

if ($amount > $airtimemax) {
    header("HTTP/1.0 400 Bad Request");
    $response['status'] = "fail";
    $response['msg'] = "Maximum airtime you can purchase is $airtimemax";
    
    // Blockchain verified, so we refund
    $transaction_type = $isDexToken ? 'dex' : 'app';
    $normTokenContract = $controller->normalizeEvmAddress($token_contract);
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Above Max Amount)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Calculate Airtime Discount
// -------------------------------------------------------------------
if ($isDexToken) {
    $amountopay = (float) $amount;
    $buyamount = (float) $amount;
    $profit = "0";
} else {
    $result = $controller->calculateAirtimeDiscount($network, $airtime_type, $amount, $usertype);
    $amountopay = (float) $result["discount"];
    $buyamount = (float) $result["buyamount"];
    $profit = $amountopay - $buyamount;
}

// -------------------------------------------------------------------
//  Check For Duplicate Transaction Description
// -------------------------------------------------------------------
$servicename = "Airtime";
$servicedesc = "{$networkDetails["network"]} Airtime purchase of N{$amount} @ {$tokenamount} {$token_name} for phone number {$phone}";

$result = $controller->checkTransactionDuplicate($servicename, $servicedesc);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Possible Transaction Duplicate, Please Verify Transaction & Try Again After 60 Seconds";
    
    // Blockchain verified, so we refund
    $transaction_type = $isDexToken ? 'dex' : 'app';
    $normTokenContract = $controller->normalizeEvmAddress($token_contract);
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "{$servicedesc} (Duplicate)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Validate User Address (for non-DEX tokens only)
// -------------------------------------------------------------------
if (!$isDexToken) {
    $adressresult = $controller->getUserDetails($token);
    if ($adressresult["tonwalletstatus"] == "0" || $adressresult["tonwalletstatus"] == 0) {
        header('HTTP/1.0 400 Bad Request');
        $response['status'] = "fail";
        $response['msg'] = "User Address Not Set, Please Set Your Address In Your Profile";
        
        // Blockchain verified, so we refund
        $transaction_type = $isDexToken ? 'dex' : 'app';
        $normTokenContract = $controller->normalizeEvmAddress($token_contract);
        
        $failureParams = [
            'userid' => $userid,
            'servicename' => "Airtime",
            'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Address Not Set)",
            'amount' => $amount,
            'ref' => $ref,
            'ftarget_address' => $ftarget_address,
            'tx_hash' => $tx_hash,
            'fuser_address' => $fuser_address,
            'tokenamount' => $tokenamount,
            'transaction_type' => $transaction_type,
            'token_name' => $token_name,
            'normTokenContract' => $normTokenContract,
            'siteaddress' => $siteaddress,
            'isDexToken' => $isDexToken,
            'token_contract' => $token_contract,
            'token_decimals' => $token_decimals,
            'controller' => $controller
        ];
        
        handleTransactionFailure($controller, $failureParams);
        echo json_encode($response);
        exit();
    }
    
    if (empty($adressresult["tonaddress"])) {
        header('HTTP/1.0 400 Bad Request');
        $response['status'] = "fail";
        $response['msg'] = "User Address Is Empty, Please Set Your Address In Your Profile";
        
        // Blockchain verified, so we refund
        $transaction_type = $isDexToken ? 'dex' : 'app';
        $normTokenContract = $controller->normalizeEvmAddress($token_contract);
        
        $failureParams = [
            'userid' => $userid,
            'servicename' => "Airtime",
            'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Empty Address)",
            'amount' => $amount,
            'ref' => $ref,
            'ftarget_address' => $ftarget_address,
            'tx_hash' => $tx_hash,
            'fuser_address' => $fuser_address,
            'tokenamount' => $tokenamount,
            'transaction_type' => $transaction_type,
            'token_name' => $token_name,
            'normTokenContract' => $normTokenContract,
            'siteaddress' => $siteaddress,
            'isDexToken' => $isDexToken,
            'token_contract' => $token_contract,
            'token_decimals' => $token_decimals,
            'controller' => $controller
        ];
        
        handleTransactionFailure($controller, $failureParams);
        echo json_encode($response);
        exit();
    }
    
    $user_saved_address = $adressresult["tonaddress"];
    $fsaved_address = $controller->normalizeEvmAddress($user_saved_address);
    
    if ($fsaved_address != $fuser_address) {
        header('HTTP/1.0 400 Bad Request');
        $response['status'] = "fail";
        $response['msg'] = "User Address Not Valid, use saved wallet or Please Contact Support";
        
        // Blockchain verified, so we refund
        $transaction_type = $isDexToken ? 'dex' : 'app';
        $normTokenContract = $controller->normalizeEvmAddress($token_contract);
        
        $failureParams = [
            'userid' => $userid,
            'servicename' => "Airtime",
            'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Address Mismatch)",
            'amount' => $amount,
            'ref' => $ref,
            'ftarget_address' => $ftarget_address,
            'tx_hash' => $tx_hash,
            'fuser_address' => $fuser_address,
            'tokenamount' => $tokenamount,
            'transaction_type' => $transaction_type,
            'token_name' => $token_name,
            'normTokenContract' => $normTokenContract,
            'siteaddress' => $siteaddress,
            'isDexToken' => $isDexToken,
            'token_contract' => $token_contract,
            'token_decimals' => $token_decimals,
            'controller' => $controller
        ];
        
        handleTransactionFailure($controller, $failureParams);
        echo json_encode($response);
        exit();
    }
}

// Validate target address for non-DEX
if (!$isDexToken && $ftarget_address != $fsite_address) {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Invalid Target Address, Please Contact Support";
    
    // Blockchain verified, so we refund
    $transaction_type = $isDexToken ? 'dex' : 'app';
    $normTokenContract = $controller->normalizeEvmAddress($token_contract);
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Invalid Target)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'blockchain_id' => $blockchain_id,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Record Initial Transaction as Processing
// -------------------------------------------------------------------
$transaction_type = $isDexToken ? 'dex' : 'app';
$normTokenContract = $controller->normalizeEvmAddress($token_contract);

$transRecord = $controller->recordchainTransaction(
    $userid, 
    $servicename, 
    $servicedesc, 
    $ref, 
    $amountopay, 
    $ftarget_address, 
    $tx_hash, 
    $fuser_address, 
    $tokenamount, 
    "5", // Processing status
    $transaction_type, 
    $token_name, 
    $normTokenContract,
    $blockchain_id
);

if ($transRecord["status"] == "fail") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Failed To Record Transaction, Please Try Again Later";
    $controller->logError($response['msg'], "Api :: Airtime Index", $userid);
    
    // Blockchain verified, so we refund even though recording failed
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Airtime",
        'servicedesc' => "Failed {$network} Airtime purchase of N{$amount} for {$phone} (Record Failed)",
        'amount' => $amount,
        'ref' => $ref,
        'ftarget_address' => $ftarget_address,
        'tx_hash' => $tx_hash,
        'fuser_address' => $fuser_address,
        'tokenamount' => $tokenamount,
        'transaction_type' => $transaction_type,
        'token_name' => $token_name,
        'normTokenContract' => $normTokenContract,
        'siteaddress' => $siteaddress,
        'isDexToken' => $isDexToken,
        'token_contract' => $token_contract,
        'token_decimals' => $token_decimals,
        'controller' => $controller
    ];
    
    handleTransactionFailure($controller, $failureParams);
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Check Price Impact
// -------------------------------------------------------------------
$checkprice = $controller->checkpriceimpactcngn($amountopay, $tokenamount);
if ($checkprice['status'] == 'fail') {
    header('HTTP/1.0 400 Bad Request');
    
    $updatedDesc = "{$networkDetails["network"]} Airtime purchase of N{$amount} @ {$tokenamount} {$token_name} for phone number {$phone} Failed Due To Price Impact";
    $controller->updateFailedTransactionStatus($userid, $updatedDesc, $ref, $amountopay, "1");
    
    $response['status'] = "fail";
    $erroresult = $controller->checkIfError();
    
    if ($erroresult) {
        $response['msg'] = $checkprice['msg'] ?? "Price Maybe Higher or Lower, Please Try Again Later";
    } else {
        $response['msg'] = "Price Maybe Higher or Lower, Please Try Again Later";
    }
    
    // ALWAYS attempt refund since blockchain is verified
    $refundResult = $controller->refundTransaction($ref, $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
    if ($refundResult["status"] == "fail") {
        $controller->logError($refundResult['msg'] ?? "Unknown", "Api :: Airtime Index", $userid);
        if ($erroresult) {
            $response['msg'] .= " Refunding Failed: " . $refundResult['msg'];
        }
    } else {
        // Record successful refund
        $refundDesc = "Refund For {$ref} Transactions (Price Impact)";
        $reference = crc32($ref);
        $refundwallet = $refundResult["sender"] ?? $siteaddress;
        $targetwallet = $refundResult["receiver"] ?? $fuser_address;
        $refund_hash = $refundResult["hash"] ?? "N/A";
        
        $controller->recordrefundchainTransaction(
            $userid, 
            "Refund", 
            $refundDesc, 
            $reference, 
            "0.00", 
            $targetwallet, 
            $refund_hash, 
            $refundwallet, 
            $tokenamount, 
            "9", 
            $transaction_type, 
            $token_name, 
            $normTokenContract,
            $blockchain_id
        );
    }
    
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Purchase Airtime
// -------------------------------------------------------------------
$result = $airtimeController->purchaseMyAirtime($body, $networkDetails);
// $result = ["status" => "success", "msg" => "Transaction Successful"]; 
// -------------------------------------------------------------------
//  Process Result
// -------------------------------------------------------------------
if ($result["status"] == "success") {
    // Credit referal bonus if applicable
    if (!empty($refearedby) && !$isDexToken) {
        $controller->creditReferalBonus($referal, $referalname, $refearedby, $servicename);
    }
    
    // Update transaction status to successful
    $controller->updateTransactionStatus($userid, $ref, $amountopay, "0");
    
    // Save profit for non-DEX transactions
    if (!$isDexToken) {
        $controller->saveProfit($ref, $profit);
    }
    
    header('HTTP/1.0 200 OK');
    $response['status'] = "success";
    $response['Status'] = "successful";
    echo json_encode($response);
    exit();
} else {
    // Handle failed purchase
    $updatedDesc = "{$networkDetails["network"]} Airtime purchase of N{$amount} @ {$tokenamount} {$token_name} for phone number {$phone} Failed - " . ($result["msg"] ?? "Network/Server Error");
    $controller->updateFailedTransactionStatus($userid, $updatedDesc, $ref, $amountopay, "1");
    
    $erroresult = $controller->checkIfError();
    
    // ALWAYS attempt refund since blockchain is verified
    $refundResult = $controller->refundTransaction($ref, $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
    
    if ($refundResult["status"] == "fail") {
        header('HTTP/1.0 400 Bad Request');
        $response['status'] = "fail";
        
        if ($erroresult) {
            $response['msg'] = $result["msg"] . " Refunding Failed: " . $refundResult['msg'];
        } else {
            $response['msg'] = "Transaction Failed and Refund Failed, Please Contact Support";
        }
        
        $controller->logError($response['msg'], "Api :: Airtime Index", $userid);
        echo json_encode($response);
        exit();
    }
    
    // Record successful refund
    $refundDesc = "Refund For {$ref} Transactions";
    $reference = crc32($ref);
    $refundwallet = $refundResult["sender"] ?? $siteaddress;
    $targetwallet = $refundResult["receiver"] ?? $fuser_address;
    $refund_hash = $refundResult["hash"] ?? "N/A";
    
    $controller->recordrefundchainTransaction(
        $userid, 
        "Refund", 
        $refundDesc, 
        "0.00", 
        $reference, 
        $targetwallet, 
        $refund_hash, 
        $refundwallet, 
        $tokenamount, 
        "9", 
        $transaction_type, 
        $token_name, 
        $normTokenContract
    );
    
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['Status'] = "failed";
    $response['msg'] = $result["msg"] ?? "Transaction Failed (Refund Processed)";
    $controller->logError($response['msg'], "Api :: Airtime Index", $userid);
    echo json_encode($response);
    exit();
}
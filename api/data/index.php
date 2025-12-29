<?php
// Auto Load Classes
require_once("../autoloader.php");
require_once("../security_helper.php");

// Apply Security Measures
ApiSecurity::disableErrorDisplay();
ApiSecurity::applySecurityHeaders();
ApiSecurity::rateLimit(30, 60);

// Allowed API Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

$headers = apache_request_headers();
$response = array();
$controller = new ApiAccess;
$controller2 = new InternetData;
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
        $amount, 
        $ref, 
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
            "0.00", 
            $reference, 
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
    } else {
        // Record failed refund
        $refundDesc = "Refund Failed For {$ref} (" . ($refundResult['msg'] ?? 'Unknown') . ")";
        $reference = crc32($ref . "REFFAIL");
        $refundwallet = $siteaddress;
        $targetwallet = $fuser_address;
        
        $controller->recordrefundchainTransaction(
            $userid, 
            "Refund", 
            $refundDesc, 
            "0.00", 
            $reference, 
            $targetwallet, 
            "N/A", 
            $refundwallet, 
            $tokenamount, 
            "1", // Failed refund status
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
        'data_plan' => 'Data Plan ID Is Required',
        'ref' => 'Ref Is Required',
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
if (isset($body->mobile_number)) {
    $body2["phone"] = $body->mobile_number;
}
if (isset($body->plan)) {
    $body2["data_plan"] = $body->plan;
}
if (!isset($body->ported_number)) {
    $body2["ported_number"] = "false";
}
if (!isset($body->ref)) {
    $body2["ref"] = time();
}
$body = (object) array_merge((array)$body, $body2);

// Extract and sanitize inputs
$network = isset($body->network) ? trim($body->network) : "";
$phone = isset($body->phone) ? trim($body->phone) : "";
$data_plan = isset($body->data_plan) ? trim($body->data_plan) : "";
$ported_number = isset($body->ported_number) ? $body->ported_number : "false";
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
$chainresult = $controller->verifyAssetTransaction($target_address, $tx_hash, $user_address, $amount_wei, $token_contract);
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
$decQ = $dbh->prepare("SELECT token_decimals, token_name, token_contract FROM tokens WHERE LOWER(token_contract)=LOWER(:c) AND is_active=1 LIMIT 1");
$decQ->bindParam(':c', $token_contract, PDO::PARAM_STR);
$decQ->execute();
$trow = $decQ->fetch(PDO::FETCH_ASSOC);

if (!$trow) {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Token Not Found or Disabled";
    echo json_encode($response);
    exit();
}

$token_decimals = (int)($trow['token_decimals'] ?? 6);
$token_name = $trow['token_name'] ?? 'Unknown';
$tokenamount = number_format($controller->convertWeiToToken($amount_wei, $token_decimals), 4, '.', '');

// -------------------------------------------------------------------
//  Address Normalization and Validation
// -------------------------------------------------------------------
$ftarget_address = $controller->normalizeEvmAddress($target_address);
$fuser_address = $controller->normalizeEvmAddress($user_address);
$normTokenContract = $controller->normalizeEvmAddress($token_contract);

// Get blockchain configuration
$blockchainConfig = $controller->getBlockchainConfig('AssetChain');
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

// Prepare common params for failure handling
$transaction_type = $isDexToken ? 'dex' : 'app';

// Address validation checks
if ($ftarget_address == $fuser_address) {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Target Address Cannot Be Your Address";
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Data",
        'servicedesc' => "Failed {$network} Data purchase for {$phone} (Target = User Address)",
        'amount' => "0",
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

if ($fuser_address == $fsite_address) {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "User Address Cannot Be Site Address";
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Data",
        'servicedesc' => "Failed {$network} Data purchase for {$phone} (User = Site Address)",
        'amount' => "0",
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

// Refunding Address Balance Check
if (!empty($refundingAddress) && !empty($token_contract) && !empty($amount_wei)) {
    $balanceCheck = $controller->checkERC20Balance($refundingAddress, $token_contract);
    if ($balanceCheck['status'] === 'success') {
        $hexBal = $balanceCheck['balance_hex'];
        $decBal = hexdec($hexBal); 
        if ($decBal < (float)$amount_wei) {
            header('HTTP/1.0 400 Bad Request');
            $response['status'] = "fail";
            $response['msg'] = "Low Balance: Refunding address has insufficient funds";
            
            // Record but cannot refund
            $controller->recordchainTransaction(
                $userid, 
                "Data",
                "Failed {$network} Data purchase for {$phone} (Insufficient Refund Balance)",
                "0", 
                $ref, 
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
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Data",
        'servicedesc' => "Failed {$network} Data purchase for {$phone} (Invalid Network ID)",
        'amount' => "0",
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
} else {
    $networkDetails = $result;
}

// -------------------------------------------------------------------
//  Check If Network Is Available
// -------------------------------------------------------------------
if ($networkDetails["networkStatus"] <> "On") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Sorry, {$networkDetails["network"]} is not available at the moment";
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Data",
        'servicedesc' => "Failed {$networkDetails['network']} Data purchase for {$phone} (Network Unavailable)",
        'amount' => "0",
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
//  Verify Plan Id
// -------------------------------------------------------------------
$result = $controller->verifyDataPlanId($network, $data_plan, $usertype);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "The Data Plan ID : $data_plan is invalid ";
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Data",
        'servicedesc' => "Failed {$networkDetails['network']} Data purchase for {$phone} (Invalid Plan ID)",
        'amount' => "0",
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

// Plan is valid, extract details
$datagroup = $result["datatype"];
$actualPlanId = $result["dataplan"];
$amountopay = (float) $result["amount"];
$buyprice = (float) $result["buyprice"];
$profit = 0;
$plandesc = "Purchase of " . $networkDetails["network"] . " " . $result['name'] . " " . $result['datatype'] . " " . $result['day'] . " Days " . "@ {$tokenamount} {$token_name} Plan for phone number {$phone}";

// Check Datagroup availability
$datagroupmessage = "";
if ($datagroup == "SME" && $networkDetails["smeStatus"] <> "On") {
    $datagroupmessage = "Sorry, {$networkDetails["network"]} SME is not available at the moment";
}
if ($datagroup == "Gifting" && $networkDetails["giftingStatus"] <> "On") {
    $datagroupmessage = "Sorry, {$networkDetails["network"]} Gifting is not available at the moment";
}
if ($datagroup == "Corporate" && $networkDetails["corporateStatus"] <> "On") {
    $datagroupmessage = "Sorry, {$networkDetails["network"]} Corporate is not available at the moment";
}

if ($datagroupmessage <> "") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = $datagroupmessage;
    
    $failureParams = [
        'userid' => $userid,
        'servicename' => "Data",
        'servicedesc' => "Failed {$networkDetails['network']} Data purchase for {$phone} (Plan Unavailable)",
        'amount' => $amountopay,
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
//  Verify Phone Number
// -------------------------------------------------------------------
if ($ported_number == "false") {
    $result = $controller->verifyPhoneNumber($phone, $networkDetails["network"]);
    if ($result["status"] == "fail") {
        header('HTTP/1.0 400 Bad Request');
        $response['status'] = "fail";
        $response['msg'] = $result["msg"];
        
        $failureParams = [
            'userid' => $userid,
            'servicename' => "Data",
            'servicedesc' => "Failed {$networkDetails['network']} Data purchase for {$phone} (Invalid Phone)",
            'amount' => $amountopay,
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
}

// -------------------------------------------------------------------
//  Record Transaction As Processing
// -------------------------------------------------------------------
// Check for internal duplicates before recording
$result = $controller->checkTransactionDuplicate("Data", $plandesc);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Possible Transaction Duplicate, Please Verify Transaction & Try Again After 60 Seconds";
    echo json_encode($response);
    exit();
}

$transRecord = $controller->recordchainTransaction($userid, "Data", $plandesc, $amountopay, $ref, $ftarget_address, $tx_hash, $fuser_address, $tokenamount, "5", $transaction_type, $token_name, $normTokenContract, $blockchain_id);
if ($transRecord["status"] == "fail") {
    header('HTTP/1.0 400 Bad Request');
    $response['status'] = "fail";
    $response['msg'] = "Failed To Record, Please Try Again Later";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Price Impact Check
// -------------------------------------------------------------------
$checkprice = $controller->checkpriceimpactcngn($amountopay, $tokenamount);
if ($checkprice['status'] == 'fail') {
    header('HTTP/1.0 400 Bad Request');
    $servicedesc = $plandesc . " Failed Due To Price Impact";
    $controller->updateFailedTransactionStatus($userid, $servicedesc, $ref, $amountopay, "1");
    $response['status'] = "fail";
    $response['msg'] = $checkprice['msg'] ?? "Price Maybe Higher or Lower, Please Try Again Later";
    
    // Manual refund
    $refund = $controller->refundTransaction($ref, $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
    
    if ($refund["status"] == "fail") {
        $servicedesc = "Refund Failed For {$ref} (Price Impact)";
        $reference = crc32($ref . "REFFAIL");
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $fuser_address, "N/A", $siteaddress, $tokenamount, "1", $transaction_type, $token_name, $normTokenContract, $blockchain_id);
    } else {
        $servicedesc = "Refund For {$ref} Transactions ". ($refund['msg']?? " - ");
        $reference = crc32($ref);
        $refundwallet = $refund["sender"] ?? $siteaddress;
        $targetwallet = $refund["receiver"] ?? $fuser_address;
        $refund_hash = $refund["hash"] ?? " - ";
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract, $blockchain_id);
    }
    
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Send Request To Purchase Data
// -------------------------------------------------------------------
$result = $controller2->purchaseData($body, $networkDetails, $datagroup, $actualPlanId);
// $result = ["status" => "success", "msg" => "Transaction Successful"]; 

if ($result["status"] == "success") {
    if ($refearedby <> "") {
        $controller->creditReferalBonus($referal, $referalname, $refearedby, "Data");
    }
    $controller->updateTransactionStatus($userid, $ref, $amountopay, "0");
    $controller->saveProfit($ref, $profit);
    $response['status'] = "success";
    $response['Status'] = "successful";
    header('HTTP/1.0 200 Transaction Successful');
    echo json_encode($response);
    exit();
} else {
    header('HTTP/1.0 400 Transaction Failed');
    $response['status'] = "fail";
    $response['Status'] = "failed";
    $response['msg'] = $result["msg"] ?? "Network / Server Error ";
    $servicedesc = $plandesc . " Failed " . ($result["msg"] ?? "Network / Server Error");
    
    $controller->updateFailedTransactionStatus($userid, $servicedesc, $ref, $amountopay, "1");
    
    // Refund
    $refund = $controller->refundTransaction($ref, $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
    
    if ($refund["status"] == "fail") {
        $servicedesc = "Refund Failed For {$ref} (Transaction Failed)";
        $reference = crc32($ref . "REFFAIL");
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $fuser_address, "N/A", $siteaddress, $tokenamount, "1", $transaction_type, $token_name, $normTokenContract, $blockchain_id);
    } else {
        $servicedesc = "Refund For {$ref} Transactions" . " " . ($refund['msg'] ?? "N/A");
        $reference = crc32($ref);
        $refundwallet = $refund["sender"] ?? $siteaddress;
        $targetwallet = $refund["receiver"] ?? $fuser_address;
        $refund_hash = $refund["hash"] ?? "N/A";
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract, $blockchain_id);
    }
    
    echo json_encode($response);
    exit();
}

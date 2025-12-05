<?php
//Auto Load Classes
require_once("../autoloader.php");

//Allowed API Headers
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
//  Check Request Method
// -------------------------------------------------------------------

$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($requestMethod !== 'POST') {
    header('HTTP/1.0 400 Bad Request');
    $response["status"] = "fail";
    $response["msg"] = "Only POST method is allowed";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Check For Api Authorization
// -------------------------------------------------------------------

// Function to validate DEX token
function validateDexToken($token)
{
    $tokenFile = __DIR__ . '/../../dex/dex_token.json';
    if (!file_exists($tokenFile)) {
        return false;
    }
    $tokenData = json_decode(file_get_contents($tokenFile), true);
    return ($tokenData && isset($tokenData['token']) && $tokenData['token'] === $token);
}

$isDexToken = false;
if ((isset($headers['Authorization']) || isset($headers['authorization'])) || (isset($headers['Token']) || isset($headers['token']))) {
    if ((isset($headers['Authorization']) || isset($headers['authorization']))) {
        $token = trim(str_replace("Token", "", (isset($headers['Authorization'])) ? $headers['Authorization'] : $headers['authorization']));
    }
    if ((isset($headers['Token']) || isset($headers['token']))) {
        $token = trim(str_replace("Token", "", (isset($headers['Token'])) ? $headers['Token'] : $headers['token']));
    }

    // Check if it's a DEX token first
    if (validateDexToken($token)) {
        $isDexToken = true;
        // Set default values for DEX transactions
        $usertype = "dex";
        $userbalance = 999999999; // High balance for DEX transactions
        $userid = 0; // Special ID for DEX transactions
        $refearedby = "";
        $referal = "dex";
        $referalname = "DEX User";
    } else {
        // Regular token validation
        $result = $controller->validateAccessToken($token);
        if ($result["status"] == "fail") {
            // tell the user no products found
            header('HTTP/1.0 401 Unauthorized');
            $response["status"] = "fail";
            $response["msg"] = "Authorization token not found $token";
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
    // tell the user no products found
    $response["status"] = "fail";
    $response["msg"] = "Your authorization token is required.";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Get The Request Details
// -------------------------------------------------------------------

$input = @file_get_contents("php://input");

//decode the json file
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

$network = (isset($body->network)) ? $body->network : "";
$phone = (isset($body->phone)) ? $body->phone : "";
$amount = (isset($body->amount)) ? $body->amount : "";
$ported_number = (isset($body->ported_number)) ? $body->ported_number : "false";
$airtime_type = (isset($body->airtime_type)) ? $body->airtime_type : "";
$ref = (isset($body->ref)) ? $body->ref : "";

$target_address = (isset($body->target_address)) ? $body->target_address : "";
$tx_hash = (isset($body->tx_hash)) ? $body->tx_hash : "";
$user_address = (isset($body->user_address)) ? $body->user_address : "";
// Assetchain migration: use amount_wei and optional token_contract (CNGN by default)
$amount_wei = (isset($body->amount_wei)) ? $body->amount_wei : "";
$token_contract = (isset($body->token_contract)) ? $body->token_contract : "";

// -------------------------------------------------------------------
//  Check Inputs Parameters
// -------------------------------------------------------------------

$requiredField = "";

if ($airtime_type == "") {
    $requiredField = "Airtime Type Is Required";
}
if ($amount == "") {
    $requiredField = "Amount Is Required";
}
if ($phone == "") {
    $requiredField = "Phone Is Required";
}
if ($network == "") {
    $requiredField = "Network Id Required";
}
if ($ref == "") {
    $requiredField = "Ref Is Required";
}
if ($airtime_type <> "") {
    if ($airtime_type <> "VTU" && $airtime_type <> "Share And Sell") {
        $requiredField = "Airtime Type can only be VTU or Share And Sell";
    }
}


if ($target_address == "") {
    $requiredField = "Target Adress Is Required";
}
if ($tx_hash == "") {
    $requiredField = "Onchain Transaction Hash Is Required";
}
if ($user_address == "") {
    $requiredField = "User Adress Required";
}
if ($amount_wei == "") {
    $requiredField = "Token amount_wei is required";
}
if ($requiredField <> "") {
    header('HTTP/1.0 400 Parameters Required');
    $response['status'] = "fail";
    $response['msg'] = $requiredField;
    echo json_encode($response);
    exit();
}
    $erroresult = $controller->checkIfError();
// Verify Assetchain transaction (CNGN ERC-20)
$chainresult = $controller->verifyAssetTransaction($target_address, $tx_hash, $user_address, $amount_wei, $token_contract);
if ($chainresult["status"] == "fail") {
    header('HTTP/1.0 400 Transaction Verification Failed');
    $response['status'] = "fail";
    $erroresult = $controller->checkIfError();
    if ($erroresult) {
        $response['msg'] = $chainresult['msg'] ?? 'verification_failed';
        if (isset($chainresult['expected_value']) || isset($chainresult['transfer_value'])) {
            $response['msg'] .= " | expected: " . ($chainresult['expected_value'] ?? 'N/A') . ", got: " . ($chainresult['transfer_value'] ?? 'N/A');
        }
        echo json_encode($response);
        exit();
    } else {
        $response['msg'] = "Transaction Verification Failed, Please Check The Transaction Details And Try Again or Contact Support";
        echo json_encode($response);
        exit();
    }
}
$ftarget_address = $controller->normalizeEvmAddress($target_address);
// Check Target Adress
$fuser_address = $controller->normalizeEvmAddress($user_address);
// Resolve token decimals from DB
$dbh = AdminModel::connect();
$decQ = $dbh->prepare("SELECT token_decimals, token_name, token_contract FROM tokens WHERE LOWER(token_contract)=LOWER(:c) AND is_active=1 LIMIT 1");
$decQ->bindParam(':c', $token_contract, PDO::PARAM_STR);
$decQ->execute();
$trow = $decQ->fetch(PDO::FETCH_ASSOC);
if (!$trow) {
    header('HTTP/1.0 400 Invalid Token');
    $response['status'] = "fail";
    $response['msg'] = "Token Not Found or Disabled";
    echo json_encode($response);
    exit();
}
$token_decimals = (int)($trow['token_decimals'] ?? 6);
$token_name = $trow['token_name'] ?? 'Unknown';
$tokenamount = $controller->convertWeiToToken($amount_wei, $token_decimals);
$from = "Api :: Airtime Index";

// -------------------------------------------------------------------
//  Verify Network Id
// -------------------------------------------------------------------

$result = $controller->verifyNetworkId($network);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Invalid Network Id');
    $response['status'] = "fail";
    $response['msg'] = "The Network id is invalid ";
    // Refund on-chain disabled for Assetchain path
    if (!$isDexToken) {
        $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
    } else {
        $refund = ["status" => "skip"];
    }
    if ($refund["status"] == "fail") {
        $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] .= " Failed To Refund, Please Try Again Later";
        }
        echo json_encode($response);
        exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions";
    $reference = crc32($body->ref);
    if (($refund["status"] ?? '') === 'success') {
        $refundwallet = $refund["sender"] ?? $siteaddress;
        $targetwallet = $refund["receiver"] ?? $fuser_address;
        $refund_hash = $refund["hash"] ?? "N/A";
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract);
    }

    echo json_encode($response);
    exit();
} else {
    $networkDetails = $result;
}


// -------------------------------------------------------------------
//  Check If Network Is Available
// -------------------------------------------------------------------

if ($airtime_type == "Share And Sell") {
    if ($networkDetails["networkStatus"] <> "On" || $networkDetails["sharesellStatus"] <> "On") {
        header('HTTP/1.0 400 Network Not Available');
        $response['status'] = "fail";
        $response['msg'] = "Sorry, {$networkDetails["network"]} is not available at the moment ";
        if ($networkDetails["sharesellStatus"] == "Off") {
            $response['msg'] = "Sorry, {$networkDetails["network"]} Share And Sell service is not available at the moment ";
        }
        if (!$isDexToken) {
            $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
        } else {
            $refund = ["status" => "skip"];
        }
        if ($refund["status"] == "fail") {
            $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
            if ($erroresult) {
                $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
            } else {
                $response['msg'] .= " Failed To Refund, Please Try Again Later";
            }
            echo json_encode($response);
            exit();
        }
        $servicedesc = "Refund For {$body->ref} Transactions";
        $reference = crc32($body->ref);
        if (($refund["status"] ?? '') === 'success') {
            $refundwallet = $refund["sender"] ?? $siteaddress;
            $targetwallet = $refund["receiver"] ?? $fuser_address;
            $refund_hash = $refund["hash"] ?? "N/A";
            $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract);
        }

        echo json_encode($response);
        exit();
    }
}


if ($airtime_type == "VTU") {
    if ($networkDetails["networkStatus"] <> "On" || $networkDetails["vtuStatus"] <> "On") {
        header('HTTP/1.0 400 Network Not Available');
        $response['status'] = "fail";
        $response['msg'] = "Sorry, {$networkDetails["network"]} is not available at the moment ";
        if ($networkDetails["vtuStatus"] == "Off") {
            $response['msg'] = "Sorry, {$networkDetails["network"]} VTU service is not available at the moment ";
        }
        if (!$isDexToken) {
            $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
        } else {
            $refund = ["status" => "skip"];
        }
        if ($refund["status"] == "fail") {
            $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
            if ($erroresult) {
                $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
            } else {
                $response['msg'] .= "Failed To Refund, Please Try Again Later";
            }
            echo json_encode($response);
            exit();
        }
        $servicedesc = "Refund For {$body->ref} Transactions";
        $reference = crc32($body->ref);
        if (($refund["status"] ?? '') === 'success') {
            $refundwallet = $refund["sender"] ?? $siteaddress;
            $targetwallet = $refund["receiver"] ?? $fuser_address;
            $refund_hash = $refund["hash"] ?? "N/A";
            $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract);
        }

        echo json_encode($response);
        exit();
    }
}




// -------------------------------------------------------------------
//  Verify Phone Number
// -------------------------------------------------------------------
if ($ported_number == "false") {
    $result = $controller->verifyPhoneNumber($phone, $networkDetails["network"]);
    if ($result["status"] == "fail") {
        header('HTTP/1.0 400 Invalid Phone Number');
        $response['status'] = "fail";
        $response['msg'] = $result["msg"];
        $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
        if ($refund["status"] == "fail") {
            $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
            if ($erroresult) {
                $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
            } else {
                $response['msg'] .= " Failed To Refund, Please Try Again Later";
            }
            echo json_encode($response);
            exit();
        }
        $servicedesc = "Refund For {$body->ref} Transactions";
        $reference = crc32($body->ref);
        $refundwallet = $refund["sender"] ?? $siteaddress;
        $targetwallet = $refund["receiver"] ?? $fuser_address;
        $refund_hash = $refund["hash"] ?? "N/A";
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract);

        echo json_encode($response);
        exit();
    }
}

// -------------------------------------------------------------------
//  Calculate Airtime Discount
// -------------------------------------------------------------------

if ($isDexToken) {
    $amountopay = (float) $amount;
    $buyamount =  (float) $amount;
    $profit = "0";
    $erroresult = $controller->checkIfError();
    $from = "Api :: Airtime Index";
} else {
    $result = $controller->calculateAirtimeDiscount($network, $airtime_type, $amount, $usertype);
    $amountopay = (float) $result["discount"];
    $buyamount =  (float) $result["buyamount"];
    $profit = $amountopay - $buyamount;
    $erroresult = $controller->checkIfError();
    $from = "Api :: Airtime Index";
}

// -------------------------------------------------------------------
//  Check Id User Balance Can Perform The Transaction
// -------------------------------------------------------------------
// if($amountopay > $userbalance || $amountopay < 0){
//         header('HTTP/1.0 400 Insufficient Balance');
//         $response['status']="fail";
//         $response['msg'] = "Insufficient balance fund your wallet and try again";
//         echo json_encode($response);
//         exit();
// }

// -------------------------------------------------------------------
//  Check For Minimum And Maximum Amount Of Airtime Purchase
// -------------------------------------------------------------------
$airtimelimit = $controller->getSiteSettings();
$airtimemin = (int) $airtimelimit->airtimemin;
$airtimemax = (int) $airtimelimit->airtimemax;

if ($amount < $airtimemin) {
    header("HTTP/1.0 400 Minimum airtime purchase is $airtimemin  ");
    $response['status'] = "fail";
    $response['msg'] = "Minimum airtime you can purchase is $airtimemin ";
    $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
    if ($refund["status"] == "fail") {
        $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] = $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] = " Failed To Refund, Please Try Again Later";
        }
        echo json_encode($response);
        exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions";
    $reference = crc32($body->ref);
    $refundwallet = $refund["sender"] ?? $siteaddress;
    $targetwallet = $refund["receiver"] ?? $fuser_address;
    $refund_hash = $refund["hash"] ?? "N/A";
    $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract);

    echo json_encode($response);
    exit();
}

if ($amount > $airtimemax) {
    header("HTTP/1.0 400 Maximum airtime purchase is $airtimemax");
    $response['status'] = "fail";
    $response['msg'] = "Maximum airtime you can purchase is $airtimemax";
    $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tokenamount, $token_contract, $token_name, $token_decimals);
    if ($refund["status"] == "fail") {

        $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] = $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] = "Failed To Refund, Please Try Again Later";
        }
        echo json_encode($response);
        exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions";
    $reference = crc32($body->ref);
    $refundwallet = $refund["sender"] ?? $siteaddress;
    $targetwallet = $refund["receiver"] ?? $fuser_address;
    $refund_hash = $refund["hash"] ?? "N/A";
    $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract);

    echo json_encode($response);
    exit();
}
// -------------------------------------------------------------------
//  Check For Api Authorization
// -------------------------------------------------------------------

$result = $controller->checkIfTransactionExist($ref);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Transaction Ref Already Exist');
    $response['status'] = "fail";
    $response['msg'] = "Transaction Ref Already Exist";
    echo json_encode($response);
    exit();
}


// -------------------------------------------------------------------
// Purchase Airtime
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// token amount already computed above
$servicename = "Airtime";
$servicedesc = "{$networkDetails["network"]} Airtime purchase of N{$amount} @ {$tokenamount} CNGN for phone number {$phone}";

// Transaction classification and token metadata
$transaction_type = $isDexToken ? 'dex' : 'app';
$normTokenContract = $controller->normalizeEvmAddress($token_contract);
$cngnContractCfg = '';
$tokenInfo = $controller->getTokenInfo('CNGN');
if ($tokenInfo && !empty($tokenInfo['token_contract'])) {
    $cngnContractCfg = $controller->normalizeEvmAddress($tokenInfo['token_contract']);
}
$token_name = $trow['token_name'] ?? (($normTokenContract && $normTokenContract === $cngnContractCfg) ? 'cNGN' : (($normTokenContract) ? 'ERC20' : 'ASET'));


$result = $controller->checkTransactionDuplicate($servicename, $servicedesc);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Possible Transaction Duplicate, Please Verify Transaction & Try Again After 60 Seconds');
    $response['status'] = "fail";
    $response['msg'] = "Possible Transaction Duplicate, Please Verify Transaction & Try Again After 60 Seconds";
    echo json_encode($response);
    exit();
}


// -------------------------------------------------------------------
// -------------------------------------------------------------------

// Get The User Saved Adress
if ($isDexToken) {
    $user_saved_address = $user_address;
} else {
    $adressresult = $controller->getUserDetails($token);
    if ($adressresult["tonwalletstatus"] == "0" || $adressresult["tonwalletstatus"] == 0) {
        header('HTTP/1.0 400 User Address Not Set');
        $response['status'] = "fail";
        $response['msg'] = "User Address Not Set, Please Set Your Address In Your Profile";
        echo json_encode($response);
        exit();
    }
    if ($adressresult["tonaddress"] == "" || $adressresult["tonaddress"] == null) {
        header('HTTP/1.0 400 User Address Empty');
        $response['status'] = "fail";
        $response['msg'] = "User Address Is Empty, Please Set Your Address In Your Profile";
        echo json_encode($response);
        exit();
    }
    $user_saved_address = $adressresult["tonaddress"];
}
$systemadressresult = $controller->getSiteSettings();
$siteaddress = $systemadressresult->walletaddress;
// Override site address/token contract from Assetchain config if available
// Override site address/token contract from Blockchain DB Config
$blockchainConfig = $controller->getBlockchainConfig('AssetChain');
$refundingAddress = null;

if ($blockchainConfig) {
    if (!empty($blockchainConfig['site_address'])) {
        $siteaddress = $blockchainConfig['site_address'];
    }
    $refundingAddress = !empty($blockchainConfig['refunding_address']) ? $blockchainConfig['refunding_address'] : $siteaddress;
}
// Fallback token contract if not set
if (empty($token_contract)) {
    $tokenInfo = $controller->getTokenInfo('CNGN');
    if ($tokenInfo) {
        $token_contract = $tokenInfo['token_contract'];
    }
}
if ($siteaddress == "" || $siteaddress == null) {
    header('HTTP/1.0 400 Site Address Empty');
    $response['status'] = "fail";
    $response['msg'] = "Site Address Is Empty, Please Contact Support";
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
            header('HTTP/1.0 400 Low Balance');
            $response['status'] = "fail";
            $response['msg'] = "Low Balance: Refunding address has insufficient funds. Required: $amount_wei wei of $token_contract";
            echo json_encode($response);
            exit();
        }
    } else {
        error_log("RPC Balance Check Failed: " . ($balanceCheck['msg'] ?? 'Unknown Error'));
        header('HTTP/1.0 500 Blockchain Error');
        $response['status'] = "fail";
        $response['msg'] = "Blockchain RPC Error: Unable to verify system balance.";
        echo json_encode($response);
        exit();
    }
}
$fsite_address = $controller->normalizeEvmAddress($siteaddress);
$ftarget_address = $controller->normalizeEvmAddress($target_address);
// Check Target Adress
$fuser_address = $controller->normalizeEvmAddress($user_address);
if ($ftarget_address == $fuser_address || $fuser_address == $ftarget_address) {
    header('HTTP/1.0 400 Target Address Cannot Be Your Address');
    $response['status'] = "fail";
    $response['msg'] = "Target Address Cannot Be Your Address";
    echo json_encode($response);
    exit();
}

if ($fuser_address == $fsite_address || $fsite_address == $fuser_address) {
    header('HTTP/1.0 400 User Address Cannot Be Site Address');
    $response['status'] = "fail";
    $response['msg'] = "User Address Cannot Be Site Address";
    echo json_encode($response);
    exit();
}

if (!$isDexToken && $ftarget_address <> $fsite_address) {
    header('HTTP/1.0 400 Target Address Not Valid');
    $response['status'] = "fail";
    $response['msg'] = "Invalid Target Address, Please Contact Support";
    echo json_encode($response);
    exit();
}

if (!$isDexToken && $fuser_address <> $user_saved_address) {
    header('HTTP/1.0 400 User Address Not Valid');
    $response['status'] = "fail";
    $response['msg'] = "User Address Not Valid, use saved wallet or Please Contact Support";
    echo json_encode($response);
    exit();
}

// token amount already computed above
// Check User Adress
//  Record Transaction As Processing With Status 5
$transRecord = $controller->recordchainTransaction($userid, $servicename, $servicedesc, $amountopay, $body->ref, $ftarget_address, $tx_hash, $fuser_address, $tokenamount, "5", $transaction_type, $token_name, $normTokenContract);
if ($transRecord["status"] == "fail") {
    header('HTTP/1.0 400 Transaction Failed');
    $response['status'] = "fail";
    $response['msg'] = "Failed To Record, Please Try Again Later";
    $controller->logError($response['msg'] ?? "Unknown", $from, $userid);
    echo json_encode($response);
    exit();
}


$checkprice = $controller->checkpriceimpactcngn($amountopay, $tokenamount);
// $checkprice['status'] = 'fail';
if ($checkprice['status'] == 'fail') {
    header('HTTP/1.0 400 Transaction Failed');
    $servicedesc = "{$networkDetails["network"]} Airtime purchase of N{$amount} @ {$tokenamount} CNGN for phone number {$phone} Failed Due To Price Impact";
    $controller->updateFailedTransactionStatus($userid, $servicedesc, $body->ref, $amountopay, "1");
    $response['status'] = "fail";
    $erroresult = $controller->checkIfError();
    $controller->logError($response['msg'] ?? "Unknown", $from, $userid);
    if ($erroresult) {
        $response['msg'] = $checkprice['msg'] ?? "Price Maybe Higher or Lower, Please Try Again Later ";
    } else {
        $response['msg'] = "Price Maybe Higher or Lower, Please Try Again Later ";
    }
    if (!$isDexToken) {
        $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tokenamount);
    } else {
        $refund = ["status" => "skip"];
    }
    if ($refund["status"] == "fail") {
        $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] .= "Failed To Refund, Please Try Again Later";
        }
        echo json_encode($response);
        exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions";
    $reference = crc32($body->ref);
    if (($refund["status"] ?? '') === 'success') {
        $refundwallet = $refund["sender"] ?? $siteaddress;
        $targetwallet = $refund["receiver"] ?? $fuser_address;
        $refund_hash = $refund["hash"] ?? "N/A";
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9", $transaction_type, $token_name, $normTokenContract);
    }

    // $controller->updateFailedTransactionStatus($userid, $servicedesc, $ref, $amountopay, "1");
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Send Request To Purchase Airtime
// -------------------------------------------------------------------

if ($isDexToken) {
    // $result = $airtimeController->purchaseMyAirtime($body, $networkDetails);
    $result["status"] = "success";
} else {
    $result = $airtimeController->purchaseMyAirtime($body, $networkDetails);
}

// -------------------------------------------------------------------
// Debit User Wallet & Record Transaction
// -------------------------------------------------------------------
if ($result["status"] == "success") {
    if ($refearedby <> "") {
        $controller->creditReferalBonus($referal, $referalname, $refearedby, $servicename);
    }
    $controller->updateTransactionStatus($userid, $body->ref, $amountopay, "0");
    $controller->saveProfit($body->ref, $profit);
    $response['status'] = "success";
    $response['Status'] = "successful";
    header('HTTP/1.0 200 Transaction Successful');
    echo json_encode($response);
    exit();
} else {

    $servicedesc = "{$networkDetails["network"]} Airtime purchase of N{$amount} @ {$tokenamount} CNGN for phone number {$phone} Failed " . ($result["msg"] ?? "Network / Server Error");
    $controller->updateFailedTransactionStatus($userid, $servicedesc, $body->ref, $amountopay, "1");
    $erroresult = $controller->checkIfError();
    // Refund User Wallet
    if (!$isDexToken) {
        $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tokenamount);
    } else {
        $refund = ["status" => "skip"];
    }
    if ($refund["status"] == "fail") {
        header('HTTP/1.0 400 Transaction Failed');
        $response['status'] = "fail";

        $controller->logError($response['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] = $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] = "Failed To Refund, Please Try Again Later";
        }
        echo json_encode($response);
        exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions";
    $reference = crc32($body->ref);
    if (($refund["status"] ?? '') === 'success') {
        $refundwallet = $refund["sender"] ?? $siteaddress;
        $targetwallet = $refund["receiver"] ?? $fuser_address;
        $refund_hash = $refund["hash"] ?? "N/A";
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tokenamount, "9");
    }
    $controller->logError($response['msg'] ?? "Unknown", $from, $userid);

    header('HTTP/1.0 400 Transaction Failed');
    $response['status'] = "fail";
    $response['Status'] = "failed";
    $response['msg'] = $result["msg"];
    echo json_encode($response);
    exit();
}

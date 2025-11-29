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
$controller2 = new InternetData;
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

if ((isset($headers['Authorization']) || isset($headers['authorization'])) || (isset($headers['Token']) || isset($headers['token']))) {
    if ((isset($headers['Authorization']) || isset($headers['authorization']))) {
        $token = trim(str_replace("Token", "", (isset($headers['Authorization'])) ? $headers['Authorization'] : $headers['authorization']));
    }
    if ((isset($headers['Token']) || isset($headers['token']))) {
        $token = trim(str_replace("Token", "", (isset($headers['Token'])) ? $headers['Token'] : $headers['token']));
    }
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
if (isset($body->mobile_number)) {
    $body2["phone"] = $body->mobile_number;
}
if (isset($body->plan)) {
    $body2["data_plan"] = $body->plan;
}
if (!isset($body->ref)) {
    $body2["ref"] = time();
}
$body = (object) array_merge((array)$body, $body2);

$network = (isset($body->network)) ? $body->network : "";
$phone = (isset($body->phone)) ? $body->phone : "";
$ported_number = (isset($body->ported_number)) ? $body->ported_number : "false";
$data_plan = (isset($body->data_plan)) ? $body->data_plan : "";
$ref = (isset($body->ref)) ? $body->ref : "";

$target_address = (isset($body->target_address)) ? $body->target_address : "";
$tx_hash = (isset($body->tx_hash)) ? $body->tx_hash : "";
$tx_lt = (isset($body->tx_lt)) ? $body->tx_lt : "";
$user_address = (isset($body->user_address)) ? $body->user_address : "";
$nanoamount = (isset($body->nanoamount)) ? $body->nanoamount : "";
// -------------------------------------------------------------------
//  Check Inputs Parameters
// -------------------------------------------------------------------

$requiredField = "";

if ($data_plan == "") {
    $requiredField = "Data Plan ID Is Required";
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
if ($target_address == "") {
    $requiredField = "Target Adress Is Required";
}
if ($tx_hash == "") {
    $requiredField = "Onchain Transaction Hash Is Required";
}
if ($tx_lt == "") {
    $requiredField = "Logic Time Required";
}
if ($user_address == "") {
    $requiredField = "User Adress Required";
}
if ($nanoamount == "") {
    $requiredField = "TON Amount Is Required";
}

if ($requiredField <> "") {
    header('HTTP/1.0 400 Parameters Required');
    $response['status'] = "fail";
    $response['msg'] = $requiredField;
    echo json_encode($response);
    exit();
}


// -------------------------------------------------------------------
//  Verify Network Id
// -------------------------------------------------------------------

$chainresult = $controller->verifyTransaction($target_address, $tx_hash, $tx_lt, $user_address, $nanoamount);
if ($chainresult["status"] == "fail") {
    header('HTTP/1.0 400 Transaction Verification Failed');
    $response['status'] = "fail";
    $erroresult = $controller->checkIfError();
    if ($erroresult) {
        if (isset($chainresult['code']) == "verification_failed") {
            $response['msg'] = $chainresult["msg"] . ". ";
            $response['msg'] .= "Expected Target: " . $chainresult["expected"]["target_address"] . " But Got: " . $chainresult["received"]["target_address"] . ". ";
            $response['msg'] .= "Expected Logic Time: " . $chainresult["expected"]["tx_lt"] . " But Got: " . $chainresult["received"]["tx_lt"] . ". ";
            $response['msg'] .= "Expected User Address: " . $chainresult["expected"]["user_address"] . " But Got: " . $chainresult["received"]["user_address"] . ". ";
            $response['msg'] .= "Expected TON Amount: " . $chainresult["expected"]["nanoamount"] . " But Got: " . $chainresult["received"]["nanoamount"];
        } else {
            $response['msg'] = $chainresult['msg'];
        }
        echo json_encode($response);
        exit();
    } else {
        $response['msg'] = "Transaction Verification Failed, Please Check The Transaction Details And Try Again or Contact Support";
        echo json_encode($response);
        exit();
    }
}

$ftarget_address = $controller->toFriendlyAddress($target_address, false, false);
// Check Target Adress
$fuser_address = $controller->toFriendlyAddress($user_address, false, false);
$tonamount = $controller->convertNanoToTon($nanoamount);

$from = "Api :: Data Index";


$result = $controller->verifyNetworkId($network);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Invalid Network Id');
    $response['status'] = "fail";
    $response['msg'] = "The Network id is invalid";
    $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tonamount);
    if ($refund["status"] == "fail") {
        header('HTTP/1.0 400 Transaction Failed');
        $response['status'] = "fail";
        $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] = $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] = "Failed To Refund, Please Try Again Later";
        }
        // echo json_encode($response);
        // exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions" . " " . $refund['msg'] ?? " - ";
    $reference = crc32($body->ref);
    $refundwallet = $refund["sender"] ?? $siteaddress;
    $targetwallet = $refund["receiver"] ?? $fuser_address;
    $refund_hash = $refund["hash"] ?? "N/A";
    $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tonamount,  $refund["status"] == "fail" ? "1" : "9");

    echo json_encode($response);
    exit();
} else {
    $networkDetails = $result;
}


// -------------------------------------------------------------------
//  Check If Network Is Available
// -------------------------------------------------------------------

if ($networkDetails["networkStatus"] <> "On") {
    header('HTTP/1.0 400 Network Not Available');
    $response['status'] = "fail";
    $response['msg'] = "Sorry, {$networkDetails["network"]} is not available at the moment";
    $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tonamount);
    if ($refund["status"] == "fail") {
        $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] .= " Failed To Refund, Please Try Again Later";
        }
        // echo json_encode($response);
        // exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions" . " " . $refund['msg'] ?? " - ";
    $reference = crc32($body->ref);
    $refundwallet = $refund["sender"] ?? $siteaddress;
    $targetwallet = $refund["receiver"] ?? $fuser_address;
    $refund_hash = $refund["hash"] ?? "N/A";
    $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tonamount,  $refund["status"] == "fail" ? "1" : "9");

    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Verify Plan Id
// -------------------------------------------------------------------

$result = $controller->verifyDataPlanId($network, $data_plan, $usertype);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Invalid Data Plan Id');
    $response['status'] = "fail";
    $response['msg'] = "The Data Plan ID : $data_plan is invalid ";
    $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tonamount);
    if ($refund["status"] == "fail") {
        $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] .= " Failed To Refund, Please Try Again Later";
        }
        // echo json_encode($response);
        // exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions" . " " . $refund['msg'] ?? " - ";
    $reference = crc32($body->ref);
    $refundwallet = $refund["sender"] ?? $siteaddress;
    $targetwallet = $refund["receiver"] ?? $fuser_address;
    $refund_hash = $refund["hash"] ?? "N/A";
    $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tonamount,  $refund["status"] == "fail" ? "1" : "9");

    echo json_encode($response);
    exit();
} else {

    // -------------------------------------------------------------------
    //Check If SME, Gifting, Corporate Data Is Disabled
    // -------------------------------------------------------------------

    $datagroup = $result["datatype"];
    $actualPlanId = $result["dataplan"];
    $datagroupmessage = "";

    if ($datagroup == "SME" && $networkDetails["smeStatus"] <> "On") {
        $datagroupmessage = "Sorry, {$networkDetails["network"]} SME is not available at the moment";
    }
    if ($datagroup == "Gifting" && $networkDetails["giftingStatus"] <> "On") {
        $datagroupmessage = "Sorry, {$networkDetails["network"]} SME is not available at the moment";
    }
    if ($datagroup == "Corporate" && $networkDetails["corporateStatus"] <> "On") {
        $datagroupmessage = "Sorry, {$networkDetails["network"]} SME is not available at the moment";
    }

    if ($datagroupmessage <> "") {
        header('HTTP/1.0 400 Data Not Available At The Moment');
        $response['status'] = "fail";
        $response['msg'] = $datagroupmessage;
        $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tonamount);
        if ($refund["status"] == "fail") {
            $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
            if ($erroresult) {
                $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
            } else {
                $response['msg'] .= " Failed To Refund, Please Try Again Later";
            }
            // echo json_encode($response);
            // exit();
        }
        $servicedesc = "Refund For {$body->ref} Transactions" . " " . $refund['msg'] ?? " - ";
        $reference = crc32($body->ref);
        $refundwallet = $refund["sender"] ?? $siteaddress;
        $targetwallet = $refund["receiver"] ?? $fuser_address;
        $refund_hash = $refund["hash"] ?? "N/A";
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tonamount,  $refund["status"] == "fail" ? "1" : "9");

        echo json_encode($response);
        exit();
    }

    //Calculate Profit
    $amountopay =  (float) $result["amount"];
    $buyprice =  (float) $result["buyprice"];
    $profit = 0;

    $plandesc = "Purchase of " . $networkDetails["network"] . " " . $result['name'] . " " . $result['datatype'] . " " . $result['day'] . " Days " . "@ {$tonamount} TON Plan for phone number {$phone}";
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
        $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tonamount);
        if ($refund["status"] == "fail") {
            $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
            if ($erroresult) {
                $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
            } else {
                $response['msg'] .= " Failed To Refund, Please Try Again Later";
            }
            // echo json_encode($response);
            // exit();
        }
        $servicedesc = "Refund For {$body->ref} Transactions" . " " . $refund['msg'] ?? " - ";
        $reference = crc32($body->ref);
        $refundwallet = $refund["sender"] ?? $siteaddress;
        $targetwallet = $refund["receiver"] ?? $fuser_address;
        $refund_hash = $refund["hash"] ?? "N/A";
        $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tonamount,  $refund["status"] == "fail" ? "1" : "9");

        echo json_encode($response);
        exit();
    }
}

// -------------------------------------------------------------------
//  Check Id User Balance Can Perform The Transaction
// -------------------------------------------------------------------
// if ($amountopay > $userbalance || $amountopay < 0) {
//     header('HTTP/1.0 400 Insufficient Balance');
//     $response['status'] = "fail";
//     $response['msg'] = "Insufficient balance fund your wallet and try again";
//     echo json_encode($response);
//     exit();
// }


// -------------------------------------------------------------------
//  Check For Api Authorization
// -------------------------------------------------------------------

$result = $controller->checkIfTransactionExist($ref);
if ($result["status"] == "fail") {
    header('HTTP/1.0 400 Transaction Ref Already Exist');
    $response['status'] = "fail";
    $response['msg'] = "Transaction Ref Already Exist ";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
// Purchase Data
// -------------------------------------------------------------------
// -------------------------------------------------------------------

$servicename = "Data";
$servicedesc = $plandesc;
$tonamount = $controller->convertNanoToTon($nanoamount);
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
$adressresult = $controller->getUserDetails($token);
if ($adressresult["tonwalletstatus"] == "0" || $adressresult["tonwalletstatus"] == 0) {
    header('HTTP/1.0 400 User Address Not Set');
    $response['status'] = "fail";
    $response['msg'] = "User Address Not Set, Please Set Your Address In Your Profile";
    echo json_encode($response);
    exit();
} else {
    if ($adressresult["tonaddress"] == "" || $adressresult["tonaddress"] == null) {
        header('HTTP/1.0 400 User Address Empty');
        $response['status'] = "fail";
        $response['msg'] = "User Address Is Empty, Please Set Your Address In Your Profile";
        echo json_encode($response);
        exit();
    } else {
        $user_saved_address = $adressresult["tonaddress"];
    }
}
$systemadressresult = $controller->getSiteSettings();
$siteaddress = $systemadressresult->walletaddress;
if ($siteaddress == "" || $siteaddress == null) {
    header('HTTP/1.0 400 Site Address Empty');
    $response['status'] = "fail";
    $response['msg'] = "Site Address Is Empty, Please Contact Support";
    echo json_encode($response);
    exit();
}

$ftarget_address = $controller->toFriendlyAddress($target_address, false, false);
// Check Target Adress
$fuser_address = $controller->toFriendlyAddress($user_address, false, false);
if ($ftarget_address == $fuser_address || $fuser_address == $ftarget_address) {
    header('HTTP/1.0 400 Target Address Cannot Be Your Address');
    $response['status'] = "fail";
    $response['msg'] = "Target Address Cannot Be Your Address";
    echo json_encode($response);
    exit();
}

if ($fuser_address == $siteaddress || $siteaddress == $fuser_address) {
    header('HTTP/1.0 400 User Address Cannot Be Site Address');
    $response['status'] = "fail";
    $response['msg'] = "User Address Cannot Be Site Address";
    echo json_encode($response);
    exit();
}

if ($ftarget_address <> $siteaddress) {
    header('HTTP/1.0 400 Target Address Not Valid');
    $response['status'] = "fail";
    $response['msg'] = "Invalid Target Address, Please Contact Support";
    echo json_encode($response);
    exit();
}

if ($fuser_address <> $user_saved_address) {
    header('HTTP/1.0 400 User Address Not Valid');
    $response['status'] = "fail";
    $response['msg'] = "User Address Not Valid, use saved wallet or Please Contact Support";
    echo json_encode($response);
    exit();
}

// -------------------------------------------------------------------
//  Record Transaction As Processing With Status 5
// -------------------------------------------------------------------
$transRecord = $controller->recordchainTransaction($userid, $servicename, $servicedesc, $amountopay, $body->ref, $ftarget_address, $tx_hash, $fuser_address, $tonamount, "5");
if ($transRecord["status"] == "fail") {
    header('HTTP/1.0 400 Transaction Failed');
    $response['status'] = "fail";
    $response['msg'] = "Failed To Record, Please Try Again Later";
    $controller->logError($response['msg'] ?? "Unknown", $from, $userid);
    echo json_encode($response);
    exit();
}

$checkprice = $controller->checkpriceimpact($amountopay, $tonamount);
// $checkprice['status'] = 'fail';
if ($checkprice['status'] == 'fail') {
    header('HTTP/1.0 400 Transaction Failed');
    $servicedesc = $plandesc." Failed Due To Price Impact";
    $controller->updateFailedTransactionStatus($userid, $servicedesc, $body->ref, $amountopay, "1");
    $response['status'] = "fail";
    $erroresult = $controller->checkIfError();
    $controller->logError($response['msg'] ?? "Unknown", $from, $userid);
    if ($erroresult) {
        $response['msg'] = $checkprice['msg'] ?? "Price Maybe Higher or Lower, Please Try Again Later ";
    } else {
        $response['msg'] = "Price Maybe Higher or Lower, Please Try Again Later ";
    }
    $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tonamount);
    if ($refund["status"] == "fail") {
        $controller->logError($refund['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] .= "Failed To Refund, Please Try Again Later";
        }
        
        // echo json_encode($response);
        // exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions ". $refund['msg']?? " - ";
    $reference = crc32($body->ref);
    $refundwallet = $refund["sender"] ?? $siteaddress;
    $targetwallet = $refund["receiver"] ?? $fuser_address;
    $refund_hash = $refund["hash"] ?? " - ";
    $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tonamount,  $refund["status"] == "fail" ? "1" : "9");

    // $controller->updateFailedTransactionStatus($userid, $servicedesc, $ref, $amountopay, "1");
    echo json_encode($response);
    exit();
}
// -------------------------------------------------------------------
//  Send Request To Purchase Airtime
// -------------------------------------------------------------------
$result = $controller2->purchaseData($body, $networkDetails, $datagroup, $actualPlanId);

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
    header('HTTP/1.0 400 Transaction Failed');
    $response['status'] = "fail";
    $response['Status'] = "failed";
    $response['msg'] = $result["msg"] ?? "Network / Server Error ";
    $servicedesc = $plandesc ." Failed " . $result["msg"] ?? "Network / Server Error";
    $controller->updateFailedTransactionStatus($userid, $servicedesc, $body->ref, $amountopay, "1");
    $erroresult = $controller->checkIfError();
    // Refund User Wallet
    $refund = $controller->refundTransaction($body->ref,  $fuser_address, $tonamount);
    if ($refund["status"] == "fail") {
        header('HTTP/1.0 400 Transaction Failed');
        $response['status'] = "fail";

        $controller->logError($response['msg'] ?? "Unknown", $from, $userid);
        if ($erroresult) {
            $response['msg'] .= $refund['msg'] . " Refunding Failed. ";
        } else {
            $response['msg'] .= " Failed To Refund, Please Try Again Later";
        }
        // echo json_encode($response);
        // exit();
    }
    $servicedesc = "Refund For {$body->ref} Transactions" . " " . $refund['msg'] ?? "N/A";
    $reference = crc32($body->ref);
    $refundwallet = $refund["sender"] ?? $siteaddress;
    $targetwallet = $refund["receiver"] ?? $fuser_address;
    $refund_hash = $refund["hash"] ?? "N/A";
    $controller->recordrefundchainTransaction($userid, "Refund", $servicedesc, "0.00", $reference, $targetwallet, $refund_hash, $refundwallet, $tonamount,  $refund["status"] == "fail" ? "1" : "9");
    $controller->logError($response['msg'] ?? "Unknown", $from, $userid);

    echo json_encode($response);
    exit();
}

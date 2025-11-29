<?php

/*

        * Route For Admin
        * Login
        * Posts
        * Forms

    */

session_start();
//ini_set("display_errors",1); 
//error_reporting(E_ALL);

//Verify User Is Logged In
if (!isset($_SESSION["sysId"]) && !isset($_GET["login"])) {
    header("Location: ../");
    exit();
}

//Auto Load Classes
require_once("auto_loader.php");

//Global Variables
date_default_timezone_set('Africa/Lagos');
$protocol = (isset($_SERVER['HTTPS'])) ? "https://" : "http://";
$assetsLoc = $protocol . $_SERVER['SERVER_NAME'] . "/" . $parentdirectory . "/assets";
$urlAddon = "./";
$data = "";
$page = "dashboard.php";
$title = "Home";
$msg = "";
$link = explode("/", $_GET["url"]);
$url = $link[0];
$arg1 = (!empty($link[1])) ? $link[1] : 0;
$arg2 = (!empty($link[2])) ? $link[2] : 0;
$arg3 = (!empty($link[3])) ? $link[3] : 0;
$controller = "";

$limit = 1000;
$pageCount = (isset($_GET["page"])) ? $_GET["page"] : 1;
$pageCount = (float) $pageCount;
$limit = $pageCount * $limit;
$limit = $limit - 1000;
$pageCount++;


//Admin Login
if (isset($_GET["login"])) {
    $controller = new AccountAccess;
    echo $controller->verifyAdminLogin();
    exit();
} else {
    global $controller;
    $controller = new AdminController;
}

//Admin Logout
if ($url == "logout") {
    $controller->logoutUser();
}

//Block System User
if (isset($_GET["block-user"])) {
    echo $controller->updateAccountStatus();
    exit();
}

//Delete User Account
if (isset($_GET["delete-user-account"])) {
    echo $controller->terminateUserAccount();
    exit();
}
if (isset($_GET["delete-merchant"])) {
    echo $controller->terminateMerchant();
    exit();
}
if (isset($_GET["get-merchant-by-phone"])) {
    echo $controller->getSubscriberByPhone();
    exit();
}
//Add Merchant
if (isset($_POST["add-merchant"])) {
    $msg = $controller->addMerchant();
}
//Update Merchant
if (isset($_POST["update-merchant"])) {
    $msg = $controller->updateMerchant();
}


//Reset Api Key For User
if (isset($_GET["reset-user-api-key"])) {
    echo $controller->resetAccountApiKey();
    exit();
}

//Add New Api Details
if (isset($_POST["add-new-api-details"])) {
    $msg = $controller->addNewApiDetails();
}

//Update Exam pin Settings
if (isset($_POST["update-exam-pin-setting"])) {
    $msg = $controller->updateExamPin();
}

//Update Electricity Bill Settings
if (isset($_POST["update-electricity-bill-setting"])) {
    $msg = $controller->updateElectricityBill();
}

//Add New System User
if (isset($_POST["add-new-user"])) {
    $msg = $controller->createAccount();
}

//Update System User Details
if (isset($_POST["update-account"])) {
    $msg = $controller->updateAdminAccount();
}

//Delete A Contact Message
if (isset($_GET["delete-message"])) {
    $msg = $controller->deleteContact();
    exit();
}

//Update Api Configurations
if (isset($_POST["update-api-config"])) {
    $msg = $controller->updateApiConfiguration();
}

//Update Monnify Configurations
if (isset($_POST["update-monnify-config"])) {
    $msg = $controller->updateApiConfiguration();
}

//Update Paystack Configurations
if (isset($_POST["update-paystack-config"])) {
    $msg = $controller->updateApiConfiguration();
}

//Update Network Settings
if (isset($_POST["update-network-setting"])) {
    $msg = $controller->updateNetworkSetting();
}

//Update Contact Settings
if (isset($_POST["update-contact-setting"])) {
    $msg = $controller->updateContactSetting();
}

//Update Site Settings
if (isset($_POST["update-site-setting"])) {
    $msg = $controller->updateSiteSetting();
}

//Update Site Style Settings
if (isset($_POST["update-site-style"])) {
    $msg = $controller->updateSiteStyleSetting();
}

//Add Airtime Discount
if (isset($_POST["add-airtime-discount"])) {
    $msg = $controller->addAirtimeDiscount();
}

//Update Airtime Discount
if (isset($_POST["update-airtime-discount"])) {
    $msg = $controller->updateAirtimeDiscount();
}
//Add Alpha Topup
if (isset($_POST["add-alpha-topup"])) {
    $msg = $controller->addAlphaTopup();
}

//Delete Alpha Topup
if (isset($_GET["delete-alpha-topup"])) {
    $msg = $controller->deleteAlphaTopup();
    exit();
}

//Update Alpha Topup
if (isset($_POST["update-alpha-topup"])) {
    $msg = $controller->updateAlphaTopup();
}

//Add Recharge Card Pin Discount
if (isset($_POST["add-recharge-pin-discount"])) {
    $msg = $controller->addRechargeCardPinDiscount();
}

//Update Recharge Card Pin Discount
if (isset($_POST["update-recharge-pin-discount"])) {
    $msg = $controller->updateRechargeCardPinDiscount();
}

//Add Data Plan
if (isset($_POST["add-data-plan"])) {
    $msg = $controller->addDataPlan();
}

//Update Data Plan
if (isset($_POST["update-data-plan"])) {
    $msg = $controller->updateDataPlan();
}

//Update Data Plan
if (isset($_POST["update-api"])) {
    $msg = $controller->updateApiDetails();
}

//Delete A Data Plan
if (isset($_GET["delete-data-plan"])) {
    $msg = $controller->deleteDataPlan();
    exit();
}
//Delete Media
if (isset($_GET["delete-media"])) {
    $msg = $controller->deleteMedia();
    exit();
}
if (isset($_GET["delete-api"])) {
    $msg = $controller->deleteApi();
    exit();
}
//Add Data Pin
if (isset($_POST["add-data-pin"])) {
    $msg = $controller->addDataPin();
}

//Update Data Pin
if (isset($_POST["update-data-pin"])) {
    $msg = $controller->updateDataPin();
}

//Delete A Data Pin
if (isset($_GET["delete-data-pin"])) {
    $msg = $controller->deleteDataPin();
    exit();
}

//Add Cable Plan
if (isset($_POST["add-cable-plan"])) {
    $msg = $controller->addCablePlan();
}

//Update Cable Plan
if (isset($_POST["update-cable-plan"])) {
    $msg = $controller->updateCablePlan();
}

//Delete A Cable Plan
if (isset($_GET["delete-cable-plan"])) {
    $msg = $controller->deleteCablePlan();
    exit();
}

//Add Notification
if (isset($_POST["add-notification"])) {
    $msg = $controller->addNotification();
}

//Delete A Notification
if (isset($_GET["delete-notification"])) {
    $msg = $controller->deleteNotification();
    exit();
}

//Update Notification Status
if (isset($_POST["update-notification-status"])) {
    $msg = $controller->updateNotificationStatus();
}

//Add NotificationCredit Debit User
if (isset($_POST["credit-debit-user"])) {
    $msg = $controller->creditDebitUser();
}

//Update Subscriber
if (isset($_POST["update-subscriber-pass"])) {
    $msg = $controller->updateSubscriberPass();
}

//Update Subscriber
if (isset($_POST["update-subscriber"])) {
    $msg = $controller->updateSubscriber();
}

//Add New Subscriber
if (isset($_POST["add-new-subscriber"])) {
    $msg = $controller->createSubscriberAccount();
}

//Update transaction Status
if (isset($_POST["update-trans-status"])) {
    $msg = $controller->updateTransactionStatus();
}

//Send Email
if (isset($_POST["send-user-email"])) {
    $msg = $controller->sendEmailToUser();
}

//Complete Alpha Order
if (isset($_GET["complete-alpha-order"])) {
    $msg = $controller->completeAlphaTopupRequest();
    exit();
}

//Fetch The View Of The Page To Be Displayed
createView($url);
if ($page == "dashboard.php") {
    createView("dashboard");
}


function createView($url)
{

    if (file_exists($url . ".php")) {
        global $title, $data, $page;
        $title = str_replace("-", " ", $url);
        $title = ucwords($title);
        $page = $url . ".php";
        $data = getDataIfAny($url);
    }
}

function getDataIfAny($page)
{
    global $urlAddon, $limit;
    $controller = new AdminController;

    switch ($page) {
        case "system-users":
            return $controller->getAccounts();
            break;

        case "airtime-discount":
            $data = array();
            $data[0] = $controller->getAirtimeDiscount();
            $data[1] = $controller->getNetworks();
            return $data;
            break;

        case "recharge-pin-discount":
            $data = array();
            $data[0] = $controller->getRechargeCardPinDiscount();
            $data[1] = $controller->getNetworks();
            return $data;
            break;

        case "data-plans":
            $data = array();
            $data[0] = $controller->getDataPlans();
            $data[1] = $controller->getNetworks();
            return $data;
            break;

        case "p2p-merchants":
            $data = array();
            $data[0] = $controller->getMerchant();
            $data[1] = $controller->getCoins();
            // $data[2] = $controller->getSubscriberByUsername();
            return $data;
            break;

        case "merchant-details":
            if (isset($_GET["mapo"])) {
                $data = array();
                $data[0] = $controller->getMerchantDetails(urldecode(base64_decode($_GET["mapo"])));
                $data[1] =  $controller->getSubscribersDetails(urldecode(base64_decode($_GET["apo"])));
                $data[2] = $controller->getCoins();
                return $data;
            } else {
                header("Location: p2p-merchants");
            }
            break;

        case "add-me-some-api":
            $data = array();
            $data[0] = $controller->getapikeys();
            return $data;
            break;

        case "data-pins":
            $data = array();
            $data[0] = $controller->getDataPins();
            $data[1] = $controller->getNetworks();
            return $data;
            break;

        case "cable-tv":
            $data = array();
            $data[0] = $controller->getCablePlans();
            $data[1] = $controller->getCableProvider();
            return $data;
            break;

        case "notifications":
            $data = array();
            $data[0] = $controller->getNotificationStatus();
            $data[1] = $controller->getNotifications();
            return $data;
            break;

        case "messages":
            return $controller->getContact();
            break;

        case "subscribers":
            return $controller->getSubscribers($limit);
            break;

        case "subscriber-details":
            if (isset($_GET["apo"])) {
                return $controller->getSubscribersDetails(urldecode(base64_decode($_GET["apo"])));
            } else {
                header("Location: subscribers");
            }
            break;

        case "transactions":
            return $controller->getTransactions($limit);
            break;

        case "transaction-details":
            return $controller->getTransactionDetails();
            break;

        case "dashboard":
            $data = array();
            $data[0] = $controller->getGeneralSiteReports();
            $data[1] = $controller->getWalletBalance();
            return $data;
            break;

        case "sale-analysis":
            return $controller->getSaleTransactions();
            break;

        case "api-setting":
            $data = array();
            $data[0] = $controller->getApiConfiguration();
            $data[1] = $controller->getApiConfigurationLinks();
            return $data;
            break;

        case "monnify-setting":
            return $controller->getApiConfiguration();
            break;

        case "paystack-setting":
            return $controller->getApiConfiguration();
            break;

        case "site-setting":
            return $controller->getSiteSettings();
            break;

        case "website-style":
            return $controller->getSiteSettings();
            break;

        case "contact-setting":
            return $controller->getSiteSettings();
            break;

        case "network-setting":
            if (!isset($_GET["network"])) {
                $_GET["network"] = "MTN";
            }
            return $controller->getNetworks();
            break;

        case "airtime-api-setting":
            if (!isset($_GET["network"])) {
                $_GET["network"] = "MTN";
            }
            $data = array();
            $data[0] = $controller->getApiConfiguration();
            $data[1] = $controller->getApiConfigurationLinks();
            return $data;
            break;

        case "data-api-setting":
            if (!isset($_GET["network"])) {
                $_GET["network"] = "MTN";
            }
            $data = array();
            $data[0] = $controller->getApiConfiguration();
            $data[1] = $controller->getApiConfigurationLinks();
            return $data;
            break;

        case "wallet-api-setting":
            $data = array();
            $data[0] = $controller->getApiConfiguration();
            $data[1] = $controller->getApiConfigurationLinks();
            return $data;
            break;

        case "credit-user":
            if (isset($_GET["apo"])) {
                return urldecode(base64_decode($_GET["apo"]));
            } else {
                header("Location: subscribers");
            }
            break;

        case "exam-pin":
            if (!isset($_GET["exam"])) {
                $_GET["exam"] = "WAEC";
            }
            return $controller->getExamPinDetails();
            break;

        case "electricity-bill":
            if (!isset($_GET["electricity"])) {
                $_GET["electricity"] = "IE";
            }
            return $controller->getElectricityBillDetails();
            break;

        case "alpha-topup":

            $data = $controller->getAlphaTopup();
            return $data;
            break;

        case "alpha-request":
            return $controller->getPendingAlphaOrder();
            break;

        default:
            return "";
    }
}

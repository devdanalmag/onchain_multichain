<?php

class AdminController extends Controller
{

	public static $role;
	public static $adminName;
	public static $adminUsername;
	public static $sysId;
	protected $model;

	//Default Constructor
	public function __construct()
	{
		if (isset($_SESSION['sysId']) && isset($_SESSION["sysRole"])) {
			if ($_SESSION['sysId'] != '' && $_SESSION["sysRole"] != '') {
				self::$role = (float) $_SESSION["sysRole"];
				self::$adminName = $_SESSION["sysName"];
				self::$adminUsername = $_SESSION["sysUser"];
				self::$sysId = $_SESSION['sysId'];

				$this->model = new AdminModel;
			} else {
				header("Location: ../");
				exit();
			}
		} else {
			header("Location: ../");
			exit();
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	// System Users Account Management
	//----------------------------------------------------------------------------------------------------------------

	//Logout Users From System
	public function logoutUser()
	{
		session_start();
		session_destroy();
		header("Location: ../");
		exit();
	}

	//Create Account For New System Users
	public function createAccount()
	{
		extract($_POST);
		$check = $this->model->createAccount($name, $username, $password, $role);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "New User Created Successfully.");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Username Already Exist, Please Try Again.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Create User, Please Try Again.");
		}
	}

	//Create Account For Subscriber
	public function createSubscriberAccount()
	{
		extract($_POST);
		$obj = new Account;
		$check = $obj->registerUser($fname, $lname, $email, $phone, $password, $state, 1, "admin", "1234");
		if ($check == 0) {
			return $this->createNotification1("alert-success", "New Subscriber Account Created Successfully.");
		} elseif ($check == 1) {
			return $this->createNotification1("alert-danger", "Email & Phone Number Already Exist.");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Email Already Exist.");
		} elseif ($check == 3) {
			return $this->createNotification1("alert-danger", "Phone Number Already Exist.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Create Subscriber Account, Please Try Again.");
		}
	}

	//Manage Account Of System Users
	public function getAccounts()
	{
		$data = $this->model->getAccounts();
		return $data;
	}

	//Get Account By ID
	public function getAccountById($id)
	{
		$data = $this->model->getAccountById($id);
		return $data;
	}

	//Update Account
	public function updateAccountStatus()
	{
		extract($_POST);
		$check = $this->model->updateAccountStatus($id, $status);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	//Update Account
	public function updateAdminAccount()
	{
		extract($_POST);
		$check = $this->model->updateAdminAccount(self::$sysId, $name, $password, $newpassword);
		if ($check == 0) {
			self::$adminName = $name;
			return $this->createNotification1("alert-info", "Account Updated Successfully");
		} elseif ($check == 1) {
			return $this->createNotification1("alert-danger", "Wrong Password, Please Try Again");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Account, Please Try Again");
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	// Subscribers
	//----------------------------------------------------------------------------------------------------------------
	//Get All Subscribers
	public function getSubscribers($limit)
	{
		$data = $this->model->getSubscribers($limit);
		return $data;
	}

	public function getSubscribersDetails($id)
	{
		$data = $this->model->getSubscribersDetails($id);
		return $data;
	}
	public function getMerchant()
	{
		$data = $this->model->getMerchant();
		return $data;
	}

	public function getMerchantDetails($id)
	{
		$data = $this->model->getMerchantDetails($id);
		return $data;
	}

	public function addMerchant()
	{
		extract($_POST);

		// Only get fields that are NOT readonly in the form:
		// bname, phone, coins[], limits[], prices[], mStatus, user

		$mphone = isset($_POST['mphone']) ? trim($_POST['mphone']) : '';
		$mUsername = isset($_POST['mUsername']) ? trim($_POST['mUsername']) : '';
		$mEmail = isset($_POST['mEmail']) ? trim($_POST['mEmail']) : '';
		$wphone = isset($_POST['mWnumber']) ? trim($_POST['mWnumber']) : '';
		$bname = isset($_POST['mBname']) ? trim($_POST['mBname']) : '';
		$coins = isset($_POST['coins']) ? $_POST['coins'] : [];
		$limits = isset($_POST['limits']) ? $_POST['limits'] : [];
		$prices = isset($_POST['prices']) ? $_POST['prices'] : [];
		$Action = isset($_POST['mAction']) ? $_POST['MAction'] : [];
		$sId = isset($_POST['sId']) ? $_POST['sId'] : '';

		// Convert arrays to comma-separated strings for storage
		$coinIds = !empty($coins) ? implode(",", $coins) : "";
		$limitArr = [];
		$priceArr = [];
		foreach ($coins as $cid) {
			$limitArr[] = isset($limits[$cid]) ? $limits[$cid] : '';
			$priceArr[] = isset($prices[$cid]) ? $prices[$cid] : '';
		}
		$limitStr = implode(",", $limitArr);
		$priceStr = implode(",", $priceArr);

		// Call model update with only editable fields
		$check = $this->model->addMerchant($sId, $mphone, $mUsername, $mEmail, $bname, $wphone, $coinIds, $limitStr, $priceStr, $Action);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Merchant Create Successfully");
		} elseif ($check == 1) {
			return $this->createNotification1("alert-danger", "Unable To Update Account, Please Try Again");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Username Already Exist, Please Try Again");
		} elseif ($check == 3) {
			return $this->createNotification1("alert-danger", "Email Already Exist, Please Try Again");
		} elseif ($check == 4) {
			return $this->createNotification1("alert-danger", "Phone Number Already Exist, Please Try Again");
		} elseif ($check == 5) {
			return $this->createNotification1("alert-danger", "Required Fields Cannot Be Empty, Please Try Again");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Account, Please Try Again");
		}
	}

	public function updateMerchant()
	{
		extract($_POST);

		// Only get fields that are NOT readonly in the form:
		// bname, phone, coins[], limits[], prices[], mStatus, user

		$bname = isset($_POST['bname']) ? trim($_POST['bname']) : '';
		$wphone = isset($_POST['wphone']) ? trim($_POST['wphone']) : '';
		$coins = isset($_POST['coins']) ? $_POST['coins'] : [];
		$limits = isset($_POST['limits']) ? $_POST['limits'] : [];
		$prices = isset($_POST['prices']) ? $_POST['prices'] : [];
		$mStatus = isset($_POST['mStatus']) ? $_POST['mStatus'] : 0;
		$user = isset($_POST['user']) ? $_POST['user'] : '';
		$Action = isset($_POST['mAction']) ? $_POST['mAction'] : 0;

		// Convert arrays to comma-separated strings for storage
		$coinIds = !empty($coins) ? implode(",", $coins) : "";
		$limitArr = [];
		$priceArr = [];
		foreach ($coins as $cid) {
			$limitArr[] = isset($limits[$cid]) ? $limits[$cid] : '';
			$priceArr[] = isset($prices[$cid]) ? $prices[$cid] : '';
		}
		$limitStr = implode(",", $limitArr);
		$priceStr = implode(",", $priceArr);

		// Call model update with only editable fields
		$check = $this->model->updateMerchant($user, $bname, $wphone, $coinIds, $limitStr, $priceStr, $mStatus, $Action);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Account Updated Successfully");
		} elseif ($check == 1) {
			return $this->createNotification1("alert-danger", "Unable To Update Account, Please Try Again");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Account, Please Try Again");
		}
	}
	public function terminateMerchant()
	{
		extract($_POST);
		$check = $this->model->terminateMerchant($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	public function getSubscriberByPhone()
	{
		extract($_POST);
		$check = $this->model->getSubscriberByPhone($phone);
		// Always return JSON string to avoid type errors with json_decode

		return json_encode($check);
		// return json_encode($check);
	}
	public function updateSubscriber()
	{
		extract($_POST);
		$check = $this->model->updateSubscriber($user, $fname, $lname, $state, $email, $phone, $accounttype, $accountstatus);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Account Updated Successfully");
		} elseif ($check == 1) {
			return $this->createNotification1("alert-danger", "Unable To Update Account, Please Try Again");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Account, Please Try Again");
		}
	}

	public function updateSubscriberPass()
	{
		extract($_POST);
		$check = $this->model->updateSubscriberPass($user, $paccess);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Account Password Updated Successfully");
		} elseif ($check == 1) {
			return $this->createNotification1("alert-danger", "Unable To Update Account Password, Please Try Again");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Account Password, Please Try Again");
		}
	}

	//Delete User Account
	public function terminateUserAccount()
	{
		extract($_POST);
		$check = $this->model->terminateUserAccount($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}



	//Change User Api Key
	public function resetAccountApiKey()
	{
		extract($_POST);
		$check = $this->model->resetAccountApiKey($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	// Exam Pin Management
	//----------------------------------------------------------------------------------------------------------------

	//Get All exam
	public function getExamPinDetails()
	{
		$data = $this->model->getExamPinDetails($_GET["exam"]);
		return $data;
	}


	public function updateExamPin()
	{
		extract($_POST);
		$check = $this->model->updateExamPin($exam, $examid, $examprice, $buying_price, $examstatus);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Exam pin Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Exam pin, Please Try Again");
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	// Electricity Management
	//----------------------------------------------------------------------------------------------------------------

	//Get All electricity
	public function getElectricityBillDetails()
	{
		$data = $this->model->getElectricityBillDetails($_GET["electricity"]);
		return $data;
	}

	public function updateElectricityBill()
	{
		extract($_POST);
		$check = $this->model->updateElectricityBill($electricity, $electricityid, $electricitystatus);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Electricity Bill Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Electricity Bill, Please Try Again");
		}
	}


	//----------------------------------------------------------------------------------------------------------------
	// Wallet Management
	//----------------------------------------------------------------------------------------------------------------

	//Credit Debit User$email,$action,$amount,$reason
	public function creditDebitUser()
	{
		extract($_POST);
		$ref = $this->generateTransactionRef();
		$check = $this->model->creditDebitUser($email, $action, $amount, $reason, $ref);
		if (is_array($check)) {
			if ($check["status"] == "success") {
				return $this->createNotification1("alert-success", $check["msg"]);
			} else {
				return $this->createNotification1("alert-danger", $check["msg"]);
			}
		} elseif ($check == 1) {
			return $this->createNotification1("alert-danger", "User Email Not Found");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Insufficent User Balance");
		} else {
			return $this->createNotification1("alert-danger", "Unexpected Error, Please Try Again Later");
		}
	}

	//Generate Transaction Reference
	public function generateTransactionRef()
	{
		$tranId = rand(1000, 9999) . time();
		return $tranId;
	}


	//----------------------------------------------------------------------------------------------------------------
	// Site Settings
	//----------------------------------------------------------------------------------------------------------------

	public function getSiteSettings()
	{
		$data = $this->model->getSiteSettings();
		return $data;
	}


	public function updateNetworkSetting()
	{
		extract($_POST);
		$check = $this->model->updateNetworkSetting($network, $general, $vtuStatus, $sharesellStatus, $airtimepin, $datapin, $sme, $gifting, $corporate, $networkid, $vtuId, $sharesellId, $smeId, $giftingId, $corporateId);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Network Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Network, Please Try Again");
		}
	}

	public function updateContactSetting()
	{
		extract($_POST);
		$check = $this->model->updateContactSetting($phone, $email, $whatsapp, $whatsappgroup, $instagram, $facebook, $twitter, $telegram);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Contact Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Contact, Please Try Again");
		}
	}

	public function updateSiteSetting()
	{
		extract($_POST);

		// Map form fields to expected model parameters
		$sitename = isset($sitename) ? $sitename : '';
		$siteurl = isset($siteurl) ? $siteurl : '';
		$apidocumentation = isset($apidocumentation) ? $apidocumentation : '';
		$blockchain = isset($blockchain) ? $blockchain : '';
		$syswallet = isset($syswallet) ? $syswallet : '';
		$refstatus = isset($refstatus) ? $refstatus : 0;
		$refundwallet = isset($refundwallet) ? $refundwallet : '';
		$errorshow = isset($errorshow) ? $errorshow : 0;
		$referalupgradebonus = isset($referalupgradebonus) ? $referalupgradebonus : 0;
		$referalairtimebonus = isset($referalairtimebonus) ? $referalairtimebonus : 0;
		$referaldatabonus = isset($referaldatabonus) ? $referaldatabonus : 0;
		$referalwalletbonus = isset($referalwalletbonus) ? $referalwalletbonus : 0;
		$referalcablebonus = isset($referalcablebonus) ? $referalcablebonus : 0;
		$referalexambonus = isset($referalexambonus) ? $referalexambonus : 0;
		$referalmeterbonus = isset($referalmeterbonus) ? $referalmeterbonus : 0;
		$wallettowalletcharges = isset($wallettowalletcharges) ? $wallettowalletcharges : 0;
		$agentupgrade = isset($agentupgrade) ? $agentupgrade : 0;
		$vendorupgrade = isset($vendorupgrade) ? $vendorupgrade : 0;
		$electricitycharges = isset($electricitycharges) ? $electricitycharges : 0;
		$airtimemin = isset($airtimemin) ? $airtimemin : 0;
		$airtimemax = isset($airtimemax) ? $airtimemax : 0;

		// Call model update with all parameters
		$check = $this->model->updateSiteSetting($sitename, $siteurl, $apidocumentation, $coingeckoapi, $toncentreapi, $blockchain, $syswallet, $refstatus, $refundwallet, $errorshow, $referalupgradebonus, $referalairtimebonus, $referaldatabonus, $referalwalletbonus, $referalcablebonus, $referalexambonus, $referalmeterbonus, $wallettowalletcharges, $agentupgrade, $vendorupgrade, $electricitycharges, $airtimemin, $airtimemax);

		if ($check == 0) {
			return $this->createNotification1("alert-success", "Details Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Details, Please Try Again");
		}
	}

	public function updateSiteStyleSetting()
	{
		extract($_POST);
		$check = $this->model->updateSiteStyleSetting($sitecolor, $loginstyle, $homestyle);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Details Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Details, Please Try Again");
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	// API Management
	//----------------------------------------------------------------------------------------------------------------


	public function getApiConfiguration()
	{
		$data = $this->model->getApiConfiguration();
		return $data;
	}

	public function getApiConfigurationLinks()
	{
		$data = $this->model->getApiConfigurationLinks();
		return $data;
	}

	public function updateApiConfiguration()
	{
		$check = $this->model->updateApiConfiguration();
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Details Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Details, Please Try Again");
		}
	}

	public function addNewApiDetails()
	{
		extract($_POST);
		$check = $this->model->addNewApiDetails($providername, $providerurl, $service, $code);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Api Details For $providername $service Added Successfully");
		} elseif ($check == 1) {
			return $this->createNotification1("alert-danger", "Invalid Access Code, Please Try Again");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Api Details Already Exist.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Add New Api, Please Try Again");
		}
	}



	//----------------------------------------------------------------------------------------------------------------
	// Email Management
	//----------------------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------------------
	// Notification Management
	//----------------------------------------------------------------------------------------------------------------

	public function getNotificationStatus()
	{
		$data = $this->model->getNotificationStatus();
		return $data;
	}

	public function sendEmailToUser()
	{
		extract($_POST);
		$check = $this->model->sendEmailToUser($subject, $email, $message);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Email Message Sent Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Send Mail, Please Try Again");
		}
	}



	public function updateNotificationStatus()
	{
		extract($_POST);
		$check = $this->model->updateNotificationStatus($notificationstatus);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Network Status Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Network Status, Please Try Again");
		}
	}

	//Get Notification
	public function getNotifications()
	{
		$data = $this->model->getNotifications();
		return $data;
	}

	//Add Notification
	public function addNotification()
	{
		extract($_POST);
		$check = $this->model->addNotification($subject, $msgfor, $message);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Notification Added Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Add Notification, Please Try Again");
		}
	}

	//Delete Notification
	public function deleteNotification()
	{
		extract($_POST);
		$check = $this->model->deleteNotification($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}



	//----------------------------------------------------------------------------------------------------------------
	// Airtime Discount Management
	//----------------------------------------------------------------------------------------------------------------

	//Get All Network
	public function getNetworks()
	{
		$data = $this->model->getNetworks();
		return $data;
	}
	public function getCoins()
	{
		$data = $this->model->getCoins();
		return $data;
	}
	//Get Airtime Discount
	public function getAirtimeDiscount()
	{
		$data = $this->model->getAirtimeDiscount();
		return $data;
	}

	//Add Airtime Discount
	public function addAirtimeDiscount()
	{
		extract($_POST);
		$check = $this->model->addAirtimeDiscount($network, $networktype, $buydiscount, $userdiscount, $agentdiscount, $vendordiscount);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Discount Added Successfully");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Discount With Same Network Id Already Exist.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Add New Discount, Please Try Again");
		}
	}

	//Update Airtime Discount
	public function updateAirtimeDiscount()
	{
		extract($_POST);
		$check = $this->model->updateAirtimeDiscount($networkid, $network, $networktype, $buydiscount, $userdiscount, $agentdiscount, $vendordiscount);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Discount Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Discount, Please Try Again");
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	//Alpha Topup Management
	//----------------------------------------------------------------------------------------------------------------

	//Get Alpha Topup
	public function getAlphaTopup()
	{
		$data = $this->model->getAlphaTopup();
		return $data;
	}

	//Add Airtime Discount
	public function addAlphaTopup()
	{
		extract($_POST);
		$check = $this->model->addAlphaTopup($bprice, $sprice, $agent, $vendor);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Alpha Topup Added Successfully");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Alpha Topup With Same value Already Exist.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Add New Alpha Topup, Please Try Again");
		}
	}

	//Update Alpha Topup
	public function updateAlphaTopup()
	{
		extract($_POST);
		$check = $this->model->updateAlphaTopup($alphaid, $buying, $selling, $agent, $vendor);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Alpha Topup Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Alpha Topup, Please Try Again");
		}
	}

	//Delete Alpha Topup
	public function deleteAlphaTopup()
	{
		extract($_POST);
		$check = $this->model->deleteAlphaTopup($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	//Get All Pending Orders
	public function getPendingAlphaOrder()
	{
		$data = $this->model->getPendingAlphaOrder();
		return $data;
	}

	//Complete Alpha Topup Request
	public function completeAlphaTopupRequest()
	{
		extract($_POST);
		$check = $this->model->completeAlphaTopupRequest($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	// Recharge Card Pin Discount Management
	//----------------------------------------------------------------------------------------------------------------


	//Get Recharge Card Pin
	public function getRechargeCardPinDiscount()
	{
		$data = $this->model->getRechargeCardPinDiscount();
		return $data;
	}

	//Add ARecharge Card Pin
	public function addRechargeCardPinDiscount()
	{
		extract($_POST);
		$check = $this->model->addRechargeCardPinDiscount($network, $userdiscount, $agentdiscount, $vendordiscount);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Discount Added Successfully");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Discount With Same Network Id Already Exist.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Add New Discount, Please Try Again");
		}
	}

	//Update Recharge Card Pin
	public function updateRechargeCardPinDiscount()
	{
		extract($_POST);
		$check = $this->model->updateRechargeCardPinDiscount($network, $userdiscount, $agentdiscount, $vendordiscount);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Discount Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Discount, Please Try Again");
		}
	}


	//----------------------------------------------------------------------------------------------------------------
	// Data Plan Management
	//----------------------------------------------------------------------------------------------------------------


	//Get Data Plan
	public function getDataPlans()
	{
		$data = $this->model->getDataPlans();
		return $data;
	}
	//Get API Setting
	public function getapikeys()
	{
		$data = $this->model->getApiConfigurationLinks();
		return $data;
	}
	//Get Data Plan
	public function getDataPins()
	{
		$data = $this->model->getDataPins();
		return $data;
	}

	//Add Data Plan
	public function addDataPlan()
	{
		extract($_POST);
		$check = $this->model->addDataPlan($network, $dataname, $datatype, $planid, $duration, $price, $userprice, $agentprice, $vendorprice);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Data Plan Added Successfully");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Plan With Same Id Already Exist.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Add New Plan, Please Try Again");
		}
	}

	//Update Data Plan
	public function updateDataPlan()
	{
		extract($_POST);
		$check = $this->model->updateDataPlan($plan, $network, $dataname, $datatype, $planid, $duration, $price, $userprice, $agentprice, $vendorprice);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Plan Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Plan, Please Try Again");
		}
	}

	public function updateApiDetails()
	{
		extract($_POST);
		$check = $this->model->updateApiDetails($apiid, $eprovidername, $eproviderurl, $eservice);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "API Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update API, Please Try Again");
		}
	}
	//Delete Data Plan
	public function deleteDataPlan()
	{
		extract($_POST);
		$check = $this->model->deleteDataPlan($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}
	public function deleteApi()
	{
		extract($_POST);
		$check = $this->model->deleteApi($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}
	//Delete Media
	public function deleteMedia()
	{
		extract($_POST);
		$check = $this->model->deleteMedia($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	//Add Data Pin
	public function addDataPin()
	{
		extract($_POST);
		$check = $this->model->addDataPin($network, $dataname, $datatype, $planid, $duration, $price, $userprice, $agentprice, $vendorprice);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Data Pin Added Successfully");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Data Pin With Same Id Already Exist.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Add New Data Pin, Please Try Again");
		}
	}

	//Update Data Pin
	public function updateDataPin()
	{
		extract($_POST);
		$check = $this->model->updateDataPin($pin, $network, $dataname, $datatype, $planid, $duration, $price, $userprice, $agentprice, $vendorprice);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Data Pin Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Data Pin, Please Try Again");
		}
	}

	//Delete Data Plan
	public function deleteDataPin()
	{
		extract($_POST);
		$check = $this->model->deleteDataPin($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}


	//----------------------------------------------------------------------------------------------------------------
	// Cable Plan Management
	//----------------------------------------------------------------------------------------------------------------

	//Get All Cable Provider
	public function getCableProvider()
	{
		$data = $this->model->getCableProvider();
		return $data;
	}

	//Get Cable Plan
	public function getCablePlans()
	{
		$data = $this->model->getCablePlans();
		return $data;
	}

	//Add Cable Plan
	public function addCablePlan()
	{
		extract($_POST);
		$check = $this->model->addCablePlan($provider, $planname, $planid, $duration, $price, $userprice, $agentprice, $vendorprice);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Cable Plan Added Successfully");
		} elseif ($check == 2) {
			return $this->createNotification1("alert-danger", "Cable With Same Id Already Exist.");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Add New Cable, Please Try Again");
		}
	}

	//Update Data Plan
	public function updateCablePlan()
	{
		extract($_POST);
		$check = $this->model->updateCablePlan($plan, $provider, $planname, $planid, $duration, $price, $userprice, $agentprice, $vendorprice);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Cable Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Cable, Please Try Again");
		}
	}


	//Delete Data Plan
	public function deleteCablePlan()
	{
		extract($_POST);
		$check = $this->model->deleteCablePlan($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	//Transactions Management
	//----------------------------------------------------------------------------------------------------------------
	//Get All Transactions
	public function getTransactions($limit)
	{
		$data = $this->model->getTransactions($limit);
		return $data;
	}

	//Get Transaction Details
	public function getTransactionDetails()
	{
		if (!isset($_GET["ref"])) {
			header("Location: ./");
			exit();
		}
		$data = $this->model->getTransactionDetails($_GET["ref"]);
		return $data;
	}

	//Update Transaction Status
	public function updateTransactionStatus()
	{
		extract($_POST);
		$check = $this->model->updateTransactionStatus($user, $trans, $transstatus, $amount);
		if ($check == 0) {
			return $this->createNotification1("alert-success", "Transaction Status Updated Successfully");
		} else {
			return $this->createNotification1("alert-danger", "Unable To Update Status, Please Try Again");
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	//Sale Transactions Management
	//----------------------------------------------------------------------------------------------------------------

	//Get All Transactions
	public function getSaleTransactions()
	{
		//Get Transactions
		$service = "All";
		$datefrom = date("Y-m-d 00:00:00");
		$dateto = date("Y-m-d H:i:s");


		if (isset($_POST["filterSalesResult"])) {

			$datefrom = date("Y-m-d H:i:s", strtotime($_POST["datefrom"]));
			$dateto = date("Y-m-d H:i:s", strtotime($_POST["dateto"]));

			$displaydatefrom = date("jS F Y H:iA", strtotime($datefrom));
			$dispalydateto = date("jS F Y H:iA", strtotime($dateto));


			if ($_POST["service"] == "Airtime") {
				$data = $this->model->getSaleTransactions("Airtime", $datefrom, $dateto);
				return $this->getAirtimeSalesAnalysis($data, $displaydatefrom, $dispalydateto);
			} elseif ($_POST["service"] == "Data") {
				$data = $this->model->getSaleTransactions("Data", $datefrom, $dateto);
				return $this->getDataSalesAnalysis($data, $displaydatefrom, $dispalydateto);
			} else {
				$data = $this->model->getSaleTransactions($service, $datefrom, $dateto);
				return $this->getGeneralSalesAnalysis($data, $displaydatefrom, $dispalydateto);
			}
		} else {

			$displaydatefrom = date("jS F Y H:iA", strtotime($datefrom));
			$dispalydateto = date("jS F Y H:iA", strtotime($dateto));

			$data = $this->model->getSaleTransactions($service, $datefrom, $dateto);
			return $this->getGeneralSalesAnalysis($data, $displaydatefrom, $dispalydateto);
		}
	}

	//Get General Sale Analysis
	public function getGeneralSalesAnalysis($data, $datefrom, $dateto)
	{

		//Assign Varables To Use For Analysis
		$analysis = array(
			"service" => "general",
			"datefrom" => $datefrom,
			"dateto" => $dateto,
			"transactions" => 0,
			"sales" => 0,
			"profit" => 0,
			"successful" => 0,
			"failed" => 0,
			"airtimeTransactions" => 0,
			"airtimeSales" => 0,
			"airtimeProfit" => 0,
			"dataTransactions" => 0,
			"dataSales" => 0,
			"dataProfit" => 0,
			"dataPinTransactions" => 0,
			"dataPinSales" => 0,
			"dataPinProfit" => 0,
			"cableTransactions" => 0,
			"cableSales" => 0,
			"cableProfit" => 0,
			"electricityTransactions" => 0,
			"electricitySales" => 0,
			"electricityProfit" => 0,
			"examTransactions" => 0,
			"examSales" => 0,
			"examProfit" => 0
		);

		//Compute Sale Analysis
		foreach ($data as $sales) {

			if ($sales->status == 0) {
				$analysis["transactions"]++;
				$analysis["sales"] += (float) $sales->amount;
				$analysis["profit"] += (float) $sales->profit;
			}

			if ($sales->status == 0) {
				$analysis["successful"]++;
			}
			if ($sales->status == 1) {
				$analysis["failed"]++;
			}

			if ($sales->servicename == "Airtime" && $sales->status == 0) {
				$analysis["airtimeTransactions"]++;
				$analysis["airtimeSales"] += (float) $sales->amount;
				$analysis["airtimeProfit"] += (float) $sales->profit;
			}

			if ($sales->servicename == "Data" && $sales->status == 0) {
				$analysis["dataTransactions"]++;
				$analysis["dataSales"] += (float) $sales->amount;
				$analysis["dataProfit"] += (float) $sales->profit;
			}

			if ($sales->servicename == "Data Pin" && $sales->status == 0) {
				$analysis["dataPinTransactions"]++;
				$analysis["dataPinSales"] += (float) $sales->amount;
				$analysis["dataPinProfit"] += (float) $sales->profit;
			}

			if ($sales->servicename == "Cable TV" && $sales->status == 0) {
				$analysis["cableTransactions"]++;
				$analysis["cableSales"] += (float) $sales->amount;
				$analysis["cableProfit"] += (float) $sales->profit;
			}

			if ($sales->servicename == "Electricity Bill" && $sales->status == 0) {
				$analysis["electricityTransactions"]++;
				$analysis["electricitySales"] += (float) $sales->amount;
				$analysis["electricityProfit"] += (float) $sales->profit;
			}

			if ($sales->servicename == "Exam Pin" && $sales->status == 0) {
				$analysis["examTransactions"]++;
				$analysis["examSales"] += (float) $sales->amount;
				$analysis["examProfit"] += (float) $sales->profit;
			}
		}

		//Format Sales Analysis
		$analysis["sales"] = number_format($analysis["sales"], 2);
		$analysis["profit"] = number_format($analysis["profit"], 2);
		$analysis["airtimeSales"] = number_format($analysis["airtimeSales"], 2);
		$analysis["airtimeProfit"] = number_format($analysis["airtimeProfit"], 2);
		$analysis["dataSales"] = number_format($analysis["dataSales"], 2);
		$analysis["dataProfit"] = number_format($analysis["dataProfit"], 2);
		$analysis["dataPinSales"] = number_format($analysis["dataPinSales"], 2);
		$analysis["dataPinProfit"] = number_format($analysis["dataPinProfit"], 2);
		$analysis["cableSales"] = number_format($analysis["cableSales"], 2);
		$analysis["cableProfit"] = number_format($analysis["cableProfit"], 2);
		$analysis["electricitySales"] = number_format($analysis["electricitySales"], 2);
		$analysis["electricityProfit"] = number_format($analysis["electricityProfit"], 2);
		$analysis["examSales"] = number_format($analysis["examSales"], 2);
		$analysis["examProfit"] = number_format($analysis["examProfit"], 2);


		return $analysis;
	}

	//Get GenerAirtimeal Sale Analysis
	public function getAirtimeSalesAnalysis($data, $datefrom, $dateto)
	{

		//Assign Varables To Use For Analysis
		$analysis = array(
			"service" => "airtime",
			"datefrom" => $datefrom,
			"dateto" => $dateto,
			"transactions" => 0,
			"sales" => 0,
			"profit" => 0,
			"successful" => 0,
			"failed" => 0,
			"mtnTransactions" => 0,
			"mtnSales" => 0,
			"mtnProfit" => 0,
			"airtelTransactions" => 0,
			"airtelSales" => 0,
			"airtelProfit" => 0,
			"gloTransactions" => 0,
			"gloSales" => 0,
			"gloProfit" => 0,
			"9mobileTransactions" => 0,
			"9mobileSales" => 0,
			"9mobileProfit" => 0
		);

		//Compute Sale Analysis
		foreach ($data as $sales) {

			if ($sales->status == 0) {
				$analysis["transactions"]++;
				$analysis["sales"] += (float) $sales->amount;
				$analysis["profit"] += (float) $sales->profit;
			}

			if ($sales->status == 0) {
				$analysis["successful"]++;
			}
			if ($sales->status == 1) {
				$analysis["failed"]++;
			}

			if (strpos($sales->servicedesc, "MTN") !== false && $sales->status == 0) {
				$analysis["mtnTransactions"]++;
				$analysis["mtnSales"] += (float) $sales->amount;
				$analysis["mtnProfit"] += (float) $sales->profit;
			}

			if (strpos($sales->servicedesc, "AIRTEL") !== false && $sales->status == 0) {
				$analysis["airtelTransactions"]++;
				$analysis["airtelSales"] += (float) $sales->amount;
				$analysis["airtelProfit"] += (float) $sales->profit;
			}

			if (strpos($sales->servicedesc, "GLO") !== false && $sales->status == 0) {
				$analysis["gloTransactions"]++;
				$analysis["gloSales"] += (float) $sales->amount;
				$analysis["gloProfit"] += (float) $sales->profit;
			}

			if (strpos($sales->servicedesc, "(9MOBILE)") !== false && $sales->status == 0) {
				$analysis["9mobileTransactions"]++;
				$analysis["9mobileSales"] += (float) $sales->amount;
				$analysis["9mobileProfit"] += (float) $sales->profit;
			}
		}

		//Format Sales Analysis
		$analysis["sales"] = number_format($analysis["sales"], 2);
		$analysis["profit"] = number_format($analysis["profit"], 2);
		$analysis["mtnSales"] = number_format($analysis["mtnSales"], 2);
		$analysis["mtnProfit"] = number_format($analysis["mtnProfit"], 2);
		$analysis["airtelSales"] = number_format($analysis["airtelSales"], 2);
		$analysis["airtelProfit"] = number_format($analysis["airtelProfit"], 2);
		$analysis["gloSales"] = number_format($analysis["gloSales"], 2);
		$analysis["gloProfit"] = number_format($analysis["gloProfit"], 2);
		$analysis["9mobileSales"] = number_format($analysis["9mobileSales"], 2);
		$analysis["9mobileProfit"] = number_format($analysis["9mobileProfit"], 2);


		return $analysis;
	}

	//Get Data Sale Analysis
	public function getDataSalesAnalysis($data, $datefrom, $dateto)
	{

		//Assign Varables To Use For Analysis
		$analysis = array(
			"service" => "data",
			"datefrom" => $datefrom,
			"dateto" => $dateto,
			"transactions" => 0,
			"sales" => 0,
			"profit" => 0,
			"successful" => 0,
			"failed" => 0,
			"mtnTransactions" => 0,
			"mtnSales" => 0,
			"mtnProfit" => 0,
			"airtelTransactions" => 0,
			"airtelSales" => 0,
			"airtelProfit" => 0,
			"gloTransactions" => 0,
			"gloSales" => 0,
			"gloProfit" => 0,
			"9mobileTransactions" => 0,
			"9mobileSales" => 0,
			"9mobileProfit" => 0
		);

		//Compute Sale Analysis
		foreach ($data as $sales) {

			if ($sales->status == 0) {
				$analysis["transactions"]++;
				$analysis["sales"] += (float) $sales->amount;
				$analysis["profit"] += (float) $sales->profit;
			}

			if ($sales->status == 0) {
				$analysis["successful"]++;
			}
			if ($sales->status == 1) {
				$analysis["failed"]++;
			}

			if (strpos($sales->servicedesc, "MTN") !== false && $sales->status == 0) {
				$analysis["mtnTransactions"]++;
				$analysis["mtnSales"] += (float) $sales->amount;
				$analysis["mtnProfit"] += (float) $sales->profit;
			}

			if (strpos($sales->servicedesc, "AIRTEL") !== false && $sales->status == 0) {
				$analysis["airtelTransactions"]++;
				$analysis["airtelSales"] += (float) $sales->amount;
				$analysis["airtelProfit"] += (float) $sales->profit;
			}

			if (strpos($sales->servicedesc, "GLO") !== false && $sales->status == 0) {
				$analysis["gloTransactions"]++;
				$analysis["gloSales"] += (float) $sales->amount;
				$analysis["gloProfit"] += (float) $sales->profit;
			}

			if (strpos($sales->servicedesc, "(9MOBILE)") !== false && $sales->status == 0) {
				$analysis["9mobileTransactions"]++;
				$analysis["9mobileSales"] += (float) $sales->amount;
				$analysis["9mobileProfit"] += (float) $sales->profit;
			}
		}

		//Format Sales Analysis
		$analysis["sales"] = number_format($analysis["sales"], 2);
		$analysis["profit"] = number_format($analysis["profit"], 2);
		$analysis["mtnSales"] = number_format($analysis["mtnSales"], 2);
		$analysis["mtnProfit"] = number_format($analysis["mtnProfit"], 2);
		$analysis["airtelSales"] = number_format($analysis["airtelSales"], 2);
		$analysis["airtelProfit"] = number_format($analysis["airtelProfit"], 2);
		$analysis["gloSales"] = number_format($analysis["gloSales"], 2);
		$analysis["gloProfit"] = number_format($analysis["gloProfit"], 2);
		$analysis["9mobileSales"] = number_format($analysis["9mobileSales"], 2);
		$analysis["9mobileProfit"] = number_format($analysis["9mobileProfit"], 2);


		return $analysis;
	}

	//----------------------------------------------------------------------------------------------------------------
	// Contact
	//----------------------------------------------------------------------------------------------------------------


	//Get Contact Message
	public function getContact()
	{
		$data = $this->model->getContact();
		return $data;
	}

	//Delete Message
	public function deleteContact()
	{
		extract($_POST);
		$check = $this->model->deleteContact($id);
		if ($check == 0) {
			return 0;
		} else {
			return 1;
		}
	}

	//Format Description
	public function formatDescription($data)
	{
		$data = str_replace("\n\r", "<br/>", $data);
		return $data;
	}

	public function formatStatus($value)
	{
		$value = (float) $value;
		$output = "";
		if ($value == 0) {
			$output = "<b class='text-success'>Active</b>";
		}
		if ($value == 1) {
			$output = "<b class='text-danger'>Blocked</b>";
		}
		if ($value == 2) {
			$output = "<b class='text-danger'>Pending Verification</b>";
		}
		if ($value == 3) {
			$output = "<b class='text-warning'>Pending Email Verification</b>";
		}
		return $output;
	}

	public function formatTransStatus($value)
	{
		$value = (float) $value;
		$output = "";
		if ($value == 0) {
			$output = "<b class='text-success'>Success</b>";
		} elseif ($value == 5) {
			$output = "<b class='text-success'>Processing</b>";
		} elseif ($value == 9) {
			$output = "<b class='text-success'>Refunded</b>";
		} else {
			$output = "<b class='text-danger'>Failed</b>";
		}
		return $output;
	}

	//Get Site Statistics
	public function getGeneralSiteReports()
	{
		$data = $this->model->getGeneralSiteReports();
		return $data;
	}

	//Get Site Wallet Balance
	public function getWalletBalance()
	{
		$model = new WalletBalance();
		$data = array();

		$walletOne = $model->getWalletBalance("one");
		$walletTwo = $model->getWalletBalance("two");
		$walletThree = $model->getWalletBalance("three");

		$data["walletOneBalance"] = $walletOne["balance"];
		$data["walletOneProvider"] = $walletOne["provider"];

		$data["walletTwoBalance"] = $walletTwo["balance"];
		$data["walletTwoProvider"] = $walletTwo["provider"];

		$data["walletThreeBalance"] = $walletThree["balance"];
		$data["walletThreeProvider"] = $walletThree["provider"];

		return $data;
	}
}

<?php

class AdminModel extends Model
{

	//----------------------------------------------------------------------------------------------------------------
	// System Users Account Management
	//----------------------------------------------------------------------------------------------------------------

	//Create New System User Account
	public function createAccount($name, $username, $key, $role)
	{
		$dbh = self::connect();
		$role = (float) $role;

		//Check If Username Already Exist
		$queryC = $dbh->prepare("SELECT sysId FROM sysusers WHERE sysUsername=:username");
		$queryC->bindParam(':username', $username, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 2;
		}

		//If Not Exist, Create New User
		$sql = "INSERT INTO  sysusers(sysName,sysUsername,sysToken,sysRole) VALUES(:name,:username,:key,:role)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':name', $name, PDO::PARAM_STR);
		$query->bindParam(':username', $username, PDO::PARAM_STR);
		$query->bindParam(':key', $key, PDO::PARAM_STR);
		$query->bindParam(':role', $role, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			return 0;
		} else {
			return 1;
		}
	}

	//Get All Account Details
	public function getAccounts()
	{
		$dbh = self::connect();
		$sql = "SELECT * from sysusers";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $results;
		} else {
			return 1;
		}
	}

	//Get Account Details By ID
	public function getAccountById($id)
	{
		$id = (float) $id;
		$dbh = self::connect();
		$sql = "SELECT * FROM sysusers WHERE sysId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $result;
		} else {
			return 1;
		}
	}

	//Update User Account By ID
	public function updateAccountStatus($id, $status)
	{
		$id = (float) $id;
		$status = (float) $status;
		if ($status == 1) {
			$status = 0;
		} else {
			$status = 1;
		}

		$dbh = self::connect();
		$sql = "UPDATE sysusers SET sysStatus=$status WHERE sysId=$id ";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}

	//Update Admin Profile Password
	public function updateAdminAccount($id, $name, $oldKey, $newKey)
	{

		$dbh = self::connect();
		$id = (float) $id;

		if ($newKey == "") {
			$newKey = $oldKey;
		}

		$c = "SELECT sysToken FROM sysusers WHERE sysToken=:p AND sysId=$id";
		$queryC = $dbh->prepare($c);
		$queryC->bindParam(':p', $oldKey, PDO::PARAM_STR);
		$queryC->execute();
		$result = $queryC->fetch(PDO::FETCH_ASSOC);

		if ($queryC->rowCount() > 0) {

			$sql = "UPDATE sysusers SET sysToken=:p,sysName=:name WHERE sysId=$id";
			$query = $dbh->prepare($sql);
			$query->bindParam(':p', $newKey, PDO::PARAM_STR);
			$query->bindParam(':name', $name, PDO::PARAM_STR);
			$query->execute();
			$_SESSION["sysName"] = $name;
			return 0;
		} else {
			return 1;
		}
	}


	//----------------------------------------------------------------------------------------------------------------
	//	Site Settings
	//----------------------------------------------------------------------------------------------------------------

	//Get Site Setting
	public function getSiteSettings()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM sitesettings WHERE sId=1";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_OBJ);
		return $results;
	}

	//Update Contact Setting
	public function updateContactSetting($phone, $email, $whatsapp, $whatsappgroup, $instagram, $facebook, $twitter, $telegram)
	{
		$dbh = self::connect();
		$sql = "UPDATE sitesettings SET phone=:p,email=:e,whatsapp=:w,whatsappgroup=:wg,instagram=:ig,facebook=:fb,twitter=:t,telegram=:te WHERE sId=1";
		$query = $dbh->prepare($sql);
		$query->bindParam(':p', $phone, PDO::PARAM_STR);
		$query->bindParam(':e', $email, PDO::PARAM_STR);
		$query->bindParam(':w', $whatsapp, PDO::PARAM_STR);
		$query->bindParam(':wg', $whatsappgroup, PDO::PARAM_STR);
		$query->bindParam(':ig', $instagram, PDO::PARAM_STR);
		$query->bindParam(':fb', $facebook, PDO::PARAM_STR);
		$query->bindParam(':t', $twitter, PDO::PARAM_STR);
		$query->bindParam(':te', $telegram, PDO::PARAM_STR);
		$query->execute();
		return 0;
	}

	//Update Site Setting
	public function updateSiteSetting($sitename, $siteurl, $apidocumentation, $coingeckoapi, $blockchain, $walletname, $refundstatus, $refundaddress, $errorStatus, $referalupgradebonus, $referalairtimebonus, $referaldatabonus, $referalwalletbonus, $referalcablebonus, $referalexambonus, $referalmeterbonus, $wallettowalletcharges, $agentupgrade, $vendorupgrade, $electricitycharges, $airtimemin, $airtimemax)
	{
		$dbh = self::connect();
		$sql = "UPDATE sitesettings SET 
			sitename=:sn,
			siteurl=:u,
			agentupgrade=:au,
			vendorupgrade=:vu,
			apidocumentation=:ad,
			blockchain=:bc,
			walletname=:wname,
			refundstatus=:rstatus,
			refundaddress=:raddr,
			errorStatus=:es,
			referalupgradebonus=:rub,
			referalairtimebonus=:rab,
			referaldatabonus=:rdb,
			referalwalletbonus=:rwb,
			referalcablebonus=:rcb,
			referalexambonus=:reb,
			referalmeterbonus=:rmb,
			wallettowalletcharges=:wwc,
			electricitycharges=:electc,
			coingeckoapikey=:geckokey,
			airtimemin=:amin,
			airtimemax=:amax
		WHERE sId=1";
		$query = $dbh->prepare($sql);
		$query->bindParam(':sn', $sitename, PDO::PARAM_STR);
		$query->bindParam(':u', $siteurl, PDO::PARAM_STR);
		$query->bindParam(':au', $agentupgrade, PDO::PARAM_STR);
		$query->bindParam(':vu', $vendorupgrade, PDO::PARAM_STR);
		$query->bindParam(':ad', $apidocumentation, PDO::PARAM_STR);
		$query->bindParam(':bc', $blockchain, PDO::PARAM_STR);
		$query->bindParam(':wname', $walletname, PDO::PARAM_STR);
		$query->bindParam(':rstatus', $refundstatus, PDO::PARAM_STR);
		$query->bindParam(':raddr', $refundaddress, PDO::PARAM_STR);
		$query->bindParam(':es', $errorStatus, PDO::PARAM_STR);
		$query->bindParam(':rub', $referalupgradebonus, PDO::PARAM_STR);
		$query->bindParam(':rab', $referalairtimebonus, PDO::PARAM_STR);
		$query->bindParam(':rdb', $referaldatabonus, PDO::PARAM_STR);
		$query->bindParam(':rwb', $referalwalletbonus, PDO::PARAM_STR);
		$query->bindParam(':rcb', $referalcablebonus, PDO::PARAM_STR);
		$query->bindParam(':reb', $referalexambonus, PDO::PARAM_STR);
		$query->bindParam(':rmb', $referalmeterbonus, PDO::PARAM_STR);
		$query->bindParam(':wwc', $wallettowalletcharges, PDO::PARAM_STR);
		$query->bindParam(':electc', $electricitycharges, PDO::PARAM_STR);
		$query->bindParam(':geckokey', $coingeckoapi, PDO::PARAM_STR);
		$query->bindParam(':amin', $airtimemin, PDO::PARAM_STR);
		$query->bindParam(':amax', $airtimemax, PDO::PARAM_STR);
		$query->execute();
		return 0;
	}

	//Update Site Style
	public function updateSiteStyleSetting($sitecolor, $loginstyle, $homestyle)
	{
		$dbh = self::connect();
		$sql = "UPDATE sitesettings SET sitecolor=:sc,logindesign=:ls,homedesign=:hs WHERE sId=1";
		$query = $dbh->prepare($sql);
		$query->bindParam(':sc', $sitecolor, PDO::PARAM_STR);
		$query->bindParam(':ls', $loginstyle, PDO::PARAM_STR);
		$query->bindParam(':hs', $homestyle, PDO::PARAM_STR);
		$query->execute();
		return 0;
	}

	//Update Network Setting
	public function updateNetworkSetting($network, $general, $vtuStatus, $sharesellStatus, $airtimepin, $datapin, $sme, $gifting, $corporate, $networkid, $vtuId, $sharesellId, $smeId, $giftingId, $corporateId)
	{
		$dbh = self::connect();
		$id = (float) $network;

		$sql = "UPDATE networkid SET networkStatus=:g, vtuStatus=:vs, sharesellStatus=:sss, airtimepinStatus=:ap, datapinStatus=:dp, smeStatus=:s, giftingStatus=:gi, corporateStatus=:c, networkId=:nid, vtuId=:vtuid, sharesellId=:sharesellid,smeId=:smeid,giftingId=:giftid,corporateId=:ccid WHERE nId = $id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':g', $general, PDO::PARAM_STR);
		$query->bindParam(':vs', $vtuStatus, PDO::PARAM_STR);
		$query->bindParam(':sss', $sharesellStatus, PDO::PARAM_STR);
		$query->bindParam(':ap', $airtimepin, PDO::PARAM_STR);
		$query->bindParam(':dp', $datapin, PDO::PARAM_STR);
		$query->bindParam(':s', $sme, PDO::PARAM_STR);
		$query->bindParam(':gi', $gifting, PDO::PARAM_STR);
		$query->bindParam(':c', $corporate, PDO::PARAM_STR);
		$query->bindParam(':nid', $networkid, PDO::PARAM_STR);
		$query->bindParam(':vtuid', $vtuId, PDO::PARAM_STR);
		$query->bindParam(':sharesellid', $sharesellId, PDO::PARAM_STR);
		$query->bindParam(':smeid', $smeId, PDO::PARAM_STR);
		$query->bindParam(':ccid', $corporateId, PDO::PARAM_STR);
		$query->bindParam(':giftid', $giftingId, PDO::PARAM_STR);
		$query->execute();

		return 0;
	}

	//----------------------------------------------------------------------------------------------------------------
	//	API Management
	//----------------------------------------------------------------------------------------------------------------
	//Get API Setting
	public function getApiConfiguration()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM apiconfigs";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	//Get API Link Setting
	public function getApiConfigurationLinks()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM apilinks";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	//Update API Setting
	public function updateApiConfiguration()
	{
		$dbh = self::connect();
		$count = COUNT($_POST);

		if ($count > 0) {

			foreach ($_POST as $index => $value) {
				$sql = "UPDATE apiconfigs SET value=:d WHERE name=:n";
				$query = $dbh->prepare($sql);
				$query->bindParam(':n', $index, PDO::PARAM_STR);
				$query->bindParam(':d', $value, PDO::PARAM_STR);
				$query->execute();
			}

			return 0;
		} else {
			return 1;
		}
	}

	//Add Notification
	public function addNewApiDetails($providername, $providerurl, $service, $code)
	{
		$dbh = self::connect();
		$coder = date("Hymd") . date("d");

		if ($coder <> $code) {
			return 1;
		}

		$c = "SELECT * FROM apilinks WHERE value=:v AND type=:t";
		$queryC = $dbh->prepare($c);
		$queryC->bindParam(':v', $providerurl, PDO::PARAM_STR);
		$queryC->bindParam(':t', $service, PDO::PARAM_STR);
		$queryC->execute();

		if ($queryC->rowCount() > 0) {
			return 2;
		} else {
			$sql = "INSERT INTO apilinks (`name`,`value`,`type`) VALUES (:n,:v, :t)";
			$query = $dbh->prepare($sql);
			$query->bindParam(':n', $providername, PDO::PARAM_STR);
			$query->bindParam(':v', $providerurl, PDO::PARAM_STR);
			$query->bindParam(':t', $service, PDO::PARAM_STR);
			$query->execute();
			$lastInsertId = $dbh->lastInsertId();
			if ($lastInsertId) {
				return 0;
			} else {
				return 3;
			}
		}
	}



	//----------------------------------------------------------------------------------------------------------------
	//	Notification Management
	//----------------------------------------------------------------------------------------------------------------

	//Send Email To User
	public function sendEmailToUser($subject, $email, $message)
	{
		$subject = $subject . " (" . $this->sitename . ")";
		self::sendMail($email, $subject, $message);
		return 0;
	}

	//----------------------------------------------------------------------------------------------------------------
	//	Notification Management
	//----------------------------------------------------------------------------------------------------------------
	//Get Notification Status
	public function getNotificationStatus()
	{
		$dbh = self::connect();
		$sql = "SELECT notificationStatus FROM sitesettings WHERE sId=1";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_OBJ);
		return $results;
	}

	//Update Notification Status
	public function updateNotificationStatus($notificationstatus)
	{
		$dbh = self::connect();
		$sql = "UPDATE sitesettings SET notificationStatus=:s WHERE sId=1";
		$query = $dbh->prepare($sql);
		$query->bindParam(':s', $notificationstatus, PDO::PARAM_STR);
		$query->execute();
		return 0;
	}

	//Get API Notification
	public function getNotifications()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM notifications";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	//Add Notification
	public function addNotification($subject, $msgfor, $message)
	{
		$dbh = self::connect();
		$sql = "INSERT INTO notifications SET subject=:s,msgfor=:f,message=:m";
		$query = $dbh->prepare($sql);
		$query->bindParam(':s', $subject, PDO::PARAM_STR);
		$query->bindParam(':f', $msgfor, PDO::PARAM_INT);
		$query->bindParam(':m', $message, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			return 0;
		} else {
			return 1;
		}
	}

	///Delete Notification
	public function deleteNotification($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM notifications WHERE msgId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}

	//----------------------------------------------------------------------------------------------------------------
	//	Airtime Discount Management
	//----------------------------------------------------------------------------------------------------------------

	//Get All Network
	public function getNetworks()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM networkid ORDER BY nId ASC";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	public function getCoins()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM p2pcoins ORDER BY cId ASC";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}
	//Get Airtime Discount
	public function getAirtimeDiscount()
	{
		$dbh = self::connect();
		$sql = "SELECT a.*,b.network,b.nId FROM airtime a, networkid b WHERE a.aNetwork=b.nId";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}




	//Add Airtime Discount
	public function addAirtimeDiscount($network, $networktype, $buydiscount, $userdiscount, $agentdiscount, $vendordiscount)
	{
		$dbh = self::connect();

		//Check If Discount Already Exist
		$queryC = $dbh->prepare("SELECT aNetwork FROM airtime WHERE aNetwork=:n");
		$queryC->bindParam(':n', $network, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 2;
		}

		//If Not Exist, Create New Discount
		$sql = "INSERT INTO airtime(aNetwork,aType,aBuyDiscount,aUserDiscount,aAgentDiscount,aVendorDiscount) VALUES(:n,:ny,:b,:u,:a,:v)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':n', $network, PDO::PARAM_STR);
		$query->bindParam(':nt', $networktype, PDO::PARAM_STR);
		$query->bindParam(':b', $buydiscount, PDO::PARAM_STR);
		$query->bindParam(':u', $userdiscount, PDO::PARAM_STR);
		$query->bindParam(':a', $agentdiscount, PDO::PARAM_STR);
		$query->bindParam(':v', $vendordiscount, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			return 0;
		} else {
			return 1;
		}
	}

	//Update Airtime Discount
	public function updateAirtimeDiscount($id, $network, $networktype, $buydiscount, $userdiscount, $agentdiscount, $vendordiscount)
	{
		$dbh = self::connect();
		$id = (int) base64_decode($id);
		$sql = "UPDATE airtime SET aNetwork=:n,aType=:nt,aBuyDiscount=:b,aUserDiscount=:u,aAgentDiscount=:a,aVendorDiscount=:v WHERE aId=$id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':n', $network, PDO::PARAM_STR);
		$query->bindParam(':nt', $networktype, PDO::PARAM_STR);
		$query->bindParam(':b', $buydiscount, PDO::PARAM_STR);
		$query->bindParam(':u', $userdiscount, PDO::PARAM_STR);
		$query->bindParam(':a', $agentdiscount, PDO::PARAM_STR);
		$query->bindParam(':v', $vendordiscount, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	// Alpha Topup Management
	//----------------------------------------------------------------------------------------------------------------

	//Add Alpha Topup
	public function addAlphaTopup($buying, $selling, $agent, $vendor)
	{
		$dbh = self::connect();

		//Check If Topup Already Exist
		$queryC = $dbh->prepare("SELECT * FROM alphatopupprice WHERE buyingPrice=:bn AND sellingPrice=:sn");
		$queryC->bindParam(':bn', $buying, PDO::PARAM_STR);
		$queryC->bindParam(':sn', $selling, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 2;
		}

		//If Not Exist, Create New Discount
		$sql = "INSERT INTO alphatopupprice(buyingPrice,SellingPrice,agent,vendor) VALUES(:b,:s,:a,:v)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':b', $buying, PDO::PARAM_STR);
		$query->bindParam(':s', $selling, PDO::PARAM_STR);
		$query->bindParam(':a', $agent, PDO::PARAM_STR);
		$query->bindParam(':v', $vendor, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			return 0;
		} else {
			return 1;
		}
	}

	//Update Alpha Topup
	public function updateAlphaTopup($id, $buying, $selling, $agent, $vendor)
	{
		$dbh = self::connect();
		$id = (int) base64_decode($id);
		$sql = "UPDATE alphatopupprice SET buyingPrice=:bp,sellingPrice=:sp,agent=:a,vendor=:v WHERE alphaId=$id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':bp', $buying, PDO::PARAM_INT);
		$query->bindParam(':sp', $selling, PDO::PARAM_INT);
		$query->bindParam(':a', $agent, PDO::PARAM_STR);
		$query->bindParam(':v', $vendor, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}

	///Delete A Data Plan
	public function deleteAlphaTopup($id)
	{
		$dbh = self::connect();
		$id = (int) base64_decode($id);
		$sql = "DELETE FROM alphatopupprice WHERE alphaId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}


	//Get Alpha Topup
	public function getAlphaTopup()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM alphatopupprice";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	//Get All Pending Alpha Transactions
	public function getPendingAlphaOrder()
	{
		$dbh = self::connect();
		$sql = "SELECT a.sFname,a.sPhone,a.sEmail,a.sType,b.* 
			FROM subscribers a, transactions b WHERE a.sId=b.sId AND b.status=2 ORDER BY b.date DESC";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	//Complete Alpha Topup Request
	public function completeAlphaTopupRequest($id)
	{
		$dbh = self::connect();
		$sql = "UPDATE transactions SET status = 0 WHERE tId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}

	//----------------------------------------------------------------------------------------------------------------
	//	Recharge Card Pin Discount Management
	//----------------------------------------------------------------------------------------------------------------

	//Get Recharge Card Pin Discount
	public function getRechargeCardPinDiscount()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM airtimepinprice a, networkid b WHERE a.aNetwork=b.networkid";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}


	//Add Recharge Card Pin Discount
	public function addRechargeCardPinDiscount($network, $userdiscount, $agentdiscount, $vendordiscount)
	{
		$dbh = self::connect();

		//Check If Discount Already Exist
		$queryC = $dbh->prepare("SELECT aNetwork FROM airtimepinprice WHERE aNetwork=:n");
		$queryC->bindParam(':n', $network, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 2;
		}

		//If Not Exist, Create New Discount
		$sql = "INSERT INTO airtimepinprice (aNetwork,aUserDiscount,aAgentDiscount,aVendorDiscount) VALUES(:n,:u,:a,:v)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':n', $network, PDO::PARAM_STR);
		$query->bindParam(':u', $userdiscount, PDO::PARAM_STR);
		$query->bindParam(':a', $agentdiscount, PDO::PARAM_STR);
		$query->bindParam(':v', $vendordiscount, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			return 0;
		} else {
			return 1;
		}
	}


	//Update Recharge Card Pin Discount
	public function updateRechargeCardPinDiscount($network, $userdiscount, $agentdiscount, $vendordiscount)
	{
		$dbh = self::connect();
		$sql = "UPDATE airtimepinprice SET aUserDiscount=:u,aAgentDiscount=:a,aVendorDiscount=:v WHERE aNetwork=:n";
		$query = $dbh->prepare($sql);
		$query->bindParam(':n', $network, PDO::PARAM_STR);
		$query->bindParam(':u', $userdiscount, PDO::PARAM_STR);
		$query->bindParam(':a', $agentdiscount, PDO::PARAM_STR);
		$query->bindParam(':v', $vendordiscount, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	//	Data Plan Management
	//----------------------------------------------------------------------------------------------------------------


	//Get Data Plans
	public function getDataPlans()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM dataplans a, networkid b WHERE a.datanetwork=b.nId";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	public function getMerchant()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM p2pmerchants ORDER BY mId ASC";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	public function getMerchantDetails($id)
	{
		$dbh = self::connect();

		$sql = "SELECT * FROM p2pmerchants WHERE mId = :id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_OBJ);
		return $results;
	}


	public function terminateMerchant($id)
	{
		$id = (float) base64_decode($id);
		$dbh = self::connect();

		//Delete All Transactions
		$sql = "DELETE FROM p2pmerchants WHERE mId=$id ";
		$query = $dbh->prepare($sql);
		$query->execute();

		return 0;
	}

	public function getSubscriberByPhone($phone)
	{
		$dbh = self::connect();
		$sql = "SELECT sId, sUsername, sPhone, sType, sEmail, sRegStatus FROM subscribers WHERE sPhone=:p";
		$query = $dbh->prepare($sql);
		$query->bindParam(':p', $phone, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $results;
		} else {
			//No Subscriber Found
			return 1;
		}
	}

	// //Get Api Keys
	// public function getapikeys()
	// {
	// 	$dbh = self::connect();
	// 	$sql = "SELECT * FROM apilinks a, networkid b WHERE a.datanetwork=b.nId";
	// 	$query = $dbh->prepare($sql);
	// 	$query->execute();
	// 	$results = $query->fetchAll(PDO::FETCH_OBJ);
	// 	return $results;
	// }

	//Get Data Pins
	public function getDataPins()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM datapins a, networkid b WHERE a.datanetwork=b.nId";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}


	//Add Data Plans
	public function addDataPlan($network, $dataname, $datatype, $planid, $duration, $price, $userprice, $agentprice, $vendorprice)
	{
		$dbh = self::connect();

		//Check If Username Already Exist
		$queryC = $dbh->prepare("SELECT planid FROM dataplans WHERE planid=:p");
		$queryC->bindParam(':p', $planid, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 2;
		}

		//If Not Exist, Create New User
		$sql = "INSERT INTO  dataplans (datanetwork,name,type,planid,day,price,userprice,agentprice,vendorprice) 
			VALUES(:n,:d,:dt,:p,:du,:pr,:up,:ap,:vp)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':n', $network, PDO::PARAM_STR);
		$query->bindParam(':d', $dataname, PDO::PARAM_STR);
		$query->bindParam(':dt', $datatype, PDO::PARAM_STR);
		$query->bindParam(':p', $planid, PDO::PARAM_STR);
		$query->bindParam(':du', $duration, PDO::PARAM_STR);
		$query->bindParam(':pr', $price, PDO::PARAM_STR);
		$query->bindParam(':up', $userprice, PDO::PARAM_STR);
		$query->bindParam(':ap', $agentprice, PDO::PARAM_STR);
		$query->bindParam(':vp', $vendorprice, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			return 0;
		} else {
			return 1;
		}
	}

	//Update Data Plan
	public function updateDataPlan($plan, $network, $dataname, $datatype, $planid, $duration, $price, $userprice, $agentprice, $vendorprice)
	{
		$dbh = self::connect();


		//If Not Exist, Create New User
		$sql = "UPDATE dataplans SET datanetwork=:n,name=:d,type=:dt,planid=:p,day=:du,price=:pr,userprice=:up,agentprice=:ap,vendorprice=:vp WHERE pId=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $plan, PDO::PARAM_STR);
		$query->bindParam(':n', $network, PDO::PARAM_STR);
		$query->bindParam(':d', $dataname, PDO::PARAM_STR);
		$query->bindParam(':dt', $datatype, PDO::PARAM_STR);
		$query->bindParam(':p', $planid, PDO::PARAM_STR);
		$query->bindParam(':du', $duration, PDO::PARAM_STR);
		$query->bindParam(':pr', $price, PDO::PARAM_STR);
		$query->bindParam(':up', $userprice, PDO::PARAM_STR);
		$query->bindParam(':ap', $agentprice, PDO::PARAM_STR);
		$query->bindParam(':vp', $vendorprice, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}

	public function updateApiDetails($apiid, $eprovidername, $eproviderurl, $eservice)
	{
		$dbh = self::connect();


		//If Not Exist, Create New User
		$sql = "UPDATE apilinks SET name=:n,value=:d,type=:dt WHERE aId=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $apiid, PDO::PARAM_STR);
		$query->bindParam(':n', $eprovidername, PDO::PARAM_STR);
		$query->bindParam(':d', $eproviderurl, PDO::PARAM_STR);
		$query->bindParam(':dt', $eservice, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}
	///Delete A Data Plan
	public function deleteDataPlan($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM dataplans WHERE pId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}
	// Delete Api Provider
	public function deleteApi($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM apilinks WHERE aId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}

	///Delete Media
	public function deleteMedia($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM medias WHERE tId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}
	//Add Data Pins
	public function addDataPin($network, $dataname, $datatype, $planid, $duration, $price, $userprice, $agentprice, $vendorprice)
	{
		$dbh = self::connect();

		//Check If Username Already Exist
		$queryC = $dbh->prepare("SELECT planid FROM datapins WHERE planid=:p");
		$queryC->bindParam(':p', $planid, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 2;
		}

		//If Not Exist, Create New User
		$sql = "INSERT INTO  datapins (datanetwork,name,type,planid,day,price,userprice,agentprice,vendorprice) 
			VALUES(:n,:d,:dt,:p,:du,:pr,:up,:ap,:vp)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':n', $network, PDO::PARAM_STR);
		$query->bindParam(':d', $dataname, PDO::PARAM_STR);
		$query->bindParam(':dt', $datatype, PDO::PARAM_STR);
		$query->bindParam(':p', $planid, PDO::PARAM_STR);
		$query->bindParam(':du', $duration, PDO::PARAM_STR);
		$query->bindParam(':pr', $price, PDO::PARAM_STR);
		$query->bindParam(':up', $userprice, PDO::PARAM_STR);
		$query->bindParam(':ap', $agentprice, PDO::PARAM_STR);
		$query->bindParam(':vp', $vendorprice, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			return 0;
		} else {
			return 1;
		}
	}


	//Update Data Pin
	public function updateDataPin($pin, $network, $dataname, $datatype, $planid, $duration, $price, $userprice, $agentprice, $vendorprice)
	{
		$dbh = self::connect();

		$sql = "UPDATE datapins SET datanetwork=:n,name=:d,type=:dt,planid=:p,day=:du,price=:pr,userprice=:up,agentprice=:ap,vendorprice=:vp WHERE dpId=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $pin, PDO::PARAM_STR);
		$query->bindParam(':n', $network, PDO::PARAM_STR);
		$query->bindParam(':d', $dataname, PDO::PARAM_STR);
		$query->bindParam(':dt', $datatype, PDO::PARAM_STR);
		$query->bindParam(':p', $planid, PDO::PARAM_STR);
		$query->bindParam(':du', $duration, PDO::PARAM_STR);
		$query->bindParam(':pr', $price, PDO::PARAM_STR);
		$query->bindParam(':up', $userprice, PDO::PARAM_STR);
		$query->bindParam(':ap', $agentprice, PDO::PARAM_STR);
		$query->bindParam(':vp', $vendorprice, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}

	///Delete A Data Plan
	public function deleteDataPin($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM datapins WHERE dpId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}

	//----------------------------------------------------------------------------------------------------------------
	//	Cable Plan Management
	//----------------------------------------------------------------------------------------------------------------

	//Get All Cable Provider
	public function getCableProvider()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM cableid ORDER BY cableid ASC";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	//Get Cable Plans
	public function getCablePlans()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM cableplans a, cableid b WHERE a.cableprovider=b.cableid";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}


	//Add Cable Plans
	public function addCablePlan($provider, $planname, $planid, $duration, $price, $userprice, $agentprice, $vendorprice)
	{
		$dbh = self::connect();

		//Check If Username Already Exist
		$queryC = $dbh->prepare("SELECT planid FROM cableplans WHERE planid=:p");
		$queryC->bindParam(':p', $planid, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 2;
		}

		//If Not Exist, Create New User
		$sql = "INSERT INTO cableplans (cableprovider,name,planid,day,price,userprice,agentprice,vendorprice) 
			VALUES(:cp,:n,:p,:du,:pr,:up,:ap,:vp)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':cp', $provider, PDO::PARAM_STR);
		$query->bindParam(':n', $planname, PDO::PARAM_STR);
		$query->bindParam(':p', $planid, PDO::PARAM_STR);
		$query->bindParam(':du', $duration, PDO::PARAM_STR);
		$query->bindParam(':pr', $price, PDO::PARAM_STR);
		$query->bindParam(':up', $userprice, PDO::PARAM_STR);
		$query->bindParam(':ap', $agentprice, PDO::PARAM_STR);
		$query->bindParam(':vp', $vendorprice, PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			return 0;
		} else {
			return 1;
		}
	}


	//Update Cable Plan
	public function updateCablePlan($plan, $provider, $planname, $planid, $duration, $price, $userprice, $agentprice, $vendorprice)
	{
		$dbh = self::connect();

		//If Not Exist, Create New User
		$sql = "UPDATE cableplans SET cableprovider=:p,name=:pn,planid=:pi,day=:du,price=:pr,userprice=:up,agentprice=:ap,vendorprice=:vp WHERE cpId=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $plan, PDO::PARAM_STR);
		$query->bindParam(':p', $provider, PDO::PARAM_STR);
		$query->bindParam(':pn', $planname, PDO::PARAM_STR);
		$query->bindParam(':pi', $planid, PDO::PARAM_STR);
		$query->bindParam(':du', $duration, PDO::PARAM_STR);
		$query->bindParam(':pr', $price, PDO::PARAM_STR);
		$query->bindParam(':up', $userprice, PDO::PARAM_STR);
		$query->bindParam(':ap', $agentprice, PDO::PARAM_STR);
		$query->bindParam(':vp', $vendorprice, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}

	///Delete A Cable Plan
	public function deleteCablePlan($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM cableplans WHERE cpId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}


	//----------------------------------------------------------------------------------------------------------------
	// Subscribers
	//----------------------------------------------------------------------------------------------------------------

	//Get Subscribers
	public function getSubscribers($limit)
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM subscribers ORDER BY sId DESC LIMIT $limit,1000";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $results;
		} else {
			return 1;
		}
	}

	public function resetAccountApiKey($id)
	{
		$dbh = self::connect();
		$id = base64_decode($id);
		$id = (float) $id;
		$apiKey = substr(str_shuffle("0123456789ABCDEFGHIJklmnopqrstvwxyzAbAcAdAeAfAgAhBaBbBcBdC1C23C3C4C5C6C7C8C9xix2x3"), 0, 60) . time();

		$sql = "UPDATE subscribers SET sApiKey=:api WHERE sId = $id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':api', $apiKey, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}

	//Delete User Account
	public function terminateUserAccount($id)
	{
		$id = (float) base64_decode($id);
		$dbh = self::connect();

		//Delete All Transactions
		$sql = "DELETE FROM transactions WHERE sId=$id ";
		$query = $dbh->prepare($sql);
		$query->execute();

		//Delete All Transactions
		$sql2 = "DELETE FROM userlogin WHERE user=$id ";
		$query2 = $dbh->prepare($sql2);
		$query2->execute();


		//Delete All Transactions
		$sql3 = "DELETE FROM uservisits WHERE user=$id ";
		$query3 = $dbh->prepare($sql3);
		$query3->execute();

		//Delete Account Messages
		$sql4 = "DELETE FROM contact WHERE sId=$id ";
		$query4 = $dbh->prepare($sql4);
		$query4->execute();

		//Delete Account
		$sql5 = "DELETE FROM subscribers WHERE sId=$id ";
		$query5 = $dbh->prepare($sql5);
		$query5->execute();

		return 0;
	}

	//Get Subscribers
	public function getSubscribersDetails($id)
	{
		$dbh = self::connect();

		$sql = "SELECT * FROM subscribers WHERE sId = :id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_OBJ);
		return $results;
	}

	public function updateSubscriber($user, $fname, $lname, $state, $email, $phone, $accounttype, $accountstatus)
	{
		$dbh = self::connect();
		$user = base64_decode($user);
		$user = (float) $user;
		$accounttype = (float) $accounttype;
		$accountstatus = (float) $accountstatus;

		$sql = "UPDATE subscribers SET sFname=:f, sLname=:l, sState=:s, sType=:at, sRegStatus=:as, sEmail=:e, sPhone=:p WHERE sId = :u";
		$query = $dbh->prepare($sql);
		$query->bindParam(':f', $fname, PDO::PARAM_STR);
		$query->bindParam(':l', $lname, PDO::PARAM_STR);
		$query->bindParam(':s', $state, PDO::PARAM_STR);
		$query->bindParam(':at', $accounttype, PDO::PARAM_INT);
		$query->bindParam(':as', $accountstatus, PDO::PARAM_INT);
		$query->bindParam(':e', $email, PDO::PARAM_STR);
		$query->bindParam(':p', $phone, PDO::PARAM_STR);
		$query->bindParam(':u', $user, PDO::PARAM_INT);

		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}
	public function updateMerchant($user, $bname, $wphone, $coinIds, $limitStr, $priceStr, $mStatus, $Action)
	{
		$dbh = self::connect();
		$user = base64_decode($user);
		$user = (float) $user;
		$mStatus = (float) $mStatus;
		$Action = (float) $Action;

		$sql = "UPDATE p2pmerchants SET mBrand=:bname, mWhatsapp=:wphone, mCoins=:coinIds, mLimit=:limitStr, mPrice=:priceStr, mStatus=:mStatus, mAction=:actions WHERE mId = :user";
		$query = $dbh->prepare($sql);
		$query->bindParam(':bname', $bname, PDO::PARAM_STR);
		$query->bindParam(':wphone', $wphone, PDO::PARAM_STR);
		$query->bindParam(':coinIds', $coinIds, PDO::PARAM_STR);
		$query->bindParam(':limitStr', $limitStr, PDO::PARAM_STR);
		$query->bindParam(':priceStr', $priceStr, PDO::PARAM_STR);
		$query->bindParam(':actions', $Action, PDO::PARAM_INT);
		$query->bindParam(':mStatus', $mStatus, PDO::PARAM_INT);
		$query->bindParam(':user', $user, PDO::PARAM_INT);

		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}
	public function addMerchant($user, $mphone, $mUsername, $mEmail, $bname, $wphone, $coinIds, $limitStr, $priceStr, $Action)
	{
		$dbh = self::connect();
		$user = (float) $user;

		//Check If Username Already Exist
		$queryC = $dbh->prepare("SELECT mUsername FROM p2pmerchants WHERE mUsername=:m");
		$queryC->bindParam(':m', $mUsername, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 2; //Username Already Exist
		}
		//Check If Email Already Exist
		$queryC2 = $dbh->prepare("SELECT mEmail FROM p2pmerchants WHERE mEmail=:e");

		$queryC2->bindParam(':e', $mEmail, PDO::PARAM_STR);
		$queryC2->execute();
		if ($queryC2->rowCount() > 0) {
			return 3; //Email Already Exist
		}
		//Check If Phone Already Exist
		$queryC3 = $dbh->prepare("SELECT mPhone FROM p2pmerchants WHERE mPhone=:p");
		$queryC3->bindParam(':p', $mphone, PDO::PARAM_STR);
		$queryC3->execute();
		if ($queryC3->rowCount() > 0) {
			return 4; //Phone Already Exist
		}
		//If Not Exist, Create New User
		$mphone = trim($mphone);
		$mUsername = trim($mUsername);
		$mEmail = trim($mEmail);
		$bname = trim($bname);
		$wphone = trim($wphone);
		$coinIds = trim($coinIds);
		$limitStr = trim($limitStr);
		$priceStr = trim($priceStr);
		if (empty($mphone) || empty($mUsername) || empty($mEmail) || empty($bname) || empty($wphone) || empty($coinIds) || empty($limitStr) || empty($priceStr)) {
			return 5; //Required Fields Cannot Be Empty
		}

		$sql = "INSERT INTO p2pmerchants SET 
			sId = :user, 
			mPhone = :mphone, 
			mUsername = :mUsername, 
			mEmail = :mEmail, 
			mBrand = :bname, 
			mWhatsapp = :wphone, 
			mCoins = :coinIds, 
			mLimit = :limitStr, 
			mPrice = :priceStr, 
			mAction = :actions,
			mStatus = 1";
		$query = $dbh->prepare($sql);
		$query->bindParam(':user', $user, PDO::PARAM_INT);
		$query->bindParam(':mphone', $mphone, PDO::PARAM_STR);
		$query->bindParam(':mUsername', $mUsername, PDO::PARAM_STR);
		$query->bindParam(':mEmail', $mEmail, PDO::PARAM_STR);
		$query->bindParam(':bname', $bname, PDO::PARAM_STR);
		$query->bindParam(':wphone', $wphone, PDO::PARAM_STR);
		$query->bindParam(':coinIds', $coinIds, PDO::PARAM_STR);
		$query->bindParam(':limitStr', $limitStr, PDO::PARAM_STR);
		$query->bindParam(':actions', $Action, PDO::PARAM_INT);
		$query->bindParam(':priceStr', $priceStr, PDO::PARAM_STR);

		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}
	public function updateSubscriberPass($id, $pass)
	{
		$dbh = self::connect();
		$id = base64_decode($id);
		$id = (float) $id;
		$hash = substr(sha1(md5($pass)), 3, 10);
		$sql = "UPDATE subscribers SET sPass=:pass WHERE sId = $id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':pass', $hash, PDO::PARAM_STR);
		if ($query->execute()) {
			return 0;
		} else {
			return 1;
		}
	}


	//----------------------------------------------------------------------------------------------------------------
	// Exam Pin Management
	//----------------------------------------------------------------------------------------------------------------

	//Exam pin Setting
	public function getExamPinDetails($exam)
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM examid WHERE provider=:exam";
		$query = $dbh->prepare($sql);
		$query->bindParam(':exam', $exam, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_OBJ);
		return $results;
	}

	//Update Exam pin Setting
	public function updateExamPin($exam, $examid, $examprice, $buying_price, $examstatus)
	{
		$dbh = self::connect();
		$id = (int) $exam;

		$sql = "UPDATE examid SET examid=:e, price=:g, buying_price=:l, providerStatus=:a WHERE eId = $id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':e', $examid, PDO::PARAM_INT);
		$query->bindParam(':g', $examprice, PDO::PARAM_INT);
		$query->bindParam(':l', $buying_price, PDO::PARAM_INT);
		$query->bindParam(':a', $examstatus, PDO::PARAM_STR);

		$query->execute();

		return 0;
	}


	//----------------------------------------------------------------------------------------------------------------
	// Electricity Pin Management
	//----------------------------------------------------------------------------------------------------------------

	//Electricity Bill Setting
	public function getElectricityBillDetails($electricity)
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM electricityid WHERE abbreviation=:electricity";
		$query = $dbh->prepare($sql);
		$query->bindParam(':electricity', $electricity, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_OBJ);
		return $results;
	}

	public function updateElectricityBill($electricity, $electricityid, $electricitystatus)
	{
		$dbh = self::connect();
		$id = (int) $electricity;

		$sql = "UPDATE electricityid SET electricityid=:e, providerStatus=:p WHERE eId = $id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':e', $electricityid, PDO::PARAM_STR);
		$query->bindParam(':p', $electricitystatus, PDO::PARAM_STR);

		$query->execute();
		return 0;
	}

	//----------------------------------------------------------------------------------------------------------------
	// Wallet Management
	//----------------------------------------------------------------------------------------------------------------

	//Credit Debit User
	public function creditDebitUser($email, $action, $amount, $reason, $ref)
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM subscribers WHERE sEmail = :e";
		$query = $dbh->prepare($sql);
		$query->bindParam(':e', $email, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetch(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {

			$amount = (float) $amount;
			$oldbalance = (float) $results->sWallet;
			$userId = $results->sId;
			$fname = $results->sFname;

			if ($amount > $oldbalance && $action == "Debit") {
				return 2;
			} else {

				if ($action == "Credit") {
					$newbalance = $oldbalance + $amount;
				} elseif ($action == "Debit") {
					$newbalance = $oldbalance - $amount;
				} else {
					return 3;
				}

				$servicename = "Wallet {$action}";
				$servicedesc = "Wallet {$action} of N{$amount} for user {$email}. Reason: {$reason}";
				$message = "Operation Successful. Account {$action}ed with N{$amount}. <br/> Old Balance Is: N" . number_format($oldbalance) . " <br/> New Balance Is: N" . number_format($newbalance) . ".";
				$status = 0;
				$date = date("Y-m-d H:i:s");

				//Record Transaction
				$sql2 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
				$query2 = $dbh->prepare($sql2);
				$query2->bindParam(':user', $userId, PDO::PARAM_INT);
				$query2->bindParam(':ref', $ref, PDO::PARAM_STR);
				$query2->bindParam(':sn', $servicename, PDO::PARAM_STR);
				$query2->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
				$query2->bindParam(':a', $amount, PDO::PARAM_STR);
				$query2->bindParam(':s', $status, PDO::PARAM_INT);
				$query2->bindParam(':ob', $oldbalance, PDO::PARAM_STR);
				$query2->bindParam(':nb', $newbalance, PDO::PARAM_STR);
				$query2->bindParam(':d', $date, PDO::PARAM_STR);
				$query2->execute();

				$lastInsertId = $dbh->lastInsertId();
				if ($lastInsertId) {
					$response = array();
					//Update Account Type & Balance
					$sql3 = "UPDATE subscribers SET sWallet=:bal WHERE sId=:id";
					$query3 = $dbh->prepare($sql3);
					$query3->bindParam(':id', $userId, PDO::PARAM_INT);
					$query3->bindParam(':bal', $newbalance, PDO::PARAM_STR);
					if ($query3->execute()) {
						$response["status"] = "success";
						$response["msg"] = $message;
					} else {
						$response["status"] = "fail";
						$response["msg"] = "Could Not Update Balance.";
					}

					//Send Email Notification
					$subject = $servicename . " (" . $this->sitename . ")";
					$message = "Hi " . $fname . ", This is to notify you that your account have been {$action}ed with N{$amount}. <br/>";
					$message .= "<h3>Old Balance Is: N" . number_format($oldbalance) . " <br/> New Balance Is: N" . number_format($newbalance) . ".</h3>";
					self::sendMail($email, $subject, $message);

					return $response;
				}
			}
		} else {
			return 1;
		}
	}


	//----------------------------------------------------------------------------------------------------------------
	//	Transactions Management
	//----------------------------------------------------------------------------------------------------------------


	//Get All Transactions
	public function getTransactions($limit)
	{
		$dbh = self::connect();
		$addon = "";

		if (isset($_GET["search"])) {

			$search = (isset($_GET["search"])) ? $_GET["search"] : "";
			$searchfor = (isset($_GET["searchfor"])) ? $_GET["searchfor"] : "";

			if ($search == "") {
				if ($searchfor == "all") {
					$addon = "";
				}
				if ($searchfor == "user") {
					$addon = "";
				}
				if ($searchfor == "wallet") {
					$addon = " AND b.servicename ='Wallet Credit' ";
				}
				if ($searchfor == "monnify") {
					$addon = " AND b.transref LIKE '%MNFY%' ";
				}
				if ($searchfor == "paystack") {
					$addon = " AND b.servicedesc LIKE '%Paystack%' ";
				}
				if ($searchfor == "airtime") {
					$addon = " AND b.servicename LIKE '%Airtime%' ";
				}
				if ($searchfor == "data") {
					$addon = " AND b.servicename LIKE '%Data%' ";
				}
				if ($searchfor == "cable") {
					$addon = " AND b.servicename LIKE '%Cable%' ";
				}
				if ($searchfor == "electricity") {
					$addon = " AND b.servicename LIKE '%Electricity%' ";
				}
				if ($searchfor == "exam") {
					$addon = " AND b.servicename LIKE '%Exam%' ";
				}
				if ($searchfor == "reference") {
					$addon = " AND b.transref LIKE :search ";
				}
				if ($searchfor == "refund") {
					$addon = " AND b.servicename = 'Refund' ";
				}
			} else {

				if ($searchfor == "all") {
					$addon = " AND b.servicedesc LIKE :search";
				}
				if ($searchfor == "user") {
					$addon = " AND (a.sPhone LIKE :search OR a.sEmail LIKE :search) ";
				}
				if ($searchfor == "wallet") {
					$addon = " AND (a.sPhone LIKE :search AND b.servicename ='Wallet Credit') ";
				}
				if ($searchfor == "monnify") {
					$addon = " AND ((a.sPhone LIKE :search OR a.sEmail LIKE :search) AND b.transref LIKE '%MNFY%') ";
				}
				if ($searchfor == "paystack") {
					$addon = " AND ((a.sPhone LIKE :search OR a.sEmail LIKE :search) AND b.servicedesc LIKE '%Paystack%') ";
				}
				if ($searchfor == "airtime") {
					$addon = " AND ((a.sPhone LIKE :search OR b.servicedesc LIKE :search) AND b.servicename LIKE '%Airtime%') ";
				}
				if ($searchfor == "data") {
					$addon = " AND ((a.sPhone LIKE :search OR b.servicedesc LIKE :search) AND b.servicename LIKE '%Data%') ";
				}
				if ($searchfor == "cable") {
					$addon = " AND ((a.sPhone LIKE :search OR b.servicedesc LIKE :search) AND b.servicename LIKE '%Cable%') ";
				}
				if ($searchfor == "electricity") {
					$addon = " AND ((a.sPhone LIKE :search OR b.servicedesc LIKE :search) AND b.servicename LIKE '%Electricity%') ";
				}
				if ($searchfor == "exam") {
					$addon = " AND ((a.sPhone LIKE :search OR b.servicedesc LIKE :search) AND b.servicename LIKE '%Exam%') ";
				}
				if ($searchfor == "reference") {
					$addon = " AND b.transref LIKE :search ";
				}
				if ($searchfor == "refund") {
					$addon = " AND ((a.sPhone LIKE :search OR b.servicedesc LIKE :search) AND b.servicename = 'Refund') ";
				}
			}
		}

		$sql = "SELECT a.sFname,a.sPhone,a.sEmail,a.sType,bc.name as blockchain_name,b.* FROM transactions b 
		LEFT JOIN subscribers a ON a.sId=b.sId 
		LEFT JOIN blockchain bc ON bc.id=b.blockchain_id
		WHERE 1=1 ";
		// Optional transaction_type filter
		$txType = isset($_GET['tx_type']) ? strtolower(trim($_GET['tx_type'])) : '';
		$allowedTxType = ($txType === 'dex' || $txType === 'app');
		if ($allowedTxType) {
			$sql .= " AND b.transaction_type = :tx_type ";
		}
		$sql .= $addon . " ORDER BY b.date DESC LIMIT $limit, 1000";
		$query = $dbh->prepare($sql);
		if (isset($_GET["search"])):
			if ($search <> ""):
				$query->bindValue(':search', '%' . $search . '%');
			endif;
		endif;
		if ($allowedTxType) {
			$query->bindValue(':tx_type', $txType);
		}
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	// Fetch transactions by EVM wallet address with pagination and blockchain filter
	public function getTransactionsByAddress($address, $page = 0, $perPage = 10, $blockchain_id = null)
	{
		$dbh = self::connect();
		$address = trim((string) $address);
		// Detect if EVM (starts with 0x) or other (e.g. TON)
		$isEvm = (stripos($address, '0x') === 0);

		// For EVM, we normalize to lowercase for case-insensitive matching.
		// For TON (Base64), case matters, so we use exact match.
		$addrParam = $isEvm ? strtolower($address) : $address;

		$page = max(0, (int) $page);
		$perPage = max(1, (int) $perPage);
		$offset = $page * $perPage;

		$chainFilter = "";
		if ($blockchain_id !== null) {
			$chainFilter = " AND b.blockchain_id = :bid ";
		}

		// Count total
		if ($isEvm) {
			$sqlC = "SELECT COUNT(*) AS cnt FROM transactions b WHERE (LOWER(b.senderaddress)=LOWER(:addr) OR LOWER(b.targetaddress)=LOWER(:addr))" . $chainFilter;
		} else {
			// Case-sensitive match for non-EVM
			$sqlC = "SELECT COUNT(*) AS cnt FROM transactions b WHERE (b.senderaddress=:addr OR b.targetaddress=:addr)" . $chainFilter;
		}
		$qC = $dbh->prepare($sqlC);
		$qC->bindParam(':addr', $addrParam, PDO::PARAM_STR);
		if ($blockchain_id !== null) {
			$qC->bindValue(':bid', $blockchain_id, PDO::PARAM_INT);
		}
		$qC->execute();
		$total = (int) ($qC->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0);

		// Fetch items
		if ($isEvm) {
			$sql = "SELECT a.sEmail,a.sPhone,a.sType,b.* FROM transactions b LEFT JOIN subscribers a ON a.sId=b.sId WHERE (LOWER(b.senderaddress)=LOWER(:addr) OR LOWER(b.targetaddress)=LOWER(:addr)) " . $chainFilter . " ORDER BY b.date DESC LIMIT $offset, $perPage";
		} else {
			$sql = "SELECT a.sEmail,a.sPhone,a.sType,b.* FROM transactions b LEFT JOIN subscribers a ON a.sId=b.sId WHERE (b.senderaddress=:addr OR b.targetaddress=:addr) " . $chainFilter . " ORDER BY b.date DESC LIMIT $offset, $perPage";
		}
		$q = $dbh->prepare($sql);
		$q->bindParam(':addr', $addrParam, PDO::PARAM_STR);
		if ($blockchain_id !== null) {
			$q->bindValue(':bid', $blockchain_id, PDO::PARAM_INT);
		}
		$q->execute();
		$items = $q->fetchAll(PDO::FETCH_OBJ);

		return ['total' => $total, 'page' => $page, 'perPage' => $perPage, 'items' => $items];
	}

	// Tokens CRUD
	public function getActiveTokens()
	{
		$dbh = self::connect();
		$sql = "SELECT token_id, token_name, token_contract, token_decimals, is_active, created_at, updated_at FROM tokens WHERE is_active=1 ORDER BY token_name ASC";
		$q = $dbh->prepare($sql);
		$q->execute();
		return $q->fetchAll(PDO::FETCH_OBJ);
	}

	public function getAllTokens()
	{
		$dbh = self::connect();
		$sql = "SELECT token_id, token_name, token_contract, token_decimals, chain_id, is_active, created_at, updated_at FROM tokens ORDER BY token_name ASC";
		$q = $dbh->prepare($sql);
		$q->execute();
		return $q->fetchAll(PDO::FETCH_OBJ);
	}

	public function upsertToken($tokenId, $name, $contract, $decimals, $active, $chain_id = 1)
	{
		$dbh = self::connect();
		$name = trim($name);
		$contract = strtolower(trim($contract));
		$dec = (int) $decimals;
		$active = (int) $active;
		$chain_id = (int) $chain_id;

		if (!preg_match('/^0x[a-fA-F0-9]{40}$/', $contract) && $contract != 'native') {
			return ['status' => 'fail', 'msg' => 'Invalid contract address'];
		}
		if ($dec < 0 || $dec > 36) {
			return ['status' => 'fail', 'msg' => 'Invalid decimals'];
		}

		if ($tokenId) {
			$sql = "UPDATE tokens SET token_name=:n, token_contract=:c, token_decimals=:d, is_active=:a, chain_id=:ci WHERE token_id=:id";
			$q = $dbh->prepare($sql);
			$q->bindParam(':id', $tokenId, PDO::PARAM_INT);
		} else {
			$sql = "INSERT INTO tokens (token_name, token_contract, token_decimals, is_active, chain_id) VALUES (:n,:c,:d,:a,:ci)";
			$q = $dbh->prepare($sql);
		}
		$q->bindParam(':n', $name, PDO::PARAM_STR);
		$q->bindParam(':c', $contract, PDO::PARAM_STR);
		$q->bindParam(':d', $dec, PDO::PARAM_INT);
		$q->bindParam(':a', $active, PDO::PARAM_INT);
		$q->bindParam(':ci', $chain_id, PDO::PARAM_INT);

		if ($q->execute()) {
			return ['status' => 'success'];
		}
		return ['status' => 'fail', 'msg' => 'DB error'];
	}


	// Blockchain CRUD
	public function getAllBlockchains()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM blockchain ORDER BY id ASC";
		$q = $dbh->prepare($sql);
		$q->execute();
		return $q->fetchAll(PDO::FETCH_OBJ);
	}

	public function getBlockchainById($id)
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM blockchain WHERE id = :id LIMIT 1";
		$q = $dbh->prepare($sql);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		$q->execute();
		return $q->fetch(PDO::FETCH_OBJ);
	}

	public function upsertBlockchain($id, $chain_key, $name, $rpc_url, $explorer_url, $native_symbol, $chain_id, $chain_id_hex, $is_active)
	{
		$dbh = self::connect();
		$name = trim($name);
		$rpc_url = trim($rpc_url);
		$explorer_url = trim($explorer_url);
		$native_symbol = strtoupper(trim($native_symbol));
		$is_active = (int) $is_active;

		if ($id) {
			$sql = "UPDATE blockchain SET chain_key=:ck, name=:n, rpc_url=:r, explorer_url=:e, native_symbol=:s, chain_id=:ci, chain_id_hex=:ch, is_active=:a WHERE id=:id";
			$q = $dbh->prepare($sql);
			$q->bindParam(':id', $id, PDO::PARAM_INT);
		} else {
			$sql = "INSERT INTO blockchain (chain_key, name, rpc_url, explorer_url, native_symbol, chain_id, chain_id_hex, is_active) VALUES (:ck,:n,:r,:e,:s,:ci,:ch,:a)";
			$q = $dbh->prepare($sql);
		}
		$q->bindParam(':ck', $chain_key, PDO::PARAM_STR);
		$q->bindParam(':n', $name, PDO::PARAM_STR);
		$q->bindParam(':r', $rpc_url, PDO::PARAM_STR);
		$q->bindParam(':e', $explorer_url, PDO::PARAM_STR);
		$q->bindParam(':s', $native_symbol, PDO::PARAM_STR);
		$q->bindParam(':ci', $chain_id, PDO::PARAM_INT);
		$q->bindParam(':ch', $chain_id_hex, PDO::PARAM_STR);
		$q->bindParam(':a', $is_active, PDO::PARAM_INT);

		if ($q->execute()) {
			return ['status' => 'success'];
		}
		return ['status' => 'fail', 'msg' => 'DB error'];
	}

	public function deleteBlockchain($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM blockchain WHERE id=:id";
		$q = $dbh->prepare($sql);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		if ($q->execute()) {
			return ['status' => 'success'];
		}
		return ['status' => 'fail', 'msg' => 'DB error'];
	}

	public function deleteToken($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM tokens WHERE token_id=:id";
		$q = $dbh->prepare($sql);
		$q->bindParam(':id', $id, PDO::PARAM_INT);
		if ($q->execute()) {
			return ['status' => 'success'];
		}
		return ['status' => 'fail', 'msg' => 'DB error'];
	}

	//Get Transaction Details
	public function getTransactionDetails($ref)
	{
		$dbh = self::connect();
		$sql = "SELECT a.sFname,a.sPhone,a.sEmail,a.sType,bc.name as blockchain_name,b.* FROM transactions b LEFT JOIN subscribers a ON a.sId=b.sId LEFT JOIN blockchain bc ON bc.id=b.blockchain_id WHERE transref=:ref";
		$query = $dbh->prepare($sql);
		$query->bindParam(':ref', $ref, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		return $result;
	}

	//Update Transaction Details
	public function updateTransactionStatus($user, $trans, $transstatus, $amount)
	{
		$dbh = self::connect();

		$transstatus = (int) $transstatus;
		$trans = base64_decode($trans);
		$user = base64_decode($user);
		$amount = base64_decode($amount);

		$theStatus = $transstatus;

		if ($transstatus == 10) {
			$theStatus = 0;
		}
		if ($transstatus == 11) {
			$theStatus = 1;
		}

		$sqlD = "UPDATE transactions SET status=:status WHERE transref=:ref";
		$queryD = $dbh->prepare($sqlD);
		$queryD->bindParam(':status', $theStatus, PDO::PARAM_INT);
		$queryD->bindParam(':ref', $trans, PDO::PARAM_STR);
		$queryD->execute();


		//11 Fail And Refund --- 10 Success And Debit
		if ($transstatus == 11 || $transstatus == 10) {
			$sqlW = "SELECT sWallet FROM subscribers WHERE sId=$user";
			$queryW = $dbh->prepare($sqlW);
			$queryW->execute();
			$resultW = $queryW->fetch(PDO::FETCH_OBJ);
			$oldbalance = (float) $resultW->sWallet;

			if ($transstatus == 10) {
				$newbalance = $oldbalance - $amount;
			}
			if ($transstatus == 11) {
				$newbalance = $oldbalance + $amount;
			}


			$sqlS = "UPDATE subscribers SET sWallet=:nb WHERE sId=:id";
			$queryS = $dbh->prepare($sqlS);
			$queryS->bindParam(':id', $user, PDO::PARAM_INT);
			$queryS->bindParam(':nb', $newbalance, PDO::PARAM_STR);
			$queryS->execute();

			//Record Transaction
			if ($transstatus == 10) {
				$servicename = "Debit";
				$servicedesc = "Debit of N{$amount} for tansaction reference {$trans}.";
				$status = 0;
				$date = date("Y-m-d H:i:s");
				$ref = "DEBIT/" . $trans . "/" . time();
			}

			if ($transstatus == 11) {
				$servicename = "Refund";
				$servicedesc = "Refund of N{$amount} for tansaction reference {$trans}.";
				$status = 0;
				$date = date("Y-m-d H:i:s");
				$ref = "REFUND/" . $trans . "/" . time();
			}


			$sql = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
			$query = $dbh->prepare($sql);
			$query->bindParam(':user', $user, PDO::PARAM_INT);
			$query->bindParam(':ref', $ref, PDO::PARAM_STR);
			$query->bindParam(':sn', $servicename, PDO::PARAM_STR);
			$query->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
			$query->bindParam(':a', $amount, PDO::PARAM_STR);
			$query->bindParam(':s', $status, PDO::PARAM_INT);
			$query->bindParam(':ob', $oldbalance, PDO::PARAM_STR);
			$query->bindParam(':nb', $newbalance, PDO::PARAM_STR);
			$query->bindParam(':d', $date, PDO::PARAM_STR);
			$query->execute();

			return 0;
		}
	}

	//----------------------------------------------------------------------------------------------------------------
	//	Sale Transactions Management
	//----------------------------------------------------------------------------------------------------------------


	//Get All Transactions
	public function getSaleTransactions($service, $datefrom, $dateto)
	{
		$dbh = self::connect();

		$addon = "";

		//Get Specific Service
		if ($service <> "All") {
			$addon = " AND b.servicename = :service ";
		}

		//Get Transactions
		$sql = "SELECT a.sType, b.* FROM subscribers a, transactions b WHERE a.sId=b.sId ";
		$sql .= $addon . " AND (b.date BETWEEN :df AND :dt) ORDER BY b.date DESC";
		$query = $dbh->prepare($sql);
		if ($service <> "All") {
			$query->bindParam(':service', $service);
		}
		$query->bindParam(':df', $datefrom);
		$query->bindParam(':dt', $dateto);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		return $results;
	}

	public function getBlockchainBalances()
	{
		$blockchains = $this->getAllBlockchains();
		$tokens = $this->getAllTokens();
		$results = [];

		$apiModel = new ApiModel();

		foreach ($blockchains as $b) {
			if (!$b->is_active)
				continue;

			$address = $b->refunding_address;
			if (empty($address))
				continue;

			// Native Balance
			$nativeBalance = "0";
			$nativeRes = $apiModel->callJsonRpc('eth_getBalance', [$address, 'latest'], (array) $b);
			if (isset($nativeRes['result'])) {
				$nativeBalance = hexdec($nativeRes['result']) / 1e18; // Assuming 18 decimals for native
			}

			$chainTokens = [];
			foreach ($tokens as $t) {
				if ($t->chain_id == $b->id && $t->is_active && $t->token_contract != 'native') {
					// Token Balance
					$tokenBal = "0";
					$data = '0x70a08231' . str_pad(substr($address, 2), 64, '0', STR_PAD_LEFT);
					$tokenRes = $apiModel->callJsonRpc('eth_call', [['to' => $t->token_contract, 'data' => $data], 'latest'], (array) $b);
					if (isset($tokenRes['result']) && $tokenRes['result'] != '0x') {
						$tokenBal = hexdec($tokenRes['result']) / pow(10, $t->token_decimals);
					}
					$chainTokens[] = [
						'name' => $t->token_name,
						'balance' => $tokenBal,
						'symbol' => $t->token_name // Fallback
					];
				}
			}

			$results[] = [
				'chain_name' => $b->name,
				'address' => $address,
				'native_balance' => $nativeBalance,
				'native_symbol' => $b->native_symbol,
				'tokens' => $chainTokens
			];
		}

		return $results;
	}






	//----------------------------------------------------------------------------------------------------------------
	// Contact Messages
	//----------------------------------------------------------------------------------------------------------------

	//Get Contact Messages
	public function getContact()
	{
		$dbh = self::connect();
		$sql = "SELECT * FROM contact ORDER BY dPosted DESC";
		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		if ($query->rowCount() > 0) {
			return $results;
		} else {
			return 1;
		}
	}

	//Get Contact
	public function deleteContact($id)
	{
		$dbh = self::connect();
		$sql = "DELETE FROM contact WHERE msgId=$id";
		$query = $dbh->prepare($sql);
		$query->execute();
		return 0;
	}


	//----------------------------------------------------------------------------------------------------------------
	// Dashboard
	//----------------------------------------------------------------------------------------------------------------


	//Get General Site Statictics
	public function getGeneralSiteReports()
	{
		$dbh = self::connect();

		$today = strtotime(date("Y-m-d") . '00:00:00');
		$last = strtotime(date("Y-m-d") . '23:59:59');

		$sql1 = "SELECT COUNT(sId) AS sCount FROM subscribers WHERE sType = 1";
		$sql2 = "SELECT COUNT(sId) AS aCount FROM subscribers WHERE sType = 2";
		$sql3 = "SELECT COUNT(tId) AS tCount FROM transactions";
		$sql4 = "SELECT SUM(sWallet) AS uwCount FROM subscribers WHERE sType = 1";
		$sql5 = "SELECT SUM(sWallet) AS awCount FROM subscribers WHERE sType = 2";
		$sql6 = "SELECT COUNT(msgId) AS mCount  FROM contact";
		$sql7 = "SELECT COUNT(id) AS visitCount  FROM uservisits WHERE visitTime BETWEEN $today AND $last";
		$sql8 = "SELECT a.sFname,a.sPhone,a.sType,a.sEmail,b.* FROM subscribers a, transactions b WHERE a.sId=b.sId ORDER BY b.date DESC LIMIT 50";
		//$sql9 ="SELECT dAcc,vAcc FROM apiconfigs WHERE aId=1";
		$sql10 = "SELECT SUM(sWallet) AS vwCount FROM subscribers WHERE sType = 3";
		$sql11 = "SELECT COUNT(sId) AS vCount FROM subscribers WHERE sType = 3";
		$sql12 = "SELECT COUNT(sId) AS rCount FROM subscribers WHERE sReferal <> '' ";
		$sql13 = "SELECT SUM(sRefWallet) AS rwCount FROM subscribers";
		$sql14 = "SELECT COUNT(tId) AS alphaCount FROM transactions WHERE status=2";



		$query1 = $dbh->prepare($sql1);
		$query2 = $dbh->prepare($sql2);
		$query3 = $dbh->prepare($sql3);
		$query4 = $dbh->prepare($sql4);
		$query5 = $dbh->prepare($sql5);
		$query6 = $dbh->prepare($sql6);
		$query7 = $dbh->prepare($sql7);
		$query8 = $dbh->prepare($sql8);
		//$query9 = $dbh -> prepare($sql9);
		$query10 = $dbh->prepare($sql10);
		$query11 = $dbh->prepare($sql11);
		$query12 = $dbh->prepare($sql12);
		$query13 = $dbh->prepare($sql13);
		$query14 = $dbh->prepare($sql14);


		$query1->execute();
		$query2->execute();
		$query3->execute();
		$query4->execute();
		$query5->execute();
		$query6->execute();
		$query7->execute();
		$query8->execute();
		//$query9->execute();
		$query10->execute();
		$query11->execute();
		$query12->execute();
		$query13->execute();
		$query14->execute();

		$results1 = $query1->fetch(PDO::FETCH_OBJ);
		$results2 = $query2->fetch(PDO::FETCH_OBJ);
		$results3 = $query3->fetch(PDO::FETCH_OBJ);
		$results4 = $query4->fetch(PDO::FETCH_OBJ);
		$results5 = $query5->fetch(PDO::FETCH_OBJ);
		$results6 = $query6->fetch(PDO::FETCH_OBJ);
		$results7 = $query7->fetch(PDO::FETCH_OBJ);
		$results8 = $query8->fetchAll(PDO::FETCH_OBJ);
		//$results9=$query9->fetch(PDO::FETCH_OBJ);
		$results10 = $query10->fetch(PDO::FETCH_OBJ);
		$results11 = $query11->fetch(PDO::FETCH_OBJ);
		$results12 = $query12->fetch(PDO::FETCH_OBJ);
		$results13 = $query13->fetch(PDO::FETCH_OBJ);
		$results14 = $query14->fetch(PDO::FETCH_OBJ);


		$data = array();
		$data["sCount"] = $results1->sCount;
		$data["aCount"] = $results2->aCount;
		$data["tCount"] = $results3->tCount;
		$data["uwCount"] = $results4->uwCount;
		$data["awCount"] = $results5->awCount;
		$data["mCount"] = $results6->mCount;
		$data["visitCount"] = $results7->visitCount;
		$data["transactions"] = $results8;

		//Wallet Balance  
		//$data["dataaccount"]=$results9->dAcc;
		//$data["vtuaccount"]=$results9->vAcc;
		$data["vwCount"] = $results10->vwCount;
		$data["vCount"] = $results11->vCount;
		$data["rCount"] = $results12->rCount;
		$data["rwCount"] = $results13->rwCount;

		$data["alphaCount"] = $results14->alphaCount;

		$data["blockchainBalances"] = $this->getBlockchainBalances();

		return $data;
	}
}

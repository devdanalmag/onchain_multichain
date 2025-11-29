<?php

class Account extends Model
{

	//Verify Admin Login Deatils
	public function verifyAdminAccount($uname, $pass)
	{
		$sql = "SELECT sysId,sysName,sysStatus,sysUsername,sysRole FROM sysusers WHERE sysUsername=:uname AND sysToken=:password";
		$query = self::$dbh->prepare($sql);
		$query->bindParam(':uname', $uname, PDO::PARAM_STR);
		$query->bindParam(':password', $pass, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);

		if ($query->rowCount() > 0) {
			if ($result["sysStatus"] <> 0) {
				return 2;
			}
			$_SESSION['sysUser'] = $result["sysUsername"];
			$_SESSION['sysRole'] = $result["sysRole"];
			$_SESSION['sysName'] = $result["sysName"];
			$_SESSION['sysId'] = $result["sysId"];
			return 0;
		} else {
			return 1;
		}
	}

	public function verifyAdminAccount2()
	{
		$sql = "SELECT sysId,sysName,sysStatus,sysUsername,sysRole FROM sysusers";
		$query = self::$dbh->prepare($sql);
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	//Register/Create New User Account

	public function registerUser($username, $email, $password, $referral)
	{
		// If registration is done by admin, don't save cookies data
		$saveCookies = ($referral == "admin") ? FALSE : TRUE;
		if ($referral == "admin") {
			$referral = "";
		}


		// Verify Registration Details
		$dbh = self::connect();
		$c = "SELECT sEmail, sUsername FROM subscribers WHERE sEmail = :e OR sUsername = :u";
		$queryC = $dbh->prepare($c);
		$queryC->bindParam(':e', $email, PDO::PARAM_STR);
		$queryC->bindParam(':u', $username, PDO::PARAM_STR);
		$queryC->execute();
		$result = $queryC->fetch(PDO::FETCH_ASSOC);
		$data = 3; // Default error code
		// Output Error Message If Data Already Exist
		if ($queryC->rowCount() > 0) {
			if ($result["sEmail"] == $email && $result["sUsername"] == $username) {
				$data = 1; // Both email and username exist
			} elseif ($result["sEmail"] == $email) {
				$data = 2; // Email exists
			} elseif ($result["sUsername"] == $username) {
				$data = 3; // Username exists
			}
			return $data;
		}
		if ($referral != "") {
			// Check if the referral username exists
			$d = "SELECT sEmail, sUsername, sRegStatus FROM subscribers WHERE sUsername = :u";
			$queryD = $dbh->prepare($d);
			$queryD->bindParam(':u', $referral, PDO::PARAM_STR);
			$queryD->execute();
			$resultD = $queryD->fetch(PDO::FETCH_ASSOC);
			if ($queryD->rowCount() == 0) {
				return 5; // Referral username does not exist
			}
			if ($resultD["sRegStatus"] != 0) {
				return 6; // Referral account is inactive
			}
		}

		// Insert And Register Member
		$hash = substr(sha1(md5($password)), 3, 10);
		$apiKey = substr(str_shuffle("0123456789ABCDEFGHIJklmnopqrstvwxyzAbAcAdAeAfAgAhBaBbBcBdC1C23C3C4C5C6C7C8C9xix2x3"), 0, 60) . time();
		$varCode = mt_rand(2000, 9000);

		$sql = "INSERT INTO subscribers (sUsername, sEmail, sPass, sApiKey, sVerCode, sRegStatus, sReferal) 
					VALUES (:username, :email, :pass, :k, :code, 3, :ref)";
		$query = $dbh->prepare($sql);

		$query->bindParam(':username', $username, PDO::PARAM_STR);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->bindParam(':pass', $hash, PDO::PARAM_STR);
		$query->bindParam(':k', $apiKey, PDO::PARAM_STR);
		$query->bindParam(':code', $varCode, PDO::PARAM_STR);
		$query->bindParam(':ref', $referral, PDO::PARAM_STR);
		$query->execute();

		$lastInsertId = $dbh->lastInsertId();
		if ($lastInsertId) {
			$data = 0; // Success

			if ($saveCookies) {
				// Set session variables
				$_SESSION["loginId"] = $lastInsertId;
				$_SESSION["loginName"] = $username;
				$_SESSION["loginEmail"] = $email;

				// Set cookies
				$loginId = base64_encode($lastInsertId);
				$loginName = base64_encode($username);
				$loginAccount = base64_encode("1");

				setcookie("loginAccount", $loginAccount, time() + (2592000 * 30), "/");
				setcookie("loginId", $loginId, time() + (2592000 * 30), "/");
				setcookie("loginName", $loginName, time() + (31540000 * 30), "/");
				setcookie("loginEmail", base64_encode($email), time() + (31540000 * 30), "/");

				// Generate User Login Token
				$randomToken = substr(str_shuffle("ABCDEFGHIJklmnopqrstvwxyz"), 0, 10);
				$userLoginToken = time() . $randomToken . mt_rand(100, 1000);

				// Set User Login Token
				$_SESSION["loginAccToken"] = $userLoginToken;

				// Save New User Login Token For One Device Login Check
				$sqlAc = "INSERT INTO userlogin (user, token) VALUES (:user, :token)";
				$queryAc = $dbh->prepare($sqlAc);
				$queryAc->bindParam(':user', $lastInsertId, PDO::PARAM_STR);
				$queryAc->bindParam(':token', $userLoginToken, PDO::PARAM_STR);
				$queryAc->execute();
			}

			// Get site configuration for admin email
			$a = $this->getSiteConfiguration();
			$adminEmail = $a->email;

			// Send Welcome Email
			$subject = "Welcome to " . $this->sitename . " - Account Activation Required";
			$message = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color:' . $a->sitecolor . ';
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .welcome-text {
            font-size: 18px;
            margin-bottom: 25px;
            color: #444444;
        }
        .verification-container {
            background-color: #f0f7ff;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
            border-left: 4px solid #4b6cb7;
        }
        .verification-code {
            display: inline-block;
            background-color:' . $a->sitecolor . ';
            color: white;
            font-size: 26px;
            font-weight: bold;
            padding: 12px 30px;
            margin: 15px 0;
            border-radius: 5px;
            letter-spacing: 2px;
            box-shadow: 0 2px 8px rgba(75, 108, 183, 0.3);
        }
        .button {
            display: inline-block;
            background-color:' . $a->sitecolor . ';
            color: white;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .button:hover {
            background-color:' . $a->sitecolor . ';
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(75, 108, 183, 0.4);
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777777;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
        }
        .instructions {
            font-size: 15px;
            color: #555555;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to ' . $this->sitename . '</h1>
        </div>
        
        <div class="content">
            <p class="welcome-text">Hi ' . $username . ',</p>
            
            <p class="instructions">Thank you for joining ' . $this->sitename . '! Your account has been successfully created.</p>
            
            <p class="instructions">To complete your registration and activate your account, please use the verification code below:</p>
            
            <div class="verification-container">
                <div class="verification-code">' . $varCode . '</div>
                <p style="margin: 10px 0 0 0; font-size: 13px; color: #666666;">This code will expire in 15 Minute</p>
            </div>
            
            <p class="instructions">If you didn\'t create this account, please ignore this email or contact our support team immediately.</p>
            
            <div class="footer">
                <p>© ' . date("Y") . ' ' . $this->sitename . '. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
';

			self::sendMail($email, $subject, $message);

			// Send Notification Email To Admin
			$subject2 = "New User Registration (" . $this->sitename . ")";
			$message2 = "Hi Admin, A new user just registered on your platform.<br><br>";
			$message2 .= "Username: $username<br>Email: $email<br>";
			if (!empty($referral)) {
				$message2 .= "Referred by: $referral<br>";
			}
			$message2 .= "<br><i>Notification Powered by " . $this->sitename . "</i>";
			self::sendMail($adminEmail, $subject2, $message2);
		} else {
			$data = 4; // Database error
		}

		return $data;
	}
	//Login User Account
	public function loginUser($username, $key)
	{

		//Verify Registration Details
		$dbh = self::connect();
		$hash = substr(sha1(md5($key)), 3, 10);
		$c = "SELECT sId,sUsername,sFname,sLname,sEmail,sPass,sPhone,sState,sType,sRegStatus FROM subscribers WHERE (sUsername=:un OR sEmail=:em) AND sPass=:p";  // Notice the parentheses
		$queryC = $dbh->prepare($c);
		$queryC->bindParam(':p', $hash, PDO::PARAM_STR);
		$queryC->bindParam(':un', $username, PDO::PARAM_STR);
		$queryC->bindParam(':em', $username, PDO::PARAM_STR);
		$queryC->execute();
		$result = $queryC->fetch(PDO::FETCH_OBJ);
		if ($queryC->rowCount() > 0) {

			if ($result->sRegStatus == 1) {
				return 2;
			}

			$_SESSION["loginName"] = ($result->sUsername == "" || $result->sUsername == null) ? $result->sEmail : $result->sUsername;
			$_SESSION["loginPhone"] = ($result->sPhone === "" || $result->sPhone === NULL) ? "N/A" : $result->sPhone;
			$_SESSION["loginAccount"] = $result->sType;
			$_SESSION["loginId"] = $result->sId;
			$_SESSION["loginEmail"] = $result->sEmail;


			$loginId = base64_encode($result->sId);
			$loginState = base64_encode(($result->sState === "" || $result->sState === null) ? "N/A" : $result->sState);
			$loginAccount = base64_encode($result->sType);
			$loginPhone = base64_encode(($result->sPhone === "" || $result->sPhone === NULL) ? "N/A" : $result->sPhone);
			$loginName = base64_encode(($result->sUsername === "" || $result->sUsername === null) ? $result->sEmail : $result->sUsername);
			setcookie("loginId", $loginId, time() + (2592000 * 30), "/");
			setcookie("loginState", $loginState, time() + (2592000 * 30), "/");
			setcookie("loginAccount", $loginAccount, time() + (2592000 * 30), "/");
			setcookie("loginPhone", $loginPhone, time() + (31540000 * 30), "/");
			setcookie("loginName", $loginName, time() + (31540000 * 30), "/");

			//Generate User Login Token
			$randomToken = substr(str_shuffle("ABCDEFGHIJklmnopqrstvwxyz"), 0, 10);
			$userLoginToken = time() . $randomToken . mt_rand(100, 1000);

			//Set User Login Token
			$_SESSION["loginAccToken"] = $userLoginToken;

			//Save New User Login Token For One Device Login Check

			$sqlAc = "INSERT INTO userlogin (user,token) VALUES (:user,:token)";
			$queryAc = $dbh->prepare($sqlAc);
			$queryAc->bindParam(':user', $result->sId, PDO::PARAM_STR);
			$queryAc->bindParam(':token', $userLoginToken, PDO::PARAM_STR);
			$queryAc->execute();

			return 0;
		} else {
			return 1;
		}
	}


	//Recover User Account
	public function recoverUserLogin($email)
	{

		//Verify Registration Details
		$dbh = self::connect();
		$c = "SELECT sId,sFname,sUsername,sLname,sEmail,sPass FROM subscribers WHERE sEmail=:e";
		$queryC = $dbh->prepare($c);
		$queryC->bindParam(':e', $email, PDO::PARAM_STR);
		$queryC->execute();
		$result = $queryC->fetch(PDO::FETCH_OBJ);
		if ($queryC->rowCount() > 0) {

			//Genereate And Update Verification Code
			$varCode = mt_rand(2000, 9000);
			$stmt = "UPDATE subscribers SET sVerCode=$varCode WHERE sId=$result->sId";
			$query = $dbh->prepare($stmt);
			$query->execute();
			$a = $this->getSiteConfiguration();
			//Send Verification Code To User Email
			$email = $result->sEmail;
			$subject = "Account Recovery (" . $this->sitename . ")";
			$message = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px 0;
            background-color: #f5f7fa;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color:' . $a->sitecolor . ';
            color: white;
            padding: 25px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .verification-box {
            background-color: #f0f7ff;
            border-left: 4px solid' . $a->sitecolor . ';
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .verification-code {
            display: inline-block;
            background-color:' . $a->sitecolor . ';
            color: white;
            font-size: 24px;
            font-weight: bold;
            padding: 12px 25px;
            margin: 10px 0;
            border-radius: 5px;
            letter-spacing: 2px;
        }
        .button {
            display: inline-block;
            background-color:' . $a->sitecolor . ';
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ecf0f1;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>' . $this->sitename . '</h1>
        </div>
        
        <div class="content">
            <h3 style="color: #2c3e50;">Hi ' . $result->sUsername . ',</h3>
            
            <p>You recently requested a password recovery. Please use the verification code below to recover your account:</p>
            
            <div class="verification-box">
                <p style="margin: 0 0 10px 0;">Your verification code is:</p>
                <div class="verification-code">' . $varCode . '</div>
                <p style="margin: 10px 0 0 0; font-size: 12px;">(This code expires in 30 Minute)</p>
            </div>
            
            <p>If you didn\'t request this password reset, please ignore this email or contact our support team immediately.</p>
            
            <div class="footer">
                <p>© ' . date("Y") . ' ' . $this->sitename . '. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
';
			$check = self::sendMail($email, $subject, $message);
			if ($check == 0) {
				return 0;
			} else {
				return 2;
			}
		} else {
			return 1;
		}
	}
	// Resend Email
	public function resendVerificationCode($email)
	{

		//Verify Registration Details
		$dbh = self::connect();
		$c = "SELECT sId,sFname,sUsername,sLname,sEmail,sPass FROM subscribers WHERE sEmail=:e";
		$queryC = $dbh->prepare($c);
		$queryC->bindParam(':e', $email, PDO::PARAM_STR);
		$queryC->execute();
		$result = $queryC->fetch(PDO::FETCH_OBJ);
		if ($queryC->rowCount() > 0) {

			//Genereate And Update Verification Code
			$varCode = mt_rand(2000, 9000);
			$stmt = "UPDATE subscribers SET sVerCode=$varCode WHERE sId=$result->sId";
			$query = $dbh->prepare($stmt);
			$query->execute();
			$a = $this->getSiteConfiguration();
			//Send Verification Code To User Email
			$email = $result->sEmail;
			// Send Welcome Email
			$subject = "Welcome to " . $this->sitename . " - Account Activation Required";
			$message = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color:' . $a->sitecolor . ';
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .welcome-text {
            font-size: 18px;
            margin-bottom: 25px;
            color: #444444;
        }
        .verification-container {
            background-color: #f0f7ff;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
            border-left: 4px solid #4b6cb7;
        }
        .verification-code {
            display: inline-block;
            background-color:' . $a->sitecolor . ';
            color: white;
            font-size: 26px;
            font-weight: bold;
            padding: 12px 30px;
            margin: 15px 0;
            border-radius: 5px;
            letter-spacing: 2px;
            box-shadow: 0 2px 8px rgba(75, 108, 183, 0.3);
        }
        .button {
            display: inline-block;
            background-color:' . $a->sitecolor . ';
            color: white;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .button:hover {
            background-color:' . $a->sitecolor . ';
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(75, 108, 183, 0.4);
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #777777;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
        }
        .instructions {
            font-size: 15px;
            color: #555555;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to ' . $this->sitename . '</h1>
        </div>
        
        <div class="content">
            <p class="welcome-text">Hi ' . $result->sUsername . ',</p>
            
            <p class="instructions">Thank you for joining ' . $this->sitename . '! Your account has been successfully created.</p>
            
            <p class="instructions">To complete your registration and activate your account, please use the verification code below:</p>
            
            <div class="verification-container">
                <div class="verification-code">' . $varCode . '</div>
                <p style="margin: 10px 0 0 0; font-size: 13px; color: #666666;">This code will expire in 15 Minute</p>
            </div>
            
            <p class="instructions">If you didn\'t create this account, please ignore this email or contact our support team immediately.</p>
            
            <div class="footer">
                <p>© ' . date("Y") . ' ' . $this->sitename . '. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
';

			$checksend = self::sendMail($email, $subject, $message);
			if ($checksend == 0) {
				return 0;
			} else {
				return 2;
			}
		} else {
			return 1;
		}
	}
	//Recover User Account
	public function verifyRecoveryCode($email, $code)
	{

		//Verify Registration Details
		$dbh = self::connect();
		$c = "SELECT sId FROM subscribers WHERE sEmail=:e AND sVerCode=:c";
		$queryC = $dbh->prepare($c);
		$queryC->bindParam(':e', $email, PDO::PARAM_STR);
		$queryC->bindParam(':c', $code, PDO::PARAM_STR);
		$queryC->execute();
		if ($queryC->rowCount() > 0) {
			return 0;
		} else {
			return 1;
		}
	}

	//Recover Seller Account
	public function updateUserKey($email, $code, $key)
	{

		//Verify Registration Details
		$dbh = self::connect();
		$hash = substr(sha1(md5($key)), 3, 10);
		$verCode = mt_rand(1000, 9999);
		$c = "UPDATE subscribers SET sPass=:k,sVerCode=:v WHERE sEmail=:e AND sVerCode=:c";
		$queryC = $dbh->prepare($c);
		$queryC->bindParam(':e', $email, PDO::PARAM_STR);
		$queryC->bindParam(':c', $code, PDO::PARAM_STR);
		$queryC->bindParam(':k', $hash, PDO::PARAM_STR);
		$queryC->bindParam(':v', $verCode, PDO::PARAM_INT);
		if ($queryC->execute()) {
			return 0;
		} else {
			return 1;
		}
	}


	//Create Virtual Bank Account
	public function createVirtualBankAccount($id, $fname, $lname, $phone, $email, $monnifyApi, $monnifySecret, $monnifyContract)
	{

		$fullname = $fname . " " . $lname;
		$accessKey = "$monnifyApi:$monnifySecret";
		$apiKey = base64_encode($accessKey);

		//Get Authorization Data
		$url = 'https://api.monnify.com/api/v1/auth/login';
		//$url = "https://sandbox.monnify.com/api/v1/auth/login/";
		$url2 = "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
		//$url2 = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				"Authorization: Basic {$apiKey}",
			),
		));


		$json = curl_exec($ch);
		$result = json_decode($json);
		curl_close($ch);

		$accessToken = $result->responseBody->accessToken;
		$ref = uniqid() . rand(1000, 9000);

		//Request Account Creation
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL =>  $url2,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>
			'{
											"accountReference": "' . $ref . '",
											"accountName": "' . $fullname . '",
											"currencyCode": "NGN",
											"contractCode": "' . $monnifyContract . '",
											"customerEmail": "' . $email . '",
											"bvn": "22433145825",
											"customerName": "' . $fullname . '",
											"getAllAvailableBanks": false,
											"preferredBanks": ["035"]
										
									}',
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $accessToken,
				"Content-Type: application/json"
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$value = json_decode($response, true);

		//Check And Save Account Details
		if ($value["requestSuccessful"] == true) {
			$account_name  = $value["responseBody"]["accountName"];
			if ($value["responseBody"]["accounts"][0]["bankCode"] == "035") {
				$wema =  $value["responseBody"]["accounts"][0]["accountNumber"];
				$wema_name = $value["responseBody"]["accounts"][0]["bankName"];

				$dbh = self::connect();
				$c = "UPDATE subscribers SET sBankName=:bn,sBankNo=:bno WHERE sId=$id";
				$queryC = $dbh->prepare($c);
				$queryC->bindParam(':bn', $wema_name, PDO::PARAM_STR);
				$queryC->bindParam(':bno', $wema, PDO::PARAM_STR);
				$queryC->execute();
			}
		}
	}

	//Create Virtual Bank Account
	public function createVirtualBankAccount2($id, $fname, $lname, $phone, $email, $monnifyApi, $monnifySecret, $monnifyContract)
	{

		$fullname = $fname . " " . $lname;
		$accessKey = "$monnifyApi:$monnifySecret";
		$apiKey = base64_encode($accessKey);

		//Get Authorization Data
		$url = 'https://api.monnify.com/api/v1/auth/login';
		//$url = "https://sandbox.monnify.com/api/v1/auth/login/";
		$url2 = "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
		//$url2 = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				"Authorization: Basic {$apiKey}",
			),
		));


		$json = curl_exec($ch);
		$result = json_decode($json);
		curl_close($ch);

		$accessToken = $result->responseBody->accessToken;
		$ref = uniqid() . rand(1000, 9000);

		//Request Account Creation
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL =>  $url2,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>
			'{
											"accountReference": "' . $ref . '",
											"accountName": "' . $fullname . '",
											"currencyCode": "NGN",
											"contractCode": "' . $monnifyContract . '",
											"customerEmail": "' . $email . '",
											"bvn": "22433145825",
											"customerName": "' . $fullname . '",
											"getAllAvailableBanks": false,
											"preferredBanks": ["50515","232"]
										
									}',
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $accessToken,
				"Content-Type: application/json"
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$value = json_decode($response, true);

		//Check And Save Account Details
		if ($value["requestSuccessful"] == true) {
			$account_name  = $value["responseBody"]["accountName"];
			$rolex = "";
			$sterling = "";

			if ($value["responseBody"]["accounts"][0]["bankCode"] == "50515") {
				$rolex =  $value["responseBody"]["accounts"][0]["accountNumber"];
			} elseif ($value["responseBody"]["accounts"][1]["bankCode"] == "50515") {
				$rolex =  $value["responseBody"]["accounts"][1]["accountNumber"];
			} else {
			}

			if ($value["responseBody"]["accounts"][0]["bankCode"] == "232") {
				$sterling =  $value["responseBody"]["accounts"][0]["accountNumber"];
			} elseif ($value["responseBody"]["accounts"][1]["bankCode"] == "232") {
				$sterling =  $value["responseBody"]["accounts"][1]["accountNumber"];
			} else {
			}

			//Save Account Number

			$dbh = self::connect();
			$c = "UPDATE subscribers SET sRolexBank=:rb,sSterlingBank=:sb WHERE sId=$id";
			$queryC = $dbh->prepare($c);
			$queryC->bindParam(':rb', $rolex, PDO::PARAM_STR);
			$queryC->bindParam(':sb', $sterling, PDO::PARAM_STR);
			$queryC->execute();
		}
	}

	//Create Virtual Bank Account
	public function createVirtualBankAccount3($id, $fname, $lname, $phone, $email, $monnifyApi, $monnifySecret, $monnifyContract)
	{

		$fullname = $fname . " " . $lname;
		$accessKey = "$monnifyApi:$monnifySecret";
		$apiKey = base64_encode($accessKey);

		//Get Authorization Data
		$url = 'https://api.monnify.com/api/v1/auth/login';
		//$url = "https://sandbox.monnify.com/api/v1/auth/login/";
		$url2 = "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts";
		//$url2 = "https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts";
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				"Authorization: Basic {$apiKey}",
			),
		));


		$json = curl_exec($ch);
		$result = json_decode($json);
		curl_close($ch);

		$accessToken = $result->responseBody->accessToken;
		$ref = uniqid() . rand(1000, 9000);

		//Request Account Creation
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL =>  $url2,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>
			'{
											"accountReference": "' . $ref . '",
											"accountName": "' . $fullname . '",
											"currencyCode": "NGN",
											"contractCode": "' . $monnifyContract . '",
											"customerEmail": "' . $email . '",
											"bvn": "22433145825",
											"customerName": "' . $fullname . '",
											"getAllAvailableBanks": false,
											"preferredBanks": ["070"]
										
									}',
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $accessToken,
				"Content-Type: application/json"
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$value = json_decode($response, true);

		//Check And Save Account Details
		if ($value["requestSuccessful"] == true) {
			$account_name  = $value["responseBody"]["accountName"];
			$fidelityBank = "";

			if ($value["responseBody"]["accounts"][0]["bankCode"] == "070") {
				$fidelityBank =  $value["responseBody"]["accounts"][0]["accountNumber"];
			} elseif ($value["responseBody"]["accounts"][1]["bankCode"] == "070") {
				$fidelityBank =  $value["responseBody"]["accounts"][1]["accountNumber"];
			} else {
			}


			//Save Account Number

			$dbh = self::connect();
			$c = "UPDATE subscribers SET sFidelityBank=:fb WHERE sId=$id";
			$queryC = $dbh->prepare($c);
			$queryC->bindParam(':fb', $fidelityBank, PDO::PARAM_STR);
			$queryC->execute();
		}
	}
}

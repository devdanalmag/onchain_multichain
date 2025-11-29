<?php
    //Auto Load Classes
     require_once("../autoloader.php");
    
    //Allowed API Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: POST");
    header("Allow: POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

    $headers = getallheaders();
    $response = array();
    $controller = new ApiAccess;
    $controller2 = new Electricity;
    date_default_timezone_set('Africa/Lagos');
    
    //echo json_encode($headers);
    //exit();

    // -------------------------------------------------------------------
    //  Check Request Method
    // -------------------------------------------------------------------

    $requestMethod = $_SERVER["REQUEST_METHOD"]; 
    if ($requestMethod !== 'POST') {
        header('HTTP/1.0 400 Bad Request');
        $response["status"] = "fail";
        $response["msg"] = "Only POST method is allowed";
        echo json_encode($response); exit(); 
    } 
    
    // -------------------------------------------------------------------
    //  Check For Api Authorization
    // -------------------------------------------------------------------
   
    if((isset($headers['Authorization']) || isset($headers['authorization'])) || (isset($headers['Token']) || isset($headers['token']))){
        if((isset($headers['Authorization']) || isset($headers['authorization']))){
            $token = trim(str_replace("Token", "", (isset($headers['Authorization'])) ? $headers['Authorization'] : $headers['authorization']));
        }
        if((isset($headers['Token']) || isset($headers['token']))){
            $token = trim(str_replace("Token", "", (isset($headers['Token'])) ? $headers['Token'] : $headers['token']));
        }
        $result=$controller->validateAccessToken($token);
        if($result["status"] == "fail"){
            // tell the user no products found
            header('HTTP/1.0 401 Unauthorized');
            $response["status"] = "fail";
            $response["msg"] = "Authorization token not found $token";
            echo json_encode($response); exit(); 
        }
        else{
            $usertype = $result["usertype"];
            $userbalance = (float) $result["balance"]; 
            $userid = $result["userid"];
            $refearedby = $result["refearedby"];
            $referal = $result["phone"];
            $referalname = $result["name"];
         }
    }
    else{
        header('HTTP/1.0 401 Unauthorized');
        // tell the user no products found
        $response["status"] = "fail";
        $response["msg"] = "Your authorization token is required.";
        echo json_encode($response); exit(); 
    }

    // -------------------------------------------------------------------
    //  Get The Request Details
    // -------------------------------------------------------------------

    $input = @file_get_contents("php://input");
    
    //decode the json file
    $body = json_decode($input);

    // Support Other API Format
    $body2 = array();   
    if(isset($body->MeterType)){$body2["metertype"]=$body->MeterType;}
    if(isset($body->disco_name)){$body2["provider"]=$body->disco_name;}
    if(isset($body->meter_number)){$body2["meternumber"]=$body->meter_number;}
    if(!isset($body->ref)){$body2["ref"]=time();}
    $body = (object) array_merge( (array)$body, $body2 );

    $provider= (isset($body->provider)) ? $body->provider : "";
    $meternumber= (isset($body->meternumber)) ? $body->meternumber : "";
    $amount= (isset($body->amount)) ? $body->amount : "";
    $ref= (isset($body->ref)) ? $body->ref : "";
    $metertype= (isset($body->metertype)) ? $body->metertype : "";
    $phone= (isset($body->phone)) ? $body->phone : "";

    
    
   
    // -------------------------------------------------------------------
    //  Check Inputs Parameters
    // -------------------------------------------------------------------

    $requiredField = "";
    
    if($amount == ""){$requiredField ="Amount Is Required"; }
    if($meternumber == ""){$requiredField ="Meter Number Is Required"; }
    if($provider == ""){$requiredField ="Provider Id Required"; }
    if($ref == ""){$requiredField ="Ref Is Required"; }
    if($metertype == ""){$requiredField ="Meter Type Is Required"; }

    $amount = (float) $amount;
    
    

    if($requiredField <> ""){
        header('HTTP/1.0 400 Parameters Required');
        $response['status']="fail";
        $response['msg'] = $requiredField;
        echo json_encode($response);
        exit();
    }

    
     // -------------------------------------------------------------------
    //  Verify Amount
    // -------------------------------------------------------------------
    
    if($amount < 1000){
        header('HTTP/1.0 400 Amount Low');
        $response['status']="fail";
        $response['msg'] = "Minimum Unit Purchase Is N1000";
        echo json_encode($response);
        exit();
    }

    // -------------------------------------------------------------------
    //  Verify Provider Id
    // -------------------------------------------------------------------
    
    $result = $controller->verifyElectricityId($provider);
    if($result["status"]=="fail"){
        header('HTTP/1.0 400 Invalid Provider Id');
        $response['status']="fail";
        $response['msg'] = "The Provider id is invalid";
        echo json_encode($response);
        exit();
    }
    else{
        $electricityid=$result['electricityid']; 
        $provider=$result['provider']; 
        $providerStatus=$result['providerStatus']; 
    }


    // -------------------------------------------------------------------
    //  Check If Network Is Available
    // -------------------------------------------------------------------
    
    if($providerStatus <> "On"){
        header('HTTP/1.0 400 Provider Not Available');
        $response['status']="fail";
        $response['msg'] = "Sorry, {$provider} is not available at the moment";
        echo json_encode($response);
        exit();
    }

    // -------------------------------------------------------------------
    //  Compute Amount To Pay And Profit
    // -------------------------------------------------------------------
    $siteSettings=$controller->getSiteSettings();
    $charges = (float) $siteSettings->electricitycharges;
    $amountopay = $amount + $charges;
    $profit = $charges;


    // -------------------------------------------------------------------
    //  Check Id User Balance Can Perform The Transaction
    // -------------------------------------------------------------------
    if($amountopay > $userbalance || $amountopay < 0){
            header('HTTP/1.0 400 Insufficient Balance');
            $response['status']="fail";
            $response['msg'] = "Insufficient balance fund your wallet and try again";
            echo json_encode($response);
            exit();
    }


    // -------------------------------------------------------------------
    //  Check For Api Authorization
    // -------------------------------------------------------------------
    
    $result = $controller->checkIfTransactionExist($ref);
    if($result["status"]=="fail"){
        header('HTTP/1.0 400 Transaction Ref Already Exist');
        $response['status']="fail";
        $response['msg'] = "Transaction Ref Already Exist";
        echo json_encode($response);
        exit();
    }

    // -------------------------------------------------------------------
    // Check For Duplicate Transaction Within Last Few Mins
    // -------------------------------------------------------------------

    $servicename = "Electricity Bill";
    $servicedesc = "Purchase of {$provider} ({$metertype}) Meter Unit of N{$amount} for Meter Number: {$meternumber}"; 
    
    $result = $controller->checkTransactionDuplicate($servicename,$servicedesc);
    if($result["status"]=="fail"){
        header('HTTP/1.0 400 Possible Transaction Duplicate, Please Verify Transaction & Try Again After 60 Seconds');
        $response['status']="fail";
        $response['msg'] = "Possible Transaction Duplicate, Please Verify Transaction & Try Again After 60 Seconds";
        echo json_encode($response);
        exit();
    }


    // -------------------------------------------------------------------
    // Purchase Unit Token
    // -------------------------------------------------------------------
    // -------------------------------------------------------------------

    // Debit User Before Performing The Transaction
    $oldbalance = (float) $userbalance;
    $deibt = $oldbalance - $amountopay;

    $checkDebit=$controller->debitUserBeforeTransaction($userid,$deibt);

    if($checkDebit <> "success"){
        header('HTTP/1.0 400 Could Not Complete Transaction');
        $response['status']="fail";
        $response['msg'] = "Could Not Complete Transaction";
        echo json_encode($response);
        exit();
    }

   
    // -------------------------------------------------------------------
    //  Send Request To Purchase Power
    // -------------------------------------------------------------------
    
    $result = $controller2->purchaseElectricityToken($body,$electricityid,$provider);

    
    // -------------------------------------------------------------------
    // Debit User Wallet & Record Transaction
    // -------------------------------------------------------------------
    
     
    if($result["status"]=="success"){
        $servicedesc.=". Your Unit Token Is '".$result["msg"]."'";
        if($refearedby <> ""){ $controller->creditReferalBonus($referal,$referalname,$refearedby,$servicename); }
        $transRecord = $controller->recordTransaction($userid,$servicename,$servicedesc,$amountopay,$userbalance,$body->ref,"0");
        $controller->saveProfit($body->ref,$profit);
        $response['status']="success";
        $response['Status']="successful";
        header('HTTP/1.0 200 Transaction Successful');
        echo json_encode($response);
        exit(); 
    } 
    else{
        header('HTTP/1.0 400 Transaction Failed');
        $response['status']="fail";
        $response['Status']="failed";
        $response['msg'] = $result["msg"];
        $transRecord = $controller->recordTransaction($userid,$servicename,$servicedesc,$amountopay,$userbalance,$body->ref,"1");
        echo json_encode($response);
        exit();
    }

?>
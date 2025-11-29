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
    $controller2 = new Exam;
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
    if(isset($body->exam_name)){$body2["provider"]=$body->exam_name;}
    if(!isset($body->ref)){$body2["ref"]=time();}
    $body = (object) array_merge( (array)$body, $body2 );

    $provider= (isset($body->provider)) ? $body->provider : "";
    $quantity= (isset($body->quantity)) ? $body->quantity : "";
    $ref= (isset($body->ref)) ? $body->ref : "";
    
    // -------------------------------------------------------------------
    //  Check Inputs Parameters
    // -------------------------------------------------------------------

    $requiredField = "";
    
    if($provider == ""){$requiredField ="Provider Id Required"; }
    if($ref == ""){$requiredField ="Ref Is Required"; }
    if($quantity == ""){$requiredField ="Quantity Is Required"; }
    

    if($requiredField <> ""){
        header('HTTP/1.0 400 Parameters Required');
        $response['status']="fail";
        $response['msg'] = $requiredField;
        echo json_encode($response);
        exit();
    }

    
    // -------------------------------------------------------------------
    //  Verify Provider Id
    // -------------------------------------------------------------------
    
    $result = $controller->verifyExamId($provider);
    if($result["status"]=="fail"){
        header('HTTP/1.0 400 Invalid Provider Id');
        $response['status']="fail";
        $response['msg'] = "The Provider id is invalid";
        echo json_encode($response);
        exit();
    }
    else{
        $examid=$result['examid']; $provider=$result['provider']; 
        $providerStatus=$result['providerStatus']; 
        $amount = (float) $result["amount"]; 
        $buying_price = (float) $result["buying_price"]; 
    }

    // Compute Amount To Pay
    $quantity = (float) $quantity;
    $amount = $amount * $quantity;
    $buying_price = $buying_price * $quantity;
    $amountopay = $amount;
    $profit = $amount - $buying_price;

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
    //  Check Id User Balance Can Perform The Transaction
    // -------------------------------------------------------------------
    if($amountopay > $userbalance  || $amountopay < 0){
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

    $servicename = "Exam Pin";
    $servicedesc = "Purchase of {$quantity} token of {$provider} pin for N{$amount}"; 
     
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
    //  Send Request To Purchase Exam
    // -------------------------------------------------------------------
    
    $result = $controller2->purchaseExamPinToken($body,$examid,$provider);
    
    
    // -------------------------------------------------------------------
    // Debit User Wallet & Record Transaction
    // -------------------------------------------------------------------
   
    
    if($result["status"]=="success"){
        $servicedesc.=". Your Pin Is: '".$result["msg"]."'";
        if($refearedby <> ""){ $controller->creditReferalBonus($referal,$referalname,$refearedby,$servicename);}
        $transRecord = $controller->recordTransaction($userid,$servicename,$servicedesc,$amountopay,$userbalance,$body->ref,"0");
        $controller->saveProfit($body->ref,$profit);
        $response['status']="success";
        $response['Status']="successful";
        $response['msg']=$result["msg"];
        $response['pin']=$result["msg"];
        $response['pins']=$result["msg"];
        $response['token']=$result["msg"];
        
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
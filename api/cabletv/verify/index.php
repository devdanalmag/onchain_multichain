<?php
    //Auto Load Classes
    require_once("../../autoloader.php");
    //Allowed API Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: POST");
    header("Allow: POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

    $headers = apache_request_headers();
    $response = array();
    $controller = new ApiAccess;
    $controller2 = new Cable;
    date_default_timezone_set('Africa/Lagos');
    

    // -------------------------------------------------------------------
    //  Check Request Method
    // -------------------------------------------------------------------

    $requestMethod = $_SERVER["REQUEST_METHOD"]; 
    if ($requestMethod !== 'POST' && $requestMethod !== 'GET') {
        header('HTTP/1.0 400 Bad Request');
        $response["status"] = "fail";
        $response["msg"] = "Only POST and GET method is allowed";
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
    if($requestMethod == 'GET'){
        if(isset($_GET["smart_card_number"])){$iucnumber=$_GET["smart_card_number"];}else{$iucnumber="";}
        if(isset($_GET["cablename"]))
        {
            if($_GET["cablename"] == "GOTV"): $provider = 1;
            elseif($_GET["cablename"] == "DSTV"): $provider = 2; 
            elseif($_GET["cablename"] == "STARTIMES"): $provider = 3; 
            else: $provider="";
            endif;
            
        }
        else{$provider="";}
        
        $provider = strip_tags($provider);
        $iucnumber = strip_tags($iucnumber);
        $body = [
            "provider" => $provider,
            "iucnumber" => $iucnumber
        ];
        
        $body = (object) $body;
      
    }
    else{
        $input = @file_get_contents("php://input");
        //decode the json file
        $body = json_decode($input);
        
        
        // Support Other API Format
        $body2 = array();   
        if(isset($body->smart_card_number)){$body2["iucnumber"]=$body->smart_card_number;}
        if(isset($body->cablename)){$body2["provider"]=$body->cablename;}
        if(!isset($body->ref)){$body2["ref"]=time();}
        
        $body = (object) array_merge( (array)$body, $body2 );
    
        $provider= (isset($body->provider)) ? $body->provider : "";
        $iucnumber= (isset($body->iucnumber)) ? $body->iucnumber : "";
    }
    // -------------------------------------------------------------------
    //  Check Inputs Parameters
    // -------------------------------------------------------------------

    $requiredField = "";
    
    if($iucnumber == ""){$requiredField ="IUC Number Is Required"; }
    if($provider == ""){$requiredField ="Cable Provider Id Required"; }
    
    if($requiredField <> ""){
        header('HTTP/1.0 400 Parameters Required');
        $response['status']="fail";
        $response['msg'] = $requiredField;
        echo json_encode($response);
        exit();
    }

    // -------------------------------------------------------------------
    //  Verify Cable Id
    // -------------------------------------------------------------------
    
    $result = $controller->verifyCableId($provider);
    if($result["status"]=="fail"){
        header('HTTP/1.0 400 Invalid Cable Provider Id');
        $response['status']="fail";
        $response['msg'] = "The Cable Provider id is invalid";
        echo json_encode($response);
        exit();
    }
    else{$cableid=$result['cableid']; $provider=$result['provider']; $providerStatus=$result['providerStatus']; }


    // -------------------------------------------------------------------
    //  Check If Network Is Available
    // -------------------------------------------------------------------
    
    if($providerStatus <> "On"){
        header('HTTP/1.0 400 Cable TV Not Available');
        $response['status']="fail";
        $response['msg'] = "Sorry, {$provider} Subscription is not available at the moment";
        echo json_encode($response);
        exit();
    }


    // -------------------------------------------------------------------
    // Verify Cable TV
    // -------------------------------------------------------------------
    // -------------------------------------------------------------------
    
    $result = $controller2->validateIUCNumber($body,$cableid,$provider);
    if($result["status"]=="success"){
        $response['status']="success";
        $response['Status']="successful";
        $response['msg']=$result["msg"];
        $response['name']=$result["msg"];
        $response['Customer_Name']=$result["msg"];
         header('HTTP/1.0 200 Successful');
        echo json_encode($response);
        exit(); 
    }
    else{
        header('HTTP/1.0 400 Transaction Failed');
        $response['status']="fail";
        $response['Status']="failed";
        $response['msg'] = "Could Not Verify Smart Card/IUC Number";
        echo json_encode($response);
        exit();
    }

?>
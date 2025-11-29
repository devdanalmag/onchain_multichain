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
    $controller2 = new Electricity;
    date_default_timezone_set('Africa/Lagos');
            


    // -------------------------------------------------------------------
    //  Check Request Method
    // -------------------------------------------------------------------

    $requestMethod = $_SERVER["REQUEST_METHOD"]; 
    if ($requestMethod !== 'POST' && $requestMethod !== 'GET') {
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
        if(isset($_GET["mtype"])){$mtype=$_GET["mtype"];}else{$mtype="";}
        if(isset($_GET["disconame"])){$disconame=$_GET["disconame"];}else{$disconame="";}
        if(isset($_GET["disco"])){$provider=$_GET["disco"];}else{$provider="";}
        if(isset($_GET["meternumber"])){$meternumber=$_GET["meternumber"];}else{$meternumber="";}
        
       
        $provider = strip_tags($provider);
        $mtype = strip_tags($mtype);
        $meternumber = strip_tags($meternumber);
        $disconame = strip_tags($disconame);
        
        $body = [
            "mtype" => $mtype,
            "provider" => $provider,
            "meternumber" => $meternumber
        ];
        
        $body = (object) $body;
      
    }
    else{
        $input = @file_get_contents("php://input");
        //decode the json file
        $body = json_decode($input);
    
        // Support Other API Format
        $body2 = array();   
        if(isset($body->disconame)){$body2["provider"]=$body->disconame;}
        if(!isset($body->ref)){$body2["ref"]=time();}
        $body = (object) array_merge( (array)$body, $body2 );
    
        $provider= (isset($body->provider)) ? $body->provider : "";
        $meternumber= (isset($body->meternumber)) ? $body->meternumber : "";
        $metertype= (isset($body->metertype)) ? $body->metertype : "";
    }
   
    // -------------------------------------------------------------------
    //  Check Inputs Parameters
    // -------------------------------------------------------------------

    $requiredField = "";
    
    if($metertype == ""){$requiredField ="Meter Type Is Required"; }
    if($meternumber == ""){$requiredField ="Meter Number Is Required"; }
    if($provider == ""){$requiredField ="Unit Provider Id Required"; }
    
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
    
    $result = $controller->verifyElectricityId($provider);
    if($result["status"]=="fail"){
        header('HTTP/1.0 400 Invalid Electricity Provider Id');
        $response['status']="fail";
        $response['msg'] = "The Electricity Provider id is invalid";
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
        header('HTTP/1.0 400 Electricity Not Available');
        $response['status']="fail";
        $response['msg'] = "Sorry, {$provider} is not available at the moment";
        echo json_encode($response);
        exit();
    }

    

    // -------------------------------------------------------------------
    // Verify Meter No
    // -------------------------------------------------------------------
    // -------------------------------------------------------------------
    
    $result = $controller2->validateMeterNumber($body,$electricityid,$provider);
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
        $response['msg'] = "Could Not Verify Meter Number";
        echo json_encode($response);
        exit();
    }

?>
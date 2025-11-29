<?php
    //Auto Load Classes
    require_once("../autoloader.php");

    //Allowed API Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: POST");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

    $headers = apache_request_headers();
    $response = array();
    $controller = new ApiAccess;
    

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
        $result = $controller->validateAccessToken($token);
        if($result["status"] == "fail"){
            // tell the user no products found
            header('HTTP/1.0 500 Unauthorized');
            $response["status"] = "fail";
            $response["msg"] = "Authorization token not found $token";
            echo json_encode($response); exit(); 
        }
    }
    else{
        header('HTTP/1.0 500 Unauthorized');
        // tell the user no products found
        $response["status"] = "fail";
        $response["msg"] = "Your authorization token is required.";
        echo json_encode($response); exit(); 
    }

    // -------------------------------------------------------------------
    //  Get User Details
    // -------------------------------------------------------------------
    $response = $controller->getUserDetails($token);
    $response["status"] = "success";
    echo json_encode($response); exit();


?>
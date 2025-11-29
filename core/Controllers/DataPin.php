<?php

class DataPin extends ApiAccess{
    

     //Purchase Data
    public function purchaseDataPin($body,$networkDetails,$datagroup,$actualPlanId){

        $response = array();
        $details=$this->model->getApiDetails();
        $thenetworkId=$networkDetails["networkid"];
        //Get Api Key Details
        $host = self::getConfigValue($details,"dataPinProvider");
        $apiKey = self::getConfigValue($details,"dataPinApi");

        //Check If API Is Is Using N3TData Or Bilalsubs
        if(strpos($host, 'n3tdata247') !== false){
            $hostuserurl="https://n3tdata247.com/api/user/";
            return $this->purchaseDataWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId,$actualPlanId);
        }

        if(strpos($host, 'bilalsadasub') !== false){
            $hostuserurl="https://bilalsadasub.com/api/user/";
            return $this->purchaseDataWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId,$actualPlanId);
        }

        if(strpos($host, 'beensade') !== false){
            $hostuserurl="https://beensadeprint.com/api/user/";
            return $this->purchaseDataWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId,$actualPlanId);
        }
        
        // ------------------------------------------
        //  Purchase Data
        // ------------------------------------------
        
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $host,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "network": "'.$thenetworkId.'",
            "mobile_number": "'.$body->phone.'",
            "request-id" : "'.$body->ref.'",
            "plan": "'.$actualPlanId.'"
        }',
        
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: Token $apiKey"
        ),
        ));

        $exereq = curl_exec($curl);
        $err = curl_error($curl);
        
        if($err){
            $response["status"] = "fail";
            $response["msg"] = "Server Connection Error"; //.$err;
            file_put_contents("data_error_log2.txt",json_encode($response)." ".$err." ".$host);
            curl_close($curl);
            return $response;
        }

        $result=json_decode($exereq);
        curl_close($curl);
        

        if($result->Status=='successful' || $result->Status=='processing'){
            $response["status"] = "success";
        }
        elseif($result->Status=='failed'){
            $response["status"] = "fail";
            $response["msg"] = "Network Error, Please Try Again Later";
        }
        else{
            $response["status"] = "fail";
            $response["msg"] = "Server/Network Error: ".$result->error[0];
            file_put_contents("data_error_log.txt",json_encode($result));
        }

        return $response;
    }

    //Purchase Data
    public function purchaseDataWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$thenetworkId,$actualPlanId){

        $response = array();
        
        // ------------------------------------------
        //  Get User Access Token
        // ------------------------------------------
        
        
        $curlA = curl_init();
        curl_setopt_array($curlA, array(
            CURLOPT_URL => $hostuserurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic $apiKey",
            ),
        ));
    
        $exereqA = curl_exec($curlA);
        $err = curl_error($curlA);
        
        if($err){
            $response["status"] = "fail";
            $response["msg"] = "Server Connection Error"; //.$err;
            curl_close($curlA);
            return $response;
        }
        $resultA=json_decode($exereqA);
        $apiKey=$resultA->AccessToken;
        curl_close($curlA);
    
        
        // ------------------------------------------
        //  Purchase Data
        // ------------------------------------------
    
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $host,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "network": "'.$thenetworkId.'",
            "card_name": "'.$body->businessname.'",
            "request-id" : "'.$body->ref.'",
            "quantity": "'.$body->quantity.'",
            "plan_type": "'.$actualPlanId.'"
        }',
        
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: Token $apiKey"
        ),
        ));

        $exereq = curl_exec($curl);
        $err = curl_error($curl);
        
        if($err){
            $response["status"] = "fail";
            $response["msg"] = "Server Connection Error"; //.$err;
            file_put_contents("basic_error_log2.txt",json_encode($response));
            curl_close($curl);
            return $response;
        }

        $result=json_decode($exereq);
        curl_close($curl);
        
        if($result->status=='successful' || $result->status=='success'){
            $response["status"] = "success";
            $response["quantity"] = $result->quantity;
            $response["serial"] = $result->serial;
            $response["pin"] = $result->pin;
        }
        elseif($result->status=='fail'){
            $response["status"] = "fail";
            $response["msg"] = "Network Error, Please Try Again Later";
             file_put_contents("datapin_error_log.txt",json_encode($result));
        }
        else{
            $response["status"] = "fail";
            $response["msg"] = "Server Error: ".$result->message;
            file_put_contents("basic_data_error_log.txt",json_encode($result));
        }

        return $response;
    }
    

}

?>
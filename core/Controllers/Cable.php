<?php

    class Cable extends ApiAccess{
        

        //Verify Cable Tv Number
		public function validateIUCNumber($body,$cableid,$provider){

			$response = array();
            $details=$this->model->getApiDetails();
            
            //Get Ap Details
            $host = self::getConfigValue($details,"cableVerificationProvider");
            $apiKey = self::getConfigValue($details,"cableVerificationApi");

            //Set Authentication Type And Parameters
            $aunType = "Basic";

            if(strpos($host, 'n3tdata') !== false){
                $aunType = "Basic";
                $host = $host . "?iuc=".$body->iucnumber."&cable=".$cableid;
            }
            elseif (strpos($host, 'bilalsadasub') !== false){
                $aunType = "Basic";
                $host = $host . "?iuc=".$body->iucnumber."&cable=".$cableid;
            }
            else{
                $aunType = "Token";
                $host = $host . "?smart_card_number=".$body->iucnumber."&cablename=".$provider;
            }
             
            // ------------------------------------------
            //  Verify Cable Plan
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
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: $aunType $apiKey"
            ),
            ));

            $exereq = curl_exec($curl);

            $err = curl_error($curl);

            if($err){
                $response["status"] = "fail";
                $response["msg"] = "Server Connection Error";
                file_put_contents("iuc_error_log2.txt",json_encode($response).$err);
                curl_close($curl);
                return $response;
            }
 
            $result=json_decode($exereq);
            curl_close($curl);
            
            
            if(isset($result->name)){
                $response["status"] = "success";
                $response["msg"] = $result->name;
                $response["others"] = $result;
            }
            else{
                $response["status"] = "fail";
                file_put_contents("iuc_error_log.txt",json_encode($result));
            }

            return $response;
		}

        //Purchase Cable Tv
        public function purchaseCableTv($body,$cableid,$provider,$cableplan){

			$response = array();
            $details=$this->model->getApiDetails();

            $host = self::getConfigValue($details,"cableProvider");
            $apiKey = self::getConfigValue($details,"cableApi");

            //Check If API Is Is Using N3TData Or Bilalsubs
            if(strpos($host, 'n3tdata') !== false){
                $hostuserurl="https://n3tdata.com/api/user/";
                return $this->purchaseCableWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$cableid,$provider,$cableplan);
            }

            if(strpos($host, 'bilalsadasub') !== false){
                $hostuserurl="https://bilalsadasub.com/api/user/";
                return $this->purchaseCableWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$cableid,$provider,$cableplan);
            }
           
            // ------------------------------------------
            //  Purchase Cable Plan
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
                "cablename": "'.$cableid.'",
                "smart_card_number": "'.$body->iucnumber.'",
                "cableplan":"'.$cableplan.'"
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
                $response["msg"] = "Server Connection Error";
                file_put_contents("cable_error_log2.txt",json_encode($response).$err);
                curl_close($curl);
                return $response;
            }
 
            $result=json_decode($exereq);
            curl_close($curl);
            
            if($result->Status=='successful' || $result->status=='success'){
                $response["status"] = "success";
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error: ".$result->msg;
                file_put_contents("cable_error_log.txt",json_encode($result));
            }

            return $response;
		} 





        //Purchase Cable Tv
        
		public function purchaseCableWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$cableid,$provider,$cableplan){

			$response = array();
            $details=$this->model->getApiDetails();

            $host = self::getConfigValue($details,"cableProvider");
            $apiKey = self::getConfigValue($details,"cableApi");
           
            // ------------------------------------------
            //  Get User Access Token
            // ------------------------------------------
            
            $curlA = curl_init();
            curl_setopt_array($curlA, array(
                CURLOPT_URL => $hostuserurl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic  $apiKey",
                    'Content-Type: application/json'
                ),
            ));
        
            $exereqA = curl_exec($curlA);
            $err = curl_error($curlA);
            
            if($err){
                $response["status"] = "fail";
                $response["msg"] = "Server Connection Error";
                file_put_contents("cable_error_log2.txt",json_encode($response).$err);
                curl_close($curlA);
                return $response;
            }

            $resultA=json_decode($exereqA);
            $apiKey=$resultA->AccessToken;
            curl_close($curlA);
            
            
            // ------------------------------------------
            //  Purchase Cable Plan
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
                "cable": "'.$cableid.'",
                "iuc": "'.$body->iucnumber.'",
                "cable_plan":"'.$cableplan.'",
                "bypass" : false,
                "request-id" : "'.$body->ref.'"
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
                $response["msg"] = "Server Connection Error";
                file_put_contents("cable_error_log2.txt",json_encode($response).$err);
                curl_close($curl);
                return $response;
            }
 
            $result=json_decode($exereq);
            curl_close($curl);
            
            if($result->status=='successful' || $result->status=='success'){
                $response["status"] = "success";
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error: ".$result->msg;
                file_put_contents("cable_error_log.txt",json_encode($result));
            }

            return $response;
		} 


    }

?>
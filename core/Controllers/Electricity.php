<?php

    class Electricity extends ApiAccess{
        

         // ------------------------------------------------------------------------------
        // Electricity Bills Payment
        // ------------------------------------------------------------------------------

        //Verify Meter Number
		public function validateMeterNumber($body,$electricityid,$provider){

			$response = array();
            $details=$this->model->getApiDetails();
            
            //Get Ap Details
            $host = self::getConfigValue($details,"meterVerificationProvider");
            $apiKey = self::getConfigValue($details,"meterVerificationApi");

            //Set Authentication Type And Parameters
            $aunType = "Basic";

            if(strpos($host, 'n3tdata') !== false){
                $aunType = "Basic";
                $host = $host . "?meter_type=".$body->metertype."&disco=".$electricityid."&meter_number=".$body->meternumber;
            }
            elseif (strpos($host, 'bilalsadasub') !== false){
                $aunType = "Basic";
                $host = $host . "?meter_type=".$body->metertype."&disco=".$electricityid."&meter_number=".$body->meternumber;
            }
            else{
                $aunType = "Token";
                $disconame = str_replace(" ","-",strtolower($provider));
                $host = $host . "?mtype=".$body->metertype."&disconame=".$disconame."&disco=".$electricityid."&meternumber=".$body->meternumber;
            }
            
           
             
            // ------------------------------------------
            //  Verify Meter No
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
                file_put_contents("meter_ver_error_log.txt",json_encode($response).$err);
                curl_close($curl);
                return $response;
            }

 
            $result=json_decode($exereq);
            curl_close($curl);
            
           
            if(isset($result->Customer_Name)){
                $response["status"] = "success";
                $response["msg"] = $result->Customer_Name;
                $response["others"] = $result;
            }
            elseif(isset($result->name)){
                $response["status"] = "success";
                $response["msg"] = $result->name;
                $response["others"] = $result;
            }
            else{
                $response["status"] = "fail";
                file_put_contents("meter_ver_error_log.txt",json_encode($result).$host);
            }

            return $response;
		}


        //Purchase Electricity Unit
		public function purchaseElectricityToken($body,$electricityid,$provider){

			
            $response = array();
            $details=$this->model->getApiDetails();
            
            //Get Ap Details
            $host = self::getConfigValue($details,"meterProvider");
            $apiKey = self::getConfigValue($details,"meterApi");

            //Check If API Is Is Using N3TData Or Bilalsubs
            if(strpos($host, 'n3tdata') !== false){
                $hostuserurl="https://n3tdata.com/api/user/";
                return $this->purchaseMeterWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$electricityid,$provider);
            }

            if(strpos($host, 'bilalsadasub') !== false){
                $hostuserurl="https://bilalsadasub.com/api/user/";
                return $this->purchaseMeterWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$electricityid,$provider);
            }

           
            // ------------------------------------------
            //  Purchase Electricity
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
                "disco_name": "'.$electricityid.'",
                "meter_number": "'.$body->meternumber.'",
                "MeterType": "'.ucfirst($body->metertype).'",
                "amount": "'.$body->amount.'"
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
                $response["msg"] = "Server Connection Error: ".$err;
                file_put_contents("meter_purchase_error_log.txt",json_encode($response));
                curl_close($curl);
                return $response;
            }

            $result=json_decode($exereq);
            curl_close($curl);

            if($result->Status=='successful' || $result->status=='success'){
                $response["status"] = "success";
                $response["msg"] = $result->token;
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error: ".$result->error[0];
                file_put_contents("meter_purchase_error_log.txt",json_encode($result));
            }

            return $response;
		}

        //Purchase Electricity Unit
		public function purchaseMeterWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$electricityid,$provider){

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
                $response["msg"] = "Server Connection Error: ".$err;
                file_put_contents("meter_purchase_error_log.txt",json_encode($response));
                curl_close($curlA);
                return $response;
            }
            $resultA=json_decode($exereqA);
            $apiKey=$resultA->AccessToken;
            curl_close($curlA);
        
           
            // ------------------------------------------
            //  Purchase Electricity
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
                "disco": "'.$electricityid.'",
                "meter_type": "'.$body->metertype.'",
                "meter_number": "'.$body->meternumber.'",
                "bypass":true,
                "request-id" : "'.$body->ref.'",
                "amount": "'.$body->amount.'",
                "phone": "'.$body->phone.'"
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
                $response["msg"] = "Server Connection Error: ".$err;
                file_put_contents("meter_purchase_error_log.txt",json_encode($response));
                curl_close($curl);
                return $response;
            }

            $result=json_decode($exereq);
            curl_close($curl);

           

            if($result->status=='successful' || $result->status=='success'){
                $response["status"] = "success";
                $response["msg"] = $result->token;
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error: ".$result->msg;
                file_put_contents("meter_purchase_error_log.txt",json_encode($result));
            }

            return $response;
		}


    }

?>
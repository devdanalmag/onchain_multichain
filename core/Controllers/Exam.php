<?php

    class Exam extends ApiAccess{
         

        //Purchase Exam Pin Token
		public function purchaseExamPinToken($body,$examid,$provider){

            $response = array();
            $details=$this->model->getApiDetails();
            

            $host = self::getConfigValue($details,"examProvider");
            $apiKey = self::getConfigValue($details,"examApi");

            //Check If API Is Is Using N3TData Or Bilalsubs
            if(strpos($host, 'n3tdata') !== false){
                $hostuserurl="https://n3tdata.com/api/user/";
                return $this->purchaseExamWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$examid);
            }

            if(strpos($host, 'bilalsadasub') !== false){
                $hostuserurl="https://bilalsadasub.com/api/user/";
                return $this->purchaseExamWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$examid);
            }

            // ------------------------------------------
            //  Purchase Exam Pin
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
                "exam_name": "'.$provider.'",
                "quantity": "'.$body->quantity.'"
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
                file_put_contents("exampin_purchase_error_log.txt2",json_encode($response).$err);
                curl_close($curl);
                return $response;
            }

            $result=json_decode($exereq);
            curl_close($curl);


            if($result->Status=='successful' || $result->status=='success'){
                file_put_contents("exampin2.txt",json_encode($result));
                $response["status"] = "success";
                if(isset($result->data_pin->pin)){$response["msg"] = $result->data_pin->pin;}
                elseif(isset($result->pins)){$response["msg"] = $result->pins;}
                elseif(isset($result->pin)){$response["msg"] = $result->pin;}
                else{$response["msg"] = "";}
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error: ".$result->msg;
                file_put_contents("exampin_purchase_error_log.txt",json_encode($result));
            }

            return $response;

        }


        public function purchaseExamWithBasicAuthentication($body,$host,$hostuserurl,$apiKey,$examid){

			
            // ---------------------------------------------------------------
            //  Get User Access Token
            // ---------------------------------------------------------------
            
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
                file_put_contents("exampin_purchase_error_log2.txt",json_encode($response).$err);
                curl_close($curlA);
                return $response;
            }
            $resultA=json_decode($exereqA);
            $apiKey=$resultA->AccessToken;
            curl_close($curlA);
        
           
            // ---------------------------------------------------------------
            //  Purchase Exam Pin
            // ---------------------------------------------------------------
        
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
                "exam": "'.$examid.'",
                "quantity": "'.$body->quantity.'"
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
                file_put_contents("exampin_purchase_error_log.txt2",json_encode($response).$err);
                curl_close($curl);
                return $response;
            }

            $result=json_decode($exereq);
            curl_close($curl);

            if($result->status=='successful' || $result->status=='success'){
                $response["status"] = "success";
                $response["msg"] = $result->pin;
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error: ".$result->msg;
                file_put_contents("exampin_purchase_error_log.txt",json_encode($result));
            }

            return $response;
		}



    }

?>
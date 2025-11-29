<?php

    class AlphaTopup extends ApiAccess{

        //Purchase Airtime
		public function purchaseAlphaTopup($body){

            $details=$this->model->getApiDetails();
            $response = array();
 
            $host = self::getConfigValue($details,"alphaProvider");
            $apiKey = self::getConfigValue($details,"alphaKey");
            $serverhost=$_SERVER["SERVER_NAME"];
            
            //Check If Server Is The API Provider
            if(strpos($host, $serverhost) !== false){
                $response["status"] = "success";
                $response["apiAccessMethod"] = "provider";
                return $response;
            }else{$response["apiAccessMethod"] = "consumer"; }

           
            // ------------------------------------------
            //  Purchase Airtime
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
                "amount": "'.$body->amount.'",
                "phone": "'.$body->phone.'",
                "ref" : "'.$body->ref.'"
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
                file_put_contents("alpha_airtime_error_log2.txt",json_encode($response).$err);
                curl_close($curl);
                return $response;
            }

            $result=json_decode($exereq);
            curl_close($curl);

            if($result->status=='success' || $result->status=='processing'){
                $response["status"] = "success";
            }
            else{
                $response["status"] = "fail";
                $response["msg"] = "Server/Network Error";
                file_put_contents("alpha_airtime_error_log.txt",json_encode($result));
            }

            return $response;
		}

        
    }

?>
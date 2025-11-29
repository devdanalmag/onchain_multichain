<?php

    class WalletBalance extends ApiAccess{

        //Get Wallet Balance
		public function getWalletBalance($wallet){

			$response = array();
            $details=$this->model->getApiDetails();
            
            

            if($wallet == "one"){$name="walletOneApi"; $name2="walletOneProvider"; $name3="walletOneProviderName";}
            if($wallet == "two"){$name="walletTwoApi"; $name2="walletTwoProvider"; $name3="walletTwoProviderName";}
            if($wallet == "three"){$name="walletThreeApi"; $name2="walletThreeProvider"; $name3="walletThreeProviderName";}

            $apiKey=self::getConfigValue($details,$name);
            $hostuserurl=self::getConfigValue($details,$name2);
            $apiProvider=self::getConfigValue($details,$name3);

            $aunType = "Basic"; $accMethod=0;
            if(strpos($hostuserurl, 'n3tdata247') !== false){$aunType = "Basic "; $accMethod=1;}
            elseif (strpos($hostuserurl, 'bilalsadasub') !== false){$aunType = "Basic "; $accMethod=1;}
            elseif (strpos($hostuserurl, 'n3tdata') !== false){$aunType = "Basic "; }
            else{$aunType = "Token";}

            // ------------------------------------------
            //  Get User Access Token
            // ------------------------------------------
            
             $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $hostuserurl);
                curl_setopt($ch, CURLOPT_POST, $accMethod);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt(
                   $ch, CURLOPT_HTTPHEADER, [
                        "Authorization: $aunType $apiKey",
                    ]
                );
            $json = curl_exec($ch);
            $result=json_decode($json);
            curl_close($ch);
           
            if(isset($result->user->wallet_balance)){
                $response["status"] = "success";
                $response["balance"] = $result->user->wallet_balance;
            }
            elseif(isset($result->wallet_balance)){
                $response["status"] = "success";
                $response["balance"] = $result->wallet_balance;
            }
            elseif(isset($result->balance)){
                $response["status"] = "success";
                $response["balance"] = $result->balance;
            }
            else{
                $response["status"] = "fail";
                $response["balance"] = "0";
            }

            $response["provider"] = $apiProvider;
            
            return $response;
        }   
        
    }

?>
<?php

    //Auto Load Classes
    require_once("../autoloader.php");
    require_once("../../core/helpers/vendor/autoload.php");
    header('Content-Type: application/json');
    
    $headers = getallheaders();
    $response = array();
    $controller = new ApiAccess;
    
    $input = @file_get_contents("php://input");
    $res = json_decode($input, true);
    
    if(is_array($res)):
        
        $hash = (isset($headers["Monnify-Signature"])) ? $headers["Monnify-Signature"] : $headers["monnify-signature"];
        $mnfy_email = $res["eventData"]["customer"]["email"];
       $amount_paid = $res["eventData"]["amountPaid"];
        $mnfy_trans_ref = $res["eventData"]["transactionReference"];
        $payment_status =  $res["eventData"]["paymentStatus"];
        $paidon = $res["eventData"]["paidOn"];
        $payment_ref = $res["eventData"]["paymentReference"];
        $email = $res["eventData"]['customer']['email'];

        //Verify The Transaction
        $check=$controller->verifyMonnifyRef($mnfy_email,$hash,$input);
        
        if($check["status"] == "success"):
            $userid = $check["userid"];
            $userbalance = $check["balance"];
            $charges = (float) $check["charges"];
           
            //Check If Transaction Was Successful
            if($res["eventType"] == 'SUCCESSFUL_TRANSACTION'):
                
                if ( $res["eventData"]["paymentStatus"] == "PAID"):
                        $chargesText = ($charges == 50 || $charges == "50") ? "N50" : $charges."%";
                        $servicename = "Wallet Topup";
                        $servicedesc = "Wallet funding of N{$amount_paid} via Monnify bank transfer with a service charges of {$chargesText}";
                        $amounttosave = (float) $amount_paid;

                        if($charges == 50 || $charges == "50"){
                            $amounttosave = $amounttosave - 50;
                        }
                        else{
                            $amounttosave = $amounttosave - ($amounttosave * ($charges/100)); 
                        }
                        $servicedesc.=". You wallet have been credited with $amounttosave";

                        $result = $controller->recordMonnifyTransaction($userid,$servicename,$servicedesc,$amounttosave,$userbalance,$mnfy_trans_ref,"0");

                        //Send Email Notification
                        $message = $servicedesc . ". Your transaction reference is $mnfy_trans_ref";
                        $controller->sendEmailNotification($servicename,$message,$email);

                        echo "Success";
                        http_response_code(200);
                        exit();
                else:  
                        $servicename = "Wallet Topup";
                        $servicedesc = "Failed wallet funding of N{$amount_paid} via bank transfer.";
                        $result = $controller->recordMonnifyTransaction($userid,$servicename,$servicedesc,$amount_paid,$userbalance,$mnfy_trans_ref,"1");
                        echo "Fail";
                        http_response_code(400);
                        exit();
                endif;

            endif;
        else:
            echo "UnAutorized";
            http_response_code(401);
            exit();
        endif;

    else:
        echo "UnAutorized";
        http_response_code(401);
        exit();

    endif;
    
?>
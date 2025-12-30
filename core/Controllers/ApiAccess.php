<?php

class ApiAccess extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = new ApiModel;
    }

    //Send Email Notification
    public function sendEmailNotification($subject, $message, $email)
    {
        $this->model->sendEmailNotification($subject, $message, $email);
    }

    //Verify Access Token
    public function validateAccessToken($token)
    {
        $result = $this->model->validateAccessToken($token);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["usertype"] = $result->sType;
            $response["userid"] = $result->sId;
            $response["name"] = $result->sLname . " " . $result->sFname;
            $response["balance"] = $result->sWallet;
            $response["username"] = $result->sUsername;
            $response["refearedby"] = $result->sReferal;
            $response["regstatus"] = $result->sRegStatus;
        } else {
            $response["status"] = "fail";
        }
        return $response;
    }

    //Fetch User Details
    public function getUserDetails($token)
    {
        $result = $this->model->getUserDetails($token);
        $response = array();
        $response["name"] = $result->sLname . " " . $result->sFname;
        $response["balance"] = number_format($result->sWallet, 2);
        $response["walletstatus"] = $result->tonaddstatus;
        $response["walletaddress"] = $result->sTonaddress;
        return $response;
    }

    //Fetch Site Settings
    public function getSiteSettings()
    {
        $result = $this->model->getSiteSettings();
        return $result;
    }

    //Verify Network Id
    public function verifyNetworkId($network)
    {
        $result = $this->model->verifyNetworkId($network);
        $response = array();
        if (is_object($result)) {
            $response = (array) $result;
            $response["status"] = "success";
        } else {
            $response["status"] = "fail";
        }
        return $response;
    }


    //Verify Data Plan Id
    public function verifyDataPlanId($network, $data_plan, $usertype)
    {
        $result = $this->model->verifyDataPlanId($network, $data_plan);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["dataplan"] = $result->planid;
            $response["name"] = $result->name;
            if ($usertype == 3) {
                $response["amount"] = (float) $result->vendorprice;
            } elseif ($usertype == 2) {
                $response["amount"] = (float) $result->agentprice;
            } else {
                $response["amount"] = (float) $result->userprice;
            }
            $response["buyprice"] = $result->price;
            $response["datatype"] = $result->type;
            $response["day"] = $result->day;
        } else {
            $response["status"] = "fail";
        }

        return $response;
    }

    //Verify Data Plan Id
    public function verifyDataPinId($network, $data_plan, $usertype)
    {
        $result = $this->model->verifyDataPinId($network, $data_plan);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["datapin"] = $result->planid;
            $response["name"] = $result->name;
            if ($usertype == 3) {
                $response["amount"] = (float) $result->vendorprice;
            } elseif ($usertype == 2) {
                $response["amount"] = (float) $result->agentprice;
            } else {
                $response["amount"] = (float) $result->userprice;
            }
            $response["buyprice"] = $result->price;
            $response["datatype"] = $result->type;
            $response["day"] = $result->day;
        } else {
            $response["status"] = "fail";
        }

        return $response;
    }

    //Verify Electricity Provider Id
    public function verifyElectricityId($provider)
    {
        $result = $this->model->verifyElectricityId($provider);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["electricityid"] = $result->electricityid;
            $response["provider"] = $result->provider;
            $response["providerStatus"] = $result->providerStatus;
        } else {
            $response["status"] = "fail";
        }

        return $response;
    }


    //Verify Exam Provider Id
    public function verifyExamId($provider)
    {
        $result = $this->model->verifyExamId($provider);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["examid"] = $result->examid;
            $response["provider"] = $result->provider;
            $response["providerStatus"] = $result->providerStatus;
            $response["amount"] = $result->price;
            $response["buying_price"] = $result->buying_price;
        } else {
            $response["status"] = "fail";
        }

        return $response;
    }


    //Verify Cable Provider Id
    public function verifyCableId($provider)
    {
        $result = $this->model->verifyCableId($provider);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["cableid"] = $result->cableid;
            $response["provider"] = $result->provider;
            $response["providerStatus"] = $result->providerStatus;
        } else {
            $response["status"] = "fail";
        }

        return $response;
    }

    //Verify Cable Plan Id
    public function verifyCablePlanId($provider, $plan, $usertype)
    {
        $result = $this->model->verifyCablePlanId($provider, $plan);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["cableplan"] = $result->planid;
            $response["name"] = $result->name;
            if ($usertype == 3) {
                $response["amount"] = (float) $result->vendorprice;
            } elseif ($usertype == 2) {
                $response["amount"] = (float) $result->agentprice;
            } else {
                $response["amount"] = (float) $result->userprice;
            }
            $response["day"] = $result->day;
            $response["buyprice"] = $result->price;
        } else {
            $response["status"] = "fail";
        }

        return $response;
    }

    //Verify Phone Number
    public function verifyPhoneNumber($phone, $network_name)
    {
        $response = array();
        $validate = substr($phone, 0, 4);
        $response["status"] = "success";

        if ($network_name == "MTN") {
            if (strpos(" 0702 0703 0713 0704 0706 0716 0802 0803 0806 0810 0813 0814 0816 0903 0913 0906 0916 0804 ", $validate) == FALSE || strlen($phone) != 11) {
                $response['msg'] = "This number is not an $network_name Number $phone";
                $response["status"] = "fail";
            }
        } else if ($network_name == "GLO") {
            if (strpos(" 0805 0705 0905 0807 0907 0707 0817 0917 0717 0715 0815 0915 0811 0711 0911 ", $validate) == FALSE || strlen($phone) != 11) {
                $response['msg'] = "This number is not an $network_name Number $phone";
                $response["status"] = "fail";
            }
        } else if ($network_name == "AIRTEL") {
            if (strpos(" 0904 0802 0902 0702 0808 0908 0708 0918 0818 0718 0812 0912 0712 0801 0701 0901 0907 0917 ", $validate) == FALSE || strlen($phone) != 11) {
                $response['msg'] = "This number is not an $network_name Number $phone";
                $response["status"] = "fail";
            }
        } else if ($network_name == "9MOBILE") {
            if (strpos(" 0809 0909 0709 0819 0919 0719 0817 0917 0717 0718 0918 0818 0808 0708 0908 ", $validate) == FALSE || strlen($phone) != 11) {
                $response['msg'] = "This number is not an $network_name Number $phone";
                $response["status"] = "fail";
            }
        } else {
            $response['msg'] = "Unidentified Network Id";
            $response["status"] = "fail";
        }

        return $response;
    }

    //Calculate Airtime Discount
    public function calculateAirtimeDiscount($network, $airtime_type, $amount, $usertype)
    {
        $response = array();
        $usertype = (float) $usertype;
        $network = (float) $network;
        $amount = (float) $amount;

        //Get Disount Persentage And Calculate Discount
        $result = $this->model->calculateAirtimeDiscount($network, $airtime_type);
        if ($usertype == 3) {
            $per = (float) $result->aVendorDiscount;
        } elseif ($usertype == 2) {
            $per = (float) $result->aAgentDiscount;
        } else {
            $per = (float) $result->aUserDiscount;
        }
        $amounttopay = ($amount * $per) / 100;
        $buyper = (float) $result->aBuyDiscount;
        $buyamount = ($amount * $buyper) / 100;

        $response["status"] = "success";
        $response["discount"] = $amounttopay;
        $response["buyamount"] = $buyamount;

        return $response;
    }

    //Check If Transaction Exist
    public function checkIfTransactionExist($ref)
    {
        $result = $this->model->checkIfTransactionExist($ref);
        $response = array();
        if ($result == 0) {
            $response["status"] = "fail";
        } else {
            $response["status"] = "success";
        }
        return $response;
    }



    //Check For Transaction Duplicate
    public function checkTransactionDuplicate($servicename, $servicedesc)
    {
        $result = $this->model->checkTransactionDuplicate($servicename, $servicedesc);
        $response = array();
        if (is_object($result)) {
            date_default_timezone_set('Africa/Lagos');
            $dateNow = date("Y-m-d H:i:s");
            $transDate = new DateTime($result->date);
            $transDateNow = new DateTime($dateNow);
            $timeLength = (float) $transDateNow->getTimestamp() - $transDate->getTimestamp();
            //file_put_contents("responsetime.txt","Seconds: ".$timeLength.", Trans Date: ".$result->date.", Date Now: ".$dateNow);

            //If same transaction occured in the last 1 minite, then dont send transaction.
            if ($timeLength > 60) {
                $response["status"] = "success";
            } else {
                $response["status"] = "fail";
            }
        } else {
            $response["status"] = "success";
        }
        return $response;
    }


    //Debit User BeforeTransaction
    public function debitUserBeforeTransaction($userid, $deibt)
    {
        return $this->model->debitUserBeforeTransaction($userid, $deibt);
    }

    //   Record Onchain Transaction
    public function recordchainTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $target_address, $tx_hash, $user_address, $nanoamount, $status, $transaction_type = 'app', $token_name = null, $token_contract = null, $blockchain_id = 1)
    {
        $response = array();
        $result = $this->model->recordchainTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $target_address, $tx_hash, $user_address, $nanoamount, $status, $transaction_type, $token_name, $token_contract, $blockchain_id);
        if ($result !== 0) {
            $response["status"] = "fail";
            $response["msg"] = "Failed To Record Transaction";
            return $response;
        }
        $response["status"] = "success";
        $response["amount"] = $amountopay;
            $response["service"] = $servicename;
        $response["description"] = $servicedesc;
        return $response;
    }
    // Record and Refund Transaction
    public function recordrefundchainTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $target_address, $tx_hash, $user_address, $nanoamount, $status, $transaction_type = 'app', $token_name = null, $token_contract = null, $blockchain_id = 1)
    {
        $response = array();
        $result = $this->model->recordrefundchainTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $target_address, $tx_hash, $user_address, $nanoamount, $status, $transaction_type, $token_name, $token_contract, $blockchain_id);
        if ($result !== 0) {
            $response["status"] = "fail";
            $response["msg"] = "Failed To Record Transaction";
            return $response;
        }
        $response["status"] = "success";
        $response["amount"] = $amountopay;
        $response["service"] = $servicename;
        $response["description"] = $servicedesc;
        return $response;
    }

    public function logError($message, $from, $userId)
    {
        $logFile = __DIR__ . '/../../log_error/error_log.txt';
        $timestamp = date(format: 'Y-m-d H:i:s');
        $userId = $_SESSION['user_id'] ?? 'Unknown'; // Assuming user ID is stored in session
        $logMessage = "[$timestamp] ERROR: $message\n";

        // Add request data to the log
        $logMessage .= "From: $from\n";
        $logMessage .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
        $logMessage .= "Request Data: " . json_encode($_POST) . "\n";
        $logMessage .= "User ID: " . $userId . "\n";
        $logMessage .= "--------------------------------------------------\n";

        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
    }
    // Refund Transaction
    public function refundTransaction($ref, $fuser_address, $tonamount, $token_contract = null, $token_symbol = null, $token_decimals = 18)
    {
        $response = array();
        $response = $this->model->refundTransaction($ref, $fuser_address, $tonamount, $token_contract, $token_symbol, $token_decimals);
        // if (!$result) {
        //     $response["status"] = "fail";
        //     $response["msg"] = "Failed To Record Transaction";
        //     return $response;
        // }
        // $response["status"] = "success";
        // $response["amount"] = $amountopay;
        // $response["service"] = $servicename;
        // $response["description"] = $servicedesc;
        return $response;
    }
    //Record Transaction & Debit User
    public function recordTransaction($userid, $servicename, $servicedesc, $amountopay, $userbalance, $ref, $status)
    {
        $response = array();
        $oldbalance = (float) $userbalance;
        $newbalance = $oldbalance - $amountopay;

        $result = $this->model->recordTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $oldbalance, $newbalance, $status);
        $response["status"] = "success";
        $response["amount"] = $amountopay;
        $response["oldbal"] = $oldbalance;
        $response["newbal"] = $newbalance;
        $response["service"] = $servicename;
        $response["description"] = $servicedesc;
        return $response;
    }
    //Save Profit
    public function saveProfit($ref, $profit)
    {
        $result = $this->model->saveProfit($ref, $profit);
    }

    //SaveData Pin
    public function saveDataPin($userid, $ref, $business, $networkname, $dataplansize, $quantity, $serial, $pin)
    {
        $result = $this->model->saveDataPin($userid, $ref, $business, $networkname, $dataplansize, $quantity, $serial, $pin);
    }


    //Update Transaction Status
    public function updateTransactionStatus($userid, $ref, $amountopay, $status)
    {
        $this->model->updateTransactionStatus($userid, $ref, $amountopay, $status);
    }

    public function updateFailedTransactionStatus($userid, $servicedesc, $ref, $amountopay, $status)
    {
        $this->model->updateFailedTransactionStatus($userid, $servicedesc, $ref, $amountopay, $status);
    }

    //----------------------------------------------------------------------------------------------------------------
    // Referal Bonus
    //----------------------------------------------------------------------------------------------------------------

    public function creditReferalBonus($referal, $referalname, $refearedby, $service)
    {
        $result = $this->model->creditReferalBonus($referal, $referalname, $refearedby, $service);
    }

    //Record Transaction & Debit User
    public function recordMonnifyTransaction($userid, $servicename, $servicedesc, $amount, $userbalance, $ref, $status)
    {
        $response = array();
        $oldbalance = (float) $userbalance;
        $newbalance = $oldbalance + $amount;

        $result = $this->model->recordMonnifyTransaction($userid, $servicename, $servicedesc, $ref, $amount, $oldbalance, $newbalance, $status);
        $response["status"] = "success";
        $response["amount"] = $amount;
        $response["oldbal"] = $oldbalance;
        $response["newbal"] = $newbalance;
        $response["service"] = $servicename;
        $response["description"] = $servicedesc;
        return $response;
    }

    //Record Transaction & Debit User
    // public function recordPaystackTransaction($userid, $servicename, $servicedesc, $amount, $userbalance, $ref, $status)
    // {
    //     $response = array();
    //     $oldbalance = (float) $userbalance;
    //     $newbalance = $oldbalance + $amount;

    //     $result = $this->model->recordTransaction($userid, $servicename, $servicedesc, $ref, $amount, $oldbalance, $newbalance, $status);
    //     $response["status"] = "success";
    //     $response["amount"] = $amount;
    //     $response["oldbal"] = $oldbalance;
    //     $response["newbal"] = $newbalance;
    //     $response["service"] = $servicename;
    //     $response["description"] = $servicedesc;
    //     return $response;
    // }

    //Verify Monnify Transaction
    public function verifyMonnifyRef($email, $monnifyhash, $token)
    {
        $result = $this->model->verifyMonnifyRef($email, $monnifyhash, $token);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["userid"] = $result->sId;
            $response["name"] = $result->sLname . " " . $result->sFname;
            $response["balance"] = $result->sWallet;
            $response["charges"] = $result->charges;
        } else {
            $response["status"] = "fail";
        }
        return $response;
    }

    //Verify Paystack Transaction
    public function verifyPaystackRef($email, $token)
    {
        $result = $this->model->verifyPaystackRef($email, $token);
        $response = array();
        if (is_object($result)) {
            $response["status"] = "success";
            $response["userid"] = $result->sId;
            $response["balance"] = $result->sWallet;
            $response["amount"] = $result->amount;
            $response["charges"] = $result->charges;
        } else {
            $response["status"] = "fail";
            $response["msg"] = $result;
        }
        return $response;
    }

    // ----------------------------------------------------------------------
    //Alpha Topup
    // ----------------------------------------------------------------------

    //Get Alpha Topup
    public function getAlphaTopupPlans()
    {
        $data = $this->model->getAlphaTopupPlans();
        return $data;
    }

    //Calculate AlphaTopup Discount
    public function calculateAlphaTopupDiscountDiscount($amount, $usertype)
    {
        $response = array();
        $usertype = (float) $usertype;
        $amount = (float) $amount;

        //Get Disount Persentage And Calculate Discount
        $result = $this->model->calculateAlphaTopupDiscountDiscount($amount);
        if ($usertype == 3) {
            $amounttopay = (float) $result->vendor;
        } elseif ($usertype == 2) {
            $amounttopay = (float) $result->agent;
        } else {
            $amounttopay = (float) $result->sellingPrice;
        }

        $buyamount = (float) $result->buyingPrice;


        $response["status"] = "success";
        $response["discount"] = $amounttopay;
        $response["buyamount"] = $buyamount;

        return $response;
    }
    // Check Blockchain transaction
    public function verifyTransaction($target_address, $tx_hash, $tx_lt, $user_address, $nanoamount)
    {
        // Legacy method wrapper for AssetChain/EVM verification
        // Note: $tx_lt is unused in EVM
        
        // Attempt to get token contract from request
        $token_contract = $_REQUEST['token_contract'] ?? null;
        $blockchain_id = $_REQUEST['blockchain_id'] ?? 1;
        
        return $this->verifyBlockchainTransaction($target_address, $tx_hash, $user_address, $nanoamount, $token_contract, $blockchain_id);
    }

    public function convertWeiToEther($wei_amount)
    {
        return $wei_amount / 1e18;
    }

    //Check Price Impact
    public function checkPriceImpact($price, $tokenAmount)
    {
        $response = array();

        try {
            // Get the current Native price from the API
            $currentNativePrice = $this->model->checkNativePrice();
            $priceResult = $currentNativePrice * $tokenAmount;
            // $price = 20; // Assuming 20 NGN for the sake of example
            // Ensure we have valid numeric values
            if (!is_numeric($price) || !is_numeric($tokenAmount)) {
                throw new InvalidArgumentException('Invalid input values');
            }

            // Calculate price difference and percentage drop
            $priceDifference = $priceResult - $price;
            $percentageDrop = ($priceDifference / $priceResult) * 100;

            // Populate response data
            $response['current_price'] = $priceResult;
            $response['price_difference'] = $priceDifference;
            $response['percentage_drop'] = $percentageDrop;

            // Check if price dropped by 1.5% or more
            if ($percentageDrop >= 1.5) {
                $response['status'] = 'fail';
                $response['msg'] = sprintf(
                    'Price drop alert: %.2f%% | Transaction Price: %.2f NGN | Current Value: %.2f NGN',
                    $percentageDrop,
                    $price,
                    $priceResult
                );
            } else {
                $response['status'] = 'success';
                $response['msg'] = sprintf(
                    'Price within acceptable range: %.2f%% drop | Transaction Price: %.2f NGN | Current Value: %.2f NGN',
                    $percentageDrop,
                    $price,
                    $priceResult
                );
            }
        } catch (Exception $e) {
            $response['status'] = 'fail';
            $response['msg'] = 'Error: ' . $e->getMessage();
        }

        return $response;
    }

    // ===== Assetchain (EVM) Helpers =====


    // Convert wei to token units using decimals (default 18)
    public function convertWeiToToken($wei, $decimals = 18)
    {
        // Accept string or int
        if ($wei === null || $wei === '') return 0;
        $scale = pow(10, (int)$decimals);
        return ((float)$wei) / $scale;
    }

    // Since CNGN is a stable token, price impact is not used
    public function checkPriceImpactCngn($price, $tokenAmount)
    {
        return [
            'status' => 'success',
            'msg' => 'CNGN stable token; price impact not applicable',
            'current_price' => (float)$price,
            'price_difference' => 0,
            'percentage_drop' => 0,
            'token_amount' => (float)$tokenAmount,
        ];
    }

    /**
     * Unified Blockchain Transaction Verification
     * Handles AssetChain (via scanner) and Base/BSC/Arbitrum (via Moralis)
     */
    public function verifyBlockchainTransaction($target_address, $tx_hash, $user_address, $amount_wei, $token_contract = null, $blockchain_id = 1)
    {
        $tx_hash = trim((string)$tx_hash);
        // 1) Handle AssetChain
        if ($blockchain_id == 1) {
            return $this->verifyAssetTransaction($target_address, $tx_hash, $user_address, $amount_wei, $token_contract);
        }

        // 2) Handle Multi-Chain via Moralis
        $chainMap = [
            2 => 'base',
            3 => 'arbitrum',
            4 => 'bsc'
        ];

        $chainKey = $chainMap[$blockchain_id] ?? null;
        if (!$chainKey) {
            return ['status' => 'fail', 'msg' => 'unsupported_blockchain_id: ' . $blockchain_id];
        }

        $moralis = new MoralisModel();
        
        // Multi-chain indexing can take a few seconds, retry up to 5 times
        $tx = null;
        $maxAttempts = 5;
        for ($i = 0; $i < $maxAttempts; $i++) {
            $tx = $moralis->getTransactionByHash($tx_hash, $chainKey);
            if (isset($tx['hash'])) {
                break;
            }
            // If Moralis returned an actual error (not just 'not found'), we might want to log it
            if ($i < $maxAttempts - 1) {
                sleep(2); // Wait 2 seconds before next attempt
            }
        }

        if (!$tx || !isset($tx['hash'])) {
            $errorDetail = 'transaction_not_found_on_chain';
            if (isset($tx['status']) && $tx['status'] === 'fail') {
                $errorDetail = 'moralis_error: ' . ($tx['msg'] ?? 'unknown') . " | Hash: $tx_hash | Chain: $chainKey";
            }
            return ['status' => 'fail', 'msg' => $errorDetail];
        }

        // Check status
        if (!($tx['receipt_status'] ?? null) && ($tx['status'] ?? '') !== 'ok') {
            // Some chains use status: ok, others use receipt_status: 1
            if (isset($tx['receipt_status']) && (int)$tx['receipt_status'] !== 1) {
                return ['status' => 'fail', 'msg' => 'transaction_reverted'];
            }
        }

        $txTo = strtolower($tx['to_address'] ?? '');
        $txFrom = strtolower($tx['from_address'] ?? '');
        $txValue = (string)($tx['value'] ?? '0');
        
        $wantTo = strtolower($target_address);
        $wantFrom = strtolower($user_address);
        $wantValue = (string)$amount_wei;

        $isNative = empty($token_contract) || strtolower($token_contract) === 'native' || $token_contract === '0x0000000000000000000000000000000000000000';

        if ($isNative) {
            // Verify native transfer
            if ($txTo === $wantTo && $txFrom === $wantFrom && $txValue === $wantValue) {
                return [
                    'status' => 'success',
                    'msg' => 'verified',
                    'transfer_value' => $txValue
                ];
            }
            return [
                'status' => 'fail', 
                'msg' => 'native_transfer_mismatch',
                'expected_value' => $wantValue,
                'transfer_value' => $txValue
            ];
        } else {
            // Verify ERC20 transfer
            // Moralis getTransactionByHash doesn't always show full token transfers in basic response
            // We might need to check logs or used dedicated endpoint
            // However, base Moralis response often has logs. 
            // Better to use getWalletTransactions or similar if we want to be sure, 
            // but let's see if we can use the logs in the response.
            
            $wantToken = strtolower($token_contract);
            $matched = false;
            $foundValue = 'N/A';

            if (isset($tx['logs']) && is_array($tx['logs'])) {
                foreach ($tx['logs'] as $log) {
                    // ERC20 Transfer event: Topic0 = 0xddf252ad...
                    if (($log['address'] ?? '') === $wantToken && ($log['topic0'] ?? '') === '0xddf252ad1be2c89b69c2b068fc378daa952ba7f163c4a11628f55a4df523b3ef') {
                        // Topic1 is From, Topic2 is To
                        $logFrom = strtolower('0x' . substr($log['topic1'] ?? '', 26));
                        $logTo = strtolower('0x' . substr($log['topic2'] ?? '', 26));
                        $logValue = (string)hexdec($log['data'] ?? '0');

                        if ($logValue !== '0') $foundValue = $logValue;

                        if ($logFrom === $wantFrom && $logTo === $wantTo && $logValue === $wantValue) {
                            $matched = true;
                            break;
                        }
                    }
                }
            }

            if ($matched) {
                return ['status' => 'success', 'msg' => 'verified', 'transfer_value' => $wantValue];
            }
            return [
                'status' => 'fail', 
                'msg' => 'token_transfer_mismatch',
                'token' => $wantToken,
                'expected_value' => $wantValue,
                'transfer_value' => $foundValue
            ];
        }
    }

    // Verify Assetchain transaction via public scanner API
    // Strategy:
    // 1) Check base transaction details at /transactions/<hash> for status ok
    // 2) Read token transfers at /transactions/<hash>/token-transfers?type=ERC-20%2CERC-721%2CERC-1155
    // 3) Match ERC-20 transfer with from==user_address, to==target_address, token.address==token_contract, total.value==amount_wei
    public function verifyAssetTransaction($target_address, $tx_hash, $user_address, $amount_wei, $token_contract = null)
    {
        $resp = [
            'status' => 'fail',
            'msg' => 'unknown_error',
            'tx_hash' => $tx_hash,
            'expected_value' => (string)$amount_wei,
            'transfer_value' => null,
        ];

        try {
            $hash = trim((string)$tx_hash);
            if (!$hash) {
                $resp['msg'] = 'missing_tx_hash';
                return $resp;
            }

            $isNative = empty($token_contract) || strtolower($token_contract) === 'native' || $token_contract === '0x0000000000000000000000000000000000000000';
            $wantToken = null;
            
            if (!$isNative) {
                $wantToken = $this->normalizeEvmAddress($token_contract);
                if (!$wantToken || !preg_match('/^0x[a-fA-F0-9]{40}$/', $wantToken)) {
                    $resp['msg'] = 'invalid_token_contract';
                    return $resp;
                }
            }

            // Step 1: base transaction details
            $txUrl = 'https://scan.assetchain.org/api/v2/transactions/' . $hash;
            $ch = curl_init($txUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['accept: application/json']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $maxRetries = 2;
            $retryCount = 0;
            $result = false;
            $cErr = '';

            while ($retryCount <= $maxRetries) {
                $result = curl_exec($ch);
                if ($result !== false) break;
                $cErr = curl_error($ch);
                $retryCount++;
                if ($retryCount <= $maxRetries) sleep(1); 
            }

            if ($result === false) {
                $resp['msg'] = 'scanner_unreachable: ' . $cErr;
                curl_close($ch);
                return $resp;
            }
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($code < 200 || $code >= 300) {
                $resp['msg'] = 'scanner_http_' . $code;
                return $resp;
            }

            $data = json_decode($result, true);
            if (!is_array($data)) {
                $resp['msg'] = 'invalid_scanner_response';
                return $resp;
            }

            $baseOk = (($data['status'] ?? '') === 'ok') || (($data['result'] ?? '') === 'success');
            $baseTo = $this->normalizeEvmAddress($data['to']['hash'] ?? $data['to'] ?? '');
            $baseFrom = $this->normalizeEvmAddress($data['from']['hash'] ?? $data['from'] ?? '');
            $diVal = '';
            
            if (isset($data['decoded_input']) && is_array($data['decoded_input'])) {
                $methodId = (string)($data['decoded_input']['method_id'] ?? '');
                $params = $data['decoded_input']['parameters'] ?? [];
                if ($methodId === 'a9059cbb' && is_array($params)) {
                    foreach ($params as $p) {
                        $pv = (string)($p['value'] ?? '');
                        if ($pv !== '') { $diVal = $pv; }
                    }
                }
            }

            $items = [];
            if (isset($data['token_transfers']) && is_array($data['token_transfers'])) {
                $items = $data['token_transfers'];
            }

            if (!$isNative) {
                $ttUrl = 'https://scan.assetchain.org/api/v2/transactions/' . $hash . '/token-transfers?type=ERC-20%2CERC-721%2CERC-1155';
                $ch2 = curl_init($ttUrl);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_TIMEOUT, 15);
                curl_setopt($ch2, CURLOPT_HTTPHEADER, ['accept: application/json']);
                curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

                $retryCount = 0;
                $ttRaw = false;
                while ($retryCount <= $maxRetries) {
                    $ttRaw = curl_exec($ch2);
                    if ($ttRaw !== false) break;
                    $retryCount++;
                    if ($retryCount <= $maxRetries) sleep(1);
                }

                if ($ttRaw !== false) {
                    $code2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
                    curl_close($ch2);
                    if ($code2 >= 200 && $code2 < 300) {
                        $ttData = json_decode($ttRaw, true);
                        if (is_array($ttData)) {
                            $items = array_merge($items, $ttData['items'] ?? []);
                        }
                    }
                } else {
                    curl_close($ch2);
                }
            }

            $wantFrom = $this->normalizeEvmAddress($user_address);
            $wantTo = $this->normalizeEvmAddress($target_address);
            $matched = false;
            $transferValue = null;

            if ($isNative) {
                $txValue = (string)($data['value'] ?? '');
                if ($baseFrom === $wantFrom && $baseTo === $wantTo && (string)$amount_wei === $txValue) {
                    $matched = true;
                    $transferValue = $txValue;
                }
            } else {
                foreach ($items as $tt) {
                    $ttTo = $this->normalizeEvmAddress($tt['to']['hash'] ?? $tt['to'] ?? '');
                    $ttFrom = $this->normalizeEvmAddress($tt['from']['hash'] ?? $tt['from'] ?? '');
                    $ttToken = $this->normalizeEvmAddress($tt['token']['address'] ?? $tt['token']['hash'] ?? $tt['token'] ?? '');
                    $ttValue = (string)($tt['total']['value'] ?? $tt['value'] ?? $tt['amount'] ?? '');
                    
                    if ($ttToken === $wantToken) {
                        if ($transferValue === null && $ttValue !== '') { $transferValue = $ttValue; }
                        if ($ttFrom === $wantFrom && ($ttTo === $wantTo || $wantTo === null) && (string)$amount_wei === (string)$ttValue) {
                            $matched = true;
                            break;
                        }
                    }
                }
            }

            if (!$matched && !$isNative && $diVal !== '') {
                if ($transferValue === null) { $transferValue = (string)$diVal; }
                if ($baseFrom === $wantFrom && $baseTo === $wantToken && (string)$amount_wei === (string)$diVal) {
                    $matched = true;
                }
            }

            if ($matched) {
                $resp['status'] = 'success';
                $resp['msg'] = 'verified';
                $resp['transfer_value'] = (string)$transferValue;
            } else {
                $resp['msg'] = $baseOk ? 'transfer_not_matched' : 'tx_not_ok';
                $resp['transfer_value'] = (string)$transferValue;
            }

            return $resp;
        } catch (\Throwable $e) {
            $resp['msg'] = 'error:' . $e->getMessage();
            return $resp;
        }
    }

    //Check If Error Show Status
    public function checkIfError()
    {
        $result = $this->model->checkIfError();
        if ($result == 1 || $result == "1") {
            return 1;
        } else {
            return 0;
        }
    }


    //Record Alpha Transaction Transaction & Debit User
    public function sendAlphaNotification($amount, $servicedesc)
    {
        return $result = $this->model->sendAlphaNotification($amount, $servicedesc);
    }

    // Get Blockchain Config
    public function getBlockchainConfig($name = 'AssetChain')
    {
        return $this->model->getBlockchainConfig($name);
    }

    // Get Token Info
    public function getTokenInfo($name)
    {
        return $this->model->getTokenInfo($name);
    }

    // Check ERC20 Balance
    public function checkERC20Balance($address, $tokenContract, $blockchain_id = null)
    {
        return $this->model->checkERC20Balance($address, $tokenContract, $blockchain_id);
    }
}

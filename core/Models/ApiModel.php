<?php

class ApiModel extends Model
{

    //----------------------------------------------------------------------------------------------------------------
    // API Access Management
    //----------------------------------------------------------------------------------------------------------------

    //Send Email Notification
    public function sendEmailNotification($subject, $message, $email)
    {
        $subject .= "(" . $this->sitename . ")";
        self::sendMail($email, $subject, $message);
    }

    //Validate API Token
    public function validateAccessToken($token)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM subscribers WHERE sApiKey='$token' AND sRegStatus='0'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $result;
        } else {
            return 1;
        }
    }

    //Get User Details
    public function getUserDetails($token)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM subscribers WHERE sApiKey='$token' AND sRegStatus='0'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    //Verify Network Id
    public function verifyNetworkId($network)
    {
        $dbh = self::connect();
        $network = (int) $network;
        $sql = "SELECT * FROM  networkid WHERE nId=$network";
        $query = $dbh->prepare($sql);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } else {
            return 1;
        }
    }

    //Verify Data Plan Id
    public function verifyDataPlanId($network, $data_plan)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM dataplans WHERE datanetwork=:network AND pId=:plan ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':network', $network, PDO::PARAM_STR);
        $query->bindParam(':plan', $data_plan, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } else {
            return 1;
        }
    }

    //Verify Data Plan Id
    public function verifyDataPinId($network, $data_plan)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM datapins WHERE datanetwork=:network AND dpId=:plan ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':network', $network, PDO::PARAM_STR);
        $query->bindParam(':plan', $data_plan, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } else {
            return 1;
        }
    }


    //Verify Electricity Id
    public function verifyElectricityId($provider)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM electricityid WHERE eId='$provider' ";
        $query = $dbh->prepare($sql);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } else {
            return 1;
        }
    }

    //Verify Exam Id
    public function verifyExamId($provider)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM examid WHERE eId='$provider' ";
        $query = $dbh->prepare($sql);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } else {
            return 1;
        }
    }

    //Verify Cable Id
    public function verifyCableId($provider)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM cableid WHERE cId='$provider' ";
        $query = $dbh->prepare($sql);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } else {
            return 1;
        }
    }

    //Verify Cable Plan Id
    public function verifyCablePlanId($provider, $plan)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM cableplans WHERE cableprovider=:provider AND cpId=:plan ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':provider', $provider, PDO::PARAM_STR);
        $query->bindParam(':plan', $plan, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } else {
            return 1;
        }
    }

    //Calculate Airtime Discount
    public function calculateAirtimeDiscount($network, $airtime_type)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM airtime WHERE aNetwork=:n AND aType=:ty";
        $query = $dbh->prepare($sql);
        $query->bindParam(':n', $network, PDO::PARAM_INT);
        $query->bindParam(':ty', $airtime_type, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    //Check If Transaction Exist
    public function checkIfTransactionExist($ref)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM transactions WHERE transref='$ref'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    //Check For Transaction Duplicate
    public function checkTransactionDuplicate($servicename, $servicedesc)
    {
        $dbh = self::connect();
        $sql = "SELECT date FROM transactions WHERE servicename=:sn AND servicedesc=:sd ORDER BY tId DESC LIMIT 1";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sn', $servicename, PDO::PARAM_STR);
        $query->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $result;
        } else {
            return 1;
        }
    }

    //Get API Details
    public function getApiDetails()
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM apiconfigs";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    //Get Site Settings Details
    public function getSiteSettings()
    {
        $dbh = self::connect();
        $sqlA = "SELECT * FROM sitesettings WHERE sId=1 LIMIT 1";
        $queryA = $dbh->prepare($sqlA);
        $queryA->execute();
        $siteData = $queryA->fetch(PDO::FETCH_OBJ);
        return $siteData;
    }

    //Debit User BeforeTransaction
    public function debitUserBeforeTransaction($userid, $deibt)
    {
        $dbh = self::connect();
        $userid = (float) $userid;
        $sqlD = "UPDATE subscribers SET sWallet=:nb WHERE sId=:id";
        $queryD = $dbh->prepare($sqlD);
        $queryD->bindParam(':id', $userid, PDO::PARAM_INT);
        $queryD->bindParam(':nb', $deibt, PDO::PARAM_STR);
        if ($queryD->execute()) {
            return "success";
        } else {
            return "fail";
        }
    }

    //Save Profit
    public function saveProfit($ref, $profit)
    {
        $dbh = self::connect();
        $sqlD = "UPDATE transactions SET profit=:p WHERE transref=:ref";
        $queryD = $dbh->prepare($sqlD);
        $queryD->bindParam(':p', $profit, PDO::PARAM_STR);
        $queryD->bindParam(':ref', $ref, PDO::PARAM_STR);
        if ($queryD->execute()) {
            return "success";
        } else {
            return "fail";
        }
    }

    //Save Data Pin
    public function saveDataPin($userid, $ref, $business, $networkname, $dataplansize, $quantity, $serial, $pin)
    {
        $dbh = self::connect();
        $sql = "INSERT INTO datatokens SET sId=:user,tRef=:ref,business=:b,network=:net,datasize=:size,quantity=:q,serial=:s,tokens=:t";
        $query = $dbh->prepare($sql);
        $query->bindParam(':user', $userid, PDO::PARAM_INT);
        $query->bindParam(':ref', $ref, PDO::PARAM_STR);
        $query->bindParam(':q', $quantity, PDO::PARAM_STR);
        $query->bindParam(':s', $serial, PDO::PARAM_STR);
        $query->bindParam(':t', $pin, PDO::PARAM_STR);
        $query->bindParam(':b', $business, PDO::PARAM_STR);
        $query->bindParam(':net', $networkname, PDO::PARAM_STR);
        $query->bindParam(':size', $dataplansize, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            return 0;
        } else {
            return 1;
        }
    }


    //Record Monnify Transaction 
    public function recordMonnifyTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $oldbalance, $newbalance, $status)
    {
        $dbh = self::connect();
        $userid = (float) $userid;
        $status = (float) $status;
        $date = date("Y-m-d H:i:s");

        //Check If Discount Already Exist
        $queryC = $dbh->prepare("SELECT transref FROM transactions WHERE transref=:transref");
        $queryC->bindParam(':transref', $ref, PDO::PARAM_STR);
        $queryC->execute();
        if ($queryC->rowCount() > 0) {
            return 1;
        }

        //If transaction was successful, debit user wallet
        $sqlD = "UPDATE subscribers SET sWallet=:nb WHERE sId=:id";
        $queryD = $dbh->prepare($sqlD);
        $queryD->bindParam(':id', $userid, PDO::PARAM_INT);
        $queryD->bindParam(':nb', $newbalance, PDO::PARAM_STR);
        $queryD->execute();

        //Record Transaction
        $sql = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
        $query = $dbh->prepare($sql);
        $query->bindParam(':user', $userid, PDO::PARAM_INT);
        $query->bindParam(':ref', $ref, PDO::PARAM_STR);
        $query->bindParam(':sn', $servicename, PDO::PARAM_STR);
        $query->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
        $query->bindParam(':a', $amountopay, PDO::PARAM_STR);
        $query->bindParam(':s', $status, PDO::PARAM_INT);
        $query->bindParam(':ob', $oldbalance, PDO::PARAM_STR);
        $query->bindParam(':nb', $newbalance, PDO::PARAM_STR);
        $query->bindParam(':d', $date, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            return 0;
        } else {
            return 1;
        }
    }


    //Record Transaction ANd Debit User
    public function recordTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $oldbalance, $newbalance, $status)
    {
        $dbh = self::connect();
        $userid = (float) $userid;
        $status = (float) $status;
        $date = date("Y-m-d H:i:s");

        //If transaction was successful, debit user wallet
        if ($status == 1) {
            $newbalance = $oldbalance;
        }
        $sqlD = "UPDATE subscribers SET sWallet=:nb WHERE sId=:id";
        $queryD = $dbh->prepare($sqlD);
        $queryD->bindParam(':id', $userid, PDO::PARAM_INT);
        $queryD->bindParam(':nb', $newbalance, PDO::PARAM_STR);
        $queryD->execute();

        //Record Transaction
        $sql = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
        $query = $dbh->prepare($sql);
        $query->bindParam(':user', $userid, PDO::PARAM_INT);
        $query->bindParam(':ref', $ref, PDO::PARAM_STR);
        $query->bindParam(':sn', $servicename, PDO::PARAM_STR);
        $query->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
        $query->bindParam(':a', $amountopay, PDO::PARAM_STR);
        $query->bindParam(':s', $status, PDO::PARAM_INT);
        $query->bindParam(':ob', $oldbalance, PDO::PARAM_STR);
        $query->bindParam(':nb', $newbalance, PDO::PARAM_STR);
        $query->bindParam(':d', $date, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            return 0;
        } else {
            return 1;
        }
    }
    public function refundTransaction($ref, $fuser_address, $amount, $token_contract = null, $token_symbol = null, $token_decimals = 18)
    {


        $reference = crc32($ref);
        $check =  $this->checkIfTransactionExist($reference);
        if ($check == 0) {
            return [
                'status' => "fail",
                'msg' => "Refund Transaction Exists"
            ];
        } //Transaction Already Exist

        $refunds = $this->getSiteSettings();
        $refundstatus = $refunds->refundstatus;
        if ($refundstatus == 0) {
            return [
                'status' => "fail",
                'msg' => "Refund Not Allowed"
            ];
        } //Refund Not Allowed

        // Token Verification
        if ($token_contract && $token_contract !== '0x0000000000000000000000000000000000000000') {
            $dbh = self::connect();
            $sql = "SELECT token_id FROM tokens WHERE LOWER(token_contract) = LOWER(:contract) AND is_active = 1 LIMIT 1";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([':contract' => $token_contract]);
            if (!$stmt->fetch()) {
                return [
                    'status' => "fail",
                    'msg' => "Token not supported or inactive"
                ];
            }
        }

        try {
            // Prepare input data
            $input = [
                'address' => $fuser_address,
                'amount' => $amount,
                'token_contract' => $token_contract,
                'token_decimals' => $token_decimals,
                'msgs' => "Refund for transaction: " . $ref
            ];
            // Validate input data
            if (empty($input['address']) || empty($input['amount'])) {
                throw new Exception('Address or amount missing', 400);
            }
            if (!is_numeric($input['amount'])) {
                throw new Exception('Amount must be numeric', 400);
            }
            if ($input['amount'] <= 0) {
                throw new Exception('Amount must be greater than zero', 400);
            }

            // Prepare request to Deno Deploy
            $denoDeployUrl = "https://evm-refund.deno.dev/";
            $ch = curl_init($denoDeployUrl);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            $response = curl_exec($ch);
            $curlError = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($response === false) {
                throw new Exception("Curl error: " . $curlError, 500);
            }

            http_response_code($httpCode);
            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Invalid JSON response: " . json_last_error_msg(), 500);
            }

            if (isset($data['success']) && $data['success'] === false) {
                throw new Exception($data['message'] ?? 'Refund failed', 400);
            }

            $checking =  $this->checktransactionbyhash($data['hash'] ?? null);

            if ($checking['status'] == 'fail') {
                return [
                    'status' => "fail",
                    'msg' => $checking['msg'] ?? 'Unknown Error For refunding transaction',
                    'hash' => $data['hash'] ?? null
                ];
            }

            return [
                'status' => "success",
                'msg' => 'Refund Successful',
                'hash' => $data['hash'] ?? null,
                'sender' => $data['sender_address'] ?? null,
                'receiver' => $data['target_address'] ?? null,
            ];
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            return [
                'status' => "fail",
                'msg' => $e->getMessage()
            ];
        }
    }
    //Update Transaction Status
    public function updateTransactionStatus($userid, $ref, $amountopay, $status)
    {
        $dbh = self::connect();
        $userid = (float) $userid;
        $status = (float) $status;
        $amountopay = (float) $amountopay;

        //If Transaction Failed, Refund User Since He Ha Been Debited Already
        if ($status == 1) {
            $sqlW = "SELECT sWallet FROM subscribers WHERE sId=$userid";
            $queryW = $dbh->prepare($sqlW);
            $queryW->execute();
            $resultW = $queryW->fetch(PDO::FETCH_OBJ);
            $oldbalance = (float) $resultW->sWallet;
            $newbalance = $oldbalance + $amountopay;

            $sqlS = "UPDATE subscribers SET sWallet=:nb WHERE sId=:id";
            $queryS = $dbh->prepare($sqlS);
            $queryS->bindParam(':id', $userid, PDO::PARAM_INT);
            $queryS->bindParam(':nb', $newbalance, PDO::PARAM_STR);
            $queryS->execute();

            //Update Transaction Status
            $sqlD = "UPDATE transactions SET status=:status,newbal=:nb WHERE sId=:user AND transref=:ref";
            $queryD = $dbh->prepare($sqlD);
            $queryD->bindParam(':user', $userid, PDO::PARAM_INT);
            $queryD->bindParam(':nb', $newbalance, PDO::PARAM_STR);
            $queryD->bindParam(':status', $status, PDO::PARAM_INT);
            $queryD->bindParam(':ref', $ref, PDO::PARAM_STR);
            $queryD->execute();
        } else {
            //Update Transaction Status
            $sqlD = "UPDATE transactions SET status=:status WHERE sId=:user AND transref=:ref";
            $queryD = $dbh->prepare($sqlD);
            $queryD->bindParam(':user', $userid, PDO::PARAM_INT);
            $queryD->bindParam(':status', $status, PDO::PARAM_INT);
            $queryD->bindParam(':ref', $ref, PDO::PARAM_STR);
            $queryD->execute();
        }
    }
    public function updateFailedTransactionStatus($userid, $servicedesc, $ref, $amountopay, $status)
    {
        $dbh = self::connect();
        $userid = (float) $userid;
        $status = (float) $status;
        $amountopay = (float) $amountopay;

        //If Transaction Failed, Refund User Since He Ha Been Debited Already
        //Update Transaction Status
        $sqlD = "UPDATE transactions SET status=:status, servicedesc=:sd WHERE sId=:user AND transref=:ref";
        $queryD = $dbh->prepare($sqlD);
        $queryD->bindParam(':user', $userid, PDO::PARAM_INT);
        $queryD->bindParam(':status', $status, PDO::PARAM_INT);
        $queryD->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
        $queryD->bindParam(':ref', $ref, PDO::PARAM_STR);
        $queryD->execute();
    }
    // Record Onchain transaction

    private function ensureTransactionsTokenColumns()
    {
        $dbh = self::connect();
        try {
            $checkSql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='transactions' AND COLUMN_NAME IN ('transaction_type','token_name','token_contract','token_amount','blockchain_id')";
            $q = $dbh->prepare($checkSql);
            $q->execute();
            $found = array_map(function ($r) { return $r['COLUMN_NAME']; }, $q->fetchAll(PDO::FETCH_ASSOC));
            $needType = !in_array('transaction_type', $found);
            $needName = !in_array('token_name', $found);
            $needContract = !in_array('token_contract', $found);
            $needAmount = !in_array('token_amount', $found);
            $needChainId = !in_array('blockchain_id', $found);

            if ($needAmount) {
                $dbh->exec("ALTER TABLE transactions ADD COLUMN token_amount VARCHAR(64) NULL");
            }
            if ($needType) {
                $dbh->exec("ALTER TABLE transactions ADD COLUMN transaction_type VARCHAR(10) NOT NULL DEFAULT 'app'");
            }
            if ($needName) {
                $dbh->exec("ALTER TABLE transactions ADD COLUMN token_name VARCHAR(64) NULL");
            }
            if ($needContract) {
                $dbh->exec("ALTER TABLE transactions ADD COLUMN token_contract VARCHAR(66) NULL");
            }
            if ($needChainId) {
                $dbh->exec("ALTER TABLE transactions ADD COLUMN blockchain_id INT DEFAULT 1 AFTER `date` ");
            }
        } catch (\Throwable $e) {
            // Ignore migration errors to avoid breaking runtime
        }
    }

    public function recordchainTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $target_address, $tx_hash, $user_address, $nanoamount, $status, $transaction_type = 'app', $token_name = null, $token_contract = null, $blockchain_id = 1)
    {
        $dbh = self::connect();
        
        // Check if transaction already exists by ref
        $checkSql = "SELECT sId FROM transactions WHERE transref = :ref LIMIT 1";
        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->execute([':ref' => $ref]);
        if ($checkQuery->rowCount() > 0) {
            return 0; // Already exists, consider success
        }

        $userid = (float) $userid;
        $status = (float) $status;
        $date = date("Y-m-d H:i:s");
        $oldbalance = '0';
        $newbalance = '0';
        $blockchain_id = (int) $blockchain_id;
        $this->ensureTransactionsTokenColumns();
        //Record Transaction
        $sql = "INSERT INTO transactions (sId, transref, servicename, servicedesc, amount, status, oldbal, newbal, txhash, targetaddress, senderaddress, token_amount, date, transaction_type, token_name, token_contract, blockchain_id) 
        VALUES (:user, :ref, :sn, :sd, :a, :s, :ob, :nb, :txh, :taddy, :uaddy, :token_amount, :d, :ttype, :tname, :tcontract, :bid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':user', $userid, PDO::PARAM_INT);
        $query->bindParam(':ref', $ref, PDO::PARAM_STR);
        $query->bindParam(':sn', $servicename, PDO::PARAM_STR);
        $query->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
        $query->bindParam(':a', $amountopay, PDO::PARAM_STR);
        $query->bindParam(':s', $status, PDO::PARAM_INT);
        $query->bindParam(':ob', $oldbalance, PDO::PARAM_STR);
        $query->bindParam(':nb', $newbalance, PDO::PARAM_STR);
        $query->bindParam(':txh', $tx_hash, PDO::PARAM_STR);
        $query->bindParam(':taddy', $target_address, PDO::PARAM_STR);
        $query->bindParam(':uaddy', $user_address, PDO::PARAM_STR);
        $query->bindParam(':token_amount', $nanoamount, PDO::PARAM_STR);
        $query->bindParam(':d', $date, PDO::PARAM_STR);
        $query->bindParam(':ttype', $transaction_type, PDO::PARAM_STR);
        $query->bindParam(':tname', $token_name, PDO::PARAM_STR);
        $query->bindParam(':tcontract', $token_contract, PDO::PARAM_STR);
        $query->bindParam(':bid', $blockchain_id, PDO::PARAM_INT);
        $query->execute();


        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            return 0;
        } else {
            return 1;
        }
    }
    // Record Refund Transaction
    public function recordrefundchainTransaction($userid, $servicename, $servicedesc, $ref, $amountopay, $target_address, $tx_hash, $user_address, $nanoamount, $status, $transaction_type = 'app', $token_name = null, $token_contract = null, $blockchain_id = 1)
    {
        $dbh = self::connect();
        
        // Check for duplicate transaction by tx_hash
        if (!empty($tx_hash)) {
            $sqlCheck = "SELECT sId FROM transactions WHERE txhash = :txh LIMIT 1";
            $qCheck = $dbh->prepare($sqlCheck);
            $qCheck->bindParam(':txh', $tx_hash, PDO::PARAM_STR);
            $qCheck->execute();
            if ($qCheck->rowCount() > 0) {
                // Transaction already exists
                return 0; 
            }
        }

        $userid = (float) $userid;
        $status = (float) $status;
        $date = date("Y-m-d H:i:s");
        $oldbalance = '0';
        $newbalance = '0';
        $blockchain_id = (int)$blockchain_id;
        $this->ensureTransactionsTokenColumns();
        //Record Transaction
        $sql = "INSERT INTO transactions (sId, transref, servicename, servicedesc, amount, status, oldbal, newbal, txhash, targetaddress, senderaddress, token_amount, date, transaction_type, token_name, token_contract, blockchain_id) 
    VALUES (:user, :ref, :sn, :sd, :a, :s, :ob, :nb, :txh, :taddy, :uaddy, :token_amount, :d, :ttype, :tname, :tcontract, :bid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':user', $userid, PDO::PARAM_INT);
        $query->bindParam(':ref', $ref, PDO::PARAM_STR);
        $query->bindParam(':sn', $servicename, PDO::PARAM_STR);
        $query->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
        $query->bindParam(':a', $amountopay, PDO::PARAM_STR);
        $query->bindParam(':s', $status, PDO::PARAM_INT);
        $query->bindParam(':ob', $oldbalance, PDO::PARAM_STR);
        $query->bindParam(':nb', $newbalance, PDO::PARAM_STR);
        $query->bindParam(':txh', $tx_hash, PDO::PARAM_STR);
        $query->bindParam(':taddy', $target_address, PDO::PARAM_STR);
        $query->bindParam(':uaddy', $user_address, PDO::PARAM_STR);
        $query->bindParam(':token_amount', $nanoamount, PDO::PARAM_STR);
        $query->bindParam(':d', $date, PDO::PARAM_STR);
        $query->bindParam(':ttype', $transaction_type, PDO::PARAM_STR);
        $query->bindParam(':tname', $token_name, PDO::PARAM_STR);
        $query->bindParam(':tcontract', $token_contract, PDO::PARAM_STR);
        $query->bindParam(':bid', $blockchain_id, PDO::PARAM_INT);
        $query->execute();


        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            return 0;
        } else {
            return 1;
        }
    }
    //----------------------------------------------------------------------------------------------------------------
    // Referal Bonus
    //----------------------------------------------------------------------------------------------------------------

    public function creditReferalBonus($referal, $referalname, $refearedby, $service)
    {
        $dbh = self::connect();

        //Get Site Details
        $sqlA = "SELECT * FROM sitesettings WHERE sId=1";
        $queryA = $dbh->prepare($sqlA);
        $queryA->execute();
        $siteData = $queryA->fetch(PDO::FETCH_OBJ);

        //Determine Referal Bonus
        if ($service == "Airtime") {
            $refbonus = (float) $siteData->referalairtimebonus;
        } elseif ($service == "Data") {
            $refbonus = (float) $siteData->referaldatabonus;
        } elseif ($service == "Cable TV") {
            $refbonus = (float) $siteData->referalcablebonus;
        } elseif ($service == "Exam Pin") {
            $refbonus = (float) $siteData->referalexambonus;
        } elseif ($service == "Electricity Bill") {
            $refbonus = (float) $siteData->referalmeterbonus;
        } else {
            $refbonus = 0;
        }

        //If bonus is not activates or set to 0, terminate operation
        if ($refbonus == 0) {
            return 1;
        }

        $sql = "SELECT sId,sRefWallet FROM subscribers WHERE sPhone=:phone";
        $query = $dbh->prepare($sql);
        $query->bindParam(':phone', $refearedby, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {

            //Get User Balance
            $userId = $result->sId;
            $balance = (float) $result->sRefWallet;
            $oldbalance = $balance;
            $amount = (float) $refbonus;
            $newbalance = $oldbalance + $amount;
            $servicename = "Referral Bonus";
            $servicedesc = "Referral Bonus Of N{$amount} For Referring {$referalname} ({$referal}). Bonus For {$service} Purchase.";
            $status = 0;
            $date = date("Y-m-d H:i:s");
            $ref = "REF-" . time();

            //Record Transaction
            $sql2 = "INSERT INTO transactions SET sId=:user,transref=:ref,servicename=:sn,servicedesc=:sd,amount=:a,status=:s,oldbal=:ob,newbal=:nb,date=:d";
            $query2 = $dbh->prepare($sql2);
            $query2->bindParam(':user', $userId, PDO::PARAM_INT);
            $query2->bindParam(':ref', $ref, PDO::PARAM_STR);
            $query2->bindParam(':sn', $servicename, PDO::PARAM_STR);
            $query2->bindParam(':sd', $servicedesc, PDO::PARAM_STR);
            $query2->bindParam(':a', $amount, PDO::PARAM_STR);
            $query2->bindParam(':s', $status, PDO::PARAM_INT);
            $query2->bindParam(':ob', $oldbalance, PDO::PARAM_STR);
            $query2->bindParam(':nb', $newbalance, PDO::PARAM_STR);
            $query2->bindParam(':d', $date, PDO::PARAM_STR);
            $query2->execute();

            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                //Update Account Type & Balance
                $sql3 = "UPDATE subscribers SET sRefWallet=:bal WHERE sId=:id";
                $query3 = $dbh->prepare($sql3);
                $query3->bindParam(':id', $userId, PDO::PARAM_INT);
                $query3->bindParam(':bal', $newbalance, PDO::PARAM_STR);
                $query3->execute();
                return 0;
            }
        }
    }


    //Validate Monnify Transaction
    public function verifyMonnifyRef($email, $monnifyhash, $token)
    {
        $dbh = self::connect();

        //Get Api Key
        $sql = "SELECT value FROM apiconfigs WHERE name='monifySecrete'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        $monifySecrete = $result->value;
        $hash = $this->computeMonnifyHash($token, $monifySecrete);

        //Get Api Status
        $sql2 = "SELECT value FROM apiconfigs WHERE name='monifyCharges'";
        $query2 = $dbh->prepare($sql2);
        $query2->execute();
        $result2 = $query2->fetch(PDO::FETCH_OBJ);
        $charges = $result2->value;

        if ($hash == $monnifyhash) {
            $sqlA = "SELECT * FROM subscribers WHERE sEmail=:e";
            $queryA = $dbh->prepare($sqlA);
            $queryA->bindParam(':e', $email, PDO::PARAM_STR);
            $queryA->execute();
            $resultA = $queryA->fetch(PDO::FETCH_OBJ);
            $resultA = (array) $resultA;
            $resultA["charges"] = $charges;
            $resultA = (object) $resultA;
            return $resultA;
        } else {
            return 1;
        }
    }

    //Compute Monnify Hash
    public function computeMonnifyHash($stringifiedData, $clientSecret)
    {
        $computedHash = hash_hmac('sha512', $stringifiedData, $clientSecret);
        return $computedHash;
    }


    //Validate Paystack Transaction
    public function verifyPaystackRef($email, $reference)
    {
        $dbh = self::connect();

        //Get Api Key
        $sql = "SELECT value FROM apiconfigs WHERE name='paystackApi'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        $apiKey = $result->value;

        //Get Api Status
        $sql2 = "SELECT value FROM apiconfigs WHERE name='paystackCharges'";
        $query2 = $dbh->prepare($sql2);
        $query2->execute();
        $result2 = $query2->fetch(PDO::FETCH_OBJ);
        $charges = $result2->value;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . $apiKey,
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            return 'Curl Returned Error: ' . $err;
        }

        $tranx = json_decode($response);

        if (!$tranx->status) {
            // there was an error from the API
            return 'API Returned Error: ' . $tranx->message;
        }

        if ('success' == $tranx->data->status) {
            $sqlA = "SELECT sId,sWallet FROM subscribers WHERE sEmail=:e";
            $queryA = $dbh->prepare($sqlA);
            $queryA->bindParam(':e', $email, PDO::PARAM_STR);
            $queryA->execute();
            $resultA = $queryA->fetch(PDO::FETCH_OBJ);
            $resultA = (array) $resultA;
            $resultA["amount"] = $tranx->data->amount;
            $resultA["charges"] = $charges;
            $resultA = (object) $resultA;
            return $resultA;
        } else {
            return "Transaction Not Verified";
        }
    }

    // Check Refund Wallet Balance
    public function checkNativeBalance($address)
    {
        // EVM Address Check (Asset Chain)
        if (preg_match('/^0x[a-fA-F0-9]{40}$/', $address)) {
            $config = $this->getBlockchainConfig();
            $response = $this->callJsonRpc('eth_getBalance', [$address, 'latest']);
            
            if (isset($response['result'])) {
                // Convert Hex to Decimal
                $wei = hexdec($response['result']);
                $balance = $wei / 1e18; // Asset Chain uses 18 decimals
                
                return [
                    "status" => "success",
                    "balance" => $balance,
                    "msg" => "Balance retrieved successfully"
                ];
            } else {
                return [
                    "status" => "fail",
                    "msg" => "Failed to retrieve EVM balance"
                ];
            }
        }

        return [
            "status" => "fail",
            "msg" => "Invalid Address Format for AssetChain/EVM"
        ];
    }

    // Check Price Increase or Decrease
    public function checkNativePrice($coinId = 'ethereum')
    {
        $curl = curl_init();
        $apikey = $this->getSiteSettings();

        // Use configured coin ID if available, otherwise default
        $coinId = $apikey->native_coin_id ?? $coinId;

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.coingecko.com/api/v3/simple/price?ids={$coinId}&vs_currencies=ngn",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "x-cg-demo-api-key: " . $apikey->coingeckoapikey,
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $data = json_decode($response, true);
            if (isset($data[$coinId]["ngn"])) {
                return (float) $data[$coinId]["ngn"];
            } else {
                 // Fallback to site settings price if API fails
                 return (float) ($apikey->tonamount ?? 0);
            }
        }
    }



    // Verified Onchain Tranasaction in The Blockchain
    public function verifyNativeTransaction($target_address, $tx_hash, $user_address, $weiamount)
    {
        // EVM Transaction Check (Asset Chain)
        if (preg_match('/^0x[a-fA-F0-9]{64}$/', $tx_hash)) {
            $response = $this->callJsonRpc('eth_getTransactionByHash', [$tx_hash]);
            
            if (isset($response['result'])) {
                $tx = $response['result'];
                
                // Normalize for comparison
                $txTo = strtolower($tx['to']);
                $txFrom = strtolower($tx['from']);
                $target = strtolower($target_address);
                $user = strtolower($user_address);
                $txValue = (string)hexdec($tx['value']); // Wei
                $expectedAmount = (string)$weiamount;

                // Basic Verification
                if ($txTo === $target && $txFrom === $user && $txValue === $expectedAmount) {
                     return [
                        "status" => "success",
                        "msg" => "Transaction verified successfully.",
                        "code" => "verified",
                        "data" => $tx
                    ];
                } else {
                    return [
                        "status" => "fail",
                        "msg" => "Transaction data does not match expected values.",
                        "received" => [
                            "to" => $txTo,
                            "from" => $txFrom,
                            "value" => $txValue
                        ],
                        "expected" => [
                            "to" => $target,
                            "from" => $user,
                            "value" => $expectedAmount
                        ]
                    ];
                }
            }
            return ["status" => "fail", "msg" => "Transaction not found on EVM chain"];
        }

        return [
            "status" => "fail",
            "msg" => "Invalid Transaction Hash or Chain not supported"
        ];
    }
    public function checktransactionbyhash($tx_hash)
    {
        // EVM Transaction Check (Asset Chain)
        if (preg_match('/^0x[a-fA-F0-9]{64}$/', $tx_hash)) {
            $response = $this->callJsonRpc('eth_getTransactionReceipt', [$tx_hash]);
            
            if (isset($response['result'])) {
                $receipt = $response['result'];
                if ($receipt['status'] == '0x1') { // 1 = Success
                    return [
                        'status' => "success",
                        'msg' => "Transaction verified successfully.",
                        'code' => "verified",
                        'sender_address' => $receipt['from'],
                        'target_address' => $receipt['to']
                    ];
                } else {
                     return [
                        'status' => "fail",
                        'msg' => "Transaction failed on chain",
                        'code' => "failed"
                    ];
                }
            }
            
            // If receipt not found, check if it exists (pending)
             $txResp = $this->callJsonRpc('eth_getTransactionByHash', [$tx_hash]);
             if (isset($txResp['result']) && $txResp['result']) {
                 return ['status' => 'fail', 'msg' => 'Transaction pending or not confirmed'];
             }
             
            return ['status' => 'fail', 'msg' => 'Transaction not found on EVM chain'];
        }

        return [
            'status' => 'fail',
            'msg' => 'Invalid Transaction Hash or Chain not supported'
        ];
    }

    // Get Blockchain Config from DB by name or ID
    public function getBlockchainConfig($identifier = 'AssetChain') {
        $dbh = self::connect();
        if (is_numeric($identifier)) {
            $sql = "SELECT * FROM blockchain WHERE id = :id LIMIT 1";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $identifier, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM blockchain WHERE name = :name LIMIT 1";
            $query = $dbh->prepare($sql);
            $query->bindParam(':name', $identifier, PDO::PARAM_STR);
        }
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result;
        }
        
        // Fallback default
        return [
            "rpc_url" => "https://mainnet-rpc.assetchain.org/",
            "chain_id" => 42420,
            "site_address" => "", 
            "refunding_address" => ""
        ];
    }

    // Get Token Info from DB
    public function getTokenInfo($name) {
        $dbh = self::connect();
        $sql = "SELECT * FROM tokens WHERE token_name = :name LIMIT 1";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Check ERC20 or Native Token Balance
    public function checkERC20Balance($address, $tokenContract, $blockchain_id = null) {
        $config = $this->getBlockchainConfig($blockchain_id ?? 'AssetChain');
        
        $isNative = empty($tokenContract) || strtolower($tokenContract) === 'native' || $tokenContract === '0x0000000000000000000000000000000000000000';
        
        if ($isNative) {
            $response = $this->callJsonRpc('eth_getBalance', [$address, 'latest'], $config);
        } else {
            // ABI for balanceOf: 0x70a08231 + address padded to 32 bytes
            $methodId = '0x70a08231';
            // Remove 0x if present
            $cleanAddress = str_replace('0x', '', $address);
            $paddedAddress = str_pad($cleanAddress, 64, '0', STR_PAD_LEFT);
            $data = $methodId . $paddedAddress;
            
            $response = $this->callJsonRpc('eth_call', [
                ['to' => $tokenContract, 'data' => $data],
                'latest'
            ], $config);
        }
        
        if (isset($response['result'])) {
            $hexBalance = $response['result'];
            return [
                'status' => 'success',
                'balance_hex' => $hexBalance,
                'msg' => 'Balance retrieved'
            ];
        }
        
        return [
            'status' => 'fail', 
            'msg' => isset($response['error']) ? $response['error']['message'] : 'RPC Error'
        ];
    }

    // Helper for JSON-RPC
    private function callJsonRpc($method, $params = [], $config = null) {
        if (!$config) {
            $config = $this->getBlockchainConfig();
        }
        $url = $config['rpc_url'];
        
        $data = [
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => $params,
            'id' => 1
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        
        if ($err) {
            return ['error' => ['message' => "cURL Error: $err"]];
        }

        return json_decode($response, true);
    }

    public function checkIfError()
    {
        $dbh = self::connect();
        $sqlA = "SELECT * FROM sitesettings WHERE sId=1";
        $queryA = $dbh->prepare($sqlA);
        $queryA->execute();
        $siteData = $queryA->fetch(PDO::FETCH_OBJ);
        return $siteData->errorStatus;
        // Default return (if no record or column missing)    
    }
    //----------------------------------------------------------------------------------------------------------------
    // Alpha Topup Management
    //----------------------------------------------------------------------------------------------------------------

    //Get All Alpha Topup Plans
    public function getAlphaTopupPlans()
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM alphatopupprice";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    //Alpha Topup 
    public function sendAlphaNotification($amount, $servicedesc)
    {
        $dbh = self::connect();
        $contact = $this->getSiteSettings();
        $subject = "Alpha Topup Request (" . $this->sitename . ")";
        $message = "This is to notify you that there is a new request for Alpha Topup on your website " . $this->sitename . ". Order Details : {$servicedesc}";
        $email = $contact->email;
        $check = self::sendMail($email, $subject, $message);
        return 0;
    }

    //Calculate Alpha Topup Discount
    public function calculateAlphaTopupDiscountDiscount($amount)
    {
        $dbh = self::connect();
        $sql = "SELECT * FROM alphatopupprice WHERE buyingPrice=:a";
        $query = $dbh->prepare($sql);
        $query->bindParam(':a', $amount, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
}

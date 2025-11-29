<?php

class InternetData extends ApiAccess
{


    //Purchase Data
    public function purchaseData($body, $networkDetails, $datagroup, $actualPlanId)
    {
        try {
            $details = $this->model->getApiDetails();
            $response = ["status" => "fail", "msg" => "Initialization failed"];

            // Validate input parameters
            if (!is_object($body)) {
                throw new Exception("Invalid request body");
            }

            if (!is_array($networkDetails)) {
                throw new Exception("Invalid network details");
            }

            if (empty($actualPlanId)) {
                throw new Exception("Plan ID is required");
            }

            // Check Data Group Type
            switch ($datagroup) {
                case "SME":
                    $name = "Sme";
                    $thenetworkId = $networkDetails["smeId"] ?? null;
                    break;
                case "Gifting":
                    $name = "Gifting";
                    $thenetworkId = $networkDetails["giftingId"] ?? null;
                    break;
                default:
                    $name = "Corporate";
                    $thenetworkId = $networkDetails["corporateId"] ?? null;
            }

            if (empty($thenetworkId)) {
                throw new Exception("Network ID not found for data group: " . $datagroup);
            }

            // Get Api Key Details
            $networkname = strtolower($networkDetails["network"] ?? '');
            $host = self::getConfigValue($details, $networkname . $name . "Provider");
            $apiKey = self::getConfigValue($details, $networkname . $name . "Api");

            if (empty($host) || empty($apiKey)) {
                throw new Exception("API configuration not found for network: " . $networkname);
            }

            // Check If API Is Using N3TData Or Bilalsubs
            if (strpos($host, 'n3tdata') !== false) {
                $hostuserurl = "https://n3tdata.com/api/user/";
                return $this->purchaseDataWithBasicAuthentication($body, $host, $hostuserurl, $apiKey, $thenetworkId, $actualPlanId);
            }

            if (strpos($host, 'bilalsadasub') !== false) {
                $hostuserurl = "https://bilalsadasub.com/api/user/";
                return $this->purchaseDataWithBasicAuthentication($body, $host, $hostuserurl, $apiKey, $thenetworkId, $actualPlanId);
            }

            // Purchase Data
            $ported_number = ($body->ported_number == "false") ? "false" : "true";

            $postData = [
                "network" => $thenetworkId,
                "mobile_number" => $body->phone,
                "Ported_number" => $ported_number,
                "request-id" => $body->ref,
                "plan" => $actualPlanId
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $host,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($postData),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    "Authorization: Token $apiKey"
                ],
            ]);

            $rawResponse = curl_exec($curl);
            $error = curl_error($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            // Log the complete request and response for debugging
            $logData = [
                'timestamp' => date('Y-m-d H:i:s'),
                'network' => $networkname,
                'data_group' => $datagroup,
                'plan_id' => $actualPlanId,
                'request' => $postData,
                'response' => $rawResponse,
                'error' => $error,
                'http_code' => $httpCode
            ];

            if ($error) {
                $this->logErrors("CURL Error: " . $error, $logData);
                return [
                    "status" => "fail",
                    "msg" => "Server Connection Error",
                    "error_details" => $error
                ];
            }

            $result = json_decode($rawResponse);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->logErrors("Invalid JSON response", $logData);
                return [
                    "status" => "fail",
                    "msg" => "Invalid server response",
                    "response" => $rawResponse
                ];
            }

            if (isset($result->Status) || isset($result->status)) {
                // Normalize status field
                $resultStatus = isset($result->Status) ? $result->Status : $result->status;
                // Handle different status values
                $resultStatus = strtolower($resultStatus);
                switch ($resultStatus) {
                    case 'success':
                    case 'successful':
                    case 'processing':
                        return ["status" => "success"];
                    case 'failed':
                    case 'fail':
                    case 'unsuccessful':
                        $errorMsg = $result->message ?? "Network Error, Please Try Again Later";
                        $this->logErrors("API Error: " . $errorMsg, $logData);
                        return [
                            "status" => "fail",
                            "msg" => $errorMsg,
                            "api_response" => $result
                        ];
                    default:
                        $errorMsg = $result->message ?? "Server/Network Error";
                        $this->logErrors("API Error: " . $errorMsg, $logData);
                        return [
                            "status" => "fail",
                            "msg" => $errorMsg,
                            "api_response" => $result
                        ];
                }
            } else {
                $this->logErrors("Unexpected API response format", $logData);
                return [
                    "status" => "fail",
                    "msg" => "Unexpected server response",
                    "api_response" => $result
                ];
            }
        } catch (Exception $e) {
            $this->logErrors("Exception: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'body' => $body,
                'networkDetails' => $networkDetails,
                'datagroup' => $datagroup,
                'actualPlanId' => $actualPlanId
            ]);
            return [
                "status" => "fail",
                "msg" => "System error occurred",
                "error" => $e->getMessage()
            ];
        }
    }

    //Purchase Data
    public function purchaseDataWithBasicAuthentication($body, $host, $hostuserurl, $apiKey, $thenetworkId, $actualPlanId)
    {
        try {
            $response = ["status" => "fail", "msg" => "Initialization failed"];
            $logData = [
                'timestamp' => date('Y-m-d H:i:s'),
                'network_id' => $thenetworkId,
                'plan_id' => $actualPlanId,
                'phone' => $body->phone,
                'reference' => $body->ref
            ];

            // Validate input parameters
            if (!is_object($body)) {
                throw new Exception("Invalid request body");
            }

            if (empty($thenetworkId) || empty($actualPlanId)) {
                throw new Exception("Missing required parameters");
            }

            // Get User Access Token
            $ported_number = ($body->ported_number == "false") ? false : true;

            $curlA = curl_init();
            curl_setopt_array($curlA, [
                CURLOPT_URL => $hostuserurl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60, // Reduced from 0 to prevent hanging
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => [
                    "Authorization: Basic $apiKey",
                    'Content-Type: application/json'
                ],
            ]);

            $tokenResponse = curl_exec($curlA);
            $tokenError = curl_error($curlA);
            $tokenHttpCode = curl_getinfo($curlA, CURLINFO_HTTP_CODE);

            // Log token request details
            $logData['token_request'] = [
                'url' => $hostuserurl,
                'http_code' => $tokenHttpCode,
                'error' => $tokenError
            ];

            if ($tokenError) {
                $this->logErrors("Token API Connection Error: " . $tokenError, $logData);
                curl_close($curlA);
                return [
                    "status" => "fail",
                    "msg" => "Server Connection Error",
                    "error_details" => $tokenError
                ];
            }

            $tokenResult = json_decode($tokenResponse);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->logErrors("Invalid Token API Response", array_merge($logData, [
                    'response' => $tokenResponse
                ]));
                curl_close($curlA);
                return [
                    "status" => "fail",
                    "msg" => "Invalid server response",
                    "response" => $tokenResponse
                ];
            }

            if (empty($tokenResult->AccessToken)) {
                $this->logErrors("Empty Access Token Received", array_merge($logData, [
                    'response' => $tokenResult
                ]));
                curl_close($curlA);
                return [
                    "status" => "fail",
                    "msg" => "Authentication failed",
                    "api_response" => $tokenResult
                ];
            }

            $apiKey = $tokenResult->AccessToken;
            curl_close($curlA);

            // Purchase Data
            $postData = [
                "network" => $thenetworkId,
                "phone" => $body->phone,
                "bypass" => $ported_number,
                "request-id" => $body->ref,
                "data_plan" => $actualPlanId
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $host,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60, // Reduced from 0 to prevent hanging
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($postData),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    "Authorization: Token $apiKey"
                ],
            ]);

            $purchaseResponse = curl_exec($curl);
            $purchaseError = curl_error($curl);
            $purchaseHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            // Log purchase request details
            $logData['purchase_request'] = [
                'url' => $host,
                'payload' => $postData,
                'http_code' => $purchaseHttpCode,
                'error' => $purchaseError,
                'response' => $purchaseResponse
            ];

            if ($purchaseError) {
                $this->logErrors("Purchase API Connection Error", $logData);
                return [
                    "status" => "fail",
                    "msg" => "Server Connection Error",
                    "error_details" => $purchaseError
                ];
            }

            $purchaseResult = json_decode($purchaseResponse);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->logErrors("Invalid Purchase API Response", $logData);
                return [
                    "status" => "fail",
                    "msg" => "Invalid server response",
                    "response" => $purchaseResponse
                ];
            }

            // Handle response status
            if (isset($purchaseResult->status)) {
                switch (strtolower($purchaseResult->status)) {
                    case 'successful':
                    case 'success':
                        // $this->logErrors("Data Purchase Successful", $logData);
                        return ["status" => "success"];

                    case 'fail':
                    case 'failed':
                        $errorMsg = $purchaseResult->message ?? "Network Error, Please Try Again Later";
                        $this->logErrors("Data Purchase Failed: " . $errorMsg, $logData);
                        return [
                            "status" => "fail",
                            "msg" => $errorMsg,
                            "api_response" => $purchaseResult
                        ];

                    default:
                        $errorMsg = $purchaseResult->message ?? "Server/Network Error";
                        $this->logErrors("Unexpected Purchase Status: " . $errorMsg, $logData);
                        return [
                            "status" => "fail",
                            "msg" => $errorMsg,
                            "api_response" => $purchaseResult
                        ];
                }
            } else {
                $this->logErrors("Missing Status in Purchase Response", $logData);
                return [
                    "status" => "fail",
                    "msg" => "Unexpected server response",
                    "api_response" => $purchaseResult
                ];
            }
        } catch (Exception $e) {
            $this->logErrors("Exception in purchaseDataWithBasicAuthentication: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'body' => $body,
                'host' => $host,
                'networkId' => $thenetworkId,
                'planId' => $actualPlanId
            ]);
            return [
                "status" => "fail",
                "msg" => "System error occurred",
                "error" => $e->getMessage()
            ];
        }
    }

    public function purchaseDataSMEPlug($body, $host, $apiKey, $thenetworkId, $actualPlanId)
    {

        $response = array();


        // ------------------------------------------
        //  Purchase Data
        // ------------------------------------------

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "network_id": "' . $thenetworkId . '",
                "plan_id": "' . $actualPlanId . '",
                "phone": "' . $body->phone . '",
                "customer_reference": "' . $body->ref . '"
            }',

            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                "Authorization: Bearer $apiKey"
            ),
        ));

        $exereq = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            $response["status"] = "fail";
            $response["msg"] = "Server Connection Error: " . $err;
            file_put_contents("data_error_log2.txt", json_encode($response));
            curl_close($curl);
            return $response;
        }

        $result = json_decode($exereq);
        curl_close($curl);


        if ($result->status == true || $result->status == "true") {
            if ($result->data->current_status == "processing") {
                $response["status"] = "processing";
            } elseif ($result->data->current_status == "failed") {
                $response["status"] = "fail";
            } else {
                $response["status"] = "success";
            }
            file_put_contents("smeplug_data_response.txt", json_encode($result));
        } else {
            $response["status"] = "fail";
            $response["msg"] = "Server/Network Error";
            file_put_contents("smeplug_data_error_log.txt", json_encode($result));
        }

        return $response;
    }

    //Purchase Airtime
    public function purchaseDataSimhost($body, $network, $dataplan, $apiKey)
    {

        $host = "https://simhostng.com/api/sms/";
        $callbackUrl = "https://motekdata.com/webhook/hostmasterresponse/";

        if ($network == 1) {
            $message = "";
            if ($dataplan == 1) {
                $message = "SMEB " . $body->phone . " 500 5818";
            }
            if ($dataplan == 2) {
                $message = "SMEC " . $body->phone . " 1000 5818";
            }
            if ($dataplan == 3) {
                $message = "SMED " . $body->phone . " 2000 5818";
            }
            if ($dataplan == 4) {
                $message = "SMEF " . $body->phone . " 3000 5818";
            }
            if ($dataplan == 5) {
                $message = "SMEE " . $body->phone . " 5000 5818";
            }
            if ($dataplan == 6) {
                $message = "SMEG " . $body->phone . " 10000 5818";
            }
            $message = urlencode($message);
            $network = "MOMTNBPVR";
            $sim = 1;
            $number = "131";
        }

        $postfields = "?apikey=$apiKey&server=$network&sim=$sim&ref=$body->ref&number=$number&message=$message";
        $host .= $postfields;

        // ------------------------------------------
        //  Purchase Airtime
        // ------------------------------------------

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                "apikey" => $apiKey,
                "server" => $network,
                "sim" => $sim,
                "number" => $number,
                "message" => $message,
                "ref" => $body->ref
            ),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $exereq = curl_exec($curl);

        $err = curl_error($curl);

        if ($err) {
            $response["status"] = "fail";
            $response["msg"] = "Server Connection Error: " . $err;
            file_put_contents("data_simhost_error_logo2.txt", json_encode($response));
            curl_close($curl);
            return $response;
        }

        $result = json_decode($exereq);
        curl_close($curl);

        if ($result->data[0]->response == "Ok") {
            $response["status"] = "processing";
        } else {
            $response["status"] = "fail";
            $response["msg"] = "Server/Network Error";
            file_put_contents("data_simhost_error_logo.txt", json_encode($result) . ":" . $host . ":" . $exereq);
        }

        return $response;
    }

    private function logErrors($message, $context = [])
    {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'From' => 'Controller:: InternetData',
            'message' => $message,
            'context' => $context,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_id' => $this->userId ?? 'unknown'
        ];

        // Log to single file with append mode
        file_put_contents(
            __DIR__ . '/../../log_error/error_log.txt',
            json_encode($logEntry) . PHP_EOL,
            FILE_APPEND
        );
    }
}

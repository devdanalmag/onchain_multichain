<?php

class MoralisModel extends Model
{
    private $apiKey;
    private $baseUrl = 'https://deep-index.moralis.io/api/v2.2';

    public function __construct()
    {
        $configFile = __DIR__ . '/../../config/moralis.json';
        if (file_exists($configFile)) {
            $config = json_decode(file_get_contents($configFile), true);
            $this->apiKey = $config['api_key'] ?? '';
        }
    }

    private function request($endpoint, $params = [])
    {
        if (!$this->apiKey || $this->apiKey === 'YOUR_MORALIS_API_KEY_HERE') {
            return ['status' => 'fail', 'msg' => 'Moralis API key not configured'];
        }

        $url = $this->baseUrl . $endpoint;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'X-API-Key: ' . $this->apiKey
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($result === false) {
            return ['status' => 'fail', 'msg' => 'cURL error: ' . $curlError];
        }

        if ($httpCode >= 400) {
            return ['status' => 'fail', 'msg' => 'Moralis API error: ' . $httpCode, 'data' => json_decode($result, true)];
        }

        $decoded = json_decode($result, true);
        if ($decoded === null) {
            return ['status' => 'fail', 'msg' => 'Failed to decode Moralis response'];
        }

        return $decoded;
    }

    public function getWalletTransactions($address, $chain, $page = 0, $limit = 10)
    {
        $chainMap = [
            'base' => '0x2105',
            'bsc' => '0x38',
            'bnb' => '0x38',
            'arbitrum' => '0xa4b1'
        ];

        $moralisChain = $chainMap[strtolower($chain)] ?? null;
        if (!$moralisChain) {
            return ['status' => 'fail', 'msg' => 'Unsupported chain'];
        }

        // Fetch Native Transactions
        $paramsNative = [
            'chain' => $moralisChain,
            'order' => 'DESC',
            'limit' => $limit
        ];
        $nativeResp = $this->request("/$address", $paramsNative);

        // Fetch ERC20 Transfers
        $paramsToken = [
            'chain' => $moralisChain,
            'order' => 'DESC',
            'limit' => $limit
        ];
        $tokenResp = $this->request("/$address/erc20/transfers", $paramsToken);

        $items = [];

        // Process Native
        if (isset($nativeResp['result'])) {
            foreach ($nativeResp['result'] as $tx) {
                $dateStr = $tx['block_timestamp'];
                try {
                    $dt = new DateTime($dateStr);
                    $dateStr = $dt->format('Y-m-d H:i:s');
                } catch (Exception $e) {
                }

                $items[] = [
                    'txhash' => $tx['hash'],
                    'txref' => substr($tx['hash'], 0, 10) . '...',
                    'date' => $dateStr,
                    'timestamp' => strtotime($tx['block_timestamp']),
                    'servicename' => 'Native Transfer',
                    'servicedesc' => 'Native Transaction',
                    'amount' => isset($tx['value']) ? number_format((float) $tx['value'] / 1e18, 6, '.', '') : 0,
                    'status' => 1,
                    'senderaddress' => $tx['from_address'],
                    'targetaddress' => $tx['to_address'],
                    'transaction_type' => ($tx['from_address'] == strtolower($address)) ? 'debit' : 'credit',
                    'token_name' => 'Native',
                    'token_contract' => null,
                    'token_amount' => null
                ];
            }
        }

        // Process Tokens
        if (isset($tokenResp['result'])) {
            foreach ($tokenResp['result'] as $tx) {
                $dateStr = $tx['block_timestamp'];
                try {
                    $dt = new DateTime($dateStr);
                    $dateStr = $dt->format('Y-m-d H:i:s');
                } catch (Exception $e) {
                }

                $decimals = isset($tx['token_decimals']) ? (int) $tx['token_decimals'] : 18;
                $val = isset($tx['value']) ? (float) $tx['value'] : 0;
                $amt = $val / pow(10, $decimals);

                $items[] = [
                    'txhash' => $tx['transaction_hash'],
                    'txref' => substr($tx['transaction_hash'], 0, 10) . '...',
                    'date' => $dateStr,
                    'timestamp' => strtotime($tx['block_timestamp']),
                    'servicename' => 'Token Transfer',
                    'servicedesc' => ($tx['token_symbol'] ?? 'Token') . ' Transfer',
                    'amount' => 0, // Native amount is 0 for token transfer usually (unless attached)
                    'status' => 1,
                    'senderaddress' => $tx['from_address'],
                    'targetaddress' => $tx['to_address'],
                    'transaction_type' => ($tx['from_address'] == strtolower($address)) ? 'debit' : 'credit',
                    'token_name' => $tx['token_symbol'] ?? 'Unknown',
                    'token_contract' => $tx['address'],
                    'token_amount' => number_format($amt, 6, '.', '')
                ];
            }
        }

        // Sort by timestamp DESC
        usort($items, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        // Slice to limit
        $items = array_slice($items, 0, $limit);

        return [
            'status' => 'success',
            'total' => count($items), // Approximation since we merged
            'page' => 0,
            'perPage' => $limit,
            'pages' => 1,
            'items' => $items
        ];
    }

    public function getTransactionByHash($tx_hash, $chain)
    {
        $chainMap = [
            'base' => '0x2105',
            'bsc' => '0x38',
            'bnb' => '0x38',
            'arbitrum' => '0xa4b1'
        ];

        $moralisChain = $chainMap[strtolower($chain)] ?? null;
        if (!$moralisChain)
            return null;

        return $this->request("/transaction/$tx_hash", ['chain' => $moralisChain]);
    }

    public function getTokenPrice($tokenAddress, $chain)
    {
        $chainMap = [
            'base' => '0x2105',
            'bsc' => '0x38',
            'bnb' => '0x38',
            'arbitrum' => '0xa4b1'
        ];
        $moralisChain = $chainMap[strtolower($chain)] ?? null;
        if (!$moralisChain)
            return null;

        // If address is empty, null, or 'native', it's the native token (ETH, BNB, etc.)
        if (empty($tokenAddress) || strtolower($tokenAddress) === 'native' || $tokenAddress === '0x0000000000000000000000000000000000000000') {
            // Wait, Moralis native price is usually /wallets/{address}/tokens/{token_address}/price?
            // Actually Moralis has a specific native price endpoint or we can use the wrapped version address
            // For convenience, Moralis /erc20/{address}/price works for wrapped tokens.
            // But for native, we might need a different approach.
            // Let's use the known wrapped addresses for each chain if it's native.
            $wrapped = [
                '0x2105' => '0x4200000000000000000000000000000000000006', // WETH on Base
                '0x38' => '0xbb4CdB9CBd36B01bD1cBaEBF2De08d9173bc095c', // WBNB on BSC
                '0xa4b1' => '0x82aF49447D8a07e3bd95BD0d56f35241523fBab1'  // WETH on Arbitrum
            ];
            $tokenAddress = $wrapped[$moralisChain] ?? $tokenAddress;
        }

        return $this->request("/erc20/$tokenAddress/price", ['chain' => $moralisChain]);
    }

    public function getNativeBalance($address, $chain)
    {
        $chainMap = [
            'base' => '0x2105',
            'bsc' => '0x38',
            'bnb' => '0x38',
            'arbitrum' => '0xa4b1'
        ];
        $moralisChain = $chainMap[strtolower($chain)] ?? null;
        if (!$moralisChain)
            return null;

        return $this->request("/$address/balance", ['chain' => $moralisChain]);
    }
}
?>
<?php

class OssnWallet extends OssnDatabase {

    const TABLE = 'ossn_wallet';
    const DAK = 'DAK';
    const USDT = 'USDT';
    const WALLET_API_BASE_URL = 'http://127.0.0.1:4003';
    const DAK_ADMIN_WALLET_ADDRESS = '0x1d841125021aae5bd05fa3a05b426b82614fd863';
    const USDT_ADMIN_WALLET_PASSWORD = 'yR7kxCHLpn5Vzghp';

    const SWAP_RATE = 10;

    const STATUS_PENDING = 1;
    const STATUS_CONFIRMED = 2;


    /**
     * Initialize the objects.
     *
     * @return void
     */
    public function __construct() {
        //php warnings when deleting a message #1353
        //$this->data = new stdClass;
        //$this->curl = new Curl();
        $this->user_id = ossn_loggedin_user()->guid;
    }


    public function updateDak($balance){
        $symbol = self::DAK;
        $wallet = $this->getWalletBySymbol($symbol, $this->user_id);
        if(!$wallet){
            $this->createWallet($symbol, $this->generateRandomString(6));
            $wallet = $this->getWalletBySymbol($symbol, $this->user_id);
        }
        if($wallet && $balance > 0 && $wallet->balance != $balance){
            $params['table'] = 'ossn_wallet';
            $params['names'] = array('balance', 'time_updated');
            $params['values'] = array($balance, time());
            $params['wheres'] = array(
                "user_id = {$this->user_id} AND symbol = '{$symbol}'"
            );
            if($this->update($params)){
                $guid = $this->getLastEntry();
                ossn_trigger_callback('wallet_balance', 'update', array(
                    'guid' => $guid
                ));
                return true;
            }
        }
        return false;
    }


    public function getWalletBySymbol($symbol, $user_id){
        if (!empty($symbol) && !empty($user_id)) {
            $params['from'] = self::TABLE;
            $params['wheres'] = array(
                "user_id = {$user_id} AND symbol='{$symbol}'"
            );
            $wallet = $this->select($params);
        }
        if (!$wallet) {
            return false;
        }
        $data = $wallet;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('wallet', 'get', false, $metadata);
    }


    public function getWalletById($id){
        if (!empty($id)) {
            $params['from'] = self::TABLE;
            $params['wheres'] = array(
                "id='{$id}'"
            );
            $wallet = $this->select($params);
        }
        if (!$wallet) {
            return false;
        }
        $data = $wallet;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('wallet', 'get', false, $metadata);
    }


    public function getWalletByUserId($user_id) {

        $params['from'] = self::TABLE;
        $params['wheres'] = array(
            "user_id = {$user_id}"
        );
        $wallet = $this->select($params, true);
        if (!$wallet) {
            return false;
        }
        $data = $wallet;
        $metadata = arrayObject($data, get_class($this));
        //$metadata->data = new stdClass;
        return ossn_call_hook('wallet', 'get', false, $data);

    }

    public function getWalletByAddress($address) {
        $params['from'] = self::TABLE;
        $params['wheres'] = array(
            "address = '{$address}'"
        );
        $wallet = $this->select($params);
        if (!$wallet) {
            return false;
        }
        $data = $wallet;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('wallet', 'get', false, $data);
    }

    private function preCurl(){
        global $Ossn;
        $curl = new Curl();
        $curl->headers = array(
            //'Authorization' =>  'Bearer 4UDB3dHF79h96yVVHvY6c6d51SEU501XwBe',
            'Authorization' =>  'Bearer ' . $Ossn->wallet_api_bearer_key,
            'Content-Type' => 'application/json',
        );
        return $curl;
    }


    public function createWallet($symbol, $password){
        $wallet = $this->getWalletBySymbol($symbol, ossn_loggedin_user()->guid);
        if(!$wallet){
            $params = array(
                'into' => 'ossn_wallet',
                'names' => array(
                    'user_id',
                    'name',
                    'symbol',
                    'time_created'
                ),
                'values' => array(
                    ossn_loggedin_user()->guid,
                    strtoupper($symbol),
                    strtoupper($symbol),
                    time()
                ),
            );
            if ($this->insert($params)) {
                $guid = $this->getLastEntry();
                ossn_trigger_callback('wallet', 'created', array(
                    'guid' => $guid
                ));
                $wallet = $this->getWalletBySymbol($symbol, $this->user_id);
            }
        }
        if($wallet->address == null){
            global $Ossn;
            $curl = $this->preCurl();
            $endpoint = ($symbol == self::USDT) ? '/usdtoken/create/account' : '/ethereum/create/account';
            $url = $Ossn->wallet_api_base_url . $endpoint;
            $data = json_encode(array(
                'password' => $password
            ));
            $request = $curl->post($url,$data);
            if($request->headers['Status-Code'] == '200'){
                $result = json_decode($request->body);
                if($result->address){
                    $params = array(
                        'table' => 'ossn_wallet',
                        'names' => array(
                            'address',
                            'time_updated'
                        ),
                        'values' => array(
                            $result->address,
                            time()
                        ),
                        'wheres' => array(
                            "user_id = {$this->user_id} AND symbol = '{$symbol}'"
                        )
                    );
                    if ($this->update($params)) {
                        $guid = $this->getLastEntry();
                        ossn_trigger_callback('wallet', 'update', array(
                            'guid' => $guid
                        ));
                        return $result;
                    }

                }
                return false;
            } else {
                return false;
            }
        }

    }

    public function apiCreateWallet($symbol, $password){
        global  $Ossn;
        $curl = $this->preCurl();
        $endpoint = ($symbol == self::USDT) ? '/usdtoken/create/account' : '/ethereum/create/account';
        $url = $Ossn->wallet_api_base_url . $endpoint;
        //$url = self::WALLET_API_BASE_URL . $endpoint;
        $data = json_encode(array(
            'password' => $password
        ));
        $request = $curl->post($url,$data);
        if($request->headers['Status-Code'] == '200'){
            $result = json_decode($request->body);
            if($result->address){
                return $result;
            }
            return false;
        } else {
            return false;
        }
    }

    public function withdrawMoney($symbol, $user_id, $amount, $to_address){
        $wallet = $this->getWalletBySymbol($symbol, $user_id);
        if($wallet && $wallet->balance > $amount){
            global  $Ossn;
            $curl = $this->preCurl();
            if($symbol == self::USDT){
                $endpoint = '/usdtoken/widthdrawToAddress';
                $data = json_encode(array(
                    'password' => self::USDT_ADMIN_WALLET_PASSWORD,
                    'address' => $to_address,
                    'amount' => $amount
                ));
            } else {
                $endpoint = '/ethereum/transfer';
                $data = json_encode(array(
                    'from_address' => $wallet->address,
                    'to_address' => $to_address,
                    'amount' => $amount
                ));
            }
            $url = $Ossn->wallet_api_base_url . $endpoint;
            $request = $curl->post($url,$data);
            $result = json_decode($request->body);
            if($request->headers['Status-Code'] == '200' && isset($result)){
                if($symbol == self::USDT && isset($result->receipt->transactionHash)){
                    $withdraw = array(
                        'amount' => $amount,
                        'from' => $wallet->address,
                        'to' => $to_address,
                        'hash' => $result->receipt->transactionHash
                    );
                    $this->addWithdraw($withdraw);
                    return array(
                        'status' => 'success',
                        'msg' => ''
                    );
                } elseif($symbol == self::DAK && isset($result->hash)) {
                    $withdraw = array(
                        'amount' => $amount,
                        'from' => $wallet->address,
                        'to' => $to_address,
                        'hash' => $result->hash
                    );
                    $this->addWithdraw($withdraw);
                    return array(
                        'status' => 'success',
                        'msg' => ''
                    );
                }
            } else {
                if(isset($result->errmsg)){
                    return array(
                        'status' => 'error',
                        'msg' => $result->errmsg
                    );
                }
            }

        }

        return array(
            'status' => 'error',
            'msg' => 'unknown error'
        );

    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    public function getWalletLog($wallet_id, $user_id, $type){
        $table = ($type == 'deposit') ? 'ossn_deposit' : 'ossn_withdraw';
        $params['from'] = $table;
        $params['wheres'] = array(
            "amount > 0 AND wallet_id = {$wallet_id} AND user_id = {$user_id}"
        );
        $wallet = $this->select($params, true);
        if (!$wallet) {
            return false;
        }
        $data = $wallet;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('wallet_log', 'get', false, $data);

    }


    public function addDeposit($deposit){
        if($deposit['from'] && $deposit['to'] && $deposit['hash'] && $deposit['amount']){
            $get = $this->getWalletByAddress($deposit['to']);
            $before_balance = $get->balance;
            $exist = $this->checkDeposit($deposit);
            if(isset($get) && !$exist){
                $params = array(
                    'into' => 'ossn_deposit',
                    'names' => array(
                        'wallet_id',
                        'user_id',
                        'status',
                        'amount',
                        'from_address',
                        'to_address',
                        'tx_hash',
                        'time_created'
                    ),
                    'values' => array(
                        $get->id,
                        $get->user_id,
                        self::STATUS_CONFIRMED,
                        $deposit['amount'],
                        $deposit['from'],
                        $deposit['to'],
                        $deposit['hash'],
                        time()
                    ),
                );
                if ($this->insert($params)) {
                    $guid = $this->getLastEntry();
                    ossn_trigger_callback('wallet_deposit', 'created', array(
                        'guid' => $guid
                    ));
                    $after_balance = $before_balance + $deposit['amount'];
                    unset($params);
                    $params['table'] = 'ossn_wallet';
                    $params['names'] = array('balance', 'time_updated');
                    $params['values'] = array($after_balance, time());
                    $params['wheres'] = array(
                        "id = {$get->id}"
                    );
                    if($this->update($params)){
                        $wallet_id = $this->getLastEntry();
                        ossn_trigger_callback('wallet_balance', 'update', array(
                            'guid' => $wallet_id
                        ));
                    }
                    return true;
                }
            }

        }
        return false;
    }

    public function checkDeposit($deposit){
        $params['from'] = 'ossn_deposit';
        $params['wheres'] = array(
            "to_address = '{$deposit['to']}' AND tx_hash = '{$deposit['hash']}'"
        );
        $wallet = $this->select($params);
        if (!$wallet) {
            return false;
        }
        $data = $wallet;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('ossn_deposit', 'get', false, $data);
    }


    public function addWithdraw($withdraw){
        if($withdraw['from'] && $withdraw['to'] && $withdraw['hash'] && $withdraw['amount']){
            $get = $this->getWalletByAddress($withdraw['from']);
            $before_balance = $get->balance;
            $exist = $this->checkWithdraw($withdraw);
            if(isset($get) && !$exist){
                $params = array(
                    'into' => 'ossn_withdraw',
                    'names' => array(
                        'wallet_id',
                        'user_id',
                        'status',
                        'amount',
                        'from_address',
                        'to_address',
                        'tx_hash',
                        'time_created'
                    ),
                    'values' => array(
                        $get->id,
                        $get->user_id,
                        self::STATUS_CONFIRMED,
                        $withdraw['amount'],
                        $withdraw['from'],
                        $withdraw['to'],
                        $withdraw['hash'],
                        time()
                    ),
                );
                if ($this->insert($params)) {
                    $guid = $this->getLastEntry();
                    ossn_trigger_callback('wallet_withdraw', 'created', array(
                        'guid' => $guid
                    ));

                    $after_balance = $before_balance - $withdraw['amount'];
                    unset($params);
                    $params['table'] = 'ossn_wallet';
                    $params['names'] = array('balance', 'time_updated');
                    $params['values'] = array($after_balance, time());
                    $params['wheres'] = array(
                        "id = {$get->id}"
                    );
                    if($this->update($params)){
                        $wallet_id = $this->getLastEntry();
                        ossn_trigger_callback('wallet_balance', 'update', array(
                            'guid' => $wallet_id
                        ));
                    }
                    return true;
                }
            }

        }
        return false;
    }

    public function checkWithdraw($deposit){
        $params['from'] = 'ossn_withdraw';
        $params['wheres'] = array(
            "tx_hash = '{$deposit['hash']}' AND from_address = '{$deposit['from']}'"
        );
        $wallet = $this->select($params);
        if (!$wallet) {
            return false;
        }
        $data = $wallet;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('ossn_withdraw', 'get', false, $data);

    }

    public static function getStatusText($status){
        $array = array(
            self::STATUS_CONFIRMED => 'CONFIRMED',
            self::STATUS_PENDING => 'PENDING',
        );
        if(in_array($status, array_keys($array))){
            return $array[$status];
        } else {
            return '';
        }
    }


    public function setDakBalance($new_balance) {
        $user = ossn_loggedin_user();
        if($user) {
            $user_id             = $user->guid;
            $params['table']  = 'ossn_wallet';
            $params['names']  = array(
                'balance'
            );
            $params['values'] = array(
                $new_balance
            );
            $params['wheres'] = array(
                "user_id='{$user_id}' AND symbol = 'dak'"
            );
            if($user_id > 0 && $this->update($params)) {
                return true;
            }
        }
        return false;
    }

    public function Swap($amount, $symbol){

        $user = ossn_loggedin_user();
        $user_id             = $user->guid;
        $from_wallet = $this->getWalletBySymbol($symbol, $user_id);
        if($symbol == self::DAK){
            $to_wallet = $this->getWalletBySymbol(self::USDT, $user_id);
            $receive = $amount / self::SWAP_RATE;
        } elseif( $symbol == self::USDT){
            $to_wallet = $this->getWalletBySymbol(self::DAK, $user_id);
            $receive = $amount * self::SWAP_RATE;
        }
        if($from_wallet && $to_wallet && $receive > 0){
            $current_from_balance = $from_wallet->balance;
            $current_to_balance = $to_wallet->balance;
            $from_new_balance = $current_from_balance - $amount;
            $to_new_balance = $current_to_balance + $receive;
            $update_from_balance = array(
                'table' => self::TABLE,
                'names' => array('balance'),
                'values' => array($from_new_balance),
                'wheres' => array(
                    "id = {$from_wallet->id}"
                ),
            );
            if($this->update($update_from_balance)) {
                $update_to_balance = array(
                    'table' => self::TABLE,
                    'names' => array('balance'),
                    'values' => array($to_new_balance),
                    'wheres' => array(
                        "id = {$to_wallet->id}"
                    ),
                );
                $this->update($update_to_balance);
                $log_params = array(
                    'into' => 'ossn_swap',
                    'names' => array(
                        'user_id',
                        'from_wallet_id',
                        'to_wallet_id',
                        'symbol',
                        'swap_amount',
                        'receive_amount',
                        'time_created'
                    ),
                    'values' => array(
                        $user_id,
                        $from_wallet->id,
                        $to_wallet->id,
                        $symbol,
                        $amount,
                        $receive,
                        time()
                    ),
                );
                $this->insert($log_params);
                return true;
            } else {
                $rollback_from = array(
                    'table' => self::TABLE,
                    'names' => array('balance'),
                    'values' => array($current_from_balance),
                    'wheres' => array(
                        "id = {$from_wallet->id}"
                    ),
                );
                $this->update($rollback_from);
                $rollback_to = array(
                    'table' => self::TABLE,
                    'names' => array('balance'),
                    'values' => array($current_to_balance),
                    'wheres' => array(
                        "id = {$to_wallet->id}"
                    ),
                );
                $this->update($rollback_from);
                return false;
            }

        }

    }

    /*
     * decimal $amount
     * string $symbol: DAK
     * object: $to_user
     * */
    public function Send($amount, $symbol, $to_user){

        $user = ossn_loggedin_user();
        $user_id             = $user->guid;
        $to_user_id          = $to_user->guid;
        $from_wallet = $this->getWalletBySymbol($symbol, $user_id);
        $to_wallet = $this->getWalletBySymbol(self::DAK, $to_user_id);
        if($from_wallet && $to_wallet){
            $current_from_balance = $from_wallet->balance;
            $current_to_balance = $to_wallet->balance;
            $from_new_balance = $current_from_balance - $amount;
            $to_new_balance = $current_to_balance + $amount;
            $update_from_balance = array(
                'table' => self::TABLE,
                'names' => array('balance'),
                'values' => array($from_new_balance),
                'wheres' => array(
                    "id = {$from_wallet->id}"
                ),
            );
            if($this->update($update_from_balance)) {
                $update_to_balance = array(
                    'table' => self::TABLE,
                    'names' => array('balance'),
                    'values' => array($to_new_balance),
                    'wheres' => array(
                        "id = {$to_wallet->id}"
                    ),
                );
                $this->update($update_to_balance);
                $log_params = array(
                    'into' => 'ossn_send',
                    'names' => array(
                        'from_user_id',
                        'to_user_id',
                        'from_wallet_id',
                        'to_wallet_id',
                        'symbol',
                        'send_amount',
                        'receive_amount',
                        'time_created'
                    ),
                    'values' => array(
                        $user_id,
                        $to_user_id,
                        $from_wallet->id,
                        $to_wallet->id,
                        $symbol,
                        $amount,
                        $amount,
                        time()
                    ),
                );
                $this->insert($log_params);
                return true;
            } else {
                $rollback_from = array(
                    'table' => self::TABLE,
                    'names' => array('balance'),
                    'values' => array($current_from_balance),
                    'wheres' => array(
                        "id = {$from_wallet->id}"
                    ),
                );
                $this->update($rollback_from);
                $rollback_to = array(
                    'table' => self::TABLE,
                    'names' => array('balance'),
                    'values' => array($current_to_balance),
                    'wheres' => array(
                        "id = {$to_wallet->id}"
                    ),
                );
                $this->update($rollback_from);
                return false;
            }

        }

    }








} //class

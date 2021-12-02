<?php


class OssnJackpot extends OssnDatabase {

    const TABLE_JACKPOT = 'ossn_jackpot';
    const TABLE_JACKPOT_PLAY = 'ossn_jackpot_play';
    const NUMBER_PRICE = 10;



    public function getMyNumber(){
        $user_id = ossn_loggedin_user()->guid;
        $params['from'] = self::TABLE_JACKPOT_PLAY;
        $params['wheres'] = array(
            "user_id = {$user_id}"
        );
        $params['order_by'] = 'id DESC';
        $jackpot = $this->select($params, true);
        if (!$jackpot) {
            return false;
        }
        $data = $jackpot;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('jackpot_play', 'get', false, $metadata);
    }

    public function getTopTenJackpot(){
        $day = date('Y-m-d', strtotime('-10 days'));
        $params['from'] = self::TABLE_JACKPOT;
        $params['wheres'] = array(
            "date > '{$day}'"
        );
        $params['order_by'] = 'id DESC';
        $jackpot = $this->select($params, true);
        if (!$jackpot) {
            return false;
        }
        $data = $jackpot;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('jackpot', 'get', false, $metadata);
    }


    public function buyNumber($date, $ampm, $number){
        $today = date('Y-m-d', time());
        if($date < $today){
            return false;
        }
        if($ampm != 'am' && $ampm != 'pm'){
            return false;
        }
        if(!is_numeric($number) || strlen($number) != 6){
            return false;
        }
        $w = new OssnWallet();
        $dak = $w->getWalletBySymbol(OssnWallet::DAK, ossn_loggedin_user()->guid);
        if($dak->balance < self::NUMBER_PRICE){
            return false;
        }
        $slots = str_split($number);
        $params = array(
            'into' => self::TABLE_JACKPOT_PLAY,
            'names' => array(
                'user_id',
                'date',
                'am_pm',
                'full_slot',
                'slot_1',
                'slot_2',
                'slot_3',
                'slot_4',
                'slot_5',
                'slot_6',
                'time_created'
            ),
            'values' => array(
                ossn_loggedin_user()->guid,
                $date,
                $ampm,
                $number,
                $slots[0],
                $slots[1],
                $slots[2],
                $slots[3],
                $slots[4],
                $slots[5],
                time()
            ),
        );
        if ($this->insert($params)) {
            $guid = $this->getLastEntry();
            $after_balance = $dak->balance - self::NUMBER_PRICE;
            $this->updateBalance($after_balance, ossn_loggedin_user()->guid);
            ossn_trigger_callback('jackpot_play', 'created', array(
                'guid' => $guid
            ));
            return true;
        }

    }


    public function updateBalance($balance, $user_id){
        $symbol = OssnWallet::DAK;
        $params['table'] = 'ossn_wallet';
        $params['names'] = array('balance', 'time_updated');
        $params['values'] = array($balance, time());
        $params['wheres'] = array(
            "user_id = {$user_id} AND symbol = '{$symbol}'"
        );
        if($this->update($params)){
            $guid = $this->getLastEntry();
            ossn_trigger_callback('wallet_balance', 'update', array(
                'guid' => $guid
            ));
            return true;
        }
    }

    public function getLastDrawNumber(){
        $params = array(
            'from' => self::TABLE_JACKPOT,
            'wheres' => array("total_jackpot is null"),
            'order_by' => 'id DESC',
            'limit' => '1'
        );
        $jackpot = $this->select($params);
        if (!$jackpot) {
            return false;
        }
        $data = $jackpot;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('jackpot', 'get', false, $metadata);

    }


    public function generateWinningNumber($date, $ampm, $number){
        $ps = new OssnPointSetting();
        $point = $ps->getPointSettingByCode('jackpot');
        $reward = $point->value;
        $without_reward_round = 0;
        $lastDraw = $this->getLastDrawNumber();
        if(!$lastDraw && $point && $point->value > 0){
            $without_reward_round = 1;
        } else {
            if($lastDraw->without_reward_round < 10){
                $reward = $lastDraw->reward * 2;
                $without_reward_round = $lastDraw->without_reward_round + 1;
            } elseif($lastDraw->without_reward_round == 10){
                $without_reward_round = 1;
            }
        }

        $slots = str_split($number);
        $params = array(
            'into' => self::TABLE_JACKPOT,
            'names' => array(
                'date',
                'am_pm',
                'full_slot',
                'slot_1',
                'slot_2',
                'slot_3',
                'slot_4',
                'slot_5',
                'slot_6',
                'reward',
                'without_reward_round',
                'time_created'
            ),
            'values' => array(
                $date,
                $ampm,
                $number,
                $slots[0],
                $slots[1],
                $slots[2],
                $slots[3],
                $slots[4],
                $slots[5],
                $reward,
                $without_reward_round,
                time()
            ),
        );
        if ($this->insert($params)) {
            $guid = $this->getLastEntry();
            ossn_trigger_callback('jackpot', 'created', array(
                'guid' => $guid
            ));
            return $guid;
        }
    }


    public function getWinningNumberByParams($params){
        $default['from'] = self::TABLE_JACKPOT;
        $options = array_merge($default, $params);
        $jackpot = $this->select($options);
        if (!$jackpot) {
            return false;
        }
        $data = $jackpot;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('jackpot', 'get', false, $metadata);
    }

    public function getAllPlayingNumber($date, $ampm){
        $params['from'] = self::TABLE_JACKPOT_PLAY;
        $params['wheres'] = array(
            "date = '{$date}' AND am_pm = '{$ampm}'"
        );
        $jackpot = $this->select($params, true);
        if (!$jackpot) {
            return false;
        }
        $data = $jackpot;
        $metadata = arrayObject($data, get_class($this));
        return ossn_call_hook('jackpot_play', 'get', false, $metadata);
    }

    public function updatePlayerReward($id, $jackpot_id, $max_slot_prize, $prize_amount, $user_id, $total_jackpot = 0){
        $update_params = array(
            'table' => OssnJackpot::TABLE_JACKPOT_PLAY,
            'names' => array('jackpot_id', 'max_slot_prize', 'prize_amount', 'time_updated'),
            'values' => array($jackpot_id, $max_slot_prize, $prize_amount, time()),
            'wheres' => array(" id = {$id} ")
        );
        if($this->update($update_params)){
            $guid = $this->getLastEntry();
            ossn_trigger_callback('ossn_jackpot_play', 'update', array(
                'guid' => $guid
            ));

            if($total_jackpot > 0){
                $jackpot_params = array(
                    'table' => OssnJackpot::TABLE_JACKPOT,
                    'names' => array('total_jackpot', 'without_reward_round', 'time_updated'),
                    'values' => array($total_jackpot, 1, time()),
                    'wheres' => array(" id = {$jackpot_id} ")
                );
                $this->update($jackpot_params);
            }

            $w = new OssnWallet();
            $dak = $w->getWalletBySymbol(OssnWallet::DAK, $user_id);
            $after_balance = $dak->balance + $prize_amount;
            $this->updateBalance($after_balance, $user_id);
            return true;
        }
    }





    public function generateRandomString($length = 10) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }













} //class

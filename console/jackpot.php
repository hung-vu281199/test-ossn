<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
define('OSSN_ALLOW_SYSTEM_START', TRUE);
require_once(dirname(__FILE__) .'/../system/start.php');
$jackpot_id = 0;
$point_setting = new OssnPointSetting();
$jackpot = new OssnJackpot();
$number = $jackpot->generateRandomString(6);
$now = time();
$today = date('Y-m-d', $now);
$am_pm = date('A', $now);
if($am_pm == 'AM'){
    $ampm = 'am';
} else {
    $ampm = 'pm';
}
$check_params = array('wheres' => array("date = '{$today}' AND am_pm = '{$ampm}'"));
$check = $jackpot->getWinningNumberByParams($check_params);
if(!$check){
    $jackpot_id = $jackpot->generateWinningNumber($today, $ampm, $number);
    $check = $jackpot->getWinningNumberByParams($check_params);
}
$number = $check->full_slot;
$jackpot_id = $check->id;




$playing = $jackpot->getAllPlayingNumber($today, $ampm);
$numberArr = str_split($number);

echo '<pre>';
print_r($numberArr);
echo '</pre>';
echo "\n";

if(count($playing) > 0){
    $totalJackpot = array();
    foreach ($playing as $play){
        echo "Begin match number: " . $play->full_slot . "\n";
        $numberPlayingArr = str_split($play->full_slot);
        $matchCount = 0;
        if(count($numberArr) == 6){
            foreach ($numberPlayingArr as $numberPlaying){
                if(in_array($numberPlaying, $numberArr)){
                    $numberArrKey = end(array_keys($numberArr, $numberPlaying));
                    echo "\t Match number:" . $numberPlaying . "\n";
                    $matchCount++;
                    unset($numberArr[$numberArrKey]);
                } else {
                    echo "\t Number not match:" . $numberPlaying . "\n";
                }
            }
            //if jackpot
            if($matchCount == 6){
                $reward_key = 'jackpot';
                $totalJackpot[] = $play;
            } else {
                $reward_key = 'jackpot_' . $matchCount;
                $point = $point_setting->getPointSettingByCode($reward_key);
                if($point && $point->value > 0){
                    //$id, $jackpot_id, $max_slot_prize, $prize_amount
                    $jackpot->updatePlayerReward($play->id, $jackpot_id, $matchCount, $point->value, $play->user_id, false);
                }
            }

            echo "\t #######################\n";
            echo "\t TOTAL MATCH: " . $matchCount . "\n";
            echo "\t #######################\n";
        }
        $numberArr = str_split($number);
        echo "End of number: " . $play->full_slot . "\n\n";
    }



    if($totalJackpot > 0 && $check->reward > 0){
        $jackpot_reward = $check->reward / count($totalJackpot);
        foreach ($totalJackpot as $play){
            $jackpot->updatePlayerReward($play->id, $jackpot_id, 6, $jackpot_reward, $play->user_id, count($totalJackpot));
        }
    }
}


















<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author     Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   SOFTLAB24 COMMERCIAL LICENSE https://www.softlab24.com/license/commercial-license-v1
 * @link      https://www.softlab24.com/
 */
 class Points extends OssnBase {
	 	/**
		 * Init Points
		 * 
		 * @param integer $int User guid
		 * @return void
		 */
	 	public function __construct($guid = false){
	 	        $this->user = false;
				if($guid){
                    $this->user = ossn_user_by_guid($guid);
				}
		}
	 	/**
		 * add user points
		 * 
		 * @param integer $points User points
		 * @return boolean
		 */		
		public function addPoints($points = '', $setting_id){
				if($this->user){
				    $w = new OssnWallet();
				    $symbol = OssnWallet::DAK;
				    $wallet = $w->getWalletBySymbol($symbol, $this->user->guid);
				    if(!$wallet){
                        $password = $w->generateRandomString(6);
                        $w->createWallet($symbol, $password);
                        $wallet = $w->getWalletBySymbol($symbol, $this->user->guid);
                    }
                    $balance = $wallet->balance > 0 ? $wallet->balance : 0;
				    $newBalance = $balance + $points;


				    $log = new OssnPointLog();
                    $todayPoint = $log->getTodayPoint($this->user->guid);
                    if($todayPoint < OssnPointSetting::MAX_POINT_TODAY){
                        $log->user_id = $this->user->guid;
                        $log->point_setting_id = $setting_id;
                        $log->value = $points;
                        $log->before_balance = $balance;
                        $log->after_balance = $newBalance;
                        $log->change_type = OssnPointLog::CHANGE_ADD;
                        $log->source = OssnPointLog::SOURCE_SOCIAL;
                        $log->time_created = time();
                        $log->addPointLog();
                        ossn_update_balance($newBalance);

                    }

				}
				return false;
		}
	 	/**
		 * Get Points
		 * 
		 * @return integer
		 */		
		public function getPoints(){
            $w = new OssnWallet();
            $symbol = OssnWallet::DAK;
            $wallet = $w->getWalletBySymbol($symbol, $this->user->guid);
            if(isset($wallet)){
                    return $wallet->balance;
            }
            return 0;
		}
 }
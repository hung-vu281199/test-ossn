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
define('__POINTS__', ossn_route()->com . 'Points/');
require_once(__POINTS__ . 'classes/Points.php');
/**
 * Initilize the component
 *
 * @return void
 */
function points_init() {
		ossn_extend_view('css/ossn.default', 'css/points');

        ossn_register_callback('login', 'success', 'points_add');
		//ossn_register_callback('wall', 'post:created', 'points_add');
		ossn_register_callback('comment', 'created', 'points_add');
		ossn_register_callback('like', 'created', 'points_add');
		//ossn_register_callback('message', 'created', 'points_add');
		//ossn_register_callback('ossn:photo', 'add', 'points_add');
		//ossn_extend_view('profile/role', 'points/user');
}
/**
 * add the points to user
 *
 * @param $callback 	string name of callback
 * @param $type 	 	string callback type
 * @param $params       array option values
 * 
 * @access private
 * @return void
 */
function points_add($callback, $type, $params) {
        $pss = ossn_point_setting_list();
        $psArr = [];
        if(count($pss) > 0){
            foreach ($pss as $ps){
                $psArr[$ps->code] = $ps;
            }
        }
        $point_setting_id = 0;
		switch($callback . ':' . $type) {
                case 'login:success':
                    $points = 0;
                    if(in_array('login', $psArr)){
                        break;
                    }
                    $today = convert_unixtime(time());
                    $last_login_date = convert_unixtime($params['user']->last_login);
                    $setting = $psArr['login'];
                    $log = ossn_get_point_log(array(
                        "wheres" => array(
                            "value = {$setting->value} AND user_id={$params['user']->guid} AND point_setting_id={$setting->guid} AND FROM_UNIXTIME(time_created, '%Y-%m-%d') = '{$today}'"
                        )
                    ));
                    if(!$log || count($log) < 1){
                        $points = $setting->value;
                        $point_setting_id = $setting->guid;
                    }
                    $guid   = $params['user']->guid;
                    break;
				case 'wall:post:created':
						$points = 5;
						$guid   = $params['poster_guid'];
						break;
				case 'comment:created':
                        if(in_array('comment', $psArr)){
                            break;
                        }
						$points  = 0;
                        $setting = $psArr['comment'];
						$comment = ossn_get_annotation($params['id']);
						$guid    = false;
						if($comment) {
                            $points = $setting->value;
                            $guid = $comment->owner_guid;
                            $point_setting_id = $setting->guid;
						}
						break;
				case 'like:created';
                    $points = 0;
                    if(in_array('like', $psArr) && isset($params['reaction_type']) && $params['reaction_type'] == 'love'){
                        $points = $psArr['like']->value;
                        $point_setting_id = $psArr['like']->guid;
                    }
                    $guid   = $params['owner_guid'];
                    break;
				case 'message:created':
                    $points = 2;
                    $guid   = $params['message_from'];
                    break;
				case 'ossn:photo:add':
                    $points = 10;
                    $guid   = $params['album']->album->owner_guid;
                    break;
		}
		if(!empty($guid) && !empty($points) && $points > 0 && $point_setting_id > 0) {
				$point = new Points($guid);
				$point->addPoints($points, $point_setting_id);
		}
}
ossn_register_callback('ossn', 'init', 'points_init');
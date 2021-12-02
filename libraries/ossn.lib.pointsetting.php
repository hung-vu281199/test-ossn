<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */

/**
 * Initialize categories class
 *
 * @return bool;
 */
function ossn_point_setting(){
    $ps = new OssnPointSetting();
    return $ps;
}




/**
 * Get a point setting by id
 *
 * @param $guid 'guid' of user
 *
 * @return object
 */
function ossn_point_setting_by_guid($guid)
{
    $ps = new OssnPointSetting();
    $ps->guid = $guid;
    return $ps->getPointSetting();
}



/**
 * Get a point setting by id
 *
 * @param $guid 'guid' of user
 *
 * @return object
 */
function ossn_point_setting_by_code($code)
{
    $ps = new OssnPointSetting();
    $ps->code = $code;
    return $ps->getPointSetting();
}



function ossn_point_setting_list(){
    $ps = new OssnPointSetting();
    return $ps->searchPointSetting(array(
        'keyword' => false,
        'limit' => false
    ));
}

function convert_unixtime($ts, $format = false){
    $format = !$format ? 'Y-m-d': $format;
    if($ts && $format){
        return date($format, $ts);
    }
    return false;
}


function ossn_get_point_log($params){
    $log = new OssnPointLog();
    return $log->getPointLogByParams($params);
}

function ossn_update_balance($new_balance){
    //$user = new OssnUser();
    //return $user->setBalance($new_balance);
    $w = new OssnWallet();
    return $w->setDakBalance($new_balance);
}
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

$loggedin = ossn_loggedin_user();
$ps['name'] = input('name');
$ps['code'] = strtolower(input('code'));
$ps['value'] = input('value');
$ps['status'] = input('status');
$statusArr = array(
    '0' => 'Disable',
    '1' => 'Enable'
);


if (!empty($ps)) {
    foreach ($ps as $field => $value) {
        if (strlen($value) == 0) {
            ossn_trigger_message(ossn_print('fields:require'), 'error');
            redirect(REF);
        }
    }
}

if (!in_array($ps['status'], array_keys($statusArr))) {
    ossn_trigger_message(ossn_print('point:create:error:admin'), 'error');
    redirect(REF);
}

if(!$loggedin->guid && $loggedin->type != 'admin'){
    ossn_trigger_message(ossn_print('point:create:error:admin'), 'error');
    redirect(REF);
}



$add = new OssnPointSetting();
$add->name = $ps['name'];
$add->code = $ps['code'];
$add->value = $ps['value'];
$add->added_by = $loggedin->guid;
$add->status = $ps['status'];

if($add->isExist()){
    ossn_trigger_message(ossn_print('ossn:point:name:inuse'), 'error');
    redirect(REF);
}

if ($add->addPointSetting()) {
    ossn_trigger_message(ossn_print('point:created'), 'success');
    redirect(REF);
} else {
    ossn_trigger_message(ossn_print('point:create:error:admin'), 'error');
    redirect(REF);
}

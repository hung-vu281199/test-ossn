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
$entity = ossn_point_setting_by_guid(input('guid'));
if(!$entity){
	redirect(REF);
}

$ps['name'] = input('name');
$ps['code'] = strtolower(input('code'));
$ps['value'] = input('value');
$ps['status'] = input('status');



if(!$loggedin->guid && $loggedin->type != 'admin'){
    ossn_trigger_message(ossn_print('point:create:error:admin'), 'error');
    redirect(REF);
}
if (!empty($ps)) {
    foreach ($ps as $field => $value) {
        if (empty($value)) {
            ossn_trigger_message(ossn_print('fields:require'), 'error');
            redirect(REF);
        }
    }
}

$OssnDatabase = new OssnDatabase;
$params['table'] = 'ossn_point_setting';
$params['wheres'] = array("guid='{$entity->guid}'");

$params['names'] = array(
    'code',
    'name',
    'value',
    'added_by',
    'status',
    'time_updated'
);
$params['values'] = array(
    $ps['code'],
    $ps['name'],
    $ps['value'],
    $loggedin->guid,
    $ps['status'],
    time()
);


//save
if ($OssnDatabase->update($params)) {
    ossn_trigger_message(ossn_print('point:updated'), 'success');
    redirect(REF);
} 

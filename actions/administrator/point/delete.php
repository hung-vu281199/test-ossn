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

$guid = input('guid');
$ps = ossn_point_setting_by_guid($guid);
if($ps){
	if($ps->deletePointSetting()){
		ossn_trigger_message(ossn_print('admin:point:deleted'), 'success');
	} else {
		ossn_trigger_message(ossn_print('admin:point:delete:error'), 'error');
	}
}
redirect(REF);
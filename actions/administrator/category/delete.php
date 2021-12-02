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
$category = ossn_category_by_guid($guid);
if($category){
	if($category->deleteCategory()){
		ossn_trigger_message(ossn_print('admin:category:deleted'), 'success');
	} else {
		ossn_trigger_message(ossn_print('admin:category:delete:error'), 'error');
	}
}
redirect(REF);
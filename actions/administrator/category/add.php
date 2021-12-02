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

$category['name'] = input('name');
$category['enable'] = input('enable');
$statusArr = array(
    '0' => 'Disable',
    '1' => 'Enable'
);


if (!empty($category)) {
    foreach ($category as $field => $value) {
        if (strlen($value) == 0) {
            ossn_trigger_message(ossn_print('fields:require'), 'error');
            redirect(REF);
        }
    }
}


if (!in_array($add['enable'], array_keys($statusArr))) {
    ossn_trigger_message(ossn_print('category:create:error:admin'), 'error');
    redirect(REF);
}



$add = new OssnCategory();
$add->name = $category['name'];
$add->slug = $add->makeSlug($category['name']);
$add->enable = $category['enable'];

if($add->isExistName()){
    ossn_trigger_message(ossn_print('ossn:category:name:inuse'), 'error');
    redirect(REF);
}

if ($add->addCategory()) {
    ossn_trigger_message(ossn_print('category:created'), 'success');
    redirect(REF);
} else {
    ossn_trigger_message(ossn_print('category:create:error:admin'), 'error');
    redirect(REF);
}

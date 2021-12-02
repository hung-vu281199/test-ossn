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
$entity = ossn_category_by_guid(input('guid'));
if(!$entity){
	redirect(REF);
}

$category['name'] = input('name');
$category['enable'] = input('enable');
$category['guid'] = input('guid');

if (!empty($user)) {
    foreach ($user as $field => $value) {
        if (empty($value)) {
            ossn_trigger_message(ossn_print('fields:require'), 'error');
            redirect(REF);
        }
    }
}


$OssnCategory = new OssnCategory();
$OssnCategory->name = $category['name'];
$OssnCategory->slug = $OssnCategory->makeSlug($category['name']);
$OssnCategory->enable = $category['enable'];

$OssnDatabase = new OssnDatabase;
$params['table'] = 'ossn_categories';
$params['wheres'] = array("guid='{$entity->guid}'");

$params['names'] = array(
    'name',
    'slug',
    'enable',
);
$category['slug'] = $OssnCategory->makeSlug($category['name']);
$params['values'] = array(
    $category['name'],
    $category['slug'],
    $category['enable']
);


//save
if ($OssnDatabase->update($params)) {
    ossn_trigger_message(ossn_print('category:updated'), 'success');
    redirect(REF);
} 

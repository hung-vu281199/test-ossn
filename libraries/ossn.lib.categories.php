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
function ossn_category(){
    $category = new OssnCategory;
    return $category;
}


/**
 * Get all categories
 *
 *
 *
 * @return object
 */
function ossn_category_list(){

    $category = new OssnCategory;
    $list = $category->searchCategories(array(
        'keyword' => false,
        'wheres' => 'c.enable = 1'
    ));
    return $list;

}

/**
 * Get a user by user id
 *
 * @param $guid 'guid' of user
 *
 * @return object
 */
function ossn_category_by_guid($guid)
{
    $category = new OssnCategory;
    $category->guid = $guid;
    return $category->getCategory();
}

/**
 * Ossn Add Category & Wall Post Object
 *
 * @param integer $category_id Relation guid
 * @param integer $object_id Relation guid
 *
 * @return boolean
 */
function ossn_add_relation_category_object($category_id, $object_id)
{
    if (!empty($category_id) && !empty($object_id)) {
        $add = new OssnDatabase;
        $params['into'] = 'ossn_object_category';
        $params['names'] = array(
            'category_id',
            'object_id'
        );
        $params['values'] = array(
            $category_id,
            $object_id,
        );


        $params_exits['from'] = 'ossn_object_category';
        $params_exits['wheres']   = array();
        $params_exits['wheres'][] = "object_id='{$object_id}' AND category_id='{$category_id}'";
        $isExits = $add->select($params_exits);
        if (!$isExits) {
            if ($add->insert($params)) {
                ossn_trigger_callback('category_object', 'add', array(
                    'object_id' => $object_id,
                    'category_id' => $category_id

                ));
            }
            return true;
        }
    }
    return false;
}



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
class OssnCategory extends OssnEntities
{


    const ENABLE = 1;
    const DISABLE = 0;

    /**
     * Initialize the objects.
     *
     * @return void
     */
    public function initAttributes()
    {
        $this->OssnDatabase = new OssnDatabase;
        $this->OssnAnnotation = new OssnAnnotation;
        $this->data = new stdClass;
    }

    /**
     * Add user to system.
     *
     * @return boolean
     */
    public function addCategory()
    {
        self::initAttributes();
        if (empty($this->enable)) {
            $this->enable = self::DISABLE;
        }
        $category = $this->getCategory();
        if (empty($category->name)) {
            $this->slug = $this->makeSlug($this->name);
            $params['into'] = 'ossn_categories';
            $params['names'] = array(
                'name',
                'slug',
                'enable',
                'time_created'
            );
            $params['values'] = array(
                $this->name,
                $this->slug,
                $this->enable,
                time()
            );
            $create = ossn_call_hook('category', 'create', array(
                'params' => $params,
                'instance' => $this
            ), true);
            if ($create) {
                if ($this->insert($params)) {
                    $guid = $this->getLastEntry();
                    ossn_trigger_callback('category', 'created', array(
                        'guid' => $guid
                    ));
                    return $guid;
                }
            }
        }
        return false;
    }


    /**
     * Generate category slug
     */
    public function makeSlug($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }


    /**
     * Get user with its entities.
     *
     * @return object
     */
    public function getCategory()
    {
        if (!empty($this->guid)) {
            $params['from'] = 'ossn_categories';
            $params['wheres'] = array(
                "guid='{$this->guid}'"
            );
            $category = $this->select($params);
        }
        if (!$category) {
            return false;
        }
        $data = $category;
        $metadata = arrayObject($data, get_class($this));
        $metadata->data = new stdClass;
        return ossn_call_hook('category', 'get', false, $metadata);
    }


    /**
     * Search users using a keyword or entities_pairs
     *
     * @param array $params A valid options in format:
     *      'keyword'        => A keyword to search users
     *    'entities_pairs'  => A entities pairs options, must be array
     *    'limit'            => Result limit default, Default is 10 values
     *    'count'            => True if you wanted to count search items.
     *      'order_by'        => To show result in sepcific order. Default is Assending
     *
     * reutrn array|false;
     *
     */
    public function searchCategories(array $params = array())
    {
        if (empty($params)) {
            return false;
        }
        //prepare default attributes
        $default = array(
            'keyword' => false,
            'order_by' => false,
            'distinct' => false,
            'offset' => input('offset', '', 1),
            'page_limit' => ossn_call_hook('pagination', 'page_limit', false, 10), //call hook for page limit
            'count' => false,
            'limit' => false,
            'entities_pairs' => false
        );

        $options = array_merge($default, $params);
        $wheres = array();
        $params = array();
        $wheres_paris = array();
        //validate offset values
        if ($options['limit'] !== false && $options['limit'] != 0 && $options['page_limit'] != 0) {
            $offset_vals = ceil($options['limit'] / $options['page_limit']);
            $offset_vals = abs($offset_vals);
            $offset_vals = range(1, $offset_vals);
            if (!in_array($options['offset'], $offset_vals)) {
                return false;
            }
        }
        //get only required result, don't bust your server memory
        $getlimit = $this->generateLimit($options['limit'], $options['page_limit'], $options['offset']);
        if ($getlimit) {
            $options['limit'] = $getlimit;
        }
        if (!empty($options['keyword'])) {
            $wheres[] = "c.name LIKE '%{$options['keyword']}%')";
        }
        $wheres[] = "c.time_created IS NOT NULL";
        if (isset($options['wheres']) && !empty($options['wheres'])) {
            if (!is_array($options['wheres'])) {
                $wheres[] = $options['wheres'];
            } else {
                foreach ($options['wheres'] as $witem) {
                    $wheres[] = $witem;
                }
            }

        }
        $distinct = '';
        if ($options['distinct'] === true) {
            $distinct = "DISTINCT ";
        }
        $params['from'] = 'ossn_categories as c';
        $params['params'] = array(
            "{$distinct} c.guid",
            'c.*'
        );
        $params['order_by'] = $options['order_by'];
        $params['limit'] = $options['limit'];

        if (!$options['order_by']) {
            $params['order_by'] = "c.guid ASC";
        }
        if (isset($options['group_by']) && !empty($options['group_by'])) {
            $params['group_by'] = $options['group_by'];
        }
        //override params
        if (isset($options['params']) && !empty($options['params'])) {
            $params['params'] = $options['params'];
        }
        $params['wheres'] = array(
            $this->constructWheres($wheres)
        );
        if ($options['count'] === true) {
            unset($params['params']);
            unset($params['limit']);
            $count = array();
            $count['params'] = array(
                "count({$distinct}c.guid) as total"
            );
            $count = array_merge($params, $count);
            return $this->select($count)->total;
        }
        $categories = $this->select($params, true);
        if ($categories) {
            foreach ($categories as $category) {
                $result[] = ossn_category_by_guid($category->guid);
            }
            return $result;
        }
        return false;
    }


    /**
     * Delete category from system
     *
     * @return boolean
     */
    public function deleteCategory()
    {
        self::initAttributes();
        if (!empty($this->guid) && !empty($this->name)) {
            $params['from'] = 'ossn_categories';
            $params['wheres'] = array(
                "guid='{$this->guid}'"
            );
            if ($this->delete($params) && $this->deleteCategory($this->guid)) {
                $vars['entity'] = $this;
                ossn_trigger_callback('category', 'delete', $vars);
                return true;
            }
        }
        return false;
    }

    /**
     * Delete object category
     *
     * @return boolean
     */
    public function deleteObject($category_id) {
        $this->statement("DELETE FROM ossn_object_category WHERE category_id='{$category_id}'");
        if($this->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Get user with its entities.
     *
     * @return object
     */
    public function getCategoryBySlug()
    {
        if (!empty($this->slug)) {
            $params['from'] = 'ossn_categories';
            $params['wheres'] = array(
                "slug='{$this->slug}'"
            );
            $category = $this->select($params);
        }
        if (!$category) {
            return false;
        }
        $data = $category;
        $metadata = arrayObject($data, get_class($this));
        $metadata->data = new stdClass;
        return ossn_call_hook('category', 'get', false, $metadata);
    }


    /**
     * Check if slug is exist in categories database or not.
     *
     * @return boolean
     */
    public function isExistName()
    {
        $category = $this->getCategoryBySlug();
        if (!empty($category->guid) && strtolower($this->slug) == strtolower($category->slug)) {
            return true;
        }
        return false;
    }


} //CLASS

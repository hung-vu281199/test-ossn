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
class OssnPointSetting extends OssnDatabase
{


    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    const MAX_POINT_TODAY = 100;

    /**
     * Initialize the objects.
     *
     * @return void
     */
    public function initAttributes()
    {
        $this->OssnDatabase = new OssnDatabase;
        $this->data = new stdClass;
    }

    /**
     * Add setting point
     *
     * @return boolean
     */
    public function addPointSetting()
    {
        self::initAttributes();
        if (empty($this->status)) {
            $this->status = self::STATUS_DISABLE;
        }
        $pointSetting = $this->getPointSetting();
        if (empty($pointSetting->name)) {
            $params['into'] = 'ossn_point_setting';
            $params['names'] = array(
                'code',
                'name',
                'value',
                'added_by',
                'status',
                'time_created'
            );
            $params['values'] = array(
                $this->code,
                $this->name,
                $this->value,
                $this->added_by,
                $this->status,
                time()
            );
            $create = ossn_call_hook('ossn_point_setting', 'create', array(
                'params' => $params,
                'instance' => $this
            ), true);
            if ($create) {
                if ($this->insert($params)) {
                    $guid = $this->getLastEntry();
                    ossn_trigger_callback('ossn_point_setting', 'created', array(
                        'guid' => $guid
                    ));
                    return $guid;
                }
            }
        }
        return false;
    }


    /**
     * Get user with its entities.
     *
     * @return object
     */
    public function getPointSetting()
    {
        if (!empty($this->guid)) {
            $params['from'] = 'ossn_point_setting';
            $params['wheres'] = array(
                "guid='{$this->guid}'"
            );
            if(isset($this->code)){
                $params['wheres'] = array(
                    "code='{$this->code}'"
                );
            }
            $ps = $this->select($params);
        }
        if (!$ps) {
            return false;
        }
        $data = $ps;
        $metadata = arrayObject($data, get_class($this));
        $metadata->data = new stdClass;
        return ossn_call_hook('ossn_point_setting', 'get', false, $metadata);
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
    public function searchPointSetting(array $params = array())
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
            $wheres[] = "c.name LIKE '%{$options['keyword']}%'";
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
        $params['from'] = 'ossn_point_setting as c';
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
        $pss = $this->select($params, true);
        if ($pss) {
            foreach ($pss as $ps) {
                $result[] = ossn_point_setting_by_guid($ps->guid);
            }
            return $result;
        }
        return false;
    }


    /**
     * Delete point setting from system
     *
     * @return boolean
     */
    public function deletePointSetting()
    {
        self::initAttributes();
        if (!empty($this->guid) && !empty($this->name)) {
            $params['from'] = 'ossn_point_setting';
            $params['wheres'] = array(
                "guid='{$this->guid}'"
            );
            if ($this->delete($params)) {
                $vars['entity'] = $this;
                ossn_trigger_callback('ossn_point_setting', 'delete', $vars);
                return true;
            }
        }
        return false;
    }

    /**
     * Check if slug is exist in categories database or not.
     *
     * @return boolean
     */
    public function isExist()
    {
        $ps = $this->getPointSetting();
        if (!empty($ps->guid) && strtolower($this->code) == strtolower($ps->code)) {
            return true;
        }
        return false;
    }


    public function getPointSettingByCode($code){
        if (!empty($code)) {
            $params['from'] = 'ossn_point_setting';
            $params['wheres'] = array(
                "code='{$code}'"
            );
            $ps = $this->select($params);
        }
        if (!$ps) {
            return false;
        }
        $data = $ps;
        $metadata = arrayObject($data, get_class($this));
        $metadata->data = new stdClass;
        return ossn_call_hook('ossn_point_setting', 'get', false, $metadata);
    }


} //CLASS

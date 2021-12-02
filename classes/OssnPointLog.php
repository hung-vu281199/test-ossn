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
class OssnPointLog extends OssnDatabase
{

    const CHANGE_ADD = 1;
    const CHANGE_SUB = 0;

    const SOURCE_SOCIAL = 1;


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
    public function addPointLog()
    {
        self::initAttributes();
        $params['into'] = 'ossn_point_log';
        $params['names'] = array(
            'user_id',
            'point_setting_id',
            'value',
            'before_balance',
            'after_balance',
            'change_type',
            'source',
            'time_created'
        );
        $params['values'] = array(
            $this->user_id,
            $this->point_setting_id,
            $this->value,
            $this->before_balance,
            $this->after_balance,
            $this->change_type,
            $this->source,
            $this->time_created,
        );
        $create = ossn_call_hook('ossn_point_log', 'create', array(
            'params' => $params,
            'instance' => $this
        ), true);
        if ($create) {
            if ($this->insert($params)) {
                $guid = $this->getLastEntry();
                ossn_trigger_callback('ossn_point_log', 'created', array(
                    'guid' => $guid
                ));
                return $guid;
            }
        }
        return false;
    }


    /**
     * Get user with its entities.
     *
     * @return object
     */
    public function getPointLog()
    {
        if (!empty($this->guid)) {
            $params['from'] = 'ossn_point_log';
            $params['wheres'] = array(
                "guid='{$this->guid}'"
            );
            $pl = $this->select($params);
        }
        if (!$pl) {
            return false;
        }
        $data = $pl;
        $metadata = arrayObject($data, get_class($this));
        $metadata->data = new stdClass;
        return ossn_call_hook('ossn_point_log', 'get', false, $metadata);
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
    public function searchPointLog(array $params = array())
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
            $wheres[] = "s.name LIKE '%{$options['keyword']}%'";
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
        $params['from'] = 'ossn_point_log as c';
        $params['joins'][] = "LEFT JOIN ossn_users as u ON u.guid = c.user_id";
        $params['joins'][] = "LEFT JOIN ossn_point_setting as s ON s.guid = c.point_setting_id";

        $params['params'] = array(
            "{$distinct} c.guid",
            'c.*',
            'u.*',
            's.*',
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


    public function getTodayPoint($guid){
        $params = array(
            'from' => 'ossn_point_log',
            'params' => array(
                'SUM(value) as total'
            ),
            'wheres' => array(
                "FROM_UNIXTIME(time_created, '%Y-%m-%d') = CURDATE() AND guid = {$guid} AND change_type = 1"
            )
        );
        $result = $this->select($params);
        if($result->total > 0){
            return $result->total;
        }
        return 0;
    }

    /**
     * Get user with its entities.
     *
     * @return object
     */
    public function getPointLogByParams($params)
    {
        $default['from'] = 'ossn_point_log';
        $options = array_merge($default, $params);
        $pl = $this->select($options);
        if (!$pl) {
            return false;
        }
        $data = $pl;
        $metadata = arrayObject($data, get_class($this));
        $metadata->data = new stdClass;
        return ossn_call_hook('ossn_point_log', 'get', false, $metadata);
    }




} //CLASS

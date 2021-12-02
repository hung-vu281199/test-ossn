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
echo ossn_view_form('admin/categories/list_search', array(
    'action' => ossn_site_url('administrator/categories'),
    'class' => 'ossn-admin-form',
));
echo ossn_view_form('admin/categories/list', array(
    'action' => ossn_site_url('action/admin/delete/category'),
    'class' => 'ossn-admin-form',
));
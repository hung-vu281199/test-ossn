<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
if(!isset($params['user'])) {
		$params['user'] = '';
}

echo '<div class="ossn-wall-container">';
echo ossn_view_form('home/container', array(
		'action' => ossn_site_url() . 'action/wall/post/a',
		'component' => 'OssnWall',
		'id' => 'ossn-wall-form',
		'enctype' => 'multipart/form-data',
		'params' => array(
				'user' => $params['user'],
                'categories' => ossn_category_list()
		)
), false);

echo '</div>';
if(input('category_id')){
    echo '<hr>';
}
echo '<div class="user-activity">';
echo ossn_plugin_view('wall/siteactivity');
echo '</div>';

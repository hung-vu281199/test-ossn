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
 ossn_trigger_callback('object', 'load:comment:share:like', $params);
 ?>
<div class="comments-likes ossn-photos-comments">
	<div class="menu-likes-comments-share">
            	<?php echo ossn_view_menu('object_extra');?>
	</div>     
 	<?php
    if (ossn_is_hook('post', 'likes:object')) {
        $object['params'] = $params;
        $object['object_guid'] = $params['object']->guid;
        echo ossn_call_hook('post', 'likes:object', $object);
    }
    ?>
    <div class="comments-list">
    <?php
    if (ossn_is_hook('post', 'comments:object')) {
        $object['params'] = $params;
        $object['object_guid'] =  $params['object']->guid;
        echo ossn_call_hook('post', 'comments:object', $object);
    }
    ?>
    </div>
</div>

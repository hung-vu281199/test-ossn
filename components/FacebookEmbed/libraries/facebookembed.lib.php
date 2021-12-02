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

function com_facebook_embed_create_embed_object($url, $guid) {
	if (!isset($url)) {
		return false;
	}
	if (strpos($url, 'facebook.com') != false) {
		return com_facebook_embed_facebook_handler($url, $guid);
	} else {
		return false;
	}
}




function com_facebook_embed_facebook_handler($url, $guid) {
    $regex = '/(?:(?:http|https):\/\/(?:www|m|mbasic|business)\.(?:facebook|fb)\.com\/)(?:photo(?:\.php|s)|permalink\.php|video\.php|media|watch\/|questions|notes|[^\/]+\/(?:activity|posts|videos|photos))[\/?](?:fbid=|story_fbid=|id=|b=|v=|)([0-9]+|[^\/]+\/[\d]+)/';
    //preg_match($regex, $url, $matches);
    if (strpos($url, 'videos') != false) {
        return com_facebook_embed_add_object('video', $url, $guid);
    } elseif(strpos($url, 'photo') != false) {
        return com_facebook_embed_add_object('photos', $url, $guid);
    } elseif(strpos($url, 'posts') != false) {
        return com_facebook_embed_add_object('posts', $url, $guid);
    } else {
        return;
    }


}


function com_facebook_embed_add_object($type, $url, $guid) {
    $html = '';
	switch ($type) {
        case 'video':
            $html .= '<div class="fb-video" data-href="'.$url.'" data-width="auto" data-show-text="false"></div>';
          break;
        case 'photo':
            $html .= '<div class="fb-photo" data-href="'.$url.'" data-width="auto" data-show-text="false"></div>';
            break;
        case 'posts':
            $html .= '<div class="fb-post" data-href="'.$url.'" data-width="auto"></div>';
            break;
    }
    return $html;
}

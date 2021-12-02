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
 
function com_soundcloud_embed_create_embed_object($url, $guid) {
	if (!isset($url)) {
		return false;
	}
	if (strpos($url, 'soundcloud.com') != false) {
		return com_soundcloud_embed_soundcloud_handler($url, $guid);
	} else {
		return false;
	}
}

function com_soundcloud_embed_soundcloud_handler($url, $guid) {
	preg_match('/(https:\/\/soundcloud\.com\/.*\/)([0-9a-z]*)/', $url, $matches);
	if($matches) {
		if(strlen($matches[2])) {
			return com_soundcloud_embed_add_object('soundcloud-track', $url, $guid);
		} else {
			return com_soundcloud_embed_add_object('soundcloud-artist', $url, $guid);
		}
	}
}

function com_soundcloud_embed_add_object($type, $url, $guid) {
	switch ($type) {
		case 'soundcloud-track':
			$soundcloud_info = 'https://soundcloud.com/oembed?url=' . urlencode($url) . '&format=json';
			$track_details = @file_get_contents($soundcloud_info);
			if(!empty($track_details)){
				$content = json_decode($track_details);
				$matches = array();
				preg_match('/tracks%2F(.*?)&/s', $content->{'html'}, $matches);
				$track_id = $matches[1];
				$videodiv =  "<span id=\"{$guid}\" class=\"ossn_embed_video embed-responsive com-soundcloudembed-track\">";
				$videodiv .= "<iframe width=\"100%\" height=\"166\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/{$track_id}&visual=false&show_artwork=true\"></iframe>";
				$videodiv .= "</span>";
			} else{
				$videodiv =  "<span id=\"{$guid}\" class=\"ossn_embed_video embed-responsive com-soundcloudembed-error\">";
				$videodiv .= "<iframe width=\"100%\" height=\"135\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?url=https://api.soundcloud.com/error&visual=false&show_artwork=true\"></iframe>";
				$videodiv .= "</span>";
			}		
			break;
		case 'soundcloud-artist':
			$soundcloud_info = 'https://soundcloud.com/oembed?url='.urlencode($url).'&format=json';
			$artist_details = @file_get_contents($soundcloud_info);
			if(!empty($artist_details)){
				$content = json_decode($artist_details);
				$matches = array();
				preg_match('/users%2F(.*?)&/s', $content->{'html'}, $matches);
				$artist_id = $matches[1];
				$videodiv =  "<span id=\"{$guid}\" class=\"ossn_embed_video embed-responsive com-soundcloudembed-artist\">";
				$videodiv .= "<iframe width=\"100%\" height=\"450\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?url=https://api.soundcloud.com/users/{$artist_id}&visual=false&show_artwork=true\"></iframe>";
				$videodiv .= "</span>";
			} else{
				$videodiv =  "<span id=\"{$guid}\" class=\"ossn_embed_video embed-responsive com-soundcloudembed-error\">";
				$videodiv .= "<iframe width=\"100%\" height=\"135\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?url=https://api.soundcloud.com/error&visual=false&show_artwork=true\"></iframe>";
				$videodiv .= "</span>";
			}		
			break;
	}
	return $videodiv; 
}

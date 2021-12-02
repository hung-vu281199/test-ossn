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
 
define('__SOUNDCLOUD_EMBED__', ossn_route()->com . 'SoundCloudEmbed/');
require_once(__SOUNDCLOUD_EMBED__ . 'libraries/soundcloudembed.lib.php');

function com_soundcloud_embed_init() {	
	$component = new OssnComponents();
	if($component->isActive('OssnEmbed')) {
		ossn_extend_view('css/ossn.default', 'css/soundcloudembed');
		ossn_add_hook('wall', 'templates:item', 'com_soundcloud_embed_wall_template_item');
		ossn_add_hook('required', 'components', 'com_soundcloud_embed_asure_requirements');
	}
}

function com_soundcloud_embed_asure_requirements($hook, $type, $return, $params) {
	$return[] = 'OssnEmbed';
	return $return;
}

function com_soundcloud_embed_wall_template_item($hook, $type, $return){
	$patterns = array(	'/(https?:\/\/soundcloud\.com\/.*\/)([0-9a-z]*)/',
						);
	$regex = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/";
	if(preg_match_all($regex, $return['text'], $matches, PREG_SET_ORDER)){

	foreach($matches as $match){
			foreach ($patterns as $pattern){
				if (preg_match($pattern, $match[2]) > 0){
					$return['text'] = str_replace($match[0], com_soundcloud_embed_create_embed_object($match[2], uniqid('soundcloud_embed_')), $return['text']);
				}				
			}
		}
	}
	return $return;
}

ossn_register_callback('ossn', 'init', 'com_soundcloud_embed_init');

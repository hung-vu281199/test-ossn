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
 
define('__FACEBOOK_EMBED__', ossn_route()->com . 'FacebookEmbed/');
require_once(__FACEBOOK_EMBED__ . 'libraries/facebookembed.lib.php');

function com_facebook_embed_init() {
	$component = new OssnComponents();
	if($component->isActive('OssnEmbed')) {

        ossn_extend_view('css/ossn.default', 'css/facebookembed');
		ossn_extend_view('js/ossn.site', 'js/facebookembed');

		ossn_add_hook('wall', 'templates:item', 'com_facebook_embed_wall_template_item');
		ossn_add_hook('required', 'components', 'com_facebook_embed_asure_requirements');
	}
}

function com_facebook_embed_asure_requirements($hook, $type, $return, $params) {
	$return[] = 'OssnEmbed';
	return $return;
}

function com_facebook_embed_wall_template_item($hook, $type, $return){
    $patterns = array(
        '/(?:(?:http|https):\/\/(?:www|m|mbasic|business)\.(?:facebook|fb)\.com\/)(?:photo(?:\.php|s)|permalink\.php|video\.php|media|watch\/|questions|notes|[^\/]+\/(?:activity|posts|videos|photos))[\/?](?:fbid=|story_fbid=|id=|b=|v=|)([0-9]+|[^\/]+\/[\d]+)/m',
    );
    $regex = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/";
    if(preg_match_all($regex, $return['text'], $matches, PREG_SET_ORDER)){
	    foreach($matches as $match){
			foreach ($patterns as $pattern){
				if (preg_match($pattern, $match[2]) > 0){
					$return['text'] = str_replace($match[0], com_facebook_embed_create_embed_object($match[2], uniqid('facebook_embed_')), $return['text']);
				}
			}
		}
	}
	return $return;
}
ossn_register_callback('ossn', 'init', 'com_facebook_embed_init');

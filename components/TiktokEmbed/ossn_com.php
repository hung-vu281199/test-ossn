<?php

 
define('__TIKTOK_EMBED__', ossn_route()->com . 'TiktokEmbed/');
require_once(__TIKTOK_EMBED__ . 'libraries/tiktokembed.lib.php');

function com_tiktok_embed_init() {
	$component = new OssnComponents();
	if($component->isActive('OssnEmbed')) {

        ossn_extend_view('css/ossn.default', 'css/embed');
		ossn_extend_view('js/ossn.site', 'js/embed');

		ossn_add_hook('wall', 'templates:item', 'com_tiktok_embed_wall_template_item');
		ossn_add_hook('required', 'components', 'com_tiktok_embed_asure_requirements');
	}
}

function com_tiktok_embed_asure_requirements($hook, $type, $return, $params) {
	$return[] = 'OssnEmbed';
	return $return;
}

function com_tiktok_embed_wall_template_item($hook, $type, $return){
    //check shortend url
    $patterns = array(
        '/(?:(?:http|https):\/\/(?:www|vt)\.(?:tiktok)\.com\/)/m',
    );
    $regex = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/";
    if(preg_match_all($regex, $return['text'], $matches, PREG_SET_ORDER)){
	    foreach($matches as $match){
			foreach ($patterns as $pattern){
				if (preg_match($pattern, $match[2]) > 0){
					$return['text'] = str_replace($match[0], com_tiktok_embed_create_embed_object($match[2], uniqid('tiktok_embed_')), $return['text']);
				}
			}
		}
	}
	return $return;
}


ossn_register_callback('ossn', 'init', 'com_tiktok_embed_init');

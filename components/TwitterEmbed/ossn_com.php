<?php

 
define('__TWITTER_EMBED__', ossn_route()->com . 'TwitterEmbed/');
require_once(__TWITTER_EMBED__ . 'libraries/twitterembed.lib.php');

function com_twitter_embed_init() {
	$component = new OssnComponents();
	if($component->isActive('OssnEmbed')) {
		ossn_add_hook('wall', 'templates:item', 'com_twitter_embed_wall_template_item');
		ossn_add_hook('required', 'components', 'com_twitter_embed_asure_requirements');
	}
}

function com_twitter_embed_asure_requirements($hook, $type, $return, $params) {
	$return[] = 'OssnEmbed';
	return $return;
}

function com_twitter_embed_wall_template_item($hook, $type, $return){
    //check shortend url
    $patterns = array(
        '/https?:\/\/twitter\.com\/.*?\/status\/(\d+)(.*)?/',
    );
    $regex = "/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/";
    if(preg_match_all($regex, $return['text'], $matches, PREG_SET_ORDER)){

	    foreach($matches as $match){


			foreach ($patterns as $pattern){
				if (preg_match($pattern, $match[2]) > 0){
					$return['text'] = str_replace($match[0], com_twitter_embed_create_embed_object($match[2], uniqid('twitter_embed_')), $return['text']);
				}
			}
		}
	}
	return $return;
}


ossn_register_callback('ossn', 'init', 'com_twitter_embed_init');

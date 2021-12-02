<?php


function com_twitter_embed_create_embed_object($url, $guid) {
	if (!isset($url)) {
		return false;
	}

    $domain = parse_url($url, PHP_URL_HOST);
	if($domain != 'twitter.com'){
        return false;
    }
    return com_twitter_embed_handler($url, $guid);
}




function com_twitter_embed_handler($url, $guid) {
    $embeb = twitter_embeb_request($url);
    if(is_object($embeb)){
        return $embeb->html;
    } else {
        return $url;
    }
}



function twitter_embeb_request($uri = ''){
    $url = 'https://publish.twitter.com/oembed?url=' . $uri;
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36',
        ],
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);
}
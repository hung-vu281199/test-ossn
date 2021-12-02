<?php


function com_tiktok_embed_create_embed_object($url, $guid) {
	if (!isset($url)) {
		return false;
	}
	if(isShortLink($url)){
	    $url = getFullUrl($url);
    }
    return com_tiktok_embed_handler($url, $guid);
}




function com_tiktok_embed_handler($url, $guid) {
    $embeb = embeb_request($url);
    if(is_object($embeb)){
        return $embeb->html;
    } else {
        return $url;
    }
}




function isShortLink($uri){
    $part = parse_url($uri);
    if(isset($part['host']) && $part['host'] == 'vt.tiktok.com'){
        return true;
    }
    return false;
    //$pattern = '/vm./';
    //return preg_match($pattern, $uri, $e, PREG_OFFSET_CAPTURE);
}


function getFullUrl($url){
    $header = get_headers($url, 1);
    $location = count($header['Location']) == 1 ? $header['Location'] : $header['Location'][0];
    if($location){
        $share_url = parse_url($location, PHP_URL_PATH);
        $part = explode("/", $share_url);
        if(isset($part[4])){
            return 'https://m.tiktok.com/v/'.$part[4].'.html';
        } else {
            return $url;
        }

    }
}

function embeb_request($uri = ''){
    $url = 'https://www.tiktok.com/oembed?url=' . $uri;
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
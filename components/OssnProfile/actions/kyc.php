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
global $Ossn;
$entity = ossn_user_by_username(input('username'));
if(!$entity){
		redirect(REF);
}
$user['firstname'] = input('firstname');
$user['lastname']  = input('lastname');
$user['birthday']  = input('birthday');
$user['id_type'] = 1;
$user['id_number'] = input('id_number');

//$user['id_front_image'] = file('id_front_image');

$current_user = ossn_loggedin_user();
if($current_user->kyc_level == 2){
    $success  = ossn_print('user:updated');
    ossn_trigger_message($success, 'success');
    redirect(REF);
}

$kyc_level = null;
if(isset($user['birthday']) && isset($user['id_number'])){
    $kyc_level = 1;
}
//[E] make user email lowercase when adding to db #186






if(isset($_FILES['id_front_image'])){
    $filesize = $_FILES['id_front_image']['size'];
    $filename = $_FILES['id_front_image']['name'];
    $filedata = $_FILES['id_front_image']['tmp_name'];

    if ($filedata != '') {

        $mime = mime_content_type($filedata);
        $info = pathinfo($filedata);
        $name = $info['basename'];
        $curl_file = new CURLFile($filedata, $mime, $name);
        $postfields = array(
            "image" => $curl_file
        );

        $url = $Ossn->eyeq_api_base_url . '/api/ocr/single';
        $headers = array(
            "Content-Type:multipart/form-data",
            "Authorization:Bearer ". $Ossn->eyeq_api_bearer_key
        );
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_INFILESIZE => $filesize,
            CURLOPT_RETURNTRANSFER => true
        ); // cURL options
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $response = new CurlResponse($result);
        if(!curl_errno($ch)) {
            $info = curl_getinfo($ch);
            $data = json_decode($response->body);
            if ($info['http_code'] == 200 && $data->code == '0000') {
                $cmnd = $data->data;
                if($kyc_level == 1 && $cmnd->card_type == 'cmnd_front' && $cmnd->id == $user['id_number'] && date('Y-m-d', strtotime($cmnd->birthday)) == $user['birthday']){
                    $kyc_level = 2;
                }

                $file    = new OssnFile;
                $file->owner_guid = $current_user->guid;
                $file->type       = 'user';
                $file->subtype    = 'profile:photo';
                $file->setFile('id_front_image');
                $file->setPath('profile/kyc/');
                $file->setExtension(array(
                    'jpg',
                    'png',
                    'jpeg',
                    'gif'
                ));
                $file->addFile();


            } else {
                ossn_trigger_message($data->message, 'error');
                redirect(REF);
            }
        }

        curl_close($ch);
    }
}






$OssnUser           = new OssnUser();
$OssnDatabase = new OssnDatabase();
$user_get     = ossn_user_by_username(input('username'));
if($user_get->guid !== ossn_loggedin_user()->guid){
		redirect('home');
}

$params['table']  = 'ossn_users';
$params['wheres'] = array(
		"guid='{$user_get->guid}'",
);

$params['names'] = array(
		'first_name',
		'last_name',
		'birthday',
        'id_type',
        'id_number',
        'kyc_level'

);
$params['values'] = array(
		$user['firstname'],
		$user['lastname'],
		$user['birthday'],
        $user['id_type'],
        $user['id_number'],
        $kyc_level
);

$success  = ossn_print('user:updated');
//save
if($OssnDatabase->update($params)){


		ossn_trigger_message($success, 'success');
		redirect(REF);
}

<?php
$wallet = new OssnWallet;
$password = trim(input('password'));
$symbol = input('symbol');
$user_id = input('user_id');
$info = $wallet->apiCreateWallet($symbol, $password);
if($info){
    $params = array(
        'info' => $info,
        'password' => $password
    );
    echo ossn_plugin_view('wallet/pages/view/dak', $params);
} else {
    echo 0;
}
exit;

<?php
$w = new OssnWallet;
$swap['amount'] = trim(input('amount'));
$swap['symbol'] = input('symbol');
$swap['user_id'] = ossn_loggedin_user()->guid;
$wallet = $w->getWalletBySymbol($swap['symbol'], $swap['user_id']);
if(!$wallet){
    redirect(REF);
}
$fields = array(
    'required' => array(
        'amount'
    )
);
foreach ($fields['required'] as $field){
    $swap[$field] = input($field);
}

if(!empty($swap)){
    foreach ($swap as $field => $value){
        if(empty($value)){
            ossn_trigger_message(ossn_print('fields:require'), 'error');
            redirect(REF);
        }
    }
}
if($swap['amount'] <= 0){
    ossn_trigger_message(ossn_print('Invalid amount'), 'error');
    redirect(REF);
}

if($wallet->balance < $swap['amount']){
    ossn_trigger_message(ossn_print('Not enough balance'), 'error');
    redirect(REF);
}

$to_user_or_email = trim(input('username'));
if(filter_var($to_user_or_email, FILTER_VALIDATE_EMAIL)) {
    $to_user = ossn_user_by_email($to_user_or_email);
} else {
    $to_user = ossn_user_by_username($to_user_or_email);
}

if(!$to_user){
    ossn_trigger_message(ossn_print('User not found'), 'error');
    redirect(REF);
} else {
    if($to_user->guid == ossn_loggedin_user()->guid){
        ossn_trigger_message(ossn_print('Can not send to yourself'), 'error');
        redirect(REF);
    }
}




if($w->Send($swap['amount'], $swap['symbol'], $to_user)){
    $success  = ossn_print('Send success');
    ossn_trigger_message($success, 'success');
    redirect(REF);
} else {
    ossn_trigger_message(ossn_print('Something wrong, please try again'), 'error');
    redirect(REF);
}






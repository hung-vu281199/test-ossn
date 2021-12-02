<?php
$w = new OssnWallet;
$withdraw['address'] = trim(input('address'));
$withdraw['amount'] = trim(input('amount'));
$withdraw['symbol'] = input('symbol');
$withdraw['user_id'] = ossn_loggedin_user()->guid;
$wallet = $w->getWalletBySymbol($withdraw['symbol'], $withdraw['user_id']);
if(!$wallet){
    redirect(REF);
}

$fields = array(
    'required' => array(
        'address',
        'amount'
    )
);
foreach ($fields['required'] as $field){
    $withdraw[$field] = input($field);
}

if(!empty($withdraw)){
    foreach ($withdraw as $field => $value){
        if(empty($value)){
            ossn_trigger_message(ossn_print('fields:require'), 'error');
            redirect(REF);
        }
    }
}

if($wallet->balance < $withdraw['amount']){
    ossn_trigger_message(ossn_print('Not enough balance'), 'error');
    redirect(REF);
}

$do = $w->withdrawMoney($withdraw['symbol'], $withdraw['user_id'], $withdraw['amount'], $withdraw['address']);
if($do['status'] == 'success'){
    $success  = ossn_print('withdraw success');
    ossn_trigger_message($success, 'success');
    redirect(REF);
} else {
    $error  = $do['msg'];
    ossn_trigger_message($error, 'error');
    redirect(REF);
}


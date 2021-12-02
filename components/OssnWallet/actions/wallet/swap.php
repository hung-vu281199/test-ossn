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
//public function withdrawMoney($symbol, $user_id, $amount, $to_address){
//if($w->withdrawMoney($withdraw['symbol'], $withdraw['user_id'], $withdraw['amount'], $withdraw['address'])){
//    $success  = ossn_print('withdraw success');
//    ossn_trigger_message($success, 'success');
//    redirect(REF);
//}

if($w->Swap($swap['amount'], $swap['symbol'])){
    $success  = ossn_print('swap success');
    ossn_trigger_message($success, 'success');
    redirect(REF);
}






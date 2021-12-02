
<?php
echo ossn_view_form('withdraw', array(
    'action' => ossn_site_url() . 'action/wallet/withdraw',
    'component' => 'OssnWallet',
    'class' => 'wallet-form-withdraw',
    'id' => "wallet-withdraw-{$params['wallet']->symbol}",
    'params' => $params['wallet']
), false);


?>
<div class="withdraw margin-top-10">

</div>



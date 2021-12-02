<?php
echo ossn_view_form('send', array(
    'action' => ossn_site_url() . 'action/wallet/send',
    'component' => 'OssnWallet',
    'class' => 'wallet-form-swap',
    'id' => "wallet-swap-dak",
    'params' => $params['wallet']
), false);


?>
<div class="send margin-top-10">

</div>



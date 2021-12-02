<?php
echo ossn_view_form('swap', array(
    'action' => ossn_site_url() . 'action/wallet/swap',
    'component' => 'OssnWallet',
    'class' => 'wallet-form-swap',
    'id' => "wallet-swap-{$params['wallet']->symbol}",
    'params' => $params['wallet']
), false);


?>
<div class="swap margin-top-10">

</div>



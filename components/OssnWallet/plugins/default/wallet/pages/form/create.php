<script>
    Ossn.CreateWallet(<?php echo $params['user_id'];?>);
</script>
<?php
if($params['symbol'] == OssnWallet::DAK){
    echo ossn_view_form('create', array(
        'component' => 'OssnWallet',
        'class' => 'wallet-form-form',
        'id' => "wallet-create-{$params['user_id']}",
        'params' => $params
    ), false);
} else {
    redirect(REF);
}
?>
<div class="wallet-append margin-top-10">

</div>



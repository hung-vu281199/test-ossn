<script>
    Ossn.BuyNumber(<?php echo $params['user_id'];?>);
</script>
<?php
echo ossn_view_form('create', array(
    'component' => 'OssnJackpot',
    'class' => 'jackpot-form-form',
    'id' => "jackpot-create-{$params['user_id']}",
    'params' => $params
), false);

?>
<div class="margin-top-10">

</div>



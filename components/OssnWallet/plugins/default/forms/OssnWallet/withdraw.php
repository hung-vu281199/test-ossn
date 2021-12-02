<div class="form-group mb-2">
    <label for="address"><?php echo $params->symbol; ?> Address</label>
    <?php if($params->symbol == OssnWallet::DAK){?>
        <br><a target="_blank" href="<?php echo ossn_site_url('wallet/create'); ?>" class="text text-success">Create new DAK wallet</a>
    <?php } ?>
    <input type="text" id="address" name="address" class="form-control" placeholder="Withdraw Address">
</div>
<div class="form-group mb-2">
    <label for="amount"><?php echo $params->symbol; ?> Amount</label><br>
    Balance: <?php echo number_format($params->balance);?><br>
    <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount">
</div>
<div class="controls">
    <input type="hidden" name="user_id" value="<?php echo $params->user_id; ?>"/>
    <input type="hidden" name="symbol" value="<?php echo $params->symbol; ?>"/>
    <div class="ossn-loading ossn-hidden"></div>
    <input type="submit" class="btn btn-primary" value="Withdraw"/>
</div>

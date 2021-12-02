<?php if($params->symbol == OssnWallet::DAK) { ?>
    <div class="form-group mb-2">
        <label for="amount"><?php echo $params->symbol; ?> Amount</label><br>
        <?php echo $params->symbol; ?> Balance: <?php echo number_format($params->balance);?><br>
        <input type="text" name="amount" class="form-control" id="swapAmount" placeholder="Amount">
    </div>
    <div class="form-group mb-2">
        Receive: <span class="receive text-muted">0</span> USDT
    </div>
<?php } elseif($params->symbol == OssnWallet::USDT){?>
    <div class="form-group mb-2">
        <label for="amount"><?php echo $params->symbol; ?> Amount</label><br>
        Balance: <?php echo number_format($params->balance);?><br>
        <input type="text" name="amount" class="form-control" id="swapAmount" placeholder="Amount">
    </div>
    <div class="form-group mb-2">
        Receive: <span class="receive text-muted">0</span> DAK
    </div>
<?php } ?>
<div class="controls">
    <input type="hidden" name="user_id" value="<?php echo $params->user_id; ?>"/>
    <input type="hidden" name="symbol" id="swapSymbol" value="<?php echo $params->symbol; ?>"/>
    <input type="hidden" name="balance" id="swapBalance" value="<?php echo $params->balance; ?>"/>
    <div class="ossn-loading ossn-hidden"></div>
    <input type="submit" class="btn btn-primary" value="Swap"/>
</div>

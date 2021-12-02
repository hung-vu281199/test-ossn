
<div class="form-group mb-2">
    Balance: <?php echo number_format($params->balance);?> DAK<br>
    <label for="amount"><?php echo $params->symbol; ?> Amount</label><br>
    <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount">
</div>
<div class="form-group mb-2">
    <label for="amount">Username or Email</label><br>
    <input type="text" name="username" class="form-control" id="username" placeholder="Username or Email">
    <small class="user-info text"></small>
</div>
<div class="controls">
    <input type="hidden" name="user_id" value="<?php echo $params->user_id; ?>"/>
    <input type="hidden" name="symbol" id="swapSymbol" value="<?php echo $params->symbol; ?>"/>
    <input type="hidden" name="balance" id="swapBalance" value="<?php echo $params->balance; ?>"/>
    <div class="ossn-loading ossn-hidden"></div>
    <input type="submit" class="btn btn-primary" id="send"  disabled value="Send"/>
</div>

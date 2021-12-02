<div class="form-group mb-2">
    <label for="password">Wallet Password</label>
    <input type="text" name="password" class="form-control" id="password" placeholder="Password">
</div>
<div class="controls">
    <input type="hidden" name="user_id" value="<?php echo $params['user_id']; ?>"/>
    <input type="hidden" name="symbol" value="<?php echo $params['symbol']; ?>"/>
    <div class="ossn-loading ossn-hidden"></div>
    <input type="submit" class="btn btn-primary" value="Create DAK Wallet"/>
</div>

<div class="card">
    <div class="card-header">
        Deposit <?php echo strtoupper($params['info']->symbol); ?>
    </div>
    <div class="card-body">
        <h5 class="card-title">
            <div class="form-group">
                <label for="address" class="h5">Address</label>
                <input type="text" class="form-control" id="address" aria-describedby="emailHelp" value="<?php echo $params['info']->address;?>">
                <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
            </div>
            <div class="form-group margin-top-10">
                <a href="<?php echo ossn_site_url('wallet/all');?>" class="btn btn-primary ">Back</a>
            </div>
        </h5>
    </div>
</div>

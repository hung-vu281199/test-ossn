<div class="card">
    <div class="card-header">
        Wallet info
    </div>

    <div class="card-body">
        <h5 class="card-title">
            Address: <?php echo $params['info']->address;?>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">
            Password: <?php echo $params['password'];?>
        </h6>
        <h6 class="card-subtitle mb-2 text-muted">
            Private Key: <?php echo $params['info']->privateKey;?>
        </h6>
        <p class="card-text">Please save your wallet information before close this page</p>
    </div>
</div>

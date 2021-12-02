

<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-tabs" id="wallet" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dak-tab" data-bs-toggle="tab" data-bs-target="#dak" type="button" role="tab" aria-controls="dak" aria-selected="true">DAK</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="usdt-tab" data-bs-toggle="tab" data-bs-target="#usdt" type="button" role="tab" aria-controls="usdt" aria-selected="false">USDT</button>
            </li>
        </ul>
        <div class="tab-content" id="walletTabContent">
            <div class="tab-pane fade show active" id="dak" role="tabpanel" aria-labelledby="dak-tab">
                <div class="card margin-top-10" >
                    <div class="card-body">
                        <h5 class="card-title">DAK</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($params['dak']['wallet']) ? number_format($params['dak']['wallet']->balance) : 0;?> DAK</h6>
                        <p class="card-text"><?php //echo isset($params['dak']['wallet']) ? $params['dak']['wallet']->address : ''?></p>
                        <a href="<?php echo ossn_site_url('wallet/deposit/dak');?>" class="btn btn-primary">Deposit</a>
                        <a href="<?php echo ossn_site_url('wallet/withdraw/dak');?>" class="btn btn-success">Withdraw</a>
                        <a href="<?php echo ossn_site_url('wallet/swap/dak');?>" class="btn btn-info">Swap</a>
                        <a href="<?php echo ossn_site_url('wallet/send/dak');?>" class="btn btn-danger">Send</a>

                    </div>
                </div>
                <div class="car margin-top-10">
                    <ul class="nav nav-tabs" id="dakWalletLog" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dak-deposit-tab" data-bs-toggle="tab" data-bs-target="#dak-deposit" type="button" role="tab" aria-controls="dak-deposit" aria-selected="true">
                                Deposit
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="dak-withdraw-tab" data-bs-toggle="tab" data-bs-target="#dak-withdraw" type="button" role="tab" aria-controls="dak-withdraw" aria-selected="false">
                                Withdraw
                            </button>
                        </li>

                    </ul>
                    <div class="tab-content" id="dakWalletLogTabContent">
                        <div class="tab-pane fade show active" id="dak-deposit" role="tabpanel" aria-labelledby="dak-deposit-tab">
                            <!--DAK Deposit-->
                            <table class="table table-striped margin-top-10">
                                <thead>
                                <tr>
                                    <th scope="col">Deposit Info</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($params['dak']['deposit']) > 0){ ?>
                                    <?php foreach ($params['dak']['deposit'] as $log){ ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="small">
                                                    From: <?php echo $log->from_address;?>
                                                </div>
                                                <div class="small">
                                                    To: <?php echo $log->to_address;?>
                                                </div>
                                                <div class="small">
                                                    Tx Hash: <?php echo $log->tx_hash;?>
                                                </div>
                                            </th>
                                            <td><?php echo number_format($log->amount);?></td>
                                            <td>
                                                <span class="text text-<?php echo ($log->status == OssnWallet::STATUS_CONFIRMED) ? 'success' : 'primary';?>"><?php echo OssnWallet::getStatusText($log->status); ?></span>
                                            </td>
                                            <td><?php echo date('m-d-Y h:i', $log->time_created) ;?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="dak-withdraw" role="tabpanel" aria-labelledby="dak-withdraw-tab">
                            <!--DAK WITHDRAW-->
                            <table class="table table-striped margin-top-10">
                                <thead>
                                <tr>
                                    <th scope="col">Withdraw Info</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($params['dak']['withdraw']) > 0){ ?>
                                    <?php foreach ($params['dak']['withdraw'] as $log){ ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="small">
                                                    From: <?php echo $log->from_address;?>
                                                </div>
                                                <div class="small">
                                                    To: <?php echo $log->to_address;?>
                                                </div>
                                                <div class="small">
                                                    Tx Hash: <?php echo $log->tx_hash;?>
                                                </div>
                                            </th>
                                            <td><?php echo number_format($log->amount);?></td>
                                            <td>
                                                <span class="text text-<?php echo ($log->status == OssnWallet::STATUS_CONFIRMED) ? 'success' : 'primary';?>"><?php echo OssnWallet::getStatusText($log->status); ?></span>
                                            </td>
                                            <td><?php echo date('m-d-Y h:i', $log->time_created) ;?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="usdt" role="tabpanel" aria-labelledby="usdt-tab">
                <div class="card margin-top-10" >
                    <div class="card-body">
                        <h5 class="card-title">USDT</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <?php echo isset($params['usdt']['wallet']->balance) ? number_format($params['usdt']['wallet']->balance) : 0;?> USDT
                        </h6>
                        <p class="card-text"><?php //echo isset($params['usdt']['wallet']) ? $params['usdt']['wallet']->address : ''?></p>
                        <a href="<?php echo ossn_site_url('wallet/deposit/usdt');?>" class="btn btn-primary">Deposit</a>
                        <a href="<?php echo ossn_site_url('wallet/withdraw/usdt');?>" class="btn btn-success">Withdraw</a>
                        <a href="<?php echo ossn_site_url('wallet/swap/usdt');?>" class="btn btn-info">Swap</a>
                    </div>
                </div>
                <div class="car margin-top-10">
                    <ul class="nav nav-tabs" id="usdtWalletLog" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="usdt-deposit-tab" data-bs-toggle="tab" data-bs-target="#usdt-deposit" type="button" role="tab" aria-controls="usdt-deposit" aria-selected="true">
                                Deposit
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="usdt-withdraw-tab" data-bs-toggle="tab" data-bs-target="#usdt-withdraw" type="button" role="tab" aria-controls="usdt-withdraw" aria-selected="false">
                                Withdraw
                            </button>
                        </li>

                    </ul>
                    <div class="tab-content" id="usdtWalletLogTabContent">
                        <div class="tab-pane fade show active" id="usdt-deposit" role="tabpanel" aria-labelledby="usdt-deposit-tab">
                            <!--USDT Deposit-->
                            <table class="table table-striped margin-top-10">
                                <thead>
                                <tr>
                                    <th scope="col">Deposit Info</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($params['usdt']['deposit']) > 0){ ?>
                                    <?php foreach ($params['usdt']['deposit'] as $log){ ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="small">
                                                    From: <?php echo $log->from_address;?>
                                                </div>
                                                <div class="small">
                                                    To: <?php echo $log->to_address;?>
                                                </div>
                                                <div class="small">
                                                    Tx Hash: <?php echo $log->tx_hash;?>
                                                </div>
                                            </th>
                                            <td><?php echo number_format($log->amount);?></td>
                                            <td>
                                                <span class="text text-<?php echo ($log->status == OssnWallet::STATUS_CONFIRMED) ? 'success' : 'primary';?>"><?php echo OssnWallet::getStatusText($log->status); ?></span>
                                            </td>
                                            <td><?php echo date('m-d-Y h:i', $log->time_created) ;?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="usdt-withdraw" role="tabpanel" aria-labelledby="usdt-withdraw-tab">
                            <!--USDt WITHDRAW-->
                            <table class="table table-striped margin-top-10">
                                <thead>
                                <tr>
                                    <th scope="col">Withdraw Info</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($params['usdt']['withdraw']) > 0){ ?>
                                    <?php foreach ($params['usdt']['withdraw'] as $log){ ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="small">
                                                    From: <?php echo $log->from_address;?>
                                                </div>
                                                <div class="small">
                                                    To: <?php echo $log->to_address;?>
                                                </div>
                                                <div class="small">
                                                    Tx Hash: <?php echo $log->tx_hash;?>
                                                </div>
                                            </th>
                                            <td><?php echo number_format($log->amount);?></td>
                                            <td>
                                                <span class="text text-<?php echo ($log->status == OssnWallet::STATUS_CONFIRMED) ? 'success' : 'primary';?>"><?php echo OssnWallet::getStatusText($log->status); ?></span>
                                            </td>
                                            <td><?php echo date('m-d-Y h:i', $log->time_created) ;?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>

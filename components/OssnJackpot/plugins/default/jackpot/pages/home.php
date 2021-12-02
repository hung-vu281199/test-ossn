
<div class="row">
    <div class="col-lg-12">

        <h2>Your numbers</h2>
        <a href="<?php echo ossn_site_url('jackpot/create');?>" class="btn btn-primary pull-right">Buy Number - 10 DAK</a>

        <table class="table table-striped margin-top-10">
            <thead>
            <tr>
                <th scope="col">Draw Date</th>
                <th scope="col">Winning Numbers</th>
                <th scope="col">Matched Count</th>
                <th scope="col">Rewards</th>
                <th scope="col">Buy Time</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($params['my_jackpot']) > 0){ ?>
                <?php foreach ($params['my_jackpot'] as $j){ ?>
                    <tr>
                        <td scope="row">
                            <?php echo $j->date; ?> <br>
                            <span class="badge bg-primary"><?php echo strtoupper($j->am_pm); ?></span>
                        </td>
                        <td>
                            <span class="badge bg-primary jackpot-slot-play"><?php echo $j->slot_1; ?></span>
                            <span class="badge bg-primary jackpot-slot-play"><?php echo $j->slot_2; ?></span>
                            <span class="badge bg-primary jackpot-slot-play"><?php echo $j->slot_3; ?></span>
                            <span class="badge bg-primary jackpot-slot-play"><?php echo $j->slot_4; ?></span>
                            <span class="badge bg-primary jackpot-slot-play"><?php echo $j->slot_5; ?></span>
                            <span class="badge bg-primary jackpot-slot-play"><?php echo $j->slot_6; ?></span>
                        </td>
                        <td scope="row"><?php echo ($j->max_slot_prize > 0) ? $j->max_slot_prize : 0; ?></td>
                        <td scope="row"><?php echo ($j->prize_amount > 0) ? number_format($j->prize_amount) : 0; ?> DAK</td>
                        <td scope="row"><?php echo date('Y-m-d h:i:s', $j->time_created); ?></td>

                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>

        <hr>

        <h2>
            Previous Winning Drawings
        </h2>
        <table class="table table-striped margin-top-10">
            <thead>
            <tr>
                <th scope="col">Draw Date</th>
                <th scope="col">Winning Numbers</th>
                <th scope="col">Total Jackpot</th>
                <th scope="col">Rewards</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($params['today_jackpot']) > 0){ ?>
                <?php foreach ($params['today_jackpot'] as $j){ ?>
                    <tr>
                        <td scope="row">
                            <?php echo $j->date; ?> <br>
                            <span class="badge bg-primary"><?php echo strtoupper($j->am_pm); ?></span>
                        </td>
                        <td>
                            <span class="badge bg-success jackpot-slot"><?php echo $j->slot_1; ?></span>
                            <span class="badge bg-success jackpot-slot"><?php echo $j->slot_2; ?></span>
                            <span class="badge bg-success jackpot-slot"><?php echo $j->slot_3; ?></span>
                            <span class="badge bg-success jackpot-slot"><?php echo $j->slot_4; ?></span>
                            <span class="badge bg-success jackpot-slot"><?php echo $j->slot_5; ?></span>
                            <span class="badge bg-success jackpot-slot"><?php echo $j->slot_6; ?></span>
                        </td>
                        <td>
                            <?php echo ($j->total_jackpot > 0) ? $j->total_jackpot : 0;?>
                        </td>
                        <td style="font-size: 2em;" class="text text-success">
                            <?php echo ($j->reward > 0) ? number_format($j->reward) : 0;?> DAK
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>

        </table>
<!--        <a href="#">View more...</a>-->


    </div>

</div>

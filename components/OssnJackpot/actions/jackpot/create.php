<?php
$jp = new OssnJackpot();
$date = trim(input('date'));
$ampm = strtolower(trim(input('ampm')));
$number = trim(input('number'));
$info = $jp->buyNumber($date, $ampm, $number);

if($info){
    redirect(ossn_site_url('jackpot/home'));
} else {
    echo 0;
}
exit;

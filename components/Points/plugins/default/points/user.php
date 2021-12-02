<?php
	$point = new Points($params['user']->guid);
?>
<div class="user-fullname ossn-profile-points hidden-xs"><i class="fa fa-money"></i><?php echo $point->getPoints();?></div>

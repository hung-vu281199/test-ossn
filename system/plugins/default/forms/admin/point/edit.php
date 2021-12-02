<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */



$ps = $params['point-setting'];

?>
<div>
	<label> <?php echo ossn_print('name'); ?> </label>
	<input type='text' name="name" value="<?php echo $ps->name; ?>"/>
</div>
<div>
    <label> <?php echo ossn_print('code'); ?> </label>
    <input type='text' name="code" value="<?php echo $ps->code; ?>"/>
</div>
<div>
    <label> <?php echo ossn_print('value'); ?> </label>
    <input type='text' name="value" value="<?php echo $ps->value; ?>"/>
</div>
<div>
	<label> <?php echo ossn_print('status'); ?> </label>
	<select name="status">
    <?php

    if ($ps->status == 1) {
        $enable = 'selected';
        $disable = '';
    } else {
        $enable = '';
        $disable = 'selected';
    }
    ?>
    	<option value="1" <?php echo $enable; ?>> Enable </option>
    	<option value="0" <?php echo $disable; ?>> Disable</option>
	</select>
</div>

<div>
	<input type="hidden" value="<?php echo $ps->guid; ?>" name="guid"/>
	<input type="submit" class="btn btn-success btn-sm" value="<?php echo ossn_print('save'); ?>"/>
</div>

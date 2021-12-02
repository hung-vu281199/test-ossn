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

$category = $params['category'];

?>
<div>
	<label> <?php echo ossn_print('name'); ?> </label>
	<input type='text' name="name" value="<?php echo $category->name; ?>"/>
</div>
<div>
	<label> <?php echo ossn_print('status'); ?> </label>
	<select name="enable">
    <?php

    if ($category->enable == 1) {
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
	<input type="hidden" value="<?php echo $category->guid; ?>" name="guid"/>
	<input type="submit" class="btn btn-success btn-sm" value="<?php echo ossn_print('save'); ?>"/>
</div>

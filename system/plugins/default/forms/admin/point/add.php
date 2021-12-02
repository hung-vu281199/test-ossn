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
?>
<div>
	<label> <?php echo ossn_print('name'); ?> </label>
	<input type='text' name="name" placeholder=''/>
</div>
<div>
    <label> <?php echo ossn_print('code'); ?> </label>
    <input type='text' name="code" placeholder=''/>
</div>
<div>
    <label> <?php echo ossn_print('value'); ?> </label>
    <input type='text' name="value" placeholder=''/>
</div>
<div>
	<label> <?php echo ossn_print('status'); ?> </label>
	<select name="status">
        <option value="0">Enable</option>
        <option value="1">Disable</option>
    </select>
</div>
<div>
	<input type="submit" class="btn btn-primary" value="<?php echo ossn_print('save'); ?>"/>
</div>

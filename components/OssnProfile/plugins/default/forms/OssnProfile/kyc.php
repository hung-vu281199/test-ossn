<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$user = $params['user'];
?>
<script type="text/javascript">
    $(function () {
        $('.birthday').datepicker({
            format: "yyyy-mm-dd",
        });
    });
</script>

<div>
    <figure class="text-center">
        <blockquote class="blockquote">
            <h4>KYC Level: <?php echo ($user->kyc_level != null) ? $user->kyc_level : 'Basic';?></h4>
        </blockquote>

    </figure>
</div>
<div>
	<label> <?php echo ossn_print('first:name'); ?> </label>
	<input type='text' name="firstname" value="<?php echo $user->first_name; ?>"/>
</div>
<div>
	<label> <?php echo ossn_print('last:name'); ?> </label>
	<input type='text' name="lastname" value="<?php echo $user->last_name; ?>"/>
</div>

<div>
    <label> <?php echo ossn_print('profile:birthday'); ?> </label>
    <input type="text" class="birthday" name="birthday" value="<?php echo $user->birthday; ?>"/>
</div>

<div>
    <label> <?php echo ossn_print('profile:id_type'); ?> </label>
    <select name="id_type">
        <option value="<?php echo $user->id_type; ?>">CMND</option>
    </select>
</div>
<div>
    <label> <?php echo ossn_print('profile:id_number'); ?> </label>
    <input type='text' name="id_number" value="<?php echo $user->id_number; ?>"/>
</div>
<?php if($user->kyc_level != 2) { ?>
<div>
    <label> <?php echo ossn_print('profile:id_front_image'); ?> </label><br>
    <input type='file' name="id_front_image"/>
</div>
<hr>
<input type="hidden" value="<?php echo $user->username; ?>" name="username"/>
<input type="submit" class="btn btn-primary" value="<?php echo ossn_print('save'); ?>"/>
<?php } ?>

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
$OssnSitePages = new OssnSitePages;
$OssnSitePages->pagename = 'about';
$OssnSitePages = $OssnSitePages->getPage();
if($OssnSitePages) {
	$description = html_entity_decode($OssnSitePages->description);
} else {
	$description = '';
}
?>
<div>
	<label> <?php echo ossn_print('site:about'); ?> </label>
	<textarea name="pagebody" class="ossn-editor"><?php echo $description; ?></textarea>
<div>
<div class="margin-top-10">
	<input type="submit" class="btn btn-success btn-sm" value="<?php echo ossn_print('save'); ?>"/>
</div>

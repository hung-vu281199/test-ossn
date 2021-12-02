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
$search = input('search_point');
$ps = new OssnPointSetting();
$pagination = new OssnPagination;

if (!empty($search)) {
   $list = $ps->searchPointSetting(array(
				 'keyword' => $search,
			));
   $count = $ps->searchPointSetting(array(
				 'count' => true,
			));
} else {

   $list = $ps->searchPointSetting(array(
				 'keyword' => false,
			));
   $count = $ps->searchPointSetting(array(
				 'keyword' => false,
				 'count' => true,
			));
}

?>
<div class="margin-top-10">
<table class="table ossn-users-list">
    <tbody>
    <tr class="table-titles">
        <th><?php echo ossn_print('name'); ?></th>
        <th><?php echo ossn_print('code'); ?></th>
        <th><?php echo ossn_print('value'); ?></th>
        <th><?php echo ossn_print('status'); ?></th>
        <th><?php echo ossn_print('time_created'); ?></th>
        <th><?php echo ossn_print('edit'); ?></th>
<!--        <th>--><?php //echo ossn_print('delete'); ?><!--</th>-->
    </tr>
    <?php
	if($list){
	foreach ($list as $item) {
	    $status = ($item->status == 0) ? 'Disable' : 'Enable';
        ?>
        <tr>
            <td><?php echo $item->name; ?></td>
            <td><?php echo $item->code; ?></td>
            <td><?php echo $item->value; ?></td>
            <td><?php echo $status; ?></td>
            <td><?php echo date('d-m-Y h:i:s', $item->time_created); ?></td>
            <td>
                <a href="<?php echo ossn_site_url("administrator/edit-point/{$item->guid}"); ?>"><?php echo ossn_print('edit'); ?></a>
            </td>
<!--            <td><a href="--><?php //echo ossn_site_url("action/admin/point/delete?guid={$item->guid}", true); ?><!--" class="ossn-make-sure" data-ossn-msg="ossn:user:delete:exception">--><?php //echo ossn_print('delete'); ?><!--</a></td>-->

        </tr>
    <?php
		}
	}
	?>
    </tbody>
</table>
</div>
<div class="row">
	<?php echo ossn_view_pagination($count); ?>
</div>

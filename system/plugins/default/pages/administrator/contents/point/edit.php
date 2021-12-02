<?php
echo ossn_view_form('admin/point/edit', array(
    'action' => ossn_site_url('action/admin/point/edit'),
    'class' => 'ossn-admin-form',
    'params' => $params,
));?>
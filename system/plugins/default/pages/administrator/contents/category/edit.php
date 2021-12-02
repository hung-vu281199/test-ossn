<?php
echo ossn_view_form('admin/category/edit', array(
    'action' => ossn_site_url('action/admin/category/edit'),
    'class' => 'ossn-admin-form',
    'params' => $params,
));?>
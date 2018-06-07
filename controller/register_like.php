<?php
require_once '../model/queries.php';

function add_like($image_id)
{
    register_like(1, $image_id);
}

if (isset($_POST['snap_id']))
    add_like($_POST['snap_id']);
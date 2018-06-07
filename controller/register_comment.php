<?php
require_once '../model/queries.php';

function add_comment($snap_id, $content)
{
    register_comment(1, $snap_id, $content);
}

if (isset($_POST['snap_id']) && isset($_POST['content']))
    add_comment($_POST['snap_id'], $_POST['content']);
<?php

require_once '../model/snap.class.php';
require_once '../model/user.class.php';

session_start();
function save_file($img, $filter_id)
{
    $user = unserialize($_SESSION['user']);
    $new_snap = new snap();
    echo $new_snap->save($user,$img, $filter_id);
}

if (isset($_POST['snap']) && isset($_POST['filter_id']) && isset($_SESSION['user']) && $_SESSION['user'] !== "")
    save_file($_POST['snap'], $_POST['filter_id']);
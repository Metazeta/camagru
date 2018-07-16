<?php

require_once '../model/snap.class.php';
require_once '../model/user.class.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function delete_snap($img)
{
    $delsnap = new snap();
    $delsnap->delete($img);
}

if (isset($_POST['snap_id']) && isset($_SESSION['user']))
    delete_snap($_POST['snap_id']);
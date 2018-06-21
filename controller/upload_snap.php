<?php

require_once '../model/snap.class.php';
require_once '../model/user.class.php';

session_start();
function save_file($img)
{
    $user = unserialize($_SESSION['user']);
    $new_snap = new snap();
    echo $new_snap->save($user,$img);
}

if (isset($_POST['snap']))
    save_file($_POST['snap']);
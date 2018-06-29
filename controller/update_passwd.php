<?php
require_once '../model/user.class.php';

session_start();
if (isset($_SESSION['user']))
{
    $user = unserialize($_SESSION['user']);
    if (isset($_POST['oldpwd'], $_POST['newpwd']))
        echo $user->update_passwd($_POST['oldpwd'], $_POST['newpwd']);
}
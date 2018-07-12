<?php
require_once('../model/user.class.php');
if (isset($_POST['login']))
{
    $user = new user($_POST['login']);
    $user->set_confirm();
    header("Location: ../login.php");
}

if (isset($_POST['new_pass1']))
{
    $user = new user($_POST['login']);
    $user->reset_pwd($_POST['new_pass1'], $_POST['new_pass2'], $_POST['confirm_value']);
    header("Location: ../login.php");

}
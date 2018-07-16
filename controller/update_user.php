<?php
require_once '../model/user.class.php';

session_start();
if (isset($_SESSION['user']))
{
  $user = unserialize($_SESSION['user']);
    if (isset($_POST['oldpwd']) && isset($_POST['newpwd']))
        echo $user->update_passwd($_POST['oldpwd'], $_POST['newpwd']);
    else if (isset($_POST['newlogin']) && isset($_POST['pwd']))
      echo $user->update_login($_POST['pwd'], $_POST['newlogin']);
  else if (isset($_POST['newmail']) && isset($_POST['pwd']))
    echo $user->update_email($_POST['pwd'], $_POST['newmail']);
  unset($_SESSION['user']);
  $_SESSION['user'] = serialize($user);
}

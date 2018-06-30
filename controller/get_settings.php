<?php
session_start();
require_once('../model/user.class.php');

$user = unserialize($_SESSION['user']);
if (isset($_POST["set"]))
{
    $user->set_suscribe($_POST['state']);
}
else
  echo $user->get_suscribe();
?>

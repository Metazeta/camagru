<?php

require_once("../model/user.class.php");

session_start();

$_SESSION["user"] = "";
if (isset($_POST["login"]) && isset($_POST["passwd"]))
{
    $user = new user($_POST["login"]);
    $success = $user->auth($_POST['passwd']);
    if ($success) {
        $_SESSION["user"] = serialize($user);
        header("Location: ../profile.php");
    }
    else {
        header("Location: ../login.php");
    }
}
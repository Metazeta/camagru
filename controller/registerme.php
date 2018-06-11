<?php

require_once("../model/user.class.php");

session_start();

$_SESSION["user"] = "";
if (isset($_POST["login"]) && isset($_POST["passwd"]) && isset($_POST["email"]))
{
    if (strlen($_POST["passwd"]) < 4) {
        header("Location: ../register.php?tooshort=true");
    }
    else
        {
            $user = new user($_POST["login"]);
            if ($user->create($_POST["passwd"], $_POST['email'])) {
                $success = $user->auth($_POST['passwd']);
                if ($success) {
                    $_SESSION["user"] = serialize($user);
                    header("Location: ../profile.php");
                }
                else {
                header("Location: ../register.php");
                }
            }
        }
}
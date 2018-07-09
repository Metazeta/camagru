<?php

require_once("../model/user.class.php");

session_start();

$_SESSION["user"] = "";
if (isset($_POST["login"]) && isset($_POST["passwd"]) && isset($_POST["email"]))
{
    $tmp = new user("");
    $logins = $tmp->get_all_logins();
    if (!password_validity($_POST["passwd"]) || in_array($_POST["login"], $logins)) {
        header("Location: ../register.php");
    }
    else
        {
            $user = new user(htmlspecialchars($_POST["login"]));
            if ($user->create(htmlspecialchars($_POST["passwd"]), htmlspecialchars($_POST['email']))) {
                $success = $user->auth(htmlspecialchars($_POST['passwd']));
                header("Location: ../register.php");
            }
        }
}

function password_validity($pass)
{
    if (strlen($pass) < 8)
        return false;
    if (strtolower($pass) === $pass)
        return false;
    if (strtoupper($pass) === $pass)
        return false;
    if (ctype_alnum($pass))
        return false;
    return true;
}

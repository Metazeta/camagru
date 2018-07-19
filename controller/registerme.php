<?php

require_once("../model/user.class.php");

session_start();

$_SESSION["user"] = "";
if (isset($_POST["login"]) && isset($_POST["passwd"]) && isset($_POST["email"]))
{
    $tmp = new user("");
    $logins = $tmp->get_all_logins();
    if (!password_validity($_POST["passwd"]) || in_array($_POST["login"], $logins) || !mail_validity($_POST['email'])
    || !login_validity($_POST['login']))
        header("Location: ../register.php");
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
    if (strlen($pass) < 8 || strtolower($pass) === $pass || strtoupper($pass) === $pass || ctype_alnum($pass))
        return false;
    return true;
}


function mail_validity($email)
{
    return preg_match('/[^\s@]+@[^\s@]+\.[^\s@]+/', $email);
}


function login_validity($login)
{
    return ctype_alnum ($login);
}
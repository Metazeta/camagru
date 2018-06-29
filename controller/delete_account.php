<?php
require_once '../model/user.class.php';

session_start();
function delete_account($user, $passwd)
{
         $user = unserialize($user);
         echo $user->delete($passwd);
        unset ($_SESSION["user"]);
}

if (isset($_SESSION['user']) && isset($_POST['passwd']))
    delete_account($_SESSION['user'], $_POST['passwd']);
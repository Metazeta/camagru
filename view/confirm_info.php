<?php
require_once("model/user.class.php");
if (isset($_GET['confirm']))
{
    $user = new user("");
    $res = $user->confirm($_GET['confirm']);
    if ($res !== false)
        echo "<div class='confirm'>Your account has been confirmed, you can now login.</div>";
    else
        echo "<div class='confirm'>This confirmation ID is wrong.</div>";
}
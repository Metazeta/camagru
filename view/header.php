<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Little Camagru</title>
    <link rel="stylesheet" href="view/css/header.css">
    <link rel="stylesheet" href="view/css/main.css">
    <link rel="stylesheet" href="view/css/gallery.css">
    <link rel="stylesheet" href="view/css/profile.css">
    <link rel="stylesheet" href="view/css/footer.css">
    <link rel="stylesheet" href="view/css/login.css">
    <link rel="stylesheet" href="view/css/register.css">
</head>
<body class="main_body">
<div class="website_container">

<div class="header">
    <div class="navbar">
        <div class="navitem">My Little Camagru</div>
        <a class="navitem" href="index.php">Gallery</a>
        <?php
            session_start();
            if (isset($_SESSION["user"]) && $_SESSION["user"] != "") {
                echo "<a class='navitem' href='profile.php'>My Profile</a>
                       <a class='login' href='logout.php'>Logout</a>";
            }
            else
                echo "<a class='navitem' href='login.php'>Login</a>
                    <a class='login' href='register.php'>Register</a>";
        ?>
    </div>
</div>

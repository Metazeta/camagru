<?php
require_once '../model/like.class.php';
require_once '../model/user.class.php';

function add_like($image_id)
{
    session_start();
    if (isset($_SESSION['user']))
    {
        $user = unserialize($_SESSION['user']);
        $like = new like();
        $currentlike = $like->register_like($user->get_id(), $image_id);
        echo $currentlike;
    }
}

if (isset($_POST['snap_id']))
    add_like($_POST['snap_id']);
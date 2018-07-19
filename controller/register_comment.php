<?php
require_once '../model/comment.class.php';
require_once '../model/user.class.php';

session_start();

function add_comment($snap_id, $content)
{
    $user = unserialize($_SESSION['user']);
    $comment = new comment();
    $com = $comment->register_comment($user->get_id(), $snap_id, $content);
    $comment->notify_user($snap_id);
    echo "<b>".$com[0]."</b> ".$com[1];
}

if (isset($_POST['snap_id']) && isset($_POST['content']) && isset($_SESSION['user']) && $_SESSION['user'] !== "")
    add_comment($_POST['snap_id'], htmlspecialchars($_POST['content']));
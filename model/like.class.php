<?php
require_once 'pdo.class.php';
require_once 'user.class.php';

class like extends pdo_connection
{
    function __construct()
    {
        parent::__construct();
    }

    function notify_user($snap_id)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `user_id` FROM `pics` WHERE `id` = :snap_id");
        $st->execute(array(':snap_id' => $snap_id));
        $this->close();
        $user = new user("");
        $user->login_from_id($st->fetchAll()[0][0]);
        $user->notify("Hey ".$user->get_login()."! You got a new like!");
    }

    function register_like($user_id , $snap_id)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `user_id` FROM likes WHERE `user_id` = :user_id  AND `snap_id` = :snap_id");
        $st->execute(array(":user_id" => $user_id, ":snap_id" => $snap_id));
        if (count($st->fetchAll()) > 0) {
            $st = $this->dbh->prepare("DELETE FROM likes WHERE `user_id` = :user_id  AND `snap_id` = :snap_id");
            $st->execute(array(":user_id" => $user_id, ":snap_id" => $snap_id));
        }
        else
        {
            $st = $this->dbh->prepare("INSERT INTO likes (`user_id`, `snap_id`) VALUES (:user_id, :snap_id)");
            $st->execute(array(":user_id" => $user_id, ":snap_id" => $snap_id));
            $this->notify_user($snap_id);
        }
        $this->connect();
        $st = $this->dbh->prepare("SELECT COUNT(*) FROM likes WHERE `snap_id` = :snap_id");
        $st->execute(array(":snap_id" => $snap_id));
        $currentlikes = $st->fetchAll()[0];
        $this->close();
        return $currentlikes;
    }

    function get_likes($snap_id)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `user_id` FROM likes WHERE `snap_id` = :snap_id");
        $st->execute(array(":snap_id" => $snap_id));
        $this->close();
        return ($st->fetchAll());
    }

    function likes($user_id, $snap_id)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `user_id` FROM likes WHERE `user_id` = :user_id AND `snap_id` = :snap_id");
        $st->execute(array(":user_id" => $user_id, "snap_id" => $snap_id));
        $liked = $st->fetchAll();
        $this->close();
        if (count($liked) > 0)
            return TRUE;
        else
            return FALSE;
    }
}
<?php
require_once 'pdo.class.php';

class comment extends pdo_connection
{
    function __construct()
    {
        parent::__construct();
    }

    function register_comment($user_id , $snap_id, $content)
    {
        $this->connect();
        $st = $this->dbh->prepare("
        INSERT INTO comments (`user_id`, `snap_id`, `content`) VALUES (:user_id, :snap_id, :content)
        ");
        $st->execute(array(":user_id" => $user_id, ":snap_id" => $snap_id, ":content" => $content));
        $user = new user("");
        $login = $user->login_from_id($user_id);
        $this->close();
        return [$login, $content];
    }

    function notify_user($snap_id)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `user_id` FROM `comments` WHERE `snap_id` = :snap_id");
        $st->execute(array(':snap_id' => $snap_id));
        $this->close();
        $user = new user("");
        $user->login_from_id($st->fetchAll()[0][0]);
        $user->notify("Hey ".$user->get_login()."! You got a new comment !");
    }

    function get_comments($snap_id)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `content`, `snap_id`, `login` FROM `comments`
                    LEFT JOIN `users` ON `user_id` = users.id WHERE `snap_id` = :snap_id
                    ORDER BY `comment_time` DESC;");
        $st->execute(array(":snap_id" => $snap_id));
        $this->close();
        return ($st->fetchAll());
    }

    function __toString()
    {

    }
}
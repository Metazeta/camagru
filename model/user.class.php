<?php

require_once dirname(__FILE__) . '/../model/pdo.class.php';

class user extends pdo_connection
{
    protected $login = "";
    protected $passwd = "";
    protected $email = "";
    protected $id = 0;

    function __construct($login)
    {
        parent::__construct();
        $this->login = $login;
    }

    function get_all_logins()
    {
        $this->connect();
        $res = $this->dbh->query("SELECT `login` FROM `users`");
        $res = $res->fetchAll();
        $logins = array();
        foreach ($res as $login)
            $logins[] = $login['login'];
        return $logins;
    }

    function get_login()
    {
        return $this->login;
    }

    function login_from_id($id)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `login` FROM `users` WHERE `id` = :id");
        $st->execute(array(":id" => $id));
        $this->login = $st->fetchAll()[0]['login'];
        return $this->login;
    }

    function get_id()
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `id` FROM `users` WHERE `login` = :login");
        $st->execute(array(":login" => $this->login));
        $this->id = $st->fetchAll()[0]['id'];
        return $this->id;
    }

    private function get_passwd()
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `passwd`, `confirmation` FROM `users` WHERE `login` = :login");
        $st->execute(array(":login" => $this->login));
        $this->close();
        $res = $st->fetchAll();
        if (isset($res) && isset($res[0]) && isset($res[0]['passwd']) &&
            isset($res[0]['confirmation']) && $res[0]['confirmation'] == "")
            $this->passwd = $res[0]['passwd'];
        else
            return False;
        return True;
    }

    private function get_mail()
    {
        if ($this->passwd != "") {
            $this->connect();
            $st = $this->dbh->prepare("SELECT `email` FROM users WHERE login = :login");
            $st->execute(array(':login' => $this->login));
            $row = $st->fetchAll();
            $this->close();
            if ($row && isset($row[0]) && isset($row[0]['email']))
                $this->email = $row[0]['email'];
        }
    }

    public function confirm($confirm)
    {
        $this->connect();
        $st = $this->dbh->prepare("UPDATE users SET `confirmation` = '' WHERE `confirmation` = :confirm");
        $st->execute(array(":confirm" => $confirm));
        $res = $st->rowCount();
        $this->close();
        return ($res > 0);
    }

    public function get_confirm()
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `confirmation` FROM `users` WHERE `id` = :user_id");
        $st->execute(array(":user_id" => $this->login));
        $res = $st->fetchAll();
        $this->close();
        return $res;
    }

    public function send_confirm_mail()
    {
        $this->get_mail();
        $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $content = "Please visit <a href='".$url."?confirm=".$this->get_confirm().
            "' this link</a> to confirm your account";
        mail($this->email, "My Little Camagru - Confirm your email", $content);
        }

    public function create($passwd, $email)
    {
        $passwd = hash("sha384", $passwd);
        $this->connect();
        $st = $this->dbh->prepare("SELECT `login` FROM `users` WHERE `login` = :login");
        $st->execute(array(":login" => $this->login));
        $exists = $st->fetchAll();
        if (count($exists) != 0)
            return FALSE;
        $st = $this->dbh->prepare("INSERT INTO `users` (`login`, `passwd`, `email`, `confirmation`)
        VALUES (:login, :passwd, :email, :confirm)");
        $st->execute(array(":login" => $this->login, ":passwd" => $passwd, ":email" => $email, ":confirm" => uniqid()));
        $this->close();
        $this->send_confirm_mail();
        return TRUE;
    }

    public function auth($passwd)
    {
        $res = $this->get_passwd();
        if ($res == True && $this->passwd == hash("sha384", $passwd))
            return True;
        return False;
    }

    public function update_passwd($current, $new)
    {
        $this->get_passwd();
        if (hash("sha384", $current) !== $this->passwd)
            return false;
        $this->connect();
        $st = $this->dbh->prepare("UPDATE users SET `passwd` = :newpass WHERE `login` = :login");
        $st->execute(array(":newpass" => hash("sha384", $new), ":login" => $this->login));
        $this->close();
        return true;
    }

    public function delete($passwd)
    {
        if (!$this->auth($passwd))
            return false;
        $id = $this->get_id();
        $this->connect();
        $st = $this->dbh->prepare("DELETE FROM pics WHERE `user_id` = :user_id");
        $st->execute(array(":user_id" => $lid));
        $st = $this->dbh->prepare("DELETE FROM comments WHERE `user_id` = :user_id");
        $st->execute(array(":user_id" => $id));
        $st = $this->dbh->prepare("DELETE FROM likes WHERE `user_id` = :user_id");
        $st->execute(array(":user_id" => $id));
        $st = $this->dbh->prepare("DELETE FROM users WHERE `id` = :user_id");
        $st->execute(array(":user_id" => $id));
        $this->close();
        return true;
    }
}
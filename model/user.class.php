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
        $st = $this->dbh->prepare("SELECT `passwd` FROM `users` WHERE `login` = :login");
        $st->execute(array(":login" => $this->login));
        $this->close();
        $res = $st->fetchAll();
        if (isset($res) && isset($res[0]) && isset($res[0]['passwd']))
            $this->passwd = $res[0]['passwd'];
        else
            return False;
        return True;
    }

    private function get_mail()
    {
        if($this->passwd != "")
        {
            $this->connect();
            $st = $this->dbh->prepare("SELECT `email` FROM users WHERE login = :login");
            $st->execute(array(':login' => $this->login));
            $row = $st->fetchAll();
            $this->close();
            if ($row && isset($row[0]) && isset($row[0]['email']))
                $this->email = $row[0]['email'];
        }
    }

    public function send_mail()
    {
        $this->get_mail();
        return $this->email;
    }

    public function create($passwd, $email)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `login` FROM `users` WHERE `login` = :login");
        $st->execute(array(":login" => $this->login));
        $exists = $st->fetchAll();
        if (count($exists) != 0)
            return FALSE;
        $st = $this->dbh->prepare("INSERT INTO `users` (`login`, `passwd`, `email`)
        VALUES (:login, :passwd, :email)");
        $st->execute(array(":login" => $this->login, ":passwd" => $passwd, ":email" => $email));
        $this->close();
        return TRUE;
    }

    public function auth($passwd)
    {
        $res = $this->get_passwd();
        if ($res == True && $this->passwd == $passwd)
            return True;
        return False;
    }
}
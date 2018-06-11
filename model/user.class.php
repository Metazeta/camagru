<?php

require_once dirname(__FILE__) . '/../model/pdo.class.php';

class user
{
    protected $login = "";
    protected $passwd = "";
    protected $email = "";

    function __construct($login)
    {
        $this->login = $login;
    }

    private function get_passwd()
    {
        $connect = new pdo_connection();
        $connect->connect();
        $res = $connect->send("
          SELECT `passwd` FROM `users`
          WHERE `login` = '".$this->login."'
        ");
        $connect->close();
        $res = $res->fetchAll();
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
            $connect = new pdo_connection();
            $connect->connect();
            $res = $connect->send("
                SELECT `email` FROM users
                WHERE login = '".$this->login."'
            ");
            $row = $res->fetchAll();
            $connect->close();
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
        $connect = new pdo_connection();
        $connect->connect();
        $exists = $connect->send("
        SELECT `login` FROM `users`
        WHERE `login` = '".$this->login."'");
        $exists = $exists->fetchAll();
        if (count($exists) != 0)
            return FALSE;
        $connect->send("
        INSERT INTO `users`
        (`login`,`passwd`, `email`)
        VALUES
        ('".$this->login."', '".$passwd."', '".$email."')");
        $connect->close();
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
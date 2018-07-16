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
        $this->connect();
        $st = $this->dbh->prepare("SELECT `email` FROM users WHERE login = :login");
        $st->execute(array(':login' => $this->login));
        $row = $st->fetchAll();
        $this->close();
        if (isset($row[0]) && isset($row[0]['email'])){
            $this->email = $row[0]['email'];
            return $this->email;
        }
        return FALSE;
    }


    public function reset_pwd($newpass1, $newpass2, $confirm)
    {
        if ($this->exists_confirm($confirm) && $newpass1 === $newpass2)
        {
            $this->connect();
            $st = $this->dbh->prepare("UPDATE users SET `passwd` = :newpass WHERE `confirmation` = :confirm");
            $st->execute(array(":newpass" => hash("sha384", $newpass1), ":confirm" => $confirm));
            $this->close();
            $this->passwd = hash("sha384", $new);
            $this->confirm($confirm);
            return TRUE;
        }
        return FALSE;
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
        $st = $this->dbh->prepare("SELECT `confirmation` FROM `users` WHERE `login` = :login");
        $st->execute(array(":login" => $this->login));
        $res = $st->fetchAll();
        $this->close();
        return $res[0];
    }

    public function exists_confirm($confirm)
    {
        $this->connect();
        $st = $this->dbh->prepare("SELECT `confirmation` FROM `users` WHERE `confirmation` = :confirm");
        $st->execute(array(":confirm" => $confirm));
        $res = $st->rowCount();
        $this->close();
        return ($res > 0);
    }

    public function set_confirm()
    {
        $this->connect();
        $newconfirm = uniqid();
        $st = $this->dbh->prepare("UPDATE `users` SET confirmation = :confirm WHERE `login` = :login");
        $st->execute(array(":login" => $this->login, ":confirm" => $newconfirm));
        $this->close();
        $this->notify("You asked a reset of your password !<br>Please visit
                        <a href='http://".$_SERVER['HTTP_HOST']."/reset.php?confirm=".$newconfirm.
            "'>this link</a> to proceed");
    }

    public function notify($content)
    {
        $email = $this->get_mail();
        if ($this->get_suscribe()) {
            $content = "<!DOCTYPE html><html>".$content."</html>";
            $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
            mail($email, "My Little Camagru", $content, $headers);
            return $email;
        }
        return FALSE;
    }

    public function send_confirm_mail($email, $id)
    {
        $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $content = "<!DOCTYPE html>
                <html>Hi ".$this->login."! Please visit <a href='http://".$_SERVER['HTTP_HOST']."/confirm.php?confirm=".$id.
            "'>this link</a> to confirm your account</html>";
        mail($email, "My Little Camagru - Confirm your email", $content, $headers);
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
        $st = $this->dbh->prepare("INSERT INTO `users` (`login`, `passwd`, `email`, `confirmation`, `suscribe`)
        VALUES (:login, :passwd, :email, :confirm, 1)");
        $id = uniqid();
        $st->execute(array(":login" => $this->login, ":passwd" => $passwd, ":email" => $email, ":confirm" => $id));
        $this->close();
        $this->send_confirm_mail($email, $id);
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
        $this->passwd = hash("sha384", $new);
        return true;
    }

    public function update_login($current, $new)
    {
        $this->get_passwd();
        if (hash("sha384", $current) !== $this->passwd)
            return -1;
        $this->connect();
        $st = $this->dbh->prepare("SELECT `login` FROM `users` WHERE `login` = :login");
        $st->execute(array(":login" => $new));
        $exists = $st->fetchAll();
        if (count($exists) > 0)
        {
            $this->close();
            return -1;
        }
        $st2 = $this->dbh->prepare("UPDATE users SET `login` = :newlogin WHERE `login` = :login");
        $st2->execute(array(":newlogin" => $new, ":login" => $this->login));
        $this->close();
        $this->login = $new;
        return 1;
    }

        public function update_email($passwd, $new)
        {
            $this->get_passwd();
            if (hash("sha384", $passwd) !== $this->passwd)
                return -1;
            $this->connect();
            $st2 = $this->dbh->prepare("UPDATE users SET `email` = :newmail WHERE `login` = :login");
            $st2->execute(array(":newmail" => $new, ":login" => $this->login));
            $this->close();
            $this->email = $new;
            return 1;
        }

    public function get_suscribe()
    {
      $this->connect();
      $this->get_login();
      $st = $this->dbh->prepare("SELECT `suscribe` FROM users WHERE `login` = :login");
      $st->execute(array(":login" => $this->login));
      $this->close();
      $res = $st->fetchAll()[0][0];
      return $res;
    }

    public function set_suscribe($state)
        {
          $this->connect();
          $this->get_login();
          $st = $this->dbh->prepare("UPDATE `users` SET `suscribe` = :state WHERE `login` = :login");
          $st->execute(array(":login" => $this->login, ":state" => $state));
          $this->close();
          return $this->login;
        }

    public function delete($passwd)
    {
        if (!$this->auth($passwd))
            return false;
        $id = $this->get_id();
        $this->connect();
        $st = $this->dbh->prepare("DELETE FROM pics WHERE `user_id` = :user_id");
        $st->execute(array(":user_id" => $id));
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

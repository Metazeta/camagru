<?php

class pdo_connection
{
    protected $dbh;
    protected $db_name;
    protected $creds;

    function __construct()
    {
        require dirname(__FILE__).'/../config/database.php';
        $this->creds = ['dsn' => $DB_DSN,
            'user' => $DB_USER,
            'passwd' => $DB_PASSWORD,
            'db_name' => $DB_NAME];
        $this->db_name = $this->creds['db_name'];
    }

    function connect()
    {
        try{
            $this->dbh = new PDO($this->creds['dsn'], $this->creds['user'], $this->creds['passwd']);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e)
        {
            print ("Could not connect to database, please create a `".$this->db_name."` database");
            die();
        }
    }

    function reset()
    {
        try {
            $delete = "DROP TABLE IF EXISTS `users`";
            $this->dbh->exec($delete);
            $delete = "DROP TABLE IF EXISTS `pics`";
            $this->dbh->exec($delete);
            $delete = "DROP TABLE IF EXISTS `likes`";
            $this->dbh->exec($delete);
            $delete = "DROP TABLE IF EXISTS `comments`";
            $this->dbh->exec($delete);
            $delete = "DROP TABLE IF EXISTS `filters`";
            $this->dbh->exec($delete);
        } catch (PDOException $e)
        {
            echo $delete . "<br>" . $e->getMessage();
        }
        echo "DATABASE CLEARED SUCCESSFULLY <br/>";
    }

    function init()
    {
        $init_db = file_get_contents('cama.sql');
        $this->connect();
        $this->dbh->exec($init_db);
        $this->close();
        echo "TABLES CREATED SUCCESSFULLY <br/>";
    }

    function diagnose()
    {
        $this->connect();
        $tmp = $this->dbh->query("SHOW TABLES FROM `".$this->db_name."`")->fetchAll(PDO::FETCH_ASSOC);
        $res = array();
        foreach ($tmp as $r)
        {
            $res[$r['Tables_in_'.$this->db_name]] = true;
        }
        if (isset($res['likes']) && isset($res['comments']) && isset($res['pics']) && isset($res['filters']) && isset($res['users']))
            return true;
        else
            return false;
    }

    function get_db()
    {
        return $this->dbh;
    }

    function send($query)
    {
        $res = NULL;
        try{
            $res = $this->dbh->query($query);
        } catch (PDOException $e)
        {
            echo $query . "<br>" . $e->getMessage();
            die();
        }
        return $res;
    }

    function close()
    {
        $this->dbh = Null;
    }

    function __destruct()
    {
        $this->close();
    }
}

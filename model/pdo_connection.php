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
        $this->dbh = new PDO($this->creds['dsn'], $this->creds['user'], $this->creds['passwd']);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        if ($this->dbh === Null) {
            print ("Could not connect to database");
            die();
        }
    }

    function reset()
    {
        try {
            $delete = "DROP DATABASE IF EXISTS ".$this->db_name;
            $this->dbh->exec($delete);
        } catch (PDOException $e)
        {
            echo $delete . "<br>" . $e->getMessage();
        }
        echo "DATABASE DELETED SUCCESSFULLY <br/>";
    }

    function init()
    {
        $this->create_db('cama');
        $this->create_tables();
    }

    function get_db()
    {
        return $this->dbh;
    }

    function create_db($dbname)
    {
        try{
            $create = 'CREATE DATABASE IF NOT EXISTS '.$dbname;
            $this->dbh->exec($create);
        } catch (PDOException $e)
        {
            echo $create . "<br>" . $e->getMessage();
            die();
        }
        echo "DATABASE ".$dbname." CREATED SUCCESSFULLY <br/>";
    }

    function create_tables()
    {
        try{
            $create = 'CREATE TABLE IF NOT EXISTS '.$this->db_name.".pics (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT UNSIGNED,
                path VARCHAR(50) NOT NULL,
                upload_time TIMESTAMP               
            )";
            $this->dbh->exec($create);
            $create = 'CREATE TABLE IF NOT EXISTS '.$this->db_name.".likes (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT UNSIGNED,
                snap_id INT UNSIGNED           
            )";
            $this->dbh->exec($create);
            $create = 'CREATE TABLE IF NOT EXISTS '.$this->db_name.".comments (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT UNSIGNED,
                snap_id INT UNSIGNED,
                content VARCHAR(50) NOT NULL,
                comment_time TIMESTAMP               
            )";
            $this->dbh->exec($create);
        } catch (PDOException $e)
        {
            echo $create . "<br>" . $e->getMessage();
            die();
        }
        echo "TABLES CREATED SUCCESSFULLY <br/>";
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

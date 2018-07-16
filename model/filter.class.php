<?php
require_once 'pdo.class.php';

class filter extends pdo_connection
{
    function __construct()
    {
        parent::__construct();
    }


    function get_filters()
    {
        $this->connect();
        $sentence = "SELECT `id`, `path` FROM filters ";
        $stmnt = $this->dbh->prepare($sentence);
        $stmnt->execute();
        $res = $stmnt->fetchAll();
        $this->close();
        return $res;
    }

    function get_filter_path($id)
    {
        $this->connect();
        $sentence = "SELECT `path` FROM filters WHERE `id` = :id";
        $stmnt = $this->dbh->prepare($sentence);
        $stmnt->execute(array(":id" => $id));
        $res = $stmnt->fetchAll();
        $this->close();
        return "../model/filters/".$res[0][0];
    }
}
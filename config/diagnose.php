<?php
require_once dirname(__FILE__) . '/../model/pdo.class.php';

$connect = new pdo_connection();
$connect->connect();
if ($connect->diagnose())
    echo "EVERYTHING IS IN ORDER";
else
    echo "TABLES ARE NOT SET CORRECTLY, PLEASE RESET";
$connect->close();
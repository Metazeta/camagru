<?php
require_once dirname(__FILE__) . '/../model/pdo.class.php';

 $connect = new pdo_connection();
 $connect->connect();
 if (isset($_GET['reset']) && $_GET['reset'] === 'true')
     $connect->reset();
 $connect->init();
 $connect->close();
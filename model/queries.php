<?php
require dirname(__FILE__).'/../config/database.php';
require_once dirname(__FILE__).'/../model/pdo_connection.php';

function connect_pdo()
{
    $connect = new pdo_connection();
    $connect->connect();
    return $connect;
}

function register_snap($filepath)
{
    $connect = connect_pdo();
    $connect->send("
    INSERT INTO cama.pics
    (`user_id`, `path`)
    VALUES
    (
    1,
    '".$filepath."'
    )
    ");
    $connect->close();
}

function get_images($user)
{
    $connect = connect_pdo();
    $pdores = $connect->send("
       SELECT `id`, `path`, `upload_time` FROM cama.pics 
       WHERE user_id = ".$user."
       ORDER BY `upload_time` DESC
        ");
    $res = $pdores->fetchAll();
    $connect->close();
    return $res;
}

function register_like($user_id , $snap_id)
{
    $connect = connect_pdo();
    $connect->send(" 
        INSERT INTO cama.likes
        (`user_id`, `snap_id`)
        VALUES
        (
        ".$user_id.",
        ".$snap_id."
        )
    ");
    $connect->close();
}

function format_timestamp($timestamp)
{
    $utc_date = DateTime::createFromFormat(
        'Y-m-d G:i:s',
        $timestamp,
        new DateTimeZone('UTC')
    );

    $local_date = $utc_date;
    $local_date->setTimeZone(new DateTimeZone('Europe/Paris'));
    setlocale (LC_TIME, 'fr_FR');
    return strftime("%H:%M", $local_date->getTimestamp());
}

function get_likes($snap_id)
{
    $connect = connect_pdo();
    $res = $connect->send("
    SELECT `user_id` FROM cama.likes
    WHERE `snap_id` = ".$snap_id."
    ");
    $connect->close();
    return ($res->fetchAll());
}

function get_comments($snap_id)
{
    $connect = connect_pdo();
    $res = $connect->send("
    SELECT `user_id`, `content` FROM cama.comments
    WHERE `snap_id` = ".$snap_id."
    ");
    $connect->close();
    return ($res->fetchAll());
}

function register_comment($user_id , $snap_id, $content)
{
    $connect = connect_pdo();
    $connect->send(" 
        INSERT INTO cama.comments
        (`user_id`, `snap_id`, `content`)
        VALUES
        (
        ".$user_id.",
        ".$snap_id.",
        '".$content."'
        )
    ");
    $connect->close();
}
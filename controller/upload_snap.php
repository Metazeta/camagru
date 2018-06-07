<?php

require_once '../model/queries.php';

define('UPLOAD_DIR', '../model/pics/');

function save_file($img)
{
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $id = uniqid();
    $file = UPLOAD_DIR . $id . '.png';
    $success = file_put_contents($file, $data);
    print $success ? $file : 'Unable to save the file.';
    register_snap($id.'.png');
}

if (isset($_POST['snap']))
    save_file($_POST['snap']);
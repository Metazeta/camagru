<?php

require_once '../model/snap.class.php';

function delete_snap($img)
{
    $delsnap = new snap();
    $delsnap->delete($img);
}

if (isset($_POST['snap_id']))
    delete_snap($_POST['snap_id']);
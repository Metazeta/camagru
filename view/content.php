<?php
    if (!isset($_SESSION['user']))
        header("Location: ../index.php");
?>
<div class="content_container">
    <div class="video_cont">
        <video autoplay="true" id="video"></video>
        <div id="snap" class="capture">Snap</div>
        <div class="content">
            <?php
            require_once dirname(__FILE__).'/../model/snap.class.php';
            //$filters = get_filters();
            //foreach($filters as $filt)
             //   echo "<div class='content_item'><img id='filter_".$filt['id']."'
             //       class='filter' src='../model/filters/".$filt['path']."'/></div>"
            ?>
        </div>
    </div>
    <div class="side">
        <div class='user_gallery'>
            <?php
            require_once 'model/user.class.php';
            $snappy = new snap();
            $user = unserialize($_SESSION['user'])->get_id();
            $photos = $snappy->get_images($user, 1);
            foreach($photos as $key=>$phot)
                echo "<div id= 'item_".$key."' class='user_gallery_item'><img class='user_snap' id='user_snap_".$phot['id']."' src='../model/pics/".$phot['path']."'/></div>"
            ?>
        </div>
    </div>
</div>
<canvas id='canvas' style="display:none;"></canvas>
<script src="../controller/webcam.js"></script>
<script src="../controller/filters.js"></script>

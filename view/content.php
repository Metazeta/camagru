<?php
    if (!isset($_SESSION['user']) || $_SESSION['user'] === "")
        header("Location: ../login.php");
    require_once 'model/user.class.php';
    require_once 'model/snap.class.php';
    require_once 'model/filter.class.php';
    require_once 'model/pdo.class.php';
    $diag = new pdo_connection();
    if (!$diag->diagnose())
        header("Location: ../config/setup.php?reset=true");
?>
<div class="content_container">
    <div class="video_cont">
        <div id="upload_section"></div>
        <div id="videoandfilter">
            <img class='overlay' />
            <video autoplay='true' id="video"></video>
        </div>
        <button id="snap" class="capture" disabled>Snap</button>
        <div class="content">
            <?php
            $filters = new filter();
            $filters = $filters->get_filters();
            foreach($filters as $filt)
                echo "<div class='content_item'><img id='filter_".$filt['id']."'
                    class='filter' src='../model/filters/".$filt['path']."'/></div>"
            ?>
        </div>
    </div>
    <div class="side">
        <div class='user_gallery'>
            <?php
            $snappy = new snap();
            $user = unserialize($_SESSION['user'])->get_id();
            $photos = $snappy->get_images($user, 1);
            foreach($photos as $key=>$phot)
                echo "<div id= 'item_".$key."' class='user_gallery_item'><canvas class='user_snap' id='user_snap_".$phot['id']."' data-path='../model/pics/".$phot['path']."'/></div>"
            ?>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        [].forEach.call(document.getElementsByClassName("user_snap"), function(el) {
            var img = new Image();
            var context = el.getContext('2d');
            el.height = 220;
            img.width = el.width;
            img.src = el.dataset.path;
            img.onload = function() {
                context.drawImage(img,0,0, el.width, el.height);
            };
        })
    });
</script>
<canvas id='canvas' style="display:none;"></canvas>
<script src="view/webcam.js"></script>
<script src="view/filters.js"></script>

<div class="content_container">
    <div class="video_cont">
        <div id='filter'><img id="filter_img" src=""/></div>
        <video autoplay="true" id="video"></video>
        <canvas id="vid_canvas">
        </canvas>
        <div class="capture">Snap</div>
        <div class="content">
            <?php
            require_once dirname(__FILE__).'/../model/queries.php';
            $filters = get_filters();
            foreach($filters as $filt)
                echo "<div class='content_item'><img id='filter_".$filt['id']."' 
                    class='filter' src='../model/filters/".$filt['path']."'/></div>"
            ?>
        </div>
    </div>
    <div class="side">
        <div class='user_gallery'>
            <?php
            $photos = get_images(1);
            foreach($photos as $phot)
                echo "<div class='user_gallery_item'><img class='user_snap' src='../model/pics/".$phot['path']."'/></div>"
            ?>
        </div>
    </div>
</div>
<canvas id='canvas' style="display:none;"></canvas>
<script src="../controller/webcam.js"></script>
<script src="../controller/filters.js"></script>
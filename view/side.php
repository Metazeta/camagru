<div class="side">
    <canvas id='canvas' style="display:none;"></canvas>
    <div class='user_gallery'>
    <?php
    require_once dirname(__FILE__).'/../model/queries.php';
    $photos = get_images(1);
    foreach($photos as $phot)
        echo "<div class='user_gallery_item'><img class='user_snap' src='../model/pics/".$phot['path']."'/></div>"
    ?>
    </div>
</div>
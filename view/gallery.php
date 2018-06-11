<div class='gallery'>
    <?php
    require_once dirname(__FILE__).'/../model/queries.php';
    $photos = get_images(1);
    foreach($photos as $phot){
        $likes = count(get_likes($phot['id']));
        $comments = get_comments($phot['id']);
        echo
            "<div class='gallery_item'>
                <div class='gallery_head'> Snap taken at ".format_timestamp($phot['upload_time'])."</div>
                <img class='gallery_pic' src='../model/pics/".$phot['path']."'/>
            <div class='likebtn' id='like_".$phot['id']."'></div>
            <div class='likes'> ".$likes." fellow users liked this snap</div>
            <div class='comments'>";
            foreach ($comments as $com)
                echo "<div class='comment'>".$com['content']."</div>";
        echo
            "</div>
            <div class='comment_box'>
            <div class='comment_area'>
            <textarea placeholder='Add a comment...' class='add_comment' id='comment_".$phot['id']."'></textarea>
            </div>
            <div class='send_comment' id='addcomment_".$phot['id']."'>send</div>
            </div>
            </div>";
    }
    ?>
</div>
    <script src="../controller/likes.js"></script>
    <script src="../controller/comments.js"></script>

<div class='gallery'>
    <?php
    require_once dirname(__FILE__).'/../model/user.class.php';
    require_once dirname(__FILE__).'/../model/snap.class.php';
    require_once dirname(__FILE__).'/../model/comment.class.php';
    require_once dirname(__FILE__).'/../model/like.class.php';
    $page = 1;
    $o_snap = new snap();
    $o_like = new like();
    $o_comm = new comment();
    if (isset($_GET['page']))
        $page = $_GET['page'];
    $pagemin = $page == 1 ? $page : $page - 1;
    $pageplus = $page >= ($o_snap->count_images()[0][0] / 5) ? $page : $page + 1;
    echo "<div class='pagination'><a href='?page=".$pagemin."'>&larr;</a> <a href='?page=".$pageplus."'>&rarr;</a></div>";
    $photos = $o_snap->get_images(0, $page);
    foreach($photos as $phot){
        $likes = count($o_like->get_likes($phot['id']));
        $comments = $o_comm->get_comments($phot['id']);
        $login = new user('none');
        $login = $login->login_from_id($phot['user_id']);
        $user_id = 0;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user']) && $_SESSION['user'] != "")
            $user_id = unserialize($_SESSION['user'])->get_id();
        echo
            "<div class='gallery_item'>
                <div class='gallery_head'><img class='people' src='view/assets/people.png'/><p class='snap_title'>"
            .$login.
            "</p>snap taken at ".$o_snap->format_timestamp($phot['upload_time'])."</div>
                <img class='gallery_pic' src='../model/pics/".$phot['path']."'/>
            <div ";
            if ($user_id != 0 && $o_like->likes($user_id, $phot['id']) == FALSE)
                echo "class='likebtn likebtnnotliked'";
            else if ($user_id != 0)
                echo "class='likebtn likebtnliked'";
            else
                echo "class='likebtnguest'";
        echo "id='like_".$phot['id']."'></div>
            <div id='likect_".$phot['id']."' class='likes'> ".$likes." fellow users liked this snap</div>
            <div id='comments_".$phot['id']."' class='comments'>";
            foreach ($comments as $com)
                echo "<div class='comment'><b>".$com['login']."</b> ".$com['content']."</div>";
        echo "</div>";
        if (isset($_SESSION['user']) && $_SESSION['user'] != '')
        {
            echo "
            <div class='comment_box'>
            <div class='comment_area'>
            <textarea placeholder='Add a comment...' class='add_comment' id='comment_".$phot['id']."'></textarea>
            </div>
            <div class='send_comment' id='addcomment_".$phot['id']."'>send</div></div>";
        }
        echo "</div>";
    }
    echo "<div class='pagination'><a href='?page=".$pagemin."'>&larr;</a> <a href='?page=".$pageplus."'>&rarr;</a></div>";
    ?>
</div>
    <script src="../controller/likes.js"></script>
    <script src="../controller/comments.js"></script>

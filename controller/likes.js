
[].forEach.call(document.getElementsByClassName("likebtn"), function(el) {
    el.addEventListener("click", function() {
        register_like((el.id).replace("like_", ""));
    }, false);
});

function register_like($id)
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../controller/register_like.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("snap_id=" + $id);
    location.reload();
}
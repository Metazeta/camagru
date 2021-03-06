
[].forEach.call(document.getElementsByClassName("send_comment"), function(el) {
    el.addEventListener("click", function() {
        var id = (el.id).replace("addcomment_", "");
        register_comment(id,
            document.getElementById("comment_" + id).value);
        document.getElementById("comment_" + id).value = "";
    }, false);
});

function register_comment(id, text)
{
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE)
        {
            var newcomment = document.createElement("div");
            newcomment.innerHTML = xhr.responseText;
            newcomment.className = "comment";
            var el = document.getElementById("comments_" + id);
            el.insertBefore(newcomment,el.firstChild);
        }
    };
    xhr.open("POST", "../controller/register_comment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("snap_id=" + id + "&content=" + text);
}
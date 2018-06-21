
[].forEach.call(document.getElementsByClassName("likebtn"), function(el) {
    el.addEventListener("click", function() {
        register_like((el.id).replace("like_", ""));
    }, false);
});

function change_count(sentence, way)
{
    var arr = sentence.split(" ");
    if (way)
        arr[0] = parseInt(arr[0]) + 1;
    else
        arr[0] = arr[0] - 1;
    return (arr.join(' '));
}

function register_like(id)
{
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE)
    {
        var likebtn = document.getElementById("like_" + id);
        var likect = document.getElementById("likect_" + id);
        if (likebtn.className === "likebtn likebtnliked") {
            likebtn.className = "likebtn likebtnnotliked";
            $ct = change_count(likect.innerText, 0);
            likect.innerText = $ct;
        }
        else {
            likebtn.className = "likebtn likebtnliked";
            $ct = change_count(likect.innerText, 1);
            likect.innerText = $ct;
        }
    }
};
    xhr.open("POST", "../controller/register_like.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("snap_id=" + id);

}
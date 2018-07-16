[].forEach.call(document.getElementsByClassName("filter"), function(el) {
    el.addEventListener("click", function() {
        var id = (el.id).replace("filter_", "");
        var png = el.src;
        add_filter(id, png);
    }, false);
});

function add_filter(id, png)
{
    var img = document.getElementsByClassName("overlay")[0];
    img.src = png;
    img.id = 'filter_added_' + id;
    img.style.display = 'inline';
    document.getElementById('snap').disabled = false;
}
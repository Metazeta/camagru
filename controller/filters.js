[].forEach.call(document.getElementsByClassName("filter"), function(el) {
    el.addEventListener("click", function() {
        var id = (el.id).replace("filter_", "");
        var png = el.src;
        add_filter(id, png);
    }, false);
});

function getXYpos(elem)
{
    if (!elem)
    {
        return {"x":0,"y":0};
    }
    var xy={"x":elem.offsetLeft,"y":elem.offsetTop}
    var par=getXYpos(elem.offsetParent);
    for (var key in par)
    {
        xy[key]+=par[key];
    }
    return xy;
}

function add_filter(id, png)
{
    var img = document.getElementById("filter_img");
    //var img = document.createElement("img");
    img.src = png;
    //img.style.position = 'absolute';
    //var coord = getXYpos(vid);
    //img.style.left = coord['x'] + 'px';
    //img.style.top = coord['y'] + 'px';
    //document.getElementsByClassName('video_cont')[0].appendChild(img);
    console.log(png);
    //vid.drawImage(png);
}
/*
var new_el = document.createElement('img');
new_el.setAttribute('src', 'online.png');
new_el.setAttribute('id', 'photoStamp');
new_el.style.position = 'absolute';
var main_pic = document.getElementById('userAvatar');
var big_coordinates=getXYpos(main_pic);
var bp_x = big_coordinates['x'];
var bp_y = big_coordinates['y'];
new_el.style.left =  bp_x + 'px';
new_el.style.top = bp_y + 'px';
var container = document.getElementById('userAvatarContainer');
container.appendChild(new_el);
*/
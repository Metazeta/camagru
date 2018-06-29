(function() {

    navigator.getUserMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    if (navigator.getUserMedia) {
        navigator.getUserMedia(
            {
                video: true,
                audio: false
            },
            function (localMediaStream) {
                var video = document.getElementById('video');
                video.srcObject = localMediaStream;
            },
            function (err) {
                console.log("The following error occured: " + err);
            });
    } else {
        alert("getUserMedia not supported by your web browser or Operating system version");
    }

    function rotate_gallery()
    {
        var el = document.getElementsByClassName("user_gallery")[0];
        for (var i = 4; i >= 0; i--) {
            if (document.getElementById("item_" + i))
                document.getElementById("item_" + i).id = "item_" + (i + 1).toString();
        }
        if (document.getElementById("item_5"))
            document.getElementById("item_5").remove();
        var newpic = document.createElement("div");
        newpic.className = "user_gallery_item";
        var imginser = document.createElement("img");
        imginser.className = "user_snap";
        el.insertBefore(newpic, el.firstChild);
        newpic.appendChild(imginser);
        newpic.id = "item_0";
        return imginser;
    }

    function takepicture() {

        var canvas = document.getElementById('canvas');
        var video = document.getElementById('video');
        var width = video.videoWidth;
        var height = video.videoHeight;
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        var imginser = rotate_gallery();
        imginser.src = data;
        if (window.XMLHttpRequest) {
            var xh = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            var xh = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xh.open("POST", "controller/upload_snap.php", true);
        xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xh.send("snap=" + data);
    }

    document.getElementById("snap").addEventListener("click", function(ev){
        takepicture();
        ev.preventDefault();
    }, false);

    function delete_snap(id)
    {
        if (window.XMLHttpRequest) {
            var xh = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            var xh = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xh.open("POST", "controller/delete_snap.php", true);
        xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xh.send("snap_id=" + id);
    }

    [].forEach.call(document.getElementsByClassName("user_snap"), function(el) {
        el.addEventListener("click", function() {
            var id = (el.id).replace("user_snap_", "");
            delete_snap(id);
        }, false);
    });
})();
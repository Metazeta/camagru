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
                upload_form();
            });
    } else {
        alert("getUserMedia not supported by your web browser or Operating system version");
    }

    function upload_form(){
        var up_section = document.createElement('div');
        var up_label = document.createElement('div');
        var up_butn = document.createElement('input');
        up_section.append(up_label);
        up_section.append(up_butn);
        up_label.innerText = 'Select an image to use';
        up_butn.type = 'file';
        up_butn.accept = 'image/*';
        document.getElementsByClassName('video_cont')[0].insertBefore(up_section,
            document.getElementById('video'));
        up_butn.addEventListener('change', function(){
           var reader = new FileReader();
           reader.readAsDataURL(up_butn.files[0]);
           reader.addEventListener('load', function () {
               var newvid = document.createElement('img');
               document.getElementById('video').remove();
               newvid.src = reader.result;
               newvid.id = 'video';
               var videocont = document.getElementsByClassName('video_cont')[0];
               videocont.insertBefore(newvid, document.getElementById('snap'));
           });
        });
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
        var width = 0;
        var height = 0;
        if (video.nodeName === 'VIDEO'){
            width = video.videoWidth;
            height = video.videoHeight;
        }
        else {
            width = video.width;
            height = video.height;
        }
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        var imginser = rotate_gallery();
        imginser.src = data;
        var xh = null;
        if (window.XMLHttpRequest) {
            xh = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xh = new ActiveXObject("Microsoft.XMLHTTP");
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
        var xh = null;
        if (window.XMLHttpRequest) {
            xh = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xh = new ActiveXObject("Microsoft.XMLHTTP");
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

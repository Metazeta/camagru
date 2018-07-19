(function() {

    upload_form();
    get_vid();

    function get_vid(){
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
                function () {

                });
        } else {
            alert("getUserMedia not supported by your web browser or Operating system version");
        }
    }

    function upload_form(){
        var up_label = document.createElement('div');
        var up_butn = document.createElement('input');
        var vid_butn = document.createElement('input');
        var up_section = document.getElementById('upload_section');
        up_section.id = 'upload_section';
        up_section.append(up_label);
        up_section.append(up_butn);
        up_section.append(vid_butn);
        vid_butn.value = 'Use webcam';
        vid_butn.type = 'button';
        vid_butn.addEventListener('click', function(){
            var img = document.getElementById('video');
            if (img.nodeName === 'IMG'){
                img.remove();
                var newvid = document.createElement('video');
                newvid.id = 'video';
                newvid.autoplay = true;
                document.getElementById('videoandfilter').append(newvid);
                get_vid();
            }
        });
        up_label.innerText = 'Select an image to use';
        up_butn.type = 'file';
        up_butn.accept = 'image/*';
        up_butn.addEventListener('change', function(ev){
            if (up_butn.files[0] && /\.(jpe?g|png|gif)$/i.test(up_butn.files[0].name)) {
                var reader = new FileReader();
                reader.readAsDataURL(up_butn.files[0]);
                reader.addEventListener('load', function () {
                    if (reader.result === 'data:')
                        return false;
                    var newvid = document.createElement('img');
                    newvid.src = reader.result;
                    document.getElementById('video').remove();
                    newvid.id = 'video';
                    var videofilter = document.getElementById('videoandfilter');
                    videofilter.appendChild(newvid);
                }, false);
                reader.onloadend = function(){
                    var vid = document.getElementById('video');
                    if(vid.naturalHeight === 0 || vid.complete === false)
                        vid.src = '';
                };
            }
        });
    }

    function rotate_gallery(img)
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
        var imginser = document.createElement("canvas");
        imginser.className = "user_snap";
        el.insertBefore(newpic, el.firstChild);
        newpic.appendChild(imginser);
        newpic.id = "item_0";
        imginser.height = 220;
        imginser.getContext('2d').drawImage(img, 0, 0, imginser.width, imginser.height);
        var over = document.getElementsByClassName('overlay')[0];
        var filterid = over.id.split('_')[2];
        var filter = new Image();
        filter.src = document.getElementById('filter_' + filterid).src;
        imginser.getContext('2d').drawImage(filter, 0, 0, imginser.width, imginser.height);
    }

    function takepicture() {
        var filter_id = document.getElementsByClassName('overlay')[0].id;
        if (filter_id === "")
            return false;
        filter_id = filter_id.split('_')[2];
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
        if (height === 0 || width === 0)
            return false;
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var data = canvas.toDataURL('image/png');
        rotate_gallery(video);
        var xh = null;
        if (window.XMLHttpRequest) {
            xh = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xh = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xh.open("POST", "controller/upload_snap.php", true);
        xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xh.send("snap=" + data + "&filter_id=" + filter_id);
        return true;
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
            if (confirm('Do you want to remove this snap ?')){
                delete_snap(id);
                el.remove();
            }
        }, false);
    });
})();

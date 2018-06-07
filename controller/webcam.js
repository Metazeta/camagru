const video = document.getElementById("video");

document.getElementsByClassName("capture")[0].addEventListener("click", capture_cam);

function display_cam()
{
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

    if (navigator.getUserMedia) {
        navigator.getUserMedia({video: true}, handleVideo, videoError);
    }

    function handleVideo(stream) {
        video.srcObject = stream;
    }

    function videoError(e) {
    }
}

function capture_cam() {
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0);
    var data_url = canvas.toDataURL();
    var xhr = new XMLHttpRequest();
    document.getElementsByClassName("capture")[0].innerHTML="Uploading, please wait...";
    xhr.open("POST", "../controller/upload_snap.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send('snap=' + data_url);
    document.getElementsByClassName("capture")[0].innerHTML="Snap";
    location.reload();
}

display_cam();

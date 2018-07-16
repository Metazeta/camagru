[].forEach.call(document.getElementsByClassName("gallery_pic"), function(el) {
    el.addEventListener("contextmenu", function(ev) {
        ev.preventDefault();
        if (el.id === 'pic_mine')
            if (confirm('Do you want to remove this snap?'))
            {
                el.parentElement.remove();
                var id = el.nextElementSibling.id.split('_')[1];
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../controller/delete_snap.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("snap_id=" + id);
            }
        return false;
    }, false);
});
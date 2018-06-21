document.getElementById("password").addEventListener('click', function(ev){
    var el = document.getElementById("account_content");
    el.innerHTML =
        "<div>" +
        "<div>Initial Password</div>"+
        "<div><input type='password' id='initial_pass'/></div>" +
        "<div>New Password</div>"+
        "<div><input type='password' id='new_pass1'/></div>" +
        "<div>Retype Password</div>"+
        "<div><input type='password' id='new_pass2'/></div>" +
        "</div>";
});

document.getElementById("settings").addEventListener('click', function(ev){
    var el = document.getElementById("account_content");
    el.innerHTML =
        "<div>" +
        "</div>";
});
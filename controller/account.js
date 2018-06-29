// Change password panel
document.getElementById("password").addEventListener('click', function(ev){
    var el = document.getElementById("account_content");
    el.className="password_form";
    el.innerHTML =
        "<div id='hint'></div>" +
        "<div>Current password</div>"+
        "<div><input type='password' id='initial_pass'/></div>" +
        "<div>New password</div>"+
        "<div><input type='password' id='new_pass1'/></div>" +
        "<div>Retype password</div>"+
        "<div><input type='password' id='new_pass2'/></div>" +
        "<input id='password_confirm' type='submit' value='Confirm'/>";
        document.getElementById("password_confirm").addEventListener('click', function (ev) {
            xh = new XMLHttpRequest();
            xh.onreadystatechange = function() {
                if (xh.readyState === 4) {
                    if (xh.response !== false)
                        document.getElementById("hint").innerText = "Your new password was set successfully";
                }
            };
            xh.open("POST", "../controller/update_passwd.php", true);
            xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xh.send("oldpwd=" + document.getElementById("initial_pass").value +
                "&newpwd=" + document.getElementById("new_pass1").value);
        });
    document.getElementById("password_confirm").disabled = true;
    document.getElementById('new_pass1').addEventListener('keyup', function(ev) {
        var hint = document.getElementById('hint');
        var val1 = document.getElementById('new_pass1').value;
        var val2 = document.getElementById('new_pass2').value;
        var res = check_form(val1, val2);
        hint.innerText = res;
        document.getElementById("password_confirm").disabled = res !== "";
    }, false);
    document.getElementById('new_pass2').addEventListener('keyup', function(ev) {
        var hint = document.getElementById('hint');
        var val1 = document.getElementById('new_pass1').value;
        var val2 = document.getElementById('new_pass2').value;
        var res = check_form(val1, val2);
        hint.innerText = res;
        document.getElementById("password_confirm").disabled = res !== "";
        }, false);
}, false);

function check_form(pass1, pass2)
{
    var validity = password_validity(pass1);
    if (validity !== "")
        return validity;
    if (pass1 !== pass2)
        return "Passwords must match";
    return "";
}
//--------------------------------------------------------------------------
// Delete account
document.getElementById("delete").addEventListener('click', function(ev){
    var el = document.getElementById("account_content");
    el.className = "delete_form";
    el.innerHTML =
        "<div id='info_delete'></div>" +
        "<div>Password</div>" +
        "<div><input type='password' id='initial_pass'/></div>" +
        "<input id='delete_confirm' type='submit' value='Delete'/>";
    document.getElementById("info_delete").innerText = "Delete your account and all your snaps";
    document.getElementById("delete_confirm").addEventListener('click', function (ev) {
        xh = new XMLHttpRequest();
        xh.onreadystatechange = function() {
            if (xh.readyState === 4) {
                if (xh.response !== false)
                    document.getElementById("info_delete").innerText = "Your account was successfully deleted";
            }
        };
        xh.open("POST", "../controller/delete_account.php", true);
        xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xh.send("passwd=" + document.getElementById("initial_pass").value);
    });
});

//--------------------------------------------------------------------------
// Setting panel
document.getElementById("settings").addEventListener('click', function(ev){
    var el = document.getElementById("account_content");
    el.className = "settings";
    el.innerHTML =
        "<label class='switch'>" +
        "<input type='checkbox'>" +
        "<span class='slider'></span>" +
        "</label>";
});
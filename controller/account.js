// Change login panel
document.getElementById("change_login").addEventListener('click', function(ev){
    var el = document.getElementById("account_content");
    el.className="password_form";
    el.innerHTML =
        "<div id='hint'></div>" +
        "<div class='inputlabel'>New login</div>"+
        "<div><input class='textinput' type='text' id='new_pass1'/></div>" +
        "<div class='inputlabel'>Password</div>"+
        "<div><input class='textinput' type='password' id='initial_pass'/></div>" +
        "<input id='password_confirm' type='submit' value='Confirm'/>";
});
// Change password panel
document.getElementById("password").addEventListener('click', function(ev){
    var el = document.getElementById("account_content");
    el.className="password_form";
    el.innerHTML =
        "<div id='hint'></div>" +
        "<div class='inputlabel'>Current password</div>"+
        "<div><input class='textinput' type='password' id='initial_pass'/></div>" +
        "<div class='inputlabel'>New password</div>"+
        "<div><input class='textinput' type='password' id='new_pass1'/></div>" +
        "<div class='inputlabel'>Retype password</div>"+
        "<div><input class='textinput' type='password' id='new_pass2'/></div>" +
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
        "<div><input class='textinput' type='password' id='initial_pass'/></div>" +
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
      "<div class='setting_list'> Receive an email when a user likes or comments my snaps" +
      "<label class='switch'>" +
      "<input type='checkbox' id='suscribe'>" +
      "<span class='slider'></span>" +
      "</label>" +
      "</div>";
    let state = 0;
    xh = new XMLHttpRequest();
    xh.onreadystatechange = function() {
    if (xh.readyState === 4)
    {
            state = xh.response;
            document.getElementById('suscribe').checked = (state === '1');
            document.getElementById('suscribe').addEventListener('click', function(ev){
            xh2 = new XMLHttpRequest();
            xh2.onreadystatechange = function() {
                if (xh2.readyState === 4)
                  console.log(xh2.response);
              }
            xh2.open("POST", "../controller/get_settings.php", true);
            xh2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            state = ((parseInt(state) + 1) % 2);
            xh2.send("set=true&state=" + state);
      });
    }
  }
    xh.open("POST", "../controller/get_settings.php", true);
    xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xh.send();
});

document.getElementById('new_pass1').addEventListener('keyup', function(ev) {
    var hint = document.getElementById('hint');
    var pass = document.getElementById('new_pass1').value;
    var mail = document.getElementById('email').value;
    var error = check_form(pass, mail);
    hint.innerText = error;
    document.getElementById("registersubmit").disabled = error !== "";
    }, false);

document.getElementById('email').addEventListener('keyup', function(ev) {
    var hint = document.getElementById('hint');
    var pass = document.getElementById('new_pass1').value;
    var mail = document.getElementById('email').value;
    var error = check_form(pass, mail);
    hint.innerText = error;
    document.getElementById("registersubmit").disabled = error !== "";
}, false);

function check_form(pass, email)
{
    var pass_error = password_validity(pass);
    var mail_error = mail_validity(email);
    if (pass_error !== "")
        return pass_error;
    if (mail_error !== "")
        return mail_error;
    return "";
}

document.getElementById("registersubmit").disabled = true;
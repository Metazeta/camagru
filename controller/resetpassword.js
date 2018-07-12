document.getElementById("password_reset").disabled = true;

document.getElementById('new_pass1').addEventListener('keyup', function() {
    var hint = document.getElementById('hint');
    var val1 = document.getElementById('new_pass1').value;
    var val2 = document.getElementById('new_pass2').value;
    var res = check_form(val1, val2);
    hint.innerText = res;
    document.getElementById("password_reset").disabled = res !== "";
}, false);

document.getElementById('new_pass2').addEventListener('keyup', function() {
    var hint = document.getElementById('hint');
    var val1 = document.getElementById('new_pass1').value;
    var val2 = document.getElementById('new_pass2').value;
    var res = check_form(val1, val2);
    hint.innerText = res;
    document.getElementById("password_reset").disabled = res !== "";
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
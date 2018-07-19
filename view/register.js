document.getElementById('new_pass1').addEventListener('keyup', function(ev) {
    var hint = document.getElementById('hint');
    var login = document.getElementById('login').value;
    var pass = document.getElementById('new_pass1').value;
    var mail = document.getElementById('email').value;
    var error = check_form(login, pass, mail);
    if (error === "" && (login === "" || pass === "" || mail === ""))
        error = "Please fill all the fields";
    hint.innerText = error;
    document.getElementById("registersubmit").disabled = error !== "";
    }, false);

document.getElementById('email').addEventListener('keyup', function(ev) {
    var hint = document.getElementById('hint');
    var login = document.getElementById('login').value;
    var pass = document.getElementById('new_pass1').value;
    var mail = document.getElementById('email').value;
    var error = check_form(login, pass, mail);
    if (error === "" && (login === "" || pass === "" || mail === ""))
        error = "Please fill all the fields";
    hint.innerText = error;
    document.getElementById("registersubmit").disabled = error !== "";
}, false);

document.getElementById('login').addEventListener('keyup', function(ev) {
    var hint = document.getElementById('hint');
    var login = document.getElementById('login').value;
    var pass = document.getElementById('new_pass1').value;
    var mail = document.getElementById('email').value;
    var error = check_form(login, pass, mail);
    if (error === "" && (login === "" || pass === "" || mail === ""))
        error = "Please fill all the fields";
    hint.innerText = error;
    document.getElementById("registersubmit").disabled = error !== "";
}, false);

document.getElementById("registersubmit").disabled = true;
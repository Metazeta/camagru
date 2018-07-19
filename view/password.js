function password_validity(password)
{
    if (password.length < 8)
        return "Password is too short";
    var upper = password.match(/[A-Z]/) ? password.match(/[A-Z]/).length : 0;
    var lower = password.match(/[a-z]/) ? password.match(/[a-z]/).length : 0;
    var number = password.match(/[1-9]/g) ? password.match(/[1-9]/).length : 0;
    if (upper === 0)
        return "Password must contain an uppercase letter";
    if (lower === 0)
        return "Password must contain a lowercase letter";
    if (number === 0)
        return "Password must contain a number";
    if (isAlphaNumeric(password) === true)
        return "Password must contain a symbol";
    else
        return "";
}

function mail_validity(email)
{
    if (/[^\s@]+@[^\s@]+\.[^\s@]+/.test(email))
        return "";
    return "Email invalid";
}

function isAlphaNumeric(str) {
    var code, i, len;

    for (i = 0, len = str.length; i < len; i++) {
        code = str.charCodeAt(i);
        if (!(code > 47 && code < 58) &&
            !(code > 64 && code < 91) &&
            !(code > 96 && code < 123)) {
            return false;
        }
    }
    return true;
}

function login_validity(login)
{
    if (!isAlphaNumeric(login))
        return "Your login must be alphanumeric";
    return "";
}


function check_form(login, pass, email)
{
    var pass_error = password_validity(pass);
    var mail_error = mail_validity(email);
    var login_error = login_validity(login);
    if (login_error !== "" && login !== "")
        return login_error;
    if (pass_error !== "" && pass !== "")
        return pass_error;
    if (mail_error !== "" && email !== "")
        return mail_error;
    return "";
}
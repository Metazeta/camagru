function password_validity(password)
{
    if (password.length < 8)
        return "Password is too short";
    var upper = password.match(/[A-Z]/) ? password.match(/[A-Z]/).length : 0;
    var lower = password.match(/[a-z]/) ? password.match(/[a-z]/).length : 0;
    var number = password.match(/[1-9]/g) ? password.match(/[1-9]/).length : 0;
    var others = password.length - upper - lower - number;
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
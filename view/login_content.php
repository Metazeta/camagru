<?php
?>
<div class="loginbody">
<form class="loginform" method="POST" action="../controller/logme.php">
    <p class="loginlabel">Login</p>
    <input placeholder='login' class='loginitem' type="text" name="login"/>
    <p class="loginlabel">Password</p>
    <input placeholder='password' class='loginitem' type="password" name="passwd" id="new_pass1"/>
    <input id='submit' type="submit" value="Login">
    <a id='forgot' href='../reset.php'>Mot de passe oublié ?</a>
</form>
</div>

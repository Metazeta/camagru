<div class="registerbody">
<form class="registerform" method="POST" action="../controller/registerme.php">
    <p id="hint"></p>
    <p class="registerlabel">Login</p>
    <input placeholder='login' class='registeritem' type="text" name="login"/>
    <p class="registerlabel">Password</p>
    <input placeholder='password' class='registeritem' type="password" name="passwd" id="new_pass1"/>
    <p class="registerlabel">Email</p>
    <input placeholder='Email address' class='registeritem' type="text" name="email" id="email"/>
    <input id='registersubmit' type="submit" value="Register">
</form>
</div>
<script src="../view/password.js"></script>
<script src="../view/register.js"></script>
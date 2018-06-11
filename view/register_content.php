<div class="registerbody">
    <?php
    if (isset($_GET["tooshort"]) && $_GET["tooshort"] == "true")
        echo "<p>This password is too short (minimum 4 characters)</p>";
    ?>
<form class="registerform" method="POST" action="../controller/registerme.php">
    <p class="registerlabel">Login</p>
    <input placeholder='login' class='registeritem' type="text" name="login"/>
    <p class="registerlabel">Password</p>
    <input placeholder='password' class='registeritem' type="password" name="passwd"/>
    <p class="registerlabel">Email</p>
    <input placeholder='Email address' class='registeritem' type="text" name="email"/>
    <input id='registersubmit' type="submit" value="Register">
</form>
</div>

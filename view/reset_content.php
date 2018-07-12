<?php
require_once("model/user.class.php");

if (!isset($_GET['confirm'])){
    ?>
    <div class="resetbody">
        <form class="resetform" method="POST" action="../controller/handle_reset.php">
            <p class="loginlabel">Login</p>
            <input placeholder='login' class='loginitem' type="text" name="login"/>
            <input id='submit' type="submit" value="Reset">
        </form>
    </div>
    <?php
}
else
    {
        $user = new user("");
        $res = $user->exists_confirm($_GET['confirm']);
        if ($_GET['confirm'] !== '' && $res){
            ?>
            <form class="resetpwdform" method="POST" action="../controller/handle_reset.php">
                <div id='hint'></div>
                <div class='loginlabel'>New password</div>
                <div><input class='textinput' type='password' id='new_pass1' name='new_pass1'/></div>
                <div class='loginlabel'>Retype password</div>
                <div><input class='textinput' type='password' id='new_pass2' name='new_pass2'/></div>
                <input type="hidden" name="confirm_value" value="<?php echo $_GET['confirm'];?>"/>
                <input id='password_reset' type='submit' value='Confirm'/>
            </form>
            <script type="text/javascript" src="../controller/password.js"></script>
            <script type="text/javascript" src="../controller/resetpassword.js"></script>
        <?php
        }
        else{
            echo "<div class='confirm'>This confirmation ID is wrong.</div>";
        }
}
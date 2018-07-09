<?php
    if (!isset($_SESSION['user']))
        header("Location: ../index.php");
?>

<div class="account">
<div class="account_nav">
  <div id="change_email" class="account_item">change<br>email</div>
    <div id="change_login" class="account_item">change<br>login</div>
    <div id="password" class="account_item">change<br>password</div>
    <div id="settings" class="account_item">settings</div>
    <div id="delete" class="account_item">delete<br>account</div>
</div>

<div class='account_container'>
    <div id="account_content">
    </div>
</div>
</div>
<script src="../controller/account.js"></script>
<script src="../controller/password.js"></script>

<?php
$sActive = 'Signup';
require_once(__DIR__.'/top-not-signedin.php');

?>

<form id="signupForm" class="signupForm" method="POST">
    <div>Enter email (e.g. name@mail.com)</div>
    <input name = "txtEmail" type="text" data-type ="email" maxlength="100">
    <div>Enter name (2 to 20 characters)</div>
    <input name = "txtName" type="text" data-type ="string" minlength="2" maxlength="20" data-min="2" data-max="20">
    <div>Enter last name (2 to 20 characters)</div>
    <input name = "txtLastName" type="text" data-type ="string" minlength="2" maxlength="20" data-min="2" data-max="20">
    <div>Enter password (10 to 50 characters)</div>
    <input name = "txtPassword" type="password" data-type ="string" minlength="10" maxlength="50" data-min="10" data-max="50">
    <button id="signup_button_user" onclick="return signup(this);" data-start="SIGN UP AS A USER" data-wait="WAIT ...">SIGN UP AS A USER</button>
</form>
<!-- <div id="error_message_user">
    
</div> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="validate.js"></script>
<script src="app.js"></script>

<?php
require_once(__DIR__.'/bottom.php');
?>

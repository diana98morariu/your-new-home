<?php
$sActive = 'Login';
require_once(__DIR__.'/top-not-signedin.php');
?>

<?php
session_start();
if($_SESSION){
    header('Location: profile.php');
}

if($_POST){
    if(empty($_POST['email'])){
        displayPage();
    }
    if(empty($_POST['password'])){
        displayPage();
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        displayPage();
    }
    if(strlen($_POST['password']) < 10 || strlen($_POST['password']) > 50){
        displayPage();
    }
    $sjUser = file_get_contents(__DIR__.'/users.json');
    $jUsers = json_decode($sjUser);
    $sjAgents = file_get_contents(__DIR__.'/agents.json');
    $jAgents = json_decode($sjAgents);
        
    foreach($jUsers as $jUser){
        if($jUser->email == $_POST['email'] && $jUser->password == $_POST['password']){
            $_SESSION['jUser'] = $jUser;
            header('Location: profile.php');
        }
    }
    foreach($jAgents as $jAgent){
        if($jAgent->email == $_POST['email'] && $jAgent->password == $_POST['password']){
            $_SESSION['jAgent'] = $jAgent;
            header('Location: profile.php');
        }
    }
}
?>


<?php
function displayPage(){
?>

<?php
$sActive = 'Login';
require_once(__DIR__.'/top-not-signedin.php');
?>
<form id="loginForm" class="loginForm" method="POST">
    <div>Enter email (e.g. name@mail.com)</div>
    <input name="email" class="" type="text" maxlength="100" data-type="email">
    <div>Enter password (10 to 20 characters)</div>
    <input name="password" type="password" minlength="10" maxlength="20" data-type="string" data-min="10" data-max="20">
    <button id="login_button" onclick="return login(this);" data-start="LOGIN" data-wait="WAIT ...">LOGIN</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="validate.js"></script>
<script src="login.js"></script>


<?php
require_once(__DIR__.'/bottom.php');
?>

<?php
exit;
}
?>





<form id="loginForm" class="loginForm" method="POST">
    <div>Enter email (e.g. name@mail.com)</div>
    <input name="email" class="" type="text" maxlength="100" data-type="email">
    <div>Enter password (10 to 20 characters)</div>
    <input name="password" type="password" minlength="10" maxlength="50" data-type="string" data-min="10" data-max="50">
    <button id="login_button" onclick="return login(this);" data-start="LOGIN" data-wait="WAIT ...">LOGIN</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="validate.js"></script>
<script src="login.js"></script>


<?php
require_once(__DIR__.'/bottom.php');
?>
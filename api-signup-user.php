<?php
if($_POST){
    if (empty( $_POST['txtEmail'] )) {
        sendErrorMessage('Email is missing', __LINE__ );
    }
    if (!filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL)){               // validate email
        sendErrorMessage('Email is not valid', __LINE__ );
    }
    if (empty( $_POST['txtName'] )) {
        sendErrorMessage('Name is missing', __LINE__ );
    }
    if(strlen($_POST['txtName']) < 2 || strlen($_POST['txtName']) > 20) {
        sendErrorMessage('Name - Min 2 max 20 characters', __LINE__ );
    }
    if (empty( $_POST['txtLastName'] )) {
        sendErrorMessage('Last name is missing', __LINE__ );
    }
    if(strlen($_POST['txtLastName']) < 2 || strlen($_POST['txtLastName']) > 20) {
        sendErrorMessage('Last name - Min 2 max 20 characters', __LINE__ );
    }
    if (empty( $_POST['txtPassword'] )) {
        sendErrorMessage('Password is missing', __LINE__ );
    }
    if(strlen($_POST['txtPassword']) < 10 || strlen($_POST['txtPassword']) > 50) {
        sendErrorMessage('Password - Min 2 max 20 characters', __LINE__ );
    }
}
$sEmail = $_POST ['txtEmail'];
$sName = $_POST ['txtName'];
$sLastName = $_POST ['txtLastName'];
$sPassword = $_POST ['txtPassword'];

$jUser = new stdClass();
$jUser->name = $sName;
$jUser->lastname = $sLastName;
$jUser->email = $sEmail;
$jUser->password = $sPassword;
$jUser->image = "";


$sUserUniqueId = uniqid();
$sjData = file_get_contents(__DIR__.'/users.json');
$jData = json_decode($sjData);
$jData->$sUserUniqueId = $jUser;
$jUser->id = $sUserUniqueId;
$sjData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents(__DIR__.'/users.json', $sjData );





echo '{"status": 1, "message":"user added", "line":"'.__LINE__.'"}';


function sendErrorMessage($sErrorMessage, $iLineNumber){
    echo '{"status": 0, "message":"'.$sErrorMessage.'", "line": '.$iLineNumber.'}';
    exit;
}
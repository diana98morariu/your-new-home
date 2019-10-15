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
        sendErrorMessage('Last Name is missing', __LINE__ );
    }
    if(strlen($_POST['txtLastName']) < 2 || strlen($_POST['txtLastName']) > 20) {
        sendErrorMessage('Last Name - Min 2 max 20 characters', __LINE__ );
    }
    if (empty( $_POST['txtPassword'] )) {
        sendErrorMessage('Password is missing', __LINE__ );
    }
    if(strlen($_POST['txtPassword']) < 10 || strlen($_POST['txtPassword']) > 50) {
        sendErrorMessage('Password - Min 10 max 50 characters', __LINE__ );
    }
}

$sEmail = $_POST ['txtEmail'];
$sName = $_POST ['txtName'];
$sLastName = $_POST ['txtLastName'];
$sPassword = $_POST ['txtPassword'];

$jAgent = new stdClass();
$jAgent->name = $sName;
$jAgent->lastname = $sLastName;
$jAgent->email = $sEmail;
$jAgent->password = $sPassword;
$jAgent->properties = new stdClass();
$jAgent->image = "";

$sAgentUniqueId = uniqid();
$sjData = file_get_contents(__DIR__.'/agents.json');
$jData = json_decode($sjData);
$jData->$sAgentUniqueId = $jAgent;
$jAgent->id = $sAgentUniqueId;
$sjData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents(__DIR__.'/agents.json', $sjData );





echo '{"status": 1, "message":"agent added", "line":"'.__LINE__.'"}';


function sendErrorMessage($sErrorMessage, $iLineNumber){
    echo '{"status": 0, "message":"'.$sErrorMessage.'", "line": '.$iLineNumber.'}';
    exit;
}
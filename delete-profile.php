<?php
session_start();

if(isset($_SESSION['jUser'])){
    $userSessionId = $_SESSION['jUser'];
    $sUserId = $userSessionId->id;
    $sjUsers = file_get_contents(__DIR__.'/users.json');
    $jUsers =json_decode($sjUsers);
    unset($jUsers->$sUserId);
    $sjUsers = json_encode($jUsers, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__.'/users.json', $sjUsers);
    session_destroy(); //MUST HAVE
    header('Location:frontpage.php');
}else if($_SESSION['jAgent']){
    $agentSessionId = $_SESSION['jAgent'];
    $sAgentId = $agentSessionId->id;
    $sjAgents = file_get_contents(__DIR__.'/agents.json');
    $jAgents =json_decode($sjAgents);
    unset($jAgents->$sAgentId);
    $sjAgents = json_encode($jAgents, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__.'/agents.json', $sjAgents);
    session_destroy(); //MUST HAVE
    header('Location:frontpage.php');
}













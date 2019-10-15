<?php
session_start();
$agentSessionId = $_SESSION['jAgent'];
$sAgentId = $agentSessionId->id;
$sPropertyUniqueId = $_POST['id'];
$sUniqueImageId = $_POST['path'];
$sjData = file_get_contents(__DIR__.'/agents.json');
$jData = json_decode($sjData);
unset($jData->$sAgentId->properties->$sPropertyUniqueId);
unlink(__DIR__.'/images/'.$sUniqueImageId);
//echo json_encode($jProperties);
// above spawns valid json (of course it is really text)
$sjData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents(__DIR__.'/agents.json',$sjData);
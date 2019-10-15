<?php
session_start();
$extension = pathinfo($_FILES['image']['name'])['extension'];

$sUniqueImageName = uniqid().'.'.$extension;
$location ='./images/'.$sUniqueImageName;
move_uploaded_file($_FILES['image']['tmp_name'], $location);
echo '<img src="'.$location.'" height="150px" width="225px" class="image-thumbnail"/>';

if(isset($_SESSION['jUser'])){
    $sjUsers = file_get_contents(__DIR__.'/users.json');
    $jUsers = json_decode($sjUsers);
    $sUserUniqueID = $_SESSION['jUser'];
    $userId = $sUserUniqueID->id;
    $jUsers->$userId->image = $sUniqueImageName;
    $sjUsers = json_encode($jUsers, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__.'/users.json', $sjUsers);
    
} else if(isset($_SESSION['jAgent'])) {
    $sjAgents = file_get_contents(__DIR__.'/agents.json');
    $jAgents = json_decode($sjAgents);
    $sAgentUniqueID = $_SESSION['jAgent'];
    $agentId = $sAgentUniqueID->id;
    $jAgents->$agentId->image = $sUniqueImageName;
    $sjAgents = json_encode($jAgents, JSON_PRETTY_PRINT);
    file_put_contents(__DIR__.'/agents.json', $sjAgents );
}
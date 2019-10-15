<?php

$sAgentId = $_POST['id'];
$sKeyToUpdate = $_POST['key'];
$sNewValue = $_POST['value'];
$sjData = file_get_contents(__DIR__.'/agents.json');
$jData = json_decode($sjData);

$jData->$sAgentId->$sKeyToUpdate = $sNewValue;

$sjData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents(__DIR__.'/agents.json', $sjData);
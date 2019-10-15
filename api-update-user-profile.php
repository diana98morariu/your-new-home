<?php

$sUserId = $_POST['id'];
$sKeyToUpdate = $_POST['key'];
$sNewValue = $_POST['value'];
$sjData = file_get_contents(__DIR__.'/users.json');
$jData = json_decode($sjData);

$jData->$sUserId->$sKeyToUpdate = $sNewValue;

$sjData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents(__DIR__.'/users.json', $sjData);
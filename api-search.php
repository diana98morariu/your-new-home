<?php

//Thinks that 0 is empty



if(!isset($_GET['search'])){
    echo '[]';
    exit;
}
$sSearchFor = $_GET['search']; //The user's input
$sjAgents = file_get_contents('agents.json');
$jAgents = json_decode($sjAgents);
$matches =[];

foreach($jAgents as $jAgent){
// $ZipCodes = $jAgent->properties->zipcode;
$jProperties =$jAgent->properties;
    foreach($jProperties as $jProperty){
        // $matches = $jProperty->zipcode;
        if(strpos( $jProperty->zipcode, $sSearchFor ) !== false && !in_array($jProperty->zipcode, $matches)){ 
            array_push($matches, $jProperty->zipcode);
            
        }
        // $matches[$jProperty->zipcode] = $jProperty;
        // echo $matches;
        
        
    }
}
echo json_encode($matches);


// if(in_array($sSearchFor, $aZipCodes)){
//     echo 'Match';
// } else {
//     echo 'not found';
// }
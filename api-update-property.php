<?php

session_start();
// $agentSessionId = $_SESSION['jAgent'];
// $sAgentId = $agentSessionId->id;
// $sPropertyUniqueId = $_POST['id'];
// $jNewPrice = $_POST['price'];
// $jNewBathrooms = $_POST['bathrooms'];
// $jNewBedrooms = $_POST['bedrooms'];
// $jNewSurface = $_POST['surface'];
// $jNewAddress = $_POST['address'];
// $jNewZip = $_POST['zipcode'];
// $sjData = file_get_contents(_DIR_.'/agents.json');
// $jData = json_decode($sjData);


    // if(empty( $_POST['price'])){
    //     sendErrorMessage('price is missing',__LINE__);

    // }
    
    // if( !ctype_digit( $_POST['price'] ) ){
    //     sendErrorMessage('price can only be numbers',__LINE__);
  
    // }
    
    // if( $_POST['price'] < 1 ){
    //     sendErrorMessage('price is too low',__LINE__);

    // }
    
    // if( $_POST['price'] > 999999999 ){
    //     sendErrorMessage('price is too big',__LINE__);

    // }
    // if( $_POST['bathrooms'] < 1 ){
    //     sendErrorMessage('needs at least one bathrooms',__LINE__);
    
    // }
    // if( $_POST['bathrooms'] > 999999999 ){
    //     sendErrorMessage('too many bathrooms',__LINE__);

    // }
    // if( $_POST['bedrooms'] < 1 ){
    //     sendErrorMessage('needs at least one bedrooms',__LINE__);
    
    // }
    // if( $_POST['bedrooms'] > 999999999 ){
    //     sendErrorMessage('too many bedrooms',__LINE__);

    // }
    // if( $_POST['surface'] < 1 ){
    //     sendErrorMessage('too little surface',__LINE__);
    
    // }
    // if( $_POST['surface'] > 999999999 ){
    //     sendErrorMessage('too much surface',__LINE__);

    // }
    // if( empty($_POST['address'])){
    //     sendErrorMessage('address too short',__LINE__);
    
    // }
    // if( strlen($_POST['zipcode']) < 3 ){
    //     sendErrorMessage('zipcode is too small',__LINE__);
    
    // }
    // if( strlen($_POST['zipcode']) > 10 ){
    //     sendErrorMessage('zipcode is too big',__LINE__);
    // }

    addNewInfo();
        
    function addNewInfo(){
        $agentSessionId = $_SESSION['jAgent'];
        $sAgentId = $agentSessionId->id;
        $sPropertyUniqueId = $_POST['id'];
        $sKeyToUpdate = $_POST['key'];
        $sNewValue = $_POST['value'];
        $sjData = file_get_contents(__DIR__.'/agents.json');
        $jData = json_decode($sjData);
        $jData->$sAgentId->properties->$sPropertyUniqueId->$sKeyToUpdate = $sNewValue;
        // $sjProperties = json_encode($jProperties, JSON_PRETTY_PRINT);
        // file_put_contents(_DIR_.'/prop.json', $sjProperties);
        $sjData = json_encode($jData, JSON_PRETTY_PRINT);
        file_put_contents(__DIR__.'/agents.json', $sjData);
        
        $strObj = '{"status":1, "message":"Correcto"}';
        $obj = json_decode($strObj);
        $obj->newProperty = $jData->$sAgentId->properties->$sPropertyUniqueId;

        echo json_encode($obj);

        
    };

function sendErrorMessage($sErrorMessage, $iLineNumber){
    echo '{"status":0, "message":"'.$sErrorMessage.'", "line":'.$iLineNumber.'}';
    exit;

}
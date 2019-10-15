<?php

//PATHINFO
session_start();



if ($_FILES){

    if(empty( $_POST['txtPrice'])){
        sendErrorMessage('price is missing',__LINE__);
    }
    
    if( !ctype_digit( $_POST['txtPrice'] ) ){
        sendErrorMessage('price can only be numbers',__LINE__);
    }
    
    if( $_POST['txtPrice'] < 1 ){
        sendErrorMessage('price is too low',__LINE__);
    
    }
    if( $_POST['txtPrice'] > 999999999 ){
        sendErrorMessage('price is too big',__LINE__);
    }
    if( $_POST['txtBathrooms'] < 1 ){
        sendErrorMessage('needs at least one bathrooms',__LINE__);
    
    }
    if( $_POST['txtBathrooms'] > 999999999 ){
        sendErrorMessage('too many bathrooms',__LINE__);

    }
    if( $_POST['txtBedrooms'] < 1 ){
        sendErrorMessage('needs at least one bedrooms',__LINE__);
    
    }
    if( $_POST['txtBedrooms'] > 999999999 ){
        sendErrorMessage('too many bedrooms',__LINE__);
    }
    if( $_POST['txtSurface'] < 1 ){
        sendErrorMessage('surface area is too small',__LINE__);
    
    }
    if( $_POST['txtSurface'] > 3000 ){
        sendErrorMessage('surface area is too big',__LINE__);
    }
    if(empty( $_POST['txtAddress'])){
        sendErrorMessage('address is missing',__LINE__);
    
    }
    // if(empty( $_POST['txtZipcode'])){
    //     sendErrorMessage('zip is missing',__LINE__);
    
    // }
    // if( $_POST['txtZipcode'] < 3 ){
    //     sendErrorMessage('zipcode is too small',__LINE__);
    
    // }
    // if( $_POST['txtZipcode'] > 10 ){
    //     sendErrorMessage('zipcode area is too big',__LINE__);
    // }
    
    if(!isset($_FILES['myFile'])){
        sendErrorMessage('myFile is missing', __LINE__);
    }
    $sExtension = $_FILES['myFile']['type'];
    $sExtension = strtolower($sExtension);
    $aExtensionsAllowed = array('image/jpeg', 'image/gif', 'image/png', 'image/jpg');
    if (!in_array($sExtension, $aExtensionsAllowed)) {
        sendErrorMessage('file must be png, jpg, jpeg or gif.',__LINE__); 
    }
    if($_FILES['myFile']['size'] < 20480){ //bytes
        sendErrorMessage('file is too small.',__LINE__);
    }
    if($_FILES['myFile']['size'] > 5242880){
        sendErrorMessage('file is too large.',__LINE__);
    }else {
        
            $extension = pathinfo($_FILES['myFile']['name'])['extension'];
            $sUniqueImageName = uniqid() . '.' . $extension;
            move_uploaded_file( $_FILES['myFile']['tmp_name'], __DIR__."/images/$sUniqueImageName" );

            $sPrice = $_POST['txtPrice']; 
            $sBathrooms = $_POST['txtBathrooms']; 
            $sBedrooms = $_POST['txtBedrooms']; 
            $sSurface = $_POST['txtSurface']; 
            $sAddress = $_POST['txtAddress']; 
            $sZipcode = $_POST['txtZipcode']; 
            $agentSessionId = $_SESSION['jAgent'];
            $sAgentId = $agentSessionId->id;



            $jProperty = new stdClass(); //NEW JSON OBJECT
            $sPropertyUniqueId = uniqid();
            $jProperty->id = $sPropertyUniqueId;
            $jProperty->geometry = new stdClass();
            $jProperty->geometry->coordinates = [12.572225, 55.70419];
            $jProperty->geometry->type = "Point";
            $jProperty->iconSize = [20,20];
            $jProperty->type = "Feature"; 
            $jProperty->image = $sUniqueImageName;
            $jProperty->price = intVal($sPrice);
            $jProperty->address = $sAddress;
            $jProperty->bathrooms = intVal($sBathrooms);
            $jProperty->bedrooms = intVal($sBedrooms);
            $jProperty->surface = intVal($sSurface);
            $jProperty->zipcode = $sZipcode;

            $sjData = file_get_contents(__DIR__.'/agents.json');
            $jData = json_decode($sjData);
            $jData->$sAgentId->properties->$sPropertyUniqueId = $jProperty;
            //echo json_encode($jProperties);
            // above spawns valid json (of course it is really text)
            $sjData = json_encode($jData, JSON_PRETTY_PRINT);
            file_put_contents(__DIR__.'/agents.json',$sjData);

            $strObj = '{"status":1, "message":"Correcto"}';
            $obj = json_decode($strObj);
            $obj->property = $jProperty;

            echo json_encode($obj);

    }
}
function sendErrorMessage($sErrorMessage, $iLineNumber){
    echo '{"status":0, "message":"'.$sErrorMessage.'", "line":'.$iLineNumber.'}';
    exit;

}
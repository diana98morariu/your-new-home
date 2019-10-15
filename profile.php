<?php
$sActive = 'Profile';
require_once(__DIR__.'/top-signedin.php');

?>
<?php
session_start();
if(!$_SESSION){
    header('Location: login.php');
}
if(isset($_SESSION['jAgent'])){
    // echo "Hi {$_SESSION['jAgent']->name} {$_SESSION['jAgent']->lastname}";
    displayAgentProfile();
}else if(isset($_SESSION['jUser'])){
    // echo "Hi {$_SESSION['jUser']->name} {$_SESSION['jUser']->lastname}";
    displayUserProfile();
}

?>

<?php
function displayUserProfile(){
?>

<?php
$sActive = 'Profile';
require_once(__DIR__.'/top-signedin.php');
$sjUsers = file_get_contents(__DIR__.'/users.json');
$jUsers = json_decode($sjUsers);
$userSessionId = $_SESSION['jUser'];
$userId = $userSessionId->id;

?>
<div class="container-user">
    <div>
        <form id="frmImage" method="POST" enctype="multipart/form-data" class="user-image">
            <?php 
            $sjUsers = file_get_contents('users.json');
            $jUsers = json_decode($sjUsers);
            echo '<label for="file-upload" id="uploaded_image" style="background-image:url(../your-new-home/images/'.$jUsers->$userId->image.');"></label>';
            ?>
            <input type="file" name="image" id="file">
            <button id="btnUploadImage">UPLOAD PROFILE IMAGE</button>
        </form>
    </div>
    <div>
        <form id="profileInfo" class="profileInfo" method="POST">
            <div <?= 'id="'.$userSessionId->id.'"' ?> class="user">
                <input class="inputProfile" name="name" data-update="name" type="text" maxlength="20" 
                data-type="string" value="<?= $jUsers->$userId->name ?>">
                
                <input class="inputProfile" name="lastname" data-update="lastname" type="text" minlength="2" maxlength="20" 
                data-type="string" data-min="2" data-max="20" value="<?= $jUsers->$userId->lastname ?>">
                
                <div id="update_button" data-start="EDIT" data-wait="WAIT ...">EDIT</div>
                
            </div>
        </form>
    </div>
    <button id="delete_button" data-start="DELETE" data-wait="WAIT ..." ><a href="delete-profile.php">DELETE PROFILE</a></button>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="validate.js"></script>
<script src="profile.js"></script>

<?php
require_once(__DIR__.'/bottom.php');
?>

<?php
exit;
}
?>


<?php
function displayAgentProfile(){
?>

<?php
$sActive = 'Profile';
require_once(__DIR__.'/top-signedin.php');

$sjAgents = file_get_contents(__DIR__.'/agents.json');
$jAgents = json_decode($sjAgents);
$agentSessionId = $_SESSION['jAgent'];
$AgentId = $agentSessionId->id;
?>
<div class="container">
    <div class="profile-image-name">
        <h3>UPDATE YOUR PROFILE</h3>
        <form id="frmImage" enctype="multipart/form-data" method="POST" class="agent-image">
            <?php
            $sjAgents = file_get_contents('agents.json');
            $jAgents = json_decode($sjAgents);
            
            echo '<label for="file-upload" id="uploaded_image" style="background-image:url(../your-new-home/images/'.$jAgents->$AgentId->image.');"></label>';
            ?>
            <input type="file" name="image" id="input_profile_image">
            <button id="btnUploadImage">UPLOAD PROFILE IMAGE</button>
        </form>
    
        <form id="profileInfo" class="profileInfo" method="POST">
            <div <?php echo 'id="'.$agentSessionId->id.'"'?> class="agent">
                <div>Name:</div>
                <input class="inputProfile" name="name" data-update="name" type="text" maxlength="20" 
                data-type="string" value="<?= $jAgents->$AgentId->name ?>">
                <div class="lastName-profileInfo">Last name:</div>
                <input class="inputProfile" name="lastname" data-update="lastname" type="text" minlength="2" maxlength="20" 
                data-type="string" data-min="2" data-max="20" value="<?= $jAgents->$AgentId->lastname ?>">
                
                <div id="update_button" data-start="UPDATE" data-wait="WAIT ..." >UPDATE</div>
            </div>
        </form>
        <button id="delete_button" data-start="DELETE" data-wait="WAIT ..." ><a href="delete-profile.php">DELETE PROFILE</a></button>
    </div>
    <div class="property-upload-container ">
        <h3>UPLOAD A NEW PROPERTY</h3>
        <form id="property_upload" method="POST" enctype="multipart/form-data">
            <div>Only images are allowed (jpg, png, jpeg)</div>
            <input id="myFile" name="myFile" type="file">

            <input id="txtPrice" name="txtPrice" type="number" data-type="integer" data-min="1" data-max="999999999" placeholder="Price">

            <input id="txtBathrooms" name="txtBathrooms" type="number" data-type="integer" placeholder="Bathrooms">

            <input id="txtBedrooms" name="txtBedrooms" type="number" data-type="integer" placeholder="Bedrooms">

            <input id="txtSurface" name="txtSurface" type="number" data-type="integer" placeholder="Surface">

            <input id="txtAddress" name="txtAddress" type="text" data-type="string" data-min="3" data-max="3000" placeholder="Address">

            <input id="txtZipcode" name="txtZipcode" type="text" data-type="string" data-min="3" data-max="10" placeholder="Zipcode">

            <button type="submit" onclick="return uploadCheck(this);" id="btn_upload_prop">UPLOAD PROPERTY</button>    
        </form>
    </div>
    <div id="property_container">
    
    <?php

    $sjProperties = file_get_contents(__DIR__.'/agents.json');
    $jProperties = json_decode ($sjProperties);
    $sBlueprint = '
    <div class="property" id="{{id}}">
        <form  method="POST" id="{{id}}" class="indiv-property">
            <div class="image-btn">
                <img style="width: 270px; height: 270px; object-fit: cover;" src="images/{{path}}" alt="">
                <div class="edit_property_btn" data-id="{{id}}" style="background-color:#f0e370; text-align: center; color:black; height:40px; 
                border-radius: 5px; width:270px; padding-top: 10px;">EDIT</div>
            </div>
            <div class="input-property">
                <div>Price:<input data-update="price" name="txtPrice" type="number" data-type="integer" value="{{price}}" placeholder="Price"></div>
                <div>Bathrooms:<input data-update="bathrooms" name="txtBathrooms" type="number" data-type="integer" value="{{bathrooms}}"placeholder="Bathrooms"></div>
                <div>Bedrooms:<input data-update="bedrooms" name="txtBedrooms" type="number" data-type="integer" value="{{bedrooms}}" placeholder="Bedrooms"></div>
                <div>Surface:<input data-update="surface" name="txtSurface" type="number" data-type="integer" value="{{surface}}" placeholder="Surface"></div>
                <div>Address:<input data-update="address" name="txtAddress" type="text" data-type="string" data-min="3" data-max="3000" value="{{address}}" placeholder="Address"></div>
                <div>Zipcode:<input data-update="zipcode" name="txtZipcode" type="text" data-type="string" data-min="3" data-max="10" value="{{zipcode}}" placeholder="Zipcode"></div>
                <button class="delete-button" data-path="{{path}}" data-id="{{id}}">DELETE</button>
            </div>
        </form>
    </div>

    ';
    // onclick="return updateCheck(this);"
    foreach($jProperties->$AgentId->properties as $sKey => $jProperty){
        $sCopyBlueprint = $sBlueprint;
        //ANOTHER WAY
        $sCopyBlueprint = str_replace('{{price}}', $jProperty->price, $sCopyBlueprint);
        $sCopyBlueprint = str_replace('{{path}}', $jProperty->image, $sCopyBlueprint);
        $sCopyBlueprint = str_replace('{{bathrooms}}', $jProperty->bathrooms, $sCopyBlueprint);
        $sCopyBlueprint = str_replace('{{bedrooms}}', $jProperty->bedrooms, $sCopyBlueprint);
        $sCopyBlueprint = str_replace('{{surface}}', $jProperty->surface, $sCopyBlueprint);
        $sCopyBlueprint = str_replace('{{address}}', $jProperty->address, $sCopyBlueprint);
        $sCopyBlueprint = str_replace('{{zipcode}}', $jProperty->zipcode, $sCopyBlueprint);
        $sCopyBlueprint = str_replace('{{id}}', $sKey, $sCopyBlueprint);
        //SHOW IT
        echo $sCopyBlueprint;
    }

    ?>
    </div>
    
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="validate.js"></script>
<script src="profile.js"></script>


<?php
require_once(__DIR__.'/bottom.php');
?>

<?php
exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.css' rel='stylesheet'/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" 
    integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

    <title><?php echo $sActive; ?></title>
</head>
<body>
    <nav>
        <a <?= $sActive=='Properties' ? 'class="active" ' : ''; ?>href="properties.php">PROPERTIES</a>
        <a <?= $sActive=='Contact-us' ? 'class="active" ' : ''; ?>href="contact-us.php">CONTACT US</a>
        <a href="frontpage.php"><img class="logo_id" src="images/logo.png" alt="logo"></a>
        <a <?= $sActive=='Login' ? 'class="active" ' : ''; ?>href="login.php">LOGIN</a>
        <div class="dropdown" <?= $sActive=='Signup' ? 'class="active" ' : ''; ?>>
            <div class="dropbtn">SIGNUP</div>
            <div class="dropdown_content_signup">
                <a href="signup-agent.php">As an agent</a>
                <a href="signup-user.php">As a user</a>
            </div>
        </div>
    </nav>
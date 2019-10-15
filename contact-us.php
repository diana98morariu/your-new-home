<?php
$sActive = 'Contact-us';
session_start();
if (empty($_SESSION)){
    require_once('top-not-signedin.php');
}else{
    require_once('top-signedin.php');
}
?>


<div class="form-wraper-contact">
    <div class="contact-info">
        <h1>CONTACT US</h1>
        <p>Address: Sølvgade 15, 1307 København</p>
        <p>Phone : +45 25 36 85 47</p>
        <p>Fax : +45 56 74 98 02</p>
        <div id='map' style='width: 400px; height: 300px;'></div>

    </div>
    
    <form id="frmContact" method="GET" type="submit">
        <p>Want to Know More? Drop Us a Mail</p>
        <input id="txtName" class="form-contact-inputs" type="text" name="txtName" placeholder="Name" maxlength="100" 
        data-type="string" data-min="2" data-max="20" required>

        <input id="txtLastName" class="form-contact-inputs" type="text" name="txtLastName" placeholder="Last Name" 
        maxlength="100" data-type="string" data-min="2" data-max="20" required>

        <input id="txtEmail" class="form-contact-inputs" type="text" name="txtEmail" maxlength="100" data-type="email" 
        placeholder="Email" required>

        <input id="txtSubject" class="form-contact-inputs" type="text" name="txtSubject" placeholder="Subject" 
        maxlength="100" data-type="string" data-min="2" data-max="20" required>

        <textarea id="txtMessage" class="form-contact-inputs" name="txtMessage" maxlength="5000"  data-max="5000" 
        data-type="string" data-type="string" placeholder="Message" rows="10" required></textarea>

        <button id="submit_button" onclick="contact(this); return false" class="btn-form">SEND</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="validate.js"></script>
<script src="contact.js"></script>
<script>
    $(document).ready(function(){
        $('#submit_button').click(function(){
            var email = $('#txtEmail').val();
            var subject = $('#txtSubject').val();
            var message = $('#txtMessage').val();
            var varData = 'txtEmail=' + email +'&txtSubject=' + subject + '&txtMessage=' + message;
            console.log(varData);
            $.ajax({
                url: "api-send-email.php",
                method: "GET",
                data: varData,
                beforeSend:function(){
                    if( email ){
                        $('#submit_button').html("<label class='text-success'> EMAIL SENDING...</label>");
                    }
                }
            }).done(function(data){
                if( email ){
                    if(validateEmail(email)== true){
                        $('#submit_button').text('EMAIL HAS BEEN SENT').css({"background-color":"#f0e370", "color":"black"});
                        window.setTimeout(function(){window.location.reload()}, 1000);
                    }
                }
            }).fail(function(){
                alert('Not sent');
            })
        })
    })
    function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( email );
    }
</script>

<script>
      mapboxgl.accessToken = 'pk.eyJ1IjoiYW5kcmVlYXN0ZXJpdSIsImEiOiJjazBjNWY2ZGkweWxsM21vNDQ0bXp0Y2NiIn0.3fJGX-jym2-4HMP87D7V0w';
      var geojson = {
        type: 'FeatureCollection',
        features: [{
          type: 'Feature',
          geometry: {
            type: 'Point',
            coordinates: [12.554355, 55.703006]
          },
          properties: {
            title: 'Your New Home',
            description: 'Jemtelandsgade 3, 2300 København'
          }
        }]

    };
      var map = new mapboxgl.Map({
      container: 'map',
      center: [12.555050, 55.704001], // starting position
      zoom: 12, // starting zoom
      style: 'mapbox://styles/mapbox/streets-v11'
      });

      map.addControl(new mapboxgl.NavigationControl());
      // add markers to map
        geojson.features.forEach(function(marker) {

        // create a HTML element for each feature
        var el = document.createElement('div');
        el.className = 'marker';

        // make a marker for each feature and add to the map
        new mapboxgl.Marker(el)
          .setLngLat(marker.geometry.coordinates)
          .addTo(map);
        });

</script>
<?php
require_once(__DIR__.'/bottom.php');
?>
<?php
$sActive = 'Properties';
session_start();
if (empty($_SESSION)){
    require_once('top-not-signedin.php');
}else{
    require_once('top-signedin.php');
}
?>

<div id="map_properties">
        <div id="map"></div>

        <div id="properties">

            <?php
                $sjAgents = file_get_contents('agents.json');
                $jAgents = json_decode($sjAgents);
                $jAllProperties = [];
                
                    foreach($jAgents as $jAgent){
                        $jProperties = $jAgent->properties;
                        foreach($jProperties as $jProperty){
                            $jAllProperties[$jProperty->id] = $jProperty;
                            if(empty($_GET['zipcode'])){
                                echo '
                            <div id="Right'.$jProperty->id.'" class="property-properties">
                                <img src="images/'.$jProperty->image.'" class="property-image">
                                <div class="total-info">
                                    <div class="price-info">
                                        <div class="price">'.$jProperty->price.' DKK/month</div>
                                        <div class="info">
                                            <div class="bathrooms">'.$jProperty->bathrooms.' ba</div>
                                            <div class="bedrooms">'.$jProperty->bedrooms.' bds</div>
                                            <div class="surface">'.$jProperty->surface.' m<sup>2</sup></div>
                                        </div>
                                    </div>
                                    <div class="address">'.$jProperty->address.', '.$jProperty->zipcode.' København</div>
                                    <div class="for-rent">&#8226 Property for rent</div>
                                </div>
                            </div>';
                        }else if($_GET['zipcode'] == $jProperty->zipcode){
                            echo '
                            <div id="Right'.$jProperty->id.'" class="property-properties">
                                <img src="images/'.$jProperty->image.'" class="property-image">
                                <div class="total-info">
                                    <div class="price-info">
                                        <div class="price">'.$jProperty->price.' DKK/month</div>
                                        <div class="info">
                                            <div class="bathrooms">'.$jProperty->bathrooms.' ba</div>
                                            <div class="bedrooms">'.$jProperty->bedrooms.' bds</div>
                                            <div class="surface">'.$jProperty->surface.' m<sup>2</sup></div>
                                        </div>
                                    </div>
                                    <div class="address">'.$jProperty->address.', '.$_GET['zipcode'].' København</div>
                                    <div class="for-rent">Property for rent</div>
                                </div>
                            </div>';
                        }
                        
                    }
                }
            ?>
        </div>
    </div>

    <script>

        const sjProperties ='<?php echo json_encode($jAllProperties);?>'
        console.log(sjProperties)
        ajProperties = JSON.parse(sjProperties)
        console.log(ajProperties)

        mapboxgl.accessToken = 'pk.eyJ1IjoiZGlhbmE5OG1vcmFyaXUiLCJhIjoiY2swYzVnd2h0MHk3MTNqbnV4dTAzNzd0aSJ9.LL5e8ZpvPjKV6Z7cypaBjg';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/diana98morariu/ck0c6ib0j02ty1cn28ogwjrux',
        center: [12.539045, 55.707827], // starting position
        zoom: 12 // starting zoom
        });
        // Add zoom and rotation controls to the map.
        map.addControl(new mapboxgl.NavigationControl());


        for( let jProperty in ajProperties){
            const property = ajProperties[jProperty];
    
            var el = document.createElement('a');
            el.href = '#Right'+ property.id;
            el.className = 'marker';
            // el.style.backgroundImage = 'url(images/marker.svg)';
            // el.style.width = "50px";
            // el.style.height = "50px";
            el.id = property.id;
            
            el.addEventListener('click', function(){
                removeActivePropertyClassFromProperty()
                removeActiveMarkerClassFromProperty()
                document.getElementById('Right' + this.id).classList.add('active-property')
                document.getElementById(this.id).classList.add('active-marker')
            });

            //add marker to map
            new mapboxgl.Marker(el).setLngLat(property.geometry.coordinates).addTo(map);
        
        }
        function removeActivePropertyClassFromProperty(){
            let properties = document.querySelectorAll('.active-property')
            properties.forEach(function(oPropertyDiv){
                oPropertyDiv.classList.remove('active-property')
            })
        }
        function removeActiveMarkerClassFromProperty(){
            let properties = document.querySelectorAll('.active-marker')
            properties.forEach(function(oPropertyDiv){
                oPropertyDiv.classList.remove('active-marker')
            })
        }
    </script>

<?php
require_once(__DIR__.'/bottom.php');
?>
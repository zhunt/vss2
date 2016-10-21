<!-- venue_streetview -->

<div id="gmap_streetview" style="width: 273px; height: 246px; border: 2px solid #A7A7A7" ></div>	
						
<?php $this->Html->scriptStart( array('inline' => false ) );?>
    var streetviewOptions;
    var streetviewPano;
    var streetviewPos;

    $(document).ready(function() {

        streetviewPos = new google.maps.LatLng( <?php echo $venue['Venue']['lat'] . ', ' . $venue['Venue']['lng']?>  )
        streetviewOptions = {
            position: streetviewPos  ,
            pov: {
                heading: <?php echo $venue['Venue']['heading'] ?>,
                pitch: <?php echo $venue['Venue']['pitch'] ?>,
                zoom: <?php echo $venue['Venue']['zoom'] ?>            
                },
            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
            visible: true
        };

        streetviewPano = new google.maps.StreetViewPanorama(
            document.getElementById("gmap_streetview"), streetviewOptions);

        streetviewPano.setOptions({
            addressControl: false,
            navigationControl: false,
            linksControl: false
        });

        streetviewPano.set('navigationControlOptions', {
            position: google.maps.ControlPosition.TOP_LEFT,
            style: google.maps.NavigationControlStyle.ANDROID
        });

    });
    
<?php $this->Html->scriptEnd(); ?>
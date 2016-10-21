<?php 
if ( !empty($venue['Venue']['photo_1']) ): ?>
	<img src="/img/venue_photos/<?php echo $venue['Venue']['photo_1'] ?>" alt="image of <?php echo $venue['Venue']['full_name'] ?>" width="590" height="340" />
<?php 
	elseif (!empty($venue['Venue']['heading']) ): ?>
    	<div id="gmap_streetview" class="venue_streetview" style="width: 590px; height: 340px; z-index:0"></div>
<script language="javascript">        
<?php $this->Html->scriptStart(array('inline' => false)) ?>
    var streetviewOptions;
    var streetviewPano;
    var streetviewPos;

    $(document).ready(function() {

        streetviewPos = new google.maps.LatLng( <?php echo "{$venue['Venue']['lat']}, {$venue['Venue']['lng']}" ?> )
        streetviewOptions = {
            position: streetviewPos,
            pov: {
                heading: <?php echo trim($venue['Venue']['heading']) ?>,
                pitch: <?php echo trim($venue['Venue']['pitch']) ?>,
                zoom: <?php echo trim($venue['Venue']['zoom']) ?>
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
    <?php $this->Html->scriptEnd() ?>
    </script>
<?php else: ?>
<!-- no photo for <?php echo $venue['Venue']['full_name'] ?> -->
<div id="gmap_streetview" class="venue_streetview" style="width: 590px; height: 52px; z-index:0"></div>
<?php endif; ?>
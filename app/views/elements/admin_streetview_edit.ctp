<a href="#" id="link_streetview">Edit Streetview</a>

<div id="dialog-streetview" style="display: none">
    <div id="gmap_streetview" style="width: 590px; height: 340px;" ></div>
    <a href="#" id="link_streetview_updatelatlong">Update Lat/Long</a>
    <?php //debug($streetView) ?>

    <div id="streetview_input">
   <?php //echo $this->VenueMeta->streetviewFields(); ?>
   
   <?php echo $this->Form->input('heading', array('id' => 'PageMetaHeading', 'label' => 'Heading', 'class' => 'small', 'div' => false ) ) ?>
   <?php echo $this->Form->input('pitch', array('id' => 'PageMetaPitch', 'label' => 'Pitch', 'class' => 'small', 'div' => false ) ) ?>
   <?php echo $this->Form->input('zoom', array('id' => 'PageMetaZoom', 'label' => 'Zoom', 'class' => 'small', 'div' => false ) ) ?>
   <?php echo $this->Form->input('lat', array('id' => 'PageMetaLat', 'label' => 'Lat', 'class' => 'small', 'div' => false ) ) ?>
   <?php echo $this->Form->input('lng', array('id' => 'PageMetaLng', 'label' => 'Lng', 'class' => 'small', 'div' => false ) ) ?>
   
   </div>


    </div>
    <a href="#" id="link_streetview_clear_cords">Clear</a>
    
</div>

<script type="text/javascript">
<?php $this->Html->scriptStart(array('inline' => false)) ?>

$(document).ready(function() {

    var streetviewPano;
    var streetviewOptions;
    var streetviewLatlng;
    
    $("#link_streetview").click(function () {
      $("#dialog-streetview").slideToggle('fast', initStreetView );
      return false;
    });

    $('#link_streetview_clear_cords').click( function() {
        $('#PageMetaZoom').val('');
        $('#PageMetaPitch').val('');
        $('#PageMetaHeading').val('');
        $('#PageMetaZoom').val('');
        $('#PageMetaLat').val('');
        $('#PageMetaLng').val('');
        return false;
    });

    // copies map cords to streetview's cords
    $('#link_streetview_updatelatlong').bind('click', function(){
        streetviewLatlng = new google.maps.LatLng( $('#VenueGeoLat').val(), $('#VenueGeoLng').val() );
        streetviewPano.setPosition(streetviewLatlng);
        return false;
    } );

    // initialize Street View
    function initStreetView() {

        if (streetviewPano == null) {

            // check if lat/lng already set in page meta, use site cords if not
            streetViewLat = parseFloat( $('#PageMetaLat').val() );
            if ( !streetViewLat)
                streetViewLat = $('#VenueGeoLat').val()

            streetViewLng = parseFloat( $('#PageMetaLng').val() );
            if (!streetViewLng)
                streetViewLng = $('#VenueGeoLng').val()

            streetviewLatlng = new google.maps.LatLng( streetViewLat, streetViewLng );

            if (streetviewLatlng) {
                streetviewOptions = {
                    position: streetviewLatlng,
                    pov: {
                        heading: 0,
                        pitch: 0,
                        zoom: 1
                    },
                    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
                    addressControl: false,
                    visible: true
                };

                if ( $('#PageMetaPitch').val() != '' )
                    streetviewOptions.pov.pitch = parseFloat( $('#PageMetaPitch').val() );
                if ( $('#PageMetaHeading').val() != '' )
                    streetviewOptions.pov.heading = parseFloat( $('#PageMetaHeading').val() );
                if ( $('#PageMetaZoom').val() != '' )
                    streetviewOptions.pov.zoom = parseFloat( $('#PageMetaZoom').val() );

                streetviewPano = new google.maps.StreetViewPanorama(
                    document.getElementById("gmap_streetview"), streetviewOptions);

                //google.maps.event.trigger(streetviewPano, 'position_changed');

                 google.maps.event.addListener(streetviewPano, 'position_changed', function() {
                    //console.log( streetviewPano.getPosition() );
                    $('#PageMetaLat').val(streetviewPano.getPosition().lat() );
                    $('#PageMetaLng').val(streetviewPano.getPosition().lng() );
                });

                 google.maps.event.addListener(streetviewPano, 'pov_changed', function() {
                    //console.log( streetviewPano.getPov() );
                    $('#PageMetaHeading').val(streetviewPano.getPov().heading );
                    $('#PageMetaPitch').val(streetviewPano.getPov().pitch );
                    $('#PageMetaZoom').val(streetviewPano.getPov().zoom );

                });

                 $('#PageMetaZoom').change(function() {
                     console.log( $('#PageMetaZoom').val() )
                    //streetviewOptions.pov.zoom = parseFloat( $('#PageMetaZoom').val() );

                    streetviewOptions.pov = streetviewPano.getPov();
                    streetviewOptions.pov.zoom = parseFloat( $('#PageMetaZoom').val() );
                    
                    console.log(streetviewOptions.pov );
                    streetviewPano.setPov( streetviewOptions.pov );
                    //streetviewOptions.pov( { heading: 0, pitch: 0, zoom: 2} );
                    
                 })

            }
        }

    }

});
<?php $this->Html->scriptEnd() ?>
</script>
<a href="#" id="link_streetview">Edit Streetview</a>

<div id="dialog-streetview" style="display: none">
    <div id="gmap_streetview" ></div>
    <a href="#" id="link_streetview_updatelatlong">Update Lat/Long</a>
    <?php //debug($streetView) ?>

    <div id="streetview_input">
   <?php echo $this->VenueMeta->streetviewFields(); ?>
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
            streetviewLatlng = new google.maps.LatLng(
                $('#VenueGeoLat').val(), $('#VenueGeoLng').val() );



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

            }
        }

    }

});
<?php $this->Html->scriptEnd() ?>
</script>
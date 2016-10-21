<?php
class VenueMetaDataComponent extends Object {

    /*
     * serializes data from a form into meta table format
     */
    function packStreetviewData( $venueMetaId, $venueId, $form) {

        unset($form['id']);
        $form = array('Streetview' => $form );
        debug($form);
        $data = array(
            'id' => $venueMetaId,
            'venue_id' => $venueId,
            'meta_key' => 'streetview',
            'meta_value' => serialize($form)
        );

        if ( intval($venueMetaId) < 1 )
            unset($data['id']);
            
        //debug($data); exit;
        return $data;
    }

    /*
     * loops through all in PageMeta
     * returns array of values prefixed by meta_key and fieldname
     */
    function unpackStreetviewData( $pageMeta) {
        $data = array();
        $key = $pageMeta[0]['meta_key'];

        foreach( $pageMeta as $row) {
            array_push( $data, array($key => unserialize($row['meta_value']) ) );
        }

        /*
        $data = array(
            'venue_id' => $venueId,
            'meta_key' => 'streetview',
            'meta_value' => serialize($form)
        );*/
        return $data;
    }

}

/*
 *     [VssPageMeta] => Array
        (
            [heading] => 55.05
            [pitch] => -1.3500000000000005
            [zoom] => 3
            [lat] => 49.312337
            [lng] => -123.07722
        )

 */
?>

<?php
class VenueMetaHelper extends AppHelper {
    var $helpers = array('Form');

    function streetviewFields() {

        $index = 0;
        foreach( $this->data['VenueMeta'] as $i => $value ) {
            if ( $value['meta_key'] == 'streetview') {
                $index = $i;
                break;
            }
        }

        $html = '';
        $html .= $this->Form->input("VenueMeta.{$index}.heading", array('div' => false, 'class' => 'small', 'id' => 'PageMetaHeading') ) ;
        $html .= $this->Form->input("VenueMeta.{$index}.pitch", array('div' => false, 'class' => 'small', 'id' => 'PageMetaPitch'));
        $html .= $this->Form->input("VenueMeta.{$index}.zoom", array('div' => false, 'class' => 'small', 'id' => 'PageMetaZoom'));
        $html .= $this->Form->input("VenueMeta.{$index}.lat", array('div' => false, 'class' => 'small', 'id' => 'PageMetaLat'));
        $html .= $this->Form->input("VenueMeta.{$index}.lng", array('div' => false, 'class' => 'small', 'id' => 'PageMetaLng'));

        // for saving
        $html .= $this->Form->input("VenueMeta.{$index}.id", array('type' => 'hidden'));
        $html .= $this->Form->input("VenueMeta.{$index}.venue_id", array('type' => 'hidden'));
        $html .= $this->Form->input("VenueMeta.{$index}.meta_key", array('type' => 'hidden', 'value' => 'streetview'));


        
        return $this->output($html);
    }

    /*
     * Checks if there is a PageMeta for a type (e.g. streetview, gallery, etc. )
     * returns row if exists, false if not
     */
    function getMetaType($type) {
        
        foreach( $this->data['VenueMeta'] as $i => $row ) {
            if ( $row['meta_key'] == $type) {
                return $row;
            }
        }
        
        return false;
    }
	
	/* Like getMetaType but returns just the meta value for a field
	*/
	function getMetaTypeSingle($type) {
        foreach( $this->data['VenueMeta'] as $i => $row ) {
            if ( $row['meta_key'] == $type) {
                return $row['meta_value'];
            }
        }
        
        return false;		
	}
}
?>
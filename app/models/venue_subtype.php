<?php
class VenueSubtype extends AppModel {

	var $name = 'VenueSubtype';
        var $actsAs = array('Sluggable', 'Containable');
        
	var $validate = array(
		'name' => array('notempty'),
		'slug' => array('notempty'),
		'venue_type_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'VenueType' => array(
			'className' => 'VenueType',
			'foreignKey' => 'venue_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'VenueType.name DESC'
		)
	);

	var $hasAndBelongsToMany = array(
		'Venue' => array(
			'className' => 'Venue',
			'joinTable' => 'venues_venue_subtypes',
			'foreignKey' => 'venue_subtype_id',
			'associationForeignKey' => 'venue_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

    /*
     * returns Id of product, adding product to table if nessassary
     */
    function updateVenueSubtype($name, $venueId, $venueTypeId = null) {
        if ( empty($name)) return false;

        $this->Containable = false;
        $result = $this->findByName($name);

        if (!$result) {
            $data = array(
                    'VenueSubtype' => array('name' => $name, 'venue_type_id' => $venueTypeId),
                    'Venue' => array('Venue' => array($venueId) )
                    );
        }else { // product already in list
            $id = $result['VenueType']['id'];
            // get list of venues with this VenueType already
            $venues = $this->VenuesVenueSubtype->find('list', array(
                                'fields' => array('venue_id'),
                                'conditions' => array( 'venue_subtype_id' => $id ) ) );
            $venues[] = $venueId;
            sort($venues);
            
            $data = array(
                    'VenueSubtype' => array( 'id' => $id, 'name' => $name, 'venue_type_id' => $venueTypeId ),
                    'Venue' => array('Venue' => (array)$venues )
                    );
        }
        $this->create();
        $this->save( $data, array('validate' => false));
        $id = $this->id;

        return($id);
    }

    /*
     * returns Id of subtype, adding venue subtype to table if nessassary
     */
    function updateSubtype($subtype, $venueTypeId = 0) {
        if ( empty($subtype)) return false;
        //debug($neighbourhood);
        $this->Containable = false;
        $result = $this->findByName($subtype);

        if (!$result) {
            $this->create();
            $data = array('VenueSubtype' => array('name' => $subtype,
                                                    'venue_type_id' => $venueTypeId) );
            //$this->containable = false;
            $this->save( $data);
            $id = $this->id;
        } else {
            $id = $result['VenueSubtype']['id'];
        }

        return($id);
    }


}
?>
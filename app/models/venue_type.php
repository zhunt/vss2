<?php
class VenueType extends AppModel {

	var $name = 'VenueType';
        var $actsAs = array('Sluggable');
	var $validate = array(
            'name' => array('notempty'),
            'slug' => array('rule' => 'notempty', 'on' => 'update'),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'VenueAmenity' => array(
			'className' => 'VenueAmenity',
			'foreignKey' => 'venue_type_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'VenueProduct' => array(
			'className' => 'VenueProduct',
			'foreignKey' => 'venue_type_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'VenueService' => array(
			'className' => 'VenueService',
			'foreignKey' => 'venue_type_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'VenueSubtype' => array(
			'className' => 'VenueSubtype',
			'foreignKey' => 'venue_type_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Venue' => array(
			'className' => 'Venue',
			'joinTable' => 'venues_venue_types',
			'foreignKey' => 'venue_type_id',
			'associationForeignKey' => 'venue_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'Venue.created ASC',
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
    function updateVenueType($name, $venueId) {
        if ( empty($name)) return false;

        $this->Containable = false;
        $result = $this->findByName($name);

        if (!$result) {
            $data = array(
                    'VenueType' => array('name' => $name),
                    'Venue' => array('Venue' => array($venueId) )
                    );
        }else { // product already in list
            $id = $result['VenueType']['id'];
            // get list of venues with this VenueType already
            $venues = $this->VenuesVenueType->find('list', array(
                                'fields' => array('venue_id'),
                                'conditions' => array( 'venue_type_id' => $id ) ) );
            $venues[] = $venueId;
            sort($venues);

            $data = array(
                    'VenueType' => array( 'id' => $id, 'name' => $name),
                    'Venue' => array('Venue' => (array)$venues )
                    );
        }
            $this->create();
            $this->save( $data, array('validate' => false));
            $id = $this->id;

        return($id);
    }

}
?>
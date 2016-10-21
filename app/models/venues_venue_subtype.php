<?php
class VenuesVenueSubtype extends AppModel {

	var $name = 'VenuesVenueSubtype';
        var $actsAs = array('Sluggable', 'Containable');
        
	var $validate = array(
		'venue_id' => array('numeric'),
		'venue_subtype_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'venue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'VenueSubtype' => array(
			'className' => 'VenueSubtype',
			'foreignKey' => 'venue_subtype_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
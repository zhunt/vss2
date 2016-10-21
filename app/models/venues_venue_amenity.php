<?php
class VenuesVenueAmenity extends AppModel {

	var $name = 'VenuesVenueAmenity';
	var $validate = array(
		'venue_id' => array('numeric'),
		'amenity_id' => array('numeric')
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
		'Amenity' => array(
			'className' => 'Amenity',
			'foreignKey' => 'amenity_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
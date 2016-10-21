<?php
class VenuesVenueType extends AppModel {

	var $name = 'VenuesVenueType';
        var $actsAs = array('Sluggable', 'Containable');
        
	var $validate = array(
		'venue_id' => array('numeric'),
		'venue_type_id' => array('numeric')
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
		'VenueType' => array(
			'className' => 'VenueType',
			'foreignKey' => 'venue_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
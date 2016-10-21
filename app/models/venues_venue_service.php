<?php
class VenuesVenueService extends AppModel {

	var $name = 'VenuesVenueService';
        var $actsAs = array('Sluggable', 'Containable');
        
	var $validate = array(
		'venue_id' => array('numeric'),
		'venue_service_id' => array('numeric')
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
		'VenueService' => array(
			'className' => 'VenueService',
			'foreignKey' => 'venue_service_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
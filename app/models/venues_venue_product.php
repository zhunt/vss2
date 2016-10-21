<?php
class VenuesVenueProduct extends AppModel {

	var $name = 'VenuesVenueProduct';
        var $actsAs = array('Sluggable', 'Containable');
	var $validate = array(
		'venue_id' => array('numeric'),
		'venue_product_id' => array('numeric')
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
		'VenueProduct' => array(
			'className' => 'VenueProduct',
			'foreignKey' => 'venue_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
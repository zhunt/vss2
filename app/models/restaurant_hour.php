<?php
class RestaurantHour extends AppModel {

	var $name = 'RestaurantHour';
	var $validate = array(
		'venue_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'venue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
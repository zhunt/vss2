<?php
class VenueField extends AppModel {
	var $name = 'VenueField';
	var $displayField = 'name';
	var $validate = array(
		'venue_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

        var $hasMany = array('Venue' => array(
            'foreignKey' => 'venue_id'
        ));
}
?>
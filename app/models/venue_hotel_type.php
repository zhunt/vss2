<?php
class VenueHotelType extends AppModel {

	var $name = 'VenueHotelType';
    var $actsAs  = array('Containable', 'CounterCache',
                                'Sluggable' => array('urlField' => 'slug') );

	var $validate = array(
		'name' => array('notempty'),
		'slug' => array(
                    'unique' => array( 'rule' => 'isUnique', 'on' => 'create'),
                    'notempty' => array ('rule' => 'notempty')
                    ),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Venue' => array('className' => 'Venue',
								'foreignKey' => 'venue_hotel_type_id',
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

}
?>
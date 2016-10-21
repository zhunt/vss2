<?php
class VenueAttractionType extends AppModel {

	var $name = 'VenueAttractionType';
    var $actsAs  = array('Containable',
                                'Sluggable' => array('urlField' => 'slug') );
    
	var $validate = array(
		'name' => array('notempty'),
		'slug' => array(
                    'unique' => array( 'rule' => 'isUnique', 'on' => 'create'),
                    'notempty' => array ('rule' => 'notempty')
                    )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Venue' => array('className' => 'Venue',
								'foreignKey' => 'venue_attraction_type_id',
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
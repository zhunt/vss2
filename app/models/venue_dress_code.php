<?php
class VenueDressCode extends AppModel {

	var $name = 'VenueDressCode';
    var $actsAs  = array('Containable', 'SdSlugger' );

	var $validate = array(
		'name' => array('notempty'),
		'slug' => array(
                    'unique' => array( 'rule' => 'isUnique', 'on' => 'create'),
                    'notempty' => array ('rule' => 'notempty')
                    )
	);

	var $hasMany = array(
			'VenueDetail' => array('className' => 'VenueDetail',
								'foreignKey' => 'venue_dress_code_id',
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
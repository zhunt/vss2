<?php
class VenueAtmosphere extends AppModel {

	var $name = 'VenueAtmosphere';
    var $actsAs  = array('Containable', 'SdSlugger' );

	var $validate = array(
		'name' => array('notempty'),
		'slug' => array(
                    'unique' => array( 'rule' => 'isUnique', 'on' => 'create'),
                    'notempty' => array ('rule' => 'notempty')
                    )
	);

	var $hasMany = array(
			'VenueDetail1' => array('className' => 'VenueDetail',
								'foreignKey' => 'venue_atmosphere_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'VenueDetail2' => array('className' => 'VenueDetail',
								'foreignKey' => 'venue_atmosphere_2_id',
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
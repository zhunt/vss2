<?php
class VenueCafeType extends AppModel {

	var $name = 'VenueCafeType';
    var $actsAs  = array('Containable', 'SdSlugger' );
    
	var $validate = array(
		'name' => array('notempty'),
		'slug' => array(
                    'unique' => array( 'rule' => 'isUnique', 'on' => 'create'),
                    'notempty' => array ('rule' => 'notempty')
                    ),
		'venue_cafe_type_count' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Venue' => array('className' => 'Venue',
                                        'foreignKey' => 'venue_cafe_type_id',
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

    /*
     * ===================================================================
     * Model functions
     */

    /*
     * getVenueCuisines
     * returns a list of cuisines
     */
     function getCafeTypes() {
         $this->contain();
         $result = $this->find('list', array('conditions' => array('venue_count >' => 0),
                                                'fields' => array('name','slug'),
                                                'order' => 'name') );

         return $result;
     }

}
?>
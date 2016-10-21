<?php
class VenueCuisineType extends AppModel {
    var $name = 'VenueCuisineType';
    var $actsAs  = array('Containable', 'SdSlugger' );

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
                                    'foreignKey' => 'venue_cuisine_type_id',
                                    'dependent' => false,


                    )
    );


    /*
     * ===================================================================
     * Model functions
     */
    

}
?>
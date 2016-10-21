<?php
class VenueDetail extends AppModel {

    var $name = 'VenueDetail';

    
    var $validate = array(
        'venue_id' => array('numeric'),
        //'website_url' => array('url'),
        'email' => array('rule' => 'email', 'allowEmpty' => true ),
        'social_1_url' => array('url'),
        'social_2_url' => array('url'),
        'phone_fax' => array('phone'),
        'phone_2' => array('phone')
    );

    //The Associations below have been created with all possible keys,
    // those that are not needed can be removed
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
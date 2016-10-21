<?php
class VenueFeature extends AppModel {

    var $name = 'VenueFeature';
    var $actsAs  = array('Containable', 'SdSlugger' );

    var $validate = array(
            'name' => array('notempty'),
            'slug' => array(
                'unique' => array( 'rule' => 'isUnique', 'on' => 'create'),
                'notempty' => array ('rule' => 'notempty')
                ),
            'flag_restaurant' => array('numeric'),
            'flag_bar' => array('numeric'),
            'flag_cafe' => array('numeric'),
            'flag_hotel' => array('numeric'),
            'flag_attraction' => array('numeric'),
            'flag_caterer' => array('numeric')
    );

    /*
     * ===================================================================
     * Model functions
     */

    /*
     * getVenueCuisines
     * returns a list of features
     * options
     * venueTypeId: filter by venue type (e.g. different features for bars than cafes)
     */
     function getFeaturesList( $options = null) {

         $conditions = array();

         if ( isset($options['venueTypeId']) && is_numeric($options['venueTypeId']) ) {
            switch( (int)$options['venueTypeId'] ) {
                case Configure::read('type.restaurant'):
                    $field = 'flag_restaurant';
                    break;
                case Configure::read('type.bar'):
                    $field = 'flag_bar';
                    break;
                case Configure::read('type.cafe'):
                    $field = 'flag_cafe';
                    break;
                case Configure::read('type.hotel'):
                    $field = 'flag_hotel';
                    break;
                case Configure::read('type.attraction'):
                    $field = 'flag_attraction';
                    break;
                case Configure::read('type.caterer'):
                    $field = 'flag_caterer';
                    break;
            }

            $conditions = array_merge($conditions, array('VenueFeature.' . $field => 1, 'venue_count >' => 0 ));
         }
        

         $this->contain();
         $result = $this->find('list', array('conditions' => $conditions,
                                                'fields' => array('name','slug'),
                                                'order' => 'name') );

      
         return $result;
     }

}
?>
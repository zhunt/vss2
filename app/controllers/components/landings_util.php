<?php
/*
 * utility functions for displaying landing pages
 */
class LandingsUtilComponent extends Object {

    function initialize(&$controller, $settings = array()) {
            // saving the controller reference for later use
            $this->controller =& $controller;
    }

    /*
     * Return an array of the Cities / City Regions with a count of the venues of
     * venue_type_id
     */
    function getCityCounts( $venueTypeId ) {

        if ( Cache::read('cityCounts_venueType_' . $venueTypeId ) ) {
            return ( Cache::read('cityCounts_venueType_' . $venueTypeId) );
        }
        else {
            // add additional venue_types if needed
            if ( $venueTypeId == Configure::read('type.restaurant') ) {
                $venueTypeId = array( Configure::read('type.restaurant'), Configure::read('type.restaurantBar') );
            }
            if ( $venueTypeId == Configure::read('type.bar') ) {
                $venueTypeId = array( Configure::read('type.bar'), Configure::read('type.restaurantBar') );
            }

            $this->controller->City->contain( array( 'CityRegion' => array('conditions' => array( 'venue_count >' => 0) ) ) );
            $cities = $this->controller->City->find('all', array( 'conditions' => array( 'venue_count >' => 0) ) );
            foreach( $cities as $i => $row ) {
                if ( !empty($row['City']['venue_count']) ) {
                    $this->controller->Venue->contain();
                    $total = $this->controller->Venue->find('count', array( 'conditions' =>
                                                            array('venue_type_id' => $venueTypeId,
                                                                'flag_published' => 1,
                                                                'city_id' => $row['City']['id'])
                                                            ));

                    $cities[$i]['City']['venue_total'] = $total;
                    unset($cities[$i]['City']['venue_count']);

                    //debug($total);
                }
                if (!empty( $row['CityRegion'] ) ) {
                    foreach($row['CityRegion'] as $j => $row2 ) {

                        $this->controller->Venue->contain();
                        $total = $this->controller->Venue->find('count', array( 'conditions' =>
                                                                array('venue_type_id' => $venueTypeId,
                                                                    'flag_published' => 1,
                                                                    'city_region_id' => $row2['id'])
                                                                ));

                        $cities[$i]['CityRegion'][$j]['venue_total'] = $total;
                        //debug($total);
                        
                        // if there are none of the venue_type in this region, remove region, else just the old venue_count
                        if ( $total < 1 )
                            unset($cities[$i]['CityRegion'][$j]);
                        else
                            unset($cities[$i]['CityRegion'][$j]['venue_count']);

                    }
                }
            }
            Cache::write('cityCounts_venueType_' . $venueTypeId, $cities );
            return($cities);
        }
    }

    /*
     * Gets a list of cuisines where there are (published) venues with this type
     */
    function getBarCounts() {

        if ( Cache::read('barTypeCounts') ) {
            return ( Cache::read('barTypeCounts') );
        }
        else {
            $bars = array();
            $barTypes = $this->controller->Venue->VenueBarType->find('all', array('order' => 'name ASC') );
            foreach( $barTypes as $row) {
                $barTypeId = $row['VenueBarType']['id'];

                $this->controller->Venue->VenueDetail->contain( array( 'Venue' => array( 'name', 'conditions' => array('flag_published' => 1) ) ) );

                $total = $this->controller->Venue->VenueDetail->find('count', array(
                                                                    'conditions' => array(
                                                                        'OR' => array(
                                                                            'venue_bar_type_2_id' => $barTypeId,
                                                                            'Venue.venue_bar_type_id' => $barTypeId
                                                                        ),
                                                                        'Venue.flag_published' => 1,
                                                                    )
                                                        )
                                                );

                if ( $total < 1 ) continue;

                array_push( $bars, array( 'slug' => $row['VenueBarType']['slug'],
                                                'name' => $row['VenueBarType']['name'],
                                                'count' => $total)
                                        );
            }
            Cache::write('barTypeCounts', $bars );
            return($bars);
        }
    }

    /*
     * Gets a list of cafe types where there are (published) venues with this type
     */
    function getCafeCounts() {

        if ( Cache::read('cafeTypeCounts') ) {
            return ( Cache::read('cafeTypeCounts') );
        }
        else {
            $cafes = array();
            $cafeTypes = $this->controller->Venue->VenueCafeType->find('all', array('order' => 'name ASC') );
            foreach( $cafeTypes as $row) {
                $barTypeId = $row['VenueCafeType']['id'];

                $this->controller->Venue->VenueDetail->contain( array( 'Venue' => array( 'name', 'conditions' => array('flag_published' => 1) ) ) );

                $total = $this->controller->Venue->VenueDetail->find('count', array(
                                                                    'conditions' => array(
                                                                        'OR' => array(
                                                                            'venue_cafe_type_2_id' => $barTypeId,
                                                                            'Venue.venue_cafe_type_id' => $barTypeId
                                                                        ),
                                                                        'Venue.flag_published' => 1,
                                                                    )
                                                        )
                                                );

                if ( $total < 1 ) continue;

                array_push( $cafes, array( 'slug' => $row['VenueCafeType']['slug'],
                                                'name' => $row['VenueCafeType']['name'],
                                                'count' => $total)
                                        );
            }
            Cache::write('cafeTypeCounts', $cafes );
            return($cafes);
        }
    }

    /*
     * Gets a list of venues that cater where there are (published) venues with this type
     */
    function getCateringCounts() {
        $cateringId = 8; // from venue_features table
        if ( Cache::read('cateringCounts') ) {
            return ( Cache::read('cateringCounts') );
        }
        else {
            $caters = array();
            $caterTypes = $this->controller->Venue->VenueCuisineType->find('all', array('order' => 'name ASC') );
            foreach( $caterTypes as $row) {
                $CuisineTypeId = $row['VenueCuisineType']['id'];

                $this->controller->Venue->VenueDetail->contain( array( 'Venue' => array( 'name', 'conditions' => array('flag_published' => 1) ) ) );

                $total = $this->controller->Venue->VenueDetail->find('count', array(
                                                                    'conditions' => array(
                                                                        'OR' => array(
                                                                            'venue_cuisine_type_2_id' => $CuisineTypeId,
                                                                            'venue_cuisine_type_3_id' => $CuisineTypeId,
                                                                            'venue_cuisine_type_4_id' => $CuisineTypeId,
                                                                            'Venue.venue_cuisine_type_id' => $CuisineTypeId
                                                                        ),
                                                                        'AND' => array( 'OR' => array( 'venue_feature_1_id' => $cateringId,
                                                                                                        'venue_feature_2_id' => $cateringId,
                                                                                                        'venue_feature_3_id' => $cateringId,
                                                                                                        'venue_feature_4_id' => $cateringId,
                                                                                                        'venue_feature_5_id' => $cateringId
                                                                                                    ) ),

                                                                        'Venue.flag_published' => 1,

                                                                    )
                                                        )
                                                );

                if ( $total < 1 ) continue;

                array_push( $caters, array( 'slug' => $row['VenueCuisineType']['slug'],
                                                'name' => $row['VenueCuisineType']['name'],
                                                'cuisineId' => $CuisineTypeId,
                                                'count' => $total)
                                        );
            }
            Cache::write('cateringCounts', $caters );
            return($caters);
        }
    }

    /*
     * Gets a list of cuisines where there are (published) venues with this type
     */
    function getCuisineCounts( $venueTypeId = null) {


            
        if ( Cache::read('cuisineCounts_venue_' . $venueTypeId ) ) {
            return ( Cache::read('cuisineCounts_venue_' . $venueTypeId) );
        }
        else {

            if ( $venueTypeId == Configure::read('type.restaurant') )
                $venueTypeId = array( Configure::read('type.restaurant'), Configure::read('type.restaurantBar') );

            $cuisines = array();
            $cusinesTypes = $this->controller->Venue->VenueCuisineType->find('all', array('order' => 'name ASC') );
            foreach( $cusinesTypes as $row) {
                $CuisineTypeId = $row['VenueCuisineType']['id'];

                $this->controller->Venue->VenueDetail->contain( array( 'Venue' => array( 'name', 'conditions' => 
                                                                                    array('flag_published' => 1,
                                                                                            'venue_type_id' => $venueTypeId ) ) ) );

                $total = $this->controller->Venue->VenueDetail->find('count', array(
                                                                    'conditions' => array(
                                                                        'OR' => array(
                                                                            'venue_cuisine_type_2_id' => $CuisineTypeId,
                                                                            'venue_cuisine_type_3_id' => $CuisineTypeId,
                                                                            'venue_cuisine_type_4_id' => $CuisineTypeId,
                                                                            'Venue.venue_cuisine_type_id' => $CuisineTypeId
                                                                        ),
                                                                        'Venue.flag_published' => 1,
                                                                    )
                                                        )
                                                );

                if ( $total < 1 ) continue;

                array_push( $cuisines, array( 'slug' => $row['VenueCuisineType']['slug'],
                                                'name' => $row['VenueCuisineType']['name'],
                                                'cuisineId' => $CuisineTypeId,
                                                'count' => $total)
                                        );
            }
            Cache::write('cuisineCounts_venue_' . $venueTypeId, $cuisines );
            return($cuisines);
        }
    }

    /*
     * Gets a list of features where there are (published) venues with this type
     */
    function getFeatureCounts( $venueTypeId) {

        if ( Cache::read('featureCounts_venueType_' . $venueTypeId) ) {
            return ( Cache::read('featureCounts_venueType_' . $venueTypeId) );
        }
        else {
            $field = $this->_getVenueTypeField($venueTypeId);
            // get all the features this venue_type can have
            $featureTypes = $this->controller->VenueFeature->find('all', array('conditions' => array( $field => 1 ), 'order' => 'name ASC') );

            $features = array();
            foreach( $featureTypes as $row) {
                $VenueFeatureTypeId = $row['VenueFeature']['id'];

                // add additional venue_types if needed
                if ( $venueTypeId == Configure::read('type.restaurant') ) {
                    $venueTypeId = array( Configure::read('type.restaurant'), Configure::read('type.restaurantBar') );
                }
                if ( $venueTypeId == Configure::read('type.bar') ) {
                    $venueTypeId = array( Configure::read('type.bar'), Configure::read('type.restaurantBar') );
                }

                $this->controller->Venue->VenueDetail->contain( array( 'Venue' => array( 'name',
                                                                    'conditions' =>
                                                                        array('flag_published' => 1, 'venue_type_id' => $venueTypeId )
                                                                    ) ) );

                $total = $this->controller->Venue->VenueDetail->find('count', array(
                                                                    'conditions' => array(
                                                                        'OR' => array(
                                                                            'venue_feature_1_id' => $VenueFeatureTypeId,
                                                                            'venue_feature_2_id' => $VenueFeatureTypeId,
                                                                            'venue_feature_3_id' => $VenueFeatureTypeId,
                                                                            'venue_feature_4_id' => $VenueFeatureTypeId,
                                                                            'venue_feature_5_id' => $VenueFeatureTypeId
                                                                        ),
                                                                        'Venue.flag_published' => 1,
                                                                    )
                                                        )
                                                );

                if ( $total < 1 ) continue;

                array_push( $features, array( 'slug' => $row['VenueFeature']['slug'],
                                                'name' => $row['VenueFeature']['name'],
                                                'count' => $total)
                                        );
            }
           // debug($features);exit();
            Cache::write('featureCounts_venueType_' . $venueTypeId, $features );
            return($features);
        }
    }

    /*
     * Gets a list of features where there are (published) venues with this type
     */
    function getAmenitiesCounts( $venueTypeId) {

        if ( Cache::read('amenityCounts_venueType_' . $venueTypeId) ) {
            return ( Cache::read('amenityCounts_venueType_' . $venueTypeId) );
        }
        else {
            $field = $this->_getVenueTypeField($venueTypeId);
            // get all the features this venue_type can have
            $featureTypes = $this->controller->VenueAmenity->find('all', array('conditions' => array( $field => 1 ), 'order' => 'name ASC') );

            $amenities = array();
            foreach( $featureTypes as $row) {
                $VenueAmenityTypeId = $row['VenueAmenity']['id'];

                // add additional venue_types if needed
                if ( $venueTypeId == Configure::read('type.restaurant') ) {
                    $venueTypeId = array( Configure::read('type.restaurant'), Configure::read('type.restaurantBar') );
                }
                if ( $venueTypeId == Configure::read('type.bar') ) {
                    $venueTypeId = array( Configure::read('type.bar'), Configure::read('type.restaurantBar') );
                }

                $this->controller->Venue->VenueDetail->contain( array( 'Venue' => array( 'name',
                                                                        'conditions' =>
                                                                            array('flag_published' => 1, 'venue_type_id' => $venueTypeId )
                                                                        ) ) );

                $total = $this->controller->Venue->VenueDetail->find('count', array(
                                                                    'conditions' => array(
                                                                        'OR' => array(
                                                                            'venue_amenity_1_id' => $VenueAmenityTypeId,
                                                                            'venue_amenity_2_id' => $VenueAmenityTypeId,
                                                                            'venue_amenity_3_id' => $VenueAmenityTypeId,
                                                                            'venue_amenity_4_id' => $VenueAmenityTypeId,
                                                                            'venue_amenity_5_id' => $VenueAmenityTypeId
                                                                        ),
                                                                        'Venue.flag_published' => 1,
                                                                    )
                                                        )
                                                );
                 //debug($total);
                if ( $total < 1 ) continue;

                array_push( $amenities, array( 'slug' => $row['VenueAmenity']['slug'],
                                                'name' => $row['VenueAmenity']['name'],
                                                'count' => $total)
                                        );
            }
           //debug($amenities);exit();
            Cache::write('amenityCounts_venueType_' . $venueTypeId, $amenities );
            return($amenities);
        }
    }

    /*
     * Utility function to get the field that needs to be set to TRUE for a
     * feature to apply to a venue_type
     */
    function _getVenueTypeField( $venueTypeId ) {
        switch( (int)$venueTypeId ) {
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
            default:
                $this->log('invalid type passed into _getVenueTypeField: ' . $venueTypeId );
                exit();
        }
        return($field);
    }
}

?>

<?php
class Venue extends AppModel {

    var $name = 'Venue';
    var $actsAs = array('Sluggable' => array('overwrite' => false), 'Expandable');

    

    var $validate = array(
        'name' => array('notempty'),
        'slug' => array('rule' => 'notempty', 'on' => 'update'),
        'address' => array('notempty'),
        'geo_lat' => array('numeric'),
        'geo_lng' => array('numeric'),
        'phone' => array( 'rule' => array('minLength', 12) ),
        'city_id' => array('numeric'),
        'city_region_id' => array( 'rule' => 'numeric', 'allowEmpty' => true ),
        'city_neighbourhood_id' => array( 'rule' => 'numeric', 'allowEmpty' => true ),
        'publish_state_id' => array('numeric'),
        //'chain_id' => array('numeric')
    );

    var $virtualFields = array(
    'full_name' => 'CONCAT(Venue.name, " ", Venue.sub_name)'
    );


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
                        'counterCache' => true,
                        'counterScope' => array('Venue.publish_state_id' => VENUE_PUBLISHED )
		),
		'CityRegion' => array(
			'className' => 'CityRegion',
			'foreignKey' => 'city_region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CityNeighbourhood' => array(
			'className' => 'CityNeighbourhood',
			'foreignKey' => 'city_neighbourhood_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Intersection' => array(
			'className' => 'Intersection',
			'foreignKey' => 'intersection_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Intersection.name'
		),
		'PublishState' => array(
			'className' => 'PublishState',
			'foreignKey' => 'publish_state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ClientType' => array(
			'className' => 'ClientType',
			'foreignKey' => 'client_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Chain' => array(
			'className' => 'Chain',
			'foreignKey' => 'chain_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Chain.name ASC'
		)
	);

	var $hasOne = array(
		'RestaurantHour' => array(
			'className' => 'RestaurantHour',
			'foreignKey' => 'venue_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'VenueDetail' => array(
			'className' => 'VenueDetail',
			'foreignKey' => 'venue_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'VenueScore' => array(
			'className' => 'VenueScore',
			'foreignKey' => 'venue_id',
			'dependent' => true
		),
		'VenueView' => array(
			'className' => 'VenueView',
			'foreignKey' => 'venue_id',
			'dependent' => true
		)
	);

	var $hasMany = array(
                'VenueField',
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'venue_id',
			'dependent' => false,
			'conditions' => array('Comment.comment_status_id' => COMMENT_PUBLISHED ),
			'fields' => '',
			'order' => 'Comment.created DESC',
			'limit' => '10',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'VssPage' => array(
			'className' => 'VssPage',
			'foreignKey' => 'venue_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		), /*
		'VenueMeta' => array(
			'className' => 'VenueMeta',
			'foreignKey' => 'venue_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		) */
	);

	var $hasAndBelongsToMany = array(
		'VenueAmenity' => array(
			'className' => 'VenueAmenity',
			'joinTable' => 'venues_venue_amenities',
			'foreignKey' => 'venue_id',
			'associationForeignKey' => 'venue_amenity_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'VenueProduct' => array(
			'className' => 'VenueProduct',
			'joinTable' => 'venues_venue_products',
			'foreignKey' => 'venue_id',
			'associationForeignKey' => 'venue_product_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'VenueService' => array(
			'className' => 'VenueService',
			'joinTable' => 'venues_venue_services',
			'foreignKey' => 'venue_id',
			'associationForeignKey' => 'venue_service_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'VenueSubtype' => array(
			'className' => 'VenueSubtype',
			'joinTable' => 'venues_venue_subtypes',
			'foreignKey' => 'venue_id',
			'associationForeignKey' => 'venue_subtype_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'VenueType' => array(
			'className' => 'VenueType',
			'joinTable' => 'venues_venue_types',
			'foreignKey' => 'venue_id',
			'associationForeignKey' => 'venue_type_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

     /*
      * Returns array of featured venues
      * name, subname, thumb photo, description text, address, city, region,
      * cuisine/bar type/cafe type/hotel type/attraction type
      * $options will have differnt sorting types
      */
     function getFeaturedListings( $num, $options = null) {

         $onlyVenueTypeId = null;
         $finalLength = $num; // the number to be returned
         if ( isset($options['venueTypeId'])) {
            $onlyVenueTypeId = intval($options['venueTypeId']);
            $num = $num * 5; // multiply in case 5 have to throw out some venue of the wrong type
         }

         // first get the number of listing we want
         $venues = $this->find('list', array(
                'conditions' => array(
                    'Venue.publish_state_id' => Configure::read('Venue.published'),
                    'Venue.client_type_id' => Configure::read('ClientType.premium'),
                    
                ),
                'fields' => array('id', 'slug'),
                'order' => 'rand()',
                //'limit' => $num 
				)
                );
         
         if ( !$venues)
             return false; // no featured listings

         $featuredVenues = array();
         foreach( $venues as $id => $slug ) { 
            // check if the entry has been cached
            if ( Cache::read('featured_venue_' . $slug ) ) {
                // if so, add that that
                $featuredVenues[] = Cache::read('featured_venue_' . $slug );
            }else { 
                // else, load in the venue data, process and add
                $result = $this->find('first',
                    array(
                    'contain' => array(
                        'VenueField',
                        'VenueDetail',
                        'City.name',
                        'VenueType',
                        'VenueSubtype',
                        'VenueService'
                     ),
                     'conditions' => array('Venue.id' => $id ),
                     'fields' => array( 'Venue.name','Venue.sub_name', 'Venue.slug', 'Venue.address',
                                        'VenueDetail.description'
                     ),
                     'order' => array('rand()'),
                     'limit' => 1
                    )
                );

                $result['VenueDetail']['description'] = Sanitize::html($result['VenueDetail']['description'], array('remove' => true) );
                
                if ( isset($result['VenueService'])) {
                    $result['services'] = Set::extract( 'VenueService/name',
                                            $result['VenueService']);
                }
                if ( isset($result['VenueProduct'])) {
                    $result['products'] = Set::extract( 'VenueProduct/name',
                                            $result['VenueProduct']);
                }
                if ( isset($result['VenueAmenity'])) {
                    $result['amenities'] = Set::extract( 'VenueAmenity/name',
                                            $result['VenueAmenity']);
                }
                if ( isset($result['VenueType'])) {
                    $result['venueTypes'] = Set::extract( 'VenueType/name',
                                            $result['VenueType']);
                }
                if ( isset($result['VenueSubtype'])) {
                    $result['venueSubtype'] = Set::extract( 'VenueSubtype/name',
                                            $result['VenueSubtype']);
                }
                
                
                Cache::write('featured_venue_' . $result['Venue']['slug'], $result );
                $featuredVenues[] = $result;
            }
      
         }

        // option to filter out any feature venue that is not the right type
         
        if ( $onlyVenueTypeId != null ) {
            foreach ($featuredVenues as $i => $venue) {
                $match = false; // check the Id of venue_types accoc. with this one
                foreach( $venue['VenueType'] as $j => $type) {
                    if ($type['id'] == $onlyVenueTypeId)
                        $match = true;
                }
                if ($match == false)
                    unset($featuredVenues[$i]);
            }
        }

        $featuredVenues = array_slice($featuredVenues, 0, $finalLength);
        
        return($featuredVenues);
     }

    /* based on the latt/long passed in, get a list of venues a distance from that point
     * fucntion returns distance in Km
     */
    function getNearbyVenues( $lat, $lng, $venueId = null) {
            $distance = 10; // 1 = 1000 metres, 10 = 10km 
            $limit = 10;

            $venueLat = floatval($lat);
            $venueLng = floatval($lng);

            $result = $this->find('all',
                    array('fields' => array(
                        'Venue.id', 'Venue.full_name', 'Venue.slug',
                            'Venue.address', 'Venue.geo_lat',
                            'Venue.geo_lng',
                        '(6371 * acos( cos( radians(' . $venueLat . ') ) * cos( radians( geo_lat ) ) *
                                cos( radians( geo_lng ) - radians('. $venueLng .') ) + sin( radians(' . $venueLat . ') ) *
                                sin( radians( geo_lat ) ) ) ) AS distance'

                    ),
                    'conditions' => array(
                        'Venue.publish_state_id' => Configure::read('Venue.published'),
                        'Venue.id !=' => $venueId
                        ),
                    'group' => array( "Venue.id HAVING distance <= $distance"),
                    'order' => 'distance',
                    'limit' => $limit,
                    'contain' => array('City.name', 'VenueType.name', 'VenueSubtype.name' )
                    ) );

                   //debug($result); exit;
            if ($result) {
                    return($result);
            } else {
                    return false;
            }
    }
	
    /* based on the latt/long passed in, get a list of venues and their city_region and intersection
     * fucntion returns distance in Km
	 * Used when adding new venue to guess the nearest intersection / city_region / neighbourhood
     */
    function getNearbyVenueIntersection( $lat, $lng, $venueId = null) {
            $distance = 10; // 1 = 1000 metres, 10 = 10km 
            $limit = 10;

            $venueLat = floatval($lat);
            $venueLng = floatval($lng);

            $result = $this->find('all',
                    array('fields' => array(
                        'Venue.id', 'Venue.name', 'Venue.slug',
                            'Venue.address', 'Venue.geo_lat',
                            'Venue.geo_lng',
                        '(6371 * acos( cos( radians(' . $venueLat . ') ) * cos( radians( geo_lat ) ) *
                                cos( radians( geo_lng ) - radians('. $venueLng .') ) + sin( radians(' . $venueLat . ') ) *
                                sin( radians( geo_lat ) ) ) ) AS distance'

                    ),
                    'conditions' => array(
                        'Venue.publish_state_id' => Configure::read('Venue.published'),
                        'Venue.id !=' => $venueId
                        ),
                    'group' => array( "Venue.id HAVING distance <= $distance"),
                    'order' => 'distance',
                    'limit' => $limit,
                    'contain' => array('City.name', 'CityRegion.name',  'CityNeighbourhood.name', 'Intersection.name' )
                    ) );

                   //debug($result); exit;
            if ($result) {
                    return($result);
            } else {
                    return false;
            }
    }	

}
?>
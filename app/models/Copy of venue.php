<?php
class Venue extends AppModel {

	var $name = 'Venue';
    var $actsAs  = array('Containable' ); // 'SdSlugger'
    
	var $validate = array(
		'name' => array('notempty'),
		/* 'subname' => array('notempty'), */
		'slug' => array(
                    'unique' => array( 'rule' => 'isUnique', 'on' => 'create'),
                    'notempty' => array ('rule' => 'notempty')
                    ),
		'city_id' => array('numeric'),
		/*'intersection_id' => array('numeric'), */
		'client_type_id' => array('numeric'),
		'flag_published' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'City' => array('className' => 'City',
								'foreignKey' => 'city_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'CityRegion' => array('className' => 'CityRegion',
								'foreignKey' => 'city_region_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'InsideVenue' => array('className' => 'Venue',
								'foreignKey' => 'inside_venue_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'VenueType' => array('className' => 'VenueType',
								'foreignKey' => 'venue_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'VenueCuisineType' => array('className' => 'VenueCuisineType',
								'foreignKey' => 'venue_cuisine_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'VenueBarType' => array('className' => 'VenueBarType',
								'foreignKey' => 'venue_bar_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'VenueCafeType' => array('className' => 'VenueCafeType',
								'foreignKey' => 'venue_cafe_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'VenueCaterType' => array('className' => 'VenueCaterType',
								'foreignKey' => 'venue_cater_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'VenueHotelType' => array('className' => 'VenueHotelType',
								'foreignKey' => 'venue_hotel_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'VenueAttractionType' => array('className' => 'VenueAttractionType',
								'foreignKey' => 'venue_attraction_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'VenueChain' => array('className' => 'VenueChain',
								'foreignKey' => 'venue_chain_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
                                'counterCache' => true
			),
			'Intersection' => array('className' => 'Intersection',
								'foreignKey' => 'intersection_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'ClientType' => array('className' => 'ClientType',
								'foreignKey' => 'client_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasOne = array(
			'VenueDetail' => array('className' => 'VenueDetail',
								'foreignKey' => 'venue_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'VenueRating' => array('className' => 'VenueRating',
								'foreignKey' => 'venue_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'VenueVisit' => array('className' => 'VenueVisit',
								'foreignKey' => 'venue_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'VenueComment' => array('className' => 'VenueComment',
								'foreignKey' => 'venue_id',
								'dependent' => true,
								'conditions' => '',
								'fields' => '',
								'order' => 'created DESC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);
	
	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'tags_venues',
			'foreignKey' => 'venue_id',
			'associationForeignKey' => 'tag_id',
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
     * ======================================================================
     * Model functions
     *
     */
     
     /*
      * Returns array of featured venues
      * name, subname, thumb photo, description text, address, city, region,
      * cuisine/bar type/cafe type/hotel type/attraction type
      * $options will have differnt sorting types
      */
     function getFeaturedListings( $num, $options = null) {
        App::import('Sanitize');

        $this->contain( array('VenueDetail' => array('description', 'photo_1_thumb'),
                                'City.name', 'CityRegion.name',
                                'VenueType.name', 'VenueCuisineType.name',
                                'VenueBarType.name', 'VenueCafeType.name',
                                'VenueHotelType.name',
                                'VenueAttractionType.name') ) ;

        $result = $this->find('all',
                    array(
                     'conditions' => array('flag_published' => 1, 'client_type_id' => 3),
                     'fields' => array('Venue.name','Venue.subname', 'Venue.slug', 'Venue.address',
                                        'VenueDetail.description', 'VenueDetail.photo_1_thumb','Venue.created' ),
                     'order' => array('rand()'), 'limit' => $num)
                    );

        if ($result) {
            foreach($result as $i => $row) {
                // Sanitize::html($badString, true);
                $result[$i]['VenueDetail']['description'] = Sanitize::html($row['VenueDetail']['description'], true);
            }
        }
        // debug($result);
        // exit();
        return($result);
     }

     /*
      * Returns an array of new listings
      * name, subname, slug, address, city
      * params:
      * venueTypeId: match those with this id type
      * city: match those with city slug of this type
      */
     function getNewListings( $num, $options = null) {

         if ( empty($options) ) {
             $this->contain( array('City' => array('name')));
             $result = $this->find('all',
                        array(
                            'conditions' => array('flag_published' => 1),
                            'fields' => array('Venue.name','Venue.subname', 'Venue.slug', 'Venue.address', 'Venue.created'),
                            'order' => array('Venue.created DESC'), 'limit' => $num
                        ) );
             return($result);
         }

         // there are options set, handle them here
         $conditions = array('flag_published' => 1);
         if ( isset($options['venueTypeId']) && !empty($options['venueTypeId']) )
            $conditions = array_merge( $conditions, array( 'Venue.venue_type_id' => $options['venueTypeId'] ) );
         if ( isset($options['city']) && !empty($options['city']) )
            $conditions = array_merge( $conditions, array( 'City.slug' => $options['city'] ) );

         $this->contain( array('City' => array('name', 'slug')));
         $result = $this->find('all',
                    array(
                        'conditions' => $conditions,
                        'fields' => array('Venue.name','Venue.subname', 'Venue.slug', 'Venue.address', 'Venue.created'),
                        'order' => array('Venue.created DESC'), 'limit' => $num
                    ) );

         return($result);
     }

     /*
      * Returns array of highest-rated venues
      */
     function getPopularListings( $num, $options = null) {
         $this->contain( array('City.name', 'VenueRating' => array('score', 'votes'), 'VenueVisit.visits' ));
         $result = $this->find('all',
                    array(
                        'conditions' => array('flag_published' => 1),
                        'fields' => array('Venue.name','Venue.subname', 'Venue.slug', 'Venue.address', 'Venue.created', 
                                            'VenueVisit.visits',
                                            'VenueRating.score',
                                            'VenueRating.votes',
                                    ),
                        'order' => array( 'VenueRating.score DESC', 'VenueVisit.visits DESC'), 'limit' => $num
                    ) );
                
         //debug($result);
         //exit;
         return($result);

     }


}
?>
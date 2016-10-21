<?php
/*
 * Used for public side of website to diesplay venues
 */

class ProfilesController extends AppController {

    var $name = 'Profiles';
    var $uses = array('Venue');
    var $components = array('ProfileUtil', 'Cookie');
    var $helpers = array('Text', 'Form', 'Profile', 'Time', 'Cache');

    var $cacheAction = array('view' => '1 week');

	function view2($id = null) {
	
        if ( is_null($id))
            $id = $this->params['slug'];
            
        App::import('Sanitize');
        $id = Sanitize::paranoid($id, array('-') );
        
		$this->Venue->recursive = 2;
		$result = $this->Venue->find( 'first', array( 'conditions' => 
											array('Venue.flag_published' => 1,
													'Venue.slug' => $id),
									));
          
        if(!$result)
            $this->cakeError('error404',array(array('url'=>'/')));

        $this->set('venue', $result);

		$this->autoRender = false;
		echo json_encode($result);
		exit;
	}
	
    function view( $id = null) {

        if ( is_null($id))
            $id = $this->params['slug'];
            
        App::import('Sanitize');
        $id = Sanitize::paranoid($id, array('-') );

        $this->loadModel('VenueComment');
        
        // check if chached
        $result = Cache::read('venue_' . $id );
        if ( $result == false ) {

            
            $this->Venue->contain( array(
                        'VenueDetail' => array(
                            'meta_keywords', 'meta_desc', 'description', 'postal',
                            'website_url', 'email', 'photo_1',
                            'hours_sun', 'hours_mon', 'hours_tue', 'hours_wed',
                            'hours_thu', 'hours_fri', 'hours_sat',
                            'flag_creditcard', 'flag_bankcard', 'flag_cash', 'flag_atm',
                            'phone2', 'phone2_txt',
                            'VenueCuisineType2' => array('name', 'slug'),
                            'VenueCuisineType3' => array('name', 'slug'),
                            'VenueCuisineType4' => array('name', 'slug'),
                            'VenueBarType2' => array('name', 'slug'),
                            'VenueCafeType2' => array('name', 'slug'),
                            'VenueCaterType2' => array('name', 'slug'),
                            'VenueHotelType2' => array('name', 'slug'),
                            'VenueAttractionType2' => array('name', 'slug'),
                            'VenueFeature1' => array('name', 'slug'),
                            'VenueFeature2' => array('name', 'slug'),
                            'VenueFeature3' => array('name', 'slug'),
                            'VenueFeature4' => array('name', 'slug'),
                            'VenueFeature5' => array('name', 'slug'),
                            'VenueAmenity1' => array('name', 'slug'),
                            'VenueAmenity2' => array('name', 'slug'),
                            'VenueAmenity3' => array('name', 'slug'),
                            'VenueAmenity4' => array('name', 'slug'),
                            'VenueAmenity5' => array('name', 'slug'),
                            'VenuePrice' => array('name', 'slug'),
                            'VenueDressCode' => array('name', 'slug'),
                            'VenueAtmosphere1'  => array('name', 'slug'),
                            'VenueAtmosphere2'  => array('name', 'slug'),
                        ),
                        'Intersection' => array('name', 'slug'),
                        'City' => array('name', 'slug'),
                        'CityRegion' => array('name', 'slug') ,
                        'InsideVenue' => array('name', 'slug'),
                        'VenueChain' => array('name', 'slug'),
                        'VenueType' => array('name', 'slug'),
                        'VenueCuisineType' => array('name', 'slug'),
                        'VenueBarType' => array('name', 'slug'),
                        'VenueCafeType' => array('name', 'slug'),
                        'VenueCaterType' => array('name', 'slug'),
                        'VenueHotelType' => array('name', 'slug'),
                        'VenueAttractionType' => array('name', 'slug'),
                        'VenueRating' => array('score', 'votes')
                        ) );
                    
            $result = $this->Venue->find( 'first', array( 'conditions' => 
                                                array('Venue.flag_published' => 1,
                                                        'Venue.slug' => $id),
                                        ));

            Cache::write('venue_' . $id, $result );
        }
        //debug($result);
        //exit();
        if(!$result)
            $this->cakeError('error404',array(array('url'=>'/')));


        // get the nearby venues:
        $nearbyVenues = $this->_getNearByVenues($result['Venue']['geo_latt'], $result['Venue']['geo_long']);

        $this->set('nearbyVenues', $nearbyVenues);


        $this->set('cuisines', $this->ProfileUtil->getCuisines($result) );
        $this->set('amenities', $this->ProfileUtil->getAmenities($result) );
        $this->set('features', $this->ProfileUtil->getFeatures($result) );
        $this->set('venueTypes', $this->ProfileUtil->getVenueTypes($result) );
        $this->set('payment', $this->ProfileUtil->getPaymentTypes($result) );
        $this->set('atmosphere', $this->ProfileUtil->getAtmosphere($result) );
        $this->set('dresscode', $this->ProfileUtil->getDresscode($result) );
        $this->set('pricerange', $this->ProfileUtil->getPricerange($result) );

        if ( $result['VenueRating']['score']) {
            $this->set('venueScore', round($result['VenueRating']['score']) );
            $this->set('venueVotes', $result['VenueRating']['votes'] );
        } else {
            $this->set('venueScore', 0 );
            $this->set('venueVotes', 0 );
        }
        $venueId = $result['Venue']['id'];
        $this->set('venueComments', $this->VenueComment->getRecentComments( $venueId));

        $this->set('venue', $result);

        // check if user has visted this venue
        // load in the user's cookie
        $this->Cookie->name = 'VenueRating';
        $userVisits = $this->Cookie->read('venueVisitList');

        if ( !is_array($userVisits) )
            $userVisits = array();

        // check if venue_id is already in array, if so, return message and exit
        if ( array_search( $venueId, $userVisits) === false ){
            $this->Venue->VenueVisit->addAVisit($venueId);
            array_push($userVisits, $venueId);
            $this->Cookie->write( 'venueVisitList', $userVisits, $encrypt = true, 3600 * 24 * 30);
           
        }

    }

    /*
     * Nearby venues
     */
	// based on the latt/long passed in, get a list of venues a distance from that point
	function _getNearByVenues( $venueLatt, $venueLong ) {
		$distance = 1; // 1000 metres

		$venueLatt = floatval($venueLatt);
		$venueLong = floatval($venueLong);

		$result1 = $this->Venue->query( "SELECT Venue.name, Venue.subname, Venue.slug, Venue.address, Venue.geo_latt, Venue.geo_long, Venue.slug, Venue.flag_published,
								(6371 * acos( cos( radians( $venueLatt ) ) * cos( radians( geo_latt ) ) *
									cos( radians( geo_long ) - radians( $venueLong ) ) + sin( radians( $venueLatt ) ) *
									sin( radians( geo_latt ) ) ) ) AS distance,
									VenueType.name

								FROM venues As Venue
								LEFT JOIN `venue_types` AS `VenueType` ON (`Venue`.`venue_type_id` = `VenueType`.`id`)
								HAVING distance <= $distance AND Venue.flag_published = 1
								ORDER BY distance
								LIMIT 1 , 10;");

               

               /* //debug($calc);
                $this->Venue->contain('VenueType.name');
                $result2 = $this->Venue->find('all', array(
                                'fields' => array( 'Venue.name', 'Venue.subname', 'Venue.slug', 'Venue.address',
                                                    "6371 * acos( cos( radians( {$venueLatt} ) ) *
                                                        cos( radians( geo_latt ) ) *
                                                        cos( radians( geo_long ) - radians( {$venueLong} ) ) +
                                                        sin( radians( {$venueLatt} ) ) * sin( radians( geo_latt ) ) ) AS distance "
                                                    ),

                                'conditions' => array( 'distance <=' => $distance, 'Venue.flag_published' => 1), //'distance <=' => $distance,
                                'order' => ' `distance` ASC ',
                                'limit' => array() //'1,10'
                                )
                            );

                debug($result1);debug($result2); exit(); */

                //debug($result1);
		if ($result1) {
			return($result1);
		} else {
			return false;
		}
	}

    /*
     * called inside element
     */
    function newest_listings( $num = 1) {
        $num = (int)$this->params['named']['num'];
        $num = ( $num < 1) ? 1 : $num;

        $options = array();
        if ( isset($this->params['named']['venueTypeId']) )
            $options['venueTypeId'] = (int)$this->params['named']['venueTypeId'];

        return( $this->Venue->getNewListings( $num, $options ) );

    }

    /*
     * called inside element
     */
    function popular_listings() {
        $num = (int)$this->params['named']['num'];
        $num = ( $num < 1) ? 1 : $num;
        return( $this->Venue->getPopularListings( $num ) );

    }

    /*
     * called inside element
     */
    function visitor_recommendations() {
        $num = (int)$this->params['named']['num'];
        $num = ( $num < 1) ? 1 : $num;
        return( $this->Venue->VenueComment->getNewestComments( $num ) );
    }

}
?>

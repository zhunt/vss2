<?php
class LandingsController extends AppController {
    var $name = 'Landings';
    var $uses = array('Venue');
    var $helpers = array('Text', 'Time', 'Venues', 'Cache'); // 

    var $components = array('Wordpress');

    var $post = null;
   

    var $cacheAction = array(
        'home' => '1 week',
        'computer_venues' => '1 week',
        'cafe_venues' => '1 week',
        'resource_venues' => '1 week',
        'venue_type' => '1 week'
   );


    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    function about_us() {
        $this->set( 'title_for_layout', 'About SimcoeDining');
        $this->set('metaDescription', 'Simcoe Dining is a guide to restaurants, bars, cafes and hotels in the Barrie area launched in 2006.');
    }
	
    function advertise() {
        $this->set( 'title_for_layout', 'Advertise on SimcoeDining');
        $this->set('metaDescription', 'Advertising information for SimcoeDining.');
    }	
	
    function links() {
        $this->set( 'title_for_layout', 'Related Links');
        $this->set('metaDescription', 'Friends of Simcoe Dining.');
    }	

    function home() {



        // get featured venues
        $this->set( 'title_for_layout', 'SimcoeDining.com : Barrie Restaurants and bars');
        $this->set('metaDescription', 'Guide to restaurants, bars and cafes in and around Barrie, Collingwood, Blue Mountain, Wasaga, Orillia and surrounding areas.');
        
        $cacheName = 'landing_homePage';
        $cacheData = Cache::read($cacheName);
        if ( $cacheData) {
            $newVenues = $cacheData['newVenues'];
            $popularVenues = $cacheData['popularVenues'];
            $featuredVenues = $cacheData['featuredVenues'];

            $featureArticle = $cacheData['featureArticle'];
            $latestArticle = $cacheData['latestArticle'];

        } else {

            $this->loadModel('Venue');
            $featuredVenues = $this->Venue->getFeaturedListings(3); 
            $cacheData['featuredVenues'] = $featuredVenues;

            $featureArticle = $this->_getWPPostIntro($num = 1, $sticky = true);
            $cacheData['featureArticle'] = $featureArticle;

            $latestArticle = $this->_getWPPostIntro($num = 2, $sticky = false, $imageType = 'front_newest');
            $cacheData['latestArticle'] = $latestArticle;

            // get newest venues
            $newVenues =
                $this->Venue->find('all', array(
                    'conditions' => array('Venue.publish_state_id' => Configure::read('Venue.published') ),
                    'order' => 'Venue.created DESC',
                   // 'fields' => array('Venue.name', 'Venue.slug', 'Venue.photo_1'),
                    'contain' => array('VenueType.name', 'VenueSubtype.name', 'VenueField', 'City.name' ),
                    'limit' => 100
                ) );

            foreach ( $newVenues as $i => $venue) {
                //debug($venue);
                $photo = $this->_getVenueFieldValue($venue['VenueField'], 'photo_1');
                if ($photo == '') {
                    unset( $newVenues[$i]);
                }
            }
            // finally trim down to 5 items
            $newVenues = array_slice($newVenues,0,5);
            $cacheData['newVenues'] = $newVenues;


            // get popular venues
            $popularVenues =
                $this->Venue->find('all', array(
                    'conditions' => array('Venue.publish_state_id' => Configure::read('Venue.published') ),
                    'order' => array( 'VenueScore.score DESC' ),
                    //'fields' => array('Venue.name', 'Venue.slug', 'VenueRating.score', 'Venue.photo_1'),
                    'contain' => array('VenueScore', 'VenueType.name', 'VenueSubtype.name', 'VenueField', 'City.name' ),
                    'limit' => 6
                ) );
            
            $cacheData['popularVenues'] = $popularVenues;


            //debug($cacheData);
            Cache::write($cacheName, $cacheData );
        }
            
            
        $this->set( compact('newVenues', 'popularVenues', 'featuredVenues', 'featureArticle', 'latestArticle'));
        
    }
	
	function newsletter() {
        
        $venueTypesId = array(5);
        $category = 'Books';

        $this->_getLandingPageInfo($venueTypesId, $category, 'computers');
    }


    /*
     * landing page for cafe venues
     */
    function cafe_venues() {
        $venueTypesId = array(1,2,3);
        $category = 'Venues';

        $this->_getLandingPageInfo($venueTypesId, $category, 'cafes');

       // get list of newest venues of type
        $newListings = $this->Venue->VenueType->find('all', array( 'conditions' => array('VenueType.id' => 1 ),
        'contain' => array(
            'Venue' => array('name', 'slug', 'address', 'created', 'publish_state_id = ' . Configure::read('Venue.published'),
                                'City.name',
                                'limit' => 3, 'order' => 'created DESC' ) ),
        ) );

        $this->set('newListings', $newListings);

    }

    function computer_venues() {
        
        $venueTypesId = array(5);
        $category = 'Books';

        $this->_getLandingPageInfo($venueTypesId, $category, 'computers');
    }

    function resource_venues() {

        $venueTypesId = array(7); // service
        $category = 'Books';

        $this->_getLandingPageInfo($venueTypesId, $category, 'services');
    }

    /*
     * used as landing page for some venues types
     */
    function venue_type( $type = 'restaurant') {
        $this->loadModel('Venue');

        switch ($type) {
        case 'restaurant':
            $this->_getLandingPageInfo(1, 0, 'restaurant_landing');
            $this->set('venueTypeName', 'Restaurants');
            $this->set('venueTypeSlug', 'restaurant');
            $this->set('cssId', '#hnav_rest');
            $featuredVenues = $this->Venue->getFeaturedListings(9, array('venueTypeId' => 1) );
            $this->set('title_for_layout', 'Barrie restaurants, Collingwood, Blue Mountain, features and amenities');
            $this->set('metaDescription', 'Restaurants in and around Barrie, Collingwood, Blue Mountain, Wasaga, Orillia and surrounding areas.');
            break;
        case 'bar':
            $this->_getLandingPageInfo(2, 0, 'bar_landing');
            $this->set('venueTypeName', 'Bars and Clubs');
            $this->set('venueTypeSlug', 'bar');
            $this->set('cssId', '#hnav_bar');
            $featuredVenues = $this->Venue->getFeaturedListings(9, array('venueTypeId' => 2) );
            $this->set('title_for_layout', 'Barrie bars and clubs, Collingwood, Blue Mountain, features and amenities');
            $this->set('metaDescription', 'Bars, pubs, lounges and night-clubs in and around Barrie, Collingwood, Blue Mountain, Wasaga, Orillia and surrounding areas.');
            break;
        case 'cafe':
            $this->_getLandingPageInfo(3, 0, 'cafe_landing');
            $this->set('venueTypeName', 'Cafes');
            $this->set('venueTypeSlug', 'cafe');
            $this->set('cssId', '#hnav_cafe');
            $featuredVenues = $this->Venue->getFeaturedListings(9, array('venueTypeId' => 3) );
            $this->set('title_for_layout', 'Barrie cafes, Collingwood, Blue Mountain, features and amenities');
            $this->set('metaDescription', 'Cafes, coffee shops and markets in and around Barrie, Collingwood, Blue Mountain, Wasaga, Orillia and surrounding areas.');
            break;
        case 'hotel':
            $this->_getLandingPageInfo(4, 0, 'hotel_landing');
            $this->set('venueTypeName', 'Hotels');
            $this->set('venueTypeSlug', 'hotel');
            $this->set('cssId', '#hnav_hotel');
            $featuredVenues = $this->Venue->getFeaturedListings(3, array('venueTypeId' => 4) );
            $this->set('title_for_layout', 'Barrie Hotels, Collingwood, Blue Mountain, features and amenities');
            $this->set('metaDescription', 'Hotels and motels in and around Barrie, Collingwood, Blue Mountain, Wasaga, Orillia and surrounding areas.');
            break;
        default:
            $this->_getLandingPageInfo(1, 0, 'restaurant_landing');
            $this->set('venueTypeName', 'Restaurants');
            $this->set('venueTypeSlug', 'restaurant');
            $featuredVenues = $this->Venue->getFeaturedListings(3, array('venueTypeId' => 1) );
            $this->set('cssId', '#none');
            $this->set('title_for_layout', 'Barrie restaurants, Collingwood, Blue Mountain, features and amenities');
            $this->set('metaDescription', 'Restaurants in and around Barrie, Collingwood, Blue Mountain, Wasaga, Orillia and surrounding areas.');
        }

      

        
        $this->set('featuredVenues', $featuredVenues);
    }
    /*
     * used to get all the info for a landing page (venue, computer, etc.)
     */
    function _getLandingPageInfo( $venueTypesId, $category, $cacheName) {


        $cacheData = Cache::read($cacheName);
        if ( $cacheData) {
            $services = $cacheData['services'];
            $cuisines = $cacheData['cuisines'];
            $products = $cacheData['products'];
            $amenities = $cacheData['amenities'];
            $locations = $cacheData['locations'];
            $comments = $cacheData['comments'];
            $popularVenues = $cacheData['popularVenues'];
            $newVenues = $cacheData['newVenues'];
            $latestArticles = $cacheData['latestArticles'];
            $venueTypes = $cacheData['venueTypes'];
            $newVenues =  $cacheData['newVenues'];


        } else {

            //
             $this->loadModel('Venue');
             $this->loadModel('City');

            // get list of venues of this type
            $venues = $this->Venue->VenueType->find('all', array(
                'conditions' => array('VenueType.id' => $venueTypesId),
                'contain' => array('Venue' => array('id', 'name', 'publish_state_id = ' . Configure::read('Venue.published' ) ) )
            ) );

            $result = Set::extract( $venues , '{n}.Venue.{n}.id');
            $venueIds = array_flatten($result);

            // venue types and sub-types
            $venueTypes = $this->Venue->VenueType->find('all', array(
                'conditions' => array('VenueType.id' => $venueTypesId ),
                'contain' => array('VenueSubtype')
            ));
            $cacheData['venueTypes'] = $venueTypes;

            // blog posts (2)
            $latestArticles = $this->_getWPPostIntro($num = 2, $sticky = false, $imageType = 'front_newest', $category);
            $cacheData['latestArticles'] = $latestArticles;

            // new venues (4)
            $newVenues =
                $this->Venue->find('all', array(
                    'conditions' => array('Venue.publish_state_id' => Configure::read('Venue.published'), 'Venue.id' => $venueIds ),
                    'order' => 'Venue.created DESC',
                    //'fields' => array('Venue.name', 'Venue.slug'),
                    'contain' => array('VenueType.name', 'VenueSubtype.name', 'VenueField' ),
                    'limit' => 5
                ) );
            $cacheData['newVenues'] = $newVenues;

            // fav. venues (4)
            $popularVenues =
                $this->Venue->find('all', array(
                    'conditions' => array('Venue.publish_state_id' => Configure::read('Venue.published'), 'Venue.id' => $venueIds ),
                    'order' => array( 'VenueScore.score DESC'),
                    //'fields' => array('Venue.name', 'Venue.slug', 'VenueRating.score'),
                    'contain' => array('VenueScore', 'VenueType.name', 'VenueSubtype.name', 'VenueField' ),
                    'limit' => 5
                ) );
            $cacheData['popularVenues'] = $popularVenues;

            // latest comments (3?)
            $comments = $this->Venue->Comment->find('all', array(
                'conditions' => array( 'Comment.flag_front_page' => 1,  'Comment.venue_id' => $venueIds ),
                'fields' => array('author', 'created', 'comment', 'rating'),
                'order' => 'Comment.created DESC',
                'contain' => array('Venue' => array('publish_state_id = ' . Configure::read('Venue.published'), 'name', 'sub_name', 'slug' ) ),
               'limit' => 3
            ) );
            $cacheData['comments'] = $comments;


            // locations (city, region)
            $locations = $this->City->find('all', array(
                'conditions' => array('City.venue_count >' => 0 ),
                'contain' => array('CityRegion')
            ));
            $cacheData['locations'] = $locations;

            // amenities
            $amenities =
            $this->Venue->VenueAmenity->find('all', array(
                    'conditions' => array('VenueAmenity.venue_type_id' => $venueTypesId ) ,
                    'contain' => false,
                    'order' => 'VenueAmenity.name')
                    );
            $amenities = Set::extract( $amenities , '{n}.VenueAmenity');
            $cacheData['amenities'] = $amenities;

            // products
            $products =
            $this->Venue->VenueProduct->find('all', array(
                    'conditions' => array('VenueProduct.venue_type_id' => $venueTypesId, 'VenueProduct.flag_cuisine !=' => 1 ) ,
                    'contain' => false,
                    'order' => 'VenueProduct.name')
                    );
            $products = Set::extract( $products , '{n}.VenueProduct');
            $cacheData['products'] =  $products;

            // cuisines
            $cuisines =
            $this->Venue->VenueProduct->find('all', array(
                    'conditions' => array('VenueProduct.venue_type_id' => $venueTypesId, 'VenueProduct.flag_cuisine' => 1 ) ,
                    'contain' => false,
                    'order' => 'VenueProduct.name')
                    );
            $cuisines = Set::extract( $cuisines , '{n}.VenueProduct');
            $cacheData['cuisines'] = $cuisines;

            // services
            $services =
            $this->Venue->VenueService->find('all', array(
                    'conditions' => array('VenueService.venue_type_id' => $venueTypesId ) ,
                    'contain' => false,
                    'order' => 'VenueService.name')
                    );
            $services = Set::extract( $services , '{n}.VenueService');
            $cacheData['services'] = $services;

            // newest listings
           // get list of newest venues of type
            $newListings = $this->Venue->VenueType->find('all', array( 'conditions' => array('VenueType.id' => $venueTypesId ),
            'contain' => array(
                'Venue' => array('name', 'full_name', 'slug', 'address', 'created', 'publish_state_id = ' . Configure::read('Venue.published'),
                                    'City.name',
                                    'limit' => 12, 'order' => 'created DESC' ) ),
            ) );

            $cacheData['newListings'] = $newListings;

            
            Cache::write($cacheName, $cacheData );

        }

        $this->set( compact('services', 'cuisines', 'products', 'amenities',
                        'locations', 'comments', 'popularVenues', 'newVenues',
                        'latestArticles', 'venueTypes', 'newListings'
                    ));
    }



	
    function sitemap() {
        $this->loadModel('Venue');
        // get featured venues
        $this->loadModel('Province');
        $result = $this->Province->find('all',
            array(
		'contain' =>
                    array('Region' => array('name', 'City' =>
                        array('name', 'venue_count', 'slug',
                            'Venue' => array('full_name', 'address', 'slug',
                                        'publish_state_id = ' . Configure::read('Venue.published'),
                                        'order' => 'Venue.name'
                                       
                                ),
                            'order' => 'City.name'
                            )
                        )
		,
                
                ), 'conditions' => array() ,
                )
            );
	//debug($result);

        foreach( $result as $i => $province) {
            foreach($province['Region'] as $j => $region) {
               // debug( '$region:' . $region['name'] );
                foreach($region['City'] as $k => $city) {
                    //debug( $city['name']);
                    //debug( sizeof($city['Venue']) );
                    if ( sizeof($city['Venue']) < 1 ) {
                        //debug( array($i , $j, $k) );
                        unset($result[$i]['Region'][$j]['City'][$k]);
                    }
                   
                }
                if ( isset($result[$i]['Region'][$j]['City']) &&
                        sizeof( $result[$i]['Region'][$j]['City'] ) < 1 ) {
                   
                    unset($result[$i]['Region'][$j]);
                }else {
                   // debug( $result[$i]['Region'][$j]['City'] );
                }
            }
        }
        
        $this->set('siteMap', $result);
    }

    /*
     * Display a list of cities with venue types
     * to-do: add a count for the number of venues of each type
     */
    function cities() {
        $this->loadModel('City');

        $result = $this->City->find('all', array(
            'contain' => array(
                'Venue' => array(
                   'publish_state_id = ' . Configure::read( 'Venue.published'),
                    'VenueType' => array( 'id', 'name', 'slug', 'order' => 'name DESC') ,
                    'VenueSubtype' => array( 'id', 'name', 'slug', 'venue_type_id')
                    )
            ),
            'conditions' => array('City.venue_count > ' => 0 ),
            'order' => array( 'City.name')
        ) ) ;
     //debug($result);
        $cities = array();

        $venueTypes = $this->City->Venue->VenueType->find('list');
        $venueTypeSlugs = $this->City->Venue->VenueType->find('list', array('fields' => array('id', 'slug')) );
        
        foreach( $result as $i => $city) {
            // array of cities with venues
            $cities[$i] = array( 'name' => $city['City']['name'], 'slug' => $city['City']['slug'] );
            // loop though each venue

            $cityVenues = array();

            foreach( $city['Venue'] as $j => $venue) {
               // debug( $venue['name'] );

                // loop through venues, add to $cityVenues if not set,
                //  else just increase count
                if ( !empty($venue['VenueType'])) {
                    foreach( $venue['VenueType'] as $type) {
                        if ( !isset($cityVenues[ $type['id'] ]) ) {
                            $cityVenues[ $type['id']]['name'] = $type['name'];
                            $cityVenues[ $type['id']]['slug'] = $type['slug'];
                            $cityVenues[ $type['id']]['count'] = 1;
                        } else {
                            $cityVenues[ $type['id']]['count'] ++;
                        }
                    }
                }

                // lopp through venues
                if ( !empty($venue['VenueSubtype']) ) {
                    foreach($venue['VenueSubtype'] as $subtype) {
                       $parentId = $subtype['venue_type_id'];
                       $subTypeId = $subtype['id'];

                       // if parent set, add onto its list
                       if ( isset($cityVenues[ $parentId ]) ) {
                            if ( isset( $cityVenues[ $parentId ]['subtypes'][ $subTypeId] )  ) {
                                $cityVenues[ $parentId ]['subtypes'][ $subTypeId]['count']++;
                            } else {
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['name'] = $subtype['name'];
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['slug'] = $subtype['slug'];
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['count'] = 1;
                            }
                       } else {
                           // parent not set, add parent, add subtype to parent's list
                            $cityVenues[ $parentId ]['name'] = $venueTypes[ $parentId ];
                            $cityVenues[ $parentId ]['slug'] = $venueTypeSlugs[ $parentId ];
                            $cityVenues[ $parentId ]['count'] = 1;
                            $cityVenues[ $parentId ]['subtypes'][$subTypeId]['name'] = $subtype['name'];
                            $cityVenues[ $parentId ]['subtypes'][$subTypeId]['slug'] = $subtype['slug'];
                            $cityVenues[ $parentId ]['subtypes'][ $subTypeId]['count'] = 1;
                       }

                    }
                }
                

            }
            $cities[$i]['venues'] = $cityVenues;
        }

     // debug($cities);
      // exit;

        $this->set('cities', $cities);
    }

function products_services() {
        $this->loadModel('City');

        $result = $this->City->find('all', array(
            'contain' => array(
                'Venue' => array(
                   'publish_state_id = ' . Configure::read( 'Venue.published'),
                    'VenueType' => array( 'id', 'name', 'slug', 'order' => 'name DESC') ,
                    'VenueAmenity' => array( 'id', 'name', 'slug', 'venue_type_id'),
                    'VenueService' => array( 'id', 'name', 'slug', 'venue_type_id'),
                    'VenueProduct' => array( 'id', 'name', 'slug', 'venue_type_id'),
                    )
            ),
            'conditions' => array('City.venue_count > ' => 0 ),
            'order' => array( 'City.name')
        ) ) ;
     //debug($result);


        foreach( $result as $i => $city) {
            // array of cities with venues
            $cities[$i] = array( 'name' => $city['City']['name'], 'slug' => $city['City']['slug'] );
            // loop though each venue

            $cityVenues = array();

            foreach( $city['Venue'] as $j => $venue) {
               // debug( $venue['name'] );

                // loop through venues, add to $cityVenues if not set,
                //  else just increase count
                if ( !empty($venue['VenueType'])) {
                    foreach( $venue['VenueType'] as $type) {
                        if ( !isset($cityVenues[ $type['id'] ]) ) {
                            $cityVenues[ $type['id']]['name'] = $type['name'];
                            $cityVenues[ $type['id']]['slug'] = $type['slug'];
                            $cityVenues[ $type['id']]['count'] = 1;
                        } else {
                            $cityVenues[ $type['id']]['count'] ++;
                        }
                    }
                }

                //$cityVenues['services'] =
                $this->_countUpSubtypes($cityVenues, $venue, 'VenueService', 'services');
                /*/* lopp through venues
                if ( !empty($venue['VenueService']) ) {
                    foreach($venue['VenueService'] as $subtype) {
                       $parentId = $subtype['venue_type_id'];
                       $subTypeId = $subtype['id'];

                       // if parent set, add onto its list
                       if ( isset($cityVenues[ $parentId ]) ) {
                            if ( isset( $cityVenues[ $parentId ]['subtypes'][ $subTypeId] )  ) {
                                $cityVenues[ $parentId ]['subtypes'][ $subTypeId]['count']++;
                            } else {
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['name'] = $subtype['name'];
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['slug'] = $subtype['slug'];
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['count'] = 1;
                            }
                       } else {
                           // parent not set, add parent, add subtype to parent's list
                            $cityVenues[ $parentId ]['name'] = $venueTypes[ $parentId ];
                            $cityVenues[ $parentId ]['slug'] = $venueTypeSlugs[ $parentId ];
                            $cityVenues[ $parentId ]['count'] = 1;
                            $cityVenues[ $parentId ]['subtypes'][$subTypeId]['name'] = $subtype['name'];
                            $cityVenues[ $parentId ]['subtypes'][$subTypeId]['slug'] = $subtype['slug'];
                            $cityVenues[ $parentId ]['subtypes'][ $subTypeId]['count'] = 1;
                       }

                    }
                }
                 
                 */
                //$cityVenues['products'] =
                $this->_countUpSubtypes($cityVenues, $venue, 'VenueProduct', 'products');

                // --
                /*
                if ( !empty($venue['VenueProduct']) ) {
                    foreach($venue['VenueProduct'] as $subtype) {
                       $parentId = $subtype['venue_type_id'];
                       $subTypeId = $subtype['id'];

                       // if parent set, add onto its list
                       if ( isset($cityVenues[ $parentId ]) ) {
                            if ( isset( $cityVenues[ $parentId ]['subtypes'][ $subTypeId] )  ) {
                                $cityVenues[ $parentId ]['subtypes'][ $subTypeId]['count']++;
                            } else {
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['name'] = $subtype['name'];
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['slug'] = $subtype['slug'];
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['count'] = 1;
                            }
                       } else {
                           // parent not set, add parent, add subtype to parent's list
                            $cityVenues[ $parentId ]['name'] = $venueTypes[ $parentId ];
                            $cityVenues[ $parentId ]['slug'] = $venueTypeSlugs[ $parentId ];
                            $cityVenues[ $parentId ]['count'] = 1;
                            $cityVenues[ $parentId ]['subtypes'][$subTypeId]['name'] = $subtype['name'];
                            $cityVenues[ $parentId ]['subtypes'][$subTypeId]['slug'] = $subtype['slug'];
                            $cityVenues[ $parentId ]['subtypes'][ $subTypeId]['count'] = 1;
                       }

                    }
                }
                */
                //$cityVenues['amenities'] =
                $this->_countUpSubtypes( $cityVenues, $venue, 'VenueAmenity', 'amenities');
                // --
                /*
                if ( !empty($venue['VenueAmenity']) ) {
                    foreach($venue['VenueAmenity'] as $subtype) {
                       $parentId = $subtype['venue_type_id'];
                       $subTypeId = $subtype['id'];

                       // if parent set, add onto its list
                       if ( isset($cityVenues[ $parentId ]) ) {
                            if ( isset( $cityVenues[ $parentId ]['subtypes'][ $subTypeId] )  ) {
                                $cityVenues[ $parentId ]['subtypes'][ $subTypeId]['count']++;
                            } else {
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['name'] = $subtype['name'];
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['slug'] = $subtype['slug'];
                                $cityVenues[ $parentId ]['subtypes'][$subTypeId]['count'] = 1;
                            }
                       } else {
                           // parent not set, add parent, add subtype to parent's list
                            $cityVenues[ $parentId ]['name'] = $venueTypes[ $parentId ];
                            $cityVenues[ $parentId ]['slug'] = $venueTypeSlugs[ $parentId ];
                            $cityVenues[ $parentId ]['count'] = 1;
                            $cityVenues[ $parentId ]['subtypes'][$subTypeId]['name'] = $subtype['name'];
                            $cityVenues[ $parentId ]['subtypes'][$subTypeId]['slug'] = $subtype['slug'];
                            $cityVenues[ $parentId ]['subtypes'][ $subTypeId]['count'] = 1;
                       }

                    }
                }
                */
                // --


            }
            //$cityVenues = array_merge_recursive( $services, $products, $amenities);
            $cities[$i]['venues'] = $cityVenues;
        }
        //debug($cities);
        //exit;
        $this->set('cities', $cities);
}

/* params: 
 * $venue : indivisual venue with sub-types
 * $venueType: sub-table to extract from 
 */
function _countUpSubtypes( &$cityVenues, $venue, $venueType = 'VenueAmenity', $typeName = 'subtypes' ) {

    $venueTypes = $this->City->Venue->VenueType->find('list');
    $venueTypeSlugs = $this->City->Venue->VenueType->find('list', array('fields' => array('id', 'slug')) );

    //$cityVenues = array();
    
    if ( !empty($venue[$venueType]) ) {
        foreach($venue[$venueType] as $subtype) {
           $parentId = $subtype['venue_type_id'];
           $subTypeId = $subtype['id'];

           // if parent set, add onto its list
           if ( isset($cityVenues[ $parentId ]) ) {
                if ( isset( $cityVenues[ $parentId ][$typeName][ $subTypeId] )  ) {
                    $cityVenues[ $parentId ][$typeName][ $subTypeId]['count']++;
                } else {
                    $cityVenues[ $parentId ][$typeName][$subTypeId]['name'] = $subtype['name'];
                    $cityVenues[ $parentId ][$typeName][$subTypeId]['slug'] = $subtype['slug'];
                    $cityVenues[ $parentId ][$typeName][$subTypeId]['count'] = 1;
                }
           } else {
               // parent not set, add parent, add subtype to parent's list
                $cityVenues[ $parentId ]['name'] = $venueTypes[ $parentId ];
                $cityVenues[ $parentId ]['slug'] = $venueTypeSlugs[ $parentId ];
                $cityVenues[ $parentId ]['count'] = 1;
                $cityVenues[ $parentId ][$typeName][$subTypeId]['name'] = $subtype['name'];
                $cityVenues[ $parentId ][$typeName][$subTypeId]['slug'] = $subtype['slug'];
                $cityVenues[ $parentId ][$typeName][ $subTypeId]['count'] = 1;
           }

        }
       // debug($cityVenues);
        //return($cityVenues);
    }
    //return( array() );
}

// looks up the value of a key in the VenueFields array and returns it 
// if found. False if not found.
function _getVenueFieldValue( $venueFields, $key) {
    foreach( $venueFields as $row) {
        if ( $row['key'] == $key)
            return $row['val'];
    }
    return false;
}
    
// from : http://www.php.net/manual/en/function.array-unique.php#97285
function _superUnique($array)
{
  $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

  foreach ($result as $key => $value)
  {
    if ( is_array($value) )
    {
      $result[$key] = $this->_superUnique($value);
    }
  }

  return $result;
}

    // gets the info. for a post: name, author, excerpt, image, tags, categories
    function _getWPPostIntro( $num = 1, $sticky = false, $imageType = null, $category = null) {
        if ( $sticky) {
           $stickyId = $this->Wordpress->get_option('sticky_posts');
           $featuredPost = $this->Wordpress->get_posts( array('numberposts' => $num, 'post__in' => $stickyId, 'orderby' => 'rand' ) );
        } else if ( $category) {
            $categoryId = $this->Wordpress->get_cat_ID( $category);
            $featuredPost = $this->Wordpress->get_posts( array('numberposts' => $num, 'category' => $categoryId, 'orderby' => 'rand' ) );
        }
        else {
            $featuredPost = $this->Wordpress->get_posts( array('numberposts' => $num, 'orderby' => 'post_date', 'order' => 'desc' ) );
        }

        // add extra fields
        if ( is_array($featuredPost)) {
        foreach( $featuredPost as $i => $post) {
            //debug( $this->Wordpress->get_userdata($post->post_author)->display_name );

            $categories = $this->Wordpress->wp_get_post_terms($post->ID, 'category');
            $tags = $this->Wordpress->wp_get_post_tags($post->ID);
            $link = $this->Wordpress->get_permalink( $post->ID );

            $featuredPost[$i]->categories = $categories;
            $featuredPost[$i]->tags = $tags;
            $featuredPost[$i]->perma_link = $link;

            $author = $this->Wordpress->get_userdata($post->post_author)->display_name;
            $featuredPost[$i]->author = $author;

            // find and attach image
            $args = array(
                    'post_type' => 'attachment',
                    'numberposts' => -1,
                    'post_status' => null,
                    'post_parent' => $featuredPost[$i]->ID
                    );
            $attachments = $this->Wordpress->get_posts($args);
            if ($attachments) {
                    if ( $imageType == 'front_newest')
                        $imageSize = array( 173,173);
                    else
                         $imageSize = array(55,56);

                    foreach ($attachments as $attachment) {
                        $image = $this->Wordpress->wp_get_attachment_image_src( $attachment->ID, $imageSize );

                        if ( isset($image[0]) )
                            $featuredPost[$i]->images[] = $image[0];
                    }
            }

        }
        } else {
            $featuredPost = array();
        }

        return($featuredPost);
    }

}

// from: http://www.php.net/manual/en/function.array-merge-recursive.php#100217
function array_flatten($array, $preserve_keys = false)
{
    if (!$preserve_keys) {
        // ensure keys are numeric values to avoid overwritting when array_merge gets called
        $array = array_values($array);
    }

    $flattened_array = array();
    foreach ($array as $k => $v) {
        if (is_array($v)) {
            $flattened_array = array_merge($flattened_array, call_user_func(__FUNCTION__, $v, $preserve_keys));
        } elseif ($preserve_keys) {
            $flattened_array[$k] = $v;
        } else {
            $flattened_array[] = $v;
        }
    }
    return $flattened_array;
}
?>
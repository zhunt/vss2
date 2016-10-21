<?php
class SearchController extends AppController {

    var $name = 'Search';
    var $helpers = array('Text', 'Time', 'Html', 'Javascript', 'Search');
    var $components = array('VenueMap');
    var $uses = array('Venue');

    private $stopWords = array( 'at', 'in', 'the', 'and',
            'st', 'rd', 'av', 'ave', 'hwy', 'dr', 'blvd', 'ln',
            'i', 'me', 'my', 'myself', 'we', 'our', 'ours', 'ourselves', 'you', 'your', 'yours',
            'yourself', 'yourselves', 'he', 'him', 'his', 'himself', 'she', 'her', 'hers',
            'herself', 'it', 'its', 'itself', 'they', 'them', 'their', 'theirs', 'themselves',
            'what', 'which', 'who', 'whom', 'this', 'that', 'these', 'those', 'am', 'is', 'are',
            'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'having', 'do', 'does',
            'did', 'doing', 'a', 'an', 'but', 'if', 'or', 'because', 'as', 'until',
            'while', 'of', 'by', 'for', 'with', 'about', 'against', 'between', 'into',
            'through', 'during', 'before', 'after', 'above', 'below', 'to', 'from', 'up', 'down',
            'out', 'on', 'off', 'over', 'under', 'again', 'further', 'then', 'once', 'here',
            'there', 'when', 'where', 'why', 'how', 'all', 'any', 'both', 'each', 'few', 'more',
            'most', 'other', 'some', 'such', 'no', 'nor', 'not', 'only', 'own', 'same', 'so',
            'than', 'too', 'very' );

    /*
     * called from the city/restaurant landing page
     * displays a list of venues in of a type in a region
     * params:
     * city, region, type (venue type), feature, cuisine
     * idea: use pipe (|) to allow multiples, e.g. cuisine:asian|thai
     */

    function phrase() {
        App::import('Sanitize');
        //debug($this->params);
        
        $this->loadModel('TagsVenue');
        $this->loadModel('Tag');

        if ( isset($this->params['url']['phrase'])) {
            $phrase = $this->params['url']['phrase'];
            $this->Session->delete('phraseSearch');
        }else {
            $phrase = $this->params['named']['phrase'];

            if ( $this->Session->check('phraseSearch') ) {
                $venueList = $this->Session->read('phraseSearch');
            }

        }
        $phrase = strtolower(Sanitize::paranoid($phrase, array(' ') ));

        if ( empty($phrase) )
            $this->cakeError('error404',array(array('url'=>'/')));

        if ( !isset($venueList ) ) {
            App::import('Vendor', 'Stemmer', array('file' => 'class.stemmer.inc'));
            $stemmer = new Stemmer();

            //debug($phrase);
            $fullPhrase = $stemmer->stem($phrase);
            //debug($fullPhrase);

            $wordList = explode(' ', $phrase);
            $phraseList = $stemmer->stem_list($wordList);

            $phraseList = $this->_removeStopWords($phraseList);
            //debug($phraseList);
            
            $phraseList = array_filter( array_flip( array_flip($phraseList) ) ) ;

            $numWords = sizeof($phraseList);

            // first do a check for exact name
            $venueList1 = $this->_lookupFullname($fullPhrase);
            //debug($venueList1);
            // now look-up individual words
            $venueList2 = $this->_lookupWords($phraseList, $numWords);
            //debug($venueList2);

            // now stick the 2 together and remove any duplicates
            $venueList = array_merge( $venueList1, (array)$venueList2);
            //debug($venueList);
            $venueList = array_unique($venueList);
            //debug($venueList);
            //exit();
            $this->Session->write('phraseSearch', $venueList );
        } // end of check if $venueList is populated
        
        // finally we display the results
        $conditions = array( 'Venue.flag_published' => 1, 'Venue.id' => $venueList );

        $venueIds = implode(',', $venueList );

        //debug();
        if ( empty($venueIds) )
            $venueIds = 0;
            
        $this->paginate = array(
            'limit' => Configure::read('search.listingsPerPage'),
            'conditions' => $conditions,
            'fields' => array('id','name', 'subname', 'slug', 'address', 'phone', 'venue_type_id',
                                'geo_latt', 'geo_long'),
            'contain' => array('VenueDetail', 'VenueCuisineType.name',
                                'VenueBarType.name', 'VenueCafeType.name',
                                'VenueCaterType.name', 'City.name', 'CityRegion'
                                ),
            'order' => "order by Field(Venue.id, $venueIds) "
        );

        //debug($this->paginate());
        //exit();

       $venues = $this->paginate();
       $this->set('venues', $venues );

       $this->set('venuesMapJson', $this->VenueMap->getJsonCords( $venues )  );

       $this->set('noResults', false);
       if ( empty($venues) )
            $this->set('noResults', true);


       $this->set('searchTerm', Inflector::humanize($phrase) );

       if ( isset($this->passedArgs['page']) )
            $this->set('title', 'Search for ' . $phrase . ', page ' . $this->passedArgs['page'] );
       else
            $this->set('title', 'Search for ' . $phrase );

        //$newListings = $this->Venue->getNewListings(14); // temp for right side
        //$this->set('newListings', $newListings);

        // make sure the phrase is passed to next page
        $this->passedArgs['phrase'] = $phrase;
        $this->render('venue_type_search');
    }

    


    /*
     * gets list of all params passed in and does a simple search for them
     * if this search doesn't work too good use phrase function for tag-search
     */
    function simple() {
        $this->loadModel('VenueFeature');
        
        App::import('Sanitize');
        if ( !isset($this->params['named']) )
            $this->cakeError('error404',array(array('url'=>'/')));
            
        $options = Sanitize::clean($this->params['named'], array('encode' => false));

        // now walk through options, building up conditions

        $options = array_filter($options); // remove empties

        $conditions = array( 'Venue.flag_published');
        
        foreach( $options as $option => $value) {
            switch($option) {
                case 'city':
                    $conditions = array_merge( $conditions, array('City.slug' => $value) );
                break;

                case 'region':
                    $conditions = array_merge( $conditions, array('CityRegion.slug' => $value) );
                break;

                case 'venue_type':
                    if ( $value == 'cater') {
                        $conditions = array_merge( $conditions, array( 'Venue.venue_cater_type_id >' => 0 ) );

                    } else {
                        $id = $this->_lookup_venue_type($value);
                        if ( $id == Configure::read('type.restaurant') )
                            $id = array(  Configure::read('type.restaurant'),  Configure::read('type.restaurantBar') );
                        if ( $id == Configure::read('type.bar') )
                            $id = array(  Configure::read('type.bar'),  Configure::read('type.restaurantBar') );

                        if ($id)
                            $conditions = array_merge( $conditions, array('Venue.venue_type_id' => $id) );
                    }
                break;

                case 'bar_type':
                    $id = $this->_lookup_bar_type($value);
                    if ($id)
                        $conditions = array_merge( $conditions,
                                        array( 'OR' =>
                                            array( 'Venue.venue_bar_type_id' => $id,
                                                   'VenueDetail.venue_bar_type_2_id' => $id,

                                        ) ) );
                break;

                case 'cafe_type':
                    $id = $this->_lookup_cafe_type($value);
                    if ($id)
                        $conditions = array_merge( $conditions,
                                        array( 'OR' =>
                                            array( 'Venue.venue_cafe_type_id' => $id,
                                                   'VenueDetail.venue_cafe_type_2_id' => $id,

                                        ) ) );
                break;

                case 'cater_type':
                    $id = $this->_lookup_cater_type($value);
                    if ($id)
                        $conditions = array_merge( $conditions,
                                        array( 'OR' =>
                                            array( 'Venue.venue_cater_type_id' => $id,
                                                   'VenueDetail.venue_cater_type_2_id' => $id,

                                        ) ) );
                break;

                case 'cuisine':
                    $id = $this->_lookup_cuisine_type($value);
                    if ($id) {
                        $conditions = array_merge( $conditions,
                            array(
                                       'OR' => array(
                                        'Venue.venue_cuisine_type_id' => $id,
                                        'VenueDetail.venue_cuisine_type_2_id' => $id,
                                        'VenueDetail.venue_cuisine_type_3_id' => $id,
                                        'VenueDetail.venue_cuisine_type_4_id' => $id,
                                        )
                        ) );
                    }
                break;

                case 'feature':
                    $id = $this->_lookup_feature_type($value);
                    if ($id) {
                        $conditions = array_merge( $conditions,
                            array( 'AND' => array(
                                       'OR' => array(
                                        'VenueDetail.venue_feature_1_id' => $id,
                                        'VenueDetail.venue_feature_2_id' => $id,
                                        'VenueDetail.venue_feature_3_id' => $id,
                                        'VenueDetail.venue_feature_4_id' => $id,
                                        'VenueDetail.venue_feature_5_id' => $id,
                                        ) )
                        ) );
                    }
                break;

                case 'amenity':
                    $id = $this->_lookup_amenity_type($value);
                    if ($id) {
                        $conditions = array_merge( $conditions,
                            array(
                                       'OR' => array(
                                        'VenueDetail.venue_amenity_1_id' => $id,
                                        'VenueDetail.venue_amenity_2_id' => $id,
                                        'VenueDetail.venue_amenity_3_id' => $id,
                                        'VenueDetail.venue_amenity_4_id' => $id,
                                        'VenueDetail.venue_amenity_5_id' => $id,
                                        )
                        ) );
                    }
                break;

                case 'intersection':
                    $id = $this->_lookup_intersection($value);
                    if ($id) {
                        $conditions = array_merge( $conditions,
                            array( 'Venue.intersection_id' => $id )
                       );
                    }
                break;

            }
        }

        //debug($conditions);exit();
        $this->paginate = array(
            'limit' => Configure::read('search.listingsPerPage'),
            'conditions' => $conditions,

            'contain' => array('VenueDetail', 'VenueCuisineType.name',
                                'VenueBarType.name', 'VenueCafeType.name',
                                'VenueCaterType.name', 'City.name', 'CityRegion'
                                )
        );

       $venues = $this->paginate();
       //debug($venues);exit();
       
       $this->set('venues', $venues );

       $this->set('venuesMapJson', $this->VenueMap->getJsonCords( $venues )  );

       $this->set('noResults', false);
       if ( empty($venues) )
            $this->set('noResults', true);

       // set-up page title
       if ( isset($options['item']) ) {
            $options['item'] = str_replace('-', ' ', $options['item']);
            $this->set('searchTerm', Inflector::humanize($options['item']) );
            $phrase = Inflector::humanize($options['item']);
       } else {
            $this->set('searchTerm', 'Good stuff' );
            $phrase = 'Good stuff';
       }

       // add page number to page title
       if ( isset($this->passedArgs['page']) )
            $this->set('title', 'Search for ' . $phrase . ', page ' . $this->passedArgs['page'] );
       else
            $this->set('title', 'Search for ' . $phrase );

       //$newListings = $this->Venue->getNewListings(8); // temp for right side
       //$this->set('newListings', $newListings);

       // make sure the phrase is passed to next page
       $this->passedArgs['phrase'] = $phrase;

       $this->render('venue_type_search');
    }

    /*
     * Support functions
     */

    /*
     * look up tags for full name
     */
    function _lookupFullname( $fullPhrase) {

            $tagId = $this->Tag->find('list', array(
                                            'fields' => array('name', 'id'),
                                            'conditions' =>
                                            array('name' => $fullPhrase) ) );

            if ($tagId) {
                $resultFullname = $this->TagsVenue->find('all', array('fields' =>
                            array( 'DISTINCT TagsVenue.venue_id', 'COUNT(*) as nb', 'SUM(TagsVenue.weight) as total_weight'),
                            'conditions' =>
                            array( 'TagsVenue.tag_id' => $tagId ),
                            'group' => 'TagsVenue.venue_id HAVING nb = 1',
                            'order' => array( 'nb DESC', 'total_weight DESC')
                            )
                    );
            }

            $venueList = array();
            if ( isset($resultFullname) && is_array($resultFullname) ) {
                foreach( $resultFullname as $row)
                    array_push( $venueList, $row['TagsVenue']['venue_id']);
            }
            return($venueList);
    }

    /*
     *  look up tags as parts of search phrase
     */
     function _lookupWords( $phraseList, $numWords) {

            $tagIds = $this->Tag->find('list', array(
                                            'fields' => array('name', 'id'),
                                            'conditions' =>
                                            array('name' => $phraseList) ) );
            //debug($tagIds);

            $result = $this->TagsVenue->find('all', array('fields' =>
                        array( 'DISTINCT TagsVenue.venue_id', 'COUNT(*) as nb', 'SUM(TagsVenue.weight) as total_weight'),
                        'conditions' =>
                        array( 'TagsVenue.tag_id' => $tagIds ),
                        'group' => 'TagsVenue.venue_id HAVING nb = ' . $numWords ,
                        'order' => array( 'nb DESC', 'total_weight DESC')
                        )
                );

            $venueList = array();
            if ( $result && !empty($result)) {
                foreach( $result as $row)
                    array_push( $venueList, $row['TagsVenue']['venue_id']);
            }

            return($venueList);
     }

     /* gets a venue type slug, finds its Id
      * additionally, if it's a restaurant or bar, also return the restaurant/bar type (cater could also be added later)
      */
     function _lookup_venue_type( $venueType) {
         $result = $this->Venue->VenueType->findBySlug($venueType);

         if ($result) {
            if ( $result['VenueType']['id'] == Configure::read('type.restaurant') )
                return( array( Configure::read('type.restaurant'), Configure::read('type.restaurantBar') ) );
            else if ( $result['VenueType']['id'] == Configure::read('type.bar') )
                return( array( Configure::read('type.bar'), Configure::read('type.restaurantBar') ) );
            else
                return( $result['VenueType']['id']);
         }
         else
            return false;

     }

     function _lookup_bar_type( $barType) {
         $result = $this->Venue->VenueBarType->findBySlug($barType);

         if ($result)
            return( $result['VenueBarType']['id']);
         else
            return false;

     }

     function _lookup_cafe_type( $cafeType) {
         $result = $this->Venue->VenueCafeType->findBySlug($cafeType);

         if ($result)
            return( $result['VenueCafeType']['id']);
         else
            return false;

     }

     function _lookup_cater_type( $caterType) {
         $result = $this->Venue->VenueCaterType->findBySlug($caterType);

         if ($result)
            return( $result['VenueCaterType']['id']);
         else
            return false;

     }

     // gets a venue type slug, finds its Id
     function _lookup_cuisine_type( $cuisineType) {
         $result = $this->Venue->VenueCuisineType->findBySlug($cuisineType);

         if ($result)
            return( $result['VenueCuisineType']['id']);
         else
            return false;

     }

     // gets a venue type slug, finds its Id
     function _lookup_feature_type( $featureType) {
         $result = $this->VenueFeature->findBySlug($featureType);

         if ($result)
            return( $result['VenueFeature']['id']);
         else
            return false;

     }

     // gets a venue type slug, finds its Id
     function _lookup_amenity_type( $amenityType) {

         $this->loadModel('VenueAmenity');

         $result = $this->VenueAmenity->findBySlug($amenityType);

         if ($result)
            return( $result['VenueAmenity']['id']);
         else
            return false;

     }

     //
     function _lookup_intersection( $intersection) {
         $this->loadModel('Intersection');
         $result = $this->Intersection->findBySlug($intersection);

         if ($result)
            return( $result['Intersection']['id']);
         else
            return false;
     }

    /*
     * Finds items of a certain type
     */
	function venue_type_search_DEL() {
        App::import('Sanitize');
    
        $item = Sanitize::paranoid( $this->params['named']['item'], array('-') );
        if ( empty($item) )
            $this->cakeError('error404',array(array('url'=>'/')));

        if ( isset($this->params['named']['city']) )
            $city = Sanitize::paranoid( $this->params['named']['city'], array('-') );



        switch ( $item) {
            case 'restaurants':

                $conditions = array( 'Venue.flag_published' => 1,
                                            'Venue.venue_type_id' => Configure::read('type.restaurant') );
                if (!empty($city) )
                    $conditions = array_merge( array('City.slug' => $city), $conditions );

                
                $this->paginate = array(
                    'limit' => Configure::read('search.listingsPerPage'),
                    'conditions' => $conditions,
                                            
                    'contain' => array('VenueDetail', 'VenueCuisineType.name', 
                                        'VenueBarType.name', 'VenueCafeType.name',
                                        'VenueCaterType.name', 'City.name')
                );
                
                break;

            case 'bars':

                $conditions = array( 'Venue.flag_published' => 1,
                                            'Venue.venue_type_id' => Configure::read('type.bar') );
                if (!empty($city) )
                    $conditions = array_merge( array('City.slug' => $city), $conditions );

                $this->paginate = array(
                    'limit' => Configure::read('search.listingsPerPage'),
                    'conditions' => $conditions,
                    'contain' => array('VenueDetail', 'VenueCuisineType.name',
                                        'VenueBarType.name', 'VenueCafeType.name',
                                        'VenueCaterType.name', 'City.name')
                );

                break;

            case 'cafes':

                $conditions = array( 'Venue.flag_published' => 1,
                                            'Venue.venue_type_id' => Configure::read('type.bar') );
                if (!empty($city) )
                    $conditions = array_merge( array('City.slug' => $city), $conditions );

                $this->paginate = array(
                    'limit' => Configure::read('search.listingsPerPage'),
                    'conditions' => $conditions,
                    'contain' => array('VenueDetail', 'VenueCuisineType.name',
                                        'VenueBarType.name', 'VenueCafeType.name',
                                        'VenueCaterType.name', 'City.name')
                );

                break;


            default:
                $this->cakeError('error404',array(array('url'=>'/')));

        }

        //$data = $this->paginate('Recipe');
        $this->set('venues', $this->paginate() );

        $this->set('searchTerm', Inflector::pluralize($item) );

        //$newListings = $this->Venue->getNewListings(5); // temp for right side
        //$this->set('newListings', $newListings);
	}

    /*
     * search for venues with X-type of cuisine
     * params: city, item (cuisine type),
     */
    function cuisine_search() {
        App::import('Sanitize');
        $this->loadModel('VenueCuisineType');
        $item = Sanitize::paranoid( $this->params['named']['item'], array('-') );
        if ( empty($item) )
            $this->cakeError('error404',array(array('url'=>'/')));

        if ( isset($this->params['named']['city']) )
            $city = Sanitize::paranoid( $this->params['named']['city'], array('-') );

        // look up the cuisine
        $this->VenueCuisineType->contain();
        $result = $this->VenueCuisineType->findBySlug($item);

        if (!$result)
            $this->cakeError('error404',array(array('url'=>'/')));

        $cuisineId = $result['VenueCuisineType']['id'];


        // set up the conditions
        $conditions = array( 'Venue.flag_published' => 1,
                                    'OR' => array(
                                        'Venue.venue_cuisine_type_id' => $cuisineId,
                                        'VenueDetail.venue_cuisine_type_2_id' => $cuisineId,
                                        'VenueDetail.venue_cuisine_type_3_id' => $cuisineId,
                                        'VenueDetail.venue_cuisine_type_4_id' => $cuisineId,
                                        )
                                    );
        if (!empty($city) )
            $conditions = array_merge( array('City.slug' => $city), $conditions );




        $this->paginate = array(
            'limit' => Configure::read('search.listingsPerPage'),
            'conditions' => $conditions,
                    'contain' => array('VenueDetail', 'VenueCuisineType.name',
                                        'VenueBarType.name', 'VenueCafeType.name',
                                        'VenueCaterType.name', 'City.name')
        );

        $this->set('venues', $this->paginate() );
        $this->set('searchTerm', $item );
        
        //$newListings = $this->Venue->getNewListings(5); // temp for right side
        //$this->set('newListings', $newListings);
        $this->render('venue_type_search');
    }

    /*
     * search for X-type of feature
     */
    function feature_search() {
        App::import('Sanitize');
        $this->loadModel('VenueFeature');
        $item = Sanitize::paranoid( $this->params['named']['item'], array('-') );
        if ( empty($item) )
            $this->cakeError('error404',array(array('url'=>'/')));

        // look up the cuisine
        $this->VenueFeature->contain();
        $result = $this->VenueFeature->findBySlug($item);

        if (!$result)
            $this->cakeError('error404',array(array('url'=>'/')));

        $featureId = $result['VenueFeature']['id'];
        
        $this->paginate = array(
            'limit' => Configure::read('search.listingsPerPage'),
            'conditions' => array( 'Venue.flag_published' => 1,
                                    'OR' => array(
                                        'VenueDetail.venue_feature_1_id' => $featureId,
                                        'VenueDetail.venue_feature_2_id' => $featureId,
                                        'VenueDetail.venue_feature_3_id' => $featureId,
                                        'VenueDetail.venue_feature_4_id' => $featureId,
                                        'VenueDetail.venue_feature_5_id' => $featureId,
                                        )
                                    ),
                    'contain' => array('VenueDetail', 'VenueCuisineType.name',
                                        'VenueBarType.name', 'VenueCafeType.name',
                                        'VenueCaterType.name', 'City.name')
        );

        $this->set('venues', $this->paginate() );
        $this->set('searchTerm', $item );
        
        //$newListings = $this->Venue->getNewListings(5); // temp for right side
        //$this->set('newListings', $newListings);
        $this->render('venue_type_search');
    }

    /*
     * search for X-type of amenity
     */
    function amenity_search() {
        App::import('Sanitize');
        $this->loadModel('VenueAmenity');
        $item = Sanitize::paranoid( $this->params['named']['item'], array('-') );
        if ( empty($item) )
            $this->cakeError('error404',array(array('url'=>'/')));

        // look up the cuisine
        $this->VenueAmenity->contain();
        $result = $this->VenueAmenity->findBySlug($item);

        if (!$result)
            $this->cakeError('error404',array(array('url'=>'/')));

        $amenityId = $result['VenueAmenity']['id'];

        $this->paginate = array(
            'limit' => Configure::read('search.listingsPerPage'),
            'conditions' => array( 'Venue.flag_published' => 1,
                                    'OR' => array(
                                        'VenueDetail.venue_amenity_1_id' => $amenityId,
                                        'VenueDetail.venue_amenity_2_id' => $amenityId,
                                        'VenueDetail.venue_amenity_3_id' => $amenityId,
                                        'VenueDetail.venue_amenity_4_id' => $amenityId,
                                        'VenueDetail.venue_amenity_5_id' => $amenityId,
                                        )
                                    ),
                    'contain' => array('VenueDetail', 'VenueCuisineType.name',
                                        'VenueBarType.name', 'VenueCafeType.name',
                                        'VenueCaterType.name', 'City.name')
        );

        $this->set('venues', $this->paginate() );
        $this->set('searchTerm', $item );
        
        //$newListings = $this->Venue->getNewListings(5); // temp for right side
        //$this->set('newListings', $newListings);
        $this->render('venue_type_search');
    }

    /*
     * remove stop words
     */
    function _removeStopWords( $words) {
       
        return array_diff($words, $this->stopWords);

       

    }

}
?>
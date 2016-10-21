<?php
App::import('Inflector');
class SearchesController extends AppController {

    var $name = 'Searches';
    var $uses = array('Venue');
    var $helpers = array('Text', 'Venues');

    var $indexPath = 'tmp/cache/search_index';
    var $index; // pointer to search index

    var $resultPerPage = 10; // number of result to show per search page
    var $searchConditionsAnd; // conditions and-ed to paginate
    //var $venueIdList = array(); //

    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('autocomplete', 'index');
    }

    function autocomplete() {
        Configure::write('debug',0);
        $this->autoRender = false;

        $search = Sanitize::paranoid($this->params['url']['term'], array(' ', '.', '-', ',') );

        $this->loadModel('VenueProduct');
        $this->loadModel('City');

        $data = array();

        $venues = $this->Venue->find('all', array(
                'contain' => false,
                'conditions' => array( 'Venue.name LIKE' => '%' . $search . '%',
                    'Venue.publish_state_id' => Configure::read('Venue.published')),
                'limit' => 10,
                'order' => 'Venue.name'
            )
        );
        if ($venues) {
            foreach( $venues as $row) {
                $data[] = array(
                    'id' => $row['Venue']['id'],
                    'label' => trim($row['Venue']['name'] . ' ' . $row['Venue']['sub_name']),
                    'url' => '/' . $row['Venue']['slug'],
                    'type' => 'venue'
                );
            }
        }
        
        $cities = $this->City->find('all', array(
                'contain' => false,
                'conditions' => array( 'City.name LIKE' => '%' . $search . '%'),
                'limit' => 3,
                'order' => 'City.name'
            )
        );
        if ($cities) {
            foreach( $cities as $row) {
                $data[] = array(
                    'id' => $row['City']['id'],
                    'label' => $row['City']['name'], 
                    'value' => $row['City']['name'], // in input field
                    'url' => '/searches/index/city:' . $row['City']['slug'] . '/new_search:1',
                    'type' => 'city'
                );
            }
        }

        $venueProducts = $this->VenueProduct->find('all', array(
                'contain' => false,
                'conditions' => array( 'VenueProduct.name LIKE' => '%' . $search . '%'),
                'limit' => 3,
                'order' => 'VenueProduct.name'
            )
        );
        if ($venueProducts) {
            foreach( $venueProducts as $row) {
                $data[] = array(
                    'id' => $row['VenueProduct']['id'],
                    'label' => $row['VenueProduct']['name'],
                    'value' => $row['VenueProduct']['name'], // in input field
                    'url' => '/searches/index/product:' . $row['VenueProduct']['slug']. '/new_search:1',
                    'type' => 'product'
                );
            }
        }


        echo json_encode($data);
    }

    /*
     * display the search results
     */
    function index() {
        $searchConditions = array();

        // check that keys match what is stored
        $this->_checkForNewSearch();

        // get list of venues from session
        $venueIds = $this->Session->read('searchVenues.venueIds');

        if ( $this->Session->check('searchVenues.searchConditions') ){
            $this->searchConditionsAnd = $this->Session->read('searchVenues.searchConditions');
        }

        // debug($this->searchConditionsAnd); debug($searchConditions);
        // add city/intersection/chain/etc. keys
        if (!empty($this->searchConditionsAnd) )
           $searchConditions = array_merge( $searchConditions,
                                    array('AND' => $this->searchConditionsAnd ) );

        $searchConditions['AND'][] = array('Venue.publish_state_id' => Configure::read('Venue.published') );

        // check if there is an array of VenueIds
        if (!empty($venueIds)) {
            $searchConditions = array_merge( $searchConditions, array('Venue.id' => $venueIds ) );
            $order = 'Field(Venue.id, ' . implode(',', $venueIds) .')';
        }else{
            // ... if not, do same search paginate will do and get the ids
            $result = $this->Venue->find('all',
                    array('fields' => 'Venue.id', 'conditions' => $searchConditions ) );
            if ($result) {
                $venueIds = Set::extract('/Venue/id', $result);
                shuffle($venueIds);
                $this->_updateSearchIds($venueIds );
                if (!empty($venueIds)) { 
                    $order = 'Field(Venue.id, ' . implode(',', $venueIds) .')';
                }else {
                    $order = '';
                }

            } else {
                $order = 'Venue.created';
            }
        }

        // set title for page and
        if ( $this->Session->check('searchVenues.searchPhrases') ) {
            $this->set('searchText', $this->Session->read('searchVenues.searchPhrases') );
        } else {
            $this->set('searchText', 'No Text' );
        }


        // if no search conditions, add search for venue.id == 0 to stop showing all
        if ( empty($searchConditions) )
            $searchConditions = array('Venue.id' => 0 );
        
        // do final check on search conditions to see if no results found
        // if only 1 "AND" condition and no Venue.Ids, then bad
        if ( sizeof($searchConditions['AND']) == 1 &&
                ( !isset($searchConditions['Venue.id']) || sizeof($searchConditions['Venue.id']) < 1 ) ) {
            debug('NO RESULTS');
            $searchConditions['Venue.id'] = array(0);
            $this->set('noResults', true );
        } else {
            $this->set('noResults', false );
        }

        debug($searchConditions);
        $this->paginate = array(
                'Venue' => array(
                    'conditions' => $searchConditions,
                    'limit' => $this->resultPerPage,
                    'order' => $order,
                    'contain' => array('VenueType.name', 'VenueType.slug', 'City.name', 'CityRegion.name',
                                        'CityNeighbourhood.name', 'VenueScore.score',
                                        'VenueType', 'VenueSubtype', 'VenueProduct',
                                        'VenueAmenity', 'VenueService', 'VenueField')
                    )
            );
       
        $data = $this->paginate('Venue');
       // debug($data); exit;
        $this->set('venues', $data);

        $this->set('cities', $this->Venue->City->find('list', array( 'fields' => array('slug', 'name'), 'order' => 'name') ) );

        $this->set('amenities', $this->Venue->VenueAmenity->find('list', array('order' => 'name') ) );
        $this->set('services', $this->Venue->VenueService->find('list', array('order' => 'name') ) );

        // set hidden fields
        if ($this->params['named']) {
            $filterFields = array();
            foreach( $this->params['named'] as $field => $value ) {
                if ($field == 'page') continue;
                if ($field == 'nearby') continue;

                //array_push($filterFields, array( $field => $value));
                $filterFields[$field] = $value;
            }

            // now pick the two filter fields, todo: unset duplicates in filterFields
            if ( isset($filterFields['city']) ) {
                $filterField1 = ClassRegistry::init('City')->find('list', array('fields' => array('slug', 'name'), 'order' =>'name'));
                $filterField1Name = 'city';
                $filterField2 = $this->Venue->VenueService->find('list', array('fields' => array('slug', 'name'), 'order' =>'name'));
                $filterField2Name = 'service';
            }
            else if ( isset($filterFields['venue_type']) || isset($filterFields['venue_subtype']) ) {
                $filterField1 = ClassRegistry::init('City')->find('list', array('fields' => array('slug', 'name'), 'order' =>'name'));
                $filterField1Name = 'city';
                $filterField2 = $this->Venue->VenueService->find('list', array('fields' => array('slug', 'name'), 'order' =>'name'));
                $filterField2Name = 'service';
            }
            else if ( isset($filterFields['service']) ) {
                $filterField1 = ClassRegistry::init('City')->find('list', array('fields' => array('slug', 'name'), 'order' =>'name'));
                $filterField1Name = 'city';
                $filterField2 = $this->Venue->VenueProduct->find('list', array('fields' => array('slug', 'name'), 'order' =>'name'));
                $filterField2Name = 'product';
            }
            else if ( isset($filterFields['product']) ) {
                $filterField1 = ClassRegistry::init('City')->find('list', array('fields' => array('slug', 'name'), 'order' =>'name'));
                $filterField1Name = 'city';
                $filterField2 = $this->Venue->VenueService->find('list', array('fields' => array('slug', 'name'), 'order' =>'name'));
                $filterField2Name = 'service';
            }

            $this->set('filterFields', $filterFields );
            $this->set('filterField1', $filterField1 );
            $this->set('filterField2', $filterField2 );
            $this->set('filterField1Name', $filterField1Name );
            $this->set('filterField2Name', $filterField2Name );
            debug($filterFields);
        }


       // exit;
    }

    function _checkForNewSearch() {
        $current = $this->params['named'];
        $stored = $this->Session->read('searchVenues.terms');

        unset( $current['page'] ); unset( $stored['page'] );
        unset( $current['new_search'] ); unset( $stored['new_search'] );
        //unset($current['index']); unset( $stored['index'] );

        if ( sizeof($current) != sizeof($stored) ) {
            //debug('trigger new seach');
            $this->_newSearchSetUp($this->params['named']);
            return;
        }

        if ( !empty($stored) ) {
            //debug($current); debug($stored);
            $match = true;
            foreach( $stored as $key => $value) {
                if ( !isset($current[$key]) || $current[$key] != $stored[$key]  ) {
                    $match = false;
                    debug($key . ' does not match');
                }
            }
            if ( $match == false) {
                //debug('trigger new seach');
                $this->_newSearchSetUp($this->params['named']);
            }
        } else {
            //debug('trigger new seach');
            $this->_newSearchSetUp($this->params['named']);
        }
    }

    function _newSearchSetUp( $terms) {
        unset($this->params['named']['new_search']);
        $this->Session->delete('searchVenues');
        $this->Session->write('searchVenues.venueIds', false); 
        $this->searchConditionsAnd = array();
        $this->venueIdList = array();

        // store terms being passing into url
        $urlTerms = array();
        foreach ( $terms as $key => $slug) {
            switch($key) {
                case 'product':
                    $this->_setUpTaggedVenueItem($slug, 'VenueProduct' );
                    break;
                case 'amenity':
                    $this->_setUpTaggedVenueItem($slug, 'VenueAmenity' );
                    break;
                case 'service': //
                    $this->_setUpTaggedVenueItem($slug, 'VenueService' );
                    break;
                case 'venue_type': //
                    $this->_setUpTaggedVenueItem($slug, 'VenueType' );
                    break;
                case 'venue_subtype': //
                    $this->_setUpTaggedVenueItem($slug, 'VenueSubtype' );
                    break;
                case 'city':
                    $this->_setUpVenueItem($slug, 'City');
                    break;
                case 'city_region':
                    $this->_setUpVenueItem($slug, 'CityRegion');
                    break;
                case 'neighbourhood':
                    $this->_setUpVenueItem($slug, 'CityNeighbourhood');
                    break;
                case 'intersection':
                    $this->_setUpVenueItem($slug, 'Intersection');
                    break;
                case 'chain':
                    $this->_setUpVenueItem($slug, 'Chain');
                    break;
                case 'text':
                    $this->_setUpTextSearch($slug);
                    break;
                case 'nearby':
                    $this->_setUpNearbyVenueSearch($slug);
                    break;
            }
            
            if ($key != 'new_search' || $key != 'page' )
                $urlTerms[$key] = $slug;
        }
        if ( !empty($urlTerms))
            $this->Session->write('searchVenues.terms', $urlTerms);

        if ( !empty($this->searchConditionsAnd) )
            $this->Session->write('searchVenues.searchConditions', $this->searchConditionsAnd);

        debug( $this->Session->read('searchVenues') );
    }

    // set-up search for a service/type/amenity/etc.
    function _setUpTaggedVenueItem($slug, $model = 'VenueAmenity' ) {
        $slug = Sanitize::paranoid($slug, array('-', '|'));
        if ( $slug ) {

           if (strpos($slug, '|')) {
                $slugs = explode('|', $slug);
           } else {
               $slugs = (array)$slug;
           }
           // debug($slugs);

           $venueIds = array();
           foreach( $slugs as $slug) {
                $result = ClassRegistry::init($model)->findBySlug($slug);
                $id = $result[$model]['id'];
                $phrase = $result[$model]['name'];

                //debug($model); debug($result);

                if ($id) {
                    $result = ClassRegistry::init($model)->find('first', array(
                        'contain' =>
                            array('Venue' =>
                                    array('fields' => array('name'),
                                            'conditions' => array('Venue.publish_state_id' => Configure::read('Venue.published') )
                                ) ),
                        'conditions' => array($model . '.id' => $id ),
                        'fields' => array('id', 'name')
                    ));
                }

            debug($result); //exit;
            $newVenueIds = Set::extract('/Venue/Venues' . $model .'/venue_id', $result); // VenuesVenueProduct/venue_id/

            $venueIds = array_merge($venueIds, $newVenueIds);
            }
            $this->_storeSearchIds( $venueIds, $phrase );
        }
        //if ( sizeof($slugs) > 1) exit;
    }



    // set up search for single type, e.g. city/intersection/chain/etc.
    function _setUpVenueItem($slug, $model = 'City') {
        $slug = Sanitize::paranoid($slug, array('-'));
        if ( $slug ) {
            $result = ClassRegistry::init($model)->findBySlug($slug);
            if ($result) {
                $id = $result[$model]['id'];
                $phrase = $result[$model]['name'];

                if ( $model == 'Intersection') {
                    //debug($result); exit;
                    $phrase .= ' in ' . $result['City']['name'];
                }
                $this->searchConditionsAnd[] = array('Venue.' . Inflector::underscore($model) . '_id' => $id);
                $this->_storeSearchPhrases($phrase );
            }
        }
        
    }

    //
    function _setUpNearbyVenueSearch($slug) {

        if ( $slug ) {
            $this->Venue->contain();
            $result = $this->Venue->findBySlug($slug);
            $venueName = $result['Venue']['full_name'];

            // now get list of places near this venue
            $nearby  = $this->Venue->getNearbyVenues( $result['Venue']['geo_lat'],$result['Venue']['geo_lng'] );
            //debug($nearby);
            $venueIds = Set::extract('/Venue/id', $nearby);
           
            $this->searchConditionsAnd[] = array('Venue.id' => $venueIds);

            $phrase = 'Venues near ' . $venueName;
            $this->_storeSearchPhrases($phrase );

            $this->resultPerPage = 10;
        }

    }

    // this uses the Lucene search to find matching venues
    function _setUpTextSearch($slug) {
        $phrase = Sanitize::paranoid($slug, array('-', ' ', '.' ,'+') );

        if ($phrase) {
            $this->__loadLuceneSearch();
            $index = $this->index;

            $hits = $index->find($phrase);

            $venueIds = array();
            foreach ($hits as $hit) {
                $venueIds[] = $hit->venue_id;
            }
            $venueIds = array_flip($venueIds);
            $venueIds = array_flip($venueIds);
            //debug($venueIds);
            if (empty($venueIds)) {
                $venueIds = array(0);
                $this->_storeSearchPhrases($slug );
                return false;
            }
            // now check which of these venues are published, return in same order
            // as Lucene search result
           // debug('here 222');
            $result = $this->Venue->find('all', array(
                'conditions' => array('Venue.id' => $venueIds,
                                      'Venue.publish_state_id' => Configure::read('Venue.published')
                    ),
                'order' => 'Field(Venue.id, ' . implode(',', $venueIds) .')'
            ));

            if ($result) {
                $venueIds = Set::extract('/Venue/id', $result);

                //debug($venueIds);
                $this->_storeSearchIds( $venueIds, $phrase );
            }
        }
    }

    
    // =======================================================================

    function admin_ajax_addVenue() {
        //debug($this->params);

        $this->data = $this->params['data'];

        $id = $this->data['Venue']['id'];
        $name = trim($this->data['Venue']['name'] . ' ' . $this->data['Venue']['sub_name']);
        $desc = $this->data['VenueDetail']['description'];
        $address = $this->data['Venue']['address'];

        if ( $name) {
            $this->__loadLuceneSearch();
            $index = $this->index;

            $doc = new Zend_Search_Lucene_Document();

            $doc->addField(Zend_Search_Lucene_Field::Text('venue_id',
                                            ($id)));

            $doc->addField(Zend_Search_Lucene_Field::Text('venueName',
                                            ($name)));

            $doc->addField(Zend_Search_Lucene_Field::UnStored('address',
                                            ($address)));

            $doc->addField(Zend_Search_Lucene_Field::UnStored('description',
                                            ($desc)));

            //debug($doc);
            $index->addDocument($doc);
            $index->commit();

            $msg = 'Added ' . $name . ', count: ' . $index->count();
            $this->set( 'msg' , $msg);

        }


    }

    /*
     * updates Lucene index for a venue
     * called after venue is saved
     */
    function admin_update_index($venueId) {
        $venueId = intval($venueId);
        $venue = ClassRegistry::init('Venue')->findById($venueId);
    
        if ($venue ) {
            // check if venue already indexed and remove
            $this->__loadLuceneSearch();
            $index = $this->index;
            $hits = $index->find('venue_id:' . $venueId);
            foreach( $hits as $hit) $index->delete($hit->id);

            // now add/re-add
            // comment out this IF when shell-adding
           if ( $venue['PublishState']['name'] == 'published' ) {
                $doc = new Zend_Search_Lucene_Document();
                $doc->addField(Zend_Search_Lucene_Field::Text('venue_id',
                                                ( $venue['Venue']['id'] )));
                $doc->addField(Zend_Search_Lucene_Field::Text('name',
                                                ( trim($venue['Venue']['name'] . ' ' . $venue['Venue']['sub_name'] ) ) ));
                $doc->addField(Zend_Search_Lucene_Field::Text('address',
                                                ( $venue['Venue']['address'] )));
                $doc->addField(Zend_Search_Lucene_Field::Text('phone',
                                                ( $venue['Venue']['phone'] )));
                $doc->addField(Zend_Search_Lucene_Field::Text('fax',
                                                ( $venue['VenueDetail']['phone_fax'] )));
                $doc->addField(Zend_Search_Lucene_Field::UnStored('description',
                                                ($venue['VenueDetail']['description'])));
                $doc->addField(Zend_Search_Lucene_Field::text('region',
                                                ($venue['Region']['name'])));
                $doc->addField(Zend_Search_Lucene_Field::Keyword('city',
                                                ($venue['City']['name'])));
                $doc->addField(Zend_Search_Lucene_Field::text('cityRegion',
                                                ($venue['CityRegion']['name'])));
                $doc->addField(Zend_Search_Lucene_Field::text('cityNeighbourhood',
                                                ($venue['CityNeighbourhood']['name'])));
                $doc->addField(Zend_Search_Lucene_Field::text('intersection',
                                                ($venue['Intersection']['name'])));
                $doc->addField(Zend_Search_Lucene_Field::text('chain',
                                                ($venue['Chain']['name'])));
               

                // now add venue_amenity, ...product, ...features
                if ( !empty($venue['VenueAmenity'])) {
                    $list = array();
                    foreach( $venue['VenueAmenity'] as $item) {
                        $list[] = $item['name'];
                    }
                    $list = implode(', ', $list);
                    $doc->addField(Zend_Search_Lucene_Field::text('amenities',
                                                ($list)));
                }
                if ( !empty($venue['VenueProduct'])) {
                    $list = array();
                    foreach( $venue['VenueProduct'] as $item) {
                        $list[] = $item['name'];
                    }
                    $list = implode(', ', $list);
                    $doc->addField(Zend_Search_Lucene_Field::text('products',
                                                ($list)));
                }
                if ( !empty($venue['VenueService'])) {
                    $list = array();
                    foreach( $venue['VenueService'] as $item) {
                        $list[] = $item['name'];
                    }
                    $list = implode(', ', $list);
                    $doc->addField(Zend_Search_Lucene_Field::text('services',
                                                ($list)));
                }
                // type and subtype
                if ( !empty($venue['VenueType'])) {
                    $list = array();
                    foreach( $venue['VenueType'] as $item) {
                        $list[] = $item['name'];
                    }
                    $list = implode(', ', $list);
                    $doc->addField(Zend_Search_Lucene_Field::text('types',
                                                ($list)));
                }
                if ( !empty($venue['VenueSubtype'])) {
                    $list = array();
                    foreach( $venue['VenueSubtype'] as $item) {
                        $list[] = $item['name'];
                    }
                    $list = implode(', ', $list);
                    $doc->addField(Zend_Search_Lucene_Field::text('subTypes',
                                                ($list)));
                }
                $index->addDocument($doc);
                $index->commit();
				$index->optimize();
				
            }

        }

    }

    /*
     * used to remove a listing after deleted from DB
     */
    function admin_delete_from_index($venueId) {
        $venueId = intval($venueId);

        $this->__loadLuceneSearch();
        $index = $this->index;
        $hits = $index->find('venue_id:' . $venueId);
        foreach( $hits as $hit) $index->delete($hit->id);
    }


    /*
     * Test function - REMOVE LATER
     */
    function text_search() {
        //debug($this->params);



        $phrase = $this->params['pass'][0];
        
        if ($phrase) {
            
            $this->__loadLuceneSearch();
           
            $index = $this->index;
       
            debug($index->numDocs());
            debug($index->count());

            
            $hits = $index->find($phrase);
            //$hits = $index->find('venue_id:' . '6');

            foreach ($hits as $hit) {
                $out = array( $hit->id, $hit->venue_id, $hit->name , $hit->address, $hit->city, $hit->chain);
                debug($out);
            }
            exit;

            // start
            $userQuery = Zend_Search_Lucene_Search_QueryParser::parse($phrase);

            //debug($userQuery);
            $pathTerm  = new Zend_Search_Lucene_Index_Term(
                $this->indexPath
            );
            
            debug($pathTerm);

            $pathQuery = new Zend_Search_Lucene_Search_Query_Term($pathTerm);

            $query = new Zend_Search_Lucene_Search_Query_Boolean();

            $query->addSubquery($userQuery, true /* required */);

            $query->addSubquery($pathQuery, true /* required */);

            $hits = $index->find($query);

            debug( sizeof($hits));
            foreach ($hits as $hit) {
                //debug($hit);
                debug($hit->venueName);
                debug($hit->description);
            }
            
        }

    }

    /*
     * Utility to import Zend Lucene search
     */
    function __loadLuceneSearch() {
        if( function_exists('ini_set')){
            ini_set('include_path', PATH_SEPARATOR . APP. 'vendors'); // was ini_get('include_path') , PATH_SEPARATOR ...
			//debug( ini_get('include_path')  ); exit;
        }
        App::import('Vendor', 'Zend/Search/Lucene', array('file' => 'Zend/Search/Lucene.php'));

        $indexPath = APP. $this->indexPath;

        try {
            $this->index = Zend_Search_Lucene::open($indexPath);
        }
        catch (Zend_Search_Lucene_Exception $e) {
            $this->index = Zend_Search_Lucene::create($indexPath, true);
        }

    }

    /*
     * store the user's search in session
     */
    function _storeSearchIds( $newVenueIds, $searchText = null ) {
        shuffle($newVenueIds); //debug($newVenueIds);
        // check if there's already some venueIds stored
        if ( $this->Session->check('searchVenues.venueIds') ) {
            $storedVenueIds = $this->Session->read('searchVenues.venueIds');
            // venueIds is set to false when new search started
            // so start with first set passed in
            if ( $storedVenueIds === false ) {
                $searchVenueIds = $newVenueIds;
            } else {
                // do an interset with whatever is in there (even empty)
                $searchVenueIds = array_intersect((array)$storedVenueIds, (array)$newVenueIds );
            }
            $this->Session->write('searchVenues.venueIds', $searchVenueIds);
        } else {
            $this->Session->write('searchVenues.venueIds', $searchVenueIds);
        }
        if ( !empty($searchText))
            $this->_storeSearchPhrases($searchText);

        //debug($this->Session->read('searchVenues.venueIds'));
    }

    // just store the ids
    function _updateSearchIds($venueIds) {
            //if (is_array($venueIds) )
                $this->Session->write('searchVenues.venueIds', $venueIds);
    }

    function _storeSearchPhrases($phrase) {
        $phrase = trim($phrase);
        if ( empty($phrase) )
            return false;
        
        $searchPhrases = $this->Session->read('searchVenues.searchPhrases');
        //debug('reading'); debug($searchPhrases);

        if ( !is_array($searchPhrases))
            $searchPhrases = array();

        $searchPhrases = array_merge( $searchPhrases, (array)$phrase);
       
        $this->Session->write('searchVenues.searchPhrases', $searchPhrases);
      
    }
}

?>

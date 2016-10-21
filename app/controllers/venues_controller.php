<?php
class VenuesController extends AppController {

    var $name = 'Venues';
    var $helpers = array('Html', 'Form','Text', 'Time', 'Cache', 'Venues', 'VenueMeta');
    var $components = array('Locations', 'Utilities', 'Uploader.Uploader');

    var $cacheAction = array(
        'view' => '1 month'
   );

    var $venuePriceRanges = array( '$' => '$', '$$' => '$$', '$$$' => '$$$', '$$$$' => '$$$$'  );
    var $venueAtmospheres = array(  'Casual' => 'Casual', 'Family Friendly' => 'Family Friendly', 'Upscale' => 'Upscale', 'Fun' => 'Fun'  );
   
    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('view', 'index');
    }

    function view() {
		
        $slug = Sanitize::paranoid($this->params['url']['url'], array('-') );
        if (!$slug) {
            $this->Session->setFlash('Invalid Venue.');
            $this->redirect(array('controller' => 'landings', 'action' => 'home') );
        }

        $this->_getFacebookComments($slug);
        
        $cacheName = "venue_{$slug}";
        $data = Cache::read($cacheName);

        // if not in cache, then go to DB
        if ($data == false) {
            $data = $this->Venue->find('first', array('conditions' => array(
                                                        'Venue.slug' => $slug,
                                                        'Venue.publish_state_id' => Configure::read('Venue.published')
                                                        ) ) );
            if (!$data)
                $this->cakeError('error404');
        }

        // store data in cache
        Cache::write( $cacheName, $data);
       

        $this->set('venue', $data );
        $this->data = $data;

        $this->set( 'venuesNearby', $this->Venue->getNearbyVenues( $data['Venue']['geo_lat'], $data['Venue']['geo_lng'], $data['Venue']['id'] ) );

        //$this->Venue->VenueView->addAVisit( $this->data['Venue']['id'], $this->Utilities->getRealIpAddr() );

        $this->set('venueRating', ClassRegistry::init('VenueRating')->getVenueScore($data['Venue']['id']) );

        $this->set('userAlreadyVoted', ClassRegistry::init('VenueRating')->getUserAlreadyVoted( $data['Venue']['id'], $this->Utilities->getRealIpAddr() ) );


    }

    function index() {
        $this->Venue->recursive = 0;
       

        if ( isset( $this->params['named']['list_type'] ) ) {
            $num = intval($this->params['named']['num']);

            switch( $this->params['named']['list_type'] ) {
                case 'new_venues':
                        $this->paginate = array(
                            'contain' => array('City', 'PublishState.id'),
                            'conditions' => array(
                                'PublishState.id' => Configure::read('Venue.published')
                                ),
                            'order' =>  'Venue.created DESC',
                            'limit' => $num );     
                    break;
                

                default:
                    // no action
            }
        }

       // debug($this->paginate);

        $venues = $this->paginate();
        if (isset($this->params['requested'])) {
            return $venues;
        } else {
            $this->set('venues', $venues );
        }

    }

    function load_rss() {
        App::import('Core', 'HttpSocket');
        App::import('Core', 'Xml');
        App::import('Core', 'Set');
        $feedLink = 'http://feeds2.feedburner.com/ComputerDealersInternetCafesYvrtechca';

        $this->layout = 'ajax';
        $HttpSocket = new HttpSocket();
        $result = $HttpSocket->get($feedLink);
        
        $xml = new Xml($result);
        $xmlAsArray = Set::reverse($xml);
        debug($xmlAsArray);
    }

    function admin_ajax_clone_venue() {
        $this->autoRender = false;
		$this->Venue->virtualFields = false; // turn off to prevent problems with Expandable behaviour creating extra fields
		
        $id = Sanitize::paranoid( $this->params['url']['venueId']);
        $address = $this->params['url']['address'];
       
        if ($id) {
            $record = $this->Venue->find('first', array(
                'contain' => array('RestaurantHour', 'VenueDetail',
                    'VenueType', 'VenueSubtype',
                    'VenueProduct', 'VenueService', 'VenueAmenity'),
                'conditions' => array('Venue.id' => $id)));
          
            unset($record['Venue']['id'],
                    $record['VenueDetail']['id'],
                    $record['VenueDetail']['last_verified'],
                    $record['RestaurantHour']['id'],
                    $record['Venue']['created'],
                    $record['Venue']['modified']);

            // next 5 for/each clear out venue_id/id so orginal venue record not broken
            foreach( $record['VenueProduct'] as $i => $row) {
                unset( $record['VenueProduct'][$i]['VenuesVenueProduct']['id']);
                unset( $record['VenueProduct'][$i]['VenuesVenueProduct']['venue_id']);
            }

            foreach( $record['VenueService'] as $i => $row) {
                unset( $record['VenueService'][$i]['VenuesVenueService']['id']);
                unset( $record['VenueService'][$i]['VenuesVenueService']['venue_id']);
            }

            foreach( $record['VenueAmenity'] as $i => $row) {
                unset( $record['VenueAmenity'][$i]['VenuesVenueAmenity']['id']);
                unset( $record['VenueAmenity'][$i]['VenuesVenueAmenity']['venue_id']);
            }

             foreach( $record['VenueType'] as $i => $row) {
                unset( $record['VenueType'][$i]['VenuesVenueType']['id']);
                unset( $record['VenueType'][$i]['VenuesVenueType']['venue_id']);
            }

             foreach( $record['VenueSubtype'] as $i => $row) {
                unset( $record['VenueSubtype'][$i]['VenuesVenueSubtype']['id']);
                unset( $record['VenueSubtype'][$i]['VenuesVenueSubtype']['venue_id']);
            }
            
            //debug($record);
            $record['Venue']['intersection_id'] = 0;
            $record['Venue']['city_neighbourhood_id'] = 0;
            $record['Venue']['city_region_id'] = 0;
            $record['Venue']['slug'] = '';
            $record['Venue']['publish_state_id'] = 1;
			
			
			$record['Venue']['phone'] = '000.000.0000';

            $data = $this->Locations->getGeocodedAddress($address);
            //debug($data);

            $record['Venue']['geo_lat'] = $data['lat'];
            $record['Venue']['geo_lng'] = $data['lng'];
            $record['Venue']['address'] = $data['address'] .'.';
            $record['VenueDetail']['postal_code'] = $data['postal'];
			
			// try and guess intersection and region by looking at nearby venues
			$nearbyVenues = $this->Venue->getNearbyVenueIntersection( $data['lat'], $data['lng'] );
			if ( !empty($nearbyVenues) ) {
				$intersectionId = 0;
				$neighbourhoodId = 0;
				$cityRegionId = 0;
				foreach( $nearbyVenues as $venue) {
					if ( !empty($venue['Intersection']) && $intersectionId == 0 )
						$intersectionId = intval($venue['Intersection']['id']);
					if ( !empty($venue['CityNeighbourhood']) && $neighbourhoodId == 0 )
						$neighbourhoodId = intval($venue['CityNeighbourhood']['id']);	
					if ( !empty($venue['CityRegion']) && $cityRegionId == 0 )
						$cityRegionId = intval($venue['CityRegion']['id']);							
				}
				
				$record['Venue']['intersection_id'] = $intersectionId;
				$record['Venue']['city_neighbourhood_id'] = $neighbourhoodId;
				$record['Venue']['city_region_id'] = $cityRegionId;
			}			
			
			// add the city name as a guess for what this new venue should be
            $record['Venue']['sub_name'] .= ' (' . $data['city'] .')';

            // set-up region, city id
            $record['Venue']['region_id'] = $data['region_id'];
            $record['Venue']['city_id'] = $data['city_id'];

            $this->Venue->create();
           // debug($record); //exit;
            $this->Venue->set( $record );


            if ($this->Venue->validates()) {
                $this->Venue->saveAll($record, array('validate' => false) );
                echo json_encode( array(
                    'msg' => $record['Venue']['name'] . ' Cloned',
                    'status' => 'ok',
                    'venue_id' => $this->Venue->id ) );
               // exit;
            } else {
                //debug( $this->Venue->invalidFields() );
                $badFields = '';
                foreach( $this->Venue->invalidFields() as $field => $error )
                    $badFields .= " {$field}: {$error}, ";

                echo json_encode( array(
                    'msg' => 'Error cloning ' . $record['Venue']['name'] . "\n" . $badFields,
                    'status' => 'error') );
               // exit;
               
            }
            exit;
           
        }
    }

    function admin_index() {
		debug($this->params);
		//debug($this->data);
		
		$conditions = array();
		if(!empty($this->data)) {
                    if ( $this->data['filter_clear'] == 1) {
                        $this->Session->delete('Admin.venueFilter');
                    } else {
                        $this->Session->write('Admin.venueFilter', $this->data['Venue']);
                        $fields = $this->data['Venue'];
                    }
		} else {
                    $fields = $this->Session->read('Admin.venueFilter');
		}

                if ( isset($this->params['named']['page']))
                    $this->Session->write('Admin.venueFilter.page',  $this->params['named']['page'] );

                if ( isset($this->params['named']['sort']))
                    $this->Session->write('Admin.venueFilter.sort',  $this->params['named']['sort'] );

                if ( isset($this->params['named']['direction']))
                    $this->Session->write('Admin.venueFilter.direction',  $this->params['named']['direction'] );


		//debug($this->Session->read('Admin.venueFilter'));
		// now create the filter conditions
		//debug($fields);


                /*
                    [named] => Array
        (
            [page] => 1
            [sort] => name

                */
                
		$conditions = array();
		if ( isset($fields) ) {
			foreach( $fields as $name => $value) {
					switch($name) {
						case 'city_id':
							$conditions['Venue.city_id'] = $value;
						break;
						case 'city_region_id':
							$conditions['Venue.city_region_id'] = $value;
						break;
						case 'city_neighbourhood_id':
							$conditions['Venue.city_neighbourhood_id'] = $value;
						break;					
						case 'intersection_id':
							$conditions['Venue.intersection_id'] = $value;
						break;
						case 'chain_id':
							$conditions['Venue.chain_id'] = $value;
						break;					
					}
			}
		}
		//debug($conditions);
		
		$conditions = array_filter( $conditions, array('VenuesController', '_removeEmptyElement' ) );	
		
		
		//debug($conditions);
		
		//$conditions = array( 'Venue.chain_id' => $this->data['Venue']['chain_id'], 'Venue.city_id' => $this->data['Venue']['city_id'] );
		
		
        $this->Venue->recursive = 0;
        $this->paginate = array('limit' => 20);
        $this->set('venues', $this->paginate('Venue', $conditions ));
		
		$this->set('cities', $this->Venue->City->find('list') );
		$this->set('chains', $this->Venue->Chain->find('list') );
		$this->set('cityRegions', $this->Venue->CityRegion->find('list') );
		$this->set('cityNeighbourhoods', $this->Venue->CityNeighbourhood->find('list') );
		$this->set('intersections', $this->Venue->Intersection->find('list') );
		
    }

    function admin_add() {
        
        if (!empty($this->data)) {

            if ($this->Venue->saveAll($this->data)) {
                $this->Session->setFlash('The Venue has been saved');
                // update the search index
                $result = $this->requestAction(
                        '/admin/searches/update_index/' . $this->data['Venue']['id']
                );
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Venue could not be saved. Please, try again.', true));
            }
        }

        $venueTypes = $this->Venue->VenueType->find('list', array('order' => 'name'));
        $regions = $this->Venue->Region->find('list', array('order' => 'name'));
        $cities = $this->Venue->City->find('list', array('order' => 'name'));

        $venueSubtypes = $this->Venue->VenueSubtype->find('list', array('fields' =>
                array('VenueSubtype.id', 'VenueSubtype.name', 'VenueType.name'),
                'recursive' => 0,
                'order' => array('VenueType.name', 'VenueSubtype.name')
            ) );
        $venueAmenities = $this->Venue->VenueAmenity->find('list', array('fields' =>
                array('VenueAmenity.id', 'VenueAmenity.name', 'VenueType.name'),
                'recursive' => 0,
                'order' => array('VenueType.name', 'VenueAmenity.name')
            ) );
        $venueProducts = $this->Venue->VenueProduct->find('list', array('fields' =>
                array('VenueProduct.id', 'VenueProduct.name', 'VenueType.name'),
                'recursive' => 0,
                'order' => array('VenueType.name', 'VenueProduct.name')
            ) );
        $venueServices = $this->Venue->VenueService->find('list', array('fields' =>
                array('VenueService.id', 'VenueService.name', 'VenueType.name'),
                'recursive' => 0,
                'order' => array('VenueType.name', 'VenueService.name')
            ) );
        $cityRegions = $this->Venue->CityRegion->find('list', array('fields' =>
                array('CityRegion.id', 'CityRegion.name', 'City.name'),
                'recursive' => 0,
                'order' => array('City.name', 'CityRegion.name')
            ) );

        $cityNeighbourhoods = $this->Venue->CityNeighbourhood->find('list', array('fields' =>
                array('CityNeighbourhood.id', 'CityNeighbourhood.name', 'City.name'),
                'recursive' => 0,
                'order' => array('City.name', 'CityNeighbourhood.name')
            ) );

        $intersections = $this->Venue->Intersection->find('list', array('fields' =>
                array('Intersection.id', 'Intersection.name', 'City.name'),
                'recursive' => 0,
                'order' => array('City.name', 'Intersection.name')
            ) );


        $publishStates = $this->Venue->PublishState->find('list');
        $clientTypes = $this->Venue->ClientType->find('list');
        $chains = $this->Venue->Chain->find('list', array('order' => 'Chain.name') );
        $this->set(compact('venueAmenities','venueProducts','venueServices',
                'venueSubtypes','venueTypes','regions','cities','cityRegions',
                'cityNeighbourhoods','intersections','publishStates',
                'clientTypes', 'chains'));

        // Street view
        $streetView = $this->Venue->VenueMeta->find('first', array(
            'conditions' => array('VenueMeta.venue_id' => 0, 'VenueMeta.meta_key' => 'street_view')
        ) );
       
        $this->set( compact('streetView'));

        $this->set( 'venueAtmospheres', $this->venueAtmospheres);
        $this->set( 'venuePriceRanges', $this->venuePriceRanges);
    }

    function admin_edit($id = null) {




        $this->Uploader->uploadDir = 'img/venue_photos/';
        $this->Uploader->maxFileSize = '2M'; // 2 Megabytes

        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Venue', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            
            if ( !empty($this->data['Venue']['photo_1']['name']) ) {
                
                if ($result = $this->Uploader->uploadAll() ) { //debug($result); exit;
                    $this->data['Venue']['photo_1'] = $result['Venue.photo_1']['name'];

                    $resized_path = $this->Uploader->resize(array('width' => 183, 'height' => 97, 'append' => '_med'));
                    $this->data['Venue']['photo_2'] = basename($resized_path);
                    $resized_path = $this->Uploader->resize(array('width' => 78, 'height' => 56, 'append' => '_sm'));
                    $this->data['Venue']['photo_3'] = basename($resized_path);
                }
            } else {
               
                if ( $this->data['Venue']['clear_photo'] == 1 ) {  // remove photo from DB if checked
                    $this->data['Venue']['photo_1_name'] = '';
                    unset($this->data['Venue']['clear_photo']); // so Extendable doesn't save it
                }
                $this->data['Venue']['photo_1'] = $this->data['Venue']['photo_1_name'];
            }
            // so it's not saved 
            unset($this->data['Venue']['photo_1_name']);
			
            if ($this->Venue->saveAll($this->data)) {
                $this->Session->setFlash('The Venue has been saved');
                // update the search index
                $result = $this->requestAction(
                        '/admin/searches/update_index/' . $this->data['Venue']['id']
                );
               
               
               // retraive any pageination params (page, sort field, etc.) so we go back to same page
               $newUrl = array('action'=>'index');

               if ( $this->Session->check('Admin.venueFilter.page') )
                $newUrl['page'] = $this->Session->read('Admin.venueFilter.page');
               
               if ( $this->Session->check('Admin.venueFilter.sort') ) 
                $newUrl['sort'] = $this->Session->read('Admin.venueFilter.sort');
               
               if ( $this->Session->check('Admin.venueFilter.direction') ) 
                $newUrl['direction'] = $this->Session->read('Admin.venueFilter.direction');
                
                Cache::clear(); clearCache(); // clear-out the cache in case we've changed options

                $this->redirect( $newUrl);


            } else {
                $this->Session->setFlash(__('The Venue could not be saved. Please, try again.', true));
            }

            // lastly, clear out the cache
            
        }
        if (empty($this->data)) {
            $this->data = $this->Venue->read(null, $id);
        }

        
        $venueTypes = $this->Venue->VenueType->find('list', array('order' => 'name'));
        $regions = $this->Venue->Region->find('list', array('order' => 'name'));
        $cities = $this->Venue->City->find('list', array('order' => 'name'));

        $venueSubtypes = $this->Venue->VenueSubtype->find('list', array('fields' =>
                array('VenueSubtype.id', 'VenueSubtype.name', 'VenueType.name'),
                'recursive' => 0,
                'order' => array('VenueType.name', 'VenueSubtype.name')
            ) );
        $venueAmenities = $this->Venue->VenueAmenity->find('list', array('fields' =>
                array('VenueAmenity.id', 'VenueAmenity.name', 'VenueType.name'),
                'recursive' => 0,
                'order' => array('VenueType.name', 'VenueAmenity.name')
            ) );
        $venueProducts = $this->Venue->VenueProduct->find('list', array('fields' =>
                array('VenueProduct.id', 'VenueProduct.name', 'VenueType.name'),
                'recursive' => 0,
                'order' => array('VenueType.name', 'VenueProduct.name')
            ) );
        $venueServices = $this->Venue->VenueService->find('list', array('fields' =>
                array('VenueService.id', 'VenueService.name', 'VenueType.name'),
                'recursive' => 0,
                'order' => array('VenueType.name', 'VenueService.name')
            ) );
        $cityRegions = $this->Venue->CityRegion->find('list', array('fields' =>
                array('CityRegion.id', 'CityRegion.name', 'City.name'),
                'recursive' => 0,
                'order' => array('City.name', 'CityRegion.name')
            ) );

        $cityNeighbourhoods = $this->Venue->CityNeighbourhood->find('list', array('fields' =>
                array('CityNeighbourhood.id', 'CityNeighbourhood.name', 'City.name'),
                'recursive' => 0,
                'order' => array('City.name', 'CityNeighbourhood.name')
            ) );

        $intersections = $this->Venue->Intersection->find('list', array('fields' =>
                array('Intersection.id', 'Intersection.name', 'City.name'),
                'recursive' => 0,
                'order' => array('City.name', 'Intersection.name')
            ) );

       
        $publishStates = $this->Venue->PublishState->find('list');
        $clientTypes = $this->Venue->ClientType->find('list');
        $chains = $this->Venue->Chain->find('list', array('order' => 'Chain.name') );
        $this->set(compact('venueAmenities','venueProducts','venueServices',
                'venueSubtypes','venueTypes','regions','cities','cityRegions',
                'cityNeighbourhoods','intersections','publishStates',
                'clientTypes', 'chains'));

        $this->set( 'venueAtmospheres', $this->venueAtmospheres);
        $this->set( 'venuePriceRanges', $this->venuePriceRanges);
        
    }

    
    function admin_delete($id = null) {
        $this->autoRender = false;
        if (!$id) {
            $this->Session->setFlash('Invalid id for Venue');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Venue->delete($id)) {
            $result = $this->requestAction(
                    '/admin/searches/delete_from_index/' . $id
            );
            $this->Session->setFlash('Venue deleted');
            $this->redirect(array('action'=>'index'));
        }
    }

	// ==========================================================================================
	
	function _removeEmptyElement($item) {
		if ( empty($item))
			return false;
		else 
			return true;
	}

        //

        function _getFacebookComments($venueSlug) {
            //$venueSlug = 'willys-jerk';
            $url = Configure::read('Facebook.commentUrl') . $venueSlug;

            $request_url ="https://graph.facebook.com/comments/?ids=" . $url;
            $requests = file_get_contents($request_url);

            $request = json_decode($requests, true);

            $comments = array();
            foreach ( $request[$url]['data'] as $i => $data) {
                //debug( $data );
                array_push( $comments,
                        array('id' => $data['id'], 'author' =>  $data['from']['name'], 'created' => $data['created_time'], 'message' => $data['message'])
                        );
            }

            // now save them
            $venueId = $this->Venue->find('first', array( 'conditions' => array('slug' =>$venueSlug), 'fields' => 'id', 'contain' => false));

            foreach ( $comments as $comment) {

                // check if the comment is already stored
                $count = $this->Venue->Comment->find('count', array('conditions' => array('Comment.author_ip' => $comment['id'] ) ));
                if ( $count < 1) {
                    $this->Venue->Comment->create();

                    $userComment = $comment['message'];
                   /* if(strlen($userComment) > 100) {
                        $userComment = substr($userComment, 0, 100);
                        $userComment .= '...';
                    }
					*/
					
                    $data = array('Comment' => array(
                        'venue_id' => $venueId['Venue']['id'],
                        'author' => $comment['author'],
                        'author_ip' => $comment['id'],
                        'comment' => $userComment,
                        'created' => $comment['created'],
                        'comment_agent' => 'Facebook',
                        'comment_status_id' => 2,
                        'flag_front_page' => 1
                    ));
                    $this->Venue->Comment->save($data, false);
                }
            }
        }


}
?>
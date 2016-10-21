<?php
class TagsVenuesController extends AppController {

    var $name = 'TagsVenues';
    var $helpers = array('Html', 'Form');
    var $components = array('RequestHandler');

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

    private $stemmer;


        function beforeRender() {
            // change layout for admin section
            if (isset($this->params[Configure::read('Routing.admin')]) && !$this->RequestHandler->isAjax() )
                    $this->layout = 'admin_default';
        }
        
        /*
         * -------------------------------------------------------------------
         */

	function admin_update() {

            App::import('Vendor', 'Stemmer', array('file' => 'class.stemmer.inc'));
            $stemmer = new Stemmer();

            //debug($this->data);

            if ( $this->data) {

                // first the tags
                if ( !empty($this->data['Tag']) ) {
                    foreach( $this->data['Tag'] as $i => $row ) {

                        // delete tag?
                        if ( isset($row['flag_delete']) &&  $row['flag_delete'] == 1) {
                            $tagsVenueId = $row['TagsVenue']['id'];
                            $tagId = $row['id'];
                            $this->TagsVenue->deleteTag($tagsVenueId, $tagId);
                        } else {
                            // save the new tag if new
                            $stemmedTag = $stemmer->stem($row['name']);
                            $stemmedTag = str_replace("'", '', $stemmedTag);
                            $tagId = $this->TagsVenue->Tag->updateTag($stemmedTag);

                            if ( $tagId != false ) {
                                // and update the TagsVenue table
                                $this->TagsVenue->updateTagsVenue(
                                        $this->data['TagsVenue']['venue_id'],
                                        $tagId,
                                        $row['TagsVenue']['weight']
                                    );
                            }
                        }
                    }
                }
                $this->TagsVenue->contain('Tag');
                $this->set( 'tagData', $this->TagsVenue->find('all',
                            array('conditions' =>
                                    array('TagsVenue.venue_id' =>
                                            $this->data['TagsVenue']['venue_id'])
                                    ) )
                            );

                $this->set('venueId', $this->data['TagsVenue']['venue_id'] );
                //exit();
            }
	}

        /*
         * add new tags
         */
        function admin_generate_tags() {
           App::import('Sanitize');

           //debug($this->params);exit();
           // if ( !isset($this->params['data']))
           //     return false;

            App::import('Vendor', 'Stemmer', array('file' => 'class.stemmer.inc'));
            $stemmer = new Stemmer();

            $this->stemmer = new Stemmer();

            $this->layout = 'admin_default';

            if ( isset($this->params['data']))
                $data = $this->params['data'];
            else
                $data = $this->params['url'];

            // strategy:
            /*
             * stem name and full name as is (after filter)
             */

           $venueId = $data['Venue']['id'];

           $name = $data['Venue']['name'];
           $fullName = $data['Venue']['name'] . ' ' . $data['Venue']['subname'];

           $name = Sanitize::paranoid($name, array(' ') );
           $fullName = Sanitize::paranoid($fullName, array(' ') );

           $stemmedTag = $this->stemmer->stem($name);
           $this->_addWeightedTag($stemmedTag, $venueId, 10);

           $stemmedTag = $this->stemmer->stem($fullName);
           $this->_addWeightedTag($stemmedTag, $venueId, 10);

           // address
           $address = Sanitize::paranoid($data['Venue']['address'], array(' ') );



           // full address - same as names are stored
           $stemmedTag = $this->stemmer->stem($address);
           $this->_addWeightedTag($stemmedTag, $venueId, 9);
           // address without the street extension
           $address = $this->_removeStopWordsFromStr($address);
           $stemmedTag = $this->stemmer->stem($address);
           $this->_addWeightedTag($stemmedTag, $venueId, 9);

           // city
           $city = $this->_lookupTable('City', $data['Venue']['city_id']);
           $city = Sanitize::paranoid($city, array(' ') );
           $stemmedTag = $this->stemmer->stem($city);
           $this->_addWeightedTag($stemmedTag, $venueId, 5);

           //intersection
           $intersection = $this->_lookupTable('Intersection', $data['Venue']['intersection_id']);
           $intersection = Sanitize::paranoid($intersection, array(' ', '/') );

           $streets = explode('/', $intersection);
           if ( sizeof($streets) == 2) {
                $street = $this->_removeStopWordsFromStr($streets[0]);
                $stemmedTag = $this->stemmer->stem($street);
                $this->_addWeightedTag($stemmedTag, $venueId, 5);
                $street = $this->_removeStopWordsFromStr($streets[1]);
                $stemmedTag = $this->stemmer->stem($street);
                $this->_addWeightedTag($stemmedTag, $venueId, 5);
           }

           // venue type
           $venueType = $this->_lookupTable('VenueType', $data['Venue']['venue_type_id']);
           if ( strpos($venueType, '/') ) {
               $venueTypes = explode('/', $venueType);
               $venueType = Sanitize::paranoid($venueTypes[0], array(' ') );
               $stemmedTag = $this->stemmer->stem($venueType);
               $this->_addWeightedTag($stemmedTag, $venueId, 1);
               // 2nd word
               $venueType = Sanitize::paranoid($venueTypes[1], array(' ') );
               $stemmedTag = $this->stemmer->stem($venueType);
               $this->_addWeightedTag($stemmedTag, $venueId, 1);
           } else { // just one venue type
               $venueType = Sanitize::paranoid($venueType, array(' ') );
               $stemmedTag = $this->stemmer->stem($venueType);
               $this->_addWeightedTag($stemmedTag, $venueId, 1);
           }

           // cuisine types
           $cuisineList = array(
                $data['Venue']['venue_cuisine_type_id'],
                $data['VenueDetail']['venue_cuisine_type_2_id'],
                $data['VenueDetail']['venue_cuisine_type_3_id'],
                $data['VenueDetail']['venue_cuisine_type_4_id'],
           );

           // add in cuisine types with deceding weights - move to function
           // for other food types and amenities
           $weights = array( 8, 7, 6, 5, 4, 3, 2, 1);
           $this->_addItemsList( $cuisineList, 'VenueCuisineType', $weights, $venueId);
           
           // bar types
           $bartypeList = array(
                $data['Venue']['venue_bar_type_id'],
                $data['VenueDetail']['venue_bar_type_2_id']
           );
           $weights = array( 8, 7, 6, 5, 4, 3, 2, 1);
           $this->_addItemsList( $bartypeList, 'VenueBarType', $weights, $venueId);

           // cafe types
           $cafetypeList = array(
                $data['Venue']['venue_cafe_type_id'],
                $data['VenueDetail']['venue_cafe_type_2_id']
           );
           $weights = array( 8, 7, 6, 5, 4, 3, 2, 1);
           $this->_addItemsList( $cafetypeList, 'VenueCafeType', $weights, $venueId);

           // Cater types
           $catertypeList = array(
                $data['Venue']['venue_cater_type_id'],
                $data['VenueDetail']['venue_cater_type_2_id']
           );
           $weights = array( 8, 7, 6, 5, 4, 3, 2, 1);
           $this->_addItemsList( $catertypeList, 'VenueCaterType', $weights, $venueId);

           // Hotel types
           $hoteltypeList = array(
                $data['Venue']['venue_hotel_type_id'],
                $data['VenueDetail']['venue_hotel_type_2_id']
           );
           $weights = array( 8, 7, 6, 5, 4, 3, 2, 1);
           $this->_addItemsList( $hoteltypeList, 'VenueHotelType', $weights, $venueId);

           // Attraction types
           $attractiontypeList = array(
                $data['Venue']['venue_attraction_type_id'],
                $data['VenueDetail']['venue_attraction_type_2_id']
           );
           $weights = array( 8, 7, 6, 5, 4, 3, 2, 1);
           $this->_addItemsList( $attractiontypeList, 'VenueAttractionType', $weights, $venueId);

           // Feature types
           $featureTypeList = array(
                $data['VenueDetail']['venue_feature_1_id'],
                $data['VenueDetail']['venue_feature_2_id'],
                $data['VenueDetail']['venue_feature_3_id'],
                $data['VenueDetail']['venue_feature_4_id'],
                $data['VenueDetail']['venue_feature_5_id']
           );
           $weights = array( 6, 6, 5, 5, 4, 4, 3, 2, 1);
           $this->_addItemsList( $featureTypeList, 'VenueFeature', $weights, $venueId);

           // Amenities types
           $amenitiesTypeList = array(
                $data['VenueDetail']['venue_amenity_1_id'],
                $data['VenueDetail']['venue_amenity_2_id'],
                $data['VenueDetail']['venue_amenity_3_id'],
                $data['VenueDetail']['venue_amenity_4_id'],
                $data['VenueDetail']['venue_amenity_5_id']
           );
           $weights = array( 6, 6, 5, 5, 4, 4, 3, 2, 1);
           $this->_addItemsList( $amenitiesTypeList, 'VenueAmenity', $weights, $venueId);

           // venue chain
           $venueChain = $this->_lookupTable('VenueChain', $data['Venue']['venue_chain_id'] );
           if ( $venueChain) {
                $stemmedTag = $this->stemmer->stem($venueChain);
                $this->_addWeightedTag($stemmedTag, $venueId, 5);
           }

           // atmosphere types
           $atmosTypeList = array(
                $data['VenueDetail']['venue_atmosphere_1_id'],
                $data['VenueDetail']['venue_atmosphere_2_id']
           );
           $weights = array( 6, 6);
           $this->_addItemsList( $atmosTypeList, 'VenueAtmosphere', $weights, $venueId);

           // dress code types
           $dressCodeList = array(
                $data['VenueDetail']['venue_dress_code_id']
           );
           $weights = array( 6, 6);
           $this->_addItemsList( $dressCodeList, 'VenueDressCode', $weights, $venueId);

           // postal code
           $postalCode = strtolower(Sanitize::paranoid($data['VenueDetail']['postal']));
           $stemmedTag = $this->stemmer->stem($postalCode);
           $this->_addWeightedTag($stemmedTag, $venueId, 8);

           // city region
           $cityRegionList = array(
                $data['Venue']['city_region_id']
           );
           $weights = array(8,8);
           $this->_addItemsList( $cityRegionList, 'CityRegion', $weights, $venueId);

           return;
        }




	function index() {
		$this->TagsVenue->recursive = 0;
		$this->set('tagsVenues', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TagsVenue.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tagsVenue', $this->TagsVenue->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TagsVenue->create();
			if ($this->TagsVenue->save($this->data)) {
				$this->Session->setFlash(__('The TagsVenue has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TagsVenue could not be saved. Please, try again.', true));
			}
		}
		$venues = $this->TagsVenue->Venue->find('list');
		$tags = $this->TagsVenue->Tag->find('list');
		$this->set(compact('venues', 'tags'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TagsVenue', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TagsVenue->save($this->data)) {
				$this->Session->setFlash(__('The TagsVenue has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TagsVenue could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TagsVenue->read(null, $id);
		}
		$venues = $this->TagsVenue->Venue->find('list');
		$tags = $this->TagsVenue->Tag->find('list');
		$this->set(compact('venues','tags'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TagsVenue', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TagsVenue->del($id)) {
			$this->Session->setFlash(__('TagsVenue deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->TagsVenue->recursive = 0;
		$this->set('tagsVenues', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TagsVenue.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tagsVenue', $this->TagsVenue->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TagsVenue->create();
			if ($this->TagsVenue->save($this->data)) {
				$this->Session->setFlash(__('The TagsVenue has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TagsVenue could not be saved. Please, try again.', true));
			}
		}
		$venues = $this->TagsVenue->Venue->find('list');
		$tags = $this->TagsVenue->Tag->find('list');
		$this->set(compact('venues', 'tags'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TagsVenue', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TagsVenue->save($this->data)) {
				$this->Session->setFlash(__('The TagsVenue has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TagsVenue could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TagsVenue->read(null, $id);
		}
		$venues = $this->TagsVenue->Venue->find('list');
		$tags = $this->TagsVenue->Tag->find('list');
		$this->set(compact('venues','tags'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TagsVenue', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TagsVenue->del($id)) {
			$this->Session->setFlash(__('TagsVenue deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

        /*
         *
         */
        function _addItemsList($itemList, $model, $weights, $venueId) {
           $weightCounter = 0;
           foreach ($itemList as $cuisineId) {
                $cuisineType = $this->_lookupTable($model, $cuisineId);

                if ($cuisineType) {

                    if ( strpos($cuisineType, '/') ) {
                       $cuisineTypes = explode('/', $cuisineType);
                       $cuisineType = Sanitize::paranoid($cuisineTypes[0], array(' ') );
                       $stemmedTag = $this->stemmer->stem($cuisineType);
                       $this->_addWeightedTag($stemmedTag, $venueId, $weights[$weightCounter]);
                       // 2nd word
                       $cuisineType = Sanitize::paranoid($cuisineTypes[1], array(' ') );
                       $stemmedTag = $this->stemmer->stem($cuisineType);
                       $this->_addWeightedTag($stemmedTag, $venueId, $weights[$weightCounter]);
                       $weightCounter ++;

                    } else { // just one venue type
                        $cuisineType = Sanitize::paranoid($cuisineType, array(' ') );
                        $stemmedTag = $this->stemmer->stem($cuisineType);
                        $this->_addWeightedTag($stemmedTag, $venueId, $weights[$weightCounter]);
                        $weightCounter ++; // move to the next lowest weight next
                    }
                }
           }
        }


        /*
         * add a new weighted tag for a venue
         */
        function _addWeightedTag( $stemmedTag, $venueId, $weight = 0 ) {
            if ( !$venueId )
                return false;
                
            $tagId = $this->TagsVenue->Tag->updateTag($stemmedTag);
            if ( $tagId != false ) {
                // and update the TagsVenue table
                $this->TagsVenue->updateTagsVenue(
                        $venueId,
                        $tagId,
                        $weight // default weight
                    );
            }
        }

        /*
         * look-up a name from a table
         */
        function _lookupTable($modelName, $id) {
            debug($modelName);
            $this->loadModel($modelName);
            $this->$modelName->contain();
            $result = $this->$modelName->findById($id);
            if ($result)
                return($result[$modelName]['name']);
            else
                return false;
        }

        /*
         * Break-up a string, remove stop words and return re-assembled
         */
        function _removeStopWordsFromStr($phrase) {
            $phrase = strtolower($phrase);
            $wordList = explode(' ', $phrase);
            $wordList = $this->_removeStopWords($wordList);
            $phrase = implode(' ', $wordList);
            return($phrase);
        }

    /*
     * remove stop words
     */
    function _removeStopWords( $words) {
        return array_diff($words, $this->stopWords);
    }

}
?>
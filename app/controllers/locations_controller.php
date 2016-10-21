<?php
App::import('Core', 'HttpSocket');
App::import('Core', 'Xml');
App::import('Core', 'Set');

class LocationsController extends AppController {

    var $name = 'Locations';
    var $uses = array();

    var $addressData, $rawData;

    function admin_encode_address() {
        $this->loadModel('Venue');
        $this->autoRender = false;
        //$this->layout = 'ajax';

        $address = trim($this->data['Venue']['raw_address']);
		
		if ( isset($this->data['Venue']['phone']) ) {
			$phone = trim($this->data['Venue']['phone']);
		}else {
			$phone = '000.000.0000';
		}
		
        $request = 'address=' . $address . '&sensor=false';

        $HttpSocket = new HttpSocket();
        $result = $HttpSocket->get('http://maps.google.com/maps/api/geocode/xml', $request);
        //debug($request);exit;
        $resultXml = new Xml($result);

        $resultXml = $resultXml->toArray();
        $status = $resultXml['GeocodeResponse']['status'];
       // debug( 'status: '.  $status);
        if ( $status == 'OK') {

            $location = Set::extract('/GeocodeResponse/Result/Geometry/Location', $resultXml);

            $addressFields = Set::extract('/GeocodeResponse/Result/AddressComponent', $resultXml);

            $this->addressData = $addressFields;

            //debug( '$lat:' . $location[0]['Location']['lat'] . ', $lng' . $location[0]['Location']['lng']);

            $this->rawData['geo_lat'] = $location[0]['Location']['lat'];

            $this->rawData['geo_lng'] = $location[0]['Location']['lng'];

        } else if ( $status == 'ZERO_RESULTS' ) {
            $this->rawData['geo_lat'] = -1;
            $this->rawData['geo_lng'] = -1;
        }else {
            $this->rawData['geo_lat'] = 0.0;
            $this->rawData['geo_lng'] = 0.0;
        }

        //debug($addressFields);
        $this->rawData['address'] = 
                $this->_lookupAddressField('street_number') . ' ' .
                $this->_lookupAddressField('route');

        // now save

            $data = array(
                'Venue' => array(
                    'name' => $this->data['Venue']['name'],
                    'slug' => '',
                    'sub_name' => '',
                    'address' => $this->_stripWhitespace($this->rawData['address']),
                    'phone' => $phone,
                    'geo_lat' => $this->rawData['geo_lat'],
                    'geo_lng' => $this->rawData['geo_lng'],
                    'region_id' => 0,
                    'city_id' => 0,
                    'city_region_id' => 0,
                    'city_neighbourhood_id' => 0,
                    'intersection_id' => 0,
                    'publish_state_id' => 0,
                    'chain_id' => 0,
                    ),
                'VenueDetail' => array(
                    'description' => 'Description...',
                    'postal_code' => $this->_lookupAddressField('postal_code')

                ),
                'RestaurantHour' => array(
                    'hours_mon' => 'closed',
                ),


            );

            // add address data from Google
            $data['Venue']['province_id'] = $this->_getVenueProvince();
            $data['Venue']['region_id'] = $this->_getVenueRegion( $data['Venue']['province_id']);
            $data['Venue']['city_id'] = $this->_getVenueCity( $data['Venue']['region_id']);

			// try and guess intersection and region by looking at nearby venues
			$nearbyVenues = $this->Venue->getNearbyVenueIntersection( $this->rawData['geo_lat'], $this->rawData['geo_lng']);
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
				
				$data['Venue']['intersection_id'] = $intersectionId;
				$data['Venue']['city_neighbourhood_id'] = $neighbourhoodId;
				$data['Venue']['city_region_id'] = $cityRegionId;
			}


         // debug($data); exit;
            $this->Venue->create();
            $this->Venue->saveAll($data, array('validate' => false) );
            $venueId = $this->Venue->id;
            $this->redirect(  $this->referer() );
    }


    /*
     * Utility functions
     */

    function _getVenueProvince() {
        $province = $this->_lookupAddressField('administrative_area_level_1');
       // debug('province:' . $province);
        return( ClassRegistry::init('Province')->updateProvince( trim($province)) );
    }

    function _getVenueRegion( $provinceId ) {
        $region = $this->_lookupAddressField('administrative_area_level_2');
        //debug('region:' . $region);
        // now ask model to get the id, adding new record if nessassary
        return( ClassRegistry::init('Region')->updateRegion( trim($region), $provinceId) );
    }

    function _getVenueCity( $regionId) {
        $city = $this->_lookupAddressField('locality');
        //debug('city:' . $city);
        return( ClassRegistry::init('City')->updateCity( trim($city), $regionId) );
    }

    function _lookupAddressField($fieldName) {
        // loop through address array untill we find the matching field,
        //  then get its value

        // type: value , Type: array
        foreach( $this->addressData as $address) {

            if ( isset($address['AddressComponent']['type']) ) {
                $type = $address['AddressComponent']['type'];
            } else if ( isset($address['AddressComponent']['Type']) ) {
                $type = $address['AddressComponent']['Type'][0];
            }else {
                debug('type/Type not set');
            }
            if ( $type == $fieldName)
                return($address['AddressComponent']['long_name']);
        }
    }

    function _stripWhitespace( $text) {
        return( trim(preg_replace('/\s\s+/', ' ', $text ) ) );
    }

    /* 
     * Returns latt/long of an address
     */
    function admin_geocode_address() {
        Configure::write('debug',0);
        //debug($this->params);
        $data = array();
        $address = $this->params['url']['address'];
        $this->autoRender = false;

        //
        $request = 'address=' . $address . '&sensor=false';

        $HttpSocket = new HttpSocket();
        $result = $HttpSocket->get('http://maps.google.com/maps/api/geocode/xml', $request);

        $resultXml = new Xml($result);

        $resultXml = $resultXml->toArray();
        $status = $resultXml['GeocodeResponse']['status'];
        //debug( 'status: '.  $status);
        if ( $status == 'OK') {
            $data['status'] = 'ok';
            $location = Set::extract('/GeocodeResponse/Result/Geometry/Location', $resultXml);

            //debug($location);
            $data['lat'] = $location[0]['Location']['lat'];
            $data['lng'] = $location[0]['Location']['lng'];
        }
        else {
            $data['status'] = $status;
        }

        //$data = array( 'status' => 'ok', 'lat' => 1.0, 'lng' => 2.5 );
        echo json_encode( $data );
    }



}
?>
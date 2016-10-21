<?php

App::import('Core', 'HttpSocket');
App::import('Core', 'Xml');
App::import('Core', 'Set');

class LocationsComponent extends Object {

    var $addressData;
    
    function getGeocodedAddress( $address) {
        $data = array();
        //$address = $this->params['url']['address'];
        $this->autoRender = false;

        $request = 'address=' . $address . '&sensor=false';

        $HttpSocket = new HttpSocket();
        debug($request);//exit;
        $result = $HttpSocket->get('http://maps.google.com/maps/api/geocode/xml', $request);

        $resultXml = new Xml($result);

        $resultXml = $resultXml->toArray();
        $status = $resultXml['GeocodeResponse']['status'];
        debug( 'status: '.  $status);
        if ( $status == 'OK') {
            $data['status'] = 'ok';
            $location = Set::extract('/GeocodeResponse/Result/Geometry/Location', $resultXml);
            $addressFields = Set::extract('/GeocodeResponse/Result/AddressComponent', $resultXml);
            $this->addressData = $addressFields;
            debug($location);
            $data['lat'] = $location[0]['Location']['lat'];
            $data['lng'] = $location[0]['Location']['lng'];

            // add address data from Google
            $data['province_id'] = $this->_getVenueProvince();
            $data['region_id'] = $this->_getVenueRegion( $data['province_id'] );
            $data['city_id'] = $this->_getVenueCity($data['region_id']);
            $data['city'] = $this->_getVenueCityName();
            //Notre Dame Drive Kamloops, BC V2C 5N9

            $data['postal'] = $this->_lookupAddressField('postal_code');

            $data['address'] = 
                $this->_lookupAddressField('street_number') . ' ' .
                $this->_lookupAddressField('route');
        }
        else {
            $data['status'] = $status;
        }
        return($data);
    }

    /*
     * Utility functions
     */

    function _getVenueProvince() {
        $province = $this->_lookupAddressField('administrative_area_level_1');
       // debug('province:' . $province);
        return( ClassRegistry::init('Province')->updateProvince( trim($province)) );
    }

    function _getVenueRegion( $provinceId) {
        $region = $this->_lookupAddressField('administrative_area_level_2');
        debug('region:' . $region);
        // now ask model to get the id, adding new record if nessassary
        return( ClassRegistry::init('Region')->updateRegion( trim($region),
                $provinceId ) );
    }

    function _getVenueCity( $regionId) {
        $city = $this->_lookupAddressField('locality');
        //debug('city:' . $city);
        return( ClassRegistry::init('City')->updateCity( trim($city), $regionId) );
    }

    function _getVenueCityName() {
        return($this->_lookupAddressField('locality'));
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

}
?>
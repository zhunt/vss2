<?php
/*
 * utility functions for displaying profiles
 */
class ProfileUtilComponent extends Object {

    function getAmenities( $data) {

        $itemList = array();
        if ( isset( $data['VenueDetail']['VenueAmenity1']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueAmenity1'] );
        if ( isset( $data['VenueDetail']['VenueAmenity2']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueAmenity2'] );
        if ( isset( $data['VenueDetail']['VenueAmenity3']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueAmenity3'] );
        if ( isset( $data['VenueDetail']['VenueAmenity4']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueAmenity4'] );
        if ( isset( $data['VenueDetail']['VenueAmenity5']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueAmenity5'] );

        return($itemList);
    }

    function getAtmosphere( $data) {
//debug($data);exit();
        $itemList = array();
        if ( isset( $data['VenueDetail']['VenueAtmosphere1']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueAtmosphere1'] );
        if ( isset( $data['VenueDetail']['VenueAtmosphere2']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueAtmosphere2'] );

        
        return($itemList);
    }

    function getCuisines( $data) {

        $itemList = array();
        if ( isset( $data['VenueCuisineType']['name']) )
            array_push($itemList, $data['VenueCuisineType'] );
        if ( isset( $data['VenueDetail']['VenueCuisineType2']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueCuisineType2'] );
        if ( isset( $data['VenueDetail']['VenueCuisineType3']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueCuisineType3'] );
        if ( isset( $data['VenueDetail']['VenueCuisineType4']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueCuisineType4'] );

        return($itemList);
    }

    function getDresscode( $data) {

        $itemList = array();
        if ( isset( $data['VenueDetail']['VenueDressCode']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueDressCode'] );
        
        return($itemList);
    }

    function getFeatures( $data) {

        $itemList = array();
        if ( isset( $data['VenueDetail']['VenueFeature1']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueFeature1'] );
        if ( isset( $data['VenueDetail']['VenueFeature2']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueFeature2'] );
        if ( isset( $data['VenueDetail']['VenueFeature3']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueFeature3'] );
        if ( isset( $data['VenueDetail']['VenueFeature4']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueFeature4'] );
        if ( isset( $data['VenueDetail']['VenueFeature5']['name']) )
            array_push($itemList, $data['VenueDetail']['VenueFeature5'] );

        return($itemList);
    }

    /*
     * venue types
     */
    function getPaymentTypes( $data) {
        $itemList = array();

        if ( $data['VenueDetail']['flag_creditcard'] )
            array_push($itemList, array( 'name' => 'Credit-cards') );
        if ( $data['VenueDetail']['flag_bankcard'] )
            array_push($itemList, array(  'name' => 'Bank-cards') );
        if ( $data['VenueDetail']['flag_cash'] )
            array_push($itemList, array(  'name' => 'Cash' ) );
        if ( $data['VenueDetail']['flag_atm'] )
            array_push($itemList, array( 'name' => 'ATM/Bank machine available') );

        return($itemList);

    }

    function getPricerange( $data) {

        $itemList = array();
        if ( isset( $data['VenueDetail']['VenuePrice']['name']) )
            array_push($itemList, $data['VenueDetail']['VenuePrice'] );

        return($itemList);
    }

    /*
     * venue types
     */
    function getVenueTypes( $data) {
        $itemList = array();

        if ( isset( $data['VenueType']['name'])) {
            $data['VenueType']['type'] = 'venueType';
            array_push($itemList, $data['VenueType'] );
        }
        if ( isset( $data['VenueCuisineType']['name']) ){
            $data['VenueCuisineType']['type'] = 'cuisine';
            array_push($itemList, $data['VenueCuisineType'] );
        }
        if ( isset( $data['VenueBarType']['name'])) {
            $data['VenueBarType']['type'] = 'bar_type';
            array_push($itemList, $data['VenueBarType'] );
        }
        if ( isset( $data['VenueCafeType']['name'])) {
            $data['VenueCafeType']['type'] = 'cafe_type';
            array_push($itemList, $data['VenueCafeType'] );
        }
        if ( isset( $data['VenueHotelType']['name'])) {
            $data['VenueHotelType']['type'] = 'hotel_type';
            array_push($itemList, $data['VenueHotelType'] );
        }
        if ( isset( $data['VenueCaterType']['name'])) {
            $data['VenueCaterType']['type'] = 'cater_type';
            array_push($itemList, $data['VenueCaterType'] );
        }
        if ( isset( $data['VenueAttractionType']['name'])) {
            $data['VenueAttractionType']['type'] = 'attraction_type';
            array_push($itemList, $data['VenueAttractionType'] );
        }
        return($itemList);

    }
}

?>

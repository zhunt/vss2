<?php
class FeaturedVenueHelper extends AppHelper {

    /*
     * displays the food or sub-type of a venue,
     * e.g. bar: night-club, rest: asian, etc.
     * TODO: add hotel, attraction type checks here
     */
    function foodType( $data) {
        switch( $data['VenueType']['id']) {
            case Configure::read('type.restaurant'):
                $food = $data['VenueCuisineType']['name'];
                break;
            case Configure::read('type.bar'):
                $food = $data['VenueBarType']['name'];
                break;
            case Configure::read('type.cafe'):
                $food = $data['VenueCafeType']['name'];
                break;
            case Configure::read('type.restaurantBar'):
                $food = $data['VenueCuisineType']['name'];
                break;
            default:
                $food = '';
        }

        return( $this->output($food));
        // $row['VenueCuisineType']['name']

    }
}
?>
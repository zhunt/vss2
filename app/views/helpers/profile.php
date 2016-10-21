<?php
/* 
 * Functions to display the venue profile
 */
class ProfileHelper extends AppHelper {
    var $helpers = array('Html');

    /*
     * returns a comma-seperated list of cuisine items
     * options: add links, add city to links ( allow search for more asian cuisinse
     * or search for more asian cuisinse in barrie)
     */

    function amenitiesList( $items, $options = null) {

        if (!empty($items)) {

            $city = $cityText = null;
            if ( isset( $options['citySlug'] ) ) {
                $city = $options['citySlug'];
                $cityText = ' in ' . $options['cityName'];
            }

            $itemsList = array();
            foreach( $items as $row) {
                array_push( $itemsList, $this->Html->link( $row['name'],
                    array('controller' => 'search',
                            'action' => 'simple',
                                'amenity' => $row['slug'], 'item' => $row['slug'],
                                'city' => $city,
                                'item' => $row['slug'] . $cityText ),
                    array('title' => 'Search for more places with ' . $row['name'].
                                        $cityText . '.') )
                    );
            }

            $html = implode( ', ', $itemsList);

            return( $this->output( $html) );
        }
        return false;
    }

    function atmosphereList( $items, $options = null) {

        if (!empty($items)) {
            $itemsList = array();
            foreach( $items as $row) {
              /*  array_push( $itemsList, $this->Html->link( $row['name'],
                    array('controller' => 'search',
                            'action' => 'atmosphere_search',
                                'item' => $row['slug']),
                    array('title' => 'Search for more places with a ' . $row['name']. ' atmosphere.' ) )
                    ); */
                array_push( $itemsList, $row['name']);

            }

            $html = implode( ', ', $itemsList);

            return( $this->output( $html) );
        }
        return false;
    }

    function cuisinesList( $items, $options = null) {

        if (!empty($items)) {

            $city = $cityText = null;
            if ( isset( $options['citySlug'] ) ) {
                $city = $options['citySlug'];
                $cityText = ' in ' . $options['cityName'];
            }

            $itemsList = array();
            foreach( $items as $row) {
                array_push( $itemsList, $this->Html->link( $row['name'],
                    array('controller' => 'search',
                            'action' => 'simple',
                                'cuisine' => $row['slug'],
                                'city' => $city,
                                'item' => $row['slug'] . $cityText ),
                    array('title' => 'Search for more ' . $row['name'] . 
                                        ' places' . $cityText . '.' ) )
                    );
            }

            $html = implode( ', ', $itemsList);

            return( $this->output( $html) );
        }
        return false;
    }



    function dresscodeList( $items, $options = null) {

        if (!empty($items)) {
            $itemsList = array();
            foreach( $items as $row) {
                array_push( $itemsList, $this->Html->link( $row['name'],
                    array('controller' => 'search',
                            'action' => 'feature_search',
                                'item' => $row['slug']),
                    array('title' => 'Search for more places with a ' . $row['name']. ' dress code.' ) )
                    );
            }

            $html = implode( ', ', $itemsList);

            return( $this->output( $html) );
        }
        return false;
    }

    function featuresList( $items, $options = null) {

        if (!empty($items)) {

            $city = $cityText = null;
            if ( isset( $options['citySlug'] ) ) {
                $city = $options['citySlug'];
                $cityText = ' in ' . $options['cityName'];
            }

            $itemsList = array();
            foreach( $items as $row) {
                array_push( $itemsList, $this->Html->link( $row['name'],
                    array('controller' => 'search',
                            'action' => 'simple',
                                'feature' => $row['slug'],
                                'city' => $city,
                                'item' => $row['slug'] . $cityText ),
                    array('title' => 'Search for more places with ' . $row['name'] .
                                        $cityText . '.' ) )
                    );
            }

            $html = implode( ', ', $itemsList);

            return( $this->output( $html) );
        }
        return false;
    }
    
    function paymentsList($items, $options = null) {
        if (!empty($items)) {
            $itemsList = array();
            foreach( $items as $row) {
                array_push( $itemsList, $row['name'] );
            }

            $html = implode( ', ', $itemsList);

            return( $this->output( $html) );
        }
        return false;
    }

    function pricerangeList($items, $options = null) {
        if (!empty($items)) {
            $itemsList = array();
            foreach( $items as $row) {
                array_push( $itemsList, $row['name'] );
            }

            $html = implode( ', ', $itemsList);

            return( $this->output( $html) );
        }
        return false;
    }

    function venueTypes($items, $options = null) {
        
        if (!empty($items)) {

            $city = $cityText = null;
            if ( isset( $options['citySlug'] ) ) {
                $city = $options['citySlug'];
                $cityText = ' in ' . $options['cityName'];
            }

            /*
             * first item is always the venue_type, use simple search,
             * use phrase search for any following items
             */
            $itemsList = array();
            $firstLoop = true;
            foreach( $items as $row) {
                if ( $firstLoop) {
                    array_push( $itemsList, $this->Html->link( $row['name'],
                        array('controller' => 'search',
                                'action' => 'simple',
                                    'venue_type' => $row['slug'], 'item' => $row['slug'],
                                    'city' => $city),
                        array('title' => 'Search for more ' . $row['name']. 's' .
                                            $cityText . '.' ) )
                        );
                    $firstLoop = false; 
                } else {
                    // /search/simple/cuisine:asian/city:/venue_type:restaurant/item:asian%20restaurant
                    array_push( $itemsList, $this->Html->link( $row['name'],
                        array('controller' => 'search',
                                'action' => 'simple',
                                    $row['type'] => $row['slug'],
                                   // 'venue_type' => $items[0]['slug'],
                                    'item' => $row['slug'] . $cityText,
                                    'city' => $city),
                        array('title' => 'Search for more ' . $row['name']. 's' .
                                            $cityText . '.' ) )
                        );

                     /*
                      * array_push( $itemsList, $this->Html->link( $row['name'],
                        array('controller' => 'search',
                                'action' => 'phrase',
                                    '?phrase=' . $row['name'] . ' ' . $cityText),
                        array('title' => 'Search for more ' . $row['name']. 's ' .
                                            $cityText . '.' ) )
                        );*/
                }
            }
            $html = implode( ', ', $itemsList);

            return( $this->output( $html) );
        }
        return false;
    }
}
?>

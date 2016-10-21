<?php
class VenuesHelper extends AppHelper {

	var $helpers = array('Html', 'Text');
	
    /* sorts a array with a name field in it,
     * like VenueProduct, VenueType, etc.
    */
    function sortType( $type ) {
       sort($type); // needed to clean keys
       return ( Set::sort( $type , '{n}.name', 'asc') );
    }

    /*
     * Sorts venue type(s) and subtype(s) and create new array with
     * name, slug and if it's a VenueType or VenueSubtype (or product)
	 * Params: 
	 *	$cuisinesOnly true|false : return only cuisine types
	 *	$limit false| 1+ : returns up to X entries
     */
    function sortVenueTypes( $types, $cuisinesOnly = false, $limit = 3) {
        $result = Set::sort( $types , '{n}.{s}.name', 'asc');
		
        $newList = array();
        foreach( $result as $i => $types) { 
			//
            foreach( $types as $type) {
				
             	if ( $cuisinesOnly && ( !isset($type['flag_cuisine']) || $type['flag_cuisine'] != 1 ) ) continue;
				
                if ( isset($type['VenuesVenueSubtype']) )
                    $subtype = 'venue_subtype';
				else if ( isset($type['VenuesVenueProduct'] ) )
					$subtype = 'product';		
                else
                    $subtype = 'venue_type';

				// might not be set, e.g. from Venue->getNearbyVenues
				if ( !isset($type['slug']) ) $type['slug'] = null;
				
                $newList[] = array('name' => $type['name'], 
                                    'slug' => $type['slug'],
                                    'subtype' => $subtype);
            }
        }
		
		if ( $limit != false ) {
			$newList = array_slice($newList,0,$limit);		
		}
    // debug($newList); exit;
        return($newList);

    }
	
    function sortProductTypes( $types) {
        $result = Set::sort( $types , '{n}.{s}.name', 'asc');

        $newList = array();
        foreach( $result as $i => $types) {
			
				if ( !isset( $types['flag_cuisine'] ) )
					$types['flag_cuisine'] = false;
				
                $newList[$types['slug'] ] = array( 'name' => $types['name'], 'slug' => $types['slug'], 'flag_cuisine' => $types['flag_cuisine'] );
           
        }
      
        return($newList);
    } 

    /*
     * Displays a number as distance, in metres and kilometres
     * params:
     * $distance (kilometres)
     */
    function distance( $distance, $unit = 'metres') {
        //debug($distance);
		
		
		if ( Configure::read('Vcc.measurement_units') == 'miles' || $unit == 'miles') {
			$distance = floatval($distance) * 0.621371192; 
			return( round(floatval($distance), 2) . ' miles' ); // 1 km = 0.621371192 miles
		} else {
			if ( $distance >= 1) {
				return( round(floatval($distance), 1) . 'km' );
			} else {
				return( round(floatval($distance) * 1000, 0) . 'm' );
			}
		}
    }

    /*
     * Used by search to add 3 features
     */
    function getFeaturesList( $venueData) {

       $numFeatures = 2; // size of list to return

        $amenities = Set::extract( $venueData , 'VenueAmenity.{n}.name', 'asc');
        $amenitiesSlug = Set::extract( $venueData , 'VenueAmenity.{n}.slug', 'asc');
        
        $products = Set::extract( $venueData , 'VenueProduct.{n}.name', 'asc');
        $productsSlug = Set::extract( $venueData , 'VenueProduct.{n}.slug', 'asc');

        $services = Set::extract( $venueData , 'VenueService.{n}.name', 'asc');
        $servicesSlug = Set::extract( $venueData , 'VenueService.{n}.slug', 'asc');

        foreach( $amenities as $i => $row) {
            $amenities[$i] = array('name' => $row, 'type' => 'amenity');
        }
        
        foreach( $products as $i => $row) {
            $products[$i] = array('name' => $row, 'type' => 'product');
        }
        
        foreach( $services as $i => $row) {
            $services[$i] = array('name' => $row, 'type' => 'service');
        }

        // build new arrays of features slug:name
        //$amenities = $products = $services = array();
        if (!empty($amenities))
            $amenities = array_combine($amenitiesSlug, $amenities);
        if (!empty($products))
            $products = array_combine($productsSlug, $products);
        if (!empty($services))
            $services = array_combine($servicesSlug, $services);

        $features = array_merge($amenities, $products, $services);
      
      // debug($features);
        // grab 3 items at regular intervals in array
        $featureList = array();
        $numOfFeatures = sizeof($features);

        if ( $numOfFeatures >= $numFeatures ) {
            
            $step = intval( $numOfFeatures / $numFeatures );
            $counter = 0;
            foreach( $features as $key => $val ) {
                if ( ($counter % $step) == 0 ) {
                    $featureList[] = array('slug' => $key, 'name' => $val['name'], 'type' => $val['type']);
                }
                $counter++;

            }
            // trim down to 3 if too long
            $featureList = array_slice($featureList,0, $numFeatures);
        } else {
            foreach( $features as $key => $val ) {
                $featureList[] = array('slug' => $key, 'name' => $val['name'], 'type' => $val['type']);
            }
        }
     //debug($featureList);
        return($featureList);
    }


    /*
     * rating is float number (e.g. 0.67 or 67%)
     */
    function starRating( $rating = 0) {
        $ratingsText = array (
            1 => 'Not so great',
            'Quite good',
            'Good',
            'Great',
            'Excellent'
        );

        $html = '<div style="width: 86px; height: 17px;" class="star_rating" title="rating: '. ($rating * 100) .'%">';

        if ( $rating > 0) {
            $rating = ($rating / 0.2); // 0.2 is 1/5 of 1
        } else {
            $rating = 0;
        }

        $rating = round($rating);



        // calc 5 as 100%, 67% = x
        
        for ($i=1; $i <= 5; $i++) {
            if ( $rating == $i )
                $html .= '<input type="radio" name="rate_avg" value="' . $i . '"  checked="checked" disabled="disabled" title="' . $ratingsText[$i] . '" />';
            else {
                $html .= '<input type="radio" name="rate_avg" value="' . $i . '" disabled="disabled" title="' . $ratingsText[$i] . '" />';
            }
        }

        $html .= '</div>';

        return $html;
    }
	
	/*
	* gets payments for type of venue and returns list
	*/
	function paymentOptions($venue) {
		$fields = array( 
			'payment_creditcard' => 'Credit-cards', 
			'payment_bankcard' => 'Bank-cards',
			'payment_cash_only' => 'Cash-only',
			'payment_atm_onsite' => 'ATM on-site'
		);
		
		$payments = array();
		foreach( $fields as $field => $text ) {
			if ( isset($venue[$field]) && $venue[$field] == 1 )
				$payments[] = $text;
		}
		
		return ( $this->Text->toList($payments, ',') );
	}
	
	/*
	* price given as '$$$$' (number of dollar signs)
	* return as:  $$<em>$$</em>
	*/
	function priceRange( $price) {
		$maxLength = 4;
		$text = '';
		
		$length = strlen( trim($price));
		
		$text = $price . '<em>' . str_repeat('$', abs($maxLength - $length) ) . '<em>';
		
		return $text;
	}
	
	/*
	* 
	*/
	
	/*
	*             [venue_atmosphere1] => Casual
            [venue_atmosphere2] => Upscale
            [venue_dress_code] => Casual
	*/
	function atmosphere($venue) {
		
		$types = array();
		
		if ( isset( $venue['venue_atmosphere1'] ) && !empty($venue['venue_atmosphere1']) )
			$types[] = $venue['venue_atmosphere1'];
			
		if ( isset( $venue['venue_atmosphere2'] ) && !empty($venue['venue_atmosphere2']) )
			$types[] = $venue['venue_atmosphere2'];
						
		return ( $this->Text->toList($types, ',') );	
	}
	
	/*
	* returns list of amenities or features with link
	*/
	function listFeatures( $data, $type = 'service',  $params = null ) {
		$features = array();

		foreach( $data as $row) {
			$link = $this->Html->link( trim($row['name']), '/searches/' . $type .':'. $row['slug'] );
			$features[] = $link;
		}
		
		return ( $this->Text->toList($features, ',') ); 
		
	}

	
}
?>
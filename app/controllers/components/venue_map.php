<?php
class VenueMapComponent extends Object {
	
    // takes venue data from page
    function getJsonCords( $venueData)
    {
            $map = array('markers' => array() );

            foreach ( $venueData as $row) {
                    array_push( $map['markers'],
                            array(  'lat' =>  $row['Venue']['geo_latt'],
                                    'lng' => $row['Venue']['geo_long'],
                                    'label' => $row['Venue']['name'] . ' ' . $row['Venue']['subname'],
                                    'html' => "<div class=\"map_infobox\"><a href=\"/{$row['Venue']['slug']}\">{$row['Venue']['name']} {$row['Venue']['subname']}</a><br/>{$row['Venue']['address']}<br/>{$row['Venue']['phone']}</div>"
                                    )
                    );
            }

            //debug($map);
            $json = json_encode($map);
            //debug($json);
            return($json);
    }
	
}
?>

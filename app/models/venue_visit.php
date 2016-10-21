<?php
class VenueVisit extends AppModel {

    var $name = 'VenueVisit';
    var $actsAs  = array('Containable');

    var $validate = array(
            'venue_id' => array('numeric'),
            'visits' => array('numeric')
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
            'Venue' => array(
                    'className' => 'Venue',
                    'foreignKey' => 'venue_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
            )
    );

    /*
     * =======================================================================
     * Model Functions
     */

     /*
      * add a new visit to a venue
      */
    function addAVisit( $venueId) {

        // check if already in table
        $this->contain();
        $result = $this->findByVenueId( $venueId);

        if ($result) {
            $this->id = $result['VenueVisit']['id'];
            $visits = $result['VenueVisit']['visits'] + 1;
            $this->saveField('visits', $visits, true);
        }
        else {
           $data = array('VenueVisit' => array('visits' => 1, 'venue_id' => $venueId) );
           $this->save($data, true);
        }
        return true;
    }

    /*
     * get the number of visits for a venue
     */
     function getVisitCount( $venueId ){
         $result = $this->findByVenueId($venueId);

         if ($result)
            return( $result['VenueVisit']['visits']);
         else
            return 0;
     }
}
?>
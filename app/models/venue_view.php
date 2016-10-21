<?php
class VenueView extends AppModel {

	var $name = 'VenueView';
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

	var $hasMany = array(
		'VisitorView' => array(
			'className' => 'VisitorView',
			'foreignKey' => 'venue_view_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

     /*
      * add a new visit to a venue
      */
    function addAVisit( $venueId, $userIp) {
       // debug($userIp);

        // first check if venue viewed
        

        $data = $this->_checkIfUserAdded($venueId, $userIp);

        if ($data) {
            $data['VenueView']['visits']++;
            
            $this->saveAll($data);
        }
    }

    /*
     * get the number of visits for a venue
     */
     function getVisitCount( $venueId ){
         $this->contain();
         $result = $this->findByVenueId($venueId);
         if ($result)
            return( $result['VenueView']['visits']);
         else
            return 0;
     }

     function addARating( $venueId, $userIp, $rating) {
        $data = $this->_checkIfUserAdded($userIp);

        if ($data) {
            unset( $data['VenueView']['visits'] );
            $data['VenueRating']['votes']++;

            $this->saveAll($data);
        }
     }


     function _checkIfUserAdded($venueId, $userIp) {
        $data = array();

        $result = $this->findByVenueId( $venueId);
        if ($result) {
            $viewerResult = $this->VisitorView->findByViewerIp($userIp);

            if ( $viewerResult ) {
                //debug('viewer already recorded for this venue');
            } else {
                // venue found, but this user hasn't viewed before, add user
                $data = array(
                    'VenueView' => array( 'id' => $result['VenueView']['id'],
                                            'visits' => $result['VenueView']['visits'] ),
                    'VisitorView' => array( 0 => array( 'viewer_ip' => $userIp ) )
                );
               // $this->saveAll($data);
            }
        }else {
            // venue and user haven't been recorded before, save both
            $data = array(
                'VenueView' => array('venue_id' => $venueId, 'visits' => 0),
                'VisitorView' => array( 0 => array( 'viewer_ip' => $userIp ) )
            );

        }
        return($data);
     }

}
?>
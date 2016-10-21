<?php
class VenueRating extends AppModel {
	var $name = 'VenueRating';
	var $displayField = 'user_ip';
	var $validate = array(
		'venue_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_ip' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'liked' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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

        /* Functions */

        function updateVenueRating( $venueId, $userIp, $liked ){

            if ( $liked == -1 ) $liked = 0;
            
            $data = array('VenueRating' => array(
                'venue_id' => $venueId,
                'user_ip' => $userIp,
                'liked' => $liked
            ));

            $this->save($data, true);

            $result = $this->getVenueScore( $venueId);
            
            return( array( 'result' => true, 'votes' => $result['votes'], 'likes' => $result['likes'], 'score' => $result['score'] ) );

        }

        /*
         * returns true if user has already volted for this venue
         * to-do: clear out votes over a month old
         */
        function getUserAlreadyVoted($venueId, $userIp) {

            $count = $this->find('count', array('conditions' => array(
                'venue_id' => $venueId,
                'user_ip' => $userIp
            )));

            if ( $count > 0) {
                // check to see if vote for this venue was older than a month, clear if so
                $result = $this->find('first', array(
                    'contain' => false,
                    'conditions' => array(
                    'venue_id' => $venueId,
                    'user_ip' => $userIp,
                    'created <' => date('Y-m-d', strtotime("-1 week"))
                    ) )
                );
                if ( $result) {
                    $this->id = $result['VenueRating']['id'];
                    $this->saveField('user_ip', 0, false);
                    $count = 0; // user can vote again
                }
            }
            
            if ($count > 0)
                return true;
            else {
                return false;
            }
        }

        function getVenueScore( $venueId) {
            $total = $this->find('count', array('conditions' => array(
                'venue_id' => $venueId
            )) );

            if ( $total < 1)
               return ( array('votes' => 0, 'likes' => 0, 'score' => 0 ) );

            $totalLiked = $this->find('count', array('conditions' => array(
                'venue_id' => $venueId, 'liked' => 1
            )) );

            // avoid div by zero error
            if ($total == 0)
                $score = 1;
            else
                $score = $totalLiked / $total;

            return ( array('votes' => $total, 'likes' => $totalLiked, 'score' => $score ) );
        }
}
?>
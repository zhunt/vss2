<?php
class VenueScore extends AppModel {
	var $name = 'VenueScore';
	var $displayField = 'score';
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
         * Functions
         */

        function updateScore($venueId, $score, $votes) {
            $result = $this->find('first', array('conditions' => array('venue_id' => $venueId), 'contain' => false));
//debug($result);exit;
            if ($result) {
                $data = array('id' => $result['VenueScore']['id'], 'venue_id' => $venueId, 'score' => $score, 'votes' => $votes );
            } else {
                $data = array( 'venue_id' => $venueId, 'score' => $score, 'votes' => 1);
            }
debug($data);
            $this->save($data, true);
        }
}
?>
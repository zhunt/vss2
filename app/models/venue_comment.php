<?php
class VenueComment extends AppModel {

	var $name = 'VenueComment';
        var $actsAs  = array('Containable');
        
	var $validate = array(
		'venue_id' => array('numeric'),
		'author' => array('notempty'),
                'comment' => array('notempty'),
		'flag_spam' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Venue' => array('className' => 'Venue',
								'foreignKey' => 'venue_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);


        /*
         * Model functions
         */

    function getRecentComments( $venueId, $num = 5, $options = array() ) {
        $this->contain();
        $result = $this->find('all', array( 'fields' => array('author', 'comment', 'created'),
                                            'conditions' => array('venue_id' => $venueId, 'flag_published' => 1),
                                            'order' => 'created DESC',
                                            'limit' => $num
                                            ));



        return($result);
    }

    /*
     * gets newest comments for all venues
     * used on home landing page
     */
     function getNewestComments( $num, $options = array() ) {
        $this->contain( array( 'Venue' => array('name', 'slug') ) );
        $result = $this->find('all', array( 'fields' => array('author', 'comment', 'created'),
                                            'conditions' => array( 'VenueComment.flag_published' => 1, 'Venue.flag_published' => 1),
                                            'order' => 'created DESC',
                                            'limit' => $num
                                            ));
        return($result);
     }
}
?>
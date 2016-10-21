<?php
class TagsVenue extends AppModel {

	var $name = 'TagsVenue';
        var $actsAs  = array('Containable' );
        
	var $validate = array(
		'venue_id' => array('numeric'),
		'tag_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'venue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

        /*
         * -------------------------------------------------------------------
         * Model Functions
         */

    /*
     * update TagsVenue
     * returns id of new record or id of exiting record
     */
    function updateTagsVenue( $venueId, $tagId, $weight) {

        $result = $this->find('first', array( 'conditions' =>
                                        array( 'TagsVenue.tag_id' => $tagId,
                                                'TagsVenue.venue_id' => $venueId )
                                        ) );

        if ($result) {
            $result['TagsVenue']['weight'] = $weight;
            $this->save($result);
            return($result['TagsVenue']['id']);
        } else {
            $this->create();
            $data = array('TagsVenue' =>
                            array( 'tag_id' => $tagId, 'venue_id' => $venueId,
                                    'weight' => $weight) );
            $this->save($data);
            return($this->id);

        }



    }


    /*
     * delete a TagVenue row
     */
    function deleteTag( $tagsVenueId, $tagId ) {

       // debug( $tagsVenueId, $tagId );
        $result = $this->findById($tagsVenueId);

        $this->del( $result['TagsVenue']['id'], false);

        // now check if the tag is used by other venues, delete if not
        $count = $this->find('count', array('conditions' => 
                                array( 'tag_id' => $tagId ) ) );
        if ($count < 1 ) {
            $this->Tag->del($tagId, false);
        }
        
    }

}
?>
<?php
class Tag extends AppModel {

	var $name = 'Tag';
        var $actsAs  = array('Containable' );
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
		'Venue' => array(
			'className' => 'Venue',
			'joinTable' => 'tags_venues',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'venue_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);


    /*
     * -------------------------------------------------------------------
     * Model Functions
     */

    /*
     * returns either a) the new tag's id if saved or 2) the exiting tag's id
     */
    function updateTag($tagName) {

       // debug( $tagName);
       // $newTagName = $stemmer->stem($tagName);

        if (empty($tagName) )
            return false;
            
        $result = $this->findByName($tagName);

        if ($result)
            return($result['Tag']['id']);
        else {
            $this->create();
            $this->saveField('name', $tagName);
            return($this->id);
        }
       
    }

}
?>
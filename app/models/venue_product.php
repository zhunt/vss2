<?php
class VenueProduct extends AppModel {

	var $name = 'VenueProduct';
        var $actsAs = array('Sluggable', 'Containable');
        
	var $validate = array(
            'name' => array('notempty'),
            'slug' => array('rule' => 'notempty', 'on' => 'update'),
            'venue_type_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'VenueType' => array(
			'className' => 'VenueType',
			'foreignKey' => 'venue_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Venue' => array(
			'className' => 'Venue',
			'joinTable' => 'venues_venue_products',
			'foreignKey' => 'venue_product_id',
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
     * returns Id of product, adding product to table if nessassary
     */
    function updateProduct($name, $venueId, $venueTypeId = null ) {
        if ( empty($name)) return false;

        $this->Containable = false;
        $result = $this->findByName($name);

       

        if (!$result) {
            $data = array(
                    'VenueProduct' => array('name' => $name, 'venue_type_id' => $venueTypeId),
                    'Venue' => array('Venue' => array($venueId) )
                    );
        }else { // product already in list
            $id = $result['VenueProduct']['id'];
            // get list of venues with this product already
            $venues = $this->VenuesVenueProduct->find('list', array(
                                'fields' => array('venue_id'),
                                'conditions' => array( 'venue_product_id' => $id ) ) );
            $venues[] = $venueId;
            sort($venues);

            $data = array(
                    'VenueProduct' => array( 'id' => $id, 'name' => $name, 'venue_type_id' => $venueTypeId),
                    'Venue' => array('Venue' => (array)$venues )
                    );
        }
            $this->create();
            $this->save( $data);
            $id = $this->id;
           
        return($id);
    }

    /*
     * returns Id of subtype, adding venue subtype to table if nessassary
     */
    function updateVenueProduct($name, $venueTypeId = 0) {
        if ( empty($name)) return false;

        $this->Containable = false;
        $result = $this->findByName($name);

        if (!$result) {
            $this->create();
            $data = array('VenueProduct' => array('name' => $name,
                                                    'venue_type_id' => $venueTypeId) );
            //$this->containable = false;
            $this->save($data);
            $id = $this->id;
        } else {
            $id = $result['VenueProduct']['id'];
        }

        return($id);
    }

}
?>
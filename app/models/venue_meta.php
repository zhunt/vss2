<?php
class VenueMeta extends AppModel {

	var $name = 'VenueMeta';
	var $validate = array(
		'venue_id' => array('numeric'),
		'meta_key' => array('notempty')
	);

//        var $hasMany = array('VenueDetail' => array(
//        'foreignKey' => 'venue_detail_id'
//        ));

        /*
         * un-serializes the meta_value field and adds contained fields to
         * array
         */
//        function afterFind($results){
//            parent::afterFind($results);
//
//            foreach ($results as $key => $val) {
//                if ( isset($val['VenueMeta']['meta_value']) ) {
//                    $unserializedData = unserialize($val['VenueMeta']['meta_value']);
//                    $results[$key]['VenueMeta'] =
//                        array_merge( $results[$key]['VenueMeta'], $unserializedData );
//
//                    //unset( $results[$key]['VenueMeta']['meta_value']);
//                }
//
//            }
//         // debug($results);exit;
//            return($results);
//        }
        
        /*
         * takes fields that are not in actual table and serializes them into
         * meta_value field
         */
        /*
        function beforeSave() {
            parent::beforeSave();
            //foreach( $this->data['VenueMeta'] as $i => $row ) {
                debug($this->data['VenueMeta']);

                $serializedData = $this->data['VenueMeta'];
                //debug($row);
                unset($serializedData['id']);
                unset($serializedData['venue_id']);
                unset($serializedData['meta_key']);
                $this->data['VenueMeta']['meta_value'] = serialize($serializedData);
            //}

            //debug($this->data['VenueMeta']);
            //exit;
            return true;
        }
        */

//        public function beforeSave() {
//             foreach($this->data[$this->alias] as $field => $value) {
//                if($field !== 'venue_id') {
//                  $this->data[$this->alias]['meta_key'] = $field;
//                  $this->data[$this->alias]['meta_value'] = $value;
//                }
//             }
//             return true;
//          }
        
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

}

/*
    [VenueMeta] => Array
        (
            [0] => Array
                (
                    [heading] => -143.66830642823913
                    [pitch] => 10.35
                    [zoom] => 2
                    [lat] => 49.279192
                    [lng] => -123.122902
                    [id] => 41
                    [venue_id] => 41
                    [meta_key] => streetview
                )

        )


 */
?>
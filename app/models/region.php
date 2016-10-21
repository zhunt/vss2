<?php
class Region extends AppModel {

	var $name = 'Region';
        var $actsAs = array('Sluggable');
        
	var $validate = array(
		'name' => array('notempty'),
		'slug' => array('rule' => 'notempty', 'on' => 'update'),
		'province_id' => array('numeric'),
		'administrative_area_level_2' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Province' => array(
			'className' => 'Province',
			'foreignKey' => 'province_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'region_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'region_id',
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
     * returns Id of city, adding city to table if nessassary
     * checking is done using Google's administrative_area_level_2 name
     */
    function updateRegion($region, $provinceId) {
        if ( empty($region)) return false;

        $this->Containable = false;
        $result = $this->findByAdministrativeAreaLevel_2($region);
        //debug($result);
        if (!$result) {
            $this->create();
            $data = array('Region' => array('name' => $region,
                                            'province_id' => $provinceId,
                                            'administrative_area_level_2' => $region) );
            $this->save($data);
            $regionId = $this->id;
        } else {
            $regionId = $result['Region']['id'];
        }
        return($regionId);
    }

}
?>
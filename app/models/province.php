<?php
class Province extends AppModel {

	var $name = 'Province';
        var $actsAs = array('Sluggable');
	var $validate = array(
		'name' => array('notempty'),
		'slug' => array('rule' => 'notempty', 'on' => 'update'),
		'administrative_area_level_1' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'province_id',
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
     * returns Id of province, adding province to table if nessassary
     * checking is done using Google's administrative_area_level_1 name
     */
    function updateProvince($province) {
        if ( empty($province)) return false;

        $this->Containable = false;
        $result = $this->findByAdministrativeAreaLevel_1($province);
        //debug($result);
        if (!$result) {
            $this->create();
            $data = array('Province' => array('name' => $province, 'administrative_area_level_1' => $province) );
            $this->save($data);
            $provinceId = $this->id;
        } else {
            $provinceId = $result['Province']['id'];
        }
        //debug($provinceId);exit;
        return($provinceId);
    }

}
?>
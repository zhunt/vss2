<?php
class CityRegion extends AppModel {

    var $name = 'CityRegion';
    var $actsAs = array('Sluggable', 'Containable');

    var $validate = array(
        'name' => array( 'rule' => array('minLength', 3) ),
        'slug' => array( 'rule' => 'notempty', 'on' => 'update' ),
        'city_id' => array('numeric')
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'City' => array(
                'className' => 'City',
                'foreignKey' => 'city_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
        )
    );

    var $hasMany = array(
        'Venue' => array(
                'className' => 'Venue',
                'foreignKey' => 'city_region_id',
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
     * checking is done using Google's locality name
     */
    function updateCityRegion($cityRegion, $cityId = null) {
        if ( empty($cityRegion)) return false;

        $this->Containable = false;
        $cityRegion = trim($cityRegion);
        $result = $this->findByName($cityRegion);

        if (!$result) {
            $this->create();
            $data = array('CityRegion' => array('name' => $cityRegion,
                                            'city_id' => $cityId
                                           ) );
            $this->save($data);
            $cityId = $this->id;
        } else {
            $cityId = $result['CityRegion']['id'];
        }
        return($cityId);
    }

}
?>
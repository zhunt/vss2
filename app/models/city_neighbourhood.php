<?php
class CityNeighbourhood extends AppModel {

    var $name = 'CityNeighbourhood';
    var $actsAs = array('Sluggable', 'Containable');
    
    var $validate = array(
        'name' => array('notempty'),
        'slug' => array('rule' => 'notempty', 'on' => 'update'),
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

    var $hasOne = array(
        'Venue' => array(
                'className' => 'Venue',
                'foreignKey' => 'city_neighbourhood_id',
                'dependent' => false,
                'conditions' => '',
                'fields' => '',
                'order' => ''
        )
    );

    var $hasMany = array(
        'Venue' => array(
                'className' => 'Venue',
                'foreignKey' => 'city_neighbourhood_id',
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
     */
    function updateNeighbourhood($neighbourhood, $cityId = 0) {
        if ( empty($neighbourhood)) return false;
        //debug($neighbourhood);
        $this->Containable = false;
        $result = $this->findByName($neighbourhood);

        if (!$result) {
            $this->create();
            $data = array('CityNeighbourhood' => array('name' => $neighbourhood,
                                                    'city_id' => $cityId) );
            //$this->containable = false;
            $this->save( $data);
            $id = $this->id;
        } else {
            $id = $result['CityNeighbourhood']['id'];
        }

        return($id);
    }

}
?>
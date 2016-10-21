<?php
class Intersection extends AppModel {

    var $name = 'Intersection';
    var $actsAs = array('Sluggable');

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

    /*
     * returns Id of city, adding city to table if nessassary
     */
    function updateIntersection($intersection, $cityId = 0) {
        if ( empty($intersection)) return false;
        //debug($intersection);
        $this->Containable = false;
        $result = $this->findByName($intersection);
        
        if (!$result) {
            $this->create();
            $data = array('Intersection' => array('name' => $intersection,
                                                    'city_id' => $cityId) );
            //$this->containable = false;
            $this->save( $data);
            $id = $this->id;
        } else {
            $id = $result['Intersection']['id'];
        }

        return($id);
    }

}
?>
<?php
class City extends AppModel {

    var $name = 'City';
    var $actsAs = array('Sluggable', 'Containable');
    
    var $validate = array(
        'name' => array( 'rule' => array('minLength', 3) ),
        'slug' => array( 'rule' => 'notempty', 'on' => 'update' )
    );
   

    //The Associations below have been created with all possible keys,
    // those that are not needed can be removed
    var $hasMany = array(
        'CityNeighbourhood' => array(
            'className' => 'CityNeighbourhood',
            'foreignKey' => 'city_id',
            'dependent' => false,
           
        ),
        'CityRegion' => array(
            'className' => 'CityRegion',
            'foreignKey' => 'city_id',
            'dependent' => false,
            
        ),
        'Venue' => array(
            'className' => 'Venue',
            'foreignKey' => 'city_id',
            'dependent' => false   
        ),
        'Intersection' => array(
            'className' => 'Intersection',
            'foreignKey' => 'city_id',
            'dependent' => false,

        )
    );

    var $belongsTo = array(
        'Region' => array('className' => 'Region')
    );

    /*
     * returns Id of city, adding city to table if nessassary
     * checking is done using Google's locality name
     */
    function updateCity($city, $regionId) {
        if ( empty($city)) return false;
        
        $this->Containable = false;
        $result = $this->findByLocality($city);

        if (!$result) {
            $this->create();
            $data = array('City' => array('name' => $city,
                                            'region_id' => $regionId ,
                                            'locality' => $city) );
            $this->save($data);
            $cityId = $this->id;
        } else {
            $cityId = $result['City']['id'];
        }
        return($cityId);
    }

}
?>
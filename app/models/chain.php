<?php
class Chain extends AppModel {

    var $name = 'Chain';
    var $actsAs = array('Sluggable', 'Containable');
    
    var $validate = array(
        'name' => array( 'rule' => array('minLength', '3') ),
        'slug' => array( 'rule' => 'notempty', 'on' => 'update' )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $hasMany = array(
        'Venue' => array(
            'className' => 'Venue',
            'foreignKey' => 'chain_id',
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
     * returns Id of chain, adding venue chain to table if nessassary
     */
    function updateChain($chain) {
        if ( empty($chain)) return false;
        //debug($neighbourhood);
        $this->Containable = false;
        $result = $this->findByName($chain);

        if (!$result) {
            $this->create();
            $data = array('Chain' => array('name' => $chain ) );
            //$this->containable = false;
            $this->save( $data);
            $id = $this->id;
        } else {
            $id = $result['Chain']['id'];
        }

        return($id);
    }


}
?>
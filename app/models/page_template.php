<?php
class PageTemplate extends AppModel {

    var $name = 'PageTemplate';
    var $validate = array(
        'name' => array('notempty')
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $hasMany = array(
        'VssPage' => array(
                'className' => 'VssPage',
                'foreignKey' => 'page_template_id',
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

}
?>
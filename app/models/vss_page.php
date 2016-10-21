<?php
class VssPage extends AppModel {

	var $name = 'VssPage';
        var $actsAs = array('Sluggable', 'Containable');

	var $validate = array(
		'name' => array('notempty'),
		'slug' => array('notempty'),
		//'page_template_id' => array('numeric'),
		//'venue_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'PageTemplate' => array(
			'className' => 'PageTemplate',
			'foreignKey' => 'page_template_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'venue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
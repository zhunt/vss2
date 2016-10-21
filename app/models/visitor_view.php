<?php
class VisitorView extends AppModel {

	var $name = 'VisitorView';
	var $validate = array(
		//'venue_rating_id' => array('numeric'),
		//'venue_view_id' => array('numeric'),
		//'viewer_ip' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'VenueRating' => array(
			'className' => 'VenueRating',
			'foreignKey' => 'venue_rating_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'VenueView' => array(
			'className' => 'VenueView',
			'foreignKey' => 'venue_view_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
<?php
class WpPost extends AppModel {
	var $name = 'WpPost';
	var $primaryKey = 'ID';
	var $displayField = 'post_title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'WpComment' => array(
			'className' => 'WpComment',
			'foreignKey' => 'comment_post_ID',
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
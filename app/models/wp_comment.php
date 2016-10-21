<?php
class WpComment extends AppModel {
	var $name = 'WpComment';
	var $primaryKey = 'comment_ID';
	var $displayField = 'comment_author';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'WpPost' => array(
			'className' => 'WpPost',
			'foreignKey' => 'comment_post_ID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>
<?php
class Comment extends AppModel {

	var $name = 'Comment';
	var $validate = array(
		'venue_id' => array('numeric'),
		'author' => array(
                                'rule1' => array('rule' => array('minLength', 3),
                                                    'message' => 'More than 3 characters' ),
                                'rule2' => array('rule' => array('maxLength', 30),
                                                    'message' => 'Less than 30 characters' ),
                    ),
		'author_email' => array( 'rule' => 'email', 'message' => 'An e-mail is required' ),
		//'author_url' => array('notempty'),
		'author_ip' => array('notempty'),
		'comment_agent' => array('notempty'),
                'comment' =>  array(
                                'rule1' => array('rule' => array('minLength', 3),
                                                    'message' => 'More than 3 characters' ),
                                'rule2' => array('rule' => array('maxLength', 2000),
                                                    'message' => 'Less than 2000 characters'),
                    ),
		//'comment_parent_id' => array('numeric'),
		'karma' => array('numeric'),
		'comment_status_id' => array('numeric'),

                EMAIL_CHECKFIELD_1 => array(
                    'rule' => array('equalTo', EMAIL_CHECK_DEMAMBO1 ),
                    'required' => true,
                    'message' => 'error on mambo 1 field'
                ),
                EMAIL_CHECKFIELD_2 => array(
                    'rule' => array('equalTo', EMAIL_CHECK_DEMAMBO2 ),
                    'required' => true,
                    'message' => 'error on mambo 2 field'
                ),

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'venue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CommentStatus' => array(
			'className' => 'CommentStatus',
			'foreignKey' => 'comment_status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
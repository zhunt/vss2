<?php
class User extends AppModel {

	var $name = 'User';
	var $validate = array(
		'email' => array(
                    'email_rule1' =>  array(
                        'rule' => 'email',
                        'required' => true,
                        'allowEmpty' => false,
                        'message' => 'Must be an e-mail address.'
                    ),
                    'email_rule2' => array(
                        'rule' => 'isUnique',
                            'required' =>  true,
                            'allowEmpty' => false,
                            'on' => 'create',
                            'message' => 'This address already in use.'
                        ),
                    'email_rule3' => array(
                        'rule' => array('minLength',6),
                        'message' => 'Email must be at least 3 characters long.'
                    )
                ),
		'password' => array(
                    'password_rule1' => array(
                        'rule' => 'notEmpty',
                        'required' =>  true,
                        'allowEmpty' => false,
                        'message' => 'A password is required.'
                    ),
                    'password_rule2' => array(
                        'rule' => array('minLength',6),
                        'required' =>  true,
                        'allowEmpty' => false,
                        'message' => 'Password must be at least 6 characters long.'
                    )
                ),
		'flag_active' => array('numeric'),
		'role' => array('notempty')
	);

}
?>
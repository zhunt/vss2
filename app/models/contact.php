<?php
class Contact extends AppModel {

	var $name = 'Contact';
        var $useTable = false;

        var $_schema = array(
            'author_ip'  => array('type'=>'string', 'length' => 100),
            'comment_agent' => array('type'=>'string', 'length' => 20),
            'name'	=> array('type'=>'string', 'length' => 255),
            'email'	=> array('type'=>'string', 'length' => 255),
            'comment' => array('type'=>'text'),
            'demambo1' => array('type'=>'string', 'length' => 20),
            'demambo2' => array('type'=>'string', 'length' => 20),
        );

	var $validate = array(
            'author_ip' => array('notempty'),
            'comment_agent' => array('notempty'),
            'comment' =>  array(
                            'rule1' => array('rule' => array('minLength', 3),
                                                'message' => 'More than 3 characters' ),
                            'rule2' => array('rule' => array('maxLength', 500),
                                                'message' => 'Less than 500 characters'),
                ),
            'name' => array('rule' => array('between',3,50), 'allowEmpty' => true ),
            
            'email' => array('rule' => 'email', 'allowEmpty' => true ),

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
}

?>

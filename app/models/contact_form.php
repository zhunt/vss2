<?php
class ContactForm extends AppModel {

    var $useTable = false;

    var $_schema = array(
        'name'		=>array('type'=>'string', 'length' => 100),
        'email'		=>array('type'=>'string', 'length' => 255),
        'comment'	=>array('type'=>'text')
    );

    var $validate = array(
        'name' => array(
            'rule'=>array('minLength', 3) ,
            'required' => true,
            'message'=>'Name is required' ),
        'email' => array(
            'rule'=> 'email',
            'required' => true,
            'message'=>'Must be a valid email address' ),
        'comment' => array(
            'rule'=>array('minLength', 1) ,
            'required' => true,
            'message'=>'Please enter your comment or question' )
    );


}
?>
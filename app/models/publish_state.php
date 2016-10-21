<?php
class PublishState extends AppModel {

	var $name = 'PublishState';
	var $validate = array(
		'name' => array('notempty')
	);

}
?>
<?php
class CompstoreProduct extends AppModel {

	var $name = 'CompstoreProduct';
	var $validate = array(
		'name' => array('notempty')
	);

}
?>
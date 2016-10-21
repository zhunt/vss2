<?php
class VssOption extends AppModel {

	var $name = 'VssOption';
	var $validate = array(
		'option_key' => array('notempty')
	);

}
?>
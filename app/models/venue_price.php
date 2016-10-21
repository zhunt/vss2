<?php
class VenuePrice extends AppModel {

	var $name = 'VenuePrice';
    var $actsAs = array('Containable', 'SdSlugger' );
    
	var $validate = array(
		'name' => array('notempty'),
		'slug' => array('notempty')
	);

}
?>
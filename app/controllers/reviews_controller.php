<?php
class ReviewsController extends AppController {

	var $name = 'Reviews';
        var $uses = array();
	//var $helpers = array('Html', 'Form', 'Text', 'Time');
        //var $components = array('Utilities', 'Emailer');

    function beforeFilter() { //debug('here 1');

        $this->Auth->allow('*');

    }


        function all_internet() {
            $this->autoLayout = false;
            $this->autoRender = false;
            $this->redirect('http://www.yyztech.ca/searches/venue_type:cafe/venue_subtype:internet-cafe', 404, true);
        }
}
?>
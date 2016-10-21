<?php
class ArticlesController extends AppController {

	var $name = 'Articles';
        var $uses = array();
	//var $helpers = array('Html', 'Form', 'Text', 'Time');
        //var $components = array('Utilities', 'Emailer');

    function beforeFilter() { //debug('here 1');

        $this->Auth->allow('*');

    }


        function view() {

            $this->autoLayout = false;
            $this->autoRender = false;
            //print_r($this->params);
            switch ( $this->params['pass'][0]) {
                case 'review_prototype_and_scriptaculous':
                    $newUrl = 'http://www.yyztech.ca/posts/books/review_prototype_and_scriptaculous/';
                    break;
                default:
                    //exit;
            }
            //echo($newUrl);
            $this->redirect($newUrl, 404, true);

           
          

            
        }
}
?>

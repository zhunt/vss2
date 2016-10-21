<?php
class ContactsController extends AppController {

	var $name = 'Contacts';
	var $helpers = array('Html', 'Form', 'Text', 'Time');
        var $components = array('Utilities', 'Emailer');

        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('add', 'add_listing', 'contact', 'advertise');
        }

        // not used anymore
	function add() {
            
            if (!empty($this->data)) {
                $this->Contact->create();

                $this->data['Contact']['author_ip'] = $this->Utilities->getRealIpAddr();
                $this->data['Contact']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                
                $this->Contact->set( $this->data );
                if ($this->Contact->validates()) {
                    $this->Session->setFlash('Thank you, Your comment has been sent.');

                    $name = $this->data['Contact']['name'];
                    $email = $this->data['Contact']['email'];
                    $comment = $this->data['Contact']['comment'];

                    $metaData = array(
                            'author_ip' => $this->data['Contact']['author_ip'],
                            'user_agent' => $this->data['Contact']['user_agent']
                            );
                    
                    $this->Emailer->sendContact( $name, $email, $comment, $metaData );
                    
                    $this->redirect( $this->referer() );

                } else {
                    debug($this->Contact->invalidFields() );
                    exit;
                    $this->Session->setFlash('The comment could not be sent. Please, try again.');
                    $this->redirect( $this->referer() );
                }
            }
            
	}

        
        function add_listing() {
            
            if (!empty($this->data)) { //debug($this->data); exit;
                $this->Contact->create();

                // take error report and make into a comment
                foreach ($this->data['Contact'] as $key => $row) {
                    $report[] = "{$key}: {$row}";
                }
                unset($report[ Configure::read('checkfield_1') ]);
                unset($report[ Configure::read('checkfield_2') ]);

                $this->data['Contact']['author_ip'] = $this->Utilities->getRealIpAddr();
                $this->data['Contact']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $this->data['Contact']['karma'] = 1;
                $this->data['Contact']['comment_status_id'] = 0;


                $this->data['Contact']['description'] = implode("\n", $report);
                // ---

                $this->Contact->set( $this->data );
                if ($this->Contact->validates()) {
                    $this->Session->setFlash('Thank you, We will review your venue within 2-3 days.');

                    $name = $this->data['Contact']['name'];
                    $email = $this->data['Contact']['email'];
                    $comment = $this->data['Contact']['description'];

                    $metaData = array(
                            'author_ip' => $this->data['Contact']['author_ip'],
                            'user_agent' => $this->data['Contact']['user_agent']
                            );

                    $this->Emailer->sendContact( $name, $email, $comment, $metaData );

                    $this->redirect( $this->referer() );

                } else {
                    debug($this->Contact->invalidFields() );
                    exit;
                    $this->Session->setFlash('The listing comment could not be sent. Please, try again.');
                    $this->redirect( $this->referer() );
                }
            }
	}

        /*
         * About YYZ , contact
         */
        function contact() {

            if (!empty($this->data)) {
                $this->Contact->create();

                $this->data['Contact']['author_ip'] = $this->Utilities->getRealIpAddr();
                $this->data['Contact']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

                $this->Contact->set( $this->data );
                if ($this->Contact->validates()) {
                    $this->Session->setFlash('Thank you, Your comment has been sent.');

                    $name = $this->data['Contact']['author'];
                    $email = $this->data['Contact']['author_email'];
                    $comment = $this->data['Contact']['comment'];

                    $metaData = array(
                            'author_ip' => $this->data['Contact']['author_ip'],
                            'user_agent' => $this->data['Contact']['user_agent']
                            );

                    $this->Emailer->sendContact( $name, $email, $comment, $metaData );

                    $this->redirect( $this->referer() );

                } else {
                    debug($this->Contact->invalidFields() );
                    exit;
                    $this->Session->setFlash('The comment could not be sent. Please, try again.');
                    $this->redirect( $this->referer() );
                }
            }

            // new venues 7
            $newVenues =
                ClassRegistry::init('Venue')->find('all', array(
                    'conditions' => array('Venue.publish_state_id' => Configure::read('Venue.published') ),
                    'order' => 'Venue.created DESC',
                    //'fields' => array('Venue.name', 'Venue.slug'),
                    'contain' => array('VenueType.name', 'VenueSubtype.name', 'VenueField' ),
                    'limit' => 4
                ) );
            $this->set( compact('newVenues'));
        }
		
		function advertise(){            
			/*if (!empty($this->data)) {
                $this->Contact->create();

                $this->data['Contact']['author_ip'] = $this->Utilities->getRealIpAddr();
                $this->data['Contact']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

                $this->Contact->set( $this->data );
                if ($this->Contact->validates()) {
                    $this->Session->setFlash('Thank you, Your comment has been sent.');

                    $name = $this->data['Contact']['author'];
                    $email = $this->data['Contact']['author_email'];
                    $comment = $this->data['Contact']['comment'];

                    $metaData = array(
                            'author_ip' => $this->data['Contact']['author_ip'],
                            'user_agent' => $this->data['Contact']['user_agent']
                            );

                    $this->Emailer->sendContact( $name, $email, $comment, $metaData );

                    $this->redirect( $this->referer() );

                } else {
                    debug($this->Contact->invalidFields() );
                    exit;
                    $this->Session->setFlash('The comment could not be sent. Please, try again.');
                    $this->redirect( $this->referer() );
                }
            } */

            // new venues 7
            $newVenues =
                ClassRegistry::init('Venue')->find('all', array(
                    'conditions' => array('Venue.publish_state_id' => Configure::read('Venue.published') ),
                    'order' => 'Venue.created DESC',
                    //'fields' => array('Venue.name', 'Venue.slug'),
                    'contain' => array('VenueType.name', 'VenueSubtype.name', 'VenueField' ),
                    'limit' => 4
                ) );
            $this->set( compact('newVenues'));
        }

}?>
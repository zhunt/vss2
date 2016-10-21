<?php
class VenueCommentsController extends AppController {

    var $name = 'VenueComments';
    var $helpers = array('Html', 'Form', 'Text', 'Time');
    var $components = array('RequestHandler', 'SwiftMailer');

    function beforeRender() {
		// change layout for admin section
		if (isset($this->params[Configure::read('Routing.admin')]) && !$this->RequestHandler->isAjax() )
			$this->layout = 'admin_default';
    }

        function ajax_add() {
            $this->layout = 'ajax';
            App::import('Sanitize');
            $this->loadModel('Venue');
            
            if (!empty($this->data)) {
                $this->VenueComment->create();

                if ($this->RequestHandler->isAjax()) {

                    $this->data = Sanitize::clean($this->data, array('encode' => false));
                    $venueId = (int)$this->data['VenueComment']['venue_id'];

                    if ($this->VenueComment->save($this->data)) {
                        $commentId = $this->VenueComment->id;

                        // get the venue name and send a email to publish it
                        $this->Venue->contain();
                        $result = $this->Venue->findById($venueId);
                        if ($result) {
                            $venueName = $result['Venue']['name'] . ' ' . $result['Venue']['subname'];

                            $this->mail( $venueName, $commentId, $this->data);
                            $venueComments = $this->VenueComment->getRecentComments( $venueId);
                        }
                    }

                    $this->set('venueComments', $venueComments);

                    $this->render('index');
                }
            }
        }


        function index($venueId) {
            $venueComments = $this->VenueComment->getRecentComments( $venueId);
            $this->set('comments', $venueComments);
        }

        /*
         * sends error report e-mail
         */
        function mail( $venueName, $commentId, $data) {
            $this->SwiftMailer->smtpType = 'tls';
            $this->SwiftMailer->smtpHost = 'smtp.gmail.com';
            $this->SwiftMailer->smtpPort = 465;
            $this->SwiftMailer->smtpUsername = Configure::read('smtp.username');
            $this->SwiftMailer->smtpPassword = Configure::read('smtp.password');

            $this->SwiftMailer->sendAs = 'text';
            $this->SwiftMailer->from = Configure::read('smtp.username');
            $this->SwiftMailer->fromName = 'Venue Error Report';
            $this->SwiftMailer->to = Configure::read('smtp.username');
            //set variables to template as usual
            $this->set('message', 'My message');

            $this->set('venue', $venueName);
            $this->set('commentId', $commentId );
            $this->set('comment', $data['VenueComment']['comment'] );
            
            try {
                if(!$this->SwiftMailer->send('comment_sent', 'Comment sent for ' . $venueName)) {
                    $this->log("Error sending email");
                }
            }
            catch(Exception $e) {
                  $this->log("Failed to send email: ".$e->getMessage());
            }
            //$this->redirect($this->referer(), null, true);
        }

	/*
         * ==================================================================
         */

	function admin_index() {
		$this->VenueComment->recursive = 0;
		$this->set('venueComments', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueComment.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueComment', $this->VenueComment->read(null, $id));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueComment', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueComment->save($this->data)) {
				$this->Session->setFlash(__('The VenueComment has been saved', true));
				$cleared = clearCache();
                                $this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueComment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueComment->read(null, $id);
		}
		$venues = $this->VenueComment->Venue->find('list');
		$this->set(compact('venues'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueComment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueComment->del($id)) {
			$this->Session->setFlash(__('VenueComment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
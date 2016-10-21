<?php
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Html', 'Form', 'Text', 'Time');
        var $components = array('Utilities', 'Emailer');

        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('index', 'add', 'add_error_report');
        }

        function index() {

            $this->paginate = array( 'contain' =>
                    array('Venue' => array('name', 'slug', 'City.name', 'address',
                                        'publish_state_id = ' . Configure::read('Venue.published') ) ),
                'conditions' => array('Comment.comment_status_id = ' . Configure::read( 'Comment.published' ),
                                        'Comment.flag_front_page' => true),
               // 'fields' => array('author', 'comment', 'created'),
                
                );
            $comments = $this->paginate();
            if (isset($this->params['requested'])) {
               // debug($comments);exit;
                return $comments;
            } else {
                $this->set('comments', $posts);
            }
	}

	function add() {           
            App::import('Sanitize');

            if (!empty($this->data)) {
               
                $this->data = Sanitize::clean($this->data, array( 'remove_html' => true ));
              
                $this->Comment->create();

                $this->data['Comment']['author_ip'] = $this->Utilities->getRealIpAddr();
                $this->data['Comment']['comment_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $this->data['Comment']['karma'] = 1;
                $this->data['Comment']['comment_status_id'] = 0;

                // set-up score
                if ( isset($this->data['Comment']['vote']) )
                    $vote = intval($this->data['Comment']['vote']);
                else
                    $vote = 0;
               // debug($vote);

                $averageRating = ClassRegistry::init('VenueRating')->updateVenueRating( $this->data['Comment']['venue_id'], $this->Utilities->getRealIpAddr(), $vote);
                $this->data['Comment']['rating'] = $vote;
                //debug($averageRating);
                
                //exit;


                if ($this->Comment->save($this->data)) {
                    
                    $this->Emailer->commentSent( $this->data['Comment']['venue_id'], $this->Comment->id );

//                    $response = array('msg' => '
//                                <div class="ui-widget">
//                                <div style="margin-top: 20px; padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all">
//					<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
//					Thank you, Your comment should appear shortly.</p>
//				</div>
//                                </div>
//                                ');
                    $this->Session->setFlash('Comment sent for moderation and should appear shortly.');
                    $this->redirect( '/' . $this->data['Comment']['slug']);

                } else {
                    
                    //debug($this->data); exit;
                    $this->Session->setFlash(__('The Comment could not be saved. Please, try again.', true));
                    $this->redirect( '/' . $this->data['Comment']['slug']);
                    /*
                    $response = array('msg' => '
                                <div class="ui-widget">
				<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span>
					Message counld not be sent, please try again later.</p>
				</div>
                                </div>
                                ');
*/

                }

                //echo json_encode($response);
                //exit;
            }




            $venueId = intval($this->params['named']['venue']);
            $venue = $this->Comment->Venue->findById($venueId);

            if (!$venue)
                exit;

            $venueName = $venue['Venue']['full_name'];

            
           // $venues = $this->Comment->Venue->find('list');
            $commentStatuses = $this->Comment->CommentStatus->find('list');
            $this->set(compact('venues', 'commentStatuses', 'venueId', 'venueName'));
	}

        function add_error_report() {
            App::import('Sanitize');

            if (!empty($this->data)) {
                $this->data = Sanitize::clean($this->data, array('encode' => false));

                $this->Comment->create();

                // take error report and make into a comment
                foreach ($this->data['Comment'] as $key => $row) {
                    $report[] = "{$key}: {$row}";
                }
                unset($report[ Configure::read('checkfield_1') ]);
                unset($report[ Configure::read('checkfield_2') ]);

                $this->data['Comment']['author_ip'] = $this->Utilities->getRealIpAddr();
                $this->data['Comment']['comment_agent'] = $_SERVER['HTTP_USER_AGENT'];
                $this->data['Comment']['karma'] = 1;
                $this->data['Comment']['comment_status_id'] = 0;
               
                
                $this->data['Comment']['comment'] = implode("\n", $report);

                if ($this->Comment->save($this->data)) {

                    $this->Emailer->commentSent(
                            $this->data['Comment']['venue_id'],
                            $this->Comment->id,
                            'error_report' );

                    $response = array('msg' => '
                                <div class="ui-widget">
                                <div style="margin-top: 20px; padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all">
					<p><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span>
					Thank you, Your error report has been sent</p>
				</div>
                                </div>
                                ');

                } else {
                    $response = array('msg' => '
                                <div class="ui-widget">
				<div class="ui-state-error ui-corner-all" style="padding: 0pt 0.7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span>
					Sorry, there has been an error.</p>
				</div>
                                </div>
                                ');
                }

                echo json_encode($response);
                exit;
            }

            $venueId = intval($this->params['named']['venue']);
            $venue = $this->Comment->Venue->findById($venueId);

            if (!$venue)
                exit;

            $venueName = $venue['Venue']['full_name'];

            $commentStatuses = $this->Comment->CommentStatus->find('list');
            $this->set(compact('venues', 'commentStatuses', 'venueId', 'venueName'));
	}


        // =====================================================================

	function admin_index() {
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}


	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Comment', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
                      
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(__('The Comment has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Comment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Comment->read(null, $id);
		}
		$venues = $this->Comment->Venue->find('list');
		$commentStatuses = $this->Comment->CommentStatus->find('list');
		$this->set(compact('venues','commentStatuses'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Comment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Comment->delete($id)) {
			$this->Session->setFlash(__('Comment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
<?php
class VenueRatingsController extends AppController {

    var $name = 'VenueRatings';
    var $helpers = array('Html', 'Form');
    var $components = array('Cookie', 'RequestHandler', 'Utilities');


    function beforeFilter() { //debug('here 1');
        parent::beforeFilter();
        $this->Auth->allow('ajax_vote', 'list_highest_rated');
    }


    function list_highest_rated() {
        $this->autoRender = false;
        $num = intval($this->params['named']['num']);

        $result =
        ClassRegistry::init('VenueScore')->find('all', array(
            'contain' => array(
                'Venue' => array( 'full_name', 'slug', 'address', 
                                    'publish_state_id = ' . Configure::read( 'Venue.published'),
                                    'City' => array('name', 'slug') ),
               
            ),
            'conditions' => array(
                'VenueScore.score >' => 0,
                'VenueScore.votes >' => 4 
            ),
            'limit' => $num,
            'order' => 'VenueScore.score DESC, VenueScore.votes DESC'
        ));
       return($result);
       debug($result);
       //exit;

    }

    /*
     * Called by vote button to rate a venue
     * Returns new score.
     */
    function ajax_vote() {

        $venueId =    intval($this->params['url']['id']);
        $liked = intval($this->params['url']['liked']);
        $userIp = $this->Utilities->getRealIpAddr();

        /*debug($id );
        debug($liked);
        debug($usersIp);
*/
        if ( $venueId && $liked && $userIp) {

            // check if this ip has already voted for this venue
            if ( !$this->VenueRating->getUserAlreadyVoted($venueId, $userIp) ) {

                $result = $this->VenueRating->updateVenueRating( $venueId, $userIp, $liked );
                $message = 'Thanks'; debug($result);
                ClassRegistry::init('VenueScore')->updateScore($venueId, $result['score'], $result['votes']);
            } else {
                $result = $this->VenueRating->getVenueScore($venueId);
                $message = 'Already voted';
            }
           // debug($result);

            $score = round($result['score'] * 100);
            $json = array( 'votes' => $result['votes'], 'score' => $score, 'msg' => $message);



            // console.log( data.votes, data.score, data.msg)
            echo json_encode($json);
        } else {
            debug('no vote');
        }

        exit;
    }

    function ajax_vote_OLD() {
        //$this->layout = 'ajax';

        $vote = $this->in_range($this->params['form']['rate'], 1, 5);
        $venueId = (int)$this->params['form']['venue'];

        // load in the user's cookie
        $this->Cookie->name = 'VenueRating';
        $userRatings = $this->Cookie->read('venueList');

        if ( !is_array($userRatings) )
            $userRatings = array();


        // check if venue_id is already in array, if so, return message and exit
        if ( array_search( $venueId, $userRatings) !== false ){
            $this->set('json', json_encode( array(
                'votes' => 0, 'avg' => 0, 'err_msg' => "Sorry, you've already voted." ) ) );
            return;
        }
        else {
            // not in array, add to array and write out to cookie
            array_push($userRatings, $venueId);
            $this->Cookie->write( 'venueList', $userRatings, $encrypt = true, 3600 * 24 * 30);
        }


        // load data from VenueRating
        $result = $this->VenueRating->contain('Venue.slug');
        $result = $this->VenueRating->findByVenueId($venueId);

        if ( !$result ){
            // new entry
            $this->VenueRating->create();
            $data = array('VenueRating' => array( 'venue_id' => $venueId ,'score' => $vote, 'votes' => 1, 'sum' => $vote) );
            $result = $this->VenueRating->save( $data, $validate = true );

            $this->set( 'json', json_encode(array('votes' => 1, 'avg' => $vote) ) );

            Cache::clear();
            clearCache();

            return;
        }
        else {
            $venueSlug = $result['Venue']['slug'];
            // check if there has been a sufficient delay (discorage bots)
           $timeOk = $this->_check_update_allowed( $result['VenueRating']['modified'] );

            if ($timeOk == false)
            {
                $this->log("possible bot hitting on venue {$venueId}");
                $this->set( 'json', json_encode(array('votes' => 1, 'sum' => 1, 'avg' => 1) ) );
                
                
                return;
            }

            // update existing venue rating
            $this->VenueRating->create(); // needed to set the modified time
            $this->VenueRating->id = $result['VenueRating']['id'];

            $votes = $result['VenueRating']['votes'] = $result['VenueRating']['votes'] + 1;
            $score = sprintf('%01.2f',  ( $result['VenueRating']['score'] + $vote ) / 2 );
            $data = array('VenueRating' =>
                        array(  'votes' => $votes,
                                'score' => $score
                            )
                        );
           // debug($data);

            $result = $this->VenueRating->save( $data, $validate = true );

            $this->set( 'json', json_encode(array('votes' => $votes, 'avg' => round($score) ) ) );

            Cache::clear();
            clearCache();

        }

}

	// bot defence function
	// checks the time since the record modifed
	// if too short, return false, true otherwise
	function _check_update_allowed( $modified){
		$lastUpdate = strtotime($modified);
		$nextUpdate = $lastUpdate + 60; // 60 = 1 minute

		if ( time() < $nextUpdate )
		{
			$this->log( "\$lastUpdate: " . date( 'Y-m-d h:i:s', $lastUpdate));
			$this->log( "\$nextUpdate: " . date( 'Y-m-d h:i:s', $nextUpdate) );
			$this->log( date( 'Y-m-d h:i:s') . " NO update");
			return(false);
		}
		else{
			$this->log( time() . " update");
			return(true);
		}
	}


    // ========================
    // Utility functions -- CLEAN UP LATER --
    // ========================
    function get_options() {
            return array(
                    1 => 'Not so great',
                    2 => 'Quite good',
                    3 => 'Good',
                    4 => 'Great!',
                    5 => 'Excellent!',
            );
    }

    function in_range($val, $from=0, $to=100) {
            return min($to, max($from, (int)$val));
    }

    function get_dbfile() {
            return preg_replace('#\.php$#', '.dat', __FILE__);
    }

    function get_votes() {
            $dbfile = get_dbfile();
            return is_file($dbfile) ? unserialize(file_get_contents($dbfile)) : array('votes' => 0, 'sum' => 0, 'avg' => 0);
    }

    function save_vote($vote) {
            $db = get_votes();
            $db['votes']++;
            $db['sum'] += $vote;
            $db['avg'] = sprintf('%01.2f', $db['sum'] / $db['votes']);
            file_put_contents(get_dbfile(), serialize($db));

            return $db;
    }

}
?>
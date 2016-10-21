<?php
class FeedsController extends AppController {

    var $name = 'Feeds';
    var $uses = array('Venue', 'Post');
    var $helpers = array('Text');
    var $components = array('RequestHandler');

    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index', 'reviews' );
    }

    function index(){
        if( $this->RequestHandler->isRss() ){
            $venues = $this->Venue->find('all',
                        array(
                        'conditions' => array( 'Venue.publish_state_id' => Configure::read('Venue.published') ),
                        'fields' => array('full_name', 'slug', 'address', 'created',
                                            'VenueDetail.description', 'VenueScore.score', 'VenueScore.votes'),
                        'contain' => array('VenueDetail',
                                'City' => array('name','hash_tag'), 'CityRegion',
                                'VenueDetail',
                                'VenueScore'
                                ),
                        'order' => 'Venue.created DESC'
                     )
                    );
           debug($venues);
            $this->set(compact('venues'));
        } else {
            // this is not an Rss request, so deliver
            // data used by website's interface
            $this->layout = 'admin_default';
            $this->paginate = array(
            'limit' => Configure::read('search.listingsPerPage'),
            'conditions' => array( 'Venue.publish_state_id' => Configure::read('Venue.published') ),
                        'fields' => array('full_name','address', 'modified',
                                            'VenueDetail.description'),
                        'contain' => array('VenueDetail',
                                'City.name', 'CityRegion',
                                'VenueDetail'
                                ),
                        'order' => 'Venue.created DESC'
        );

            $venues = $this->paginate();
            //debug($venues);
            $this->set(compact('venues'));
        }
    }
	
    function reviews(){
		//Configure::write('debug', 2);
		
        if( $this->RequestHandler->isRss() ){
			
            $posts = $this->Post->find('all',
                        array(
                        'conditions' => array('Post.wp_status' => 'publish'),
                        'fields' => array('Post.name', 'Post.slug', 'Post.short_dek', 'Post.wp_created'),
                        'contain' => false,
                        'order' => array( 'Post.wp_created' =>  'DESC')
                     )
                    );
			
			
			debug($posts);
            $this->set(compact('posts'));		

        }
    }	
	
	

}
?>
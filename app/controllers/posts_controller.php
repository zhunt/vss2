<?php
class PostsController extends AppController {

	var $name = 'Posts';
	var $helpers = array('Html', 'Form', 'Text', 'Time');
	
    var $cacheAction = array(
        'view' => '1 week',
   );	
	
    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('view', 'index', 'wp_update', 'latest_news');
    }
	
	
	function index() {
	
        $this->set( 'title_for_layout', 'News and Events in and around Barrie, Collingwood and beyond');
        $this->set('metaDescription', 'Listings of upcoming events and news from Simcoe Dining, your guide to restaurants, bars, cafes and hotels in the Barrie area.');
		
		$this->paginate = array (
			'limit' => 10,
			'order' => array( 'Post.wp_created' =>  'DESC'),
			'conditions' => array('Post.wp_status' => 'publish')
		);		
		
		$this->Post->recursive = 0;
		$this->set('posts', $this->paginate('Post') );
	}
	
	function latest_news() {
		
		
		$limit = $this->params['named']['limit'];
		
		$this->paginate = array (
			'limit' => $limit,
			'order' => array( 'Post.wp_created' =>  'DESC'),
			'conditions' => array('Post.wp_status' => 'publish'),
			'contains' => false,
			'fields' => array('Post.name', 'Post.slug', 'Post.short_dek', 'Post.wp_created')
		);		
		return $this->paginate('Post');
		
	}

	function view() {

        $slug = Sanitize::paranoid($this->params['slug'], array('-') );
        if (!$slug) {
            $slug = '';
            $this->Session->setFlash('Invalid article.');
            $this->redirect(array('controller' => 'landings', 'action' => 'home') );
        }

		$data = $this->Post->find('first', array('conditions' => array(
													'Post.slug' => $slug,
													'Post.wp_status' => 'publish'
													) ) );
		if (!$data)
			$this->cakeError('error404');
		
			
        $this->set( 'title_for_layout', $data['Post']['seo_title'] );
        $this->set('metaDescription', $data['Post']['seo_description']);			
				
		$this->set('post', $data );
	}
	
	// ==========================================================
	function wp_update() {

		$data = json_decode($this->params['form']['json'], true);
		
		$checksumSent = trim($data['checksum']);
		
		//echo json_encode( array(1 => $checksumSent ) ); exit;
		
		// re-calc
		$checksum = crc32($data['content']);
		$checksum = sprintf("%u", $checksum);
		if ( $checksumSent == $checksum ) {
			echo json_encode( array('result' => 'checksum checks out!') );
			$goodCheck = true;
		}else {
			echo json_encode( array('result' => 'checksum ERROR!!: ' . $checksumSent . ' != ' . $checksum ) );
			$goodCheck = false;
		}
		//exit;
		
		if ($goodCheck) {
		
			$wpData = array(
				'wp_guid' => $data['guid'],
				'name' => $data['title'],
				'slug' => $data['slug'],
				'content_html' => $data['html'],
				'wp_created' => $data['published'],
				'wp_status' => $data['status'],
				'short_dek' => $data['meta_fields']['post_short_dek_value'],
				'wp_excerpt' => $data['excerpt'],
				'seo_title' => $data['meta_fields']['_su_title'],
				'seo_description' => $data['meta_fields']['_su_description']
			);
			
			//var_dump($wpData);
				
			// save data
			$guid = $data['guid'];
			$state = $data['status']; // wp_status in DB
			
			$result = $this->Post->find('first', array('conditions' => array('wp_guid' => $guid ), 'contain' => false) ); 
			if (!$result && ( $data['status'] == 'publish' || $data['status'] == 'future' ) ) { // not found, save new record only if it's published / future

				$this->Post->create();
				$this->Post->save($wpData, array('validate' => false ));
				Cache::clear(); clearCache(); 
			}
			else if ($result && $data['status'] == 'trash' ) { // remove it
				$this->Post->delete($result['Post']['id']);
				Cache::clear(); clearCache(); 
			}
			else if ($result ) {
				$this->Post->id = $result['Post']['id'];
				$this->Post->save($wpData, array('validate' => false ));
				Cache::clear(); clearCache(); 
			}			
			
			
		
		}
		
		
		exit;
	}	

	// ==========================================================
	// admin
	function admin_index() {
		$this->Post->recursive = 0;
		$this->set('posts', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid post', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('post', $this->Post->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Post->create();
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash(__('The post has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid post', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash(__('The post has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Post->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for post', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Post->delete($id)) {
			$this->Session->setFlash(__('Post deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Post was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
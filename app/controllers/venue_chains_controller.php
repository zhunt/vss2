<?php
class VenueChainsController extends AppController {

	var $name = 'VenueChains';
	var $helpers = array('Html', 'Form');
    var $components = array('RequestHandler');

    function beforeRender()
	{
		// change layout for admin section
		if (isset($this->params[Configure::read('Routing.admin')]) && !$this->RequestHandler->isAjax() )
			$this->layout = 'admin_default';
    }

/*
 * ========================================================================
 */
    
	function index() {
		$this->VenueChain->recursive = 0;
		$this->set('venueChains', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueChain.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueChain', $this->VenueChain->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueChain->create();
			if ($this->VenueChain->save($this->data)) {
				$this->Session->setFlash(__('The VenueChain has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueChain could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueChain', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueChain->save($this->data)) {
				$this->Session->setFlash(__('The VenueChain has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueChain could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueChain->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueChain', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueChain->del($id)) {
			$this->Session->setFlash(__('VenueChain deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

    /*
     * ========================================================================
     */
	function admin_index() {
		$this->VenueChain->recursive = 0;
		$this->set('venueChains', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueChain.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueChain', $this->VenueChain->read(null, $id));
	}
    /*
     * Adds venue chain and returns new list as JSON
     */
    function admin_ajax_add(){
        $this->layout = 'ajax';
       
		if (!empty($this->data)) {
			$this->VenueChain->create();
			if ($this->VenueChain->save($this->data)) {
				
                $result = $this->VenueChain->find( 'list');
                $chainList = array();
                foreach( $result as $i => $j) {
                    array_push($chainList, array( 'id' => $i, 'name' => $j) );
                }

                $this->set('msg', json_encode($chainList) );
			} else {
				//$this->Session->setFlash(__('The VenueChain could not be saved. Please, try again.', true));
			}
		}
	}
    
	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueChain->create();
			if ($this->VenueChain->save($this->data)) {
				$this->Session->setFlash(__('The VenueChain has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueChain could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueChain', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueChain->save($this->data)) {
				$this->Session->setFlash(__('The VenueChain has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueChain could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueChain->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueChain', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueChain->del($id)) {
			$this->Session->setFlash(__('VenueChain deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
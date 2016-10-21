<?php
class VenueFeaturesController extends AppController {

	var $name = 'VenueFeatures';
	var $helpers = array('Html', 'Form');

    var $components = array('RequestHandler');

    function beforeRender()
	{
		// change layout for admin section
		if (isset($this->params[Configure::read('Routing.admin')]) && !$this->RequestHandler->isAjax() )
			$this->layout = 'admin_default';
    }

    /*
     * =======================================================================
     */

	function index() {
		$this->VenueFeature->recursive = 0;
		$this->set('venueFeatures', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueFeature.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueFeature', $this->VenueFeature->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueFeature->create();
			if ($this->VenueFeature->save($this->data)) {
				$this->Session->setFlash(__('The VenueFeature has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueFeature could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueFeature', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueFeature->save($this->data)) {
				$this->Session->setFlash(__('The VenueFeature has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueFeature could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueFeature->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueFeature', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueFeature->del($id)) {
			$this->Session->setFlash(__('VenueFeature deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueFeature->recursive = 0;
		$this->set('venueFeatures', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueFeature.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueFeature', $this->VenueFeature->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueFeature->create();
			if ($this->VenueFeature->save($this->data)) {
				$this->Session->setFlash(__('The VenueFeature has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueFeature could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueFeature', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueFeature->save($this->data)) {
				$this->Session->setFlash(__('The VenueFeature has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueFeature could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueFeature->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueFeature', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueFeature->del($id)) {
			$this->Session->setFlash(__('VenueFeature deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
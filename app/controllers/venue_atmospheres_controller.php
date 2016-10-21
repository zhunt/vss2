<?php
class VenueAtmospheresController extends AppController {

	var $name = 'VenueAtmospheres';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->VenueAtmosphere->recursive = 0;
		$this->set('venueAtmospheres', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueAtmosphere.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueAtmosphere', $this->VenueAtmosphere->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueAtmosphere->create();
			if ($this->VenueAtmosphere->save($this->data)) {
				$this->Session->setFlash(__('The VenueAtmosphere has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueAtmosphere could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueAtmosphere', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueAtmosphere->save($this->data)) {
				$this->Session->setFlash(__('The VenueAtmosphere has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueAtmosphere could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueAtmosphere->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueAtmosphere', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueAtmosphere->del($id)) {
			$this->Session->setFlash(__('VenueAtmosphere deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueAtmosphere->recursive = 0;
		$this->set('venueAtmospheres', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueAtmosphere.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueAtmosphere', $this->VenueAtmosphere->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueAtmosphere->create();
			if ($this->VenueAtmosphere->save($this->data)) {
				$this->Session->setFlash(__('The VenueAtmosphere has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueAtmosphere could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueAtmosphere', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueAtmosphere->save($this->data)) {
				$this->Session->setFlash(__('The VenueAtmosphere has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueAtmosphere could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueAtmosphere->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueAtmosphere', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueAtmosphere->del($id)) {
			$this->Session->setFlash(__('VenueAtmosphere deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
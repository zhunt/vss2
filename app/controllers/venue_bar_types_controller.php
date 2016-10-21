<?php
class VenueBarTypesController extends AppController {

	var $name = 'VenueBarTypes';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->VenueBarType->recursive = 0;
		$this->set('venueBarTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueBarType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueBarType', $this->VenueBarType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueBarType->create();
			if ($this->VenueBarType->save($this->data)) {
				$this->Session->setFlash(__('The VenueBarType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueBarType could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueBarType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueBarType->save($this->data)) {
				$this->Session->setFlash(__('The VenueBarType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueBarType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueBarType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueBarType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueBarType->del($id)) {
			$this->Session->setFlash(__('VenueBarType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueBarType->recursive = 0;
		$this->set('venueBarTypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueBarType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueBarType', $this->VenueBarType->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueBarType->create();
			if ($this->VenueBarType->save($this->data)) {
				$this->Session->setFlash(__('The VenueBarType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueBarType could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueBarType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueBarType->save($this->data)) {
				$this->Session->setFlash(__('The VenueBarType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueBarType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueBarType->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueBarType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueBarType->del($id)) {
			$this->Session->setFlash(__('VenueBarType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
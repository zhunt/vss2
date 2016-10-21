<?php
class VenuePricesController extends AppController {

	var $name = 'VenuePrices';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->VenuePrice->recursive = 0;
		$this->set('venuePrices', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenuePrice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venuePrice', $this->VenuePrice->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenuePrice->create();
			if ($this->VenuePrice->save($this->data)) {
				$this->Session->setFlash(__('The VenuePrice has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenuePrice could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenuePrice', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenuePrice->save($this->data)) {
				$this->Session->setFlash(__('The VenuePrice has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenuePrice could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenuePrice->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenuePrice', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenuePrice->del($id)) {
			$this->Session->setFlash(__('VenuePrice deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenuePrice->recursive = 0;
		$this->set('venuePrices', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenuePrice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venuePrice', $this->VenuePrice->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenuePrice->create();
			if ($this->VenuePrice->save($this->data)) {
				$this->Session->setFlash(__('The VenuePrice has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenuePrice could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenuePrice', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenuePrice->save($this->data)) {
				$this->Session->setFlash(__('The VenuePrice has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenuePrice could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenuePrice->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenuePrice', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenuePrice->del($id)) {
			$this->Session->setFlash(__('VenuePrice deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
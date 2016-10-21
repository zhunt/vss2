<?php
class VenueCaterTypesController extends AppController {

	var $name = 'VenueCaterTypes';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->VenueCaterType->recursive = 0;
		$this->set('venueCaterTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueCaterType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueCaterType', $this->VenueCaterType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueCaterType->create();
			if ($this->VenueCaterType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCaterType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCaterType could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueCaterType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueCaterType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCaterType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCaterType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueCaterType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueCaterType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueCaterType->del($id)) {
			$this->Session->setFlash(__('VenueCaterType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueCaterType->recursive = 0;
		$this->set('venueCaterTypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueCaterType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueCaterType', $this->VenueCaterType->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueCaterType->create();
			if ($this->VenueCaterType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCaterType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCaterType could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueCaterType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueCaterType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCaterType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCaterType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueCaterType->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueCaterType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueCaterType->del($id)) {
			$this->Session->setFlash(__('VenueCaterType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
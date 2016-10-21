<?php
class VenueCafeTypesController extends AppController {

	var $name = 'VenueCafeTypes';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->VenueCafeType->recursive = 0;
		$this->set('venueCafeTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueCafeType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueCafeType', $this->VenueCafeType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueCafeType->create();
			if ($this->VenueCafeType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCafeType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCafeType could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueCafeType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueCafeType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCafeType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCafeType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueCafeType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueCafeType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueCafeType->del($id)) {
			$this->Session->setFlash(__('VenueCafeType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueCafeType->recursive = 0;
		$this->set('venueCafeTypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueCafeType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueCafeType', $this->VenueCafeType->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueCafeType->create();
			if ($this->VenueCafeType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCafeType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCafeType could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueCafeType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueCafeType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCafeType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCafeType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueCafeType->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueCafeType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueCafeType->del($id)) {
			$this->Session->setFlash(__('VenueCafeType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
<?php
class VenueCuisineTypesController extends AppController {

	var $name = 'VenueCuisineTypes';
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
		$this->VenueCuisineType->recursive = 0;
		$this->set('venueCuisineTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueCuisineType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueCuisineType', $this->VenueCuisineType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueCuisineType->create();
			if ($this->VenueCuisineType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCuisineType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCuisineType could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueCuisineType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueCuisineType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCuisineType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCuisineType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueCuisineType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueCuisineType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueCuisineType->del($id)) {
			$this->Session->setFlash(__('VenueCuisineType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueCuisineType->recursive = 0;
		$this->set('venueCuisineTypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueCuisineType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueCuisineType', $this->VenueCuisineType->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueCuisineType->create();
			if ($this->VenueCuisineType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCuisineType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCuisineType could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueCuisineType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueCuisineType->save($this->data)) {
				$this->Session->setFlash(__('The VenueCuisineType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueCuisineType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueCuisineType->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueCuisineType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueCuisineType->del($id)) {
			$this->Session->setFlash(__('VenueCuisineType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
<?php
class VenueDressCodesController extends AppController {

	var $name = 'VenueDressCodes';
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
		$this->VenueDressCode->recursive = 0;
		$this->set('venueDressCodes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueDressCode.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueDressCode', $this->VenueDressCode->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueDressCode->create();
			if ($this->VenueDressCode->save($this->data)) {
				$this->Session->setFlash(__('The VenueDressCode has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueDressCode could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueDressCode', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueDressCode->save($this->data)) {
				$this->Session->setFlash(__('The VenueDressCode has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueDressCode could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueDressCode->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueDressCode', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueDressCode->del($id)) {
			$this->Session->setFlash(__('VenueDressCode deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueDressCode->recursive = 0;
		$this->set('venueDressCodes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueDressCode.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueDressCode', $this->VenueDressCode->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueDressCode->create();
			if ($this->VenueDressCode->save($this->data)) {
				$this->Session->setFlash(__('The VenueDressCode has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueDressCode could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueDressCode', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueDressCode->save($this->data)) {
				$this->Session->setFlash(__('The VenueDressCode has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueDressCode could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueDressCode->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueDressCode', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueDressCode->del($id)) {
			$this->Session->setFlash(__('VenueDressCode deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
<?php
class CitiesController extends AppController {

	var $name = 'Cities';
	var $helpers = array('Html', 'Form', 'Text');

	function admin_index() {
            
            $this->City->contain('Region');
            $this->set('cities', $this->paginate());
	}

	function admin_add() {
            if (!empty($this->data)) {
                $this->City->create();
                if ($this->City->save($this->data)) {
                    $this->Session->setFlash(__('The City has been saved', true));
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash('The City could not be saved. Please, try again.');
                }
            }
            $this->set('regions', $this->City->Region->find('list') );
	}

	function admin_edit($id = null) {
            if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid City', true));
                $this->redirect(array('action'=>'index'));
            }
            if (!empty($this->data)) {
                if ($this->City->save($this->data)) {
                    $this->Session->setFlash(__('The City has been saved', true));
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash(__('The City could not be saved. Please, try again.', true));
                }
            }
            if (empty($this->data)) {
                $this->data = $this->City->read(null, $id);
            }
	}

	function admin_delete($id = null) {
            if (!$id) {
                $this->Session->setFlash(__('Invalid id for City', true));
                $this->redirect(array('action'=>'index'));
            }
            if ($this->City->delete($id)) {
                $this->Session->setFlash(__('City deleted', true));
                $this->redirect(array('action'=>'index'));
            }
	}

}
?>
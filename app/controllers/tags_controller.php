<?php
class TagsController extends AppController {

	var $name = 'Tags';
	var $helpers = array('Html', 'Form');
        var $components = array('RequestHandler');

        function beforeRender() {
                    // change layout for admin section
                    if (isset($this->params[Configure::read('Routing.admin')]) && !$this->RequestHandler->isAjax() )
                            $this->layout = 'admin_default';
        }
        /*
         * -------------------------------------------------------------------
         */

	function index() {
		$this->Tag->recursive = 0;
		$this->set('tags', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Tag.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tag', $this->Tag->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Tag->create();
			if ($this->Tag->save($this->data)) {
				$this->Session->setFlash(__('The Tag has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tag could not be saved. Please, try again.', true));
			}
		}
		$venues = $this->Tag->Venue->find('list');
		$this->set(compact('venues'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Tag', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Tag->save($this->data)) {
				$this->Session->setFlash(__('The Tag has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tag could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tag->read(null, $id);
		}
		$venues = $this->Tag->Venue->find('list');
		$this->set(compact('venues'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Tag', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tag->del($id)) {
			$this->Session->setFlash(__('Tag deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Tag->recursive = 0;
		$this->set('tags', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Tag.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tag', $this->Tag->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Tag->create();
			if ($this->Tag->save($this->data)) {
				$this->Session->setFlash(__('The Tag has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tag could not be saved. Please, try again.', true));
			}
		}
		$venues = $this->Tag->Venue->find('list');
		$this->set(compact('venues'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Tag', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Tag->save($this->data)) {
				$this->Session->setFlash(__('The Tag has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tag could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tag->read(null, $id);
		}
		$venues = $this->Tag->Venue->find('list');
		$this->set(compact('venues'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Tag', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tag->del($id)) {
			$this->Session->setFlash(__('Tag deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
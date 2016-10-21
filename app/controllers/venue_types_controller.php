<?php
class VenueTypesController extends AppController {

	var $name = 'VenueTypes';
	var $helpers = array('Html', 'Form');

	

	function admin_index() {
		$this->VenueType->recursive = 0;
		$this->set('venueTypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueType', $this->VenueType->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueType->create();
			if ($this->VenueType->save($this->data)) {
				$this->Session->setFlash('The VenueType has been saved');
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueType could not be saved. Please, try again.', true));
			}
		}
		$venues = $this->VenueType->Venue->find('list');
		$this->set(compact('venues'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueType->save($this->data)) {
				$this->Session->setFlash(__('The VenueType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueType->read(null, $id);
		}
		$venues = $this->VenueType->Venue->find('list');
		$this->set(compact('venues'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueType->delete($id)) {
			$this->Session->setFlash(__('VenueType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
<?php
class VenueAttractionTypesController extends AppController {

	var $name = 'VenueAttractionTypes';
	var $helpers = array('Html', 'Form');




	function admin_index() {
		$this->VenueAttractionType->recursive = 0;
		$this->set('venueAttractionTypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueAttractionType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueAttractionType', $this->VenueAttractionType->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueAttractionType->create();
			if ($this->VenueAttractionType->save($this->data)) {
				$this->Session->setFlash(__('The VenueAttractionType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueAttractionType could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueAttractionType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueAttractionType->save($this->data)) {
				$this->Session->setFlash(__('The VenueAttractionType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueAttractionType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueAttractionType->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueAttractionType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueAttractionType->del($id)) {
			$this->Session->setFlash(__('VenueAttractionType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
<?php
class VenueHotelTypesController extends AppController {

	var $name = 'VenueHotelTypes';
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
		$this->VenueHotelType->recursive = 0;
		$this->set('venueHotelTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueHotelType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueHotelType', $this->VenueHotelType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueHotelType->create();
			if ($this->VenueHotelType->save($this->data)) {
				$this->Session->setFlash(__('The VenueHotelType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueHotelType could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueHotelType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueHotelType->save($this->data)) {
				$this->Session->setFlash(__('The VenueHotelType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueHotelType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueHotelType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueHotelType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueHotelType->del($id)) {
			$this->Session->setFlash(__('VenueHotelType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueHotelType->recursive = 0;
		$this->set('venueHotelTypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueHotelType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueHotelType', $this->VenueHotelType->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueHotelType->create();
			if ($this->VenueHotelType->save($this->data)) {
				$this->Session->setFlash(__('The VenueHotelType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueHotelType could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueHotelType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueHotelType->save($this->data)) {
				$this->Session->setFlash(__('The VenueHotelType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueHotelType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueHotelType->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueHotelType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueHotelType->del($id)) {
			$this->Session->setFlash(__('VenueHotelType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
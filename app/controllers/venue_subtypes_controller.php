<?php
class VenueSubtypesController extends AppController {

	var $name = 'VenueSubtypes';
	var $helpers = array('Html', 'Form');


        function admin_ajax_add() {
            if ( $this->RequestHandler->isAjax() ){

                $venueTypeId = intval($this->params['url']['venueTypeId']);
                $name = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/'));

                if ( $venueTypeId < 1 || empty($name) ) {
                    $ajaxData = array('status' => 'error', 'msg' => 'Error occured');
                } else {
                    $id = $this->VenueSubtype->updateSubtype( $name, $venueTypeId);

                    if ( $id != false)
                        $ajaxData = array('status' => 'ok', 'msg' => 'All good');
                }
                
                $venueSubtypes = $this->VenueSubtype->find('list', array('order' => 'name') );
                
                $this->data['VenueSubtype']['VenueSubtype'][] = $id;
                $this->set( compact('venueSubtypes', 'ajaxData', 'id', 'name'));

            }
        }

	function admin_index() {
            $this->VenueSubtype->recursive = 0;
            $this->set('venueSubtypes', $this->paginate());
	}

	function admin_add() {
            if (!empty($this->data)) {
                $this->VenueSubtype->create();
                if ($this->VenueSubtype->save($this->data)) {
                    $this->Session->setFlash(__('The VenueSubtype has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash( 'The VenueSubtype could not be saved. Please, try again.');
                }
            }
            $venues = $this->VenueSubtype->Venue->find('list');
            $venueTypes = $this->VenueSubtype->VenueType->find('list');
            $this->set(compact('venues', 'venueTypes'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
                    $this->Session->setFlash(__('Invalid VenueSubtype', true));
                    $this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
                    if ($this->VenueSubtype->save($this->data)) {
                        $this->Session->setFlash(__('The VenueSubtype has been saved', true));
                        $this->redirect(array('action'=>'index'));
                    } else {
                        $this->Session->setFlash(__('The VenueSubtype could not be saved. Please, try again.', true));
                    }
		}
		if (empty($this->data)) {
			$this->data = $this->VenueSubtype->read(null, $id);
		}
		$venues = $this->VenueSubtype->Venue->find('list');
		$venueTypes = $this->VenueSubtype->VenueType->find('list');
		$this->set(compact('venues','venueTypes'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueSubtype', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueSubtype->delete($id)) {
			$this->Session->setFlash(__('VenueSubtype deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
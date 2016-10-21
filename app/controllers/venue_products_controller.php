<?php
class VenueProductsController extends AppController {

    var $name = 'VenueProducts';
    var $helpers = array('Html', 'Form');


    function admin_ajax_add() {
        if ( $this->RequestHandler->isAjax() ){

            $venueTypeId = intval($this->params['url']['venueTypeId']);
            $name = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/'));

            if ( $venueTypeId < 1 || empty($name) ) {
                $ajaxData = array('status' => 'error', 'msg' => 'Error occured');
            } else {
                $id = $this->VenueProduct->updateVenueProduct( $name, $venueTypeId);

                if ( $id != false)
                    $ajaxData = array('status' => 'ok', 'msg' => 'All good');
            }

            $venueProducts = $this->VenueProduct->find('list', array('order' => 'name') );

            $this->set( compact('venueProducts', 'ajaxData', 'id', 'name'));

        }
    }

    function admin_index() {
        $this->VenueProduct->recursive = 0;
        $this->set('venueProducts', $this->paginate());
    }

    function admin_add() {
        if (!empty($this->data)) {
                $this->VenueProduct->create();
                if ($this->VenueProduct->save($this->data)) {
                        $this->Session->setFlash(__('The VenueProduct has been saved', true));
                        $this->redirect(array('action'=>'index'));
                } else {
                        $this->Session->setFlash(__('The VenueProduct could not be saved. Please, try again.', true));
                }
        }
        $venues = $this->VenueProduct->Venue->find('list');
        $venueTypes = $this->VenueProduct->VenueType->find('list');
        $this->set(compact('venues', 'venueTypes'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid VenueProduct', true));
                $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
                if ($this->VenueProduct->save($this->data)) {
                        $this->Session->setFlash(__('The VenueProduct has been saved', true));
                        $this->redirect(array('action'=>'index'));
                } else {
                        $this->Session->setFlash(__('The VenueProduct could not be saved. Please, try again.', true));
                }
        }
        if (empty($this->data)) {
                $this->data = $this->VenueProduct->read(null, $id);
        }
        $venues = $this->VenueProduct->Venue->find('list');
        $venueTypes = $this->VenueProduct->VenueType->find('list');
        $this->set(compact('venues','venueTypes'));
    }

    function admin_delete($id = null) {
        if (!$id) {
                $this->Session->setFlash(__('Invalid id for VenueProduct', true));
                $this->redirect(array('action'=>'index'));
        }
        if ($this->VenueProduct->delete($id)) {
                $this->Session->setFlash(__('VenueProduct deleted', true));
                $this->redirect(array('action'=>'index'));
        }
    }

	
}
?>
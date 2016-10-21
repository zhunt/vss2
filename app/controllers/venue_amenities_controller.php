<?php
class VenueAmenitiesController extends AppController {

    var $name = 'VenueAmenities';
    var $helpers = array('Html', 'Form');


    function admin_ajax_add() {
        if ( $this->RequestHandler->isAjax() ){

            $venueTypeId = intval($this->params['url']['venueTypeId']);
            $name = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/'));

            if ( $venueTypeId < 1 || empty($name) ) {
                $ajaxData = array('status' => 'error', 'msg' => 'Error occured');
            } else {
                $id = $this->VenueAmenity->updateVenueAmenity($name, $venueTypeId);

                if ( $id != false)
                    $ajaxData = array('status' => 'ok', 'msg' => 'All good');
            }

            $venueAmenities = $this->VenueAmenity->find('list', array('order' => 'name') );

            $this->set( compact('venueAmenities', 'ajaxData', 'id', 'name'));

        }
    }

    function admin_index() {
        $this->VenueAmenity->recursive = 0;
        $this->set('venueAmenities', $this->paginate());
    }

    function admin_add() {
        if (!empty($this->data)) {
                $this->VenueAmenity->create();
                if ($this->VenueAmenity->save($this->data)) {
                        $this->Session->setFlash(__('The VenueAmenity has been saved', true));
                        $this->redirect(array('action'=>'index'));
                } else {
                        $this->Session->setFlash(__('The VenueAmenity could not be saved. Please, try again.', true));
                }
        }
        $venues = $this->VenueAmenity->Venue->find('list');
        $venueTypes = $this->VenueAmenity->VenueType->find('list');
        $this->set(compact('venues', 'venueTypes'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid VenueAmenity', true));
                $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
                if ($this->VenueAmenity->save($this->data)) {
                        $this->Session->setFlash(__('The VenueAmenity has been saved', true));
                        $this->redirect(array('action'=>'index'));
                } else {
                        $this->Session->setFlash(__('The VenueAmenity could not be saved. Please, try again.', true));
                }
        }
        if (empty($this->data)) {
                $this->data = $this->VenueAmenity->read(null, $id);
        }
        $venues = $this->VenueAmenity->Venue->find('list');
        $venueTypes = $this->VenueAmenity->VenueType->find('list');
        $this->set(compact('venues','venueTypes'));
    }

    function admin_delete($id = null) {
        if (!$id) {
                $this->Session->setFlash(__('Invalid id for VenueAmenity', true));
                $this->redirect(array('action'=>'index'));
        }
        if ($this->VenueAmenity->delete($id)) {
                $this->Session->setFlash(__('VenueAmenity deleted', true));
                $this->redirect(array('action'=>'index'));
        }
    }




}
?>
<?php
class VenueServicesController extends AppController {

    var $name = 'VenueServices';
    var $helpers = array('Html', 'Form');


    function admin_ajax_add() {
        if ( $this->RequestHandler->isAjax() ){

            $venueTypeId = intval($this->params['url']['venueTypeId']);
            $name = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/'));

            if ( $venueTypeId < 1 || empty($name) ) {
                $ajaxData = array('status' => 'error', 'msg' => 'Error occured');
            } else {
                $id = $this->VenueService->updateVenueService( $name, $venueTypeId);

                if ( $id != false)
                    $ajaxData = array('status' => 'ok', 'msg' => 'All good');
            }

            $venueServices = $this->VenueService->find('list', array('order' => 'name') );

            $this->set( compact('venueServices', 'ajaxData', 'id', 'name'));

        }
    }

    function admin_index() {
        $this->VenueService->recursive = 0;
        $this->set('venueServices', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid VenueService.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('venueService', $this->VenueService->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
                $this->VenueService->create();
                if ($this->VenueService->save($this->data)) {
                        $this->Session->setFlash(__('The VenueService has been saved', true));
                        $this->redirect(array('action'=>'index'));
                } else {
                        $this->Session->setFlash(__('The VenueService could not be saved. Please, try again.', true));
                }
        }
        $venues = $this->VenueService->Venue->find('list');
        $venueTypes = $this->VenueService->VenueType->find('list');
        $this->set(compact('venues', 'venueTypes'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid VenueService', true));
                $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
                if ($this->VenueService->save($this->data)) {
                        $this->Session->setFlash(__('The VenueService has been saved', true));
                        $this->redirect(array('action'=>'index'));
                } else {
                        $this->Session->setFlash(__('The VenueService could not be saved. Please, try again.', true));
                }
        }
        if (empty($this->data)) {
                $this->data = $this->VenueService->read(null, $id);
        }
        $venues = $this->VenueService->Venue->find('list');
        $venueTypes = $this->VenueService->VenueType->find('list');
        $this->set(compact('venues','venueTypes'));
    }

    function admin_delete($id = null) {
        if (!$id) {
                $this->Session->setFlash(__('Invalid id for VenueService', true));
                $this->redirect(array('action'=>'index'));
        }
        if ($this->VenueService->delete($id)) {
                $this->Session->setFlash(__('VenueService deleted', true));
                $this->redirect(array('action'=>'index'));
        }
    }


}
?>
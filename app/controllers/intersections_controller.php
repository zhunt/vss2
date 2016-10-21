<?php
class IntersectionsController extends AppController {

    var $name = 'Intersections';
    var $helpers = array('Html', 'Form');



    function admin_ajax_add() {
        if ( $this->RequestHandler->isAjax() ){

            $cityId = intval($this->params['url']['cityId']);
            $cityRegion = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/'));

            if ( $cityId < 1 || empty($cityRegion) ) {
                $data = array('status' => 'error', 'msg' => 'Error occured');
            } else {
                $id = $this->Intersection->updateIntersection( $cityRegion, $cityId);

                if ( $id != false)
                    $data = array('status' => 'ok', 'msg' => 'All good');
            }

            $intersections = $this->Intersection->find('list', array('fields' =>
                    array('Intersection.id', 'Intersection.name', 'City.name'),
                    'recursive' => 0,
                    'order' => array('City.name', 'Intersection.name')
                ) );

            $this->set( compact('intersections', 'data', 'id'));

        }
    }

    
    function admin_index() {
        $this->Intersection->recursive = 0;
        $this->set('intersections', $this->paginate());
    }

    function admin_add() {
        if (!empty($this->data)) {
                $this->Intersection->create();
                if ($this->Intersection->save($this->data)) {
                    $this->Session->setFlash(__('The Intersection has been saved', true));
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash(__('The Intersection could not be saved. Please, try again.', true));
                }
        }
        $cities = $this->Intersection->City->find('list');
        $this->set(compact('cities'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Intersection', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Intersection->save($this->data)) {
                $this->Session->setFlash(__('The Intersection has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Intersection could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
                $this->data = $this->Intersection->read(null, $id);
        }
        $cities = $this->Intersection->City->find('list');
        $this->set(compact('cities'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Intersection', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Intersection->delete($id)) {
            $this->Session->setFlash(__('Intersection deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }

}
?>
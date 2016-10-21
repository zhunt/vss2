<?php
class RegionsController extends AppController {

    var $name = 'Regions';
    var $helpers = array('Html', 'Form');

    function admin_index() {
        $this->Region->recursive = 0;
        $this->set('regions', $this->paginate());
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Region->create();
            if ($this->Region->save($this->data)) {
                $this->Session->setFlash(__('The Region has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Region could not be saved. Please, try again.', true));
            }
        }
        $provinces = $this->Region->Province->find('list');
        $this->set(compact('provinces'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Region', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Region->save($this->data)) {
                $this->Session->setFlash(__('The Region has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Region could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Region->read(null, $id);
        }
        $provinces = $this->Region->Province->find('list');
        $this->set(compact('provinces'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Region', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->Region->delete($id)) {
            $this->Session->setFlash(__('Region deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }

}
?>
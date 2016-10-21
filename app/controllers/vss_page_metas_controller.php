<?php
class VssPageMetasController extends AppController {

    var $name = 'VssPageMetas';
    var $helpers = array('Html', 'Form');

    function admin_index() {
        $this->VssPageMeta->recursive = 0;
        $this->set('vssPageMetas', $this->paginate());
        $this->set('meta_description', 'meta set in controller');

    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid VssPageMeta.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('vssPageMeta', $this->VssPageMeta->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->VssPageMeta->create();
            if ($this->VssPageMeta->save($this->data)) {
                $this->Session->setFlash(__('The VssPageMeta has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The VssPageMeta could not be saved. Please, try again.', true));
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid VssPageMeta', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->VssPageMeta->save($this->data)) {
                $this->Session->setFlash(__('The VssPageMeta has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The VssPageMeta could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->VssPageMeta->read(null, $id);
        }

    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for VssPageMeta', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->VssPageMeta->delete($id)) {
            $this->Session->setFlash(__('VssPageMeta deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }

}
?>
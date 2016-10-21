<?php
class VssOptionsController extends AppController {

    var $name = 'VssOptions';
    var $helpers = array('Html', 'Form');

    function admin_index() {
        $this->VssOption->recursive = 0;
        $this->set('vssOptions', $this->paginate());
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->VssOption->create();
            if ($this->VssOption->save($this->data)) {
                Cache::delete('vssOptions', 'long_cache');
                $this->Session->setFlash(__('The VssOption has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The VssOption could not be saved. Please, try again.', true));
            }
        }
    }

    function admin_edit($id = null) {
            if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid VssOption', true));
                $this->redirect(array('action'=>'index'));
            }
            if (!empty($this->data)) {
                if ($this->VssOption->save($this->data)) {
                    Cache::delete('vssOptions', 'long_cache');
                    $this->Session->setFlash(__('The VssOption has been saved', true));
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash(__('The VssOption could not be saved. Please, try again.', true));
                }
            }
            if (empty($this->data)) {
                    $this->data = $this->VssOption->read(null, $id);
            }
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for VssOption', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->VssOption->delete($id)) {
            $this->Session->setFlash(__('VssOption deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }
}
?>
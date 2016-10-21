<?php
class VssPagesController extends AppController {

    var $name = 'VssPages';
    var $uses = array('VssPage');
    var $helpers = array('Html', 'Form', 'Text');

    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index', 'view');
    }

    function index() {
        $this->VssPage->recursive = 0;
        $this->set('vssPages', $this->paginate());
    }

    /*
     * returns back to view the content of a page
     */
    function view( $id = null) {
        if (isset($this->params['requested'])) {
            $slug = $this->params['named']['slug'];
            $this->VssPage->contain = false;
            $result = $this->VssPage->findBySlug($slug);
            if ($result)
                return($result['VssPage']['content']);
            else
                return false;
        }
    }

    function admin_index() {
        $this->VssPage->recursive = 0;
        $this->set('vssPages', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid VssPage.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('vssPage', $this->VssPage->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->VssPage->create();
            if ($this->VssPage->save($this->data)) {
                $this->Session->setFlash(__('The VssPage has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The VssPage could not be saved. Please, try again.', true));
            }
        }
        $pageTemplates = $this->VssPage->PageTemplate->find('list');
        $venues = $this->VssPage->Venue->find('list');
        $this->set(compact('pageTemplates', 'venues'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid VssPage', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->VssPage->save($this->data)) {
                $this->Session->setFlash(__('The VssPage has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The VssPage could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
                $this->data = $this->VssPage->read(null, $id);
        }
        $pageTemplates = $this->VssPage->PageTemplate->find('list');
        $venues = $this->VssPage->Venue->find('list');
        $this->set(compact('pageTemplates','venues'));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for VssPage', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->VssPage->del($id)) {
            $this->Session->setFlash(__('VssPage deleted', true));
            $this->redirect(array('action'=>'index'));
        }
    }

}
?>
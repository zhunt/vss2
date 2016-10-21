<?php
class ChainsController extends AppController {

	var $name = 'Chains';
	var $helpers = array('Html', 'Form');

        function admin_ajax_add() {
            if ( $this->RequestHandler->isAjax() ){

                //$cityId = intval($this->params['url']['cityId']);
                $chain = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/', "'"));

                if ( empty($chain) ) {
                    $data = array('status' => 'error', 'msg' => 'Error occured');
                } else {
                    $id = $this->Chain->updateChain( $chain);

                    if ( $id != false)
                        $data = array('status' => 'ok', 'msg' => 'All good');
                    else
                        $data = array('status' => 'error', 'msg' => 'Error occured');
                }

                $chains = $this->Chain->find('list', array(
                        'order' => array('Chain.name')
                    ) );

                $this->set( compact('chains', 'data', 'id'));

            }
        }

	function admin_index() {
		$this->Chain->recursive = 0;
		$this->set('chains', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Chain.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('chain', $this->Chain->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Chain->create();
			if ($this->Chain->save($this->data)) {
				$this->Session->setFlash(__('The Chain has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Chain could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Chain', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Chain->save($this->data)) {
				$this->Session->setFlash(__('The Chain has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Chain could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Chain->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Chain', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Chain->delete($id)) {
			$this->Session->setFlash(__('Chain deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
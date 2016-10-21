<?php
class CityNeighbourhoodsController extends AppController {

	var $name = 'CityNeighbourhoods';
	var $helpers = array('Html', 'Form');

        function beforeFilter() {
            parent::beforeFilter();
            //$this->Auth->allow();
        }
        /*
         * add a neighbourhood
         */
        function admin_ajax_add() {
            if ( $this->RequestHandler->isAjax() ){

                $cityId = intval($this->params['url']['cityId']);
                $cityRegion = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/'));

                if ( $cityId < 1 || empty($cityRegion) ) {
                    $data = array('status' => 'error', 'msg' => 'Error occured');
                } else {
                    $id = $this->CityNeighbourhood->updateNeighbourhood( $cityRegion, $cityId);

                    if ( $id != false)
                        $data = array('status' => 'ok', 'msg' => 'All good');
                }

                $cityNeighbourhoods = $this->CityNeighbourhood->find('list', array('fields' =>
                        array('CityNeighbourhood.id', 'CityNeighbourhood.name', 'City.name'),
                        'recursive' => 0,
                        'order' => array('City.name', 'CityNeighbourhood.name')
                    ) );

                $this->set( compact('cityNeighbourhoods', 'data', 'id'));

            }
        }
        
	function admin_index() {
		$this->CityNeighbourhood->recursive = 0;
		$this->set('cityNeighbourhoods', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
                    $this->CityNeighbourhood->create();
                    if ($this->CityNeighbourhood->save($this->data)) {
                        $this->Session->setFlash(__('The City Neighbourhood has been saved', true));
                        $this->redirect(array('action'=>'index'));
                    } else {
                        $this->Session->setFlash(__('The City Neighbourhood could not be saved. Please, try again.', true));
                    }
		}
		$cities = $this->CityNeighbourhood->City->find('list', array('order' => 'City.name'));
		$this->set(compact('cities'));
	}



	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CityNeighbourhood', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CityNeighbourhood->save($this->data)) {
				$this->Session->setFlash(__('The CityNeighbourhood has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CityNeighbourhood could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CityNeighbourhood->read(null, $id);
		}
		$cities = $this->CityNeighbourhood->City->find('list', array('order' => 'City.name') );
		$this->set(compact('cities'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for City Neighbourhood', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CityNeighbourhood->delete($id)) {
			$this->Session->setFlash(__('City Neighbourhood deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
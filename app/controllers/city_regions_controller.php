<?php
class CityRegionsController extends AppController {

	var $name = 'CityRegions';
	var $helpers = array('Html', 'Form');
        var $components = array('RequestHandler');

        function admin_ajax_add() {
            if ( $this->RequestHandler->isAjax() ){

                //$this->layout = 'ajax';

                //debug($this->params['url']);
                $cityId = intval($this->params['url']['cityId']);
                $cityRegion = Sanitize::paranoid(trim($this->params['url']['name']), array(' ','.', '/'));

                if ( $cityId < 1 || empty($cityRegion) ) {
                    $data = array('status' => 'error', 'msg' => 'Error occured');
                } else {
                    $id = $this->CityRegion->updateCityRegion( $cityRegion, $cityId);

                    if ( $id != false)
                        $data = array('status' => 'ok', 'msg' => 'All good');
                }

                $cityRegions = $this->CityRegion->find('list', array('fields' =>
                        array('CityRegion.id', 'CityRegion.name', 'City.name'),
                        'recursive' => 0,
                        'order' => array('City.name', 'CityRegion.name')
                    ) );

                

                $this->set( compact('cityRegions', 'data', 'id'));
                //echo json_encode($data);
                //exit;
                // updateCityRegion
                
            }
        }

	


	function admin_index() {
		$this->CityRegion->recursive = 0;
		$this->set('cityRegions', $this->paginate());
	}

	function admin_add() {
            if (!empty($this->data)) {
                $this->CityRegion->create();
                if ($this->CityRegion->save($this->data)) {
                    $this->Session->setFlash('The CityRegion has been saved');
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash('The CityRegion could not be saved. Please, try again.');
                }
            }
            $cities = $this->CityRegion->City->find('list');
            $this->set(compact('cities'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CityRegion', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CityRegion->save($this->data)) {
				$this->Session->setFlash(__('The CityRegion has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CityRegion could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CityRegion->read(null, $id);
		}
		$cities = $this->CityRegion->City->find('list');
		$this->set(compact('cities'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CityRegion', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CityRegion->delete($id)) {
			$this->Session->setFlash(__('CityRegion deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
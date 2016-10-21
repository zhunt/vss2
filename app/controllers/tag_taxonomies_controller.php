<?php
class TagTaxonomiesController extends AppController {

    var $name = 'TagTaxonomies';
    var $helpers = array('Html', 'Form');

    function index() {
        $this->layout = 'admin';
        $this->TagTaxonomy->contain();

        // pseudo controller code
        /*
       $data['TagTaxonomy']['parent_id'] =  0;
        $data['TagTaxonomy']['name'] =  'Bar Types';
        $this->TagTaxonomy->save($data, false);
        $this->TagTaxonomy->create();


        $result = $this->TagTaxonomy->FindByName('Bar Types');
        $parentId = $result['TagTaxonomy']['id'];

        //debug($parentId);
        $data['TagTaxonomy']['parent_id'] =  $parentId;
        $data['TagTaxonomy']['name'] =  'Sports bar';
        $data['TagTaxonomy']['tag_id'] =  '7';
        $data['TagTaxonomy']['taxonomy'] =  'bar_types';
        $this->TagTaxonomy->save($data, false);
        $this->TagTaxonomy->create();

        $data['TagTaxonomy']['parent_id'] =  $parentId;
        $data['TagTaxonomy']['name'] =  'Lounge';
        $data['TagTaxonomy']['tag_id'] =  '8';
        $data['TagTaxonomy']['taxonomy'] =  'bar_types';
        $this->TagTaxonomy->save($data, false);
        $this->TagTaxonomy->create();

        $data['TagTaxonomy']['parent_id'] =  $parentId;
        $data['TagTaxonomy']['name'] =  'Jazz bar';
        $data['TagTaxonomy']['tag_id'] =  '9';
        $data['TagTaxonomy']['taxonomy'] =  'bar_types';
        $this->TagTaxonomy->save($data, false);
        $this->TagTaxonomy->create();
*/
/*
       $data['TagTaxonomy']['parent_id'] =  0;
        $data['TagTaxonomy']['name'] =  'New Cat';
        $this->TagTaxonomy->save($data, false);
        //$result = $this->TagTaxonomy->FindByName('New Cat');
        //$parentId = $result['TagTaxonomy']['id'];

        $this->TagTaxonomy->create();
        $this->TagTaxonomy->id = 3; // id of bacon
        $newParentId = $this->TagTaxonomy->field('id', array('name' => 'New Cat'));
        $this->TagTaxonomy->save(array('parent_id' => $newParentId), false);
*/
        // tag_id 	taxonomy

       /* $totalChildren = $this->TagTaxonomy->childCount(6);
        debug($totalChildren);
        $totalChildren = $this->TagTaxonomy->childCount(10);
        debug($totalChildren);
        $totalChildren = $this->TagTaxonomy->childCount(3);


        $children = $this->TagTaxonomy->children(6);
        debug($children);
*/

        //$this->TagTaxonomy->id = null;
        //$this->TagTaxonomy->reorder( array('field' => 'TagTaxonomy.name', 'order' => 'ASC', 'verify' => false, 'id' => 6) );
        
        //$this->data = $this->TagTaxonomy->generatetreelist(null, null, null, '&nbsp;&nbsp;&nbsp;');
        debug ($this->data);
        //exit();
        //debug($this->TagTaxonomy->Tag->find('list') ); // $parentTags
       /* debug( $this->TagTaxonomy->find('all', array('conditions' => array(
                'TagTaxonomy.taxonomy' => 'test',
                'TagTaxonomy.parent_id' => 0
        )) ) );


        */
       // exit;



        //$this->set('tagTaxonomies', $this->paginate());
    }

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TagTaxonomy.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tagTaxonomy', $this->TagTaxonomy->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TagTaxonomy->create();
			if ($this->TagTaxonomy->save($this->data)) {
				$this->Session->setFlash(__('The TagTaxonomy has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TagTaxonomy could not be saved. Please, try again.', true));
			}
		}
		$tags = $this->TagTaxonomy->Tag->find('list');
		$parentTags = $this->TagTaxonomy->ParentTag->find('list');
		$this->set(compact('tags', 'parentTags'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TagTaxonomy', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TagTaxonomy->save($this->data)) {
				$this->Session->setFlash(__('The TagTaxonomy has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TagTaxonomy could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TagTaxonomy->read(null, $id);
		}
		$tags = $this->TagTaxonomy->Tag->find('list');
		$parentTags = $this->TagTaxonomy->ParentTag->find('list');
		$this->set(compact('tags','parentTags'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TagTaxonomy', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TagTaxonomy->del($id)) {
			$this->Session->setFlash(__('TagTaxonomy deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
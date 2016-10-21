<?php
class VenueDetailsController extends AppController {

	var $name = 'VenueDetails';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->VenueDetail->recursive = 0;
		$this->set('venueDetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueDetail.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueDetail', $this->VenueDetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->VenueDetail->create();
			if ($this->VenueDetail->save($this->data)) {
				$this->Session->setFlash(__('The VenueDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueDetail could not be saved. Please, try again.', true));
			}
		}
		$venues = $this->VenueDetail->Venue->find('list');
		$venueCuisineType2s = $this->VenueDetail->VenueCuisineType2->find('list');
		$venueCuisineType3s = $this->VenueDetail->VenueCuisineType3->find('list');
		$venueCuisineType4s = $this->VenueDetail->VenueCuisineType4->find('list');
		$venueBarType2s = $this->VenueDetail->VenueBarType2->find('list');
		$venueCafeType2s = $this->VenueDetail->VenueCafeType2->find('list');
		$venueCaterType2s = $this->VenueDetail->VenueCaterType2->find('list');
		$venueHotelType2s = $this->VenueDetail->VenueHotelType2->find('list');
		$venueAttractionType2s = $this->VenueDetail->VenueAttractionType2->find('list');
		$venueFeature1s = $this->VenueDetail->VenueFeature1->find('list');
		$venueFeature2s = $this->VenueDetail->VenueFeature2->find('list');
		$venueFeature3s = $this->VenueDetail->VenueFeature3->find('list');
		$venueFeature4s = $this->VenueDetail->VenueFeature4->find('list');
		$venueFeature5s = $this->VenueDetail->VenueFeature5->find('list');
		$venueAmenity1s = $this->VenueDetail->VenueAmenity1->find('list');
		$venueAmenity2s = $this->VenueDetail->VenueAmenity2->find('list');
		$venueAmenity3s = $this->VenueDetail->VenueAmenity3->find('list');
		$venueAmenity4s = $this->VenueDetail->VenueAmenity4->find('list');
		$venueAmenity5s = $this->VenueDetail->VenueAmenity5->find('list');
		$this->set(compact('venues', 'venueCuisineType2s', 'venueCuisineType3s', 'venueCuisineType4s', 'venueBarType2s', 'venueCafeType2s', 'venueCaterType2s', 'venueHotelType2s', 'venueAttractionType2s', 'venueFeature1s', 'venueFeature2s', 'venueFeature3s', 'venueFeature4s', 'venueFeature5s', 'venueAmenity1s', 'venueAmenity2s', 'venueAmenity3s', 'venueAmenity4s', 'venueAmenity5s'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueDetail->save($this->data)) {
				$this->Session->setFlash(__('The VenueDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueDetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueDetail->read(null, $id);
		}
		$venues = $this->VenueDetail->Venue->find('list');
		$venueCuisineType2s = $this->VenueDetail->VenueCuisineType2->find('list');
		$venueCuisineType3s = $this->VenueDetail->VenueCuisineType3->find('list');
		$venueCuisineType4s = $this->VenueDetail->VenueCuisineType4->find('list');
		$venueBarType2s = $this->VenueDetail->VenueBarType2->find('list');
		$venueCafeType2s = $this->VenueDetail->VenueCafeType2->find('list');
		$venueCaterType2s = $this->VenueDetail->VenueCaterType2->find('list');
		$venueHotelType2s = $this->VenueDetail->VenueHotelType2->find('list');
		$venueAttractionType2s = $this->VenueDetail->VenueAttractionType2->find('list');
		$venueFeature1s = $this->VenueDetail->VenueFeature1->find('list');
		$venueFeature2s = $this->VenueDetail->VenueFeature2->find('list');
		$venueFeature3s = $this->VenueDetail->VenueFeature3->find('list');
		$venueFeature4s = $this->VenueDetail->VenueFeature4->find('list');
		$venueFeature5s = $this->VenueDetail->VenueFeature5->find('list');
		$venueAmenity1s = $this->VenueDetail->VenueAmenity1->find('list');
		$venueAmenity2s = $this->VenueDetail->VenueAmenity2->find('list');
		$venueAmenity3s = $this->VenueDetail->VenueAmenity3->find('list');
		$venueAmenity4s = $this->VenueDetail->VenueAmenity4->find('list');
		$venueAmenity5s = $this->VenueDetail->VenueAmenity5->find('list');
		$this->set(compact('venues','venueCuisineType2s','venueCuisineType3s','venueCuisineType4s','venueBarType2s','venueCafeType2s','venueCaterType2s','venueHotelType2s','venueAttractionType2s','venueFeature1s','venueFeature2s','venueFeature3s','venueFeature4s','venueFeature5s','venueAmenity1s','venueAmenity2s','venueAmenity3s','venueAmenity4s','venueAmenity5s'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueDetail->del($id)) {
			$this->Session->setFlash(__('VenueDetail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->VenueDetail->recursive = 0;
		$this->set('venueDetails', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid VenueDetail.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('venueDetail', $this->VenueDetail->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->VenueDetail->create();
			if ($this->VenueDetail->save($this->data)) {
				$this->Session->setFlash(__('The VenueDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueDetail could not be saved. Please, try again.', true));
			}
		}
		$venues = $this->VenueDetail->Venue->find('list');
		$venueCuisineType2s = $this->VenueDetail->VenueCuisineType2->find('list');
		$venueCuisineType3s = $this->VenueDetail->VenueCuisineType3->find('list');
		$venueCuisineType4s = $this->VenueDetail->VenueCuisineType4->find('list');
		$venueBarType2s = $this->VenueDetail->VenueBarType2->find('list');
		$venueCafeType2s = $this->VenueDetail->VenueCafeType2->find('list');
		$venueCaterType2s = $this->VenueDetail->VenueCaterType2->find('list');
		$venueHotelType2s = $this->VenueDetail->VenueHotelType2->find('list');
		$venueAttractionType2s = $this->VenueDetail->VenueAttractionType2->find('list');
		$venueFeature1s = $this->VenueDetail->VenueFeature1->find('list');
		$venueFeature2s = $this->VenueDetail->VenueFeature2->find('list');
		$venueFeature3s = $this->VenueDetail->VenueFeature3->find('list');
		$venueFeature4s = $this->VenueDetail->VenueFeature4->find('list');
		$venueFeature5s = $this->VenueDetail->VenueFeature5->find('list');
		$venueAmenity1s = $this->VenueDetail->VenueAmenity1->find('list');
		$venueAmenity2s = $this->VenueDetail->VenueAmenity2->find('list');
		$venueAmenity3s = $this->VenueDetail->VenueAmenity3->find('list');
		$venueAmenity4s = $this->VenueDetail->VenueAmenity4->find('list');
		$venueAmenity5s = $this->VenueDetail->VenueAmenity5->find('list');
		$this->set(compact('venues', 'venueCuisineType2s', 'venueCuisineType3s', 'venueCuisineType4s', 'venueBarType2s', 'venueCafeType2s', 'venueCaterType2s', 'venueHotelType2s', 'venueAttractionType2s', 'venueFeature1s', 'venueFeature2s', 'venueFeature3s', 'venueFeature4s', 'venueFeature5s', 'venueAmenity1s', 'venueAmenity2s', 'venueAmenity3s', 'venueAmenity4s', 'venueAmenity5s'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid VenueDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->VenueDetail->save($this->data)) {
				$this->Session->setFlash(__('The VenueDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The VenueDetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->VenueDetail->read(null, $id);
		}
		$venues = $this->VenueDetail->Venue->find('list');
		$venueCuisineType2s = $this->VenueDetail->VenueCuisineType2->find('list');
		$venueCuisineType3s = $this->VenueDetail->VenueCuisineType3->find('list');
		$venueCuisineType4s = $this->VenueDetail->VenueCuisineType4->find('list');
		$venueBarType2s = $this->VenueDetail->VenueBarType2->find('list');
		$venueCafeType2s = $this->VenueDetail->VenueCafeType2->find('list');
		$venueCaterType2s = $this->VenueDetail->VenueCaterType2->find('list');
		$venueHotelType2s = $this->VenueDetail->VenueHotelType2->find('list');
		$venueAttractionType2s = $this->VenueDetail->VenueAttractionType2->find('list');
		$venueFeature1s = $this->VenueDetail->VenueFeature1->find('list');
		$venueFeature2s = $this->VenueDetail->VenueFeature2->find('list');
		$venueFeature3s = $this->VenueDetail->VenueFeature3->find('list');
		$venueFeature4s = $this->VenueDetail->VenueFeature4->find('list');
		$venueFeature5s = $this->VenueDetail->VenueFeature5->find('list');
		$venueAmenity1s = $this->VenueDetail->VenueAmenity1->find('list');
		$venueAmenity2s = $this->VenueDetail->VenueAmenity2->find('list');
		$venueAmenity3s = $this->VenueDetail->VenueAmenity3->find('list');
		$venueAmenity4s = $this->VenueDetail->VenueAmenity4->find('list');
		$venueAmenity5s = $this->VenueDetail->VenueAmenity5->find('list');
		$this->set(compact('venues','venueCuisineType2s','venueCuisineType3s','venueCuisineType4s','venueBarType2s','venueCafeType2s','venueCaterType2s','venueHotelType2s','venueAttractionType2s','venueFeature1s','venueFeature2s','venueFeature3s','venueFeature4s','venueFeature5s','venueAmenity1s','venueAmenity2s','venueAmenity3s','venueAmenity4s','venueAmenity5s'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for VenueDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->VenueDetail->del($id)) {
			$this->Session->setFlash(__('VenueDetail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
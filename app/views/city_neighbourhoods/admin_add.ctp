<div class="cityNeighbourhoods form">
<?php echo $form->create('CityNeighbourhood');?>
	<fieldset>
 		<legend><?php __('Add CityNeighbourhood');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('slug');
		echo $form->input('city_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CityNeighbourhoods', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Cities', true), array('controller'=> 'cities', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller'=> 'cities', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>

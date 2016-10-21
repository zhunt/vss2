<div class="cityNeighbourhoods form">
<?php echo $form->create('CityNeighbourhood');?>
	<fieldset>
 		<legend><?php __('Edit CityNeighbourhood');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('slug');
		echo $form->input('city_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('CityNeighbourhood.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('CityNeighbourhood.id'))); ?></li>
		<li><?php echo $html->link(__('List CityNeighbourhoods', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Cities', true), array('controller'=> 'cities', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller'=> 'cities', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>

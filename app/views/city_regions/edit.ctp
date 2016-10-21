<div class="cityRegions form">
<?php echo $form->create('CityRegion');?>
	<fieldset>
 		<legend><?php __('Edit CityRegion');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('url');
		echo $form->input('city_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('CityRegion.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('CityRegion.id'))); ?></li>
		<li><?php echo $html->link(__('List CityRegions', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Cities', true), array('controller'=> 'cities', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller'=> 'cities', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>

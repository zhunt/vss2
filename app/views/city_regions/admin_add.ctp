<div class="cityRegions form">
<?php echo $form->create('CityRegion');?>
	<fieldset>
 		<legend><?php __('Add CityRegion');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('postfix_field');
		//echo $form->input('slug');
		echo $form->input('city_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CityRegions', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Cities', true), array('controller'=> 'cities', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller'=> 'cities', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>

<div class="cities form">
<?php echo $form->create('City');?>
	<fieldset>
 		<legend><?php __('Add City');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('url');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Cities', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List City Regions', true), array('controller'=> 'city_regions', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City Region', true), array('controller'=> 'city_regions', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Intersections', true), array('controller'=> 'intersections', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Intersection', true), array('controller'=> 'intersections', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>

<div class="cities form">
<?php echo $form->create('City');?>
	<fieldset>
 		<legend>Add City</legend>
	<?php
		echo $form->input('name');
		echo $form->input('slug');
		echo $form->input('venue_count');
		echo $form->input('region_id');
		echo $form->input('locality');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Cities', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List City Neighbourhoods', true), array('controller'=> 'city_neighbourhoods', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City Neighbourhood', true), array('controller'=> 'city_neighbourhoods', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List City Regions', true), array('controller'=> 'city_regions', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City Region', true), array('controller'=> 'city_regions', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Intersections', true), array('controller'=> 'intersections', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Intersection', true), array('controller'=> 'intersections', 'action'=>'add')); ?> </li>
	</ul>
</div>

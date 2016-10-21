<div class="intersections form">
<?php echo $form->create('Intersection');?>
	<fieldset>
 		<legend><?php __('Add Intersection');?></legend>
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
		<li><?php echo $html->link(__('List Intersections', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Cities', true), array('controller'=> 'cities', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller'=> 'cities', 'action'=>'add')); ?> </li>
	</ul>
</div>
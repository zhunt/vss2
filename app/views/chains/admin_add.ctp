<div class="chains form">
<?php echo $form->create('Chain');?>
	<fieldset>
 		<legend><?php __('Add Chain');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('slug');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Chains', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>

<div class="chains form">
<?php echo $form->create('Chain');?>
	<fieldset>
 		<legend><?php __('Edit Chain');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('slug');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Chain.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Chain.id'))); ?></li>
		<li><?php echo $html->link(__('List Chains', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>
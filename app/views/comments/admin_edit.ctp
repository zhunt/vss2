<div class="comments form">
<?php echo $form->create('Comment');?>
	<fieldset>
 		<legend>Edit Comment</legend>
	<?php
		echo $form->input('id');
		echo $form->input('venue_id');
		echo $form->input('author');
		echo $form->input('author_email');
		echo $form->input('author_url');
		echo $form->input('author_ip');
		echo $form->input('comment_agent');
		echo $form->input('comment');
		echo $form->input('date_approved');
		echo $form->input('karma');
		
		echo $form->input('comment_status_id');
		echo $form->input('flag_front_page'); 
		echo $form->input('Comment.' . Configure::read('checkfield_1') , array('value' => Configure::read('demambo1'), 'style' => 'display: none', 'label' => false ) );
		echo $form->input('Comment.' . Configure::read('checkfield_2'), array('value' => Configure::read('demambo2'), 'style' => 'display: none', 'label' => false ) );
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Comment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Comment.id'))); ?></li>
	</ul>
</div>

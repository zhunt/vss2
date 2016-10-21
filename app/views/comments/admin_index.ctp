<div class="comments index">
<h2>Comments</h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table class="admin_listview">
<tr>
	<th><?php echo $paginator->sort('venue_id');?></th>
	<th><?php echo $paginator->sort('author');?></th>
	<th><?php echo $paginator->sort('author_email');?></th>
	
	
	
	<th><?php echo $paginator->sort('comment');?></th>
	<th><?php echo $paginator->sort('comment_status_id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('date_approved');?></th>
	<th class="actions">Actions</th>
</tr>
<?php
$i = 0;
foreach ($comments as $comment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		
		<td>
			<?php echo $html->link($comment['Venue']['name'], array('controller'=> 'comments', 'action'=>'edit', $comment['Comment']['id'])); ?>
		</td>
		<td>
			<?php echo $comment['Comment']['author']; ?>
		</td>
		<td>
			<?php echo $comment['Comment']['author_email']; ?>
		</td>
		
		
		
		<td>
			<?php echo $this->Text->truncate($comment['Comment']['comment'],30); ?>
		</td>
		
	
		<td>
			<?php echo $html->link($comment['CommentStatus']['name'], array('controller'=> 'comment_statuses', 'action'=>'view', $comment['CommentStatus']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Time->format( Configure::read('Time.format_day_time'), $comment['Comment']['created']); ?>
		</td>
		<td>
			<?php echo $this->Time->format( Configure::read('Time.format_short'), $comment['Comment']['date_approved']); ?>
		</td>
		<td class="actions">
			<?php echo $html->link('Delete', array('action'=>'delete', $comment['Comment']['id']), null, sprintf(
			'Are you sure you want to delete # %s?', $comment['Comment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

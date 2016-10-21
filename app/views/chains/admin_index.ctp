<div class="chains index">
<h2><?php __('Chains');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0" class="admin_listview">
<tr>
	
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('slug');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($chains as $chain):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?> >
		<td>
			<?php echo $this->Html->link($chain['Chain']['name'], array('action' => 'edit', $chain['Chain']['id'] ) ); ?>
		</td>
		<td>
			<?php echo $chain['Chain']['slug']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $chain['Chain']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $chain['Chain']['id'])); ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Chain', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>
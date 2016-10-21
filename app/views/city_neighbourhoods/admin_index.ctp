<div class="cityNeighbourhoods index">
<h2><?php __('CityNeighbourhoods');?></h2>
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
	<th><?php echo $paginator->sort('city_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($cityNeighbourhoods as $cityNeighbourhood):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($cityNeighbourhood['CityNeighbourhood']['name'], array('action' => 'edit', $cityNeighbourhood['CityNeighbourhood']['id'] ) ); ?>
		</td>
		<td>
			<?php echo $cityNeighbourhood['CityNeighbourhood']['slug']; ?>
		</td>
		<td>
			<?php echo $html->link($cityNeighbourhood['City']['name'], array('controller'=> 'cities', 'action'=>'view', $cityNeighbourhood['City']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $cityNeighbourhood['CityNeighbourhood']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $cityNeighbourhood['CityNeighbourhood']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $cityNeighbourhood['CityNeighbourhood']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cityNeighbourhood['CityNeighbourhood']['id'])); ?>
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
		<li><?php echo $html->link(__('New City Neighbourhood', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Cities', true), array('controller'=> 'cities', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller'=> 'cities', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>

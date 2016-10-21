<div class="cities index">
<h2>Cities</h2>
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
	<th><?php echo $paginator->sort('venue_count');?></th>
	<th><?php echo $paginator->sort('region');?></th>
	<th><?php echo $paginator->sort('locality');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($cities as $city):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>

		<td>
			<?php echo $this->Html->link( $city['City']['name'], array('action' => 'edit', $city['City']['id'] ) ); ?>
		</td>
		<td>
			<?php echo $city['City']['slug']; ?>
		</td>
		<td>
			<?php echo $city['City']['venue_count']; ?>
		</td>
		<td>
			<?php echo $this->Text->truncate($city['Region']['name']);//$city['City']['region_id']; ?>
		</td>
		<td>
			<?php echo $city['City']['locality']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $city['City']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $city['City']['id'])); ?>
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
		<li><?php echo $html->link(__('New City', true), array('action'=>'add')); ?></li>
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

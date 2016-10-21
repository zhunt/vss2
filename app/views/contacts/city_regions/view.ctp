<div class="cityRegions view">
<h2><?php  __('CityRegion');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cityRegion['CityRegion']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cityRegion['CityRegion']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cityRegion['CityRegion']['slug']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($cityRegion['City']['name'], array('controller'=> 'cities', 'action'=>'view', $cityRegion['City']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CityRegion', true), array('action'=>'edit', $cityRegion['CityRegion']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CityRegion', true), array('action'=>'delete', $cityRegion['CityRegion']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cityRegion['CityRegion']['id'])); ?> </li>
		<li><?php echo $html->link(__('List CityRegions', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New CityRegion', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Cities', true), array('controller'=> 'cities', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller'=> 'cities', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Venues');?></h3>
	<?php if (!empty($cityRegion['Venue'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Slug'); ?></th>
		<th><?php __('Sub Name'); ?></th>
		<th><?php __('Address'); ?></th>
		<th><?php __('Geo Lat'); ?></th>
		<th><?php __('Geo Lng'); ?></th>
		<th><?php __('Phone'); ?></th>
		<th><?php __('Region Id'); ?></th>
		<th><?php __('City Id'); ?></th>
		<th><?php __('City Region Id'); ?></th>
		<th><?php __('City Neighbourhood Id'); ?></th>
		<th><?php __('Intersection Id'); ?></th>
		<th><?php __('Publish State Id'); ?></th>
		<th><?php __('Chain Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($cityRegion['Venue'] as $venue):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $venue['id'];?></td>
			<td><?php echo $venue['name'];?></td>
			<td><?php echo $venue['slug'];?></td>
			<td><?php echo $venue['sub_name'];?></td>
			<td><?php echo $venue['address'];?></td>
			<td><?php echo $venue['geo_lat'];?></td>
			<td><?php echo $venue['geo_lng'];?></td>
			<td><?php echo $venue['phone'];?></td>
			<td><?php echo $venue['region_id'];?></td>
			<td><?php echo $venue['city_id'];?></td>
			<td><?php echo $venue['city_region_id'];?></td>
			<td><?php echo $venue['city_neighbourhood_id'];?></td>
			<td><?php echo $venue['intersection_id'];?></td>
			<td><?php echo $venue['publish_state_id'];?></td>
			<td><?php echo $venue['chain_id'];?></td>
			<td><?php echo $venue['created'];?></td>
			<td><?php echo $venue['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'venues', 'action'=>'view', $venue['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'venues', 'action'=>'edit', $venue['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'venues', 'action'=>'delete', $venue['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $venue['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>

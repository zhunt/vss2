<div class="cities view">
<h2><?php  __('City');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $city['City']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $city['City']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $city['City']['url']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit City', true), array('action'=>'edit', $city['City']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete City', true), array('action'=>'delete', $city['City']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $city['City']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Cities', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List City Regions', true), array('controller'=> 'city_regions', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City Region', true), array('controller'=> 'city_regions', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Intersections', true), array('controller'=> 'intersections', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Intersection', true), array('controller'=> 'intersections', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related City Regions');?></h3>
	<?php if (!empty($city['CityRegion'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('City Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($city['CityRegion'] as $cityRegion):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $cityRegion['id'];?></td>
			<td><?php echo $cityRegion['name'];?></td>
			<td><?php echo $cityRegion['url'];?></td>
			<td><?php echo $cityRegion['city_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'city_regions', 'action'=>'view', $cityRegion['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'city_regions', 'action'=>'edit', $cityRegion['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'city_regions', 'action'=>'delete', $cityRegion['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cityRegion['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New City Region', true), array('controller'=> 'city_regions', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Intersections');?></h3>
	<?php if (!empty($city['Intersection'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('City Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($city['Intersection'] as $intersection):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $intersection['id'];?></td>
			<td><?php echo $intersection['name'];?></td>
			<td><?php echo $intersection['url'];?></td>
			<td><?php echo $intersection['city_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'intersections', 'action'=>'view', $intersection['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'intersections', 'action'=>'edit', $intersection['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'intersections', 'action'=>'delete', $intersection['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $intersection['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Intersection', true), array('controller'=> 'intersections', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Venues');?></h3>
	<?php if (!empty($city['Venue'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Subname'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('Address'); ?></th>
		<th><?php __('Phone'); ?></th>
		<th><?php __('City Id'); ?></th>
		<th><?php __('City Region Id'); ?></th>
		<th><?php __('Inside Venue Id'); ?></th>
		<th><?php __('Venue Type Id'); ?></th>
		<th><?php __('Venue Cuisine Type Id'); ?></th>
		<th><?php __('Venue Bar Type Id'); ?></th>
		<th><?php __('Venue Cafe Type Id'); ?></th>
		<th><?php __('Venue Cater Type Id'); ?></th>
		<th><?php __('Venue Hotel Type Id'); ?></th>
		<th><?php __('Venue Attraction Type Id'); ?></th>
		<th><?php __('Venue Chain Id'); ?></th>
		<th><?php __('Intersection Id'); ?></th>
		<th><?php __('Client Type Id'); ?></th>
		<th><?php __('Flag Published'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($city['Venue'] as $venue):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $venue['id'];?></td>
			<td><?php echo $venue['name'];?></td>
			<td><?php echo $venue['subname'];?></td>
			<td><?php echo $venue['url'];?></td>
			<td><?php echo $venue['address'];?></td>
			<td><?php echo $venue['phone'];?></td>
			<td><?php echo $venue['city_id'];?></td>
			<td><?php echo $venue['city_region_id'];?></td>
			<td><?php echo $venue['inside_venue_id'];?></td>
			<td><?php echo $venue['venue_type_id'];?></td>
			<td><?php echo $venue['venue_cuisine_type_id'];?></td>
			<td><?php echo $venue['venue_bar_type_id'];?></td>
			<td><?php echo $venue['venue_cafe_type_id'];?></td>
			<td><?php echo $venue['venue_cater_type_id'];?></td>
			<td><?php echo $venue['venue_hotel_type_id'];?></td>
			<td><?php echo $venue['venue_attraction_type_id'];?></td>
			<td><?php echo $venue['venue_chain_id'];?></td>
			<td><?php echo $venue['intersection_id'];?></td>
			<td><?php echo $venue['client_type_id'];?></td>
			<td><?php echo $venue['flag_published'];?></td>
			<td><?php echo $venue['created'];?></td>
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

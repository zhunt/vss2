<div class="cityNeighbourhoods view">
<h2><?php  __('CityNeighbourhood');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cityNeighbourhood['CityNeighbourhood']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cityNeighbourhood['CityNeighbourhood']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cityNeighbourhood['CityNeighbourhood']['slug']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($cityNeighbourhood['City']['name'], array('controller'=> 'cities', 'action'=>'view', $cityNeighbourhood['City']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CityNeighbourhood', true), array('action'=>'edit', $cityNeighbourhood['CityNeighbourhood']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CityNeighbourhood', true), array('action'=>'delete', $cityNeighbourhood['CityNeighbourhood']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cityNeighbourhood['CityNeighbourhood']['id'])); ?> </li>
		<li><?php echo $html->link(__('List CityNeighbourhoods', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New CityNeighbourhood', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Cities', true), array('controller'=> 'cities', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller'=> 'cities', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Venues', true), array('controller'=> 'venues', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Venue', true), array('controller'=> 'venues', 'action'=>'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php  __('Related Venues');?></h3>
	<?php if (!empty($cityNeighbourhood['Venue'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['name'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Slug');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['slug'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sub Name');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['sub_name'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['address'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Geo Lat');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['geo_lat'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Geo Lng');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['geo_lng'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['phone'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Region Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['region_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['city_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City Region Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['city_region_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City Neighbourhood Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['city_neighbourhood_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Intersection Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['intersection_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Publish State Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['publish_state_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Chain Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['chain_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $cityNeighbourhood['Venue']['modified'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $html->link(__('Edit Venue', true), array('controller'=> 'venues', 'action'=>'edit', $cityNeighbourhood['Venue']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php __('Related Venues');?></h3>
	<?php if (!empty($cityNeighbourhood['Venue'])):?>
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
		foreach ($cityNeighbourhood['Venue'] as $venue):
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

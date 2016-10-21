
	<div id="lnav_accordion">
		<h3><a href="#leftnav_venues">Venues</a></h3>
		<div>
			<ul>
				<li><?php echo $html->link('New Venue', array('action'=>'add')); ?></li>
				<li><?php echo $html->link('List Cities', array('controller'=> 'cities', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New City', array('controller'=> 'cities', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List City Regions', array('controller'=> 'city_regions', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New City Region', array('controller'=> 'city_regions', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List City Neighbourhoods', array('controller'=> 'city_neighbourhoods', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New City Neighbourhood', array('controller'=> 'city_neighbourhoods', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List Publish States', array('controller'=> 'publish_states', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New Publish State', array('controller'=> 'publish_states', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List Chains', array('controller'=> 'chains', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New Chain', array('controller'=> 'chains', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List Restaurant Hours', array('controller'=> 'restaurant_hours', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New Restaurant Hour', array('controller'=> 'restaurant_hours', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List Venue Details', array('controller'=> 'venue_details', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New Venue Detail', array('controller'=> 'venue_details', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List Comments', array('controller'=> 'comments', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New Comment', array('controller'=> 'comments', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List Pages', array('controller'=> 'pages', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New Page', array('controller'=> 'pages', 'action'=>'add')); ?> </li>
				<li><?php echo $html->link('List Tag Relationships', array('controller'=> 'tag_relationships', 'action'=>'index')); ?> </li>
				<li><?php echo $html->link('New Tag Relationship', array('controller'=> 'tag_relationships', 'action'=>'add')); ?> </li>
			</ul>
		</div>
		<h3><a href="#leftnav_tags">tag managment?</a></h3>
		<div>
			<ul>
				<li><?php echo $html->link('Location Tags', array('controller' => 'cities', 'action' => 'index') ) ?></li>
			</ul>
		</div>	
		<h3><a href="#leftnav_locations">Locations</a></h3>
		<div>
			<p>
			Location menu items go here. Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
			ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
			amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
			odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
			</p>
		</div>				
	</div>
	
<script type="text/javascript">
<?php $html->scriptStart(array('inline' => false)); ?>
	$(function() {
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		$("#lnav_accordion").accordion({
			icons: icons,
			navigation: true
		});
		$("#toggle").button().toggle(function() {
			$("#lnav_accordion").accordion("option", "icons", false);
		}, function() {
			$("#lnav_accordion").accordion("option", "icons", icons);
		});
	});
<?php $html->scriptEnd();?>	
</script>	

<script type="text/javascript">
<?php 
// add button styles to #admin-content area
$html->scriptStart(array('inline' => false)); ?>
$(function() {
	$("button, input:submit, a.button-link", "#admin-content").button();
});
<?php $html->scriptEnd();?>
</script>
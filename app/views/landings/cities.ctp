<?php $this->set('title_for_layout', 'List of Store Types by City' . ' | ' . Configure::read('Vcc.site_tagline') ); ?>

<div class="clear">&nbsp;</div>
<div class="grid_9">

<h2 class="extra_margin">List of Store Types by City</h2>

<div style="margin-left:-10px;">	
<script type="text/javascript"><!--
google_ad_client = "pub-5569648086666006"; //728x90, created 5/14/10
google_ad_slot = "6823141327";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>

<?php 
	foreach($cities as $city) {
		echo '<h2 class="hilight">' . $this->Html->link($city['name'], '/searches/city:' . $city['slug'] ) . '</h2>';
		
		echo '<ul class="venue_types_list">';
		foreach($city['venues'] as $venueType) { 
			echo '<li>';
				echo $this->Html->link($venueType['name'], '/searches/city:' . $city['slug'] .'/venue_type:' . $venueType['slug']);
				echo ' (' . $venueType['count'] . ')';
				
				if ( !empty($venueType['subtypes']) ) {
					echo '<ul class="venue_subtypes_list">';
					foreach($venueType['subtypes'] as $subType) {
						echo '<li >';
						echo $this->Html->link($subType['name'], '/searches/city:' . $city['slug'] .'/venue_subtype:' . $subType['slug']);
						echo ' (' . $subType['count'] . ')';
						echo '</li>';
					}
					echo '</ul>';
				}
			echo '</li>';	
		}
		echo '</ul>';
	}
?>

<div style="margin-left:-10px;">
<script type="text/javascript"><!--
google_ad_client = "pub-5569648086666006"; // 728x90, created 5/14/10
google_ad_slot = "6823141327";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
</div>

</div>
<div class="grid_3">
        <?php
        // visitor favourites
        echo $this->element('best_rated_venues_list', array('num' => 10), array('cache' =>
                array('key' => 'home_page-highrated_venues', 'time' => '+1 month') )
                )
           ?>
</div>
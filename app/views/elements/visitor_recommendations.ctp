<?php 
$viewerComments = $this->requestAction('profiles/visitor_recommendations/num:' . $num );
if ( isset( $viewerComments )): ?>
<ul >
	<?php 
	foreach( $viewerComments as $row): 
	?>
	<li style="border-bottom:1px solid #747474; color: #747474; padding-bottom:5px;">
		<div class="textblock">
			<strong>On <?php echo $time->format('dS M, Y', $row['VenueComment']['created'] ) ?> 
					<span class="grey1"><?php echo $row['VenueComment']['author'] ?></span> said:</strong>
					<br/>
			<span style="font-size:1.1em; font-style:italic; " class="grey1"><?php echo $text->truncate( $row['VenueComment']['comment'], 250) ?></span>
			
			
			<div style="text-align:right;" class="prefix_3 grid_5">
			... about <strong><?php echo $html->link( $row['Venue']['name'], "/{$row['Venue']['slug']}" ) ?></strong> 
			</div>
		</div>
		<div class="clear">&nbsp;</div> 
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
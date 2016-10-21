<?php if ( isset( $venueComments) && !empty($venueComments) ): ?>
<table id="reader_comments">
<tr>
	<th colspan="1">
	Reader Recomendations:
	</th>
<?php 
	$i = 0;
	foreach( $venueComments as $row ): 
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="blue6_bg"';
	}	
	?>
<tr <?php echo $class ?> >
	
	<td style="padding-bottom:10px; margin-top:10px;">
		
		<strong><?php echo $row['VenueComment']['author'] ?></strong>, 
		<span class="small_txt grey3"><?php echo $time->format('dS M, Y', $row['VenueComment']['created'] ) ?></span><br/>
		<hr style="margin: 0px; padding:0px; color: #995E26; border:none;"/>
		<?php echo $text->truncate( $row['VenueComment']['comment'], 250); ?>
		
	</td>
</tr>	
<?php endforeach; ?>
</table>
<?php else: ?>
	<p><strong>No Recommendations yet - <a href="#" class="recommend_link" title="Write a recommendation">Be the first!</a></strong></p>
<?php endif; ?>



<?php 
$popularListings = $this->requestAction('profiles/popular_listings/num:5');
if (isset($popularListings) ): ?>
<ul style="list-style:none; margin-top: -9px;">
	<?php foreach($popularListings as $row): ?>
	<li >
		<h3><?php echo $html->link( $text->truncate($row['Venue']['name'] . ' '.$row['Venue']['subname'],22), "/{$row['Venue']['slug']}" ); ?></h3><br/>
		<span class="textblock grey1" style="margin-top:5px; display: block;"><?php echo $row['Venue']['address'] . ', ' . $row['City']['name']  ?>
		<br />
		
			<ul class="star-rating small-star">
			<li class="current-rating" style="width: <?php printf( '%d', ($row['VenueRating']['score'] / 5.0) * 100 ) ?>%"></li>
			<li class="one-star">&nbsp;</li>
			<li class="two-stars">&nbsp;</li>
			<li class="three-stars">&nbsp;</li>
			<li class="four-stars">&nbsp;</li>
			<li class="five-stars">&nbsp;</li>
			</ul>
		
		
		</span>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif?>		
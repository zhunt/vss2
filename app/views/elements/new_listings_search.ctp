<?php 

$venueType = '';
if ( isset($venueTypeId) )
	$venueType = '/venueTypeId:' . $venueTypeId;
	
// not currently implemented on controller side	
$cityName = '';
if ( isset($city) )
	$cityName = '/city:' . $city;	
	

$num = 0;
if ( isset($numListings) )
	$num = $numListings;	

$newListings = $this->requestAction('profiles/newest_listings/num:' . $num . $venueType . $cityName );
if (isset($newListings) ): ?>
<ul style="list-style:none; margin-top: -9px;">
	<?php foreach($newListings as $row): ?>
	<li >
		<h3><?php echo $html->link( $text->truncate($row['Venue']['name'] . ' '.$row['Venue']['subname'],22), "/{$row['Venue']['slug']}", array('class' => 'grey1') ); ?></h3><br/>
		<span class="textblock grey1"><?php echo $row['Venue']['address'] . ', ' . $row['City']['name']  ?></span><br />
		<span class="grey3 small_txt"><?php echo $time->format('jS M, Y', $row['Venue']['created']) ?></span>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif?>

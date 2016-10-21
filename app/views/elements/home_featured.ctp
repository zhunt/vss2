<?php 
$counter = 0;
$numVenues = count($featuredVenues);
foreach ($featuredVenues as $venue):  $counter++; //debug($venue); //exit;?>

    <div class="block-content">
        <div class="image"><a href="<?php echo 'http://' . Configure::read('Vcc.site_url') . '/' . $venue['Venue']['slug'] ?>" title="<?php echo $venue['Venue']['name'] ?>">
        <img src="/img/venue_photos/<?php echo $venue['Venue']['photo_2'] ?>" alt="#" width="183" height="97" /></a></div>
        <strong class="title-block"><?php echo $this->Text->truncate($venue['Venue']['name'],30) ?></strong>
        <span class="address"><?php echo $venue['Venue']['address'] . ', ' . $venue['City']['name'] ?></span>
        <span class="block-link">
                    <?php $venueTypes = array();
    if (isset($venue['venueTypes']) ) $venueTypes = array_merge( $venueTypes, array_slice($venue['venueTypes'],0,1) );
    if ( isset($venue['venueSubtype']) ) $venueTypes = array_merge( $venueTypes, array_slice($venue['venueSubtype'],0,1) );
    echo $this->Text->toList( $venueTypes, $and=',' );
    ?>
        </span>
        <p><?php echo $this->Text->truncate($venue['VenueDetail']['description'],200);?></p>
        
        <?php echo $this->Html->link( 'MORE', '/' . $venue['Venue']['slug'], array('class' => 'more') ) ?>
    </div>
	
	<?php 
	if ( $counter%3 == 0 && $numVenues > 3 ) 
		echo '
		<div style="clear: both; padding-top: 30px; margin: 0px auto 20px; width: 468px">
			<script type="text/javascript"><!--
			google_ad_client = "pub-5569648086666006";
			/* 468x60, created 6/12/11 */
			google_ad_slot = "8509781794";
			google_ad_width = 468;
			google_ad_height = 60;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>';
	?>
                                        
<?php endforeach; ?>


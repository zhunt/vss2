<?php //debug($this->params) ?>

<meta name="twitter:card" content="summary">
<meta name="twitter:creator" content="@barrie_eats">
<meta name="twitter:site" content="@barrie_eats">


<?php if (!empty($this->data['Venue']['full_name'] ) ): // venue name ?>
	<meta property="og:title" content="<?php echo $this->data['Venue']['full_name'] ?> on <?php echo Configure::read('Vcc.site_name') ?>" />
	<meta property="twitter:title" content="<?php echo $this->data['Venue']['full_name'] ?> on <?php echo Configure::read('Vcc.site_name') ?>" />
	
<?php elseif ( isset($post['Post']['name']) && $post['Post']['name'] != '' ): // post title ?>
	<meta property="og:title" content="<?php echo htmlentities($post['Post']['name']) ?>" />
	<meta property="twitter:title" content="<?php echo htmlentities($post['Post']['name']) ?>" />
	
<?php elseif ( $this->params['controller'] == 'landings' && $this->params['action']['venue_type'] && isset($this->params['pass'][0]) ): ?>
    <meta property="og:title" content="Listings of <?php echo $this->params['pass'][0]?>s on <?php echo Configure::read('Vcc.site_name') ?>" />
	<meta property="twitter:title" content="Listings of <?php echo $this->params['pass'][0]?>s on <?php echo Configure::read('Vcc.site_name') ?>" />
	
<?php else: ?>
	<meta property="og:title" content="<?php echo Configure::read('Vcc.site_name') ?>" />
	<meta property="twitter:title" content="<?php echo Configure::read('Vcc.site_name') ?>" />
	
<?php endif; ?>

<?php if ( !empty($venue['Venue']['slug']) ): ?>
<meta property="og:url" content="http://www.<?php echo Configure::read('Vcc.site_url') ?>/<?php echo $this->data['Venue']['slug'] ?>" />
<?php else: ?>
<meta property="og:url" content="http://www.<?php echo Configure::read('Vcc.site_url') ?>/<?php echo $this->params['url']['url'] ?>" />
<?php endif; ?>

<?php if ( !empty($venue['Venue']['photo_1']) ): ?>
	<meta property="og:image" content="http://www.<?php echo Configure::read('Vcc.site_url') ?>/img/venue_photos/<?php echo $venue['Venue']['photo_1'] ?>" />
	<meta property="twitter:image:src" content="http://www.<?php echo Configure::read('Vcc.site_url') ?>/img/venue_photos/<?php echo $venue['Venue']['photo_1'] ?>" />
	
	
<?php elseif( isset($post['Post']['content_html']) && $post['Post']['content_html'] != '' ): ?>	
	<?php $postContent = $post['Post']['content_html'];  preg_match_all('/<img[^>]+>/i',$postContent, $imgTags);  // from: http://stackoverflow.com/questions/138313/how-to-extract-img-src-title-and-alt-from-html-using-php
		if ( !empty($imgTags[0]) ) { // debug($imgTags[0]); //debug($postContent);
			$counter = 0;
			foreach($imgTags[0] as $counter => $imageTag){
				preg_match_all('/(src)="([^"]*)"/i',$imageTag, $imgCollection[$counter] );
				$counter ++;
			}
			//debug( $imgCollection );
			
			
			if ( isset($imgCollection[0][2][0]) ) {
				$cardImage = trim($imgCollection[0][2][0]);
				
			
				if ( strpos( $cardImage, 'http://') === false ) $cardImage = 'http://' . $cardImage;
				
				//$imgCollection[0][2][0] = str_replace('http://', '', $imgCollection[0][2][0]); // remove http:// bit
				echo '<meta property="og:image" content="' .  $cardImage .'" />' . "\n";
				echo '<meta property="twitter:image:src" content="' .  $cardImage .'" />' . "\n";
				
			}
		}
	?>
<?php else: ?>
	<meta property="og:image" content="http://www.<?php echo Configure::read('Vcc.site_url') ?>/img/simcoedining-logo-med.jpg" />
<?php endif; ?>

<?php if ( isset($post['Post']['short_dek']) && $post['Post']['short_dek'] != '' ): // post description, max 200 ?>
	<meta property="twitter:description" content="<?php echo htmlentities( $this->Text->truncate( $post['Post']['short_dek'], 190) ) ?> " /> 
<?php elseif ( isset($venue['VenueDetail']['description']) && $venue['VenueDetail']['description'] != '' ): ?>
	<meta property="twitter:description" content="<?php echo htmlentities( $this->Text->truncate( $venue['VenueDetail']['description'], 190) ) ?> " /> 	
<?php endif; ?>


<meta property="og:site_name" content="<?php echo Configure::read('Vcc.site_name') ?>" />
<!-- meta property="fb:admins" content="zoltanh" / -->

<?php
$orgType = 'restaurant';
if ( isset($venue['VenueType'][0]['slug']) ) {
	switch( $venue['VenueType'][0]['slug'] ) {
		case 'bar':
			$orgType = 'bar';
			break;
		case 'cafe':
			$orgType = 'cafe';
			break;
		case 'hotel':
			$orgType = 'hotel';
			break;
		default:
			$orgType = 'website';				
	}
}
else {	
	$orgType = 'website';	
}
?>
<meta property="og:type" content="<?php echo $orgType ?>" /> <!-- restaurant, hotel, bar, cafe, -->

<?php if ( isset($venue['Venue']['geo_lat']) ): ?>
    <meta property="og:latitude" content="<?php echo $this->data['Venue']['geo_lat'] ?>"/>
    <meta property="og:longitude" content="<?php echo $this->data['Venue']['geo_lng'] ?>"/>
    <meta property="og:street-address" content="<?php echo $this->data['Venue']['address'] ?>"/>
    <meta property="og:locality" content="<?php echo $this->data['City']['name'] ?>"/>
    <meta property="og:region" content="<?php echo Configure::read('Vcc.location_province') ?>"/>
    <meta property="og:postal-code" content="<?php echo $this->data['VenueDetail']['postal_code'] ?>"/>
    <meta property="og:country-name" content="Canada"/>
<?php endif; ?> 


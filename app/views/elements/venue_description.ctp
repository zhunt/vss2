<!-- description -->
<?php if ( !empty($venue['VenueDetail']['media_reviews']) ): ?>
	<div id="tabs" >
	<ul>
		<li><a href="#tabs-1">About <?php echo $venue['Venue']['name'] ?></a></li>
		<li><a href="#tabs-2">Reviews</a></li>
	</ul>
	<div id="tabs-1">
<?php endif; ?>	


<p><?php echo $venue['VenueDetail']['description'] ?></p>
<!-- button-list -->

<ul class="button-list">
	<?php $venueTypes = $this->Venues->sortVenueTypes( array( $venue['VenueType'], $venue['VenueSubtype'], $venue['VenueProduct']), $cuisinesOnly = false, 6 ); ?>
	<?php foreach( $venueTypes as $venueType): ?>
  
	<li><a href="<?php echo '/searches/' . $venueType['subtype'] . ':'. $venueType['slug']?> " title="<?php echo $venueType['name'] ?>"><span><?php echo $this->Text->truncate($venueType['name'],12) ?></span></a></li> 
	<?php endforeach; ?>
   
</ul>

<p style="font-size: 12px;" ><em>Listing last verified: <?php echo $time->format( Configure::read('Time.format_short'), $venue['Venue']['modified'] )?></em></p>

<?php if ( !empty($venue['VenueDetail']['media_reviews']) ): ?>
	</div>
	<div id="tabs-2" class="media-reviews">
		<?php echo $venue['VenueDetail']['media_reviews']; ?>
		
		<p class="media-notice">If you'd like your review of <?php echo $venue['Venue']['name'] ?> listed here too, send us a link at writers@SimcoeDining.com</p>
	</div>
</div>

	<?php $html->scriptBlock('
	$(document).ready(function(){ 
		$( "#tabs" ).tabs(); 
		
		// shifts tabs to bottom of panel
		$( ".tabs-bottom .ui-tabs-nav, .tabs-bottom .ui-tabs-nav > *" )
			.removeClass( "ui-corner-all ui-corner-top" );
	
		
		});
	', array('inline' => false ) ); ?>
<?php endif; ?>

<style type="text/css" >
	#tabs { margin-bottom: 8px; }
	.media-reviews ul { list-style: none; margin-left: 0; padding-left: 0 }
	
	p.media-notice { padding-top: 30px; font-size: 10px; text-align: right; text-transform: uppercase; color: #666 }
	
	.ui-corner-all {
		border-radius: 0;
		color: #ccc;
	}
	
	.ui-widget { font-size: 1em; }
	
	.ui-widget-content { border: none; border-bottom: 1px solid #ccc; }
	.ui-tabs .ui-tabs-panel { padding: 0; }
	.ui-state-default { background-image: none; background-color: #ccc; }
	.ui-widget-header { background-image: none; background-color: #fff; border: none; border-bottom: 1px solid #aaa; }
	
	.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { background-image: none; }
	
</style>

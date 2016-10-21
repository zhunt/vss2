<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $title_for_layout . ', ' . Configure::read('Vcc.site_name') ?></title>
	
    
 	<link type="text/css" rel="stylesheet" href="/css/all-home.css" />
	
                        
	<!--[if lt IE 8]><link type="text/css" rel="stylesheet" href="/css/ie-home.css" /><![endif]-->
       
    
    <link rel="stylesheet" type="text/css" href="/css/jquery.ui.stars.css"/>
	
	<style type="text/css">
		.block-holder { background-image: none; }
	</style>
     
    
<?php echo $this->element('venue_facebook_meta'); ?>


	<title>
		<?php echo $title_for_layout; ?>
		<?php //echo '| ' .Configure::read('Vcc.site_name') ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css( array(
                    'jquery-ui-1.8.2.custom')); // jquery-ui-1.8.custom.css, 'custom-theme/jquery-ui-1.8.custom'
		
		echo $this->Html->meta('rss', '/feeds/index.rss');
	?>
	
	<?php echo $html->meta('description', $metaDescription); ?>

	<?php if ( Configure::read('debug') != 0)
            echo '<meta name="ROBOTS" content="NOINDEX,NOFOLLOW">';
    ?>

<?php if ( Configure::read('debug') == 0): ?>
<script type="text/javascript">
	window.google_analytics_uacct = '<?php echo Configure::read('Vcc.google_analytics_uacct')?>';
	
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo Configure::read('Vcc.google_analytics_uacct')?>']);
	_gaq.push(['_trackPageview']);
	
	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
<?php endif; ?>
    
</head>
<body>
<!-- wrapper -->
	<div id="wrapper">
		<div class="w1">
			<div class="w2">
			<!-- header -->
				<div id="header">
				<!-- header-holder -->
					<div class="header-holder">
					<!-- header-top -->

                        
						<!-- header-top, header-navigation -->
						<?php echo $this->element('header_navigation'); ?>
                        
					</div>
					<!-- header-image -->
					<div class="header-image"><img src="/images/inside-banner.jpg" alt="#" width="1040" height="92" /></div>
				</div>
				<!-- main -->
				<div id="main">
                <!-- === -->

					<div class="b">
						
						<div class="main-holder">
							<div id="content">
								<h2>Why advertise on SimcoeDining?</h2>
								<div class="block-holder">
									
								<p>Since 2007, SimcoeDining has been a guide to finding restaurants, bars and places to eat and drink in the Barrie area.</p>
								
								<h3>Who visits SimcoeDining?</h3>
								
								<ul >
									<li>4,500+ visitors a month and growing</li>
									<li>42% visitors from Barrie (50% including Collingwood, Orillia, Alliston and Newmarket)</li>
									<li>25% of visitors from Toronto and the GTA (Mississauga, Hamilton, Brampton)</li>
									<li>We focus on Barrie and area exclusively</li>
								</ul>
								
								<h3>What we can offer you:</h3>
								<p>We offer banner advertisements on a per-monthly basis.<br>We can also design an attractive banner advertisment for you if you don't have a graphic  designer.</p>
								<p>Banners cost $100/month for all Profile pages, $200 all for the Section pages (Restaurant, Bar, Coffee and Hotel) and  $300 for the Home page.</p>
								
								<img src="/img/marketing/sd-ad-examples.jpg" width="594" height="216" alt="advertisment placement" style="display: block; text-align: center" >
								
								<h3>For Venues</h3><a name="venues"></a>
								<p> For venues we currently offer a package:
								<ul>
								  <li>Link to a website, Facebook or other webpages (available seperately for $10/month)</li>
								  <li>Ad-free profile (no advertisements on your Profile page)</li>
								  <li>Event listings</li>
								  <li>Photo galleries </li>
								  <li>Menus </li>
								  <li>Featured Listing (featured on Home and Section pages)</li>
								  <li>and more...</li>
								  <li>Only $50/month</li>
								</ul>
								</p>
								
								<p>For more information contact: <a href="mailto:advertise@simcoedining.com">advertise@simcoedining.com</a></p>

								</div>
								
								
                                <!-- -->
                                

						
 						            
                                                        
						
                        
                        
						
 
 						          
                                              
						                                                 
                                <!-- -->
                                
                                
							</div>
							<div id="sidebar">
								<div class="block">
									<div class="top">
										<div class="bottom">
											<h2>New Listings</h2>
											<ul>
													<?php
        // new listings
        echo
	$this->element('venue_list', 
		array( 'listType' => 'new_venues', 'num' => 5, array('cache' =>
                        array('key' => 'home_page-new_venues', 'time' => '+1 month') ) )
		);
	?>
											</ul>
										</div>
									</div>
								</div>
						
							</div>
						</div>
                        
						<?php echo $this->element('footer') ?>
				             
                <!-- === -->
                </div> 
			</div>
		</div>
	</div>
    
    <?php // echo $this->element('venue_microformats') ?>
    

    
</body>

</html>
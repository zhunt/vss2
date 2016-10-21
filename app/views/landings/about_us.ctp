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
						<div class="block-news-holder">
							<script type="text/javascript"><!--
                            google_ad_client = "pub-5569648086666006";
                            /* 728x90, (profile top) */
                            google_ad_slot = "5945191093";
                            google_ad_width = 728;
                            google_ad_height = 90;
                            //-->
                            </script>
                            <script type="text/javascript"
                            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                            </script>							
						</div>
						<div class="main-holder">
							<div id="content">
								<h2>About SimcoeDining</h2>
								<div class="block-holder">
									
<p><strong>SimcoeDining.com</strong> is a guide to restaurants, bars, cafes and hotels in the Barrie area including: Collingwood, Blue Mountain, Wasaga Beach and Orillia.</p>

<p>In the spring of 2011 the site was re-launched with a new look featuring numerous improvements including a new design, larger pictures, better searching and overall faster performance. </p>

<p>Launched in 2006 as a simple directory by owner Zoltan Hunt, who grew-up near Alliston, Ontario, to fill the need for a good guide to restaurants in the area, today it features a growing list of 
establishments from all over Barrie and surrounding communities.</p>

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
                         
					</div>
				             
                <!-- === -->
                </div> 
			</div>
		</div>
	</div>
    
    <?php // echo $this->element('venue_microformats') ?>
    

    
</body>

</html>
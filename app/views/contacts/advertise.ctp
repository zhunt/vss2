<?php 

$this->set('title_for_layout', 'Advertising on YYZtech.ca');

	$html->script( array(
            'http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js',
            'jquery.form',
            'http://maps.google.com/maps/api/js?sensor=false',
            'vcc_public'
            ), array('inline' => false) );
			?>





		<div id="main">
			<div class="main-holder">
				<!-- content -->
				<div id="content">
					<!-- box -->
					<div class="box">
						<div class="holder">
							<div class="heading">
								<div class="arrow">
									<h2>Advertising Rates</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								
                                <div class="description">
                                    <div class="text-col">
                                        <div class="contact">
                                       
                                        <span class="venue_description">
                                        <h4>Advertising on YYZtech.ca:</h4>
                                        <img src="/images/content/ad-spots.jpg" width="598" height="231" style="margin: 5px 50px 10px 50px" />
                                        <p>
                                           Advertising spots are available on each of the landing pages (Computer Listings, Internet Spots, Resources and search results). 
                                           Rates are $50 per month for each ad tile or $150 per month for placement on all 4 spots. If you are interested in purchasing a tile, 
                                           contact Zoltan at zhunt@yyztech.ca.
                                         </p>
                                      
                                        <p>
                                        	Tiles are 220x251 pixels and can be sent as .jpg, .gif, .png or .swf files. If you require graphic design for your advertisement, we can provided assistance. 
                                        </p>
                                        <p>
                                            YYZtech is a directory of computer stores in Toronto and the GTA created to help Toronto-area computer dealers
                                            be found by customers looking for computer equipment and services using a specialized search engine.
                                        </p>
                                       
                                        </span>                                                        
                                        </div>
                                    </div> 
                                </div>                                                               
                               
							</div>
						</div>
					</div>
					
					<!-- box -->
					</div>
				<!-- sidebar -->
				<div id="sidebar">
					
                    <!-- -->

                    <ul class="venues-list" style="margin-top:0px">
                        <?php foreach( $newVenues as $venue): ?>
                        <li>
                            <div class="photo">
                                <?php if ( !empty($venue['Venue']['photo_1'])) :?>
                                <a href="/<?php echo $venue['Venue']['slug'] ?>">
                                <img src="/image.php?<?php echo $venue['Venue']['photo_1'] ?>?width=56&amp;height=55&amp;cropratio=56:55&amp;image=/img/venue_photos/<?php echo $venue['Venue']['photo_1'] ?>" width="56" height="55" alt="image description" /></a>
                                <?php else: ?>
                                    <a href="/<?php echo $venue['Venue']['slug'] ?>">
                                <img src="/images/no_photo-sm.jpg" width="56" height="55" alt="image description" /></a>
                                <?php endif; ?>
                            </div>
                            <div class="desc">
                                <strong class="title"><a href="/<?php echo $venue['Venue']['slug'] ?>"><?php echo $venue['Venue']['name'] ?></a></strong>
                                <p><?php 
                                    if ( isset($venue['VenueSubtype'][0]['name']))
                                        echo $venue['VenueSubtype'][0]['name']; 
                                    else	
                                        echo $venue['VenueType'][0]['name']; 
                                    
                                    ?></p>
                            </div>
                        </li>
                        <?php endforeach ?>
                    </ul>
								                   									                    
                    <!-- -->
				
                
<!-- twitter -->
					
            <!-- -->                
                
			</div>
            
            </div>
            
            
		</div>

<script type="text/javascript">
<?php $this->Html->scriptStart( array('inline' => false) )?>
	$("#CommentAddForm").validate({
	  debug: false,
	  rules: {
		"data[Contact][author]": {
			required: true,
			minlength: 3,
			maxlength: 30
		},
		"data[Contact][author_email]": {
			required: true,
			email: true,
			maxlength: 50
		},
		"data[Contact][comment]": {
			required: true,
			minlength: 3,
			maxlength: 2000
		}
	  }
	  
           /* submitHandler: function(form) {
                alert('Comment being sent...');
				form.submit();
            }
			*/	  
	  
	})
        
<?php $this->Html->scriptEnd()?>
</script>




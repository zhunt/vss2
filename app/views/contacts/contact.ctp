<?php 

$this->set('title_for_layout', 'About YYZtech.ca');

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
									<h2>About YYZtech</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								
                                <div class="description">
                                    <div class="text-col">
                                        <div class="contact">
                                       
                                        <span class="venue_description">
                                        <h4>About YYZtech.ca:</h4>
                                        <p>
                                        YYZtech is a directory of computer stores in Toronto and the GTA created to help Toronto-area computer dealers
										be found by customers looking for computer equipment and services using a specialized search engine.
                                        </p>
                                        <p>
                                        Founded in 2005, YYtech started by covering the new Internet cafes that where opening on a monthly across Toronto, providing high-speed Internet 
                                        to people still discovering the Internet. In 2010, with high-speed Internet now available as close as your mobile phone, we decided to focus on
                                        the places people where going to work and play at: laptop-friendly cafes and gaming centres accross the GTA.
                                        </p>
                                        </span>                                                        
                                        </div>
                                    </div> 
                                </div>                                                               
                               
							</div>
						</div>
					</div>
					
					<!-- box -->
					<div class="box">
						<div class="holder">
							<div class="heading">
								<div class="arrow">
									<h2>Contact YYZtech</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								<!-- add-comment -->
								<?php echo $this->Session->flash(); ?>
                                <?php echo $form->create('Contact', array('action' => 'contact', 'class' => 'add-comment', 'id' => 'CommentAddForm',
																			'inputDefaults' => array('label' => false,'div' => false )
																			)
																			);
                                                                            
									echo $form->input('Contact.demambo1', array('value' => Configure::read('demambo1'), 'style' => 'display: none' ) );
									echo $form->input('Contact.demambo2', array('value' => Configure::read('demambo2'), 'style' => 'display: none' ) );
									?>
                                                
									<fieldset>
										<div class="row">
											<div class="col-1">
												<label for="name-field">Name:</label>
												<?php echo $form->input('Contact.author', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												<label for="email-field">Email:</label>
												<?php echo $form->input('Contact.author_email', array('class' => 'text')) ?>
											</div>
										</div>
										<div class="row">
											<label for="comments-field">Comments:</label>
											<div class="textarea">
                                                <?php echo $form->input('Contact.comment', array('rows' => 8, 'cols' => 91) ) ?>
											</div>
										</div>
										<div class="form-submit">
											<input class="btn-submit" type="submit" value="Submit">
											
                                          

										</div>
									</fieldset>
								</form>
								
							</div>
						</div>
					</div>
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
					<div class="twitter" >
						
						<div class="holder">
                        <script src="http://widgets.twimg.com/j/2/widget.js"></script>
							<script language="JavaScript" type="text/javascript">
                            new TWTR.Widget({
                              version: 2,
                              type: 'profile',
                              rpp: 4,
                              interval: 6000,
                              width: 209,
                              height: 240,
                              theme: {
                                shell: {
                                  background: '#96e3e9',
                                  color: '#f7f4f7'
                                },
                                tweets: {
                                  background: '#ffffff',
                                  color: '#4B4B4B',
                                  links: '#4b4b4b'
                                }
                              },
                              features: {
                                scrollbar: false,
                                loop: false,
                                live: false,
                                hashtags: true,
                                timestamp: true,
                                avatars: false,
                                behavior: 'all'
                              }
                            }).render().setUser('yyztech').start();
                            </script>
                        </div>
					</div>            
            
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




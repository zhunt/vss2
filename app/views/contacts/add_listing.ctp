<?php 

$this->set('title_for_layout', 'Add Your Venue');

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
									<h2>Add Your Business to YYZtech</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								
                                <div class="description">
                                    <div class="text-col">
                                        <div class="contact">
                                       
                                        <span class="venue_description">
                                        
                                        <p><strong>Listing your business is free!</strong>
                                        If you'd like your business added to YYZtech
                                        please include the following information: <em>contact information, hours of operation,
                                        and a brief description</em> (300 words or less) of the products and services you offer.
                                        </p>
                                        
                                        <p>When your listing is added, you'll be notified by e-mail. If you'd like,
                                            you can send us a photo of your location when you receive the confirmation email.
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
									<h2>Add Your Business</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								<!-- add-comment -->
								<?php echo $this->Session->flash(); ?>
                                <?php echo $form->create('Contact', array('action' => 'add_listing', 'class' => 'add-comment', 'id' => 'CommentAddListingForm',
																			'inputDefaults' => array('label' => false,'div' => false )
																			)
																			);
                                                                            
									echo $form->input('Contact.demambo1', array('value' => Configure::read('demambo1'), 'style' => 'display: none' ) );
									echo $form->input('Contact.demambo2', array('value' => Configure::read('demambo2'), 'style' => 'display: none' ) );
									?>
                                                
									<fieldset>
                                    	<h3>Contact Information</h3>   
										<div class="row">
											<div class="col-1">
												<label for="name-field">Name:</label>
												<?php echo $form->input('Contact.name', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												<label for="email-field">Website:</label>
												<?php echo $form->input('Contact.website', array('class' => 'text')) ?>
											</div>
										</div>
										<div class="row">
											<div class="col-1">
												<label for="name-field">Email:</label>
												<?php echo $form->input('Contact.email', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												<label for="email-field">Phone Number:</label>
												<?php echo $form->input('Contact.phone1', array('class' => 'text')) ?>
											</div>
										</div>
                                                                                                                  
 										<div class="row">
											<div class="col-1">
												<label for="name-field">Address:</label>
												<?php echo $form->input('Contact.address', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												<label for="email-field">City:</label>
												<?php echo $form->input('Contact.city', array('class' => 'text')) ?>
											</div>
										</div>
                                                                                  
                                        <h3>Hours</h3>
 										<div class="row">
											<div class="col-1">
												<label for="name-field">Sunday:</label>
												<?php echo $form->input('Contact.hours_sun', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												<label for="email-field">Monday:</label>
												<?php echo $form->input('Contact.hours_mon', array('class' => 'text')) ?>
											</div>
										</div>
 										<div class="row">
											<div class="col-1">
												<label for="name-field">Tuesday:</label>
												<?php echo $form->input('Contact.hours_tue', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												<label for="email-field">Wednesday:</label>
												<?php echo $form->input('Contact.hours_wed', array('class' => 'text')) ?>
											</div>
										</div>     
 										<div class="row">
											<div class="col-1">
												<label for="name-field">Thursday:</label>
												<?php echo $form->input('Contact.hours_thu', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												<label for="email-field">Friday:</label>
												<?php echo $form->input('Contact.hours_fri', array('class' => 'text')) ?>
											</div>
										</div>    
 										<div class="row">
											<div class="col-1">
												<label for="name-field">Saturday:</label>
												<?php echo $form->input('Contact.hours_sat', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												
											</div>
										</div>     
                                                                                                                                                    
                                         
                                        
                                         <h3>Description</h3>         
										<div class="row">
											<!-- <label for="comments-field">Description:</label> -->
											<div class="textarea">
                                                <?php echo $form->input('Contact.description', array('rows' => 8, 'cols' => 91) ) ?>
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
                                <img src="/image.php?<?php echo $venue['Venue']['photo_1'] ?>?width=56&amp;height=55&amp;cropratio=56:55&amp;image=/app/webroot/img/venue_photos/<?php echo $venue['Venue']['photo_1'] ?>" width="56" height="55" alt="image description" /></a>
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
				</div>
			</div>
		</div>

<script type="text/javascript">
<?php $this->Html->scriptStart( array('inline' => false) )?>
	$("#CommentAddListingForm").validate({
	  debug: false,
	  rules: {
		"data[Contact][name]": {
			required: true,
			minlength: 3,
			maxlength: 50
		},
		"data[Contact][address]": {
			required: true,
			maxlength: 100
		},
		"data[Contact][email]": {
			required: true,
			email: true,
			maxlength: 100
		},	
		"data[Contact][phone1]": {
			required: true,
			maxlength: 100
		},			
		"data[Contact][city]": {
			required: true,
			maxlength: 100
		},
		"data[Contact][description]": {
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




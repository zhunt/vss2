<?php 
	$html->script( array(
            'http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.js',
            'jquery.form',
            'http://maps.google.com/maps/api/js?sensor=false',
            'vcc_public'
            ), array('inline' => false) );
			?>


<style type="text/css">
.venue_photo { max-width: 273px }
.venue_description p {padding-bottom: 13px}
</style>


		<div id="main">
			<div class="main-holder">
				<!-- content -->
				<div id="content">
					<!-- box -->
					<div class="box">
						<div class="holder">
							<div class="heading">
								<div class="arrow">
									<h2><?php echo $venue['Venue']['full_name'] ?></h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								<!-- profile -->
								<div class="profile">
									<ul class="switch-nav">
                                    	<?php $venueTypes = $this->Venues->sortVenueTypes( array( $venue['VenueType'], $venue['VenueSubtype']) ); ?>
                                        <?php foreach( $venueTypes as $venueType): ?>
                                        <li><?php echo $this->Html->link( $venueType['name'], '/searches/' . $venueType['subtype'] . ':'. $venueType['slug'] ); ?></li>
                                        <?php endforeach; ?>
									</ul>
									<div class="prof-visual">
										<div class="photo">
                                        <?php 
										$photo = $venue['Venue']['photo_1'];
										if ( $photo) {
											echo '<a href="#"><img src="/image.php?' .$photo . '?width=273&height=246&cropratio=273:246&image=/app/webroot/img/venue_photos/'.$photo .'" alt="image description" class="venue_photo"></a>';
										} else if( isset($venue['Venue']['zoom']) ) {
											echo $this->element('venue_streetview');
										}else  {
											echo '<a href="#"><img src="/images/no_photo.jpg" width="273" height="246" alt="image description"></a>';	
										}
										?>
										</div>
										
                                        <?php echo $this->element('venue_map'); // display either overhead or streetview. If no photo, maybe do full-width map like CV ?>
									</div>
                                    
                                    <div style="width: 728px; height: 90px; margin: -20px 0pt 10px -16px;">                        
                                    <script type="text/javascript"><!--
                                    google_ad_client = "pub-5569648086666006";
                                    /* 728x90, created 9/29/08 */
                                    google_ad_slot = "3971646394";
                                    google_ad_width = 728;
                                    google_ad_height = 90;
                                    //-->
                                    </script>
                                    <script type="text/javascript"
                                    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                                    </script>
                                    </div>
								</div>
							</div>
						</div>
					</div>
					<!-- ad -->
                    <!--
					<div class="ad">
						<a href="#"><img src="/images/ad-728x90.jpg" width="728" height="90" alt="image description"></a>
					</div>
                    -->
					<!-- box -->
					<div class="box">
						<div class="holder">
							<div class="heading">
								<div class="arrow">
									<h2>About YYZtech<?php echo $venue['Venue']['full_name'] ?></h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								<!-- add-comment -->
								<?php echo $this->Session->flash(); ?>
                                <?php echo $form->create('Comment', array('action' => 'add', 'class' => 'add-comment', 'id' => 'CommentAddForm',
																			'inputDefaults' => array('label' => false,'div' => false )
																			)
																			);
                                                                            
									echo $form->input('Comment.venue_id', array('type' => 'hidden', 'value' => $venue['Venue']['id']) );
									echo $form->input('Comment.slug', array('type' => 'hidden', 'value' => $venue['Venue']['slug']) );
									echo $form->input('Comment.demambo1', array('value' => Configure::read('demambo1'), 'style' => 'display: none' ) );
									echo $form->input('Comment.demambo2', array('value' => Configure::read('demambo2'), 'style' => 'display: none' ) );
									?>
                                                
									<fieldset>
										<div class="row">
											<div class="col-1">
												<label for="name-field">Name:</label>
												<?php echo $form->input('Comment.author', array('class' => 'text')) ?>
											</div>
											<div class="col-2">
												<label for="email-field">Email:</label>
												<?php echo $form->input('Comment.author_email', array('class' => 'text')) ?>
											</div>
										</div>
										<div class="row">
											<label for="comments-field">Comments:</label>
											<div class="textarea">
                                                <?php echo $form->input('Comment.comment', array('rows' => 8, 'cols' => 91) ) ?>
											</div>
										</div>
										<div class="form-submit">
											<input class="btn-submit" type="submit" value="Submit">
											
                                            <div class="rate">
												<strong class="label">I rate <?php echo $venue['Venue']['full_name']?>:</strong>
                                                <div class="multiField" id="starify" style="display: inline; float: right;">
                                                    <label for="vote1" class="blockLabel"><input type="radio" name="data[Comment][vote]" id="vote1" title="Poor" value="1" /> Poor</label>
                                                    <label for="vote2" class="blockLabel"><input type="radio" name="data[Comment][vote]" id="vote2" value="2" /> Fair</label>
                                                    <label for="vote3" class="blockLabel"><input type="radio" name="data[Comment][vote]" id="vote3" value="3"  /> Average</label>
                                                    <label for="vote4" class="blockLabel"><input type="radio" name="data[Comment][vote]" id="vote4" value="4" /> Good</label>
                                                    <label for="vote5" class="blockLabel"><input type="radio" name="data[Comment][vote]" id="vote5" title="Excellent" value="5" /> Excellent</label>
                                                </div>
											</div>

										</div>
									</fieldset>
								</form>
								<div class="comments">
                                <?php if ( !empty($venue['Comment']) ): ?>
                                	<?php foreach ($venue['Comment'] as $comment): ?>
									<div class="comment">
										<div class="headline">
											<strong class="author"><?php echo $comment['author'] ?></strong>
											<em class="date"><?php echo $this->Time->format( Configure::read('Time.format_short'), $comment['created']) ?></em>
										</div>
										<p><?php echo str_replace('\n', '<br>', trim($comment['comment'])) ?></p>
										
                                        <div class="rate">
											<strong class="label">Rated <?php echo $venue['Venue']['full_name']?>:</strong>
											<!-- <img src="/images/stars2.gif" width="86" height="16" alt="image description"> -->
                                            <div class="stars" style="display: inline; width:86px; height: 16px; float: right; font-size: 0;">
                                            <?php echo $this->Venues->starRating( $comment['rating']); ?>
                                            </div>
                                            <!-- -->

                                            <!-- -->
										</div> 
									</div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                    

								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- sidebar -->
				<div id="sidebar">
					<!-- side-box -->
					<div class="side-box">
						<div class="content">
							<!-- hours -->
							<div class="hours" id="venue_hours">
								<table>
									<thead>
										<tr>
											<td class="td-1">Day</td>
											<td class="td-2">Hours</td>
										</tr>
									</thead>
									<tbody>
										<tr id="day_0">
											<td class="td-1">Sun.</td>
											<td class="td-2" ><?php echo $venue['RestaurantHour']['hours_sun'] ?></td>
										</tr>
										<tr id="day_1">
											<td class="td-1">Mon.</td>
											<td class="td-2"><?php echo $venue['RestaurantHour']['hours_mon'] ?></td>
										</tr>
										<tr id="day_2">
											<td class="td-1">Tues.</td>
											<td class="td-2"><?php echo $venue['RestaurantHour']['hours_tue'] ?></td>
										</tr>
										<tr id="day_3"> 
											<td class="td-1">Wed.</td>
											<td class="td-2"><?php echo $venue['RestaurantHour']['hours_wed'] ?></td>
										</tr>
										<tr id="day_4">
											<td class="td-1">Thurs.</td>
											<td class="td-2"><?php echo $venue['RestaurantHour']['hours_thu'] ?></td>
										</tr>
										<tr id="day_5">
											<td class="td-1">Fri.</td>
											<td class="td-2"><?php echo $venue['RestaurantHour']['hours_fri'] ?></td>
										</tr>
										<tr id="day_6">
											<td class="td-1">Sat.</td>
											<td class="td-2"><?php echo $venue['RestaurantHour']['hours_sat'] ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- side-box -->
					<div class="side-box">
						<div class="headline">
							<h3>Nearby Venues</h3>
						</div>
						<div class="content">
							<ul class="nearby-list">
                            
                            <?php 
							if ( $venuesNearby ):
							$class = 'odd'; 
							foreach( $venuesNearby as $nearbyVenue): //debug($nearbyVenue); 
								if ( isset($nearbyVenue['VenueSubtype'][0]['name']) )
									$venueType = '(' . $nearbyVenue['VenueSubtype'][0]['name'] .')';
								else if ( isset($nearbyVenue['VenueType'][0]['name']) )
									$venueType = '(' . $nearbyVenue['VenueType'][0]['name'] .')';
								else
									$venueType = '';	
							?>
								<li class="<?php echo $class ?>">
									<strong><?php echo $this->Html->link( $this->Text->truncate($nearbyVenue['Venue']['full_name'],23) , '/' . $nearbyVenue['Venue']['slug'] ) ?></strong>
									<p> <?php echo $venueType ?> <span><?php echo $this->Venues->distance($nearbyVenue[0]['distance'], 'metres');?></span></p>
								</li>
							<?php 
                            	if ($class == 'odd') $class = ''; else $class = 'odd';
                            endforeach;
							else:
								echo '<li>None<li>';
							endif;
                            ?>
							</ul>
						</div>
					</div>
					<!-- btn -->
					<a href="#" class="btn" id="link_error">REPORT ERROR ON PROFILE</a>
					<!-- btn-share -->
                    <!--
					<div class="btn-share">
						<ul>
							<li><a href="#"><img src="/images/ico-f2.gif" width="27" height="25" alt="image description"></a></li>
							<li><a href="#"><img src="/images/ico-t2.gif" width="25" height="25" alt="image description"></a></li>
							<li><a href="#"><img src="/images/ico-ms.gif" width="26" height="25" alt="image description"></a></li>
							<li><a href="#"><img src="/images/ico-flcr.gif" width="25" height="25" alt="image description"></a></li>
							<li><a href="#">+ SHARE</a></li>
						</ul>
					</div>
                    -->
				</div>
			</div>
		</div>

<script type="text/javascript">
<?php $this->Html->scriptStart( array('inline' => false) )?>
	$("#CommentAddForm").validate({
	  debug: false,
	  rules: {
		"data[Comment][author]": {
			required: true,
			minlength: 3,
			maxlength: 30
		},
		"data[Comment][author_email]": {
			required: true,
			email: true,
			maxlength: 50
		},
		"data[Comment][comment]": {
			required: true,
			minlength: 3,
			maxlength: 2000
		}
	  },
	  
            submitHandler: function(form) {
                alert('Comment being sent...');
				form.submit();
            }
				  
	  
	})
        
<?php $this->Html->scriptEnd()?>
</script>



<?php echo $this->element('venue_microformats') ?>


<div id="error-dialog" style="display: none" title="Report Error on <?php echo $this->Text->truncate($venue['Venue']['name'],20) ?> Profile">
</div>




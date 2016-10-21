<?php $this->Html->scriptBlock('$(document).ready(function(){ $("#top_menu-cafes").addClass("active"); });', array('inline' => false)); ?>
<?php $this->set('title_for_layout', 'WiFi cafes, WiFi hotspots, Internet Cafes and Venues by types, features and locations'); 

echo $this->Html->script(array('jquery.ui.stars.min'), array('inline' => false ) );

$this->Html->scriptStart( array('inline' => false) ); ?>
$(".star_rating").stars();
<?php $this->Html->scriptEnd() ?>
<style type="text/css">
@import url(/css/jquery.ui.stars.min.css);
</style>

		<div id="main">
			<div class="main-holder">
				<!-- content -->
				<div id="content">
					<!-- three-cols -->
					<div class="three-cols">
						<div class="holder">
							<div class="frame">
								<div class="col">
									<div class="heading">
										<div class="arrow">
											<h2>REVIEWS</h2>
											<span>&nbsp;</span>
										</div>
									</div>
									<div class="content">
										<div class="reviews">
											<?php foreach( $latestArticles as $i => $blogPost): ?>
                                            <div class="item">
												<div class="headline">
													<div class="photo">
														<a href="<?php echo $blogPost->perma_link ?>"><img src="/image.php?<?php echo $blogPost->images[0] ?>?width=56&amp;height=55&amp;cropratio=1:1&amp;image=<?php echo $blogPost->images[0] ?>" width="56" height="55" alt="cover image" /></a>
													</div>
													<div class="hold">
														<h3><a href="<?php echo $blogPost->perma_link ?>"><?php echo $blogPost->post_title ?></a></h3>
														<strong class="author">by <?php echo $blogPost->author ?></strong>
													</div>
												</div>
												<p><?php echo $this->Text->truncate($blogPost->post_excerpt,150) ?> <a href="<?php echo $blogPost->perma_link ?>">more</a></p>
												<div class="tags">
                                                	<?php if ( !empty($blogPost->tags) ): ?>
														<p><span>Tags:</span> 
                                                    	<?php foreach( $blogPost->tags as $tag): ?>
                                                    	<a href="/posts/tag/<?php echo $tag->slug ?>"><?php echo $tag->name ?></a>,
                                                        <?php endforeach; ?>
                                                        </p>
                                                    <?php endif;?>
												</div>
											</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
								<div class="col">
									<div class="heading">
										<div class="arrow">
											<h2>NEW VENUES</h2>
											<span>&nbsp;</span>
										</div>
									</div>
									<div class="content">
										<ul class="venues-list">
                                        	<?php foreach( $newVenues as $venue): ?>
											<li>
												<div class="photo">
                                                	<?php if ( !empty($venue['Venue']['photo_1'])) :?>
													<a href="/<?php echo $venue['Venue']['slug'] ?>">
                                                    <img src="/image.php?<?php echo $venue['Venue']['photo_1'] ?>?width=56&amp;height=55&amp;cropratio=56:55&amp;image=/img/venue_photos/<?php echo $venue['Venue']['photo_1'] ?>" width="56" height="55" alt="image description" /></a>
                                                    <?php else: ?>
                                                    <img src="/images/no_photo-sm.jpg" width="56" height="55" alt="image description" />
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
									</div>
								</div>
								<div class="col">
									<div class="heading">
										<div class="arrow">
											<h2>VISITOR FAVOURITES</h2>
											<span>&nbsp;</span>
										</div>
									</div>
									<div class="content">
										<ul class="venues-list">
                                        	<?php foreach( $popularVenues as $venue ):?>
											<li>
												<div class="photo">
                                                	<?php if ( !empty($venue['Venue']['photo_1'])) :?>
													<a href="/<?php echo $venue['Venue']['slug'] ?>"><img src="/image.php?<?php echo $venue['Venue']['photo_1'] ?>?width=96&amp;height=96&amp;cropratio=1:1&amp;image=/img/venue_photos/<?php echo $venue['Venue']['photo_1'] ?>" width="56" height="55" alt="image description" /></a>
                                                    <?php else: ?>
                                                    <img src="/images/no_photo-sm.jpg" width="56" height="55" alt="image description" />
                                                    <?php endif; ?>
												</div>
												<div class="desc">
                                                    <div class="stars" >
                                                        <?php echo $this->Venues->starRating( $venue['VenueRating']['score']); ?>
                                                    </div>
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
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- box -->
 
<div class="ad-single" style="">                    
                    <script type="text/javascript"><!--
google_ad_client = "pub-5569648086666006";
/* 728x90, created 12/5/10 */
google_ad_slot = "3256548624";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>

					<div class="box">
						<div class="holder">
							<div class="heading">
								<div class="arrow">
									<h2>LATEST COMMENTS</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								<div class="comments">
									<?php foreach($comments as $comment): ?>
                                    <div class="comment">
										<div class="headline">
											<strong class="author"><?php echo $comment['Comment']['author']?></strong>
											<em class="date"><?php echo $this->Time->format( Configure::read('Time.format_short'),$comment['Comment']['created'])?></em>
										</div>
										<p><?php echo str_replace('\n', '<br>', trim($comment['Comment']['comment'])) ?></p>
										<div class="rate">
											<strong class="label"><a href="/<?php echo $comment['Venue']['slug'] ?>/#comments">
												<?php echo trim($comment['Venue']['name'] . ' ' . $comment['Venue']['sub_name']) ?></a></strong>
											
                                           
                                            
										</div>
									</div>
                                    <?php endforeach ?>
								</div>
							</div>
						</div>
					</div>
					<!-- ad-single -->

				</div>
				<!-- sidebar -->
				<div id="sidebar">
					<!-- ad-list -->
					<div class="ad-list">
						<div class="item">
							<a href="http://www.metromarks.com/toronto" target="_blank"><img src="/img/ads/ad-metromarks.jpg" width="221" height="151" alt="Metromarks Toronto" /></a>
						</div>
						<div class="item">
							<a href="http://yyztech.ca/contacts/advertise/"><img src="/images/ad-221x151.gif" width="221" height="151" alt="Advertise with Us" /></a>
						</div>
						<div class="item">
							<a href="http://yyztech.ca/contacts/advertise/"><img src="/images/ad-221x151.gif" width="221" height="151" alt="Advertise with Us" /></a>
						</div>
						<div class="item">
							<a href="http://yyztech.ca/contacts/advertise/"><img src="/images/ad-221x151.gif" width="221" height="151" alt="Advertise with Us" /></a>
						</div>
						<div class="item">
							<a href="http://yyztech.ca/contacts/advertise/"><img src="/images/ad-221x151.gif" width="221" height="151" alt="Advertise with Us" /></a>
						</div>
					</div>
				</div>
			</div>
			<!-- four cols -->
			<div class="four-cols">
				<div class="holder">
					<div class="frame">
						<div class="col">
							<div class="heading">
								<div class="arrow">
									<h2>LOCATION</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
                            <?php //debug( $locations) ?>
								<ul class="list">
									<?php foreach( $locations as $i => $row ): ?>
                                    <li>
										<a href="/searches/city:<?php echo $row['City']['slug'] ?>"><strong><?php echo $row['City']['name'] . '/venue_type:cafe|restaurant|bar'  ?></strong></a>
                                        <?php if ( !empty($row['CityRegion'])):?>
										<ul>
                                        	<?php foreach( $row['CityRegion'] as $row2 ): ?>
											<li><a href="/searches/city_region:<?php echo $row2['slug'] ?>/city:<?php echo $row['City']['slug'] . '/venue_type:cafe|restaurant|bar'  ?>"><?php echo $row2['name'] ?></a></li>
                                            <?php endforeach; ?>
										</ul>
                                        <?php endif;?>
									</li>
                                    <?php endforeach; ?>                                 
								</ul>
							</div>
						</div>
						<div class="col">
							<div class="heading">
								<div class="arrow">
									<h2>FEATURES</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								<ul class="list">
                                <?php foreach( $services as $i => $row ): ?>
                                	<li><a href="/searches/service:<?php echo $row['slug'] . '/venue_type:cafe|restaurant|bar'  ?>"><?php echo $row['name'] ?></a></li>
								<?php endforeach; ?>	
								</ul>
							</div>
						</div>
						<div class="col">
							<div class="heading">
								<div class="arrow">
									<h2 class="long">VENUE TYPES</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								<ul class="list">
									<?php foreach( $venueTypes as $i => $row ): ?>
                                    <li>
										<a href="/searches/venue_type:<?php echo $row['VenueType']['slug'] ?>"><strong><?php echo $row['VenueType']['name'] ?></strong></a>
                                        <?php if ( !empty($row['VenueSubtype'])):?>
										<ul>
                                        	<?php foreach( $row['VenueSubtype'] as $row2 ): ?>
											<li><a href="/searches/venue_type:<?php echo $row['VenueType']['slug'] . '/venue_type:cafe|restaurant|bar'  ?>/venue_subtype:<?php echo $row2['slug'] ?>"><?php echo $row2['name'] ?></a></li>
                                            <?php endforeach; ?>
										</ul>
                                        <?php endif;?>
									</li>
                                    <?php endforeach; ?>
									<li>
										<a href="#"><strong>Cuisines</strong></a>
										<ul>
										<?php foreach( $cuisines as $i => $row ): ?>
                                            <li><a href="/searches/product:<?php echo $row['slug'] . '/venue_type:cafe|restaurant|bar'  ?>"><?php echo $row['name'] ?></a></li>
                                        <?php endforeach; ?>	
										</ul>
									</li>                                     
								</ul>
							</div>
						</div>
						<div class="col">
							<div class="heading">
								<div class="arrow">
									<h2>PRODUCTS</h2>
									<span>&nbsp;</span>
								</div>
							</div>
							<div class="content">
								<ul class="list">
									<li>
										<a href="#"><strong>Products</strong></a>
										<ul>
										<?php foreach( $products as $i => $row ): ?>
                                            <li><a href="/searches/product:<?php echo $row['slug'] . '/venue_type:cafe|restaurant|bar' ?>"><?php echo $row['name'] ?></a></li>
                                        <?php endforeach; ?>	
										</ul>
									</li>
									<li>
										<a href="#"><strong>Amenities</strong></a>
										<ul>
										<?php foreach( $amenities as $i => $row ): ?>
                                            <li><a href="/searches/amenity:<?php echo $row['slug'] . '/venue_type:cafe|restaurant|bar' ?>"><?php echo $row['name'] ?></a></li>
                                        <?php endforeach; ?>	
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
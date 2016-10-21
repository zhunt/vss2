<?php $comments = $this->requestAction('comments/index/sort:created/direction:desc/limit:8'); 
//debug($comments); exit; 
if ( !empty($comments) ): ?>
	
	
	<?php foreach( $comments as $comment):?>

									<div class="section">
										<div class="top">
											<div class="bottom">
												<div class="section-frame">
													<div class="img"><img src="/images/img-04.gif" alt="#" width="62" height="69" /></div>
													<div class="text-holder">
														<p>On <?php echo $this->Time->format( Configure::read('Time.format_short_no_year'), $comment['Comment']['created']) ?> 
                                                        	<?php echo $comment['Comment']['author']; ?> said:</p>
														<strong><?php echo $this->Text->Truncate(nl2br(trim($comment['Comment']['comment'])),100) ?></strong>
													</div>
												</div>
												<div class="tag-holder">
													<?php echo $this->Html->link( $comment['Venue']['name'], '/' . $comment['Venue']['slug'] ) ?>
													<span><?php $comment['Venue']['address'] ?>, <?php $comment['Venue']['City']['name'] ?></span>
												</div>
											</div>
										</div>
									</div>
		
	<?php endforeach; ?>
<?php endif; ?>
<!-- 
[id] => 4
                    [venue_id] => 50
                    [author] => Zoltan
                    [author_email] => me@me.com
                    [author_url] => yyztech.ca
                    [author_ip] => 2130706433
                    [comment_agent] => Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3
                    [comment] => I think this store is really good!


-->


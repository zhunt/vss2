<style type="text/css">
.ui-stars-star {
	float: left;
	display: block;
	overflow: hidden;
	text-indent: -999em;
	cursor: pointer;
}
.ui-stars-star a {
	width: 10px;
	height: 10px;
	display: block;
	position: relative;
	background: url(/css/crystal-stars-sm.png) no-repeat 0 0;
}
.ui-stars-star a {
	background-position: 0 -56px;
}

.ui-stars-star-hover a {
	background-position: 0 -80px;
}

.ui-stars-star-disabled,
.ui-stars-star-disabled a,
.ui-stars-cancel-disabled a {
	cursor: default !important;
}
</style>

<?php // home_intro.ctp
    $venues = $this->requestAction('/venue_ratings/list_highest_rated/num:' . $num);
    //debug($venues);
    
    if (!empty($venues)) {
      
        foreach($venues as $venue){
            echo '<li>';
			echo '<div class="info">';
            //echo $this->Html->link( $this->Text->truncate($venue['Venue']['full_name'],30), '/' . $venue['Venue']['slug'] );	
			
			echo '<a class="name" href="/' . $venue['Venue']['slug'] . '" title="' . $venue['Venue']['full_name'] .'">' . $this->Text->truncate($venue['Venue']['full_name'],20) . '</a>';								
            
           /* $numStars = round($venue['VenueRating']['score']);
            for( $i=0; $i< $numStars; $i++) {
              echo '<div class="star ui-stars-star ui-stars-star-disabled ui-stars-star-hover"><a title="">1</a></div>';
            }*/
			//echo '<div class="star"><img src="/images/bg-star.gif" alt="#" width="50" height="10" /></div>';
			echo '<p>' . $venue['Venue']['address'] . ', ' . $venue['Venue']['City']['name'] . '</p>';
			echo '</div>';
			echo '</li>';
        }
      
    }
?>


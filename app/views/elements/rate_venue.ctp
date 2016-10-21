<style type="text/css">

#rating_box { color: white; font: bold 12px Arial,Helvetica,sans-serif;}
#rating_val { color: yellow; font-size: 20px;}

#rating_box a, #rating_box a:visited { color: white }

#vote_up {
	background: url(/images/vote_arrows.png) no-repeat scroll 0 0 transparent;
width: 14px;
height: 19px;
	color:#999;
	font-size:14px;
	display:block;
	text-align:center;
	overflow:hidden;
	text-indent: -9999px;
	float: left
	
}

#vote_up:hover {
	background-position:-30px 0;
	text-decoration:none;	
}

#vote_down {
	background: url(/images/vote_arrows.png) no-repeat scroll -14px 1px transparent;
	width: 14px;
	height: 19px;
	color:#999;
	font-size:14px;
	display:inline;
	text-align:center;
	overflow:hidden;
	text-indent: -9999px;
	float: right;
	margin-right: 10px;
}

#vote_down:hover {
	background-position:-44px 1px;
	text-decoration:none;	
}

</style>


<table id="rating_box">
<tr>
	<td>
    <?php if ( !$userAlreadyVoted): ?>
    <a href="#" id="vote_up" title="I like">Up</a>
	<a href="#" id="vote_down" title="I don't like">Down</a>
    <?php else: ?>
	Already Voted
	<?php endif; ?>
	</td>
	<td rowspan="2"> 
    <span id="rating_val" title="Out of <?php echo $venueRating['votes'] ?> votes, <?php echo round( $venueRating['score'] * 100) ?>% of voters liked <?php echo $venue['Venue']['full_name']?>" >
	<?php 
		if ( $venueRating['score'] > 0 ) 
			echo round( $venueRating['score'] * 100) . '%'; 
		else
			echo 'No Votes';
		?>
    </span>
    </td>
</tr>
<tr>
	<td><span id="num_votes"><?php echo $venueRating['votes'] ?> Votes</span></td>
</tr>
</table>

<script>
<?php $this->Html->scriptStart(array('inline' => false)) ?>
$(document).ready(function() {
	
	/*
	* voting code
	*/
	$("a#vote_up").click(function(){
	  $.get("/venue_ratings/ajax_vote", {"id":"<?php echo $venue['Venue']['id']?>" ,"liked":"1"}, function(data){

		$('#rating_val').fadeOut('slow', function() { $('#rating_val').html( data.score + '%').fadeIn() } );
		$('#num_votes').fadeOut('slow', function(){
			$('#num_votes').html( data.votes + ' Votes').fadeIn();
		} );
	  }
	  , "json");
	});

	$("a#vote_down").click(function(){
	  $.get("/venue_ratings/ajax_vote", {"id":"<?php echo $venue['Venue']['id']?>" ,"liked":"-1"}, function(data){
		
		$('#rating_val').fadeOut('slow', function() { 
			$('#rating_val').html( data.score + '%').fadeIn() 
			} );
		$('#num_votes').fadeOut('slow', function(){
			$('#num_votes').html( data.votes + ' Votes').fadeIn();
		} );
	  }
	  , "json");
	});
	
});
<?php $this->Html->scriptEnd() ?>
</script>
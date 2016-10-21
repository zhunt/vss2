<?php 
if ( isset($newListings) ) {
		$venues = $newListings[0]['Venue'];	
		
		foreach($venues as $venue){
			echo '<li>';
			echo '<div class="date"><em>' . $this->Time->format( Configure::read('Time.format_short'),  $venue['created'] ) . '</em></div>';
			echo '<div class="info">';
			echo '<a class="name" href="http://' . Configure::read('Vcc.site_url') . '/' . $venue['slug'] . '" title="' . $venue['full_name'] . '">' . $this->Text->truncate($venue['full_name'],25) . '</a>';
			
			echo '<p>' . $venue['address'] . ', ' . $venue['City']['name'] . '</p>';
			echo '</div>';
			echo '</li>';
		}		
		
	}
	else // for front-page using pagination
	{
		$venues = $this->requestAction('/venues/index/list_type:' . $listType . '/num:' . $num );
	
		foreach($venues as $i => $venue){
			echo '<li>';
			echo '<div class="date"><em>' . $this->Time->format( Configure::read('Time.format_short'),  $venue['Venue']['created'] ) . '</em></div>';
			echo '<div class="info">';
			echo '<a class="name" href="http://' . Configure::read('Vcc.site_url') . '/' . $venue['Venue']['slug'] . '" title="' . $venue['Venue']['full_name'] . '">' . $this->Text->truncate($venue['Venue']['full_name'],25) . '</a>';
			
			echo '<p>' . $venue['Venue']['address'] . ', ' . $venue['City']['name'] . '</p>';
			echo '</div>';
			echo '</li>';
		}
	
}
?>

												
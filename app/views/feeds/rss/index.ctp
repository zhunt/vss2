<?php Configure::write('debug', 0);

    $this->set('documentData', array(
        'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

    $this->set('channelData', array(
        'title' => 'Venue listings from ' . Configure::read('Vcc.site_name'),
        'link' => $html->url('/', true),
        'description' => Configure::read('Vcc.site_name') . ': ' . Configure::read('Vcc.site_tagline'),
        'language' => 'en-us'));
		
    foreach ($venues as $post) { //debug($post);//exit;
        $postTime = strtotime($post['Venue']['created']);

        $hashTag = $post['City']['hash_tag'];
 
        $postLink = '/' . $post['Venue']['slug'];
        // You should import Sanitize
        //App::import('Sanitize');
        // This is the part where we clean the body text for output as the description 
        // of the rss item, this needs to have only text to make sure the feed validates
        $bodyText = $this->Text->truncate( 
			preg_replace('=\(.*?\)=is', '', 
				$post['Venue']['address'] . ', ' . $post['City']['name'] . ' | ' . $post['VenueDetail']['description'])
			, 120);

                if ( $hashTag)
                    $bodyText = $bodyText . ' ' . $hashTag;
			
		if ( !empty($post['VenueScore']['score']) ) {
			$bodyText .= ' Rated: ' . round( $post['VenueScore']['score'] * 100) . '% by ' . $post['VenueScore']['votes']. ' visitors.';	
		}
		
		$bodyText = strip_tags($bodyText);
		
        $bodyText = $this->Text->stripLinks($bodyText);
        $bodyText = Sanitize::stripAll($bodyText);
		
        
        
     
        


        $title = $post['Venue']['full_name'];
        echo $rss->item(array(), array(
				'title' => $title ,
				'link' => $postLink,
				'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
				'description' =>  $bodyText,
				'dc:creator' => Configure::read('Vcc.site_name'),
				'pubDate' => $post['Venue']['created']
				)
			);
    }

?>

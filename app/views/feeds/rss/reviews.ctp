<?php Configure::write('debug', 0);

debug($posts);
/*

            [Post] => Array
                (
                    [name] => Ciboulette et Cie in Midland
                    [slug] => ciboulette-cie-midland
                    [short_dek] => I spent a wonderful afternoon recently on a road trip to the northern edges of Simcoe County, destination; Ciboulette et Cie in Midland. 
                    [wp_created] => 2013-06-16 00:00:00
                )

*/
    $this->set('documentData', array(
        'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

    $this->set('channelData', array(
        'title' => 'Reviews from ' . Configure::read('Vcc.site_name'),
        'link' => $html->url('/', true),
        'description' => Configure::read('Vcc.site_name') . ': ' . Configure::read('Vcc.site_tagline'),
        'language' => 'en-us'));
		
    foreach ($posts as $post) { //debug($post);//exit;
        $postTime = strtotime($post['Post']['wp_created']);

       // $hashTag = $post['City']['hash_tag'];
 
        $postLink = '/news_events/' . $post['Post']['slug'];
        // You should import Sanitize
        //App::import('Sanitize');
        // This is the part where we clean the body text for output as the description 
        // of the rss item, this needs to have only text to make sure the feed validates
        $bodyText = $this->Text->truncate( 
			preg_replace('=\(.*?\)=is', '', 
				$post['Post']['short_dek'])
			, 300);

		//if ( $hashTag)
		//	$bodyText = $bodyText . ' ' . $hashTag;
			
		//if ( !empty($post['VenueScore']['score']) ) {
		//	$bodyText .= ' Rated: ' . round( $post['VenueScore']['score'] * 100) . '% by ' . $post['VenueScore']['votes']. ' visitors.';	
		//}
		
		$bodyText = strip_tags($bodyText);
		
        $bodyText = $this->Text->stripLinks($bodyText);
        $bodyText = Sanitize::stripAll($bodyText);
		

        $title = $post['Post']['name'];
        echo $rss->item(array(), array(
				'title' => $title ,
				'link' => $postLink,
				'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
				'description' =>  $bodyText,
				'dc:creator' => Configure::read('Vcc.site_name'),
				'pubDate' => date('D, d M Y h:i:s O', strtotime($post['Post']['wp_created']) ) 
				)
			);
    }

?>

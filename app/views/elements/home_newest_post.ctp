<style>

ul#latest_news {
	list-style: none outside none;
    margin: 0 20px 20px 0;
    padding: 0;
	}
	
#latest_news li { list-style: none outside none;
    margin: 0;
    padding: 0; }

#latest_news a:hover {color: #00b7f9; }
#latest_news a {color: #000; }

#latest_news .address { color: #666; }

#latest_news .read-link { font-weight: bold; color: #666;  }

#latest_news .title-block {
color: #000000;
    display: block;
    font-family: DroidSansBold;
    font-size: 16px;
    margin: 0 0 7px;
}
	
</style>

<?php
	// home_newest_post.php
	$latestPosts = $this->requestAction('posts/latest_news/limit:1');
	
	if ($latestPosts) {
		echo '<h2>Latest News</h2>';
		echo '<ul id="latest_news" >';
		foreach( $latestPosts as $post) {
			echo '<li>';
			echo '<strong class="title-block"><a href="/news_events/' . $post['Post']['slug'] . '">' . $post['Post']['name'] . '</a></strong>';
			echo '<span class="address">' . $this->Time->format('j-M-y' , $post['Post']['wp_created']) . '</span> ';	
			echo '</strong>';
			echo '<em>' . $post['Post']['short_dek'];
			echo '&nbsp;<a href="/news_events/' . $post['Post']['slug'] .'" title="' . $post['Post']['name'] . '" class="read-link">Read more</a> </em>';
			echo '</li>';
		}
		echo '</ul>';
	}
?>
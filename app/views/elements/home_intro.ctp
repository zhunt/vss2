<?php // home_intro.ctp
	$html = $this->requestAction('/vss_pages/view/slug:' . $page_key);
	if (!empty($html))
		echo $html
?>
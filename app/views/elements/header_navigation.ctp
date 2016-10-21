<?php
if ( strpos( $_SERVER['HTTP_HOST'], Configure::read('Vcc.site_url') ) !== false) {
	$baseUrl = 'http://www.' . Configure::read('Vcc.site_url');
} else {
	$baseUrl = '';
}
?>

<div class="header-top">
<!-- logo -->
	<h3 class="logo"><a href="<?php echo $baseUrl ?>/">SimcoeDining</a></h3>
	<!-- form-holder -->
	<div class="form-holder">
	<!-- search-form -->
		<form action="#" class="search-form">
			<fieldset>
				<div class="text"><input type="text" id="search_box" /></div>
				<input type="submit" class="submit" value="search" />
			</fieldset>
		</form>
		<!-- orm-text -->
		<div class="form-text"><span><em>Try some popular searches:</em> Bars in Barrie, Restaurants and Bars with Patios, Coffee in Barrie</span></div>
	</div>
</div>

<div class="header-navigation">
    <ul>
        <li><a href="<?php echo $baseUrl ?>/" title="Home" id="hnav_home"><em>HOME</em><span></span></a></li>
        <li><a href="<?php echo $baseUrl ?>/landings/venue_type/restaurant" title="Restaurants" id="hnav_rest"><em>RESTAURANTS</em><span></span></a></li>
        <li><a href="<?php echo $baseUrl ?>/landings/venue_type/bar" title="Bars &amp; Clubs" id="hnav_bar"><em>BARS &amp; CLUBS</em><span></span></a></li>
        <li><a href="<?php echo $baseUrl ?>/landings/venue_type/cafe" title="Coffee, Cafes, Markets" id="hnav_cafe"><em>COFFEE &amp; MARKETS</em><span></span></a></li>
		<li><a href="<?php echo $baseUrl ?>/landings/venue_type/hotel" title="Hotels" id="hnav_hotel"><em>HOTELS</em><span></span></a></li>
		<li><a href="<?php echo $baseUrl ?>/news_events/" title="Hotels" id="hnav_news"><em>REVIEWS</em><span></span></a></li>
      <!--  <li><a href="<?php echo $baseUrl ?>/landings/venue_type/cater" title="Centers" id="hnav_cater"><em>CATERS</em><span></span></a></li>
        <li><a href="<?php echo $baseUrl ?>/landings/venue_type/attraction" title="Attractions, Resorts" id="hnav_attract"><em>ATTRACTIONS</em><span></span></a></li>
        -->
    </ul>
</div>

<?php if ( isset($cssId) ):?>
<style type="text/css">
.header-navigation ul li a<?php echo $cssId ?> {
	text-decoration:none;
	background:none;
}
.header-navigation ul li a<?php echo $cssId ?> span {
	background:url(/images/bg-nav-r.gif) no-repeat 100% 0;
}
.header-navigation ul li a<?php echo $cssId ?> em {
	background:url(/images/bg-nav.gif) no-repeat;
	color:#fff;
}
</style>
<?php endif ?>
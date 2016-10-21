<!-- microformat data  -->
<!--
<div class="hreview" style="display:none">
    <span id="VenueVenueId"><?php echo $this->data['Venue']['id'] ?></span>
   <span class="item vcard">
      <span class="fn org"><?php echo $this->data['Venue']['full_name'] ?></span>
      Located at
      <span class="adr">
         <span class="street-address"><?php echo $this->data['Venue']['address'] ?></span>,
         <span class="locality"><?php echo $this->data['City']['name'] ?></span>,
         <span class="region"><?php echo Configure::read('Vcc.location_province') ?></span>.
         <span class="postal-code"><?php echo $this->data['VenueDetail']['postal_code'] ?></span>
      </span>
     <span class="geo">
        <span class="latitude">
           <span class="value-title" title="<?php echo $this->data['Venue']['geo_lat'] ?>"></span>
        </span>
        <span class="longitude">
           <span class="value-title" title="<?php echo $this->data['Venue']['geo_lng'] ?>"></span>
        </span>
     </span>
   <span class="tel"><?php echo str_replace('.','-',$venue['Venue']['phone']) ?></span>
   <?php
   if ( !empty($this->data['VenueDetail']['website_url']) ) {
	   $websiteUrl = !strpos( $this->data['VenueDetail']['website_url'], 'http') == false ? '' : 'http://';
	   $websiteUrl .= $this->data['VenueDetail']['website_url']; 
   } else {
		$websiteUrl = '';
   }
   ?>
   <a href="<?php echo $websiteUrl ?>" class="url"><?php echo $websiteUrl ?></a>
   </span>
   Reviewed by
   <span class="reviewer">Visitors to <?php echo Configure::read('Vcc.site_name') ?></span>.
   Rated:
   <span class="rating">
      <span class="value"><?php echo round( $venueRating['score'] * 100) ?></span>/
      <span class="best">100</span>
   </span>
</div>


<!-- RDF 
<div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Organization" style="display: none">
   <span property="v:name"><?php echo $this->data['Venue']['full_name'] ?></span>
   <div rel="v:address">
      <div typeof="v:Address">
         <span property="v:street-address"><?php echo $this->data['Venue']['address'] ?></span>,
         <span property="v:locality"><?php echo $this->data['City']['name'] ?></span>,
         <span property="v:region"><?php echo Configure::read('Vcc.location_province') ?></span>
         <span property="v:postal"><?php echo $this->data['VenueDetail']['postal_code'] ?></span>
      </div>
   </div>
   <div rel="v:geo">
      <span typeof="v:Geo">
         <span property="v:latitude" id="venueLat" content="<?php echo $this->data['Venue']['geo_lat'] ?>"></span>
         <span property="v:longitude" id="venueLng" content="<?php echo $this->data['Venue']['geo_lng'] ?>"></span>
      </span>
   </div>
   <span property="v:tel"><?php echo str_replace('.','-',$venue['Venue']['phone']) ?></span>
   <a href="<?php echo $websiteUrl ?>" rel="v:url"><?php echo $websiteUrl ?></a>
</div>
-->
		<!-- need these for map to work -->
         <span style="display: none" id="venueLat" content="<?php echo $this->data['Venue']['geo_lat'] ?>"></span>
         <span style="display: none" id="venueLng" content="<?php echo $this->data['Venue']['geo_lng'] ?>"></span>
		 
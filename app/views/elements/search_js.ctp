
<script language="javascript">
//$("#search_map").fadeTo("fast", 0.01);

$(document).ready(function() {
	
	if (GBrowserIsCompatible()) { 
		// Create a Map
		var map = new GMap2(document.getElementById("search_map"));
        map.setCenter(new GLatLng( jsonData.markers[0].lat, jsonData.markers[0].lng ), 9);
        map.setUIToDefault();
		
		var points = Array();
		
		mapSize = new GLatLngBounds();
		
        // === Plot the markers ===
		for (var i=0; i<jsonData.markers.length; i++) {
			var point = new GLatLng(jsonData.markers[i].lat, jsonData.markers[i].lng);
			points.push(point);
			mapSize.extend(point);
			//var marker = createMarker(point, jsonData.markers[i].label, jsonData.markers[i].html);
			var marker = new GMarker(point);
			
			// now the overlay
			var tooltip = new Tooltip(marker,jsonData.markers[i].label,5);
			
			marker.tooltip = tooltip;
			marker.htmlData = jsonData.markers[i].html;
			map.addOverlay(marker);
			map.addOverlay(tooltip);
			
			GEvent.addListener(marker,"click", function() {
			  this.openInfoWindowHtml(this.htmlData); 
			  this.tooltip.hide();
			});
					
			GEvent.addListener(marker,"mouseover",function(){
				this.tooltip.show();
			});
			GEvent.addListener(marker,"mouseout",function(){
				this.tooltip.hide();
			});
			
			
			

		}

		bounds = new GBounds( points );		
		zoomLevel = best_zoom( bounds, $('#search_map') );
		zoomLevel = 16 - zoomLevel;
		
		if ( jsonData.markers.length == 1 )
			zoomLevel = 16;

		mapCentre = mapSize.getCenter();
		map.setCenter(mapCentre, zoomLevel );
	}
	
	//
	/**
	 * Utility function to calculate the appropriate zoom level for a
	 * given bounding box and map image size. Uses the formula described
	 * in the Google Mapki (http://mapki.com/).
	 *
	 * @param  bounds  bounding box (GBounds instance)
	 * @param  mnode   DOM element containing the map.
	 * @return         zoom level.
	 */
	function best_zoom(bounds, mnode) {
		var width = $('#search_map').attr('offsetWidth'); //mnode.offsetWidth;
		var height = $('#search_map').attr('offsetHeight'); //mnode.offsetHeig

		var dlat = Math.abs(bounds.maxY - bounds.minY);
		var dlon = Math.abs(bounds.maxX - bounds.minX);
			
		if(dlat == 0 && dlon == 0)
			return 4;
	
		// Center latitude in radians
		var clat = Math.PI*(bounds.minY + bounds.maxY)/360.;
	
		var C = 0.0000107288;
		var z0 = Math.ceil(Math.log(dlat/(C*height))/Math.LN2);
		var z1 = Math.ceil(Math.log(dlon/(C*width*Math.cos(clat)))/Math.LN2);
				
		return (z1 > z0) ? z1 : z0;
	} 	

	// A function to create the marker and set up the event window
	function createMarker(point,name,html) {
		var marker = new GMarker(point);
		/*
		GEvent.addListener(marker, "click", function() {
		  marker.openInfoWindowHtml(html);
		});
		
		*/
		
		return marker;
	}
	
	// -----------------------------------------------------
		  
});
</script>	

<script language="javascript">
// Tooltip.js
/**
 * @author Marco Alionso Ramirez, marco@onemarco.com
 * @url http://onemarco.com
 * @version 1.0
 * This code is public domain
 */

/**
 * The Tooltip class is an addon designed for the Google Maps GMarker class. 
 * @constructor
 * @param {GMarker} marker
 * @param {String} text
 * @param {Number} padding
 */

	function Tooltip(marker, text, padding){
		this.marker_ = marker;
		this.text_ = text;
		this.padding_ = padding;
	}

	Tooltip.prototype = new GOverlay();
	
	Tooltip.prototype.initialize = function(map){
		var div = document.createElement("div");
		div.appendChild(document.createTextNode(this.text_));
		div.className = 'tooltip';
		div.style.position = 'absolute';
		div.style.visibility = 'hidden';
		map.getPane(G_MAP_FLOAT_PANE).appendChild(div);
		this.map_ = map;
		this.div_ = div;
	}
	
	Tooltip.prototype.remove = function(){
		this.div_.parentNode.removeChild(this.div_);
	}
	
	Tooltip.prototype.copy = function(){
		return new Tooltip(this.marker_,this.text_,this.padding_);
	}
	
	Tooltip.prototype.redraw = function(force){
		if (!force) return;
		var markerPos = this.map_.fromLatLngToDivPixel(this.marker_.getPoint());
		var iconAnchor = this.marker_.getIcon().iconAnchor;
		var xPos = Math.round(markerPos.x - this.div_.clientWidth / 2);
		var yPos = markerPos.y - iconAnchor.y - this.div_.clientHeight - this.padding_;
		this.div_.style.top = yPos + 'px';
		this.div_.style.left = xPos + 'px';
	}
	
	Tooltip.prototype.show = function(){
		this.div_.style.visibility = 'visible';
	}
	
	Tooltip.prototype.hide = function(){
		this.div_.style.visibility = 'hidden';
	}

</script>

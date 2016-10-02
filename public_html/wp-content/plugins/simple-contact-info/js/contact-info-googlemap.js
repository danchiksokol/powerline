jQuery(document).ready(function($) {

	/**
	 *	Defines:
	 *		sci_google_address
	 *		sci_google_zoom
	 *		sci_google_maptype
 	 *
	 *	in "inc/widgets/contact-googlemaps-widget.php"
	*/

	if ( sci_google_address !== '' ) {
		geocoder = new google.maps.Geocoder();

		geocoder.geocode( { 'address': sci_google_address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {

				var map_type = google.maps.MapTypeId.ROADMAP;
				switch( sci_google_maptype ) {
					case 'roadmap':
						var map_type = google.maps.MapTypeId.ROADMAP;
						break;
					case 'satellite':
						var map_type = google.maps.MapTypeId.SATELLITE;
						break;
					case 'hybrid':
						var map_type = google.maps.MapTypeId.HYBRID;
						break;
					case 'terrain':
						var map_type = google.maps.MapTypeId.TERRAIN;
						break;
				}

				var mapOptions = {
					zoom: parseInt(sci_google_zoom),
					center: results[0].geometry.location,
					mapTypeId: map_type
				};

				var map = new google.maps.Map(document.getElementById("sci-google-map"), mapOptions);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});
			}
		});
	}

});
var gp_custom_banners_tracker = (function () {
	var my_name = "Custom Banners by Gold Plugins (goldplugins.com)";
	var banner_list = [];
	
	var say_hello = function () {
		alert("Hello! My name is " + my_name + ", nice to meet you.");
	};
	
	var log_view = function (banner_id, nonce) {
		
		if ( typeof(custom_banners_tracking_vars) == 'undefined' ) {
			return;
		}
			
		if ( jQuery && custom_banners_tracking_vars.ajaxurl )
		{
			jQuery.ajax({
				url: custom_banners_tracking_vars.ajaxurl,
				data:({
					action: 'custom_banners_pro_log_impression',
					banner_id: banner_id,
					nonce: nonce,
					r: Math.random()
				}),
				type: 'POST'
			});
		}
		
	};
	
	var auto_log = function () {
		var banners_to_track = jQuery("input[name='_custom_banners_pro_track_banner[]']");
		banners_to_track.each( function ( index ) {
			var banner_id = jQuery(this).val(),
				nonce = jQuery(this).data('nonce');
			log_view( banner_id, nonce );
			//banner_list.push ( banner_id );
		});
		//console.log( banner_list );
	};
	
	// automatically find impressions to log
	auto_log();

	// expose these functions publicly
	return {
		log_view,
		//set_goal_cookies
	}	
})();
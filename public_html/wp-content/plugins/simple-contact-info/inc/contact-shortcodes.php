<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

// ------------- Functions ------------- 

/*
 * Display social icons.
 */
function sci_social_shortcode_init( $attr, $content ){
	wp_register_style( 'contact-info.css', SCI_URL . 'css/contact-info-frondend.css', array(), '1.0' );
	wp_enqueue_style( 'contact-info.css');

	$attr = shortcode_atts(
		array(
			'orientation' => 'horizontal',
		), $attr
	);

	// Links
	$twitter_link 	= get_option( 'qs_contact_twitter' );
	$facebook_link 	= get_option( 'qs_contact_facebook' );
	$youtube_link	= get_option( 'qs_contact_youtube' );
	$google_link 	= get_option( 'qs_contact_google' );
	$linkedin_link 	= get_option( 'qs_contact_linkedin' );

	// Icons
	$twitter_icon 	= get_option( 'qs_contact_twitter_icon' );
	$facebook_icon 	= get_option( 'qs_contact_facebook_icon' );
	$youtube_icon 	= get_option( 'qs_contact_youtube_icon' );
	$google_icon 	= get_option( 'qs_contact_google_icon' );
	$linkedin_icon 	= get_option( 'qs_contact_linkedin_icon' );

	extract($attr);

	global $wpdb;
	$custom_options = $wpdb->get_col( "SELECT `option_name` FROM $wpdb->options WHERE `option_name` LIKE 'qs_contact_custom_%';" );

	$result = '<div class="sci-social-icons"><ul class="sci-social-icons-' . $orientation . '">'; 
		if ( !empty( $twitter_link ) ) {
			$result .= '<li><a href="' . esc_url( $twitter_link ) . '" target="_blank" title="Twitter"><img src="' . esc_url( $twitter_icon ) . '" alt="Twitter"></a></li>';
		}
		if ( !empty( $facebook_link ) ) {
			$result .= '<li><a href="' . esc_url( $facebook_link ) . '" target="_blank" title="Facebook"><img src="' . esc_url( $facebook_icon ) . '" alt="Facebook"></a></li>';
		}
		if ( !empty( $youtube_link ) ) {
			$result .= '<li><a href="' . esc_url( $youtube_link ) . '" target="_blank" title="YouTube"><img src="' . esc_url( $youtube_icon ) . '" alt="YouTube"></a></li>';
		} 
		if ( !empty( $google_link ) ) {
			$result .= '<li><a href="' . esc_url( $google_link ) . '" target="_blank" title="Google+"><img src="' . esc_url( $google_icon ) . '" alt="Google+"></a></li>'; 
		} 
		if ( !empty( $linkedin_link ) ) {
			$result .= '<li><a href="' . esc_url( $linkedin_link ) . '" target="_blank" title="LinkedIn"><img src="' . esc_url( $linkedin_icon ) . '" alt="LinkedIn"></a></li>';
		}
		if ( !empty( $custom_options ) ) {
			foreach ( $custom_options as $key => $value ) {
				$network = str_replace( 'qs_contact_custom_', '', $value );
				$link = get_option( 'qs_contact_custom_' . $network );
				$icon = get_option( 'qs_contact_' . $network . '_icon' );
				if ( !empty( $link ) && !empty( $icon ) ) {
					$result .= '<li><a href="' . esc_url( $link ) . '" target="_blank" title="' . $network . '"><img src="' . esc_url( $icon ) . '" alt="' . $network . '"></a></li>';
				}
			}
		}
	$result .= '</ul></div>';

	return $result;
}
add_shortcode( 'sci_social', 'sci_social_shortcode_init' );
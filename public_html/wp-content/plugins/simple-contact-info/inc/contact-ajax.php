<?php
// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

// ------------- Functions ------------- 

function sci_ajax_delete_icon_callback() {
	if ( isset( $_POST['icon'] ) && !empty( $_POST['icon'] ) ) {
		$uploads_dir = wp_upload_dir();
		$icon = str_replace( $uploads_dir['baseurl'], '', $_POST['icon'] );
		if ( unlink( $uploads_dir['basedir'] . $icon ) ) {
			echo true;
		} else {
			echo false;
		}
	}

	die();
}
add_action( 'wp_ajax_sci_ajax_delete_icon', 'sci_ajax_delete_icon_callback' );

function sci_ajax_delete_option_callback() {
	if ( isset( $_POST['option'] ) && !empty( $_POST['option'] ) ) {
		delete_option($_POST['option']);
		delete_option($_POST['option'].'_icon');
	}

	die();
}
add_action( 'wp_ajax_sci_ajax_delete_option', 'sci_ajax_delete_option_callback' );
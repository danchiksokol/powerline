<?php
/*
	Plugin Name: Simple Contact Info
	Plugin Uri: http://wordpress.org/plugins/simple-contact-info/
	Description: You can write contact information (facebook, phone, fax, address etc). You can use widgets or shortcode to display it anywhere you want.
	Version: 1.1.9
	Author: LehaMotovilov
	Author URI: http://lehaqs.wordpress.com/
	Text Domain: simple-contact-info
	Domain Path: /languages
*/

// Block direct requests
if ( !defined('ABSPATH') ) {
	exit();
}

// ------------- Plugin Init ------------- 

function sci_init() {
	// ------------- Setup ------------- 
	$pathinfo = pathinfo( dirname( plugin_basename( __FILE__ ) ) );
	if ( !defined( 'SCI_DIR' ) ) define( 'SCI_DIR', plugin_dir_path( __FILE__ ) );
	if ( !defined( 'SCI_NAME' ) ) define( 'SCI_NAME', $pathinfo['filename'] );
	if ( !defined( 'SCI_URL' ) ) define( 'SCI_URL', plugins_url(SCI_NAME) . '/' ); 

	// ------------- Translate ------------- 
	load_plugin_textdomain( 'simple-contact-info', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	
	// ------------- Includes ------------- 
	include( SCI_DIR . '/inc/contact-ajax.php' );
	include( SCI_DIR . '/inc/contact-shortcodes.php' );

	include( SCI_DIR . '/inc/pages/contact-info.php' );
	include( SCI_DIR . '/inc/pages/contact-social.php' );
	include( SCI_DIR . '/inc/pages/contact-add-social.php' );
	include( SCI_DIR . '/inc/pages/contact-help.php' );

	include( SCI_DIR . '/inc/widgets/contact-social-widget.php' );
	include( SCI_DIR . '/inc/widgets/contact-googlemaps-widget.php' );
	include( SCI_DIR . '/inc/widgets/contact-address-widget.php' );
	include( SCI_DIR . '/inc/widgets/contact-info-widget.php' );
}
add_action( 'plugins_loaded', 'sci_init' );

if ( is_admin() && sci_check() ) {
	add_action( 'admin_enqueue_scripts', 'sci_admin_enqueue_scripts' );
}

function sci_check() {
	if ( isset( $_GET['page'] ) && ( $_GET['page'] == 'simple-contact-info/contact-info.php' || $_GET['page'] == 'contact_social' || $_GET['page'] == 'contact_add_social' || $_GET['page'] == 'contact_help' ) ) {
		return true;
	} else {
		return false;
	}
}

// Add settings link on plugin page
function sci_plugin_settings_link( $links ) { 
	$title = __( 'Settings', 'simple-contact-info' );
	$settings_link = '<a href="admin.php?page=simple-contact-info/contact-info.php">' . $title . '</a>'; 
	array_unshift( $links, $settings_link ); 

	return $links; 
}
add_filter( 'plugin_action_links_simple-contact-info/contact-info.php', 'sci_plugin_settings_link' );

// Add css and js for plugin
function sci_admin_enqueue_scripts() {
	wp_register_style( 'contact-info', SCI_URL . 'css/contact-info-backend.css', array(), '1.0' );
	wp_enqueue_style( 'contact-info' );

	wp_register_script( 'sci-admin', SCI_URL . 'js/contact-info-backend.js', array(), '1.0' );
	wp_enqueue_script( 'sci-admin', SCI_URL . 'js/contact-info-backend.js', '1.0' );

	// jQuery UI for social icons
	wp_enqueue_style( 'jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css'); 
	wp_enqueue_script( 'jquery-ui-core', array( 'jquery' ) );
	wp_enqueue_script( 'jquery-ui-dialog', array( 'jquery','jquery-ui-core' ) );
}

// Add menu page for admin menu
function sci_add_menu_pages() {
	// Support 3.8+ version, new cool icons on admin menu
	$theme_url = get_template_directory_uri();

	if ( ( get_bloginfo( 'version' ) >= '3.8' ) || in_array( 'mp6/mp6.php', (array)get_option( 'active_plugins', array() ) ) ) {
		$icon = 'dashicons-id-alt';
	} else {
		$icon = SCI_URL . '/images/icons/cpt_portfolio.png';
	}

	add_menu_page( $title = __( 'Contact info', 'simple-contact-info' ), $title, 'edit_others_posts', __FILE__, 'sci_contact_info_admin', $icon );
	add_submenu_page( __FILE__, $title = __( 'Social icons', 'simple-contact-info' ), $title, 'edit_others_posts', 'contact_social', 'sci_contact_info_social' );
	add_submenu_page( __FILE__, $title = __( 'Add social network', 'simple-contact-info' ), $title, 'edit_others_posts', 'contact_add_social', 'sci_contact_info_add_social' );
	add_submenu_page( __FILE__, $title = __( 'Help', 'simple-contact-info' ), $title, 'edit_others_posts', 'contact_help', 'sci_contact_info_help' );
}
add_action( 'admin_menu', 'sci_add_menu_pages' );

// ------------- Plugin uninstall ------------- 

function sci_plugin_uninstall() {
	// Remove custom icons
	$upload_dir = wp_upload_dir();
	$customFolser = $upload_dir['basedir'] . '/sci-custom-icons/';
	if ( file_exists( $customFolser ) && is_dir( $customFolser ) ) {
		$dir 	= $customFolser;
		$it 	= new RecursiveDirectoryIterator( $dir );
		$files 	= new RecursiveIteratorIterator( $it, RecursiveIteratorIterator::CHILD_FIRST );
		foreach( $files as $file ) {
			if ( $file->getFilename() === '.' || $file->getFilename() === '..' ) {
				continue;
			}

			if ( $file->isDir() ){
				rmdir( $file->getRealPath() );
			} else {
				unlink( $file->getRealPath() );
			}
		}
		rmdir( $dir );
	}

	// Remove all options
	global $wpdb;
	$customOptions = $wpdb->get_results( "SELECT `option_name` FROM $wpdb->options WHERE `option_name` LIKE 'qs_contact_%'" );

	if ( !empty( $customOptions ) ) {
		foreach ( $customOptions as $key => $value ) {
			delete_option( $value->option_name );
		}
	}
}
register_uninstall_hook( __FILE__, 'sci_plugin_uninstall' );

// ------------- Functions ------------- 

function sci_updated_notice( $msg, $error = false ) { ?>
	<?php if ( $error ) { ?>
		<div class="error">
			<p><?php _e( $msg ); ?></p>
		</div>	
	<?php } else { ?>
		<div class="updated">
			<p><?php _e( $msg ); ?></p>
		</div>
	<?php } ?>
<?php }
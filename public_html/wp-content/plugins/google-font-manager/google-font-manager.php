<?php
/*
Plugin Name: Google Font Manager
Plugin URI: http://butlerconsulting.com/work/plugins/google-font-manager/
Description: Adds a library of selected Google Fonts to your WordPress site with a backend font selection and preview system.
Version: 1.1.4
Author: Thomas S. Butler
Author URI: http://butlerconsulting.com/
Text Domain: google-font-manager
*/

/*
	
    * @author Thomas S. Butler (email : tom@opportunex.com)
    * @copyright 2013-2014 All Rights Reserved.  Google Font Manager - A WordPress Plugin.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    To get a copy of the GNU General Public License, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
    Or, visit <http://www.gnu.org/licenses/>.
    
*/

//remove comments for debugging:
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

//exit if accessed directly
if(!defined('ABSPATH')) exit;

global $wp_version;

//create text domain and defaults
function googlefontmgr_textdomain() {
    //set text domain for translations
	load_plugin_textdomain('google-font-manager', false, 'google-font-manager');
}
add_action('init', 'googlefontmgr_textdomain');

$is_networkactive = false;
$fonsterpluginurl = WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)).'/';
$fonsterpluginpath = WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)).'/';

//add global option for multisite installs
if (!function_exists('is_plugin_active_for_network')) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    if (is_multisite() && is_plugin_active_for_network('google-font-manager/google-font-manager.php')) {      
        global $wp_version, $is_networkactive;
        $is_networkactive = true;
        //add network admin submenu for 3.1 or higher
        function network_admin_page() {
            add_submenu_page('settings.php', 'Google Font API', 'Google Font API', 'manage_options', 'wp_googlefontmgr_admin_page', 'wp_googlefontmgr_admin_page');
        }
        //add network admin submenu for 3.0.9 or lower (not campatible under 3.0)
        function old_network_admin_page() {
            add_submenu_page('ms-admin.php', 'Google Font API', 'Google Font API', 'manage_options', 'wp_googlefontmgr_admin_page', 'wp_googlefontmgr_admin_page');
        }
        //add the super admin page
        if( version_compare( $wp_version , '3.0.9', '>' ) ) {
            add_action( 'network_admin_menu', 'network_admin_page');
        } else {
            add_action( 'admin_menu', 'old_network_admin_page');
        } 
    } else {
        //if not network activated, remove global API key
        delete_site_option('wp_googlefontmgr_globalkey');
    }        
}

//register plugin scripts
function wp_googlefontmgr_admin_init() {
    wp_register_script('jquery_ui_files', plugins_url( 'js/jquery.autocomplete.js', __FILE__ ));
    wp_register_script('wp_googlefontmgr_script', plugins_url( 'js/jquery.pluginscript.js', __FILE__ ), array( 'wp-color-picker' ), false, true);
    wp_register_script('wpgfm-radiobutton', plugins_url( 'js/jquery.radiobutton.js', __FILE__ ));
    wp_register_script('wpgfm-scrollto-js', plugins_url( 'js/jquery.scrollTo.min.js', __FILE__ ));
    wp_register_script('wpgfm-localscroll-js', plugins_url( 'js/jquery.localScroll.min.js', __FILE__ ));
    wp_register_script('wpgfm-easing-js', plugins_url( 'js/jquery.easing.min.js', __FILE__ ));
    wp_register_script('wpgfm-spinbox-js', plugins_url( 'js/spinbox.js', __FILE__ ));
    wp_register_style('jquery_ui_styles', plugins_url( 'css/jquery.ui.min.css', __FILE__ ));
    wp_register_style('wp_googlefontmgr_styles', plugins_url( 'css/style.css', __FILE__ ));    
}
add_action('admin_init', 'wp_googlefontmgr_admin_init');

//add template designer page to custom post type
function wp_googlefontmgr_admin() {
    $page_hook_suffix = add_options_page('Google Font Manager', 'Google Font Manager', 'manage_options', 'google-font-manager', 'wp_googlefontmgr_plugin_options');
    add_action('admin_print_scripts-' . $page_hook_suffix, 'wp_googlefontmgr_scripts'); 
}
add_action('admin_menu' , 'wp_googlefontmgr_admin');

//enqueue stylesheet for network admin page
function wp_googlefontmgr_network_scripts() {
    global $current_screen;
    if(!$current_screen->is_network) return;
    wp_register_style('wp_googlefontmgr_styles', plugins_url( 'css/style.css', __FILE__ ));
    wp_enqueue_style('wp_googlefontmgr_styles');
}
add_action('admin_print_scripts', 'wp_googlefontmgr_network_scripts');

//get network admin page for super admin
function wp_googlefontmgr_admin_page(){
    require_once dirname( __FILE__ ) .'/ajax/network_admin.php';
}

//enqueue the scripts files
function wp_googlefontmgr_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery_ui_files');
    wp_enqueue_script('wp_googlefontmgr_script');
    wp_enqueue_script('wpgfm-radiobutton');
    wp_enqueue_script('wpgfm-scrollto-js');
    wp_enqueue_script('wpgfm-localscroll-js');
    wp_enqueue_script('wpgfm-spinbox-js');
    wp_enqueue_script('wpgfm-easing-js');
    wp_enqueue_style('jquery_ui_styles');
    wp_enqueue_style('wp_googlefontmgr_styles');
    wp_enqueue_style( 'wp-color-picker' );
}

//launch the font selector
function wp_googlefontmgr_plugin_options(){
    require_once dirname( __FILE__ ) .'/wireframe.php';
}

//validate google api key (normal)
function wp_googlefontmgr_key_callback() {
    $wp_googlefontmgr_apikey = intval( $_POST['wp_googlefontmgr_apikey'] );
	require_once dirname( __FILE__ ) .'/ajax/set_google_api.php'; die(); 
}
add_action('wp_ajax_wp_googlefontmgr_key', 'wp_googlefontmgr_key_callback');

//validate google api key (global)
function wp_googlefontmgr_globalapi_callback() {
    $wp_googlefontmgr_globalkey = intval( $_POST['wp_googlefontmgr_globalkey'] );
	require_once dirname( __FILE__ ) .'/ajax/set_google_api.php'; die(); 
}
add_action('wp_ajax_wp_googlefontmgr_globalapi', 'wp_googlefontmgr_globalapi_callback');

//get the google fonts file
function wp_googlefontmgr_getfonts_callback() {
    require_once dirname( __FILE__ ) .'/ajax/google_fonts.php'; die(); 
}
add_action('wp_ajax_wp_googlefontmgr_getfonts', 'wp_googlefontmgr_getfonts_callback');

//set google font selection
function wp_googlefontmgr_setfonts_callback() {
    $font = intval( $_POST['font'] );
	require_once dirname( __FILE__ ) .'/ajax/set_google_font.php'; die(); 
}
add_action('wp_ajax_wp_googlefontmgr_setfonts', 'wp_googlefontmgr_setfonts_callback');

//remove google font selection
function wp_googlefontmgr_killfonts_callback() {
    $font = intval( $_POST['font'] );
    $remove = intval( $_POST['remove'] );
	require_once dirname( __FILE__ ) .'/ajax/set_google_font.php'; die(); 
}
add_action('wp_ajax_wp_googlefontmgr_killfonts', 'wp_googlefontmgr_killfonts_callback');

//get font inspector properties
function wp_googlefontmgr_inspector_callback() {
    $font = intval( $_POST['font'] );
    require_once dirname( __FILE__ ) .'/ajax/get_font_data.php'; die(); 
}
add_action('wp_ajax_wp_googlefontmgr_inspector', 'wp_googlefontmgr_inspector_callback');

//get font inspector properties
function wp_googlefontmgr_setoptions_callback() {
    $val = intval( $_POST['val'] );
    $element = intval( $_POST['element'] );
    require_once dirname( __FILE__ ) .'/ajax/set_style_options.php'; die(); 
}
add_action('wp_ajax_wp_googlefontmgr_setoptions', 'wp_googlefontmgr_setoptions_callback');

//get font inspector properties
function wp_googlefontmgr_setstyle_callback() {
    $stylesheet = intval( $_POST['stylesheet'] );
    require_once dirname( __FILE__ ) .'/ajax/set_style_options.php'; die(); 
}
add_action('wp_ajax_wp_googlefontmgr_setstyle', 'wp_googlefontmgr_setstyle_callback');

//check if visual editor font options enabled
$editorfonts = get_option("wp_googlefontmgr_editorfonts", 1);   

//add font selection to TinyMCE (depricated since 3.9)
function wp_googlefontmgr_formatOLDTinyMCE($init) {
    
    if($editorfonts) {
        if($websafefonts) {  
            //get websafefont list
            $safefontlist = 'Arial=Arial,Helvetica,sans-serif,Arial Black=Arial Black,Gadget,sans-serif,Comic Sans=Comic Sans MS,Comic Sans MS,cursive,Courier New=Courier New,Courier New,Courier,monospace,Georgia=Georgia,Georgia,serif,';
            $safefontlist .= 'Impact=Impact,Charcoal,sans-serif,Lucida Console=Lucida Console,Monaco,monospace,Lucida Sans Unicode=Lucida Sans Unicode,Lucida Grande,sans-serif,Palatino Linotype=Palatino Linotype,Book Antiqua,Palatino,serif,';
            $safefontlist .= 'Tahoma=Tahoma,Geneva,sans-serif,Times New Roman=Times New Roman,Times,serif,Trebuchet MS=Trebuchet MS,Helvetica,sans-serif,Verdana=Verdana,Geneva,sans-serif,Gill Sans=Gill Sans,Geneva,sans-serif,';
        }
        $fontdata = get_option("wp_googlefontmgr_fonts");
        //get the google font list
        if($fontdata) {
            //load fonts for use in plugin
            $array = explode(",", $fontdata);
            foreach($array as $value) {
                $myfontlist .=sprintf(_('%s=%s,'), $value, $value);
                $mycsslist .= "//fonts.googleapis.com/css?family=" .urlencode($value). ",";
            }
        }
        //check if websafe fonts are to be loaded
        if($websafefonts){
            $myfontlist = $myfontlist. $safefontlist;
        }
        $init['content_css']=get_template_directory_uri() . "/editor-style.css";
        $init['content_css']=rtrim($mycsslist,',');
        $init['theme_advanced_buttons1_add_before'] = 'formatselect,fontselect';
        $init['theme_advanced_fonts'] = rtrim($myfontlist,',');
        return $init;
    }
}

//add font selection to TinyMCE
function wp_googlefontmgr_formatTinyMCE($init) {
    //get option settings
    $myfontlist = "";
    $mycsslist = "";
    $editorfonts = get_option("wp_googlefontmgr_editorfonts", 1);
    $websafefonts = get_option("wp_googlefontmgr_safefonts", 1);
    
    if($editorfonts) {
        if($websafefonts) {  
            //get websafefont list - modified by Richard Bonk
            $safefontlist = 'Arial=Arial,Helvetica,sans-serif;Arial Black=Arial Black,Gadget,sans-serif;Comic Sans=Comic Sans MS,Comic Sans MS,cursive;Courier New=Courier New,Courier New,Courier,monospace;Georgia=Georgia,Georgia,serif;';
            $safefontlist .= 'Impact=Impact,Charcoal,sans-serif;Lucida Console=Lucida Console,Monaco,monospace;Lucida Sans Unicode=Lucida Sans Unicode,Lucida Grande,sans-serif;Palatino Linotype=Palatino Linotype,Book Antiqua,Palatino,serif;';
            $safefontlist .= 'Tahoma=Tahoma,Geneva,sans-serif;Times New Roman=Times New Roman,Times,serif;Trebuchet MS=Trebuchet MS,Helvetica,sans-serif;Verdana=Verdana,Geneva,sans-serif;Gill Sans=Gill Sans,Geneva,sans-serif;';
        }
        $fontdata = get_option("wp_googlefontmgr_fonts");
        //get the google font list
        if($fontdata) {
            //load fonts for use in plugin - modified by Richard Bonk
            $array = explode(",", $fontdata);
            foreach($array as $value) {
                $myfontlist .=sprintf('%s=%s;', $value, $value);
            }
        }
        //check if websafe fonts are to be loaded
        if($websafefonts){
			$myfontlist = $myfontlist. $safefontlist;
        }
		// modified by Richard Bonk
		$init['font_formats'] = rtrim($myfontlist,';');
        return $init;
    }
}
//check if editor fonts are enabled, add filter if they are 
if($editorfonts) { 
    if ( version_compare($wp_version, '3.9', '>=') ) {
        add_filter('tiny_mce_before_init', 'wp_googlefontmgr_formatTinyMCE');
    } else {
        add_filter('tiny_mce_before_init', 'wp_googlefontmgr_formatOLDTinyMCE');
    } 
}

// Enable font size & font family selects in the editor - added by Richard Bonk
if ( ! function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}
}
if ( version_compare($wp_version, '3.9', '>=') && $editorfonts) {
    add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );
}


// Add Google Scripts for use with the editor - added by Richard Bonk
// not sure this part is really necessary, but added it just in case
if ( ! function_exists( 'wpex_mce_google_fonts_styles' ) ) {
	function wpex_mce_google_fonts_styles() {
		$mycsslist = "";
		$fontdata = get_option("wp_googlefontmgr_fonts");
		//get the google font list
		if($fontdata) {
			//load fonts for use in plugin
			$array = explode(",", $fontdata);
			foreach($array as $value) {
				$mycsslist = "//fonts.googleapis.com/css?family=".urlencode($value);
				add_editor_style( str_replace( ',', '%2C', $mycsslist ) );
			}
		}  
	}
}
if ( version_compare($wp_version, '3.9', '>=') && $editorfonts) {
    add_action( 'init', 'wpex_mce_google_fonts_styles' );
}

//add selected fonts on public side
function wp_googlefontmgr_setscripts(){
    //load font styles
    $fontdata = get_option("wp_googlefontmgr_fonts");
    if($fontdata) {
        //load fonts for use in plugin
        $fontselectdrop = "";
        $array = explode(",", $fontdata);
        foreach($array as $value) {
            $cssname = "google-font-manager-" .strtolower(str_replace(" ", "-", $value));
            wp_enqueue_style($cssname,'//fonts.googleapis.com/css?family='.$value);
            $fontselectdrop .='<li class="' .strtolower(str_replace(" ", "-", $value)). '" style="font-family: ' .$value. ';">' .$value. '</li>';
        }
    }
}
add_action('wp_enqueue_scripts', 'wp_googlefontmgr_setscripts');
add_action('admin_enqueue_scripts', 'wp_googlefontmgr_setscripts');

//check if google api key is valid
function googlefontmgr_check_api($google_api_key){
	$validapi = false;
    $api_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=";
	$api_data = wp_remote_get($api_url . $google_api_key);
	if(200 === $api_data['response']['code']){ $validapi = true; } else { $validapi = false; }
    return $validapi;	
}

//get the API key function
function wp_googlefonts_getTheKey(){
    global $is_networkactive;
    if($is_networkactive){
        $the_api_key = get_site_option('wp_googlefontmgr_globalkey');
    } else {
        $the_api_key = get_option('wp_googlefontmgr_apikey');
    }
    return $the_api_key;
}

//add styles into template header
function wp_googlefontmgr_headerstyles(){
    //get option settings
    $styledefaults = get_option("wp_googlefontmgr_styledefaults", 0);    
    
    if($styledefaults) {
        $stylesheet = get_option("wp_googlefontmgr_styleopts", "");    
        if($styledefaults != "") {
            echo '<style id="google-font-mgr-style">';
            echo stripslashes($stylesheet);
            echo '</style>';
        }
    }
}
add_action('wp_head', 'wp_googlefontmgr_headerstyles');

//register deactivation hook
function wp_googlefontmgr_deactivate(){
    delete_option("wp_googlefontmgr_fonts");
    delete_option("wp_googlefontmgr_apikey");
    delete_option("wp_googlefontmgr_safefonts");
    delete_option("wp_googlefontmgr_editorfonts");
    delete_option("wp_googlefontmgr_styledefaults");
    delete_option("wp_googlefontmgr_styleopts");
    delete_site_option('wp_googlefontmgr_globalkey');
}
register_uninstall_hook( dirname( __FILE__ ) .'/google-font-manager.php', 'wp_googlefontmgr_deactivate' );

?>
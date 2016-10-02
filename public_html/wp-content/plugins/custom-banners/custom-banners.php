<?php
/*
Plugin Name: Custom Banners
Plugin Script: custom-banners.php
Plugin URI: http://goldplugins.com/our-plugins/custom-banners/
Description: Allows you to create custom banners, which consist of an image, text, a link, and a call to action.  Custom banners are easily output via shortcodes. Each visitor to the website is then shown a random custom banner.
Version: 2.0.1
Author: Gold Plugins
Author URI: http://goldplugins.com/

*/

require_once('gold-framework/plugin-base.php');
require_once('lib/lib.php');
require_once('lib/custom_banners_options.php');
require_once('lib/BikeShed/bikeshed.php');
require_once('lib/cbp_expiration_date.class.php');
require_once("lib/GP_Media_Button/gold-plugins-media-button.class.php");
require_once("lib/GP_Janus/gp-janus.class.php");
require_once('lib/gp_key_checker.php');
require_once('include/tgm/class-tgm-plugin-activation.php');

class CustomBannersPlugin extends CBP_GoldPlugin
{
	var $transitions = array('fade','fadeIn','fadeOut','scrollHorz','scrollVert','shuffle',/*'carousel',*/'flipHorz','flipVert','tileSlide');
	var $free_transitions = array('fade','scrollHorz');
	
	function __construct()
	{
		// create subclasses
		$this->ExpirationDate = new CBP_ExpirationDate($this, __FILE__);
		
		$this->add_hooks();
		$this->create_post_types();
		$this->register_taxonomies();
		$this->add_shortcodes();
		$this->add_stylesheets_and_scripts();
		
		//register sidebar widgets
		add_action( 'widgets_init', array($this, 'custom_banners_register_widgets' ));
				
		add_filter('manage_banner_posts_columns', array($this, 'custom_banners_column_head'), 10);  
		add_action('manage_banner_posts_custom_column', array($this, 'custom_banners_columns_content'), 10, 2); 
			
		add_filter('manage_edit-banner_groups_columns', array($this, 'custom_banners_cat_column_head'), 10);  
		add_action('manage_banner_groups_custom_column', array($this, 'custom_banners_cat_columns_content'), 10, 3); 
			
		$custom_banners_options = new customBannersOptions();
		
		//add Custom CSS
		add_action( 'wp_head', array($this, 'cb_setup_custom_css'));		

		//add our custom links for Settings and Support to various places on the Plugins page
		$plugin = plugin_basename(__FILE__);
		add_filter( "plugin_action_links_{$plugin}", array($this, 'add_settings_link_to_plugin_action_links') );
		add_filter( 'plugin_row_meta', array($this, 'add_custom_links_to_plugin_description'), 10, 2 );	
		
		//add single shortcode metabox to banner add/edit screen
		add_action( 'admin_menu', array($this,'add_meta_boxes')); // add our custom meta boxes
		add_action( 'admin_menu', array($this,'add_settings_link')); // add a link to the settings page under the banners menu
		
		// add media buttons to admin
		$cur_post_type = ( isset($_GET['post']) ? get_post_type(intval($_GET['post'])) : '' );
		if( is_admin() && ( empty($_REQUEST['post_type']) || $_REQUEST['post_type'] !== 'banner' ) && ($cur_post_type !== 'banner') )
		{
			global $CustomBanners_MediaButton;
			$CustomBanners_MediaButton = new Gold_Plugins_Media_Button('Banners', 'images-alt');
			$CustomBanners_MediaButton->add_button('Single Banner Widget', 'banner', 'singlebannerwidget', 'images-alt');
			$CustomBanners_MediaButton->add_button('List of Banners Widget', 'banner', 'bannerlistwidget', 'images-alt');
			$CustomBanners_MediaButton->add_button('Rotating Banner Widget',  'banner', 'rotatingbannerwidget', 'images-alt');
		}
		
		// load Janus
		if (class_exists('GP_Janus')) {
			$cb_janus = new GP_Janus();
		}
		
		parent::__construct();
	}

	//add Custom CSS
	function cb_setup_custom_css() 
	{
		echo '<style type="text/css" media="screen">' . get_option('custom_banners_custom_css') . "</style>";
	}
	
	function add_hooks()
	{
		global $post;
		
		// add Google web fonts if needed
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_webfonts') );
		
		// admin javascript
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_js') );
		
		// load required plugins
		add_action( 'tgmpa_register', array($this, 'register_required_plugins') );
		
		parent::add_hooks();
	}
	
	function enqueue_js(){		
		if (is_admin()) {
			wp_enqueue_script(
				'gp-custom_banners_theme_selector',
				plugins_url('assets/js/gp-custom_banners_theme_selector.js', __FILE__),
				array( 'jquery' ),
				false,
				true
			);			
		}
	}
	
	function create_post_types()
	{
		$postType = array('name' => 'Banner', 'plural' => 'Banners', 'slug' => 'banners');
		$customFields = array();
		$customFields[] = array('name' => 'target_url', 'title' => 'Target URL', 'description' => 'Where a user should be sent when they click on the banner or the call to action button', 'type' => 'text');	
		$customFields[] = array('name' => 'cta_text', 'title' => 'Call To Action Text', 'description' => 'The "Call To Action" (text) of the button. Leave this field blank to hide the call to action button.', 'type' => 'text');
		$customFields[] = array('name' => 'css_class', 'title' => 'CSS Class', 'description' => 'Any extra CSS classes that you would like applied to this banner.', 'type' => 'text');
		$this->add_custom_post_type($postType, $customFields);

		//load list of current posts that have featured images	
		$supportedTypes = get_theme_support( 'post-thumbnails' );
		
		//none set, add them just to our type
		if( $supportedTypes === false ){
			add_theme_support( 'post-thumbnails', array( 'banner' ) );       
			//for the banner images    
		}
		//specifics set, add our to the array
		elseif( is_array( $supportedTypes ) ){
			$supportedTypes[0][] = 'banner';
			add_theme_support( 'post-thumbnails', $supportedTypes[0] );
			//for the banner images
		}
	
		//move featured image box to main column
		add_action('add_meta_boxes', array($this,'custom_banner_edit_screen'));		
		
		//remove unused meta boxes
		add_action( 'admin_init', array($this,'custom_banners_unused_meta'));

		// move the post editor under the other metaboxes
		add_action( 'add_meta_boxes', array($this, 'reposition_editor_metabox'), 0 );
		
		// enforce correct order of metaboxes
		add_action('admin_init', array($this, 'set_metabox_order'));
	}
	
	function reposition_editor_metabox() {
		global $_wp_post_type_features;
		if (isset($_wp_post_type_features['banner']['editor']) && $_wp_post_type_features['banner']['editor']) {
			unset($_wp_post_type_features['banner']['editor']);
			add_meta_box(
			'banner_caption',
			__('Banner Caption'),
			array($this, 'output_banner_caption_metabox'),
			'banner', 'normal', 'low'
			);
		}
	}
	
	function output_banner_caption_metabox( $post ) {
		echo '<div class="wp-editor-wrap">';
		wp_editor($post->post_content, 'content', array('dfw' => true, 'tabindex' => 1, 'textarea_rows' => 3) );
		echo '</div>';
	}	
	
	function set_metabox_order() {
		global $wpdb, $user_ID, $posts_widgets_order_hash;
		
		// check to see if its already set correctly
		$check_val = get_user_option('_custom_banners_meta_box_order', $user_ID);
		$correct_val = "metaboxes_v1";
		
		// if the metabox order is incorrect or not set, reset it now
		if ($check_val !== $correct_val)
		{
			$metabox_order = get_user_option('meta-box-order_banner', $user_ID);
			if (empty($metabox_order)) {
				$metabox_order = array();
			}
			$banner_info_metabox_id = $this->customPostTypes['banners']->get_metabox_id();
			$metabox_order['normal'] = 'postimagediv,banner_caption,'.$banner_info_metabox_id.'';
			update_user_option($user_ID, 'meta-box-order_banner', $metabox_order, true);
			update_user_option($user_ID, '_custom_banners_meta_box_order', $correct_val, true);
		}
	}
	
	//remove unused meta boxes
	function custom_banners_unused_meta() {
		remove_post_type_support( 'banner', 'excerpt' );
		remove_post_type_support( 'banner', 'custom-fields' );
		remove_post_type_support( 'banner', 'comments' );
		remove_post_type_support( 'banner', 'author' );
	}

	//remove featured image from the sidebar and add it to the main column
	function custom_banner_edit_screen() {
		// remove the Featured Image metabox, and replace it with our own (slightly modified) version, now residing in the main column
		remove_meta_box( 'postimagediv', 'banner', 'side' );
		add_meta_box('postimagediv', __('Banner Image'), array($this, 'custom_banners_post_thumbnail_html'), 'banner', 'normal', 'high');
	}
	
	//custom banner image html callback
	function custom_banners_post_thumbnail_html( $post ) {
		$thumbnail_id = get_post_meta( $post->ID, '_thumbnail_id', true );

        $upload_iframe_src = esc_url( get_upload_iframe_src('image', $post->ID ) );
        $set_thumbnail_link = '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set featured image' ) . '" href="%s" id="set-post-thumbnail" class="thickbox">%s</a></p>';
        $content = sprintf( $set_thumbnail_link, $upload_iframe_src, esc_html__( 'Set featured image' ) );

        if ( $thumbnail_id && get_post( $thumbnail_id ) ) {
                $thumbnail_html = wp_get_attachment_image( $thumbnail_id, "full" );
						
                if ( !empty( $thumbnail_html ) ) {
                        $ajax_nonce = wp_create_nonce( 'set_post_thumbnail-' . $post->ID );
                        $content = sprintf( $set_thumbnail_link, $upload_iframe_src, $thumbnail_html );
                        $content .= '<p class="hide-if-no-js"><a href="#" id="remove-post-thumbnail" onclick="WPRemoveThumbnail(\'' . $ajax_nonce . '\');return false;">' . esc_html__( 'Remove featured image' ) . '</a></p>';
                }           
        }
		
		// output the finalized HTML
        echo apply_filters( 'admin_post_thumbnail_html', $content, $post->ID );
	}
	
	function register_taxonomies()
	{
		$this->add_taxonomy('banner_groups', 'banner', 'Banner Group', 'Banner Groups');
	}
	
	function add_shortcodes()
	{
		add_shortcode('banner', array($this, 'banner_shortcode'));
	}
	
	function banner_shortcode($atts, $content = '')
	{
		// load the shortcodes attributes and merge with our defaults
		$defaults = array(	'id' => '',
							'group' => '',
							'caption_position' => 'bottom',
							'transition' => 'none',
							'pager' => false,
							'count' => -1,
							'timer' => 4000,
							'use_image_tag' => true,
							'show_pager_icons' => false,
							'use_pager_thumbnails' => false,
							'hide' => false,
							'width' => get_option('custom_banners_default_width', ''),
							'height' => get_option('custom_banners_default_height', ''),
							'pause_on_hover' => false,
							'auto_height' => false,
							'prev_next' => false,
							'paused' => false,
							'banner_height' => '',
							'banner_height_px' =>get_option('custom_banners_default_height', ''),
							'banner_width' => '',
							'banner_width_px' =>  get_option('custom_banners_default_width', ''),
							'link_entire_banner' => get_option('custom_banners_use_big_link', 0),
							'open_link_in_new_window' => get_option('custom_banners_open_link_in_new_window', 0),
							'show_caption' => !get_option('custom_banners_never_show_captions', 1),
							'show_cta_button' => !get_option('custom_banners_never_show_cta_buttons', 1),
							'theme' => get_option('custom_banners_theme')
						);

		$atts = shortcode_atts($defaults, $atts);
		$banner_id = intval($atts['id']);
		
		$html = '';
		
		// Generate the HTML for the requested banners (could be a single banner, or many)
		if( $banner_id > 0 ) {
			// A single banner ID was specified, so just load it directly
			$banner = $this->get_banner_by_id($banner_id);
			if ($banner !== false) {
				$html .= $this->buildBannerHTML($banner, $banner_id, $atts);
			}
		}
		else {
			// choose a banner based on the other attributes 	
			$banners = $this->get_banners_by_atts($atts);
			$slideshow = ( (in_array($atts['transition'], $this->transitions)) );
			$atts['slideshow'] = $slideshow;
			
			if ( !isValidCBKey() && $slideshow && strlen($atts['transition']) > 0 ) {
				if ( !(in_array($atts['transition'], $this->free_transitions)) ) {					
					$atts['transition'] = 'fade';
				}
			}
			
			//generate a random number to have a unique wrapping class on each slideshow
			//this should prevent controls that effect more than one slideshow on a page
			$target = rand();

			// start the slideshow's HTML (if required)
			if( $slideshow ) {			
				if ($atts['banner_width'] == 'specify') {//if the width was specified via the widget, use it here, otherwise go with global option
					$atts['width'] = intval($atts['banner_width_px']);
				}
				
				$style_string = $this->build_banner_css($atts);
				
				//determine auto height setting
				//true is calc (height of slideshow is set to height of tallest slide)
				//false is container (height of slideshow is set to the height of the currently visible slide)
				$auto_height = ($atts['auto_height']) ? "calc" : "container";				
				
				//get theme name and theme basename
				//add both via extra classes
				//specific to the slideshow wrapper
				$theme = $atts['theme'];
				
				$theme_classes = array();
				$spot = strpos($theme, '-');
				if ($spot !== FALSE) {
					$theme_basename = substr($theme, 0, $spot);
					$theme_classes[] = sprintf('custom-banners-cycle-slideshow-theme-%s', $theme_basename);
				}
				$theme_classes[] = sprintf('custom-banners-cycle-slideshow-%s', $theme);
				
				$theme_classes_str = implode(' ', $theme_classes);
				
				$html .= '<div style="' . $style_string . '" data-cycle-auto-height="' . $auto_height . '" class="custom-banners-cycle-slideshow cycle-slideshow custom-b-'.$target.' '.$theme_classes_str.'" data-cycle-fx="' . $atts['transition'] . '" data-cycle-timeout="' . $atts['timer'] . '" data-cycle-pause-on-hover="' . $atts['pause_on_hover'] . '" data-cycle-slides="> div.banner_wrapper" data-cycle-paused="' . $atts['paused'] . '"';
				
				if($atts['prev_next']){
					$html .= 'data-cycle-prev=".custom-b-'.$target.' .custom-b-cycle-prev"  data-cycle-next=".custom-b-'.$target.' .custom-b-cycle-next"';
				}
				
				if($atts['pager'] || $atts['show_pager_icons'] ){
					$html .= 'data-cycle-pager=".custom-b-'.$target.' .custom-b-cycle-pager"';
					
					//output image thumbnails or regular pagers
					if($atts['use_pager_thumbnails']){
						if ($atts['auto_height']) {
							$html .= "data-cycle-pager-template=\"<span><a href=#><img src='{{firstChild.lastChild.previousSibling.firstChild.src}}'></a></span>\"";
						} else {
							$html .= "data-cycle-pager-template=\"<span><a href=#><img src='{{firstChild.lastChild.previousSibling.src}}'></a></span>\"";
						}
					} else {
						$html .= 'data-cycle-pager-template="<span><a href=#>{{slideNum}}</a></span>"';
					}
				}
				
				$html .= '>';				
			}
		
			// build the HTML for each banner, concatenating its output to $html
			foreach($banners as $index => $banner) {
				// If we are outputting a slideshow, hide all but the first banner
				$atts['hide'] = ( $slideshow && ($index > 0) );
				
				// Add this banner's HTML to the output
				$html .= $this->buildBannerHTML($banner, $banner_id, $atts);
			}
			
			// add a pager and close the slideshow's HTML (if requested)
			if( $slideshow ){
				//get theme name and theme basename
				//add both via extra classes
				//specific to the controls for slideshows
				$theme = $atts['theme'];
				
				$theme_classes = array();
				$spot = strpos($theme, '-');
				if ($spot !== FALSE) {
					$theme_basename = substr($theme, 0, $spot);
					$theme_classes[] = sprintf('custom-banners-controls-theme-%s', $theme_basename);
				}
				$theme_classes[] = sprintf('custom-banners-controls-theme-%s', $theme);
				
				$theme_classes_str = implode(' ', $theme_classes);
				
				$html .= '<div class="custom-b-cycle-controls ' . $theme_classes_str . '">';
					if($atts['prev_next']){
						$html .= '<div class="custom-b-cycle-prev">&lt;&lt;</div>';
					}
					if($atts['pager'] || $atts['show_pager_icons'] ){
						$html .= '<div class="custom-b-cycle-pager"></div>';
					}
					if($atts['prev_next']){
						$html .= '<div class="custom-b-cycle-next">&gt;&gt;</div>';
					}
				$html .= '</div>';
				
				$html .= '</div><!-- end slideshow -->';
			}
			
		
			
			
		}
		
		// return the generated HTML
		return $html;
	}
	
	function get_banner_by_id($id, $respect_expiration = true)
	{
		$args = array(
			'posts_per_page' => 1,
			'p' => $id,
			'post_type'=> 'banner',
		);

		/* Restrict by expiration date (optional) */
		if ($respect_expiration) {
			$args['meta_query'] = $this->ExpirationDate->get_meta_query();
		}

		$banners_query = new WP_Query( $args );
		$banner = !empty($banners_query->posts) ? $banners_query->posts[0] : false;
		return $banner;
	}
	
	function get_banners_by_atts($atts)
	{
		$args = array(
			'posts_per_page' => $atts['count'],
			'orderby' => 'rand',
			'post_type'=> 'banner',
			'banner_groups' => $atts['group'],
			'nopaging' => ($atts['count'] == '-1'), // turn paging off posts_per_page is unlimited
			'meta_query' => $this->ExpirationDate->get_meta_query()
		);

		$banners_query = new WP_Query( $args );
		$banners = !empty($banners_query->posts) ? $banners_query->posts : array();
		return $banners;
	}
	
	function buildBannerHTML($banner, $banner_id, $atts){
		if($banner_id == ''){			
			$banner_id = $banner->ID;		
		}
	
		$post_thumbnail_id 	= get_post_thumbnail_id( $banner_id );
		$cta 				= $this->get_option_value($banner_id, 'cta_text', '');
		$target_url 		= $this->get_option_value($banner_id, 'target_url', '#');
		$css_class 			= $this->get_option_value($banner_id, 'css_class', '');	
		$use_big_link 		= isset($atts['link_entire_banner']) ? $atts['link_entire_banner'] : get_option('custom_banners_use_big_link');
		$open_in_window 	= isset($atts['open_link_in_new_window']) ? $atts['open_link_in_new_window'] : get_option('custom_banners_open_link_in_new_window');
		$show_captions 		= isset($atts['show_caption']) ? $atts['show_caption'] : !get_option('custom_banners_never_show_captions', 0);
		$show_cta_buttons 	= isset($atts['show_cta_button']) ? ($atts['show_cta_button'] == 1) : !get_option('custom_banners_never_show_cta_buttons', 0);
		$banner_width  		= isset($atts['banner_width']) ? $atts['banner_width'] : 'auto';
		$banner_width_px  	= !empty($atts['banner_width_px']) && intval($atts['banner_width_px']) > 0 ? intval($atts['banner_width_px']) : '';
		$banner_height  	= isset($atts['banner_height']) ? $atts['banner_height'] : 'auto';
		$banner_height_px  	= !empty($atts['banner_height_px']) && intval($atts['banner_height_px']) > 0 ? intval($atts['banner_height_px']) : '';
		$theme = isset($atts['theme']) ? $atts['theme'] : get_option('custom_banners_theme');
		$legacy_cta_position = ($theme == 'default_style') ? true : false;//if using the original ("default") theme, order the HTML according to the old style.  Otherwise, new style.
		$slideshow  		= isset($atts['slideshow']) ? $atts['slideshow'] : false;
		// filters
		$target_url = apply_filters('custom_banners_target_url', $target_url, $banner_id);
		$css_class = apply_filters('custom_banners_banner_class', $css_class, $banner_id);
		// TODO: add filters for the other attributes
		
		// if no CTA is present but a target URL is, then link the entire banner
		if ( empty($cta) && !empty($target_url) ) {
			$use_big_link = true;
		}
		
		// placeholder variables
		$html = '';
		$img_html = '';
		$banner_style = '';

		// add any extra CSS classes to the banner
		$extra_classes = array($css_class, 'banner-' . $banner_id);
		if (strlen($cta) > 0) {
			$extra_classes[] = 'has_cta';
			
			if($legacy_cta_position){
				$extra_classes[] = 'legacy_cta_position';
			}
		}
		if ($atts['caption_position'] == 'left') {
			$extra_classes[] = 'left';
			$extra_classes[] = 'horiz';
		}
		else if ($atts['caption_position'] == 'right') {
			$extra_classes[] = 'right';
			$extra_classes[] = 'horiz';
		}
		else if ($atts['caption_position'] == 'top') {
			$extra_classes[] = 'top';
			$extra_classes[] = 'vert';
		}
		else if ($atts['caption_position'] == 'bottom') {
			$extra_classes[] = 'bottom';
			$extra_classes[] = 'vert';
		}
		
		//get theme name and theme basename
		//add both via extra classes
		$spot = strpos($theme, '-');
		if ($spot !== FALSE) {
			$theme_basename = substr($theme, 0, $spot);
			$extra_classes[] = sprintf('custom-banners-theme-%s', $theme_basename);
		}
		$extra_classes[] = sprintf('custom-banners-theme-%s', $theme);
		
		$extra_classes_str = implode(' ', $extra_classes);
		
		// we can use either a background image on the banner div, or an <img> tag inside the banner div instead
		$option_use_image_tag = isset($atts['use_image_tag']) ? $atts['use_image_tag'] : false;
		
		// load the featured image, of one was specified
		if ($post_thumbnail_id !== '' && $post_thumbnail_id > 0)
		{
			if (!$option_use_image_tag) 
			{
				$img_src = wp_get_attachment_image_src($post_thumbnail_id, 'full');
				$banner_style = "background-image: url('" . $img_src[0] . "');";
				$img_html = '';
			}
			else {
				$img_style = '';
				$frame_style = '';
				$img_meta = wp_get_attachment_metadata($post_thumbnail_id, 'full');

				if ($banner_width == 'specify') {
					$img_style .= sprintf('width: %spx;', $banner_width_px);
				}
				//$frame_style .= sprintf( 'width: %spx; ', $img_meta['width'] );
				
				if ($banner_height == 'specify') {
					$img_style .= sprintf('height: %spx;', $banner_height_px);
				}	
				$frame_style .= sprintf( 'min-height: %spx; width: 100%%; max-height:100%%', $img_meta['height'] );

				if (strlen($img_style) > 0) {
					$img_atts = array('style' => $img_style);
				} else {
					$img_atts = array();
				}
				
				if ($banner_width == 'specify' && $banner_height == 'specify') {
					$size = array($banner_width_px, $banner_height_px);
				}
				else {
					$size = 'fullsize';
				}
				
				// add frame if slideshow
				$img_html = '';
				if ($slideshow && $atts['auto_height']) {
					$img_html .= sprintf('<div class="banner_frame" style="%s">', $frame_style);
				}
				$img_html .= wp_get_attachment_image($post_thumbnail_id, 'full', $size, $img_atts);
				if ($slideshow && $atts['auto_height']) {
					$img_html .= '</div>';
				}
			}			
		}		
		
		
		if($atts['hide']){
			$banner_display = 'style="display:none; %s"';
		} else {
			$banner_display = 'style="%s"';
		}
		$banner_wrapper_style = sprintf($banner_display, $this->build_banner_wrapper_css($atts));
		
		if($open_in_window){
			$link_target = ' target="_blank" ';
		} else {
			$link_target = '';
		}
		
		$banner_style .= $this->build_banner_css($atts);
		
		// generate the html now
		$html .= '<div class="banner_wrapper" '. $banner_wrapper_style .'>';
			$html .= '<div class="banner ' . $extra_classes_str . '" style="' . $banner_style . '">';
				if($use_big_link){
					$html .= '<a class="custom_banners_big_link" ' . $link_target . ' href="' . $target_url . '"></a>';
				}
				$html .= $img_html;
				$caption = $banner->post_content;
				if ( $show_captions && (strlen($caption) > 0 || strlen($cta) > 0) )
				{
					$style_str = $this->build_caption_css();
					$html .= '<div class="banner_caption" style="' . $style_str . '">';
						
						//this is the old style of CTA html placement
						//only do this if $legacy_cta_position is true (ie, we're using the 'default' theme)
						if ( $show_cta_buttons && strlen($cta) > 0 && $legacy_cta_position)
						{
							$style_str = $this->build_typography_css('custom_banners_cta_button_');
							$style_str .= $this->build_button_css('custom_banners_cta_');
							$html .= '<div class="banner_call_to_action">';
								$html .= '<a href="' . $target_url . '" ' . $link_target . ' class="banner_btn_cta" style="' . $style_str . '">' . htmlspecialchars($cta) . '</a>';
							$html .= '</div>'; //<!--.banner_call_to_action-->
						}
						
						$inner_style_str = $this->build_typography_css('custom_banners_caption_');
						$html .= '<div class="banner_caption_inner" style="' . $inner_style_str . '">';
						$html .= $caption;
						
						//this is the new style of CTA html placement
						//only do this if $legacy_cta_position is false (ie, we're not using the 'default' theme)
						if ( $show_cta_buttons && strlen($cta) > 0 && !$legacy_cta_position)
						{
							$style_str = $this->build_typography_css('custom_banners_cta_button_');
							$style_str .= $this->build_button_css('custom_banners_cta_');
							$html .= '<div class="banner_call_to_action">';
								$html .= '<a href="' . $target_url . '" ' . $link_target . ' class="banner_btn_cta" style="' . $style_str . '">' . htmlspecialchars($cta) . '</a>';
							$html .= '</div>'; //<!--.banner_call_to_action-->
						}
						$html .= '</div>';
					$html .= '</div>'; //<!--.banner_caption-->
				}
			$html .= '</div>'; //<!--.banner -->
		$html .= '</div>'; //<!--.banner_wrapper-->
		
		// apply a filter to the completed banner HTML
		$banner_html = apply_filters('custom_banners_banner_html', $html, $banner_id, $atts);
		
		// allow the user to inject before and after HTML via filters
		$before_banner = apply_filters('custom_banners_before_banner', '', $banner_id, $atts);
		$after_banner = apply_filters('custom_banners_after_banner', '', $banner_id, $atts);
		
		// add it all together and return
		return $before_banner . $banner_html . $after_banner;
	}
	
	function add_stylesheets_and_scripts()
	{
		$cssUrl = plugins_url( 'assets/css/wp-banners.css' , __FILE__ );
		$this->add_stylesheet('wp-banners-css',  $cssUrl);
		
		//theme stylesheets to admin for theme preview section
		$this->add_admin_stylesheet('wp-banners-css',  $cssUrl);
		
		//need to include cycle2 this way, for compatibility with our other plugins
		$jsUrl = plugins_url( 'assets/js/jquery.cycle2.min.js' , __FILE__ );
		$this->add_script('gp_cycle2',  $jsUrl, array( 'jquery' ),	false, true);
		//enqueue it again, on the admin side, for use in the theme preview tool
		$this->add_admin_script('gp_cycle2',  $jsUrl, array( 'jquery' ),	false, true);

		$cb_js_url = plugins_url( 'assets/js/custom-banners.js' , __FILE__ );
		$this->add_script('custom-banners-js',  $cb_js_url, array( 'jquery' ), false, true);
	}
	
	//this is the heading of the new column we're adding to the banner posts list
	function custom_banners_column_head($defaults) {  
		$defaults = 
			array_slice($defaults, 0, 1, true) +
			array("cbp_banner_preview" => "Thumbnail") +
			array_slice($defaults, 1, 1, true) +
			array("single_shortcode" => "Shortcode") +
			array_slice($defaults, 2, count($defaults)-2, true);

		return apply_filters('custom_banners_admin_columns_head', $defaults);
	}  

	//this content is displayed in the banner post list
	function custom_banners_columns_content($column_name, $post_ID)
	{
		if ($column_name == 'cbp_banner_preview') {
			$thumb_html = get_the_post_thumbnail( $post_ID, 'post-thumbnail', array('style' => 'max-width: 100px; height: auto') );
			printf( '<a href="%s">%s</a>', get_edit_post_link($post_ID), $thumb_html );
		}  
		else if ($column_name == 'single_shortcode') {
			$my_shortcode = sprintf('[banner id="%d"]', $post_ID);
			printf('<textarea rows="1" onclick="this.select();" class="gp_code" style="height: 2em; margin-top: 10px; max-width:100%%">%s</textarea>', $my_shortcode);
		}
		
		do_action('custom_banners_admin_columns_content', $column_name, $post_ID);
	} 

	//this is the heading of the new column we're adding to the banner category list
	function custom_banners_cat_column_head($defaults) {  
		$defaults = array_slice($defaults, 0, 2, true) +
		array("single_shortcode" => "Shortcode") +
		array_slice($defaults, 2, count($defaults)-2, true);
		return $defaults;  
	}  

	//this content is displayed in the banner category list
	function custom_banners_cat_columns_content($value, $column_name, $tax_id) {  

		$category = get_term_by('id', $tax_id, 'banner_groups');
		
		return "<code>[banner group='{$category->slug}']</code>"; 
	}

	//register any widgets here
	function custom_banners_register_widgets() {
		include('lib/widgets/single_banner_widget.php');
		include('lib/widgets/rotating_banner_widget.php');
		include('lib/widgets/banner_list_widget.php');
		
		register_widget( 'singleBannerWidget' );
		register_widget( 'rotatingBannerWidget' );
		register_widget( 'bannerListWidget' );
	}
	
	//add an inline link to the settings page, before the "deactivate" link
	function add_settings_link_to_plugin_action_links($links) {
	  $settings_link = '<a href="admin.php?page=custom-banners-settings">Settings</a>';
	  array_unshift($links, $settings_link); 
	  return $links; 
	}

	// add inline links to our plugin's description area on the Plugins page
	function add_custom_links_to_plugin_description($links, $file) { 

		/** Get the plugin file name for reference */
		$plugin_file = plugin_basename( __FILE__ );
	 
		/** Check if $plugin_file matches the passed $file name */
		if ( $file == $plugin_file )
		{		
			$new_links['settings_link'] = '<a href="admin.php?page=custom-banners-settings">Settings</a>';
			$new_links['support_link'] = '<a href="http://goldplugins.com/contact/?utm-source=plugin_menu&utm_campaign=support" target="_blank">Get Support</a>';
				
			if(!isValidCBKey()){
				$new_links['upgrade_to_pro'] = '<a href="http://goldplugins.com/our-plugins/custom-banners/upgrade-to-custom-banners-pro/?utm_source=plugin_menu&utm_campaign=upgrade" target="_blank">Upgrade to Pro</a>';
			}
			
			$links = array_merge( $links, $new_links);
		}
		return $links; 
	}
	
		
	/* Displays a meta box with the shortcodes to display the current banner */
	function display_shortcodes_meta_box() {
		global $post;
		echo "Copy &amp; Paste this shortcode into any post or page to display this banner:<br />";
		$my_shortcode = sprintf('[banner id="%d"]', $post->ID);
		printf('<textarea rows="1" onclick="this.select();" class="gp_code" style="width: 100%%; height: 2em; margin-top: 10px;">%s</textarea>', $my_shortcode);
	}

	function add_meta_boxes(){
		add_meta_box( 'banner_shortcodes', 'Shortcodes', array($this, 'display_shortcodes_meta_box'), 'banner', 'side', 'default' );
	}
	
	
	/*
	 * Builds a CSS string for the banner wrapper. Primarily controls height and width
	 *
	 * @param	$atts		Attributes from the shortcode
	 *
	 * @returns	string		The completed CSS string, with the values inlined
	 */
	function build_banner_css($atts)
	{	
		$option_use_image_tag = isset($atts['use_image_tag']) ? $atts['use_image_tag'] : false;
		
		$defaults = array(
						'width' => get_option('custom_banners_default_width', ''),
						'height' => get_option('custom_banners_default_height', ''),
						'banner_width' 		=> 'auto',
						'banner_width_px' 	=> '',
						'banner_height' 	=> 'auto',
						'banner_height_px' 	=> '',
					);
		$atts = shortcode_atts($defaults, $atts);
		
		$banner_width  		= isset($atts['banner_width']) ? $atts['banner_width'] : 'auto';
		$banner_width_px  	= !empty($atts['banner_width_px']) && intval($atts['banner_width_px']) > 0 ? intval($atts['banner_width_px']) : '';
		$banner_height  	= isset($atts['banner_height']) ? $atts['banner_height'] : 'auto';
		$banner_height_px  	= !empty($atts['banner_height_px']) && intval($atts['banner_height_px']) > 0 ? intval($atts['banner_height_px']) : '';
		
		if ($banner_width == 'specify') {
			$atts['width'] = $banner_width_px;
		}
		
		if ($banner_height == 'specify') {
			$atts['height'] = $banner_height_px;
		}						
		
		$css_rule_template = ' %s: %s;';
		$output = '';
		
		/* 
		 * Width
		 */
		$option_val = $atts['width'];		
		if (!empty($option_val) || $banner_width == '100_percent' || $banner_width == 'auto') {
			if ($banner_width == 'auto' && $option_use_image_tag) {
				$option_val = 'auto';
				$output .= sprintf($css_rule_template, 'width', $option_val);
			}
			else if ($banner_width == '100_percent') {
				$option_val = '100%';
				$output .= sprintf($css_rule_template, 'width', $option_val);
			}
			else if ( is_numeric($option_val) ) {
				$option_val .= 'px';
				$output .= sprintf($css_rule_template, 'width', $option_val);
			}
		}
		
		/* 
		 * Height
		 */
		$option_val = $atts['height'];
		if (!empty($option_val) || $banner_height == 'auto') {
			if ($banner_height == 'auto' && $option_use_image_tag) {
				$option_val = 'auto';
				$output .= sprintf($css_rule_template, 'height', $option_val);
			}
			else if ( is_numeric($option_val) ) {
				$option_val .= 'px';
				$output .= sprintf($css_rule_template, 'height', $option_val);
			}			
		}		
		
		// return the completed CSS string
		return trim($output);
	}
	
	/*
	 * Builds a CSS string for the banner itself. Primarily controls height and width
	 *
	 * @param	$atts		Attributes from the shortcode
	 *
	 * @returns	string		The completed CSS string, with the values inlined
	 */
	function build_banner_wrapper_css($atts)
	{
		$defaults = array(
						'width' 			=> get_option('custom_banners_default_width', ''),
						'height'			=> get_option('custom_banners_default_height', ''),
						'banner_width' 		=> '',
						'banner_width_px' 	=> '',
						'banner_height' 	=> '',
						'banner_height_px' 	=> '',
						
					);
		$atts = shortcode_atts($defaults, $atts);
		$banner_width  		= isset($atts['banner_width']) ? $atts['banner_width'] : '';
		$banner_width_px  	= !empty($atts['banner_width_px']) && intval($atts['banner_width_px']) > 0 ? intval($atts['banner_width_px']) : '';
		$banner_height  	= isset($atts['banner_height']) ? $atts['banner_height'] : '';
		$banner_height_px  	= !empty($atts['banner_height_px']) && intval($atts['banner_height_px']) > 0 ? intval($atts['banner_height_px']) : '';
		
		if ($banner_width == 'specify') {
			$atts['width'] = $banner_width_px;
		}
		
		if ($banner_height == 'specify') {
			$atts['height'] = $banner_height_px;
		}		
				
		
		$css_rule_template = ' %s: %s;';
		$output = '';

		/* 
		 * Width
		 */
		if ($banner_width != 'auto')
		{
			$option_val = $atts['width'];		
			if (!empty($option_val) || $banner_width=='100_percent') {
				if ($banner_width == '100_percent') {
					$option_val = '100%';
					$output .= sprintf($css_rule_template, 'width', $option_val);
				}
				else if ( is_numeric($option_val) ) {
					$option_val .= 'px';
					$output .= sprintf($css_rule_template, 'width', $option_val);
				}
			}
		}
		
		/* 
		 * Height
		 */
		if ($banner_height != 'auto')
		{
			$option_val = $atts['height'];		
			if (!empty($option_val)) {
				if ( is_numeric($option_val) ) {
					$option_val .= 'px';
					$output .= sprintf($css_rule_template, 'height', $option_val);
				}
			}		
		}
		
		// return the completed CSS string
		return trim($output);
	}
	
	/*
	 * Builds a CSS string for the banner's caption
	 *
	 * @param	$atts		Attributes from the shortcode
	 *
	 * @returns	string		The completed CSS string, with the values inlined
	 */
	function build_caption_css($atts = array())
	{
		$css_rule_template = ' %s: %s;';
		$output = '';
		/* 
		 * Background Color + Opacity
		 */
		$color_val = get_option('custom_banners_caption_background_color', '');
		$opacity_val = get_option('custom_banners_caption_background_opacity', '');
		
		if (!empty($color_val)) {
			// convert the hex string into an "rgba()" string
			$opacity = !empty($opacity_val) ? ($opacity_val / 100) : 1;		
			$rgba = $this->hex2rgba($color_val, $opacity);
			$output .= sprintf($css_rule_template, 'background-color', $rgba);
		}		
		
		/* 
		 * Background Opacity
		 */
		if (!empty($option_val)) {
			$output .= sprintf($css_rule_template, 'opacity', $option_val);
		}		
		
		/* 
		 * Remove Background image if Background Color / Opacity was specified
		 */
		if (!empty($output)) {
			$output .= sprintf($css_rule_template, 'background-image', 'none');
		}
		// return the completed CSS string
		return trim($output);	
	}
	
	 
	function hex2rgba($color, $opacity = false) { 
		$default = 'rgb(0,0,0)';
 
		//Return default if no color provided
		if(empty($color)) {
			return $default;
		}
 
		//Sanitize $color if "#" is provided 
		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}
 
		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
				return $default;
		}
 
		//Convert hexadec to rgb
		$rgb =  array_map('hexdec', $hex);
 
		//Check if opacity is set(rgba or rgb)
		if($opacity){
			if(abs($opacity) > 1)
				$opacity = 1.0;
			$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
		} else {
			$output = 'rgb('.implode(",",$rgb).')';
		}
 
		//Return rgb(a) color string
		return $output;
	}
	
	/*
	 * Builds a CSS string for the call to action button
	 *
	 * @param	$prefix		The prefix for the settings
	 *
	 * @returns	string		The completed CSS string, with the values inlined
	 */
	function build_button_css($prefix)
	{
		$css_rule_template = ' %s: %s;';
		$output = '';
		if (!isValidCBKey()) {
			return $output;
		}		

		/* 
		 * Background Color
		 */
		$option_val = get_option($prefix . 'background_color', '');
		if (!empty($option_val)) {
			$output .= sprintf($css_rule_template, 'background-color', $option_val);
		}		
		
		/* 
		 * Border Color
		 */
		$option_val = get_option($prefix . 'border_color', '');
		if (!empty($option_val)) {
			$output .= sprintf($css_rule_template, 'border-color', $option_val);
		}		
		
		/* 
		 * Border Radius
		 */
		$option_val = get_option($prefix . 'border_radius', '');
		if (!empty($option_val)) {
			// append 'px' if needed
			if ( is_numeric($option_val) ) {
				$option_val .= 'px';
			}
			$output .= sprintf($css_rule_template, 'border-radius', $option_val);
		}

		// return the completed CSS string
		return trim($output);		
	}
	
	/*
	 * Builds a CSS string corresponding to the values of a typography setting
	 *
	 * @param	$prefix		The prefix for the settings. We'll append font_name,
	 *						font_size, etc to this prefix to get the actual keys
	 *
	 * @returns	string		The completed CSS string, with the values inlined
	 */
	function build_typography_css($prefix)
	{
		$css_rule_template = ' %s: %s;';
		$output = '';
		if (!isValidCBKey()) {
			return $output;
		}		
		
		/* 
		 * Font Family
		 */
		 
		$option_val = get_option($prefix . 'font_family', '');
		if (!empty($option_val)) {
			// strip off 'google:' prefix if needed
			$option_val = str_replace('google:', '', $option_val);

		
			// wrap font family name in quotes
			$option_val = '\'' . $option_val . '\'';
			$output .= sprintf($css_rule_template, 'font-family', $option_val);
		}
		
		/* 
		 * Font Size
		 */
		$option_val = get_option($prefix . 'font_size', '');
		if (!empty($option_val)) {
			// append 'px' if needed
			if ( is_numeric($option_val) ) {
				$option_val .= 'px';
			}
			$output .= sprintf($css_rule_template, 'font-size', $option_val);
		}		
		
		/* 
		 * Font Color
		 */
		$option_val = get_option($prefix . 'font_color', '');
		if (!empty($option_val)) {
			$output .= sprintf($css_rule_template, 'color', $option_val);
		}

		/* 
		 * Font Style - add font-style and font-weight rules
		 * NOTE: in this special case, we are adding 2 rules!
		 */
		$option_val = get_option($prefix . 'font_style', '');

		// Convert the value to 2 CSS rules, font-style and font-weight
		// NOTE: we lowercase the value before comparison, for simplification
		switch(strtolower($option_val))
		{
			case 'regular':
				// not bold not italic
				$output .= sprintf($css_rule_template, 'font-style', 'normal');
				$output .= sprintf($css_rule_template, 'font-weight', 'normal');
			break;
		
			case 'bold':
				// bold, but not italic
				$output .= sprintf($css_rule_template, 'font-style', 'normal');
				$output .= sprintf($css_rule_template, 'font-weight', 'bold');
			break;

			case 'italic':
				// italic, but not bold
				$output .= sprintf($css_rule_template, 'font-style', 'italic');
				$output .= sprintf($css_rule_template, 'font-weight', 'normal');
			break;
		
			case 'bold italic':
				// bold and italic
				$output .= sprintf($css_rule_template, 'font-style', 'italic');
				$output .= sprintf($css_rule_template, 'font-weight', 'bold');
			break;
			
			default:
				// empty string or other invalid value, ignore and move on
			break;			
		}			

		// return the completed CSS string
		return trim($output);		
	}
	
	// Enqueue any needed Google Web Fonts
	function enqueue_webfonts()
	{
		$cache_key = '_custom_bs_webfont_str';
		$font_str = get_transient($cache_key);
		if ($font_str == false) {
			$font_list = $this->list_required_google_fonts();
			if ( !empty($font_list) ) {
				$font_list_encoded = array_map('urlencode', $font_list);
				$font_str = implode('|', $font_list_encoded);
			} else {
				$font_str = 'x';
			}
			set_transient($cache_key, $font_str);					
		}

		//don't register this unless a font is set to register
		if(strlen($font_str)>2) {
			$protocol = is_ssl() ? 'https:' : 'http:';
			$font_url = $protocol . '//fonts.googleapis.com/css?family=' . $font_str;
			wp_register_style( 'custom_banners_webfonts', $font_url );
			wp_enqueue_style( 'custom_banners_webfonts' );
		}
	}

	function list_required_google_fonts()
	{
		// check each typography setting for google fonts, and build a list
		$option_keys = array(
			'custom_banners_caption_font_family',
			'custom_banners_cta_button_font_family',
		);
		$fonts = array();
		foreach ($option_keys as $option_key) {
			$option_value = get_option($option_key);
			if (strpos($option_value, 'google:') !== FALSE) {
				$option_value = str_replace('google:', '', $option_value);
				
				//only add the font to the array if it was in fact a google font
				$fonts[$option_value] = $option_value;				
			}
		}
		return $fonts;
	}
	
	function add_settings_link()
	{
		do_action('custom_banners_before_add_settings_link');
		$hook_suffix = add_submenu_page( 'edit.php?post_type=banner', 'Settings', 'Settings', 'administrator', 'custom-banners-settings-redirect', array($this, 'settings_link_redirect') ); 
		add_action("load-$hook_suffix", array($this, 'settings_link_redirect'));
		do_action('custom_banners_after_add_settings_link');
	}
	
	function settings_link_redirect()
	{
		$settings_page_url = admin_url('admin.php?page=custom-banners-settings');
		wp_redirect($settings_page_url);
		exit();
	}
	
	function register_required_plugins()
	{
		if ( !isValidCBKey() ) {
			return;
		}

		$package_url = $this->get_pro_package_url();
		if ( empty($package_url) ){
			return;
		}

		$plugins = array(
			array(
				'name'         => 'Custom Banners Pro', // The plugin name.
				'slug'         => 'custom-banners-pro', // The plugin slug (typically the folder name).
				'source'       => $package_url, // plugin source on S3
				'required'     => true, // If false, the plugin is only 'recommended' instead of required.
				'external_url' => 'https://goldplugins.com/our-plugins/custom-banners/', // If set, overrides default API URL and points to an external URL.
			),
		);

		$thank_you_msg = __('Thank you for purchasing Custom Banners Pro!');
		$please_install_msg = __('Please install the Custom Banners Pro add-on plugin to use your Pro features.');
		$please_activate_msg = __('Please activate the Custom Banners Pro add-on plugin to use your Pro features.');

		$thank_you_heading = sprintf( '<span style="%s">%s</span>',
									 'font-size: 1.2em; display: block; margin-bottom: 8px;',
									 $thank_you_msg
									);

		$notice_can_install_required = sprintf('%s</strong>%s<strong>',
											   $thank_you_heading,
											   $please_install_msg
											  );

		$notice_can_activate_required = sprintf('%s</strong>%s<strong>',
											    $thank_you_heading,
											    $please_activate_msg
											   );
		$activate_link = __('Click here to activate Custom Banners Pro');
		$install_link = __('Install Custom Banners Pro Automatically');
		$notice_can_install_recommended = __('Custom Banners recommends the following plugin: %1$s.');
		$notice_can_install_recommended_plural = __('Custom Banners recommends the following plugins: %1$s.');

		$strings = array(
			'notice_can_install_required'     => _n_noop(
				$notice_can_install_required,
				$notice_can_install_required,
				'custom-banners'
			),
			'notice_can_install_recommended'  => _n_noop(
				$notice_can_install_recommended,
				$notice_can_install_recommended_plural,
				'custom-banners'
			),
			'notice_can_activate_required'    => _n_noop(
				$notice_can_activate_required,
				$notice_can_activate_required,
				'custom_banners'
			),
			'install_link'                    => _n_noop(
				$install_link,
				$install_link,
				'custom-banners'
			),
			'activate_link'                   => _n_noop(
				$activate_link,
				$activate_link,
				'custom_banners'
			),
		);
		$config = array(
			'id'           => 'custom-banners',         	// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      		// Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', 		// Menu slug.
			'parent_slug'  => 'custom-banners-settings',	// Parent menu slug.
			'capability'   => 'manage_options',    			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    		// Show admin notices or not.
			'dismissable'  => false,                    	// If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      		// If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                   		// Automatically activate plugins after installation or not.
			'message'      => '',                      		// Message to output right before the plugins table.
			'strings'	   => $strings
		);
		
		add_filter( 'tgmpa_notice_action_links', array($this, 'add_manual_download_link') );
		tgmpa( $plugins, $config );
	}
	
	function add_manual_download_link($action_links)
	{
		$package_url = $this->get_pro_package_url();
		if ( empty($package_url) ){
			return $action_links;
		}
		$dl_link = sprintf( '<a href="%s">%s</a>', 	
							$package_url,
							__('Download &amp; Install Manually')
						  );
		if ( !empty($action_links['install']) && strpos($action_links['install'], 'Custom Banners Pro') !== false ) {
			$action_links['cbp_manual_install'] = $dl_link;
		}
		return $action_links;
	}
	
	function get_pro_package_url()
	{
		// look for a cached URL in the transient cache first
		$transient_key = '_custom_banners_pro_package_url';
		$url = get_transient($transient_key);
		if ( !empty($url) ) {
			return $url;
		}
		
		// no cached URL, so call home and ask for the package URL
		$kc = new GoldPlugins_Key_Checker('custom-banners-pro');
		$license_email = get_option('custom_banners_registered_name');
		$license_key = get_option('custom_banners_registered_key');
		$url = $kc->get_package_url($license_email, $license_key);
		
		// if an URL was found, save it to the transient cache
		if ( !empty($url) ) {
			set_transient( $transient_key, $url, DAY_IN_SECONDS );
		}
		
		// return the URL (even if its an empty string)
		return $url;
	}
}
$ebp = new CustomBannersPlugin();
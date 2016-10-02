<?php
/*
This file is part of Custom Banners.

Custom Banners is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Custom Banners is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with The Custom Banners.  If not, see <http://www.gnu.org/licenses/>.
*/
require_once("custom_banners_config.php");

class customBannersOptions
{
	var $textdomain = '';
	
	function __construct(){
		//may be running in non WP mode (for example from a notification)
		if(function_exists('add_action')){
			//add a menu item
			add_action( 'admin_menu', array($this, 'add_admin_menu_item') );	
			add_action( 'admin_init', array( $this, 'admin_scripts' ) );
			add_action( 'admin_head', array($this, 'admin_css') );
			add_action( 'custom_banners_admin_settings_page_top', array($this, 'settings_page_top') );
			//add_action( 'custom_banners_admin_settings_page_bottom', array($this, 'settings_page_bottom') );
		}
		$this->shed = new Custom_Banners_GoldPlugins_BikeShed();

		add_filter('update_option_custom_banners_registered_key', array($this, 'recheck_key') );
	}
	
	function add_admin_menu_item(){
		$title = "Custom Banners Settings";
		$page_title = "Custom Banners Settings";
		$top_level_slug = "custom-banners-settings";
		
		$submenu_pages = array(
			array(
				'parent_slug' => $top_level_slug,
				'page_title' => 'Basic Options',
				'menu_title' => 'Basic Options',
				'capability' => 'administrator',
				'menu_slug' => $top_level_slug,
				'callback' =>  array($this, 'basic_settings_page')
			),
			array(
				'parent_slug' => $top_level_slug,
				'page_title' => 'Themes',
				'menu_title' => 'Themes',
				'capability' => 'administrator',
				'menu_slug' => 'custom-banners-themes',
				'callback' => array($this, 'themes_page')
			),
			array(
				'parent_slug' => $top_level_slug,
				'page_title' => 'Style Options',
				'menu_title' => 'Style Options',
				'capability' => 'administrator',
				'menu_slug' => 'custom-banners-style-settings',
				'callback' => array($this, 'style_settings_page')
			),
			array(
				'parent_slug' => $top_level_slug,
				'page_title' => 'Help & Instructions',
				'menu_title' => 'Help & Instructions',
				'capability' => 'administrator',
				'menu_slug' => 'custom-banners-help',
				'callback' => array($this, 'help_settings_page')
			),
		);
		
		$submenu_pages = apply_filters("custom_banners_admin_settings_submenu_pages", $submenu_pages, $top_level_slug);
		
		//create new top-level menu
		add_menu_page($page_title, $title, 'administrator', $top_level_slug, array($this, 'basic_settings_page'));
		
		foreach($submenu_pages as $submenu_page){
			add_submenu_page($submenu_page['parent_slug'] , $submenu_page['page_title'], $submenu_page['menu_title'], $submenu_page['capability'],$submenu_page['menu_slug'], $submenu_page['callback']);
		}

		//call register settings function
		add_action( 'admin_init', array($this, 'register_settings'));	
	}

	function get_submenu_pages($top_level_slug)
	{
		$style_menu_label = isValidCBKey() ? __('Style Options', $this->textdomain) : __('Style Options (Pro)', $this->textdomain);
		$submenu_pages = array();
		
		$submenu_pages[] = array(
			'parent_slug' => $top_level_slug,
			'page_title' => 'Basic Options',
			'menu_title' => 'Basic Options',
			'capability' => 'administrator',
			'menu_slug' => $top_level_slug,
			'callback' => array($this, 'basic_settings_page')
		);
		
		$submenu_pages[] = array(
			'parent_slug' => $top_level_slug,
			'page_title' => 'Style Options',
			'menu_title' => $style_menu_label,
			'capability' => 'administrator',
			'menu_slug' => 'custom-banners-style-settings',
			'callback' => array($this, 'style_settings_page')
		);
				
		$submenu_pages[] = array(
			'parent_slug' => $top_level_slug,
			'page_title' => 'Help &amp; Instructions',
			'menu_title' => 'Help &amp; Instructions',
			'capability' => 'administrator',
			'menu_slug' => 'custom-banners-help',
			'callback' => array($this, 'help_settings_page')
		);
		
		return apply_filters('custom_banners_admin_settings_submenu_pages', $submenu_pages, $top_level_slug);
	}

	function get_admin_tabs($top_level_slug)
	{
		$submenu_pages = $this->get_submenu_pages($top_level_slug);
		$tabs = array();
		foreach ($submenu_pages as $page) {
			$slug = $page['menu_slug'];
			if ( empty($slug) ) {
				$slug = $top_level_slug;
			}
			$tabs[$slug] = $page['menu_title'];
		}
		return apply_filters('custom_banners_admin_tabs', $tabs, $top_level_slug);
	}

	function register_settings(){
		//register our settings
		register_setting( 'custom-banners-settings-group', 'custom_banners_custom_css' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_use_big_link' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_open_link_in_new_window' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_never_show_captions' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_never_show_cta_buttons' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_default_width' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_default_height' );
		
		register_setting( 'custom-banners-settings-group', 'custom_banners_registered_name' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_registered_url' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_registered_key' );
		register_setting( 'custom-banners-settings-group', 'custom_banners_cache_buster', array($this, 'bust_options_cache') );

		register_setting( 'custom-banners-theme-settings-group', 'custom_banners_theme' );
		register_setting( 'custom-banners-theme-settings-group', 'custom_banners_preview_window_background' );

		register_setting( 'custom-banners-style-settings-group', 'custom_banners_caption_background_color' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_caption_background_opacity' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_cta_background_color' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_cta_border_color' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_cta_border_radius' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_cta_button_font_size' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_cta_button_font_style' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_cta_button_font_family' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_cta_button_font_color' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_caption_font_size' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_caption_font_style' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_caption_font_family' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_caption_font_color' );
		register_setting( 'custom-banners-style-settings-group', 'custom_banners_cache_buster', array($this, 'bust_options_cache') );
	}
	
	//function to produce tabs on admin screen
	function admin_tabs($current = 'homepage' ) {
		$style_label = isValidCBKey() ? __('Style Options', $this->textdomain) : __('Style Options (Requires Pro)', $this->textdomain);
		$tabs = array( 	
			array(
				'menu_slug' => 'custom-banners-settings',
				'menu_title' => __('Basic Options', $this->textdomain),
			),
			array(
				'menu_slug' => 'custom-banners-themes',
				'menu_title' =>	__('Themes', $this->textdomain),
			),
			array(
				'menu_slug' => 'custom-banners-style-settings',
				'menu_title' => $style_label,
			),
			array(
				'menu_slug' => 'custom-banners-help',
				'menu_title' => __('Help &amp; Instructions', $this->textdomain),
			)
		);
				
		$tabs = apply_filters('custom_banners_admin_settings_submenu_pages', $tabs);
						
		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
			foreach( $tabs as $tab){
				$class = ( $tab['menu_slug'] == $current ) ? ' nav-tab-active' : '';
				echo "<a class='nav-tab{$class}' href='?page={$tab['menu_slug']}'>{$tab['menu_title']}</a>";
			}
		echo '</h2>';
	}
	
	function admin_scripts()
	{
		wp_enqueue_script(
			'gp-admin_v2',
			plugins_url('../assets/js/gp-admin_v2.js', __FILE__),
			array( 'jquery' ),
			false,
			true
		);	
	}
		
	function admin_css()
	{
		if(is_admin()) {
			$admin_css_url = plugins_url( '../assets/css/admin_style.css' , __FILE__ );
			wp_register_style('custom-banners-admin', $admin_css_url);
			wp_enqueue_style('custom-banners-admin');
		}	
	}

	function settings_page_top(){
		$title = "Custom Banners Settings";
		$message = "Custom Banners Settings Updated.";
		
		global $pagenow;
	?>
	<div class="wrap gold_plugins_settings <?php if(isValidCBKey()): ?>is_pro<?php endif; ?>">
		<h2><?php echo $title; ?></h2>
		
		<p class="cb_need_help">Need Help? <a href="http://goldplugins.com/documentation/custom-banners-documentation/" target="_blank">Click here</a> to read instructions, see examples, and find more information on how to add, edit, update, and output your custom banners.</p>
		
		<?php if(!isValidCBKey()): ?>		
			<?php $this->output_mailing_list_form(); ?>
		<?php endif; ?>
		
		<?php if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') : ?>
		<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
		<?php endif;
		
		$this->get_and_output_current_tab($pagenow);
	}
	
	function output_mailing_list_form()
	{
		global $current_user;
?>
		<script type="text/javascript">
			jQuery(function () {
				if (typeof(gold_plugins_init_coupon_box) == 'function') {
				gold_plugins_init_coupon_box();
				}
			});
		</script>
		<!-- Begin MailChimp Signup Form -->		
		<div id="signup_wrapper">
			<div class="topper yellow_orange_bg">
				<h3>Save 10% When You Upgrade To Custom Banners Pro</h3>
				<p class="pitch">When you upgrade, you'll instantly unlock the rotating banner widget, all style &amp; typography options, 50+ professionaly designed themes, and more! </p>
				<a class="upgrade_link" href="http://goldplugins.com/our-plugins/custom-banners?utm_source=cpn_box&utm_campaign=upgrade&utm_banner=learn_more" title="Learn More">Learn More About Custom Banners Pro &raquo;</a>
			</div>
			<div id="mc_embed_signup">
				<div class="save_now">
					<h3>Save 10% Now!</h3>
					<p class="pitch">Subscribe to our newsletter now, and we’ll send you a coupon for 10% off your upgrade to the Pro version.</p>
				</div>	
				<form action="" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div class="fields_wrapper">
						<label for="mce-NAME">Your Name:</label>
						<input type="text" value="<?php echo (!empty($current_user->display_name) ? $current_user->display_name : ''); ?>" name="NAME" class="name" id="mce-NAME" placeholder="Your Name">
						<label for="mce-EMAIL">Your Email:</label>
						<input type="email" value="<?php echo (!empty($current_user->user_email) ? $current_user->user_email : ''); ?>" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
						<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
						<div style="position: absolute; left: -5000px;"><input type="text" name="b_403e206455845b3b4bd0c08dc_6ad78db648" tabindex="-1" value=""></div>
					</div>
					<div class="clear"><input type="submit" value="Send Me The Coupon" name="subscribe" id="mc-embedded-subscribe" class="smallBlueButton"></div>
					<p class="secure"><img src="<?php echo plugins_url( '../assets/img/lock.png', __FILE__ ); ?>" alt="Lock" width="16px" height="16px" />We respect your privacy.</p>
					<input type="hidden" name="PRODUCT" value="Custom Banners Pro" />
					<input type="hidden" id="mc-upgrade-plugin-name" value="Custom Banners Pro" />
					<input type="hidden" id="mc-upgrade-link-per" value="http://goldplugins.com/purchase/custom-banners-pro/single?promo=newsub10" />
					<input type="hidden" id="mc-upgrade-link-biz" value="http://goldplugins.com/purchase/custom-banners-pro/business?promo=newsub10" />
					<input type="hidden" id="mc-upgrade-link-dev" value="http://goldplugins.com/purchase/custom-banners-pro/developer?promo=newsub10" />
				</form>
			</div>
			<p class="u_to_p"><a href="http://goldplugins.com/our-plugins/custom-banners/upgrade-to-custom-banners-pro/?utm_source=plugin&utm_campaign=small_text_signup">Upgrade to Custom Banners Pro now</a> to remove banners like this one.</p>
		</div>
		<!--End mc_embed_signup-->
<?php	
	}
	
	function get_and_output_current_tab($pagenow){
		$tab = $_GET['page'];
		
		$this->admin_tabs($tab); 
				
		return $tab;
	}
	
	function basic_settings_page(){	
		$this->settings_page_top();
		
		?><form method="post" action="options.php">
			<?php settings_fields( 'custom-banners-settings-group' ); ?>			
			
			<h3>Basic Options</h3>
			
			<p>Use the below options to control various bits of output.</p>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="custom_banners_custom_css">Custom CSS</a></th>
					<td><textarea name="custom_banners_custom_css" id="custom_banners_custom_css" style="width: 250px; height: 250px;"><?php echo get_option('custom_banners_custom_css'); ?></textarea>
					<p class="description">Input any Custom CSS you want to use here.  The plugin will work without you placing anything here - this is useful in case you need to edit any styles for it to work with your theme, though.<br/> For a list of available classes, click <a href="http://goldplugins.com/documentation/custom-banners-documentation/html-css-information-for-custom-banners/" target="_blank">here</a>.</p></td>
				</tr>
			</table>
			
			<table class="form-table">
			<?php
				$this->text_input('custom_banners_default_width', 'Default Banner Width', 'Enter a default width for your banners, in pixels. If not specified, the banner will try to fit its container.', '');
				$this->text_input('custom_banners_default_height', 'Default Banner Height', 'Enter a default height for your banners, in pixels. If not specified, the banner will try to fit its container.', '');
			?>
			</table>

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="custom_banners_use_big_link">Link Entire Banner</label></th>
					<td><input type="checkbox" name="custom_banners_use_big_link" id="custom_banners_use_big_link" value="1" <?php if(get_option('custom_banners_use_big_link')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, the entire banner will be linked to the Target URL - not just the CTA.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="custom_banners_open_link_in_new_window">Open Link in New Window</label></th>
					<td><input type="checkbox" name="custom_banners_open_link_in_new_window" id="custom_banners_open_link_in_new_window" value="1" <?php if(get_option('custom_banners_open_link_in_new_window')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, the Banner Link / CTA will open in a New Window.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="custom_banners_never_show_captions">Never Show Captions</label></th>
					<td><input type="checkbox" name="custom_banners_never_show_captions" id="custom_banners_never_show_captions" value="1" <?php if(get_option('custom_banners_never_show_captions')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, your banners will not show their captions, even if you enter one.</p>
					</td>
				</tr>
			</table>
			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="custom_banners_never_show_cta_buttons">Never Show CTA Buttons</label></th>
					<td><input type="checkbox" name="custom_banners_never_show_cta_buttons" id="custom_banners_never_show_cta_buttons" value="1" <?php if(get_option('custom_banners_never_show_cta_buttons')){ ?> checked="CHECKED" <?php } ?>/>
					<p class="description">If checked, your banners will not show their buttons, even if you have entered a call to action.</p>
					</td>
				</tr>
			</table>
				
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>

			<?php include('registration_options.php'); ?>
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
		</div><?php 
	} // end basic_settings_page function	
	
	function themes_page()
	{
		wp_enqueue_style( 'custom-banners-admin' );
		// themes page	
		$this->settings_page_top(); ?>	
		
		<form method="post" action="options.php">		
			<?php settings_fields( 'custom-banners-theme-settings-group' ); ?>			
			
			<h3>Custom Banners Themes</h3>			
			<p>Please select a theme to use with your Banners. This theme will become  your default choice, but you can always specify a different theme for each widget if you like!</p>
			
			<?php if (!isValidCBKey()): ?>
				<?php 
					$upgrade_link = '<a class="button" target="_blank" href="https://goldplugins.com/our-plugins/custom-banners/upgrade-to-custom-banners-pro/?utm_source=plugin_settings&utm_campaign=themes_upgrade_box">Upgrade Now</a>';
				?>
				<p style="color:green; font-weight: bold;"><em>Note: You are using the free edition of Custom Banners, which includes a limited number of themes. <?php echo $upgrade_link ?> to unlock all 50+ themes!</em></p>
			<?php  endif; ?>
			<table class="form-table custom-banners-options-table">
				<?php
					$current_theme = get_option('custom_banners_theme');
					$themes = CustomBanners_Config::all_themes(isValidCBKey(),false);
					$desc = 'Select a theme to see how it would look with your Banners. <br /><br /> If \'No Theme\' is selected, only your theme\'s own CSS, and any Custom CSS you\'ve added, will be applied to your Banners.';
					if (!isValidCBKey())
					{
						$desc = 'Select a theme to see how it would look with your Banners.<br /><br /> If \'No Theme\' is selected, only your theme\'s own CSS, and any Custom CSS you\'ve added, will be applied to your Banners.';						
					}
					$this->shed->grouped_select( array('name' => 'custom_banners_theme', 'options' => $themes, 'label' =>'Banners Theme', 'value' => $current_theme, 'description' => $desc) );

				?>
			</table>
			
			<div id="custom_banners_theme_preview">			
				<div id="custom_banners_theme_preview_color_picker">
					<table class="form-table">
					<?php
						$cur_prev_bg = get_option('custom_banners_preview_window_background', '#fff');
						$this->shed->color( array('name' => 'custom_banners_preview_window_background', 'label' =>'Set Background Color:', 'value' => $cur_prev_bg, 'description' => '') );
					?>
					</table>
				</div>
				<div id="custom_banners_theme_preview_browser"></div>
				<div id="custom_banners_theme_preview_content">
					<div style="" data-cycle-auto-height="container" class="custom-banners-cycle-slideshow cycle-slideshow custom-b-317582994 custom-banners-cycle-slideshow-theme-standard custom-banners-cycle-slideshow-standard-black" data-cycle-fx="fade" data-cycle-timeout="4000" data-cycle-pause-on-hover="" data-cycle-slides="> div.banner_wrapper" data-cycle-paused=""data-cycle-prev=".custom-b-317582994 .custom-b-cycle-prev"  data-cycle-next=".custom-b-317582994 .custom-b-cycle-next"data-cycle-pager=".custom-b-317582994 .custom-b-cycle-pager"data-cycle-pager-template="<span><a href=#>{{slideNum}}</a></span>"><div class="banner_wrapper" style=""><div class="banner  banner-5811 has_cta bottom vert custom-banners-theme-standard custom-banners-theme-standard-black" style=""><img width="580" height="270" src="<?php echo plugins_url( '../assets/img/Untitled-4.png', __FILE__ ); ?>" class="attachment-full size-full" alt="Untitled-4" /><div class="banner_caption" style=""><div class="banner_caption_inner" style="">Hello!  For a short time, register for free!<div class="banner_call_to_action"><a href="#"  class="banner_btn_cta" style="">Click Here!</a></div></div></div></div></div><div class="banner_wrapper" style="display:none; "><div class="banner  banner-5810 has_cta bottom vert custom-banners-theme-standard custom-banners-theme-standard-black" style=""><img width="580" height="270" src="<?php echo plugins_url( '../assets/img/Untitled-3.png', __FILE__ ); ?>" class="attachment-full size-full" alt="Untitled-3" /><div class="banner_caption" style=""><div class="banner_caption_inner" style="">For a short time, buy one get one free!<div class="banner_call_to_action"><a href="#"  class="banner_btn_cta" style="">Click Here to Learn More</a></div></div></div></div></div><div class="custom-b-cycle-controls custom-banners-controls-theme-standard custom-banners-controls-theme-standard-black"><div class="custom-b-cycle-prev">&lt;&lt;</div><div class="custom-b-cycle-pager"></div><div class="custom-b-cycle-next">&gt;&gt;</div></div></div><!-- end slideshow -->
				</div>
			</div>
			
			<?php if(!isValidCBKey()): ?>			
			<div id="custom_banners_themes_pro_warning">
				<h3>Upgrade to Unlock More Themes</h3>
				<p>Preview our available Pro themes <a href="https://goldplugins.com/documentation/custom-banners-documentation/custom-banners-pro-examples/?utm_source=themes_page">here!</a></p>
				<p class="click_to_upgrade">
					<a class="button" target="_blank" href="http://goldplugins.com/our-plugins/custom-banners-details/upgrade-to-custom-banners-pro/?utm_source=plugin_settings&utm_campaign=themes_upgrade_box">Upgrade Now</a>
				</p>
			</div>
			<?php endif; ?>
			
			<p class="submit" id="custom_banners_theme_preview_submit_button">
				<input type="submit" class="button-primary" value="<?php _e('Set Theme') ?>" />
			</p>
		</form>
		</div>						
		<?php
	}
	
	function style_settings_page()
	{
		$this->settings_page_top();
		$disabled = !(isValidCBKey());
		?><form method="post" action="options.php" class="gp_settings_form">
			<?php if (!isValidCBKey()): ?>
			<div class="plugin_is_not_registered">
				<p>Custom Banners Pro is required to use these features. The options below will become instantly available once you have registered and activated your plugin. <br /><br /><a class="button" href="http://goldplugins.com/our-plugins/custom-banners/upgrade-to-custom-banners-pro/?utm_campaign=registration&utm_source=custom_banners_settings" target="_blank">Click Here To Upgrade To Pro</a> <br /> <br /><em>You'll receive your API keys as soon as you complete your payment, instantly unlocking these features and more!</em></p>
			</div>
			<?php endif; ?>
			<?php settings_fields( 'custom-banners-style-settings-group' ); ?>
			<h3>Style Options</h3>
			<p>Use these options to adjust the style of your caption and your call to action buttons.</p>
			<fieldset>
				<legend>Caption Background</legend>				
				<table class="form-table">
					<?php 
						$this->color_input('custom_banners_caption_background_color', 'Background Color', '#000000', $disabled);
						$this->text_input('custom_banners_caption_background_opacity', 'Background Opacity (percentage)', '', '70', $disabled);
					?>
				</table>
			</fieldset>
			
			<fieldset>
				<legend>Caption Text</legend>
				<table class="form-table">
					<?php
						$this->typography_input('custom_banners_caption_*', 'Caption Font', 'Please note: these settings can be overridden for each banner by using the Visual Editor.', '', '', '', '#ffffff', $disabled );
					?>
				</table>
			</fieldset>
						
			<fieldset>
				<legend>Call To Action (CTA) Button</legend>
				<table class="form-table">
					<?php
						$this->typography_input('custom_banners_cta_button_*', 'Font', '', '', '', '', '', $disabled);
						$this->color_input('custom_banners_cta_background_color', 'Background Color', '#ffa500', $disabled);
						$this->color_input('custom_banners_cta_border_color', 'Border Color', '#ff8c00', $disabled);
						$this->text_input('custom_banners_cta_border_radius', 'Border Radius', '', '5', $disabled);
					?>
				</table>
			</fieldset>
	
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
		</div><?php 
	}
	
	function text_input($name, $label, $description = '', $default_val = '', $disabled = false)
	{
		$val = get_option($name, $default_val);
		if (empty($val)) {
			$val = $default_val;
		}
		$this->shed->text(
			array(
				'name' => $name,
				'label' => $label,
				'value' => $val,
				'description' => $description,
				'disabled' => $disabled
			)
		);
	}
	
	function color_input($name, $label, $default_color = '#000000', $disabled = false)
	{		
		$val = get_option($name, $default_color);
		if (empty($val)) {
			$val = $default_color;
		}
		$this->shed->color(
			array(
				'name' => $name,
				'label' => $label,
				'default_color' => $default_color,
				'value' => $val,
				'disabled' => $disabled
			)
		);
	}
	
	function typography_input($name, $label, $description = '', $default_font_family = '', $default_font_size = '', $default_font_style = '', $default_font_color = '#000080', $disabled = false)
	{
		$options = array(
			'name' => $name,
			'label' => $label,
			'default_color' => $default_font_color,
			'description' => $description,
			'google_fonts' => true,
			'values' => array(),
			'disabled' => $disabled			
		);
		$fields = array(
			'font_size' => $default_font_size,
			'font_family' => $default_font_family,
			'font_color' => $default_font_color,
			'font_style' => $default_font_style
		);
		foreach ($fields as $key => $default_value)
		{
			list($field_name, $field_id) = $this->shed->get_name_and_id($options, $key);
			$val = get_option($field_name, $default_value);
			if (empty($val)) {
				$val = $default_value;
			}			
			$options['values'][$key] = $val;
		}
		$this->shed->typography($options);
	}
	
	function help_settings_page(){
		$this->settings_page_top();
		include('pages/help.html');
	}
	
	function bust_options_cache()
	{
		delete_transient('_custom_bs_webfont_str');
	}
	
	function recheck_key()
	{
		$kc = new GoldPlugins_Key_Checker('custom-banners-pro');
		$license_email = get_option('custom_banners_registered_name');
		$license_key = get_option('custom_banners_registered_key');
		$key_status = $kc->get_key_status($license_email, $license_key);
		$option_key = '_custom_banners_pro_license_status';
		switch ( $key_status ) {
			
			case 'ACTIVE':			
			case 'EXPIRED':						
				update_option( $option_key, $key_status );
				break;
				
			case 'INVALID':
				delete_option( $option_key );
				break;
			
			// do nothing - couldn't reach the activation server 			
			case 'UNKNOWN': 
			default: 
				break;
		}
	}
	

} // end class
?>
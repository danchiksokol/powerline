<?php
/**
 * Defines customizer options
 *
 * @package Customizer Library Demo
 */

function customizer_library_topshop_premium_options() {

	// Theme defaults
	$primary_color = '#29a6e5';
	$secondary_color = '#266ee4';
    
    $nav_bg_color = '#FFFFFF';
    $footer_bg_color = '#FFFFFF';
    
    $body_font_color = '#4F4F4F';
    $heading_font_color = '#5E5E5E';

	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	// Logo
	$section = 'topshop-favicon';
    
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Favicon', 'topshop-premium' ),
		'priority' => '10',
		'description' => __( 'Add a favicon to your website', 'topshop-premium' )
	);
    
	$options['topshop-header-favicon'] = array(
		'id' => 'topshop-header-favicon',
		'label'   => __( 'Favicon', 'topshop-premium' ),
		'section' => $section,
		'type'    => 'image',
		'default' => '',
	);
    
    
    // Layout Settings
    $section = 'topshop-layout';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Layout Options', 'topshop-premium' ),
        'priority' => '30'
    );
    
    $choices = array(
        'topshop-layout-full-width' => 'Full Width Layout',
        'topshop-layout-boxed' => 'Boxed Layout'
    );
    $options['topshop-site-layout'] = array(
        'id' => 'topshop-site-layout',
        'label'   => __( 'Site Layout', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'description' => __( 'We have also placed <a href="http://kairaweb.com/support/topic/topshop-hooks-for-developers/" target="_blank">hooks in the TopShop theme</a> to improve development.', 'topshop-premium' ),
        'default' => 'topshop-layout-full-width'
    );
    
    $choices = array(
        'topshop-header-layout-standard' => 'Standard Layout',
        'topshop-header-layout-centered' => 'Centered Layout'
    );
    $options['topshop-header-layout'] = array(
        'id' => 'topshop-header-layout',
        'label'   => __( 'Header Layout', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'topshop-header-layout-standard'
    );
    
    $options['topshop-header-search'] = array(
        'id' => 'topshop-header-search',
        'label'   => __( 'Show Search', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Enable to a slogan for your site. This uses the site Tagline', 'topshop-premium' ),
        'default' => 1,
    );
    $options['topshop-sticky-header'] = array(
        'id' => 'topshop-sticky-header',
        'label'   => __( 'Sticky Header', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Select this box to make the main navigation sticky', 'topshop-premium' ),
        'default' => 0,
    );
    $options['topshop-show-header-top-bar'] = array(
        'id' => 'topshop-show-header-top-bar',
        'label'   => __( 'Show Top Bar', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'This will show/hide the top bar in the header.<br /><a href="http://kairaweb.com/support/topic/settings-not-showing-on-theme/" target="_blank">Not working? See here</a>', 'topshop-premium' ),
        'default' => 1,
    );
    
    // WooCommerce style Layout
    if ( topshop_is_woocommerce_activated() ) :
        
        $options['topshop-woocommerce-shop-fullwidth'] = array(
            'id' => 'topshop-woocommerce-shop-fullwidth',
            'label'   => __( 'Make Shop page full width', 'topshop-premium' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        
    endif;
    
    
    // Blog Settings
    $section = 'topshop-slider';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Slider Options', 'topshop-premium' ),
        'priority' => '35'
    );
    
    $choices = array(
        'topshop-slider-default' => 'Default Slider',
        'topshop-meta-slider' => 'Meta Slider',
        'topshop-no-slider' => 'None'
    );
    $options['topshop-slider-type'] = array(
        'id' => 'topshop-slider-type',
        'label'   => __( 'Choose a Slider', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'topshop-slider-default'
    );
    $options['topshop-slider-cats'] = array(
        'id' => 'topshop-slider-cats',
        'label'   => __( 'Slider Categories', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the ID\'s of the post categories you want to display in the slider. Eg: "13,17,19" (no spaces and only comma\'s)<br /><a href="http://kairaweb.com/support/topic/setting-up-the-default-slider/" target="_blank"><b>Follow instructions here</b></a>', 'topshop-premium' )
    );
    $options['topshop-meta-slider-shortcode'] = array(
        'id' => 'topshop-meta-slider-shortcode',
        'label'   => __( 'Slider Shortcode', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the shortcode give by meta slider.', 'topshop-premium' )
    );
    $options['topshop-slider-linkto-post'] = array(
        'id' => 'topshop-slider-linkto-post',
        'label'   => __( 'Link Slide to post', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Select this box to make the slide link to the post', 'topshop-premium' ),
        'default' => 0,
    );
    $options['topshop-slider-remove-title'] = array(
        'id' => 'topshop-slider-remove-title',
        'label'   => __( 'Remove Slider Title', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Select this box to remove the text on the slide', 'topshop-premium' ),
        'default' => 0,
    );
    $options['topshop-slider-auto-scroll'] = array(
        'id' => 'topshop-slider-auto-scroll',
        'label'   => __( 'Stop Auto Slide', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Click to stop the slider scrolling automatically', 'topshop-premium' ),
        'default' => 0,
    );


	// Colors
	$section = 'topshop-styling';
    $font_choices = customizer_library_get_font_choices();

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Styling Options', 'topshop-premium' ),
		'priority' => '38'
	);

	$options['topshop-main-color'] = array(
		'id' => 'topshop-main-color',
		'label'   => __( 'Main Color', 'topshop-premium' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $primary_color,
	);
	$options['topshop-main-color-hover'] = array(
		'id' => 'topshop-main-color-hover',
		'label'   => __( 'Secondary Color', 'topshop-premium' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondary_color,
	);
    
    $options['topshop-nav-color'] = array(
        'id' => 'topshop-nav-color',
        'label'   => __( 'Navigation Color', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $nav_bg_color,
    );
    
    $options['topshop-body-font'] = array(
        'id' => 'topshop-body-font',
        'label'   => __( 'Body Font', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $font_choices,
        'default' => 'Open Sans'
    );
    $options['topshop-body-font-color'] = array(
        'id' => 'topshop-body-font-color',
        'label'   => __( 'Body Font Color', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $body_font_color,
    );
    $options['topshop-heading-font'] = array(
        'id' => 'topshop-heading-font',
        'label'   => __( 'Headings Font', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $font_choices,
        'default' => 'Raleway'
    );
    $options['topshop-heading-font-color'] = array(
        'id' => 'topshop-heading-font-color',
        'label'   => __( 'Heading Font Color', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $heading_font_color,
    );
    
    $options['topshop-footer-color'] = array(
        'id' => 'topshop-footer-color',
        'label'   => __( 'Footer Color', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $footer_bg_color,
    );
    
    $options['topshop-custom-css'] = array(
        'id' => 'topshop-custom-css',
        'label'   => __( 'Custom CSS', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( '', 'topshop-premium'),
        'description' => __( 'Add custom CSS to your theme', 'topshop-premium' )
    );
    
    
    // Blog Settings
    $section = 'topshop-blog';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Blog Options', 'topshop-premium' ),
        'priority' => '50'
    );
    
    $choices = array(
        'blog-post-side-layout' => 'Side Layout',
        'blog-post-top-layout' => 'Top Layout'
    );
    $options['topshop-blog-layout'] = array(
        'id' => 'topshop-blog-layout',
        'label'   => __( 'Blog Post Layout', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'blog-post-side-layout'
    );
    $options['topshop-setting-blog-full-width'] = array(
        'id' => 'topshop-setting-blog-full-width',
        'label'   => __( 'Make Blog Full Width', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'checkbox',
        'description' => __( 'Click to make the blog page Full Width', 'topshop-premium' ),
        'default' => 0,
    );
    $options['topshop-blog-title'] = array(
        'id' => 'topshop-blog-title',
        'label'   => __( 'Blog Page Title', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
        'default' => 'Blog'
    );
    $options['topshop-blog-cats'] = array(
        'id' => 'topshop-blog-cats',
        'label'   => __( 'Exclude Blog Categories', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
        'description' => __( 'Enter the ID\'s of the post categories you\'d like to EXCLUDE from the Blog, enter only the ID\'s with a minus sign (-) before them, separated by a comma (,)<br />Eg: "-13, -17, -19"<br />If you enter the ID\'s without the minus then it\'ll show ONLY posts in those categories.', 'topshop-premium' )
    );
    $choices = array(
        'blog-use-images-loop' => 'Images Carousel',
        'blog-use-featured-image' => 'Use only the featured image'
    );
    $options['topshop-blog-list-image-type'] = array(
        'id' => 'topshop-blog-list-image-type',
        'label'   => __( 'Blog List Image', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'blog-use-featured-image'
    );
    
    
    // Social Settings
    $section = 'topshop-social';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Social Links', 'topshop-premium' ),
        'priority' => '80'
    );
    
    $options['topshop-social-email'] = array(
        'id' => 'topshop-social-email',
        'label'   => __( 'Email Address', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-skype'] = array(
        'id' => 'topshop-social-skype',
        'label'   => __( 'Skype Name', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-facebook'] = array(
        'id' => 'topshop-social-facebook',
        'label'   => __( 'Facebook', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-twitter'] = array(
        'id' => 'topshop-social-twitter',
        'label'   => __( 'Twitter', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-google-plus'] = array(
        'id' => 'topshop-social-google-plus',
        'label'   => __( 'Google Plus', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-youtube'] = array(
        'id' => 'topshop-social-youtube',
        'label'   => __( 'YouTube', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-vimeo'] = array(
        'id' => 'topshop-social-vimeo',
        'label'   => __( 'Vimeo', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-instagram'] = array(
        'id' => 'topshop-social-instagram',
        'label'   => __( 'Instagram', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-pinterest'] = array(
        'id' => 'topshop-social-pinterest',
        'label'   => __( 'Pinterest', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-linkedin'] = array(
        'id' => 'topshop-social-linkedin',
        'label'   => __( 'LinkedIn', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-vk'] = array(
        'id' => 'topshop-social-vk',
        'label'   => __( 'Vkontakte', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-tumblr'] = array(
        'id' => 'topshop-social-tumblr',
        'label'   => __( 'Tumblr', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-flickr'] = array(
        'id' => 'topshop-social-flickr',
        'label'   => __( 'Flickr', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-git'] = array(
        'id' => 'topshop-social-git',
        'label'   => __( 'Git', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    $options['topshop-social-bbucket'] = array(
        'id' => 'topshop-social-bbucket',
        'label'   => __( 'Bit Bucket', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
    );
    
    
    // Site Text Settings
    $section = 'topshop-website';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Website Text', 'topshop-premium' ),
        'priority' => '50'
    );
    
    $options['topshop-header-info-text'] = array(
        'id' => 'topshop-header-info-text',
        'label'   => __( 'Header Info Text', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Call Us: 082 444 BOOM', 'topshop-premium'),
        'description' => __( 'This is the text in the header', 'topshop-premium' )
    );
    $options['topshop-website-txt-copy'] = array(
        'id' => 'topshop-website-txt-copy',
        'label'   => __( 'Site Copy Text', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'TopShop theme, by <a href="http://kairaweb.com">Kaira</a>', 'topshop-premium'),
        'description' => __( 'Enter the text in the bottom bar of the footer', 'topshop-premium' )
    );
    $options['topshop-website-error-head'] = array(
        'id' => 'topshop-website-error-head',
        'label'   => __( '404 Error Page Heading', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( 'Oops! <span>404</span>', 'topshop-premium'),
        'description' => __( 'Enter the heading for the 404 Error page', 'topshop-premium' )
    );
    $options['topshop-website-error-msg'] = array(
        'id' => 'topshop-website-error-msg',
        'label'   => __( 'Error 404 Message', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'It looks like that page does not exist. <br />Return home or try a search', 'topshop-premium'),
        'description' => __( 'Enter the default text on the 404 error page (Page not found)', 'topshop-premium' )
    );
    $options['topshop-website-nosearch-msg'] = array(
        'id' => 'topshop-website-nosearch-msg',
        'label'   => __( 'No Search Results', 'topshop-premium' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'topshop-premium'),
        'description' => __( 'Enter the default text for when no search results are found', 'topshop-premium' )
    );

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: customizer_library_remove_theme_mods();

}
add_action( 'init', 'customizer_library_topshop_premium_options' );

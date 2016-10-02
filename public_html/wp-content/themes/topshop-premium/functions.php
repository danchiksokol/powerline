<?php
/**
 * TopShop functions and definitions
 *
 * @package topshop premium
 */
define( 'TOPSHOP_PREMIUM_THEME_VERSION' , '10.2.4' );

if ( ! function_exists( 'topshop_premium_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function topshop_premium_theme_setup() {
	
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 640; /* pixels */
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on topshop, use a find and replace
	 * to change 'topshop-premium' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'topshop-premium', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( 'topshop_blog_img_side', 352, 230, true );
        add_image_size( 'topshop_blog_img_top', 1100, 440, true );
    }

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'topshop-premium' ),
        'top-bar' => __( 'Top Bar Menu', 'topshop-premium' ),
        'footer-bar' => __( 'Footer Bar Menu', 'topshop-premium' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
	
	// The custom header is used for the logo
	add_theme_support( 'custom-header', array(
        'default-image' => '',
		'width'         => 280,
		'height'        => 91,
		'flex-width'    => true,
		'flex-height'   => true,
		'header-text'   => false,
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'topshop_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    
    add_theme_support( 'title-tag' );
	
	add_theme_support( 'woocommerce' );
}
endif; // topshop_premium_theme_setup
add_action( 'after_setup_theme', 'topshop_premium_theme_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function topshop_premium_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'topshop-premium' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>'
	) );
	
	register_sidebar(array(
		'name' => __( 'TopShop Footer', 'topshop-premium' ),
		'id' => 'topshop-site-footer',
        'description' => __( 'The footer will divide into however many widgets are put here.', 'topshop-premium' )
	));
}
add_action( 'widgets_init', 'topshop_premium_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function topshop_premium_theme_scripts() {
    wp_enqueue_style( 'topshop-google-body-font-default', '//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic', array(), TOPSHOP_PREMIUM_THEME_VERSION );
    wp_enqueue_style( 'topshop-google-heading-font-default', '//fonts.googleapis.com/css?family=Raleway:500,600,700,100,800,400,300', array(), TOPSHOP_PREMIUM_THEME_VERSION );
    
	wp_enqueue_style( 'topshop-font-awesome', get_template_directory_uri().'/includes/font-awesome/css/font-awesome.css', array(), '4.2.0' );
	wp_enqueue_style( 'topshop-style', get_stylesheet_uri(), array(), TOPSHOP_PREMIUM_THEME_VERSION );
    wp_enqueue_style( 'topshop-woocommerce-style', get_template_directory_uri().'/templates/css/topshop-woocommerce-style.css', array(), TOPSHOP_PREMIUM_THEME_VERSION );
	
	if ( get_theme_mod( 'topshop-header-layout', false ) == 'topshop-header-layout-centered' ) {
		wp_enqueue_style( 'topshop-header-centered-style', get_template_directory_uri().'/templates/css/topshop-header-centered.css', array(), TOPSHOP_PREMIUM_THEME_VERSION );
	} else {
		wp_enqueue_style( 'topshop-header-standard-style', get_template_directory_uri().'/templates/css/topshop-header-standard.css', array(), TOPSHOP_PREMIUM_THEME_VERSION );
	}

	wp_enqueue_script( 'topshop-navigation', get_template_directory_uri() . '/js/navigation.js', array(), TOPSHOP_PREMIUM_THEME_VERSION, true );
	wp_enqueue_script( 'topshop-caroufredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'), TOPSHOP_PREMIUM_THEME_VERSION, true );
	
	if ( get_theme_mod( 'topshop-sticky-header', false ) ) {
		wp_enqueue_script( 'topshop-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), TOPSHOP_PREMIUM_THEME_VERSION, true );
	    wp_enqueue_script( 'topshop-waypoints-sticky', get_template_directory_uri() . '/js/waypoints-sticky.min.js', array('jquery'), TOPSHOP_PREMIUM_THEME_VERSION, true );
        
        wp_enqueue_script( 'topshop-waypoints-custom', get_template_directory_uri() . '/js/waypoints-custom.js', array('jquery'), TOPSHOP_PREMIUM_THEME_VERSION, true );
	}
	
	wp_enqueue_script( 'topshop-customjs', get_template_directory_uri() . '/js/custom.js', array('jquery'), TOPSHOP_PREMIUM_THEME_VERSION, true );

	wp_enqueue_script( 'topshop-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), TOPSHOP_PREMIUM_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'topshop_premium_theme_scripts' );

/**
 * Print TopShop styling settings.
 */
function topshop_print_styles() {
    $topshop_custom_css = '';
    if ( get_theme_mod( 'topshop-custom-css', false ) ) {
        $topshop_custom_css = get_theme_mod( 'topshop-custom-css' );
    } ?>
    <style type="text/css" media="screen">
        <?php echo htmlspecialchars_decode( $topshop_custom_css ); ?>
    </style>
<?php
}
add_action('wp_head', 'topshop_print_styles', 11);

// Add the favicon to the header if set
function topshop_site_favicon() {
    if ( get_theme_mod( 'topshop-header-favicon', false ) ) :
        echo '<link rel="icon" href="' . esc_url( get_theme_mod( 'topshop-header-favicon' ) ) . '">';
    endif;
}
add_action('wp_head', 'topshop_site_favicon');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/includes/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/includes/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/includes/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/includes/inc/jetpack.php';

// Helper library for the theme customizer.
require get_template_directory() . '/customizer/customizer-library/customizer-library.php';

// Define options for the theme customizer.
require get_template_directory() . '/customizer/customizer-options.php';

// Output inline styles based on theme customizer selections.
require get_template_directory() . '/customizer/styles.php';

// Additional filters and actions based on theme customizer selections.
require get_template_directory() . '/customizer/mods.php';

/**
 * Enqueue topshop custom customizer styling.
 */
function topshop_load_customizer_script() {
    wp_enqueue_script( 'topshop-customizer-js', get_template_directory_uri() . '/customizer/customizer-library/js/customizer-custom.js', array('jquery'), TOPSHOP_PREMIUM_THEME_VERSION, true );
    
    wp_enqueue_style( 'topshop-customizer-css', get_template_directory_uri() . '/customizer/customizer-library/css/customizer.css' );
}    
add_action( 'customize_controls_enqueue_scripts', 'topshop_load_customizer_script' );

/* Display the recommended plugins notice that can be dismissed */
add_action('admin_notices', 'topshop_recommended_plugin_notice');

function topshop_recommended_plugin_notice() {
    global $pagenow;
    global $current_user;
    
    $user_id = $current_user->ID;
    
    /* If on plugins page, check that the user hasn't already clicked to ignore the message */
    if ( $pagenow == 'plugins.php' ) {
	    if ( ! get_user_meta( $user_id, 'topshop_recommended_plugin_ignore_notice' ) ) {
	        echo '<div class="updated"><p>';
            printf( __( '<p>Install the plugins we at <a href="http://www.kairaweb.com/" target="_blank">Kaira</a> recommended | <a href="%1$s">Hide Notice</a></p>', 'topshop-premium' ), '?topshop_recommended_plugin_nag_ignore=0' ); ?>
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=kaira'); ?>"><?php printf( __( 'WooCommerce', 'topshop-premium' ), 'topshop-premium' ); ?></a><br />
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=kaira'); ?>"><?php printf( __( 'SiteOrigin\'s Page Builder', 'topshop-premium' ), 'topshop-premium' ); ?></a><br />
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=kaira'); ?>"><?php printf( __( 'Meta Slider', 'topshop-premium' ), 'topshop-premium' ); ?></a><br />
            <a href="<?php echo admin_url('plugin-install.php?tab=favorites&user=kaira'); ?>"><?php printf( __( 'Breadcrumb NavXT', 'topshop-premium' ), 'topshop-premium' ); ?></a>
            <?php
	        echo "</p></div>";
	    }
	}
}
add_action('admin_init', 'topshop_recommended_plugin_nag_ignore');

function topshop_recommended_plugin_nag_ignore() {
    global $current_user;
    $user_id = $current_user->ID;
        
    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset($_GET['topshop_recommended_plugin_nag_ignore']) && '0' == $_GET['topshop_recommended_plugin_nag_ignore'] ) {
        add_user_meta( $user_id, 'topshop_recommended_plugin_ignore_notice', 'true', true );
    }
}

// Create function to check if WooCommerce exists.
if ( ! function_exists( 'topshop_is_woocommerce_activated' ) ) :
    
function topshop_is_woocommerce_activated() {
    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
}

endif; // topshop_is_woocommerce_activated

if ( topshop_is_woocommerce_activated() ) {
    require get_template_directory() . '/includes/inc/woocommerce-inc.php';
}

// Add specific CSS class by filter
function topshop_premium_add_body_class( $classes ) {
	if ( get_theme_mod( 'topshop-woocommerce-shop-fullwidth' ) ) {
		$classes[] = 'topshop-shop-full-width';
	}
	
	return $classes;
}
add_filter( 'body_class', 'topshop_premium_add_body_class' );

/**
 * Adjust is_home query if topshop-blog-cats is set
 */
function topshop_set_blog_queries( $query ) {
    $blog_query_set = '';
    if ( get_theme_mod( 'topshop-blog-cats', false ) ) {
        $blog_query_set = get_theme_mod( 'topshop-blog-cats' );
    }
    
    if ( $blog_query_set ) {
        // do not alter the query on wp-admin pages and only alter it if it's the main query
        if ( !is_admin() && $query->is_main_query() ){
            if ( is_home() ){
                $query->set( 'cat', $blog_query_set );
            }
        }
    }
}
add_action( 'pre_get_posts', 'topshop_set_blog_queries' );

/**
 * Check if Meta Slider plugin is active then add Meta Slider hoplink if slider is enabled
 */
if ( ! function_exists( 'is_plugin_active' ) )
     require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
 
if ( is_plugin_active( 'ml-slider/ml-slider.php' ) ) {
    
    function topshop_metaslider_hoplink( $link ) {
        return "https://getdpd.com/cart/hoplink/15318?referrer=9jtzbgs34v8k4c0gs";
    }
    add_filter('topshop_metaslider_hoplink', 'topshop_metaslider_hoplink', 10, 1);
    
}

function topshop_exclude_slider_categories_widget( $args ) {
	$exclude = ''; // ID's of the categories to exclude
	if ( get_theme_mod( 'topshop-slider-cats', false ) ) {
        $exclude = get_theme_mod( 'topshop-slider-cats' );
    }
	$args['exclude'] = $exclude;
	return $args;
}
add_filter( 'widget_categories_args', 'topshop_exclude_slider_categories_widget' );

/**
 * Add TopShop WP Updates code.
 */
require get_template_directory() . '/wp-updates-theme.php';
new WPUpdatesThemeUpdater_1440( 'http://wp-updates.com/api/2/theme', basename( get_template_directory() ) );

/* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- */
/* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- */
/* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- */

/*
 * Removes products count after categories name 
 */
add_filter( 'woocommerce_subcategory_count_html', 'woo_remove_category_products_count' );
 
function woo_remove_category_products_count() {
  return;
}
/* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- */

/*
 * Change "to cart" button on single product page // 10.01.2016
 */

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text() {
        return __( 'В корзину', 'woocommerce' );
}

/* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- */

/*
 * Убираем кнопку «В корзину» на основной витрине магазина 
 */
/* remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10); */

/* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- *//* ---- */


/* Прописываю дефолтную картинку для товаров без фото */
add_action( 'init', 'custom_fix_thumbnail' );
 
function custom_fix_thumbnail() {
  add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
   
	function custom_woocommerce_placeholder_img_src( $src ) {
	$upload_dir = wp_upload_dir();
	$uploads = untrailingslashit( $upload_dir['baseurl'] );
	$src = $uploads . '/2016/09/plg-no-image-600x600.png';
	 
	return $src;
	}
	} 
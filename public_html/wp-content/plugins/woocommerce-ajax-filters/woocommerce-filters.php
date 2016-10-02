<?php
/**
 * Plugin Name: WooCommerce AJAX Products Filter
 * Plugin URI: http://berocket.com/product/woocommerce-ajax-products-filter
 * Description: Unlimited AJAX products filters to make your shop perfect
 * Version: 2.0.6.34
 * Author: BeRocket
 * Requires at least: 4.0
 * Author URI: http://berocket.com
 * License: Berocket License
 * License URI: http://berocket.com/license
 * Text Domain: BeRocket_AJAX_domain
 * Domain Path: /languages/
 */
define( "BeRocket_AJAX_filters_version", '2.0.6.34' );
define( "BeRocket_AJAX_domain", 'BeRocket_AJAX_domain'); 
define( "BeRocket_AJAX_cache_expire", '21600'); 

define( "AAPF_TEMPLATE_PATH", plugin_dir_path( __FILE__ ) . "templates/" );

load_plugin_textdomain('BeRocket_AJAX_domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');

require_once dirname( __FILE__ ) . '/includes/widget.php';
require_once dirname( __FILE__ ) . '/includes/functions.php';
require_once dirname( __FILE__ ) . '/includes/updater.php';
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Class BeRocket_AAPF
 */

$br_aapf_debugs = array();
class BeRocket_AAPF {
    public static $debug_mode = false;
    public static $error_log = array();
    public static $info = array( 
        'id'        => 1,
        'version'   => BeRocket_AJAX_filters_version,
        'plugin'    => '',
        'slug'      => '',
        'key'       => '',
        'name'      => ''
    );

    public static $defaults = array(
        'plugin_key'                      => '',
        'no_products_message'             => 'There are no products meeting your criteria',
        'pos_relative'                    => '1',
        'no_products_class'               => '',
        'products_holder_id'              => 'ul.products',
        'woocommerce_result_count_class'  => '.woocommerce-result-count',
        'woocommerce_ordering_class'      => 'form.woocommerce-ordering',
        'woocommerce_pagination_class'    => '.woocommerce-pagination',
        'woocommerce_removes'             => array(
            'result_count'                => '',
            'ordering'                    => '',
            'pagination'                  => '',
        ),
        'products_per_page'               => '',
        'control_sorting'                 => '',
        'seo_friendly_urls'               => '',
        'slug_urls'                       => '',
        'nice_urls'                       => '',
        'filters_turn_off'                => '',
        'show_all_values'                 => '',
        'hide_value'                      => array(
            'o'                           => '',
            'sel'                         => '',
        ),
        'first_page_jump'                 => '',
        'scroll_shop_top'                 => '',
        'scroll_shop_top_px'              => '-180',
        'recount_products'                => '',
        'selected_area_show'              => '',
        'products_only'                   => '',
        'object_cache'                    => '',
        'ub_product_count'                => '1',
        'ub_product_text'                 => 'products',
        'ub_product_button_text'          => 'Show',
        'ajax_request_load'               => '1',
        'ajax_request_load_style'         => 'jquery',
        'product_per_row'                 => '4',
        
        'styles_input'                    => array(
            'checkbox'               => array( 'bcolor' => '', 'bwidth' => '', 'bradius' => '', 'fcolor' => '', 'backcolor' => '', 'icon' => '', 'fontsize' => '', 'theme' => '' ),
            'radio'                  => array( 'bcolor' => '', 'bwidth' => '', 'bradius' => '', 'fcolor' => '', 'backcolor' => '', 'icon' => '', 'fontsize' => '', 'theme' => '' ),
            'slider'                 => array( 'line_color' => '', 'line_height' => '', 'line_border_color' => '', 'line_border_width' => '', 'button_size' => '', 
                                               'button_color' => '', 'button_border_color' => '', 'button_border_width' => '', 'button_border_radius' => '' ),
            'pc_ub'                  => array( 'back_color' => '', 'border_color' => '', 'font_size' => '', 'font_color' => '', 'show_font_size' => '', 'close_size' => '', 
                                               'show_font_color' => '', 'show_font_color_hover' => '', 'close_font_color' => '', 'close_font_color_hover' => '' ),
            'product_count'          => 'round',
            'product_count_position' => '',
        ),
        'ajax_load_icon'                  => '',
        'ajax_load_text'                  => array(
            'top'                         => '',
            'bottom'                      => '',
            'left'                        => '',
            'right'                       => '',
        ),
        'description'                     => array(
            'show'                        => 'click',
            'hide'                        => 'click',
        ),
        'user_func'                       => array(
            'before_update'               => '',
            'on_update'                   => '',
            'after_update'                => '',
        ),
        'user_custom_css'                 => '',
        'br_opened_tab'                   => 'general',
        'number_style'                    => array(
            'thousand_separate' => '',
            'decimal_separate'  => '.',
            'decimal_number'    => '2',
        ),
        'tags_custom'                     => '',
        'ajax_site'                       => '',
        'debug_mode'                      => '',
    );
    public static $default_permalink = array (
        'variable' => 'filters',
        'value'    => '/values',
        'split'    => '/',
    );

    function __construct() {
        $error_log['000_select_status'] = array();
        register_activation_hook( __FILE__, array( __CLASS__, 'br_add_defaults' ) );
        register_uninstall_hook( __FILE__, array( __CLASS__, 'br_delete_plugin_options' ) );
        add_action( 'wpmu_new_blog', array( __CLASS__, 'new_blog' ), 10, 6 );
        add_filter( 'BeRocket_updater_add_plugin', array( __CLASS__, 'updater_info' ) );
        load_plugin_textdomain( 'BeRocket_AJAX_domain', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

        if ( ! @ is_network_admin() ) {

            if ( ( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) && br_get_woocommerce_version() >= 2.1 ) {
                $last_version = get_option('br_filters_version');
                if ( @ $last_version < BeRocket_AJAX_filters_version ) {
                    self::update_from_older ( @ $last_version );
                }
                unset($last_version);

                $option = self::get_aapf_option();
                self::$debug_mode = @ $option['debug_mode'];
                add_filter( 'BeRocket_updater_error_log', array( __CLASS__, 'add_error_log' ) );
                if ( BeRocket_AAPF::$debug_mode ) {
                    BeRocket_AAPF::$error_log['1_settings'] = $option;
                }

                add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
                add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts' ) );
                add_action( 'current_screen', array( __CLASS__, 'register_permalink_option' ) );
                add_action( 'wp_head', array( __CLASS__, 'br_custom_user_css' ) );
                add_shortcode( 'br_filters', array( __CLASS__, 'shortcode' ) );
                add_action( 'init', array( __CLASS__, 'create_metadata_table' ), 999999999 );
                add_action( 'br_footer_script', array( __CLASS__, 'include_all_scripts' ) );
                add_action( 'admin_menu', array( __CLASS__, 'br_add_options_page' ) );
                add_action( 'delete_transient_wc_products_onsale', array( __CLASS__, 'delete_products_not_on_sale' ) );

                add_action ( 'widgets_init', array( __CLASS__, 'widgets_init' ));
                if ( defined('DOING_AJAX') && DOING_AJAX ) {
                    $this->ajax_functions();
                }
                if ( ! defined('DOING_AJAX') || ! @ DOING_AJAX ) {
                    $this->not_ajax_functions();
                }
                if ( @ $option['nice_urls'] ) {
                    add_action( 'init', array( __CLASS__, 'init' ) );
                    add_filter( 'rewrite_rules_array', array( __CLASS__, 'add_rewrite_rules' ), 999999999 );
                    add_filter( 'query_vars', array( __CLASS__, 'add_queryvars' ) );
                }

                if ( @ $_GET['explode'] == 'explode') {
                    add_action( 'woocommerce_before_template_part', array( 'BeRocket_AAPF_Widget', 'pre_get_posts'), 999999 );
                    add_action( 'wp_footer', array( 'BeRocket_AAPF_Widget', 'end_clean'), 999999 );
                    add_action( 'init', array( 'BeRocket_AAPF_Widget', 'start_clean'), 1 );
                } else {
                    add_action( 'woocommerce_before_template_part', array( 'BeRocket_AAPF_Widget', 'rebuild'), 999999 );
                }

                if ( @ $option['selected_area_show'] ) {
                    add_action ( 'woocommerce_archive_description', array(__CLASS__, 'selected_area'), 1 );
                }
                if ( @ $option['products_per_page'] && ! br_is_plugin_active( 'list-grid' ) && ! br_is_plugin_active( 'more-products' ) ) {
                    add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$option['products_per_page'].';' ), 9999 );
                }
                if( @ $option['ajax_site'] ) {
                    add_action( 'wp_enqueue_scripts', array( __CLASS__, 'include_all_scripts' ) );
                }
            } else {
                if( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
                    add_action( 'admin_notices', array( __CLASS__, 'update_woocommerce	' ) );
                } else {
                    add_action( 'admin_notices', array( __CLASS__, 'no_woocommerce' ) );
                }
            }
        }
    }

    function ajax_functions() {
        add_action( 'setup_theme', array( __CLASS__, 'WPML_fix' ) );
        add_filter('loop_shop_columns', array( __CLASS__, 'loop_columns' ), 9999 );
        add_action( "wp_ajax_br_aapf_get_child", array ( __CLASS__, 'br_aapf_get_child' ) );
        add_action( "wp_ajax_nopriv_br_aapf_get_child", array ( __CLASS__, 'br_aapf_get_child' ) );
        add_action( "wp_ajax_aapf_color_set", array ( 'BeRocket_AAPF_Widget', 'color_listener' ) );
        BeRocket_AAPF_Widget::br_widget_ajax_set();
    }

    function not_ajax_functions() {
        add_filter( 'pre_get_posts', array( __CLASS__, 'apply_user_price' ) );
        add_filter( 'pre_get_posts', array( __CLASS__, 'apply_user_filters' ), 900000 );
        add_filter( 'woocommerce_shortcode_products_query', array( __CLASS__, 'woocommerce_shortcode_products_query' ), 10, 3 );
    }

    public static function widgets_init() {
        register_widget("BeRocket_AAPF_widget");
    }

    public static function add_rewrite_rules ( $rules ) {
        $option_permalink = get_option( 'berocket_permalink_option' );
        $values_split = $option_permalink['value'];
        $values_split = explode( 'values', $values_split );
        $newrules = array();
        $shop_slug = get_post(wc_get_page_id('shop'));
        $newrules[$option_permalink['variable'].'/(.*)/?'] = 'index.php?post_type=product&'.$option_permalink['variable'].'=$matches[1]';
        $newrules[$shop_slug->post_name.'/'.$option_permalink['variable'].'/(.*)/?'] = 'index.php?pagename='.$shop_slug->post_name.'&'.$option_permalink['variable'].'=$matches[1]';
        $category_base = get_option( 'woocommerce_permalinks' );
        $tag_base = $category_base['tag_base'];
        $category_base = $category_base['category_base'];

        if ( ! @ $category_base ) {
            $category_base = 'product-category';
        }
        $newrules[$category_base.'/(.+?)/'.$option_permalink['variable'].'/(.*)/?'] = 'index.php?product_cat=$matches[1]&'.$option_permalink['variable'].'=$matches[2]';

        if ( ! @ $tag_base ) {
            $tag_base = 'product-tag';
        }
        $newrules[$tag_base.'/([^/]+)/'.$option_permalink['variable'].'/(.*)/?'] = 'index.php?product_tag=$matches[1]&'.$option_permalink['variable'].'=$matches[2]';

        return $newrules + $rules;
    }

    public static function init () {
        $option_permalink = get_option( 'berocket_permalink_option' );
        add_rewrite_endpoint($option_permalink['variable'], EP_PERMALINK|EP_SEARCH|EP_CATEGORIES|EP_TAGS|EP_PAGES);
        flush_rewrite_rules();
    }

    public static function include_all_scripts() {
        global $wp_query, $wp, $sitepress;
        self::wp_print_special_scripts();
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );
        if( @ $br_options['user_func'] && is_array( $br_options['user_func'] ) ) {
            $user_func = array_merge( BeRocket_AAPF::$defaults['user_func'], $br_options['user_func'] );
        } else {
            $user_func = BeRocket_AAPF::$defaults['user_func'];
        }

        self::wp_print_footer_scripts();

        $wp_query_product_cat     = '-1';
        $wp_check_product_cat     = '1q1main_shop1q1';
        if ( @ $wp_query->query['product_cat'] ) {
            $wp_query_product_cat = explode( "/", $wp_query->query['product_cat'] );
            $wp_query_product_cat = $wp_query_product_cat[ count( $wp_query_product_cat ) - 1 ];
            $wp_check_product_cat = $wp_query_product_cat;
        }

        $post_temrs = "[]";
        if ( @ $_POST['terms'] ) {
            $post_temrs = @ json_encode( $_POST['terms'] );
        }

        if ( method_exists($sitepress, 'get_current_language') ) {
            $current_language = $sitepress->get_current_language();
        } else {
            $current_language = '';
        }

        $option_permalink = get_option( 'berocket_permalink_option' );
        $permalink_values = explode( 'values', $option_permalink['value'] );

        $current_page_url = preg_replace( "~paged?/[0-9]+/?~", "", home_url( $wp->request ) );
        if( @ $br_options['nice_urls'] ) {
            $current_page_url = preg_replace( "~".$option_permalink['variable']."/.+~", "", $current_page_url );
        }
        if( strpos($current_page_url, '?') !== FALSE ) {
            $current_page_url = explode('?', $current_page_url);
            $current_page_url = $current_page_url[0];
        }

        $permalink_structure = get_option('permalink_structure');
        if ( $permalink_structure ) {
            $permalink_structure = substr($permalink_structure, -1);
            if ( $permalink_structure == '/' ) {
                $permalink_structure = true;
            } else {
                $permalink_structure = false;
            }
        } else {
            $permalink_structure = false;
        }

        $product_taxonomy = '-1';
        if ( is_product_taxonomy() ) {
            $product_taxonomy = $wp_query->query_vars['taxonomy'].'|'.@ $wp_query->query_vars['term'];
        }

        $br_options['no_products_message'] = (empty($br_options['no_products_message']) ? __('There are no products meeting your criteria', 'BeRocket_AJAX_domain') : $br_options['no_products_message']);

        wp_localize_script(
            'berocket_aapf_widget-script',
            'the_ajax_script',
            array(
                'nice_url_variable'                    => $option_permalink['variable'],
                'nice_url_value_1'                     => $permalink_values[0],
                'nice_url_value_2'                     => $permalink_values[1],
                'nice_url_split'                       => $option_permalink['split'],
                'version'                              => BeRocket_AJAX_filters_version,
                'number_style'                         => array( @ $br_options['number_style']['thousand_separate'], @ $br_options['number_style']['decimal_separate'], @ $br_options['number_style']['decimal_number'] ),
                'current_language'                     => $current_language,
                'current_page_url'                     => $current_page_url,
                'ajaxurl'                              => admin_url( 'admin-ajax.php' ),
                'product_cat'                          => $wp_query_product_cat,
                'product_taxonomy'                     => $product_taxonomy,
                'products_holder_id'                   => @ $br_options['products_holder_id'],
                'result_count_class'                   => ( @ $br_options['woocommerce_result_count_class'] ? @ $br_options['woocommerce_result_count_class'] : BeRocket_AAPF::$defaults['woocommerce_result_count_class'] ),
                'ordering_class'                       => ( @ $br_options['woocommerce_ordering_class'] ? @ $br_options['woocommerce_ordering_class'] : BeRocket_AAPF::$defaults['woocommerce_ordering_class'] ),
                'pagination_class'                     => ( @ $br_options['woocommerce_pagination_class'] ? @ $br_options['woocommerce_pagination_class'] : BeRocket_AAPF::$defaults['woocommerce_pagination_class'] ),
                'control_sorting'                      => @ $br_options['control_sorting'],
                'seo_friendly_urls'                    => @ $br_options['seo_friendly_urls'],
                'slug_urls'                            => @ $br_options['slug_urls'],
                'nice_urls'                            => @ $br_options['nice_urls'],
                'ub_product_count'                     => @ $br_options['ub_product_count'],
                'ub_product_text'                      => @ $br_options['ub_product_text'],
                'ub_product_button_text'               => @ $br_options['ub_product_button_text'],
                'berocket_aapf_widget_product_filters' => $post_temrs,
                'user_func'                            => apply_filters( 'berocket_aapf_user_func', $user_func ),
                'default_sorting'                      => get_option('woocommerce_default_catalog_orderby'),
                'first_page'                           => @ $br_options['first_page_jump'],
                'scroll_shop_top'                      => @ $br_options['scroll_shop_top'],
                'ajax_request_load'                    => @ $br_options['ajax_request_load'],
                'ajax_request_load_style'              => ( @ $br_options['ajax_request_load_style'] ? @ $br_options['ajax_request_load_style'] : BeRocket_AAPF::$defaults['ajax_request_load_style'] ),
                'no_products'                          => ("<p class='no-products woocommerce-info" . ( ( $br_options['no_products_class'] ) ? ' '.$br_options['no_products_class'] : '' ) . "'>" . $br_options['no_products_message'] . "</p>"),
                'recount_products'                     => @ $br_options['recount_products'],
                'pos_relative'                         => @ $br_options['pos_relative'],
                'woocommerce_removes'                  => json_encode( array( 
                                                              'result_count' => @ $br_options['woocommerce_removes']['result_count'],
                                                              'ordering'     => @ $br_options['woocommerce_removes']['ordering'],
                                                              'pagination'   => @ $br_options['woocommerce_removes']['pagination'],
                                                          ) ),
                'description_show'                     => ( @ $br_options['description']['show'] ? @ $br_options['description']['show'] : 'click' ),
                'description_hide'                     => ( @ $br_options['description']['hide'] ? @ $br_options['description']['hide'] : 'click' ),
                'hide_sel_value'                       => @ $br_options['hide_value']['sel'],
                'hide_o_value'                         => @ $br_options['hide_value']['o'],
                'scroll_shop_top_px'                   => ( ( @ $br_options['scroll_shop_top_px'] ) ? $br_options['scroll_shop_top_px'] : BeRocket_AAPF::$defaults['scroll_shop_top_px'] ),
                'load_image'                           => '<div class="berocket_aapf_widget_loading"><div class="berocket_aapf_widget_loading_container">
                                                          <div class="berocket_aapf_widget_loading_top">' . ( ( @ $br_options['ajax_load_text']['top'] ) ? $br_options['ajax_load_text']['top'] : '' ) . '</div>
                                                          <div class="berocket_aapf_widget_loading_left">' . ( ( @ $br_options['ajax_load_text']['left'] ) ? $br_options['ajax_load_text']['left'] : '' ) . '</div>' .
                                                          ( ( @ $br_options['ajax_load_icon'] ) ? '<img alt="" src="'.$br_options['ajax_load_icon'].'">' : '<div class="berocket_aapf_widget_loading_image"></div>' ) .
                                                          '<div class="berocket_aapf_widget_loading_right">' . ( ( @ $br_options['ajax_load_text']['right'] ) ? $br_options['ajax_load_text']['right'] : '' ) . '</div>
                                                          <div class="berocket_aapf_widget_loading_bottom">' . ( ( @ $br_options['ajax_load_text']['bottom'] ) ? $br_options['ajax_load_text']['bottom'] : '' ) . '</div>
                                                          </div></div>',
                'translate'                            => array(
                                                            'show_value'        => __('Show value(s)', 'BeRocket_AJAX_domain'),
                                                            'hide_value'        => __('Hide value(s)', 'BeRocket_AJAX_domain'),
                                                            'unselect_all'      => __('Unselect all', 'BeRocket_AJAX_domain'),
                                                            'nothing_selected'  => __('Nothing is selected', 'BeRocket_AJAX_domain'),
                                                            'products'          => __('products', 'BeRocket_AJAX_domain'),
                ),
                'trailing_slash'                       => $permalink_structure,
            )
        );
    }

    public static function add_queryvars( $query_vars ) {
        $option_permalink = get_option( 'berocket_permalink_option' );
        $query_vars[] = $option_permalink['variable'];
        return $query_vars;
    }

    public static function updater_info ( $plugins ) {
        $option = self::get_aapf_option();
        self::$info['key'] = @ $option['plugin_key'];
        self::$info['slug'] = basename( __DIR__ );
        self::$info['plugin'] = plugin_basename( __FILE__ );
        self::$info = apply_filters( 'berocket_aapf_update_info', self::$info );
        $info = get_plugin_data( __FILE__ );
        self::$info['name'] = $info['Name'];
        $plugins[] = self::$info;
        return $plugins;
    }

    public static function add_error_log( $error_log ) {
        $error_log[plugin_basename( __FILE__ )] =  self::$error_log;
        $error_log['peak_memory'] = memory_get_peak_usage (true);
        return $error_log;
    }

    public static function update_from_older( $version ) {
        $option = self::get_aapf_option();
        if ( @$version < '2.0.4' ) {
            $version_index = 1;
        } elseif ( @$version < '2.0.5' ) {
            $version_index = 2;
        } else {
            $version_index = 3;
        }

        switch ( $version_index ) {
            case 1:
            case 2:
                update_option( 'berocket_permalink_option', BeRocket_AAPF::$default_permalink );
                break;
        }

        update_option( 'br_filters_options', $option );
        update_option( 'br_filters_version', BeRocket_AJAX_filters_version );
    }
    
    public static function load_jquery_ui() {
    }

    public static function no_woocommerce() {
        echo '
        <div class="error">
            <p>' . __( 'Activate WooCommerce plugin before', 'BeRocket_AJAX_domain' ) . '</p>
        </div>';
    }

    public static function update_woocommerce() {
        echo '
        <div class="error">
            <p>' . __( 'Update WooCommerce plugin', 'BeRocket_AJAX_domain' ) . '</p>
        </div>';
    }

    public static function br_add_options_page() {
        if( method_exists('BeRocket_updater', 'get_plugin_count') && BeRocket_updater::get_plugin_count() > 3 ) {
            add_submenu_page( 'berocket_account', __( 'Product Filters Settings', 'BeRocket_AJAX_domain' ), __( 'Product Filters', 'BeRocket_AJAX_domain' ), 'manage_options', 'br-product-filters', array(
                __CLASS__,
                'br_render_form'
            ) );
        } else {
            add_submenu_page( 'woocommerce', __( 'Product Filters Settings', 'BeRocket_AJAX_domain' ), __( 'Product Filters', 'BeRocket_AJAX_domain' ), 'manage_options', 'br-product-filters', array(
                __CLASS__,
                'br_render_form'
            ) );
        }
    }

    public static function shortcode( $atts = array() ) {
        if( BeRocket_AAPF::$debug_mode ) {
            if( ! isset( BeRocket_AAPF::$error_log['2_shortcodes'] ) )
            {
                BeRocket_AAPF::$error_log['2_shortcodes'] = array();
            } 
            BeRocket_AAPF::$error_log['2_shortcodes'][] = $atts;
        }
        $default = BeRocket_AAPF_Widget::$defaults;
        $a = shortcode_atts( $default, $atts );
        if ( @ $atts['product_cat'] ) {
            $a['product_cat'] = @ json_encode( explode( "|", $a['product_cat'] ) );
        }
        if ( @ $atts['show_page'] ) {
            $a['show_page'] = @ explode( "|", $a['show_page'] );
        }
        if( @ $atts['search_box_style'] ) {
            $a['search_box_style'] = array_merge($default['search_box_style'], (array)json_decode($atts['search_box_style']));
        }
        $a['search_box_attributes'] = $default['search_box_attributes'];
        if( @ $atts['search_box_attributes'] ) {
            $atts['search_box_attributes'] = (array)json_decode( $atts['search_box_attributes'] );
            if( is_array( $atts['search_box_attributes'] ) ) {
                foreach($atts['search_box_attributes'] as $attr_num => $attr_data) {
                    $a['search_box_attributes'][$attr_num] = array_merge($default['search_box_attributes'][$attr_num], (array)$attr_data);
                }
            }
        }
        $a['child_onew_childs'] = $default['child_onew_childs'];
        if( @ $atts['child_onew_childs'] ) {
            $atts['child_onew_childs'] = (array)json_decode( $atts['child_onew_childs'] );
            if( is_array( $atts['child_onew_childs'] ) ) {
                foreach($atts['child_onew_childs'] as $child_num => $child_data) {
                    $a['child_onew_childs'][$child_num] = array_merge($default['child_onew_childs'][$child_num], (array)$child_data);
                }
            }
        }

        $a = apply_filters( 'berocket_aapf_shortcode_options', $a );

        ob_start();
        the_widget( 'BeRocket_AAPF_widget', $a);
        return ob_get_clean();
    }

    public static function br_render_form() {
        wp_enqueue_script( 'berocket_aapf_widget-colorpicker', plugins_url( 'js/colpick.js', __FILE__ ), array( 'jquery' ) );
        wp_register_script( 'berocket_aapf_widget-admin', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), BeRocket_AJAX_filters_version, false );
        wp_enqueue_script( 'berocket_aapf_widget-admin' );

        include AAPF_TEMPLATE_PATH . "admin-settings.php";
    }

    public static function woocommerce_shortcode_products_query( $query_vars, $atts = array(), $name = 'products' ) {
        if( $name == 'products' ) {
            return $query_vars;
        }
        $new_query_vars = $query_vars;
        $new_query_vars['nopaging'] = true;
        $new_query_vars['fields'] = 'ids';
        $query = new WP_Query($query_vars);
        $query = self::apply_user_price( $query, true );
        $query = self::apply_user_filters( $query, true );
        $query_vars = $query->query_vars;
        $query_vars['post__in'] = apply_filters( 'loop_shop_post_in', $query_vars['post__in']);
        return $query_vars;
    }

    public static function display_products() {
        return '';
    }

    public static function apply_user_price( $query, $is_shortcode = FALSE ) {
        $option_permalink = get_option( 'berocket_permalink_option' );
        $options = BeRocket_AAPF::get_aapf_option();
        if ( ( ( ! is_admin() && $query->is_main_query() ) || $is_shortcode ) && ( @ $_GET['filters'] || $query->get( $option_permalink['variable'], '' ) ) ) {
            br_aapf_args_converter( $query );
            if ( @ $_POST['price'] ) {
                add_filter( 'loop_shop_post_in', array( __CLASS__, 'price_filter' ) );
            }

            if ( @ $_POST['limits'] ) {
                add_filter( 'loop_shop_post_in', array( __CLASS__, 'limits_filter' ) );
            }

            if ( @ $_POST['add_terms'] ) {
                add_filter( 'loop_shop_post_in', array( __CLASS__, 'add_terms' ) );
            }
            if( @ $options['products_only'] ) {
                add_filter('pre_option_woocommerce_shop_page_display', array( __CLASS__, 'display_products' ));
                add_filter('pre_option_woocommerce_category_archive_display', array( __CLASS__, 'display_products' ));
            }
        }
        return $query;
    }
    public static function apply_user_filters( $query, $is_shortcode = FALSE ) {
        if( BeRocket_AAPF::$debug_mode ) {
            if ( empty( BeRocket_AAPF::$error_log['8_1_query_in'] ) || ! @ is_array( BeRocket_AAPF::$error_log['8_1_query_in'] ) ) {
                BeRocket_AAPF::$error_log['8_1_query_in'] = array();
            }
            BeRocket_AAPF::$error_log['8_1_query_in'][] = $query;
            BeRocket_AAPF::$error_log['PERMALINK'] = get_option('permalink_structure');
        }
        $option_permalink = get_option( 'berocket_permalink_option' );
        if ( ( ( ! is_admin() && $query->is_main_query() ) || $is_shortcode ) && ( @ $_GET['filters'] || $query->get( $option_permalink['variable'], '' ) ) 
        && ( ( isset($query->query_vars['wc_query']) && $query->query_vars['wc_query'] == 'product_query' ) || ( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'product' ) ) ) {
            if( BeRocket_AAPF::$debug_mode ) {
                BeRocket_AAPF::$error_log['8_query_in'] = $query;
            }
            br_aapf_args_converter( $query );
            if( @ $options['products_only'] ) {
                add_filter('pre_option_woocommerce_shop_page_display', array( __CLASS__, 'display_products' ));
                add_filter('pre_option_woocommerce_category_archive_display', array( __CLASS__, 'display_products' ));
            }

            $old_post_terms                      = @ $_POST['terms'];
            $woocommerce_hide_out_of_stock_items = BeRocket_AAPF_Widget::woocommerce_hide_out_of_stock_items();
            $meta_query                          = BeRocket_AAPF::remove_out_of_stock( array(), true, $woocommerce_hide_out_of_stock_items != 'yes' );

            $args = br_aapf_args_parser();
            if ( isset( $args['meta_query'] ) ) {
                $args['meta_query'] += $meta_query;
            } else {
                $args['meta_query'] = $meta_query;
            }
            $_POST['terms'] = $old_post_terms;

            if ( @ $_POST['price'] ) {
                if( $is_shortcode ) {
                    $args['meta_query'][] = array( 'key' => '_price', 'compare' => 'BETWEEN', 'type' => 'NUMERIC', 'value' => array( ($_POST['price'][0]), $_POST['price'][1] ) );
                } else {
                    add_filter( 'loop_shop_post_in', array( __CLASS__, 'price_filter' ) );
                }
            } else {
                if ( @ $_POST['price_ranges'] ) {
                    if ( ! isset( $args['meta_query'] ) ) {
                        $args['meta_query'] = array();
                    }
                    $price_range_query = array( 'relation' => 'OR' );
                    foreach ( $_POST['price_ranges'] as $range ) {
                        $range = explode( '*', $range );
                        $price_range_query[] = array( 'key' => '_price', 'compare' => 'BETWEEN', 'type' => 'NUMERIC', 'value' => array( ($range[0] - 1), $range[1] ) );
                    }
                    $args['meta_query'][] = $price_range_query;
                }
            }

            $args = apply_filters( 'berocket_aapf_filters_on_page_load', $args );
            if( BeRocket_AAPF::$debug_mode ) {
                BeRocket_AAPF::$error_log['3_user_filters'] = $args;
            }

            $args_fields = array( 'meta_key', 'tax_query', 'fields', 'where', 'join', 'meta_query' );
            foreach ( $args_fields as $args_field ) {
                if ( @ $args[ $args_field ] ) {
                    $variable = $query->get( $args_field );
                    if( is_array($variable) ) {
                        $variable = array_merge($variable, $args[ $args_field ]);
                    } else {
                        $variable = $args[ $args_field ];
                    }
                    $query->set( $args_field, $variable );
                }
            }
            if( BeRocket_AAPF::$debug_mode ) {
                BeRocket_AAPF::$error_log['8_query_out'] = $query;
            }
        }

        if ( ( ! is_admin() && $query->is_main_query() ) || $is_shortcode ) {
            global $br_wc_query;
            $br_wc_query = $query;
        }
        if ( $is_shortcode ) {
            add_action( 'wp_footer', array( __CLASS__, 'wp_footer_widget'), 99999 );
        }

        if( BeRocket_AAPF::$debug_mode ) {
            BeRocket_AAPF::$error_log['8_2_query_out'] = $query;
        }
        return $query;
    }
    
    public static function remove_out_of_stock( $filtered_posts, $use_post_terms = false, $show_out_of_stock = false ) {
        global $wpdb;
        if ( $use_post_terms ) {
            $meta_query = array();
            if( @ $_POST['terms']) {
                foreach($_POST['terms'] as $term) {
                    if( $term[0] == '_stock_status' ) {
                        array_push($meta_query , array( 'key' => $term[0], 'value' => $term[3], 'compare' => '=' ) );
                    }
                }
                for ( $i = count( $_POST['terms'] ) - 1; $i >= 0; $i-- ) {
                    if ( $_POST['terms'][$i][0] ==  '_stock_status' ) {
                        unset( $_POST['terms'][$i] );
                    }
                }
            }

            if ( $show_out_of_stock ) {
                return $meta_query;
            } else {
                return array();
            }
        }

        $query_string = "
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta as meta ON ID = meta.post_id
            WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish'
            AND meta_key = '_stock_status' AND meta_value != 'outofstock'";

        if( BeRocket_AAPF::$debug_mode ) {
            BeRocket_AAPF::$error_log['104_remove_out_of_stock_SELECT'] = $query_string;
            $wpdb->show_errors();
        }

        // TODO: split this into 2 queries(product and product_variation) this way we will not be using all data at the same time
        $matched_products_query = $wpdb->get_results( $query_string, OBJECT_K );
        unset( $query_string );
        $matched_products = array( 0 );

        if( BeRocket_AAPF::$debug_mode ) {
            BeRocket_AAPF::$error_log['000_select_status'][] = @ $wpdb->last_error;
        }

        foreach ( $matched_products_query as $product ) {
            if ( $product->post_type == 'product' )
                $matched_products[] = $product->ID;
            // TODO: check if we really need this in_array. We have array_unique after foreach. Only one should be left
            if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) )
                $matched_products[] = $product->post_parent;
        }
        $matched_products = @ array_unique( $matched_products );

        if ( sizeof( $filtered_posts ) == 0) {
            $filtered_posts = $matched_products;
        } else {
            // TODO: array_intersect will create count($filtered_posts) * count($matched_products) loops.
            // TODO: this should be handled above, in foreach
            $filtered_posts = array_intersect( $filtered_posts, $matched_products );
        }

        return (array) $filtered_posts;
    }

    public static function remove_hidden( $filtered_posts ){
        global $wpdb;

        $query_string = "
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta as meta ON ID = meta.post_id
            WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish'
            AND meta_key = '_visibility' AND meta_value NOT IN ('hidden', 'search')";

        if( BeRocket_AAPF::$debug_mode ) {
            BeRocket_AAPF::$error_log['105_remove_hidden_SELECT'] = $query_string;
            $wpdb->show_errors();
        }

        $matched_products_query = $wpdb->get_results( $query_string, OBJECT_K );
        unset( $query_string );
        $matched_products = array( 0 );

        if( BeRocket_AAPF::$debug_mode ) {
            BeRocket_AAPF::$error_log['000_select_status'][] = @ $wpdb->last_error;
        }

        foreach ( $matched_products_query as $product ) {
            if ( $product->post_type == 'product' )
                $matched_products[] = $product->ID;
            if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) )
                $matched_products[] = $product->post_parent;
        }
        $matched_products = @ array_unique( $matched_products );

        if ( sizeof( $filtered_posts ) == 0) {
            $filtered_posts = $matched_products;
        } else {
            $filtered_posts = array_intersect( $filtered_posts, $matched_products );
        }
        return (array) $filtered_posts;
    }

    public static function limits_filter( $filtered_posts ) {
        global $wpdb;

        if ( @ $_POST['limits'] ) {
            $matched_products = false;

            foreach ( $_POST['limits'] as $v ) {
                if( $v[0] == 'pa__date' ) {
                    $from = date('Y-m-d 00:00:00', strtotime($v[1]));
                    $to = date('Y-m-d 23:59:59', strtotime($v[2]));
                    $query_string = "
                        SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
                        WHERE ( post_type = 'product' OR post_type = 'product_variation') AND post_status = 'publish'
                        AND post_modified >= '{$from}' AND post_modified <= '{$to}'";
                    $matched_products_query = $wpdb->get_results( $query_string, OBJECT_K );
                    $matched_products = array( 0 );
                    foreach ( $matched_products_query as $product ) {
                        if( $product->post_type == 'product' ) {
                            $matched_products[] = $product->ID;
                        }
                        if ( $product->post_parent > 0  ) {
                            $matched_products[] = $product->post_parent;
                        }
                    }
                    continue;
                }
                $v[1] = urldecode( $v[1] );
                $v[2] = urldecode( $v[2] );
                $all_terms_name = array();
                $all_terms_slug = array();
                $terms = get_terms( $v[0] );
                $is_numeric = true;
                $is_with_string = false;
                if( is_wp_error ( $all_terms_name ) ) {
                    BeRocket_updater::$error_log[] = $all_terms_name->errors;
                }
                if( ! is_numeric($v[1]) || ! is_numeric($v[2]) ) {
                    $is_with_string = true;
                }
                foreach ( $terms as $term ) {
                    if( ! is_numeric( substr( $term->name[0], 0, 1 ) ) ) {
                        $is_numeric = false;
                    }
                    if( ! is_numeric( $term->name ) ) {
                        $is_with_string = true;
                    }
                    array_push( $all_terms_name, $term->slug );
                    array_push( $all_terms_slug, $term->name );
                }
                if( $is_with_string ) {
                    if( $is_numeric ) {
                        array_multisort( $all_terms_slug, $all_terms_name, $all_terms_slug, SORT_NUMERIC );
                    } else {
                        array_multisort( $all_terms_name, $all_terms_name, $all_terms_slug );
                    }
                    $start_terms    = array_search( $v[1], $all_terms_name );
                    $end_terms      = array_search( $v[2], $all_terms_name );
                    $all_terms_name = array_slice( $all_terms_name, $start_terms, ( $end_terms - $start_terms + 1 ) );
                    $all_terms_name_text = implode( "','", $all_terms_name );
                    $all_terms_name_text = str_replace( '%', '%%', $all_terms_name_text );
                    $CAST           = "t.slug IN ('" . $all_terms_name_text . "')";
                } else {
                    $CAST = "t.name BETWEEN %f AND %f";
                }

                $query_string = "
                    SELECT DISTINCT ID, post_parent, cast(t.name as decimal) FROM $wpdb->posts
                    INNER JOIN $wpdb->term_relationships as tr ON ID = tr.object_id
                    INNER JOIN $wpdb->term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
                    INNER JOIN $wpdb->terms as t ON t.term_id = tt.term_id
                    WHERE post_type = 'product' AND post_status = 'publish'
                    AND tt.taxonomy = %s AND " . $CAST . "
                ";

                if( BeRocket_AAPF::$debug_mode ) {
                    BeRocket_AAPF::$error_log['106_'.$v[0].'limits_filter_SELECT'] = $wpdb->prepare( $query_string, $v[0], $v[1], $v[2] );
                    $wpdb->show_errors();
                }

                $matched_products_query = $wpdb->get_results( $wpdb->prepare( $query_string, $v[0], $v[1], $v[2] ), OBJECT_K );
                unset( $query_string );

                if( BeRocket_AAPF::$debug_mode ) {
                    BeRocket_AAPF::$error_log['000_select_status'][] = @ $wpdb->last_error;
                }

                if ( $matched_products_query ) {
                    if ( $matched_products === false ) {
                        $matched_products = array( 0 );
                        foreach ( $matched_products_query as $product ) {
                            $matched_products[] = $product->ID;
                            // TODO: probably this is not needed as this is for product_variation, not sure
                            if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) ) {
                                $matched_products[] = $product->post_parent;
                            }
                        }
                    } else {
                        $new_products = array( 0 );
                        foreach ( $matched_products_query as $product ) {
                            if ( in_array( $product->ID, $matched_products ) ) {
                                $new_products[] = $product->ID;
                                // TODO: probably this is not needed as this is for product_variation, not sure
                                if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $new_products ) ) {
                                    $new_products[] = $product->post_parent;
                                }
                            }
                        }
                        $matched_products = $new_products;
                        unset( $new_products );
                    }
                    unset( $matched_products_query );
                }

                $matched_product_variations_query = $wpdb->get_results( $wpdb->prepare( "
                    SELECT DISTINCT ID, post_parent, t.name as t_name_num FROM $wpdb->posts
                    INNER JOIN $wpdb->term_relationships as tr ON ID = tr.object_id
                    INNER JOIN $wpdb->term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
                    INNER JOIN $wpdb->terms as t ON t.term_id = tt.term_id
                    WHERE post_type = 'product_variation' AND post_status = 'publish'
                    AND tt.taxonomy = %s AND " . $CAST . "
                ", $v[0], $v[1], $v[2] ), OBJECT_K );

                if ( $matched_product_variations_query ) {
                    if ( $matched_products === false ) {
                        $matched_products = array( 0 );
                        foreach ( $matched_product_variations_query as $product ) {
                            if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) ) {
                                $matched_products[] = $product->post_parent;
                            }
                        }
                    } else {
                        $new_products = array( 0 );
                        foreach ( $matched_product_variations_query as $product ) {
                            if ( in_array( $product->ID, $matched_products ) ) {
                                if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $new_products ) ) {
                                    $new_products[] = $product->post_parent;
                                }
                            }
                        }
                        $matched_products = $new_products;
                        unset( $new_products );
                    }
                    unset( $matched_product_variations_query );
                }
            }

            if ( $matched_products === false ) {
                $matched_products = array( 0 );
            } else {
                // TODO: need to remove array_unique and check if unique in the loop
                $matched_products = @ array_unique( $matched_products );
            }

            // Filter the id's
            if ( sizeof( $filtered_posts ) == 0 ) {
                $filtered_posts = $matched_products;
            } else {
                // TODO: need to remove array_intersect and check if intersect in the loop
                $filtered_posts = array_intersect( $filtered_posts, $matched_products );
            }
        }

        return (array) $filtered_posts;
    }

    public static function add_terms( $filtered_posts ) {
        if( ! empty($_POST['add_terms']) && is_array($_POST['add_terms']) ) {
            $add_terms = array('_sale' => array());
            foreach($_POST['add_terms'] as $terms) {
                if( isset($add_terms[$terms[0]]) ) {
                    $add_terms[$terms[0]][] = $terms[1];
                }
            }
            foreach($add_terms as $term_name => $terms) {
                if( count($terms) > 0 ) {
                    $term_posts = array(0);
                    if($term_name == '_sale') {
                        if( in_array('2', $terms) ) {
                            $products = self::wc_get_product_ids_not_on_sale();
                            $term_posts = array_merge($term_posts, $products);
                            unset($products);
                        }
                        if( in_array('1', $terms) ) {
                            $products = wc_get_product_ids_on_sale();
                            $term_posts = array_merge($term_posts, $products);
                            unset($products);
                        }
                    }
                    if ( sizeof( $filtered_posts ) == 0 ) {
                        $filtered_posts = $term_posts;
                    } else {
                        $filtered_posts = array_intersect( $filtered_posts, $term_posts );
                    }
                }
            }
        }
        return $filtered_posts;
    }

    public static function delete_products_not_on_sale($transient) {
        delete_transient( 'wc_products_notonsale' );
    }

    public static function wc_get_product_ids_not_on_sale() {
        global $wpdb;

        // Load from cache
        $product_ids_on_sale = get_transient( 'wc_products_notonsale' );

        // Valid cache found
        if ( false !== $product_ids_on_sale ) {
            return $product_ids_on_sale;
        }
        delete_transient( 'wc_products_onsale' );

        $on_sale_posts = $wpdb->get_results( "
            SELECT post.ID, post.post_parent FROM `$wpdb->posts` AS post
            LEFT JOIN `$wpdb->postmeta` AS meta ON post.ID = meta.post_id
            LEFT JOIN `$wpdb->postmeta` AS meta2 ON post.ID = meta2.post_id
            WHERE post.post_type IN ( 'product', 'product_variation' )
                AND post.post_status = 'publish'
                AND meta.meta_key = '_sale_price'
                AND meta2.meta_key = '_price'
                AND (CAST( meta.meta_value AS DECIMAL ) <= 0
                OR CAST( meta.meta_value AS CHAR ) = ''
                OR CAST( meta.meta_value AS DECIMAL ) != CAST( meta2.meta_value AS DECIMAL ))
            GROUP BY post.ID;
        " );

        $product_ids_on_sale = array_unique( array_map( 'absint', array_merge( wp_list_pluck( $on_sale_posts, 'ID' ), array_diff( wp_list_pluck( $on_sale_posts, 'post_parent' ), array( 0 ) ) ) ) );

        set_transient( 'wc_products_notonsale', $product_ids_on_sale, DAY_IN_SECONDS * 30 );

        return $product_ids_on_sale;
    }

    public static function price_filter( $filtered_posts ) {
        global $wpdb;

        if ( @ $_POST['price'] || @ $_POST['price_ranges'] ) {
            $matched_products = array( 0 );
            if ( @ $_POST['price'] ) {
                $min              = floatval( $_POST['price'][0] );
                $max              = floatval( $_POST['price'][1] );

                if( BeRocket_AAPF::$debug_mode ) {
                    if( ! isset( BeRocket_AAPF::$error_log['5_price'] ) )
                    {
                        BeRocket_AAPF::$error_log['5_price'] = array();
                    } 
                    BeRocket_AAPF::$error_log['5_price']['select'] = 'from '.$min.' to '.$max;
                    $wpdb->show_errors();
                }

                $matched_products_query = apply_filters( 'woocommerce_price_filter_results', $wpdb->get_results( $wpdb->prepare( "
                    SELECT DISTINCT ID, post_parent FROM $wpdb->posts
                    INNER JOIN $wpdb->postmeta ON ID = post_id
                    WHERE post_type = 'product' AND post_status = 'publish' AND meta_key = %s AND meta_value BETWEEN %d AND %d
                ", '_price', $min, $max ), OBJECT_K ), $min, $max );
            } else {
                $values = $_POST['price_ranges'];
                $between = '';
                foreach ( $values as $value ) {
                    if ( $between ) {
                        $between .= ' OR ';
                    }
                    $between .= '( ';
                    $value = explode( '*', $value );
                    $between .= 'meta_value BETWEEN '.($value[0] - 1).' AND '.$value[1];
                    $between .= ' )';
                }

                $matched_products_query = apply_filters( 'woocommerce_price_ranges_filter_results', $wpdb->get_results( $wpdb->prepare( "
                    SELECT DISTINCT ID, post_parent FROM $wpdb->posts
                    INNER JOIN $wpdb->postmeta ON ID = post_id
                    WHERE post_type = 'product' AND post_status = 'publish' AND meta_key = %s AND ( $between )
                ", '_price' ), OBJECT_K ), $values );

                if( BeRocket_AAPF::$debug_mode ) {
                    BeRocket_AAPF::$error_log['000_select_status'][] = @ $wpdb->last_error;
                    BeRocket_AAPF::$error_log['0099_price'][] = $wpdb->prepare( "
                        SELECT DISTINCT ID, post_parent FROM $wpdb->posts
                        INNER JOIN $wpdb->postmeta ON ID = post_id
                        WHERE post_type = 'product' AND post_status = 'publish' AND meta_key = %s AND ( $between )
                    ", '_price' );
                }
            }

            if ( $matched_products_query ) {
                foreach ( $matched_products_query as $product ) {
                    $matched_products[] = $product->ID;
                    // TODO: check if this is needed here. probably this is for product_variation
                    if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) ) {
                        $matched_products[] = $product->post_parent;
                    }
                }
                unset( $matched_products_query );
            }

            $matched_product_variations_query = apply_filters( 'woocommerce_price_filter_results', $wpdb->get_results( $wpdb->prepare( "
                SELECT DISTINCT ID, post_parent FROM $wpdb->posts
                INNER JOIN $wpdb->postmeta ON ID = post_id
                WHERE post_type = 'product_variation' AND post_status = 'publish' AND meta_key = %s AND meta_value BETWEEN %d AND %d
            ", '_price', $min, $max ), OBJECT_K ), $min, $max );

            if ( $matched_product_variations_query ) {
                foreach ( $matched_product_variations_query as $product ) {
                    if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) ) {
                        $matched_products[] = $product->post_parent;
                    }
                }
                unset( $matched_product_variations_query );
            }

            // Filter the id's
            if ( sizeof( $filtered_posts ) == 0 ) {
                $filtered_posts = $matched_products;
            } else {
                // TODO: remove array_intersect from here and check for intersect in foreach
                $filtered_posts = array_intersect( $filtered_posts, $matched_products );
            }

        }

        return (array) $filtered_posts;
    }

    /**
     * Get template part (for templates like the slider).
     *
     * @access public
     *
     * @param string $name (default: '')
     *
     * @return void
     */
    public static function br_get_template_part( $name = '' ) {
        $template = '';

        // Look in your_child_theme/woocommerce-filters/name.php
        if ( $name ) {
            $template = locate_template( "woocommerce-filters/{$name}.php" );
        }

        // Get default slug-name.php
        if ( ! $template && $name && file_exists( AAPF_TEMPLATE_PATH . "{$name}.php" ) ) {
            $template = AAPF_TEMPLATE_PATH . "{$name}.php";
        }

        // Allow 3rd party plugin filter template file from their plugin
        $template = apply_filters( 'br_get_template_part', $template, $name );


        if ( $template ) {
            load_template( $template, false );
        }
    }

    public static function admin_enqueue_scripts() {
        if ( function_exists( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        } else {
            wp_enqueue_style( 'thickbox' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'thickbox' );
        }
    }

    public static function admin_init() {
        wp_register_style( 'berocket_aapf_widget-colorpicker-style', plugins_url( 'css/colpick.css', __FILE__ ) );
        wp_register_style( 'berocket_aapf_widget-admin-style', plugins_url( 'css/admin.css', __FILE__ ), "", BeRocket_AJAX_filters_version );
        wp_enqueue_style( 'berocket_aapf_widget-colorpicker-style' );
        wp_enqueue_style( 'berocket_aapf_widget-admin-style' );
        register_setting( 'br_filters_plugin_options', 'br_filters_options', array( __CLASS__, 'sanitize_aapf_option' ) );
    }

    public static function register_permalink_option() {
        $screen = get_current_screen();
        $default_values = self::$default_permalink;
        if($screen->id == 'options-permalink') {
            self::save_permalink_option($default_values);
            self::_register_permalink_option($default_values);
        }
        if(strpos($screen->id, 'widgets') !== FALSE || strpos($screen->id, 'br-product-filters') !== FALSE) {
            /*wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-widget ' );
            wp_enqueue_script( 'jquery-ui-selectmenu' );
            wp_enqueue_script( 'jquery-ui-accordion' );
            wp_enqueue_script( 'jquery-ui-button' );

            wp_register_style( 'jquery-ui', plugins_url( 'css/jquery-ui.min.css', __FILE__ ), "", BeRocket_AJAX_filters_version );
            wp_enqueue_style( 'jquery-ui' );*/
            
            wp_enqueue_script( 'brjsf-ui', plugins_url( 'js/brjsf.js', __FILE__ ), array( 'jquery' ), BeRocket_AJAX_filters_version );
            wp_register_style( 'brjsf-ui', plugins_url( 'css/brjsf.css', __FILE__ ), "", BeRocket_AJAX_filters_version );
            wp_enqueue_style( 'brjsf-ui' );
        }
        if( BeRocket_AAPF::$debug_mode ) {
            BeRocket_AAPF::$error_log['21_current_screen'] = $screen;
        }
    }
    public static function _register_permalink_option($default_values) {
        $permalink_option = 'berocket_permalink_option';
        $option_values = get_option( $permalink_option );
        $data = shortcode_atts( $default_values, $option_values );
        update_option($permalink_option, $data);
        
        add_settings_section(
            'berocket_permalinks',
            'BeRocket AJAX Filters',
            'br_permalink_input_section_echo',
            'permalink'
        );
    }

    public static function save_permalink_option( $default_values ) {
        if ( isset( $_POST['berocket_permalink_option'] ) ) {
            $option_values    = $_POST['berocket_permalink_option'];
            $data             = shortcode_atts( $default_values, $option_values );
            $data['variable'] = $data['variable'];

            update_option( 'berocket_permalink_option', $data );
        }
    }
    public static function new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
        global $wpdb;
        if ( is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
            $old_blog = $wpdb->blogid;
            switch_to_blog($blog_id);
            self::_br_add_defaults();
            switch_to_blog($old_blog);
        }
    }

    public static function br_add_defaults( $networkwide ) {
        global $wpdb;
        if ( function_exists('is_multisite') && is_multisite() ) {
            if ( $networkwide) {
                $old_blog = $wpdb->blogid;
                $blogids  = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

                foreach ( $blogids as $blog_id ) {
                    switch_to_blog( $blog_id );
                    self::_br_add_defaults();
                }

                switch_to_blog( $old_blog );
                return;
            }
        } 
        self::_br_add_defaults();
    }

    public static function _br_add_defaults() {
        $tmp = self::get_aapf_option();
        $tmp2 = get_option( 'berocket_permalink_option' );
        $version = get_option( 'br_filters_version' );
        if ( @$tmp['chk_default_options_db'] == '1' or ! @is_array( $tmp ) ) {
            delete_option( 'br_filters_options' );
            update_option( 'br_filters_options', BeRocket_AAPF::$defaults );
        }
        if ( @$tmp['chk_default_options_db'] == '1' or ! @is_array( $tmp2 ) ) {
            delete_option( 'berocket_permalink_option' );
            update_option( 'berocket_permalink_option', BeRocket_AAPF::$default_permalink );
        }
    }

    public static function br_delete_plugin_options($networkwide) {
        global $wpdb;
        if (function_exists('is_multisite') && is_multisite()) {
            if ($networkwide) {
                $old_blog = $wpdb->blogid;
                $blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
                foreach ($blogids as $blog_id) {
                    switch_to_blog($blog_id);
                    self::_br_delete_plugin_options();
                }
                switch_to_blog($old_blog);
                return;
            }
        }
        self::_br_delete_plugin_options();
    }

    public static function _br_delete_plugin_options() {
        delete_option( 'br_filters_options' );
        delete_option( 'berocket_permalink_option' );
    }

    public static function br_custom_user_css() {
        $options     = self::get_aapf_option();
        $replace_css = array(
            '#widget#'       => '.berocket_aapf_widget',
            '#widget-title#' => '.berocket_aapf_widget-title'
        );
        $result_css  = @ $options['user_custom_css'];
        foreach ( $replace_css as $key => $value ) {
            $result_css = str_replace( $key, $value, $result_css );
        }
        $uo = br_aapf_converter_styles( @$options['styles'] );
        echo '<style type="text/css">' . $result_css;
        echo ' div.berocket_aapf_widget_selected_area .berocket_aapf_widget_selected_filter a, div.berocket_aapf_selected_area_block a{'.@ $uo['style']['selected_area'].'}';
        echo ' div.berocket_aapf_widget_selected_area .berocket_aapf_widget_selected_filter a.br_hover *, div.berocket_aapf_widget_selected_area .berocket_aapf_widget_selected_filter a.br_hover, div.berocket_aapf_selected_area_block a.br_hover{'.@ $uo['style']['selected_area_hover'].'}';
        if ( @ $options['styles_input']['checkbox']['icon'] ) {
            echo 'ul.berocket_aapf_widget > li > span > input[type="checkbox"] + .berocket_label_widgets:before {display:inline-block;}';
            echo '.berocket_aapf_widget input[type="checkbox"] {display: none;}';
        }
        echo ' ul.berocket_aapf_widget > li > span > input[type="checkbox"] + .berocket_label_widgets:before {';
        if ( @ $options['styles_input']['checkbox']['bcolor'] ) {
            echo 'border-color: ';
            if ( $options['styles_input']['checkbox']['bcolor'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['checkbox']['bcolor'].';';
        }
        if ( @ $options['styles_input']['checkbox']['bwidth'] || @ $options['styles_input']['checkbox']['bwidth'] === '0' )
            echo 'border-width: '.$options['styles_input']['checkbox']['bwidth'].'px;';
        if ( @ $options['styles_input']['checkbox']['bradius'] || @ $options['styles_input']['checkbox']['bradius'] === '0' )
            echo 'border-radius: '.$options['styles_input']['checkbox']['bradius'].'px;';
        if ( @ $options['styles_input']['checkbox']['fontsize'] )
            echo 'font-size: '.$options['styles_input']['checkbox']['fontsize'].'px;';
        if ( @ $options['styles_input']['checkbox']['fcolor'] ) {
            echo 'color: ';
            if ( $options['styles_input']['checkbox']['fcolor'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['checkbox']['fcolor'].';';
        }
        if ( @ $options['styles_input']['checkbox']['backcolor'] ) {
            echo 'background-color: ';
            if ( $options['styles_input']['checkbox']['backcolor'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['checkbox']['backcolor'].';';
        }
        echo '}';
        echo ' ul.berocket_aapf_widget > li > span > input[type="checkbox"]:checked + .berocket_label_widgets:before {';
        if ( @ $options['styles_input']['checkbox']['icon'] )
            echo 'content: "\\'.$options['styles_input']['checkbox']['icon'].'";';
        echo '}';
        if ( @ $options['styles_input']['radio']['icon'] ) {
            echo 'ul.berocket_aapf_widget > li > span > input[type="radio"] + .berocket_label_widgets:before {display:inline-block;}';
            echo '.berocket_aapf_widget input[type="radio"] {display: none;}';
        }
        echo ' ul.berocket_aapf_widget > li > span > input[type="radio"] + .berocket_label_widgets:before {';
        if ( @ $options['styles_input']['radio']['bcolor'] ) {
            echo 'border-color: ';
            if ( $options['styles_input']['radio']['bcolor'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['radio']['bcolor'].';';
        }
        if ( @ $options['styles_input']['radio']['bwidth'] || @ $options['styles_input']['radio']['bwidth'] === '0' )
            echo 'border-width: '.$options['styles_input']['radio']['bwidth'].'px;';
        if ( @ $options['styles_input']['radio']['bradius'] || @ $options['styles_input']['radio']['bradius'] === '0' )
            echo 'border-radius: '.$options['styles_input']['radio']['bradius'].'px;';
        if ( @ $options['styles_input']['radio']['fontsize'] )
            echo 'font-size: '.$options['styles_input']['radio']['fontsize'].'px;';
        if ( @ $options['styles_input']['radio']['fcolor'] ) {
            echo 'color: ';
            if ( $options['styles_input']['radio']['fcolor'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['radio']['fcolor'].';';
        }
        if ( @ $options['styles_input']['radio']['backcolor'] ) {
            echo 'background-color: ';
            if ( $options['styles_input']['radio']['backcolor'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['radio']['backcolor'].';';
        }
        echo '}';
        echo ' ul.berocket_aapf_widget > li > span > input[type="radio"]:checked + .berocket_label_widgets:before {';
        if ( @ $options['styles_input']['radio']['icon'] )
            echo 'content: "\\'.$options['styles_input']['radio']['icon'].'";';
        echo '}';
        echo '.berocket_aapf_widget .slide .berocket_filter_slider.ui-widget-content .ui-slider-range, .berocket_aapf_widget .slide .berocket_filter_price_slider.ui-widget-content .ui-slider-range{';
        if ( @ $options['styles_input']['slider']['line_color'] ) {
            echo 'background-color: ';
            if ( $options['styles_input']['slider']['line_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['slider']['line_color'].';';
        }
        echo '}';
        echo '.berocket_aapf_widget .slide .berocket_filter_slider.ui-widget-content, .berocket_aapf_widget .slide .berocket_filter_price_slider.ui-widget-content{';
        if ( @ $options['styles_input']['slider']['line_height'] )
            echo 'height: '.$options['styles_input']['slider']['line_height'].'px;';
        if ( @ $options['styles_input']['slider']['line_border_color'] ) {
            echo 'border-color: ';
            if ( $options['styles_input']['slider']['line_border_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['slider']['line_border_color'].';';
        }
        if ( @ $options['styles_input']['slider']['back_line_color'] ) {
            echo 'background-color: ';
            if ( $options['styles_input']['slider']['back_line_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['slider']['back_line_color'].';';
        }
        if ( @ $options['styles_input']['slider']['line_border_width'] || @ $options['styles_input']['slider']['line_border_width'] === '0' )
            echo 'border-width: '.$options['styles_input']['slider']['line_border_width'].'px;';
        echo '}';
        echo '.berocket_aapf_widget .slide .berocket_filter_slider .ui-state-default, 
            .berocket_aapf_widget .slide .berocket_filter_price_slider .ui-state-default,
            .berocket_aapf_widget .slide .berocket_filter_slider.ui-widget-content .ui-state-default,
            .berocket_aapf_widget .slide .berocket_filter_price_slider.ui-widget-content .ui-state-default,
            .berocket_aapf_widget .slide .berocket_filter_slider .ui-widget-header .ui-state-default,
            .berocket_aapf_widget .slide .berocket_filter_price_slider .ui-widget-header .ui-state-default
            .berocket_aapf_widget .berocket_filter_slider.ui-widget-content .ui-slider-handle,
            .berocket_aapf_widget .berocket_filter_price_slider.ui-widget-content .ui-slider-handle{';
        if ( @ $options['styles_input']['slider']['button_size'] || @ $options['styles_input']['slider']['button_size'] === '0' )
            echo 'font-size: '.$options['styles_input']['slider']['button_size'].'px;';
        if ( @ $options['styles_input']['slider']['button_color'] ) {
            echo 'background-color: ';
            if ( $options['styles_input']['slider']['button_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['slider']['button_color'].';';
        }
        if ( @ $options['styles_input']['slider']['button_border_color'] ) {
            echo 'border-color: ';
            if ( $options['styles_input']['slider']['button_border_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['slider']['button_border_color'].';';
        }
        if ( @ $options['styles_input']['slider']['button_border_width'] || @ $options['styles_input']['slider']['button_border_width'] === '0' )
            echo 'border-width: '.$options['styles_input']['slider']['button_border_width'].'px;';
        if ( @ $options['styles_input']['slider']['button_border_radius'] || @ $options['styles_input']['slider']['button_border_radius'] === '0' )
            echo 'border-radius: '.$options['styles_input']['slider']['button_border_radius'].'px;';
        echo '}';
        echo ' .berocket_aapf_selected_area_hook div.berocket_aapf_widget_selected_area .berocket_aapf_widget_selected_filter a{'.( ( @ $uo['style']['selected_area_block'] ) ? 'background-'.@ $uo['style']['selected_area_block'] : '' ).( ( @ $uo['style']['selected_area_border'] ) ? ' border-'.@ $uo['style']['selected_area_border'] : '' ).'}';
        echo '.berocket_aapf_widget div.berocket_aapf_product_count_desc {';
        if ( @ $options['styles_input']['pc_ub']['back_color'] ) {
            echo 'background-color: ';
            if ( $options['styles_input']['pc_ub']['back_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['back_color'].';';
        }
        if ( @ $options['styles_input']['pc_ub']['border_color'] ) {
            echo 'border-color: ';
            if ( $options['styles_input']['pc_ub']['border_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['border_color'].';';
        }
        if ( @ $options['styles_input']['pc_ub']['font_color'] ) {
            echo 'color: ';
            if ( $options['styles_input']['pc_ub']['font_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['font_color'].';';
        }
        if ( @ $options['styles_input']['pc_ub']['font_size'] ) {
            echo 'font-size: '.$options['styles_input']['pc_ub']['font_size'].'px;';
        }
        echo '}';
        echo '.berocket_aapf_widget div.berocket_aapf_product_count_desc > span {';
        if ( @ $options['styles_input']['pc_ub']['back_color'] ) {
            echo 'background-color: ';
            if ( $options['styles_input']['pc_ub']['back_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['back_color'].';';
        }
        if ( @ $options['styles_input']['pc_ub']['border_color'] ) {
            echo 'border-color: ';
            if ( $options['styles_input']['pc_ub']['border_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['border_color'].';';
        }
        echo '}';
        echo '.berocket_aapf_widget div.berocket_aapf_product_count_desc .berocket_aapf_widget_update_button {';
        if ( @ $options['styles_input']['pc_ub']['show_font_color'] ) {
            echo 'color: ';
            if ( $options['styles_input']['pc_ub']['show_font_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['show_font_color'].';';
        }
        if ( @ $options['styles_input']['pc_ub']['show_font_size'] ) {
            echo 'font-size: '.$options['styles_input']['pc_ub']['show_font_size'].'px;';
        }
        echo '}';
        echo '.berocket_aapf_widget div.berocket_aapf_product_count_desc .berocket_aapf_widget_update_button:hover {';
        if ( @ $options['styles_input']['pc_ub']['show_font_color_hover'] ) {
            echo 'color: ';
            if ( $options['styles_input']['pc_ub']['show_font_color_hover'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['show_font_color_hover'].';';
        }
        echo '}';
        echo '.berocket_aapf_widget div.berocket_aapf_product_count_desc .berocket_aapf_close_pc {';
        if ( @ $options['styles_input']['pc_ub']['close_font_color'] ) {
            echo 'color: ';
            if ( $options['styles_input']['pc_ub']['close_font_color'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['close_font_color'].';';
        }
        if ( @ $options['styles_input']['pc_ub']['close_size'] ) {
            echo 'font-size: '.$options['styles_input']['pc_ub']['close_size'].'px;';
        }
        echo '}';
        echo '.berocket_aapf_widget div.berocket_aapf_product_count_desc .berocket_aapf_close_pc:hover {';
        if ( @ $options['styles_input']['pc_ub']['close_font_color_hover'] ) {
            echo 'color: ';
            if ( $options['styles_input']['pc_ub']['close_font_color_hover'][0] != '#' ) {
                echo '#';
            }
            echo $options['styles_input']['pc_ub']['close_font_color_hover'].';';
        }
        echo '}';
        echo '</style>';
    }

    public static function create_metadata_table() {
        wp_register_style( 'font-awesome', plugins_url( 'css/font-awesome.min.css', __FILE__ ) );
        wp_register_style( 'berocket_aapf_widget-style', plugins_url( 'css/widget.css', __FILE__ ), "", BeRocket_AJAX_filters_version );
        wp_register_style( 'berocket_aapf_widget-scroll-style', plugins_url( 'css/scrollbar/Scrollbar.min.css', __FILE__ ), "", BeRocket_AJAX_filters_version );
        wp_register_style( 'berocket_aapf_widget-themer-style', plugins_url( 'css/styler/formstyler.css', __FILE__ ), "", BeRocket_AJAX_filters_version );
        wp_register_style( 'jquery-ui-datepick', plugins_url( 'css/jquery-ui.min.css', __FILE__ ) );

        global $wpdb;
        $is_database = get_option( 'br_filters_color_database' );
        $type        = 'berocket_term';
        $table_name  = $wpdb->prefix . $type . 'meta';
        if ( ! $is_database ) {
            if ( ! empty ( $wpdb->charset ) ) {
                $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
            }
            if ( ! empty ( $wpdb->collate ) ) {
                $charset_collate .= " COLLATE {$wpdb->collate}";
            }

            $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
                meta_id bigint(20) NOT NULL AUTO_INCREMENT,
                {$type}_id bigint(20) NOT NULL default 0,
             
                meta_key varchar(255) DEFAULT NULL,
                meta_value longtext DEFAULT NULL,
                         
                UNIQUE KEY meta_id (meta_id)
            ) {$charset_collate};";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
            update_option( 'br_filters_color_database', true );
        }
        $variable_name        = $type . 'meta';
        $wpdb->$variable_name = $table_name;
    }

    public static function wp_print_footer_scripts() {
        wp_enqueue_style( 'font-awesome' );
        wp_enqueue_style( 'berocket_aapf_widget-style' );
        wp_enqueue_style( 'berocket_aapf_widget-scroll-style' );
        wp_enqueue_style( 'berocket_aapf_widget-themer-style' );

        /* custom scrollbar */
        wp_enqueue_script( 'berocket_aapf_widget-scroll-script', plugins_url( 'js/scrollbar/Scrollbar.concat.min.js', __FILE__ ), array( 'jquery' ), BeRocket_AJAX_filters_version );

        /* themer */
        wp_enqueue_script( 'berocket_aapf_widget-themer-script', plugins_url( 'js/styler/formstyler.js', __FILE__ ), array( 'jquery' ), BeRocket_AJAX_filters_version );

        /* main scripts */
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'berocket_aapf_widget-script', plugins_url( 'js/widget.min.js', __FILE__ ), array( 'jquery' ), BeRocket_AJAX_filters_version );
        wp_enqueue_script( 'berocket_aapf_widget-hack-script', plugins_url( 'js/mobiles.min.js', __FILE__ ), array( 'jquery' ), BeRocket_AJAX_filters_version );
        wp_enqueue_script( 'berocket_aapf_widget-tag_cloud', plugins_url( 'js/j.doe.cloud.min.js', __FILE__ ), array( 'jquery-ui-core' ), BeRocket_AJAX_filters_version );
    }

    public static function wp_print_special_scripts() {
        wp_enqueue_style( 'jquery-ui-datepick' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
    }

    public static function selected_area() {
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', self::get_aapf_option() );
        set_query_var( 'title', apply_filters( 'berocket_aapf_widget_title', @ $title ) );
        set_query_var( 'uo', br_aapf_converter_styles( @ $br_options['styles'] ) );
        set_query_var( 'selected_area_show', true );
        set_query_var( 'hide_selected_arrow', false );
        set_query_var( 'selected_is_hide', false );
        set_query_var( 'is_hooked', true );
        set_query_var( 'is_hide_mobile', false );
        br_get_template_part( 'widget_selected_area' );
        set_query_var( 'is_hooked', false );
    }

    public static function br_aapf_get_child() {
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', self::get_aapf_option() );
        $taxonomy = $_POST['taxonomy'];
        $type = $_POST['type'];
        $term_id = $_POST['term_id'];
        $term_id = str_replace( '\\', '', $term_id );
        $term_id = json_decode($term_id);
        if ( $type == 'slider' ) {
            $all_terms_name = array();
            $terms_1        = get_terms( $taxonomy );
            $is_numeric = true;
            $terms = array();
            foreach ( $terms_1 as $term_ar ) {
                array_push( $all_terms_name, $term_ar->name );
                if( ! is_numeric( substr( $term_ar->name[0], 0, 1 ) ) ) {
                    $is_numeric = false;
                }
            }
            if( $is_numeric ) {
                sort( $all_terms_name, SORT_NUMERIC );
            } else {
                sort( $all_terms_name );
            }
            $start_terms    = array_search( $term_id[0], $all_terms_name );
            $end_terms      = array_search( $term_id[1], $all_terms_name );
            $all_terms_name = array_slice( $all_terms_name, $start_terms, ( $end_terms - $start_terms + 1 ) );
            foreach ( $all_terms_name as $term_name ) {
                $term_id = get_term_by ( 'name', $term_name, $taxonomy );
                $args_terms = array(
                    'orderby'    => 'id',
                    'order'      => 'ASC',
                    'hide_empty' => false,
                    'parent'     => $term_id->term_id,
                );
                $current_terms = get_terms( $taxonomy, $args_terms );
                foreach ( $current_terms as $current_term ) {
                    $terms[] = $current_term;
                }
            }
            echo json_encode($terms);
        } else {
            if( is_array($term_id) && count($term_id) > 0 ) {
                $terms = array();
                foreach ( $term_id as $parent ) {
                    $args_terms = array(
                        'orderby'    => 'id',
                        'order'      => 'ASC',
                        'hide_empty' => false,
                        'parent'     => $parent,
                    );
                    if( $taxonomy == 'product_cat' ) {
                        $current_terms = BeRocket_AAPF_Widget::get_product_categories( '', $parent, array(), 0, 0, true );
                    } else {
                        $current_terms = get_terms( $taxonomy, $args_terms );
                    }
                    if( ! is_array( $current_terms ) ) {
                        $current_terms = array();
                    }
                    $new_terms = BeRocket_AAPF_Widget::get_attribute_values( $taxonomy, 'id', ( ! @ $br_options['show_all_values'] ), @ $br_options['recount_products'], $current_terms );
                    if ( is_array( $new_terms ) ) {
                        foreach ( $new_terms as $key => $term_val ) {
                            $new_terms[$key]->color = get_metadata( 'berocket_term', $term_val->term_id, 'color' );
                            $new_terms[$key]->r_class = '';
                            if( @ $br_options['hide_value']['o'] && isset($term_val->count) && $term_val->count == 0 ) {
                                $new_terms[$key]->r_class += 'berocket_hide_o_value ';
                            }
                        }
                    }
                    $terms = array_merge( $terms, $new_terms );
                }
                echo json_encode($terms);
            } else {
                echo json_encode($term_id);
            }
        }
        wp_die();
    }

    public static function WPML_fix() {
        global $sitepress;
        if ( method_exists( $sitepress, 'switch_lang' )
             && isset( $_POST['current_language'] )
             && $_POST['current_language'] !== $sitepress->get_default_language()
        ) {
            $sitepress->switch_lang( $_POST['current_language'], true );
        }
    }

    public static function loop_columns() {
        $options = self::get_aapf_option();
        $per_row = ( ( ! (int) @ $options['product_per_row'] || (int) @ $options['product_per_row'] < 1 ) ? 1 : (int) @ $options['product_per_row'] );
        return $per_row;
    }

    public static function order_by_popularity_post_clauses( $args ) {
        global $wpdb;
        $args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";
        return $args;
    }

    public static function order_by_rating_post_clauses( $args ) {
        global $wpdb;
        $args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";
        $args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";
        $args['join'] .= "
            LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
            LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
            ";
        $args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";
        $args['groupby'] = "$wpdb->posts.ID";
        return $args;
    }
    public static function sanitize_aapf_option( $input ) {
        $default = BeRocket_AAPF::$defaults;
        $result = self::recursive_array_set( $default, $input );
        return $result;
    }
    public static function recursive_array_set( $default, $options ) {
        foreach( $default as $key => $value ) {
            if( array_key_exists( $key, $options ) ) {
                if( is_array( $value ) ) {
                    if( is_array( $options[$key] ) ) {
                        $result[$key] = self::recursive_array_set( $value, $options[$key] );
                    } else {
                        $result[$key] = self::recursive_array_set( $value, array() );
                    }
                } else {
                    $result[$key] = $options[$key];
                }
            } else {
                if( is_array( $value ) ) {
                    $result[$key] = self::recursive_array_set( $value, array() );
                } else {
                    $result[$key] = '';
                }
            }
        }
        foreach( $options as $key => $value ) {
            if( ! array_key_exists( $key, $result ) ) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
    public static function get_aapf_option() {
        $options = get_option( 'br_filters_options' );
        if ( @ $options && is_array ( $options ) ) {
            $options = array_merge( BeRocket_AAPF::$defaults, $options );
        } else {
            $options = BeRocket_AAPF::$defaults;
        }
        return $options;
    }
    public static function wp_footer_widget() {
        global $br_widget_ids;
        if( isset( $br_widget_ids ) && is_array( $br_widget_ids ) && count( $br_widget_ids ) > 0 ) {
            echo '<div class="berocket_wc_shortcode_fix" style="display: none;">';
            foreach ( $br_widget_ids as $widget ) {
                $widget['br_wp_footer'] = true;
                the_widget( 'BeRocket_AAPF_widget', $widget);
            }
            echo '</div>';
        }
    }
}

new BeRocket_AAPF;
?>
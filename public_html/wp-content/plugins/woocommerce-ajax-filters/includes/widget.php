<?php
define('BEROCKETAAPF', 'BeRocket_AAPF_Widget');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


require_once dirname( __FILE__ ).'/functions.php';
/**
 * BeRocket_AAPF_Widget - main filter widget. One filter for any needs
 */
class BeRocket_AAPF_Widget extends WP_Widget {

    public static $defaults = array(
        'br_wp_footer'                  => false,
        'widget_type'                   => 'filter',
        'title'                         => '',
        'filter_type'                   => 'attribute',
        'attribute'                     => 'price',
        'custom_taxonomy'               => 'product_cat',
        'type'                          => 'slider',
        'operator'                      => 'OR',
        'order_values_by'               => '',
        'text_before_price'             => '',
        'text_after_price'              => '',
        'parent_product_cat'            => '',
        'depth_count'                   => '0',
        'widget_is_hide'                => '0',
        'show_product_count_per_attr'   => '0',
        'hide_child_attributes'         => '0',
        'hide_collapse_arrow'           => '0',
        'use_value_with_color'          => '0',
        'values_per_row'                => '1',
        'icon_before_title'             => '',
        'icon_after_title'              => '',
        'icon_before_value'             => '',
        'icon_after_value'              => '',
        'description'                   => '',
        'css_class'                     => '',
        'tag_cloud_height'              => '0',
        'tag_cloud_min_font'            => '12',
        'tag_cloud_max_font'            => '14',
        'tag_cloud_tags_count'          => '100',
        'use_min_price'                 => '0',
        'min_price'                     => '0',
        'use_max_price'                 => '0',
        'max_price'                     => '1',
        'height'                        => 'auto',
        'scroll_theme'                  => 'dark',
        'selected_area_show'            => '0',
        'hide_selected_arrow'           => '0',
        'selected_is_hide'              => '0',
        'slider_default'                => '0',
        'is_hide_mobile'                => '0',
        'user_can_see'                  => '',
        'cat_propagation'               => '0',
        'product_cat'                   => '',
        'parent_product_cat_current'    => '0',
        'show_page'                     => array( 'shop', 'product_cat', 'product_tag', 'product_taxonomy' ),
        'cat_value_limit'               => '0',
        'child_parent'                  => '',
        'child_parent_depth'            => '1',
        'child_parent_no_values'        => '',
        'child_parent_previous'         => '',
        'child_parent_no_products'      => '',
        'child_onew_count'              => '1',
        'child_onew_childs'             => array(
            1                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            2                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            3                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            4                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            5                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            6                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            7                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            8                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            9                               => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
            10                              => array('title' => '', 'no_product' => '', 'no_values' => '', 'previous' => ''),
        ),
        'search_box_link_type'          => 'shop_page',
        'search_box_url'                => '',
        'search_box_category'           => '',
        'search_box_count'              => '1',
        'search_box_attributes'             => array(
            1                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            2                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            3                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            4                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            5                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            6                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            7                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            8                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            9                               => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
            10                              => array('type' => 'attribute', 'attribute' => '', 'custom_taxonomy' => '', 'title' => '', 'visual_type' => 'select'),
        ),
        'search_box_style'              => array(
            'position'                      => 'vertical',
            'search_position'               => 'after',
            'search_text'                   => 'Search',
            'background'                    => 'bbbbff',
            'back_opacity'                  => '0',
            'button_background'             => '888800',
            'button_background_over'        => 'aaaa00',
            'text_color'                    => '000000',
            'text_color_over'               => '000000',
        ),
        'ranges'                        => array( 1, 10 ),
        'hide_first_last_ranges'        => '',
        'include_exclude_select'        => '',
        'include_exclude_list'          => array(),
    );

    /**
     * Constructor
     */
    function BeRocket_AAPF_Widget() {
        global $wp_version;
        /* Widget settings. */
        $widget_ops  = array( 'classname' => 'widget_berocket_aapf', 'description' => __('Add Filters to Products page', 'BeRocket_AJAX_domain') );

        /* Widget control settings. */
        $control_ops = array( 'id_base' => 'berocket_aapf_widget' );

        /* Create the widget. */
        if( strcmp( $wp_version, '4.3') < 0 ) {
            $this->WP_Widget( 'berocket_aapf_widget', __('AJAX Product Filters', 'BeRocket_AJAX_domain'), $widget_ops, $control_ops );
        } else {
            $this->__construct( 'berocket_aapf_widget', __('AJAX Product Filters', 'BeRocket_AJAX_domain'), $widget_ops, $control_ops );
        }

        add_filter( 'berocket_aapf_listener_wp_query_args', 'br_aapf_args_parser' );
    }
    public static function br_widget_ajax_set() {
        if ( ( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) && br_get_woocommerce_version() >= 2.1 ) {
            
            add_action( 'wp_ajax_nopriv_berocket_aapf_listener', array( __CLASS__, 'listener' ) );
            add_action( 'wp_ajax_berocket_aapf_listener', array( __CLASS__, 'listener' ) );
            add_action( 'wp_ajax_nopriv_berocket_aapf_listener_pc', array( __CLASS__, 'listener_product_count' ) );
            add_action( 'wp_ajax_berocket_aapf_listener_pc', array( __CLASS__, 'listener_product_count' ) );
            add_action( 'wp_ajax_berocket_aapf_color_listener', array( __CLASS__, 'color_listener' ) );
            add_action( 'wp_ajax_br_include_exclude_list', array( __CLASS__, 'ajax_include_exclude_list' ) );
        }
    }

    /**
     * Show widget to user
     *
     * @param array $args
     * @param array $instance
     */
    function widget( $args, $instance ) {
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );

        global $wp_query, $wp, $sitepress, $br_wc_query;
        if( ! isset( BeRocket_AAPF::$error_log['6_widgets'] ) )
        {
            BeRocket_AAPF::$error_log['6_widgets'] = array();
        } 
        $widget_error_log             = array();

        $instance = array_merge( self::$defaults, $instance );
        if( ( $instance['user_can_see'] == 'logged' && ! is_user_logged_in() ) || ( $instance['user_can_see'] == 'not_logged' && is_user_logged_in() ) ) {
            return false;
        }

        if( BeRocket_AAPF::$debug_mode ) {
            $widget_error_log['wp_query'] = $wp_query;
            $widget_error_log['args']     = $args;
            $widget_error_log['instance'] = $instance;
        }

        if( @ $br_options['user_func'] && is_array( $br_options['user_func'] ) ) {
            $user_func = array_merge( BeRocket_AAPF::$defaults['user_func'], $br_options['user_func'] );
        } else {
            $user_func = BeRocket_AAPF::$defaults['user_func'];
        }

        if( @ $br_options['filters_turn_off'] ) return false;

        if( !( $instance['filter_type'] == 'attribute'
        && ( $instance['attribute'] == 'price' || $instance['attribute'] == 'product_cat' ) )
        || $instance['filter_type'] == 'product_cat'
        || $instance['filter_type'] == '_stock_status'
        || $instance['filter_type'] == 'tag'
        || $instance['type'] == 'slider' ) {
            if( @ $instance['child_parent'] == 'depth' ) {
                $count = @ $instance['child_onew_count'];
                $title = @ $instance['title'];
                $instance['child_parent'] = 'parent';
                $childs = @ $instance['child_onew_childs'];
                
                $BeRocket_AAPF_Widget = new BeRocket_AAPF_Widget();
                $BeRocket_AAPF_Widget->widget( $args, $instance );
                $instance['child_parent'] = 'child';
                for( $i = 1; $i <= $count; $i++ ) {
                    $child = $childs[$i];
                    $new_args = $args;
                    $instance['child_parent_depth'] = $i;
                    $instance['title'] = $childs[$i]['title'];
                    $instance['child_parent_no_values'] = @ $childs[$i]['no_values'];
                    $instance['child_parent_previous'] = @ $childs[$i]['previous'];
                    $instance['child_parent_no_products'] = @ $childs[$i]['no_product'];
                    $BeRocket_AAPF_Widget = new BeRocket_AAPF_Widget();
                    $BeRocket_AAPF_Widget->widget( $new_args, $instance );
                }
                return false;
            }
        }

        if ( @ $instance['show_page'] ) {
            $pageid = get_the_ID();
            $pagelimit = FALSE;

            foreach ( @ $instance['show_page'] as $page => $is_show ) {
                if( $is_show ) {
                    $pagelimit = TRUE;
                    break;
                }
            }
            if ( $pagelimit &&
                ( ( ! is_product_category() && ! is_shop() && ! is_product_tag() && ! is_product_taxonomy() && ! is_product() && ! @ in_array( $pageid, $instance['show_page'] ) ) || 
                ( is_shop() && ! @ in_array( 'shop', $instance['show_page'] ) ) || 
                ( is_product_category() && ! @ in_array( 'product_cat', $instance['show_page'] ) ) || 
                ( is_product() && ! @ in_array( 'single_product', $instance['show_page'] ) ) || 
                ( is_product_taxonomy() && ! @ in_array( 'product_taxonomy', $instance['show_page'] ) && ! is_product_category() ) || 
                ( is_product_tag() && ! @ in_array( 'product_tag', $instance['show_page'] ) ) )
                ) {
                    
                if( BeRocket_AAPF::$debug_mode ) {
                    $widget_error_log['return'] = 'hidden';
                    BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                }
                return false;
            }
        }
        if ( isset ( $br_wc_query ) ) {
            $old_query = $wp_query;
            $wp_query = $br_wc_query;
        }

        $wp_query_product_cat     = '-1';
        $wp_check_product_cat     = '1q1main_shop1q1';
        if ( @ $wp_query->query['product_cat'] ) {
            $wp_query_product_cat = explode( "/", $wp_query->query['product_cat'] );
            $wp_query_product_cat = $wp_query_product_cat[ count( $wp_query_product_cat ) - 1 ];
            $wp_query_product_cat = urldecode($wp_query_product_cat);
            $wp_check_product_cat = $wp_query_product_cat;
        }

        if ( ! $br_options['products_holder_id'] ) $br_options['products_holder_id'] = 'ul.products';

        if( ! @ $br_options['ajax_site'] ) {
            do_action('br_footer_script');
        } else {
            echo '<script>jQuery(document).ready(function() {if(typeof(berocket_filters_first_load) == "function") {berocket_filters_first_load();}});</script>';
        }

        if ( @ ! $instance['br_wp_footer'] ) {
            global $br_widget_ids;
            if ( ! isset( $br_widget_ids ) ) {
                $br_widget_ids = array();
            }
            $br_widget_ids[] = $instance;
        }

        extract( $args );
        extract( $instance );

        if ( ! @ $order_values_by ) {
            $order_values_by = 'Default';
        }

        if ( @ $filter_type == 'product_cat' || $filter_type == '_stock_status' || $filter_type == '_sale' ) {
            $attribute   = $filter_type;
            $filter_type = 'attribute';
        }

        $product_cat = @ json_decode( $product_cat );

        if ( $product_cat && is_product_category() ) {
            $hide_widget = true;

            $cur_cat = get_term_by( 'slug', $wp_query_product_cat, 'product_cat' );
            $cur_cat_ancestors = get_ancestors( $cur_cat->term_id, 'product_cat' );
            $cur_cat_ancestors[] = $cur_cat->term_id;

            if ( @ $cat_propagation ) {
                foreach ( $product_cat as $cat ) {
                    $cat = get_term_by( 'slug', $cat, 'product_cat' );

                    if ( @ in_array( $cat->term_id, $cur_cat_ancestors ) ) {
                        $hide_widget = false;
                        break;
                    }
                }
            } else {
                foreach ( $product_cat as $cat ) {
                    if ( $cat == $wp_query_product_cat ) {
                        $hide_widget = false;
                        break;
                    }
                }
            }


            if ( $hide_widget ) {
                $widget_error_log['return'] = 'hide_widget';
                BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                if ( isset ( $br_wc_query ) ) {
                    $wp_query = $old_query;
                }
                return true;
            }
        }

        if ( @ $widget_type == 'update_button' ) {
            set_query_var( 'title', apply_filters( 'berocket_aapf_widget_title', $title ) );
            set_query_var( 'uo', br_aapf_converter_styles( @ $br_options['styles'] ) );
            set_query_var( 'is_hide_mobile', @ $is_hide_mobile );
            echo $before_widget;
            br_get_template_part( 'widget_update_button' );
            echo $after_widget;
            $widget_error_log['return'] = 'update_button';
            BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
            if ( isset ( $br_wc_query ) ) {
                $wp_query = $old_query;
            }
            return '';
        }

        if ( @ $widget_type == 'reset_button' ) {
            set_query_var( 'title', apply_filters( 'berocket_aapf_widget_title', $title ) );
            set_query_var( 'uo', br_aapf_converter_styles( @ $br_options['styles'] ) );
            set_query_var( 'is_hide_mobile', @ $is_hide_mobile );
            echo $before_widget;
            br_get_template_part( 'widget_reset_button' );
            echo $after_widget;
            $widget_error_log['return'] = 'reset_button';
            BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
            if ( isset ( $br_wc_query ) ) {
                $wp_query = $old_query;
            }
            return '';
        }

        if ( @ $widget_type == 'selected_area' ) {
            if ( ! @ $scroll_theme ) {
                $scroll_theme = 'dark';
            }
            set_query_var( 'title', apply_filters( 'berocket_aapf_widget_title', $title ) );
            set_query_var( 'uo', br_aapf_converter_styles( @ $br_options['styles'] ) );
            set_query_var( 'selected_area_show', $selected_area_show );
            set_query_var( 'hide_selected_arrow', $hide_selected_arrow );
            set_query_var( 'selected_is_hide', $selected_is_hide );
            set_query_var( 'is_hide_mobile', @ $is_hide_mobile );
            echo $before_widget;
            br_get_template_part( 'widget_selected_area' );
            echo $after_widget;

            $widget_error_log['return'] = 'selected_area';
            BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
            if ( isset ( $br_wc_query ) ) {
                $wp_query = $old_query;
            }
            return '';
        }

        if ( @ $widget_type == 'search_box' ) {
            if( $search_box_link_type == 'shop_page' ) {
                $search_box_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
            } elseif( $search_box_link_type == 'category' ) {
                $search_box_url = get_term_link( $search_box_category, 'product_cat' );
            }
            $sb_style = '';
            if ( $search_box_style['position'] == 'horizontal' ) {
                $sb_count = $search_box_count;
                if( $search_box_style['search_position'] == 'before_after' ) {
                    $sb_count += 2;
                } else {
                    $sb_count++;
                }
                $search_box_width = (int)(100 / $sb_count);
                $sb_style .= 'width:'.$search_box_width.'%;display:inline-block;padding: 4px;';
            }
            echo $before_widget;
            $search_box_button_class = 'search_box_button_class_'.rand();
            $sbb_style = '';
            $sbb_style .= 'background-color:'.(@ $search_box_style['background'][0] == '#' ? $search_box_style['background'] : '#'.$search_box_style['background']).';';
            $sbb_style .= 'opacity:'.$search_box_style['back_opacity'].';';
            if( @ $title ) { ?><h3 class="widget-title berocket_aapf_widget-title" style="<?php echo @ $uo['style']['title'] ?>"><span><?php echo @ $title; ?></span></h3><?php }
            echo '<div class="berocket_search_box_block">';
            echo '<div class="berocket_search_box_background" style="'.$sbb_style.'"></div>';
            echo '<div class="berocket_search_box_background_all">';
            $sbb_style = '';
            $sbb_style .= 'background-color:'.(@ $search_box_style['button_background'][0] == '#' ? $search_box_style['button_background'] : '#'.$search_box_style['button_background']).';';
            $sbb_style .= 'color:'.(@ $search_box_style['text_color'][0] == '#' ? $search_box_style['text_color'] : '#'.$search_box_style['text_color']).';';
            $sbb_style_hover = 'background-color:'.(@ $search_box_style['button_background_over'][0] == '#' ? $search_box_style['button_background_over'] : '#'.$search_box_style['button_background_over']).';';
            $sbb_style_hover .= 'color:'.(@ $search_box_style['text_color_over'][0] == '#' ? $search_box_style['text_color_over'] : '#'.$search_box_style['text_color_over']).';';
            if ( $search_box_style['search_position'] == 'before' || $search_box_style['search_position'] == 'before_after' ) {
                echo '<div style="'.$sb_style.'"><a data-url="'.$search_box_url.'" class="'.$search_box_button_class.' berocket_search_box_button">'.$search_box_style['search_text'].'</a></div>';
            }
            for($i = 1; $i <= $search_box_count; $i++) {
                echo '<div style="'.$sb_style.'">';
                $current_box = $search_box_attributes[$i];
                $widget_search = new BeRocket_AAPF_Widget();
                $search_instance = self::$defaults;
                $search_instance['filter_type'] = @ $current_box['type'];
                $search_instance['attribute'] = @ $current_box['attribute'];
                $search_instance['custom_taxonomy'] = @ $current_box['custom_taxonomy'];
                $search_instance['type'] = @ $current_box['visual_type'];
                $search_instance['height'] = @ $current_box['height'];
                $search_instance['scroll_theme'] = @ $current_box['scroll_theme'];
                $search_instance['selected_area_show'] = @ $current_box['selected_area_show'];
                $search_instance['hide_selected_arrow'] = @ $current_box['hide_selected_arrow'];
                $search_instance['selected_is_hide'] = @ $current_box['selected_is_hide'];
                $search_instance['is_hide_mobile'] = @ $current_box['is_hide_mobile'];
                $search_instance['cat_propagation'] = @ $current_box['cat_propagation'];
                $search_instance['cat_propagation'] = @ $current_box['cat_propagation'];
                $search_instance['product_cat'] = @ $current_box['product_cat'];
                $search_instance['show_page'] = @ $current_box['show_page'];
                $search_instance['cat_value_limit'] = @ $current_box['cat_value_limit'];
                
                $widget_search->widget(array('before_widget' => '<h4>'.$current_box['title'].'</h4>', 'after_widget' =>''), $search_instance);
                echo '</div>';
            }
            if ( $search_box_style['search_position'] == 'after' || $search_box_style['search_position'] == 'before_after' ) {
                echo '<div style="'.$sb_style.'">
                <a data-url="'.$search_box_url.'" 
                class="'.$search_box_button_class.' berocket_search_box_button">
                '.$search_box_style['search_text'].'</a></div>';
            }
            echo '</div></div>';
            echo '<style>.'.$search_box_button_class.'{'.$sbb_style.'}.'.$search_box_button_class.':hover{'.$sbb_style_hover.'}</style>';
            echo $after_widget;
            return '';
        } else {
            unset($search_box_attributes, $search_box_style);
        }

        $woocommerce_hide_out_of_stock_items = BeRocket_AAPF_Widget::woocommerce_hide_out_of_stock_items();
        if( $woocommerce_hide_out_of_stock_items == 'yes' && $filter_type == 'attribute' && $attribute == '_stock_status' ) {
            $widget_error_log['return'] = 'stock_status';
            BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
            if ( isset ( $br_wc_query ) ) {
                $wp_query = $old_query;
            }
            return true;
        }

        $terms = $sort_terms = $price_range = array();
        //debug( array( "filter_type" => $filter_type, "attribute" => $attribute ) );
        if ( $filter_type == 'attribute' ) {
            if ( $type == 'ranges' ) {
                if ( count( $ranges ) < 2 ) {
                    $widget_error_log['ranges'] = $ranges;
                    $widget_error_log['return'] = 'ranges < 2';
                    BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                    if ( isset ( $br_wc_query ) ) {
                        $wp_query = $old_query;
                    }
                    return false;
                }
                $terms = array();
                $ranges[0]--;
                if( @ $hide_first_last_ranges ) {
                    $price_range = br_get_cache( 'price_range', $wp_check_product_cat, $br_options['object_cache'] );
                    if ( $price_range === false ) {
                        $price_range = BeRocket_AAPF_Widget::get_price_range( $wp_query_product_cat, $woocommerce_hide_out_of_stock_items );
                        br_set_cache( 'price_range', $price_range, $wp_check_product_cat, BeRocket_AJAX_cache_expire, $br_options['object_cache'] );
                    }
                }
                for ( $i = 1; $i < count( $ranges ); $i++ ) {
                    $add_term_ranges = true;
                    if( @ $hide_first_last_ranges ) {
                        if ( ! empty( $price_range ) and count( $price_range ) >= 2 ) {
                            if( $price_range[0] >= $ranges[$i] ) {
                                $add_term_ranges = false;
                            }
                            if( $price_range[1] <= $ranges[$i - 1] ) {
                                $add_term_ranges = false;
                            }
                        }
                    }
                    if( $add_term_ranges ) {
                        $t_id = ($ranges[$i - 1] + 1).'*'.$ranges[$i];
                        $t_name = ( ( @ $icon_before_value ) ? ( ( substr( $icon_before_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_before_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_before_value.'" alt=""></i>' ) : '' ).$text_before_price.(apply_filters( 'woocommerce_price_filter_widget_min_amount', $ranges[$i - 1]) + 1).$text_after_price.( ( @ $icon_after_value ) ? ( ( substr( $icon_after_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_after_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_after_value.'" alt=""></i>' ) : '' ).
                        ' - '.
                        ( ( @ $icon_before_value ) ? ( ( substr( $icon_before_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_before_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_before_value.'" alt=""></i>' ) : '' ).$text_before_price.apply_filters( 'woocommerce_price_filter_widget_max_amount', $ranges[$i]).$text_after_price.( ( @ $icon_after_value ) ? ( ( substr( $icon_after_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_after_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_after_value.'" alt=""></i>' ) : '' );
                        $term = array( 'term_id' => $t_id, 'slug' => $t_id, 'name' => $t_name, 'count' => 1, 'taxonomy' => $attribute );
                        $term = (object)$term;
                        if( @ $br_options['recount_products'] && @ $show_product_count_per_attr ) {
                            self::price_range_count($term, $ranges[$i - 1], $ranges[$i]);
                        }
                        $terms[] = $term;
                    }
                }
                set_query_var( 'terms', apply_filters( 'berocket_aapf_widget_terms', $terms ) );
                if( BeRocket_AAPF::$debug_mode ) {
                    $widget_error_log['terms'] = $terms;
                }
            } elseif ( $attribute == 'price' ) {
                if ( @ $price_values ) {
                    $price_range = @ explode( ",", $price_values );
                } else {
                    $price_range = br_get_cache( 'price_range', $wp_check_product_cat, $br_options['object_cache'] );
                    if ( $price_range === false ) {
                        $price_range = BeRocket_AAPF_Widget::get_price_range( $wp_query_product_cat, $woocommerce_hide_out_of_stock_items );
                        br_set_cache( 'price_range', $price_range, $wp_check_product_cat, BeRocket_AJAX_cache_expire, $br_options['object_cache'] );
                    }
                    if ( ! $price_range or count( $price_range ) < 2 ) {
                        $widget_error_log['price_range'] = $price_range;
                        $widget_error_log['return'] = 'price_range < 2';
                        BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                        if ( isset ( $br_wc_query ) ) {
                            $wp_query = $old_query;
                        }
                        return false;
                    }
                }
                if( BeRocket_AAPF::$debug_mode ) {
                    $widget_error_log['price_range'] = $price_range;
                }
            } elseif ( $attribute == '_stock_status' ) {
                array_push($terms, (object)array('term_id' => '1', 'name' => __('In stock', 'BeRocket_AJAX_domain'), 'slug' => 'instock', 'taxonomy' => '_stock_status', 'count' => 1));
                array_push($terms, (object)array('term_id' => '2', 'name' => __('Out of stock', 'BeRocket_AJAX_domain'), 'slug' => 'outofstock', 'taxonomy' => '_stock_status', 'count' => 1));
                $terms = BeRocket_AAPF_Widget::get_attribute_values( $attribute, 'id', ( ! @ $br_options['show_all_values'] ), @ $br_options['recount_products'], $terms, @ $cat_value_limit );
                set_query_var( 'terms', apply_filters( 'berocket_aapf_widget_terms', $terms ) );
                if( BeRocket_AAPF::$debug_mode ) {
                    $widget_error_log['terms'] = $terms;
                }
            } elseif ( $attribute == '_sale' ) {
                $terms = array();
                array_push($terms, (object)array('term_id' => '1', 'name' => __('On sale', 'BeRocket_AJAX_domain'), 'slug' => 'sale', 'taxonomy' => '_sale', 'count' => 1));
                array_push($terms, (object)array('term_id' => '2', 'name' => __('Not on sale', 'BeRocket_AJAX_domain'), 'slug' => 'notsale', 'taxonomy' => '_sale', 'count' => 1));
                $terms = BeRocket_AAPF_Widget::get_attribute_values( $attribute, 'id', ( ! @ $br_options['show_all_values'] ), @ $br_options['recount_products'], $terms, @ $cat_value_limit );
                set_query_var( 'terms', apply_filters( 'berocket_aapf_widget_terms', $terms ) );
                if( BeRocket_AAPF::$debug_mode ) {
                    $widget_error_log['terms'] = $terms;
                }
                $type = 'checkbox';
            } elseif ( $attribute == 'product_cat' ) {
                if( $parent_product_cat_current ) {
                    $cate = get_queried_object();
                    if( isset($cate->term_id) ) {
                        $cateID = $cate->term_id;
                        $title = str_replace( '%product_cat%', $cate->name, $title );
                    } else {
                        $cateID = 0;
                        $title = str_replace( '%product_cat%', '', $title );
                    }
                    $depth_count = 0;
                    $parent_product_cat_cache = $cateID;
                    $parent_product_cat = $cateID;
                } else {
                    $parent_product_cat_cache = $parent_product_cat;
                }
                $terms = br_get_cache ( $attribute . $order_values_by, $wp_check_product_cat . $parent_product_cat_cache . $depth_count, $br_options['object_cache'] );
                if ( br_is_filtered() || $terms === false ) {
                    $terms_unsort = self::get_product_categories( '', $parent_product_cat, array(), 0, $depth_count, true );

                    self::sort_terms( $terms_unsort, array(
                        "order_values_by" => $order_values_by,
                        "attribute"       => $attribute,
                    ) );

                    $terms_unsort = self::set_terms_on_same_level( $terms_unsort, array(), ($type != 'checkbox' && $type != 'radio') );
                    $terms = BeRocket_AAPF_Widget::get_attribute_values( $attribute, 'id', ( ! @ $br_options['show_all_values'] ), @ $br_options['recount_products'], $terms_unsort, @ $cat_value_limit );
                    if ( ! br_is_filtered() ) {
                        br_set_cache( $attribute.$order_values_by, $terms, $wp_check_product_cat.$parent_product_cat_cache.$depth_count, BeRocket_AJAX_cache_expire, $br_options['object_cache'] );
                    }
                }

                if( BeRocket_AAPF::$debug_mode ) {
                    $widget_error_log['terms'] = $terms;
                }
                $terms = self::include_exclude_items($terms, $include_exclude_select, $include_exclude_list);
                if ( @ ! is_array($terms) || @ count( $terms ) < 1 ) {
                    $widget_error_log['terms'] = @ $terms;
                    $widget_error_log['return'] = 'terms < 1';
                    BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                    if ( isset ( $br_wc_query ) ) {
                        $wp_query = $old_query;
                    }
                    return false;
                }
                set_query_var( 'terms', apply_filters( 'berocket_aapf_widget_terms', $terms ) );
                unset( $terms, $terms_unsort );
            } else {
                $sort_array  = array();
                $wc_order_by = wc_attribute_orderby( $attribute );

                $terms = br_get_cache ( $attribute, $wp_check_product_cat, $br_options['object_cache'] );
                if( br_is_filtered() || $terms === false || @ $child_parent == 'parent' || @ $child_parent == 'child' ) {
                    $current_terms = self::get_terms_child_parent ( @ $child_parent, $attribute, FALSE, @ $child_parent_depth );
                    $terms = BeRocket_AAPF_Widget::get_attribute_values( $attribute, 'id', ( ! @ $br_options['show_all_values'] ), @ $br_options['recount_products'], $current_terms, @ $cat_value_limit );
                    if( ! br_is_filtered() && @ $child_parent != 'parent' && @ $child_parent != 'child' ) {
                        br_set_cache ( $attribute, $terms, $wp_check_product_cat, BeRocket_AJAX_cache_expire, $br_options['object_cache'] );
                    }
                }

                $terms = self::include_exclude_items($terms, $include_exclude_select, $include_exclude_list);

                if ( @ count( $terms ) < 1 ) {
                    $widget_error_log['terms'] = @ $terms;
                    $widget_error_log['return'] = 'terms < 1';
                    BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                    if ( isset ( $br_wc_query ) ) {
                        $wp_query = $old_query;
                    }
                    return false;
                }

                if ( $wc_order_by == 'menu_order' and $order_values_by == 'Default' ) {
                    foreach ( $terms as $term ) {
                        $sort_array[] = get_woocommerce_term_meta( @ $term->term_id, 'order_' . $attribute );
                    }
                    array_multisort( $sort_array, $terms );
                } else {
                    self::sort_terms( $terms, array(
                        "wc_order_by"     => $wc_order_by,
                        "order_values_by" => $order_values_by,
                        "filter_type"     => $filter_type,
                    ) );
                }

                if( BeRocket_AAPF::$debug_mode ) {
                    $widget_error_log['terms'] = $terms;
                }
                set_query_var( 'terms', apply_filters( 'berocket_aapf_widget_terms', $terms ) );
            }

        } elseif ( $filter_type == 'tag' ) {
            $attribute = 'product_tag';
            $terms = br_get_cache ( $attribute.$order_values_by, $wp_check_product_cat, $br_options['object_cache'] );
            if( br_is_filtered() || $terms === false ) {
                $terms = BeRocket_AAPF_Widget::get_attribute_values( $attribute, 'id', ( ! @ $br_options['show_all_values'] ), @ $br_options['recount_products'], FALSE, @ $cat_value_limit );

                if ( $order_values_by != 'Default' ) {
                    self::sort_terms( $terms, array(
                        "order_values_by" => $order_values_by,
                        "attribute"       => $attribute,
                    ) );
                }
                if( ! br_is_filtered() ) {
                    br_set_cache ( $attribute.$order_values_by, $terms, $wp_check_product_cat, BeRocket_AJAX_cache_expire, $br_options['object_cache'] );
                }
            }

            if( BeRocket_AAPF::$debug_mode ) {
                $widget_error_log['terms'] = $terms;
            }

            $terms = self::include_exclude_items($terms, $include_exclude_select, $include_exclude_list);

            set_query_var( 'terms', apply_filters( 'berocket_aapf_widget_terms', $terms ) );

            if ( @ count( $terms ) < 1 ) {
                $widget_error_log['terms'] = @ $terms;
                $widget_error_log['return'] = 'terms < 1';
                BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                if ( isset ( $br_wc_query ) ) {
                    $wp_query = $old_query;
                }
                return false;
            }
        } elseif ( $filter_type == 'custom_taxonomy' ) {
            $terms = br_get_cache ( $custom_taxonomy.$order_values_by, $filter_type.$wp_check_product_cat, $br_options['object_cache'] );
            if( br_is_filtered() || $terms === false || @ $child_parent == 'parent' || @ $child_parent == 'child' ) {
                if ( $custom_taxonomy == 'product_cat' ) {
                    $terms_unsort = self::get_product_categories( '', 0, array(), 0, 50, true );
                    $terms_unsort = self::get_terms_child_parent ( @ $child_parent, $custom_taxonomy, $terms_unsort, @ $child_parent_depth );

                    if ( $order_values_by != 'Default' ) {
                        self::sort_terms( $terms_unsort, array(
                            "order_values_by" => $order_values_by,
                            "attribute"       => $attribute,
                        ) );
                    }

                    if ( @ $child_parent != 'parent' && @ $child_parent != 'child' ) {
                        $terms_unsort = self::set_terms_on_same_level( $terms_unsort, array(), ($type != 'checkbox' && $type != 'radio') );
                    }
                    $terms = BeRocket_AAPF_Widget::get_attribute_values( $custom_taxonomy, 'id', ( ! @ $br_options['show_all_values'] ), @ $br_options['recount_products'], $terms_unsort, @ $cat_value_limit );
                } else {
                    $terms = self::get_terms_child_parent ( @ $child_parent, $custom_taxonomy, FALSE, @ $child_parent_depth );
                    $terms = BeRocket_AAPF_Widget::get_attribute_values( $custom_taxonomy, 'id', ( ! @ $br_options['show_all_values'] ), @ $br_options['recount_products'], $terms, @ $cat_value_limit );

                    if ( $order_values_by != 'Default' ) {
                        self::sort_terms( $terms, array(
                            "order_values_by" => $order_values_by,
                        ) );
                        if ( ! br_is_filtered() && @ $child_parent != 'parent' && @ $child_parent != 'child' ) {
                            br_get_cache( $custom_taxonomy . $order_values_by, $terms, $filter_type . $wp_check_product_cat, BeRocket_AJAX_cache_expire, $br_options['object_cache'] );
                        }
                    }
                }
            }

            if( BeRocket_AAPF::$debug_mode ) {
                $widget_error_log['terms'] = $terms;
            }

            $terms = self::include_exclude_items($terms, $include_exclude_select, $include_exclude_list);

            set_query_var( 'terms', apply_filters( 'berocket_aapf_widget_terms', $terms ) );

            if ( @ count( $terms ) < 1 ) {
                $widget_error_log['terms'] = @ $terms;
                $widget_error_log['return'] = 'terms < 1';
                BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                if ( isset ( $br_wc_query ) ) {
                    $wp_query = $old_query;
                }
                return false;
            }
        } elseif( $filter_type = 'date' ) {
            $type = 'date';
        }

        $style = $class = '';
        if( @$height and $height != 'auto' ){
            $style = "style='max-height: {$height}px; overflow: hidden;'";
            $class = "berocket_aapf_widget_height_control";
        }

        if( !$scroll_theme ) $scroll_theme = 'dark';
        if( $filter_type == 'custom_taxonomy' )
            $attribute = $custom_taxonomy;

        set_query_var( 'operator', $operator );
        set_query_var( 'attribute', $attribute );
        set_query_var( 'type', $type );
        set_query_var( 'title', apply_filters( 'berocket_aapf_widget_title', $title ) );
        set_query_var( 'class', apply_filters( 'berocket_aapf_widget_class', $class ) );
        set_query_var( 'css_class', apply_filters( 'berocket_aapf_widget_css_class', @ $css_class ) );
        set_query_var( 'style', apply_filters( 'berocket_aapf_widget_style', $style ) );
        set_query_var( 'scroll_theme', $scroll_theme );
        set_query_var( 'x', time() );
        set_query_var( 'filter_type', $filter_type );
        set_query_var( 'uo', br_aapf_converter_styles( @ $br_options['styles'] ) );
        set_query_var( 'notuo', @ $br_options['styles'] );
        set_query_var( 'widget_is_hide', @ $widget_is_hide );
        set_query_var( 'is_hide_mobile', @ $is_hide_mobile );
        set_query_var( 'show_product_count_per_attr', @ $show_product_count_per_attr );
        set_query_var( 'hide_child_attributes', @ $hide_child_attributes );
        set_query_var( 'cat_value_limit', @ $cat_value_limit );
        set_query_var( 'icon_before_title', @ $icon_before_title );
        set_query_var( 'icon_after_title', @ $icon_after_title );
        set_query_var( 'hide_o_value', @ $br_options['hide_value']['o'] );
        set_query_var( 'hide_sel_value', @ $br_options['hide_value']['sel'] );
        set_query_var( 'description', @ $description );
        set_query_var( 'hide_collapse_arrow', @ $hide_collapse_arrow );
        set_query_var( 'values_per_row', @ $values_per_row );
        set_query_var( 'child_parent', @ $child_parent );
        set_query_var( 'child_parent_depth', @ $child_parent_depth );
        set_query_var( 'product_count_style', @ $br_options['styles_input']['product_count'].'pcs '.@ $br_options['styles_input']['product_count_position'].'pcs' );
        set_query_var( 'child_parent_previous', @ $child_parent_previous );
        set_query_var( 'child_parent_no_values', @ $child_parent_no_values );
        set_query_var( 'child_parent_no_products', @ $child_parent_no_products );
        set_query_var( 'before_title', @ $before_title );
        set_query_var( 'after_title', @ $after_title );

        // widget title and start tag ( <ul> ) can be found in templates/widget_start.php
        echo $before_widget;
        do_action('berocket_aapf_widget_before_start');
        br_get_template_part('widget_start');
        do_action('berocket_aapf_widget_after_start');

        $slider_with_string = false;
        $stringed_is_numeric = true;
        $slider_step = 1;

        if ( $type == 'slider' ) {
            $min = $max   = false;
            $main_class   = 'slider';
            $slider_class = 'berocket_filter_slider';

            if( $attribute == 'price' ){
                wp_localize_script(
                    'berocket_aapf_widget-script',
                    'br_price_text',
                    array(
                        'before'  => @ $text_before_price,
                        'after'   => @ $text_after_price,
                    )
                );
                if ( @ $price_values ) {
                    $all_terms_name = $price_range;
                    $all_terms_slug = $price_range;
                    $stringed_is_numeric = true;
                    $min = 0;
                    $max = count( $all_terms_name ) - 1;
                    $slider_with_string = true;
                } else {
                    if( $price_range ) {
                        foreach ( $price_range as $price ) {
                            if ( $min === false or $min > (int) $price ) {
                                $min = $price;
                            }
                            if ( $max === false or $max < (int) $price ) {
                                $max = $price;
                            }
                        }
                    }
                    if( $use_min_price ) {
                        $min = $min_price;
                    }
                    if ( $use_max_price ) {
                        $max = $max_price;
                    }
                }
                $id = 'br_price';
                $slider_class .= ' berocket_filter_price_slider';
                $main_class .= ' price';

                $min = floor( $min );
                $max = ceil( $max );
            } else {
                if( $slider_default ) {
                    $slider_with_string = true;
                }
                if ( @ count( $terms ) < 1 ) {
                    $widget_error_log['terms'] = @ $terms;
                    $widget_error_log['return'] = 'terms < 1';
                    BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
                    if ( isset ( $br_wc_query ) ) {
                        $wp_query = $old_query;
                    }
                    return false;
                }
                if( @ $terms ) {
                    $all_terms_name = array();
                    $all_terms_slug = array();
                    foreach ( $terms as $term ) {
                        if ( ! is_numeric( $term->name ) ) {
                            $slider_with_string = true;
                            if ( ! is_numeric( substr( $term->name, 0, 1 ) ) ) {
                                $stringed_is_numeric = false;
                            }
                        }
                        if ( $min === false or strcmp( $min, $term->name ) > 0 ) {
                            $min = $term->name;
                        }
                        if ( $max === false or strcmp( $max, $term->name ) < 0 ) {
                            $max = $term->name;
                        }
                        array_push( $all_terms_name, $term->slug );
                        array_push( $all_terms_slug, $term->name );
                    }

                    if ( ! $slider_with_string ) {
                        $min = false;
                        $max = false;
                        foreach ( $terms as $term ) {
                            if ( (float) $term->name != (int) (float) $term->name ) {
                                if ( round( (float) $term->name, 1 ) == (float) $term->name && $slider_step != 100 ) {
                                    $slider_step = 10;
                                } else {
                                    $slider_step = 100;
                                }
                            }
                            if ( $min === false or $min > (float) $term->name ) {
                                $min = round( (float) $term->name, 2 );
                                if ( $min > (float) $term->name ) {
                                    $min -= 0.01;
                                }
                            }
                            if ( $max === false or $max < (float) $term->name ) {
                                $max = round( (float) $term->name, 2 );
                                if ( $max < (float) $term->name ) {
                                    $max += 0.01;
                                }
                            }
                        }
                    }
                }

                $id = $term->taxonomy;
                if ( ! $slider_with_string ) {
                    $min *= $slider_step;
                    $max *= $slider_step;
                    $all_terms_name = null;
                } else {
                    if ( count( $all_terms_name ) == 1 ) {
                        array_push( $all_terms_name, $all_terms_name[0] );
                        array_push( $all_terms_slug, $all_terms_slug[0] );
                    }
                    $min = 0;
                    $max = count( $all_terms_name ) - 1;
                    if( $stringed_is_numeric ) {
                        array_multisort( $all_terms_slug, $all_terms_name, $all_terms_slug, SORT_NUMERIC );
                    } else {
                        array_multisort( $all_terms_name, $all_terms_name, $all_terms_slug );
                    }
                }
            }

            $slider_value1 = $min;
            $slider_value2 = $max;

            if ( $attribute == 'price' and @ $_POST['price'] ) {
                if ( @ $price_values ) {
                    $slider_value1 = array_search( $_POST['price'][0], $all_terms_name );
                    $slider_value2 = array_search( $_POST['price'][1], $all_terms_name );
                } else {
                    $slider_value1 = $_POST['price'][0];
                    $slider_value2 = $_POST['price'][1];
                }
            }
            if ( $attribute != 'price' and @ $_POST['limits'] ) {
                foreach ( $_POST['limits'] as $p_limit ) {
                    if ( $p_limit[0] == $attribute ) {
                        $slider_value1 = $p_limit[1];
                        $slider_value2 = $p_limit[2];
                        if ( ! $slider_with_string ) {
                            $slider_value1 *= $slider_step;
                            $slider_value2 *= $slider_step;
                        } else {
                            $p_limit[1] = urldecode( $p_limit[1] );
                            $p_limit[2] = urldecode( $p_limit[2] );
                            $slider_value1 = array_search( $p_limit[1], $all_terms_name );
                            $slider_value2 = array_search( $p_limit[2], $all_terms_name );
                        }
                    }
                }
                if( BeRocket_AAPF::$debug_mode ) {
                    $widget_error_log['value_1'] = $slider_value1;
                    $widget_error_log['value_2'] = $slider_value2;
                    $widget_error_log['step'] = $slider_step;
                }
            }

            set_query_var( 'slider_value1', $slider_value1 );
            set_query_var( 'slider_value2', $slider_value2 );
            set_query_var( 'filter_slider_id', $id );
            set_query_var( 'main_class', $main_class );
            set_query_var( 'slider_class', $slider_class );
            set_query_var( 'min', $min );
            set_query_var( 'max', $max );
            set_query_var( 'step', $slider_step );
            set_query_var( 'slider_with_string', $slider_with_string );
            set_query_var( 'all_terms_name', @ $all_terms_name );
            set_query_var( 'all_terms_slug', @ $all_terms_slug );
            set_query_var( 'text_before_price', @ $text_before_price );
            set_query_var( 'text_after_price', @ $text_after_price );
        }
        set_query_var( 'first_page_jump', @ $first_page_jump );
        set_query_var( 'icon_before_value', @ $icon_before_value );
        set_query_var( 'icon_after_value', @ $icon_after_value );

        if ( $type == 'tag_cloud' ) {
            $tag_script_var = array(
                'height'        => $tag_cloud_height,
                'min_font_size' => $tag_cloud_min_font,
                'max_font_size' => $tag_cloud_max_font,
                'tags_count'    => $tag_cloud_tags_count
            );
            set_query_var( 'tag_script_var', $tag_script_var );
        } elseif ( $type == 'color' || $type == 'image' ) {
            set_query_var( 'use_value_with_color', @ $use_value_with_color );
        }

        br_get_template_part( $type );

        do_action('berocket_aapf_widget_before_end');
        br_get_template_part('widget_end');
        do_action('berocket_aapf_widget_after_end');
        echo $after_widget;
        if( BeRocket_AAPF::$debug_mode ) {
            $widget_error_log['terms'] = @ $terms;
        }
        $widget_error_log['return'] = 'OK';
        BeRocket_AAPF::$error_log['6_widgets'][] = $widget_error_log;
        if ( isset ( $br_wc_query ) ) {
            $wp_query = $old_query;
        }
    }

    public static function include_exclude_items($terms, $include_exclude_select, $include_exclude_list) {
        if ( @ is_array($terms) && @ count( $terms ) > 0 ) {
            if( $include_exclude_select == 'include' ) {
                $new_terms = array();
                foreach($terms as $term) {
                    if( in_array($term->term_id, $include_exclude_list) ) {
                        $new_terms[] = $term;
                    }
                }
                $terms = $new_terms;
            } elseif( $include_exclude_select == 'exclude' ) {
                $new_terms = array();
                foreach($terms as $term) {
                    if( ! in_array($term->term_id, $include_exclude_list) ) {
                        $new_terms[] = $term;
                    }
                }
                $terms = $new_terms;
            }
        }
        return $terms;
    }

    public static function woocommerce_hide_out_of_stock_items(){
        $hide = get_option( 'woocommerce_hide_out_of_stock_items', null );

        if ( is_array( $hide ) ) {
            $hide = array_map( 'stripslashes', $hide );
        } elseif ( ! is_null( $hide ) ) {
            $hide = stripslashes( $hide );
        }

        return apply_filters( 'berocket_aapf_hide_out_of_stock_items', $hide );
    }

    public static function price_range_count($term, $from, $to) {
        if( class_exists('WP_Meta_Query') && class_exists('WP_Tax_Query') ) {
            
                global $wpdb, $wp_query;
                $old_join_posts = '';
                if( ! method_exists('WC_Query', 'get_main_meta_query') || ! method_exists('WC_Query', 'get_main_tax_query') ) {
                    $old_query_vars = self::old_wc_compatible($wp_query);
                    $old_meta_query = (empty($old_query_vars['meta_query']) ? array() : $old_query_vars['meta_query']);
                    $old_tax_query = (empty($old_query_vars['tax_query']) ? array() : $old_query_vars['tax_query']);
                } else {
                    $old_query_vars = self::old_wc_compatible($wp_query, true);
                }
                if( ! empty( $old_query_vars['posts__in'] ) ) {
                    $old_join_posts = " AND {$wpdb->posts}.ID IN (".implode(',', $old_query_vars['posts__in']).") ";
                }
                if( method_exists('WC_Query', 'get_main_tax_query') ) {
                    $tax_query  = WC_Query::get_main_tax_query();
                } else {
                    $tax_query = $old_tax_query;
                }
                if( method_exists('WC_Query', 'get_main_meta_query') ) {
                    $meta_query  = WC_Query::get_main_meta_query();
                } else {
                    $meta_query = $old_meta_query;
                }
                foreach( $meta_query as $key => $val ) {
                    if ( ! empty( $val['price_filter'] ) || ! empty( $val['rating_filter'] ) ) {
                        unset( $meta_query[ $key ] );
                    }
                    if( isset( $val['relation']) ) {
                        unset($val['relation']);
                        foreach( $val as $key2 => $val2 ) {
                            if ( isset( $val2['key'] ) && $val2['key'] == '_price' ) {
                                if ( isset( $meta_query[ $key ][ $key2 ] ) ) unset( $meta_query[ $key ][ $key2 ] );
                            }
                        }
                        if( count($meta_query[ $key ]) <= 1 ) {
                            unset( $meta_query[ $key ] );
                        }
                    } else {
                        if ( isset( $val['key'] ) && $val['key'] == '_price' ) {
                            if ( isset( $meta_query[ $key ] ) ) unset( $meta_query[ $key ] );
                        }
                    }
                }
                $queried_object = $wp_query->get_queried_object_id();
                if( ! empty($queried_object) ) {
                    $query_object = $wp_query->get_queried_object();
                    if( ! empty($query_object->taxonomy) && ! empty($query_object->slug) ) {
                        $tax_query[ $query_object->taxonomy ] = array(
                            'taxonomy' => $query_object->taxonomy,
                            'terms'    => array( $query_object->slug ),
                            'field'    => 'slug',
                        );
                    }
                }
                $meta_query      = new WP_Meta_Query( $meta_query );
                $tax_query       = new WP_Tax_Query( $tax_query );
                $meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
                $tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );

                // Generate query
                $query           = array();
                $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as range_count";
                $query['from']   = "FROM {$wpdb->posts}";
                $query['join']   = "
                    INNER JOIN {$wpdb->postmeta} AS price_term ON {$wpdb->posts}.ID = price_term.post_id
                    " . $tax_query_sql['join'] . $meta_query_sql['join'];
                $query['where']   = "
                    WHERE {$wpdb->posts}.post_type IN ( 'product' )
                    AND {$wpdb->posts}.post_status = 'publish'
                    " . $tax_query_sql['where'] . $meta_query_sql['where'] . "
                    AND price_term.meta_key = '_price' AND price_term.meta_value >= {$from} AND price_term.meta_value <= {$to}
                ";
                if( defined('ICL_LANGUAGE_CODE') ) {
                    $query['join'] = $query['join']." INNER JOIN {$wpdb->prefix}icl_translations as wpml_lang ON ( {$wpdb->posts}.ID = wpml_lang.element_id )";
                    $query['where'] = $query['where']." AND wpml_lang.language_code = '".ICL_LANGUAGE_CODE."' AND wpml_lang.element_type = 'post_product'";
                }
                if( ! empty($_GET['s']) ) {
                    $query['where'] .= " AND ((({$wpdb->posts}.post_title LIKE '%{$_GET['s']}%') OR ({$wpdb->posts}.post_excerpt LIKE '%{$_GET['s']}%') OR ({$wpdb->posts}.post_content LIKE '%{$_GET['s']}%')))";
                }
                $query['where'] .= $old_join_posts;
                $query             = apply_filters( 'woocommerce_get_filtered_ranges_product_counts_query', $query );
                $query             = implode( ' ', $query );

                $results           = $wpdb->get_results( $query );
                if( isset( $results[0]->range_count ) ) {
                    $term->count = $results[0]->range_count;
                }
        }
        return $term;
    }

    public static function get_price_range( $wp_query_product_cat ){
        global $wpdb, $wp_query;
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );
        if( @ $br_options['show_all_values'] ) {
            $query_string = array(
                'select' => "SELECT MIN(cast(FLOOR({$wpdb->postmeta}.meta_value) as decimal)) as min_price, MAX(cast(CEIL({$wpdb->postmeta}.meta_value) as decimal)) as max_price
                    FROM {$wpdb->postmeta}",
                'join'   => " INNER JOIN {$wpdb->posts} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)
                    INNER JOIN {$wpdb->postmeta} AS pm1 ON ({$wpdb->posts}.ID = pm1.post_id)",
                'where'  => " WHERE {$wpdb->posts}.post_type = 'product'
                    AND {$wpdb->posts}.post_status = 'publish'
                    AND {$wpdb->postmeta}.meta_key = '_price' AND {$wpdb->postmeta}.meta_value >= 0
                    AND ( pm1.meta_key = '_visibility' AND CAST(pm1.meta_value AS CHAR) IN ('visible','catalog') )");
        } else { 
            if( class_exists('WP_Meta_Query') && class_exists('WP_Tax_Query') ) {
                $query_string = array(
                    'select' => "SELECT MIN(cast(FLOOR(br_prices.meta_value) as decimal)) as min_price, MAX(cast(CEIL(br_prices.meta_value) as decimal)) as max_price
                        FROM {$wpdb->posts}",
                    'join'   => " INNER JOIN {$wpdb->postmeta} as br_prices ON ({$wpdb->posts}.ID = br_prices.post_id)",
                    'where'  => " WHERE {$wpdb->posts}.post_type = 'product'
                        AND {$wpdb->posts}.post_status = 'publish'
                        AND  br_prices.meta_key = '_price' AND br_prices.meta_value >= 0");
                $tax_query  = array();
                $args       = $wp_query->query_vars;
                if( method_exists('WC_Query', 'get_main_meta_query') ) {
                    $meta_query  = WC_Query::get_main_meta_query();
                } else {
                    $meta_query = (empty($wp_query->query_vars['meta_query']) ? array() : $wp_query->query_vars['meta_query']);
                }
                foreach( $meta_query as $key => $val ) {
                    if ( ! empty( $val['price_filter'] ) || ! empty( $val['rating_filter'] ) ) {
                        unset( $meta_query[ $key ] );
                    }
                    if( isset( $val['relation']) ) {
                        unset($val['relation']);
                        foreach( $val as $key2 => $val2 ) {
                            if ( isset( $val2['key'] ) && $val2['key'] == '_price' ) {
                                if ( isset( $meta_query[ $key ][ $key2 ] ) ) unset( $meta_query[ $key ][ $key2 ] );
                            }
                        }
                        if( count($meta_query[ $key ]) <= 1 ) {
                            unset( $meta_query[ $key ] );
                        }
                    } else {
                        if ( isset( $val['key'] ) && $val['key'] == '_price' ) {
                            if ( isset( $meta_query[ $key ] ) ) unset( $meta_query[ $key ] );
                        }
                    }
                }
                if ( ! empty( $args['product_cat'] ) ) {
                    $tax_query[ 'product_cat' ] = array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array( $args['product_cat'] ),
                        'field'    => 'slug',
                    );
                }
                $queried_object = $wp_query->get_queried_object_id();
                if( ! empty($queried_object) ) {
                    $query_object = $wp_query->get_queried_object();
                    if( ! empty($query_object->taxonomy) && ! empty($query_object->slug) ) {
                        $tax_query[ $query_object->taxonomy ] = array(
                            'taxonomy' => $query_object->taxonomy,
                            'terms'    => array( $query_object->slug ),
                            'field'    => 'slug',
                        );
                    }
                }
                unset($queried_object, $query_object);
                $meta_query = new WP_Meta_Query( $meta_query );
                $meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
                unset($meta_query);
                $tax_query  = new WP_Tax_Query( $tax_query );
                $tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );
                unset($tax_query);
                $query_string['join'] = $query_string['join'].' '. $tax_query_sql['join'] . $meta_query_sql['join'];
                $query_string['where'] = $query_string['where'].' '. $tax_query_sql['where'] . $meta_query_sql['where'];
                unset($tax_query_sql, $meta_query_sql);
            } else {
                $_POST['product_cat'] = $wp_query_product_cat;
                $extra_inner = $extra_where = '';

                if ( @ $_POST['product_cat'] and $_POST['product_cat'] != '-1' ) {
                    $sub_categories = br_get_sub_categories( strip_tags( $_POST['product_cat'] ), 'slug', array( 'include_parent' => true ), 'term_taxonomy_id' );

                    $extra_inner = " INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id) ";
                    $extra_where = " AND ( {$wpdb->term_relationships}.term_taxonomy_id IN (" . $sub_categories . ") ) ";

                    unset( $sub_categories );
                } elseif ( isset($wp_query->query_vars['product_tag']) ) {
                    $product_tag = get_term_by( 'slug', $wp_query->query_vars['product_tag'], 'product_tag' );
                    $extra_inner = " INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id) ";
                    $extra_where = " AND ( {$wpdb->term_relationships}.term_taxonomy_id IN (" . $product_tag->term_id . ") ) ";
                }
                $hide_out_of_stock = BeRocket_AAPF_Widget::woocommerce_hide_out_of_stock_items();
                $out_of_stock1 = '';
                $out_of_stock2 = '';
                if ( $hide_out_of_stock == 'yes' ) {
                    $out_of_stock1 = "INNER JOIN {$wpdb->postmeta} AS pm2 ON ({$wpdb->posts}.ID = pm2.post_id)";
                    $out_of_stock2 = "AND ( pm2.meta_key = '_stock_status' AND CAST(pm2.meta_value AS CHAR) = 'instock' )";
                }

                $query_string = array(
                    'select' => "
                        SELECT MIN(cast(FLOOR({$wpdb->postmeta}.meta_value) as decimal)) as min_price, MAX(cast(CEIL({$wpdb->postmeta}.meta_value) as decimal)) as max_price
                        FROM {$wpdb->posts}",
                    'join'   => "INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)
                        INNER JOIN {$wpdb->postmeta} AS pm1 ON ({$wpdb->posts}.ID = pm1.post_id)
                        {$out_of_stock1}
                        {$extra_inner}",
                    'where'  => "WHERE {$wpdb->posts}.post_type = 'product'
                        AND {$wpdb->posts}.post_status = 'publish'
                        {$extra_where}
                        AND ( {$wpdb->postmeta}.meta_key = '_price' AND {$wpdb->postmeta}.meta_value >= 0
                        AND ( pm1.meta_key = '_visibility' AND CAST(pm1.meta_value AS CHAR) IN ('visible','catalog') )
                        {$out_of_stock2} ) ");
            }
        }
        if( defined('ICL_LANGUAGE_CODE') ) {
            $query_string['join'] = $query_string['join']." INNER JOIN {$wpdb->prefix}icl_translations as wpml_lang ON ( {$wpdb->posts}.ID = wpml_lang.element_id )";
            $query_string['where'] = $query_string['where']." AND wpml_lang.language_code = '".ICL_LANGUAGE_CODE."' AND wpml_lang.element_type = 'post_product'";
        }
        $query_string = implode( ' ', $query_string );

        $query_string = $wpdb->get_row($query_string);
        $price_range = false;
        if( isset($query_string->min_price) && isset($query_string->max_price) && $query_string->min_price != $query_string->max_price ) {
            $price_range = array(
                apply_filters( 'woocommerce_price_filter_widget_min_amount', $query_string->min_price ), 
                apply_filters( 'woocommerce_price_filter_widget_max_amount', $query_string->max_price )
            );
        }
        return apply_filters( 'berocket_aapf_get_price_range', $price_range );
    }

    public static function get_attribute_values( $taxonomy = '', $order_by = 'id', $hide_empty = false, $count_filtering = true, $input_terms = FALSE, $product_cat = FALSE ) {
if( BeRocket_AAPF::$debug_mode ) {
    $time = microtime(true);
    if( ! isset( BeRocket_AAPF::$error_log['6_term_recount'] ) )
    {
        BeRocket_AAPF::$error_log['6_term_recount'] = array();
    } 
    $term_recount_log = array();
    $term_recount_log['start_time'] = $time;
}
        if ( ! $taxonomy || $taxonomy == 'price' ) return array();

        global $wp_query, $wpdb;
        $old_join_posts = '';
        if( ! method_exists('WC_Query', 'get_main_meta_query') || ! method_exists('WC_Query', 'get_main_tax_query') ) {
            $old_query_vars = self::old_wc_compatible($wp_query);
            $old_meta_query = (empty($old_query_vars['meta_query']) ? array() : $old_query_vars['meta_query']);
            $old_tax_query = (empty($old_query_vars['tax_query']) ? array() : $old_query_vars['tax_query']);
        } else {
            $old_query_vars = self::old_wc_compatible($wp_query, true);
        }
        if( ! empty( $old_query_vars['posts__in'] ) ) {
            $old_join_posts = " AND {$wpdb->posts}.ID IN (".implode(',', $old_query_vars['posts__in']).") ";
        }

        if( $taxonomy == '_stock_status' && ( $count_filtering || $hide_empty ) ) {
            if( class_exists('WP_Meta_Query') && class_exists('WP_Tax_Query') ) {
                if( method_exists('WC_Query', 'get_main_meta_query') ) {
                    $meta_query  = WC_Query::get_main_meta_query();
                } else {
                    $meta_query = $old_meta_query;
                }
                $query_type = 'or';
                if ( 'or' === $query_type ) {
                    foreach( $meta_query as $key => $val ) {
                        if ( isset( $val['key'] ) && $val['key'] == $taxonomy ) {
                            if ( isset( $meta_query[ $key ] ) ) unset( $meta_query[ $key ] );
                        }
                    }
                }
                if( $count_filtering ) {
                    if( method_exists('WC_Query', 'get_main_tax_query') ) {
                        $tax_query  = WC_Query::get_main_tax_query();
                    } else {
                        $tax_query = $old_tax_query;
                    }
                    $args      = $wp_query->query_vars;
                } else {
                    $args      = $wp_query->query_vars;
                    $tax_query = array();
                    if ( ! empty( $args['product_cat'] ) ) {
                        $tax_query[ 'product_cat' ] = array(
                            'taxonomy' => 'product_cat',
                            'terms'    => array( $args['product_cat'] ),
                            'field'    => 'slug',
                        );
                    }
                    foreach( $meta_query as $key => $val ) {
                        if ( ! empty( $val['price_filter'] ) || ! empty( $val['rating_filter'] ) ) {
                            unset( $meta_query[ $key ] );
                        }
                        if( isset( $val['relation']) ) {
                            unset($val['relation']);
                            foreach( $val as $key2 => $val2 ) {
                                if ( isset( $val2['key'] ) && $val2['key'] == '_price' ) {
                                    if ( isset( $meta_query[ $key ][ $key2 ] ) ) unset( $meta_query[ $key ][ $key2 ] );
                                }
                            }
                            if( count($meta_query[ $key ]) <= 1 ) {
                                unset( $meta_query[ $key ] );
                            }
                        } else {
                            if ( isset( $val['key'] ) && $val['key'] == '_price' ) {
                                if ( isset( $meta_query[ $key ] ) ) unset( $meta_query[ $key ] );
                            }
                        }
                    }
                }
                $queried_object = $wp_query->get_queried_object_id();
                if( ! empty($queried_object) ) {
                    $query_object = $wp_query->get_queried_object();
                    if( ! empty($query_object->taxonomy) && ! empty($query_object->slug) ) {
                        $tax_query[ $query_object->taxonomy ] = array(
                            'taxonomy' => $query_object->taxonomy,
                            'terms'    => array( $query_object->slug ),
                            'field'    => 'slug',
                        );
                    }
                }
                $meta_query      = new WP_Meta_Query( $meta_query );
                $tax_query       = new WP_Tax_Query( $tax_query );
                $meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
                $tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );
                $term_ids = wp_list_pluck( $input_terms, 'term_id' );

                // Generate query
                $query           = array();
                $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, postmeta_stock.meta_value as term_count_id";
                $query['from']   = "FROM {$wpdb->posts}";
                $query['join']   = "
                    INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
                    INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
                    INNER JOIN {$wpdb->postmeta} AS postmeta_stock ON ( {$wpdb->posts}.ID = postmeta_stock.post_id )
                    INNER JOIN {$wpdb->terms} AS terms USING( term_id )
                    " . $tax_query_sql['join'] . $meta_query_sql['join'];
                $query['where']   = "
                    WHERE {$wpdb->posts}.post_type IN ( 'product' )
                    AND {$wpdb->posts}.post_status = 'publish'
                    " . $tax_query_sql['where'] . $meta_query_sql['where'] . "
                    AND postmeta_stock.meta_key = '_stock_status'
                ";
                if( defined('ICL_LANGUAGE_CODE') ) {
                    $query['join'] = $query['join']." INNER JOIN {$wpdb->prefix}icl_translations as wpml_lang ON ( {$wpdb->posts}.ID = wpml_lang.element_id )";
                    $query['where'] = $query['where']." AND wpml_lang.language_code = '".ICL_LANGUAGE_CODE."' AND wpml_lang.element_type = 'post_product'";
                }
                if( ! empty($_GET['s']) ) {
                    $query['where'] .= " AND ((({$wpdb->posts}.post_title LIKE '%{$_GET['s']}%') OR ({$wpdb->posts}.post_excerpt LIKE '%{$_GET['s']}%') OR ({$wpdb->posts}.post_content LIKE '%{$_GET['s']}%')))";
                }
                if( $count_filtering ) {
                    $query['where'] .= $old_join_posts;
                }
                $query['group_by'] = "GROUP BY postmeta_stock.meta_value";
                $query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
                $query             = implode( ' ', $query );
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['query_stock'] = $query;
}
                $results           = $wpdb->get_results( $query );
                $results           = wp_list_pluck( $results, 'term_count', 'term_count_id' );
                foreach($input_terms as &$res_count) {
                    if( ! empty($results[$res_count->slug] ) ) {
                        $res_count->count = $results[$res_count->slug];
                    } else {
                        $res_count->count = 0;
                    }
                }
            }
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['time_after_recount'] = microtime(true) - $time;
    $term_recount_log['after_recount'] = $input_terms;
    BeRocket_AAPF::$error_log['6_term_recount'][] = $term_recount_log;
}
            return $input_terms;
        }
        if( $taxonomy == '_sale' && ( $count_filtering || $hide_empty ) ) {
            if( class_exists('WP_Meta_Query') && class_exists('WP_Tax_Query') ) {
                if( method_exists('WC_Query', 'get_main_meta_query') ) {
                    $meta_query  = WC_Query::get_main_meta_query();
                } else {
                    $meta_query = $old_meta_query;
                }
                $query_type = 'or';
                if ( 'or' === $query_type ) {
                    foreach( $meta_query as $key => $val ) {
                        if ( isset( $val['key'] ) && $val['key'] == $taxonomy ) {
                            if ( isset( $meta_query[ $key ] ) ) unset( $meta_query[ $key ] );
                        }
                    }
                }
                if( $count_filtering ) {
                    if( method_exists('WC_Query', 'get_main_tax_query') ) {
                        $tax_query  = WC_Query::get_main_tax_query();
                    } else {
                        $tax_query = $old_tax_query;
                    }
                    $args      = $wp_query->query_vars;
                } else {
                    $args      = $wp_query->query_vars;
                    $tax_query = array();
                    if ( ! empty( $args['product_cat'] ) ) {
                        $tax_query[ 'product_cat' ] = array(
                            'taxonomy' => 'product_cat',
                            'terms'    => array( $args['product_cat'] ),
                            'field'    => 'slug',
                        );
                    }
                    foreach( $meta_query as $key => $val ) {
                        if ( ! empty( $val['price_filter'] ) || ! empty( $val['rating_filter'] ) ) {
                            unset( $meta_query[ $key ] );
                        }
                        if( isset( $val['relation']) ) {
                            unset($val['relation']);
                            foreach( $val as $key2 => $val2 ) {
                                if ( isset( $val2['key'] ) && $val2['key'] == '_price' ) {
                                    if ( isset( $meta_query[ $key ][ $key2 ] ) ) unset( $meta_query[ $key ][ $key2 ] );
                                }
                            }
                            if( count($meta_query[ $key ]) <= 1 ) {
                                unset( $meta_query[ $key ] );
                            }
                        } else {
                            if ( isset( $val['key'] ) && $val['key'] == '_price' ) {
                                if ( isset( $meta_query[ $key ] ) ) unset( $meta_query[ $key ] );
                            }
                        }
                    }
                }
                $queried_object = $wp_query->get_queried_object_id();
                if( ! empty($queried_object) ) {
                    $query_object = $wp_query->get_queried_object();
                    if( ! empty($query_object->taxonomy) && ! empty($query_object->slug) ) {
                        $tax_query[ $query_object->taxonomy ] = array(
                            'taxonomy' => $query_object->taxonomy,
                            'terms'    => array( $query_object->slug ),
                            'field'    => 'slug',
                        );
                    }
                }
                $meta_query      = new WP_Meta_Query( $meta_query );
                $tax_query       = new WP_Tax_Query( $tax_query );
                $meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
                $tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );
                $term_ids = wp_list_pluck( $input_terms, 'term_id' );

                // Generate query
                $query           = array();
                $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count";
                $query['from']   = "FROM {$wpdb->posts}";
                $query['join']   = "
                    INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
                    INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
                    INNER JOIN {$wpdb->terms} AS terms USING( term_id )
                    " . $tax_query_sql['join'] . $meta_query_sql['join'];
                $query['where']   = "
                    WHERE {$wpdb->posts}.post_type IN ( 'product' )
                    AND {$wpdb->posts}.post_status = 'publish'
                    " . $tax_query_sql['where'] . $meta_query_sql['where'] . "
                ";
                if( defined('ICL_LANGUAGE_CODE') ) {
                    $query['join'] = $query['join']." INNER JOIN {$wpdb->prefix}icl_translations as wpml_lang ON ( {$wpdb->posts}.ID = wpml_lang.element_id )";
                    $query['where'] = $query['where']." AND wpml_lang.language_code = '".ICL_LANGUAGE_CODE."' AND wpml_lang.element_type = 'post_product'";
                }
                if( ! empty($_GET['s']) ) {
                    $query['where'] .= " AND ((({$wpdb->posts}.post_title LIKE '%{$_GET['s']}%') OR ({$wpdb->posts}.post_excerpt LIKE '%{$_GET['s']}%') OR ({$wpdb->posts}.post_content LIKE '%{$_GET['s']}%')))";
                }
                if( $count_filtering ) {
                    $query['where'] .= $old_join_posts;
                }
                $query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
                $on_sale = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
                $query_sale = $query;
                $query_sale['where'] .= " AND {$wpdb->posts}.ID IN (".implode(',', $on_sale).") ";;
                $query_sale        = implode( ' ', $query_sale );
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['query_sale'] = $query_sale;
}
                $results           = $wpdb->get_results( $query_sale );
                foreach($input_terms as &$res_count) {
                    if( $res_count->term_id == 1 ) {
                        if( ! empty($results[0]->term_count ) ) {
                            $res_count->count = $results[0]->term_count;
                        } else {
                            $res_count->count = 0;
                        }
                    }
                }
                $query_not_sale = $query;
                $query_not_sale['where'] .= " AND {$wpdb->posts}.ID NOT IN (".implode(',', $on_sale).") ";;
                $query_not_sale        = implode( ' ', $query_not_sale );
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['query_not_sale'] = $query_not_sale;
}
                $results           = $wpdb->get_results( $query_not_sale );
                foreach($input_terms as &$res_count) {
                    if( $res_count->term_id == 2 ) {
                        if( ! empty($results[0]->term_count ) ) {
                            $res_count->count = $results[0]->term_count;
                        } else {
                            $res_count->count = 0;
                        }
                    }
                }
            }
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['time_after_recount'] = microtime(true) - $time;
    $term_recount_log['after_recount'] = $input_terms;
    BeRocket_AAPF::$error_log['6_term_recount'][] = $term_recount_log;
}
            return $input_terms;
        }
        if( $product_cat || $hide_empty) {
            $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );
            $cache_name = 'br_'.$taxonomy.'_'.$order_by;
            if ( $product_cat ) {
                $cache_name .= '_'.$product_cat;
            }
            $cache_result = br_get_cache ( $cache_name, 'get_attribute_values_hide_empty', $br_options['object_cache'] );
            if( $cache_result === false || ! isset($cache_result['terms'] ) || ! isset($cache_result['term_count'] ) ) {
                if( class_exists('WP_Meta_Query') && class_exists('WP_Tax_Query') ) {
                    $args = array(
                        'orderby'    => $order_by,
                        'order'      => 'ASC',
                        'hide_empty' => false,
                    );
                    if ( $taxonomy == 'product_cat' ) {
                        $re = self::get_product_categories( '', 0, array(), 0, 50, true );
                        $re = self::set_terms_on_same_level( $re, array(), false );
                    } elseif ( ! isset($input_terms) || $input_terms === FALSE ) {
                        $re = get_terms( $taxonomy, $args );
                    } else {
                        $re = $input_terms;
                    }
                    if( method_exists('WC_Query', 'get_main_meta_query') ) {
                        $meta_query  = WC_Query::get_main_meta_query();
                    } else {
                        $meta_query = $old_meta_query;
                    }
                    $woocommerce_hide_out_of_stock_items = ( BeRocket_AAPF_Widget::woocommerce_hide_out_of_stock_items() == 'no' );
                    foreach( $meta_query as $key => $val ) {
                        if ( ! empty( $val['price_filter'] ) || ! empty( $val['rating_filter'] ) ) {
                            unset( $meta_query[ $key ] );
                        }
                        if( isset( $val['relation']) ) {
                            unset($val['relation']);
                            foreach( $val as $key2 => $val2 ) {
                                if ( isset( $val2['key'] ) && $val2['key'] == '_price' ) {
                                    if ( isset( $meta_query[ $key ][ $key2 ] ) ) unset( $meta_query[ $key ][ $key2 ] );
                                } else if( $woocommerce_hide_out_of_stock_items ) {
                                    if ( isset( $val2['key'] ) && $val2['key'] == '_stock_status' ) {
                                        if ( isset( $meta_query[ $key ][ $key2 ] ) ) unset( $meta_query[ $key ][ $key2 ] );
                                    }
                                }
                            }
                            if( count($meta_query[ $key ]) <= 1 ) {
                                unset( $meta_query[ $key ] );
                            }
                        } else {
                            if ( isset( $val['key'] ) && $val['key'] == '_price' ) {
                                if ( isset( $meta_query[ $key ] ) ) unset( $meta_query[ $key ] );
                            } else if( $woocommerce_hide_out_of_stock_items ) {
                                if ( isset( $val['key'] ) && $val['key'] == '_stock_status' ) {
                                    if ( isset( $meta_query[ $key ] ) ) unset( $meta_query[ $key ] );
                                }
                            }
                        }
                    }
                    $args      = $wp_query->query_vars;
                    $tax_query = array();
                    if ( ! empty( $args['product_cat'] ) ) {
                        $tax_query[ 'product_cat' ] = array(
                            'taxonomy' => 'product_cat',
                            'terms'    => array( $args['product_cat'] ),
                            'field'    => 'slug',
                        );
                    }
                    $queried_object = $wp_query->get_queried_object_id();
                    if( ! empty($queried_object) ) {
                        $query_object = $wp_query->get_queried_object();
                        if( ! empty($query_object->taxonomy) && ! empty($query_object->slug) ) {
                            $tax_query[ $query_object->taxonomy ] = array(
                                'taxonomy' => $query_object->taxonomy,
                                'terms'    => array( $query_object->slug ),
                                'field'    => 'slug',
                            );
                        }
                    }
                    $meta_query      = new WP_Meta_Query( $meta_query );
                    $meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
                    unset($meta_query);
                    $tax_query       = new WP_Tax_Query( $tax_query );
                    $tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );
                    unset($tax_query);
                    if( ! empty($re) && ! is_wp_error($re) ) {
                        $term_ids = wp_list_pluck( $re, 'term_id' );
                    }
                    if( empty($term_ids) || ! is_array($term_ids) ) {
                        $terms = array();
                        $term_count = array();
                    } else {

                        // Generate query
                        $query           = array();
                        $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
                        $query['from']   = "FROM {$wpdb->posts}";
                        $query['join']   = "
                            INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
                            INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
                            INNER JOIN {$wpdb->terms} AS terms USING( term_id )
                            " . $tax_query_sql['join'] . $meta_query_sql['join'];
                        $query['where']   = "
                            WHERE {$wpdb->posts}.post_type IN ( 'product' )
                            AND {$wpdb->posts}.post_status = 'publish'
                            " . $tax_query_sql['where'] . $meta_query_sql['where'] . "
                            AND terms.term_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ")
                        ";
                        if( defined('ICL_LANGUAGE_CODE') ) {
                            $query['join'] = $query['join']." INNER JOIN {$wpdb->prefix}icl_translations as wpml_lang ON ( {$wpdb->posts}.ID = wpml_lang.element_id )";
                            $query['where'] = $query['where']." AND wpml_lang.language_code = '".ICL_LANGUAGE_CODE."' AND wpml_lang.element_type = 'post_product'";
                        }
                        $query['group_by'] = "GROUP BY terms.term_id";
                        $query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
                        $query             = implode( ' ', $query );
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['query_1'] = $query;
}
                        $results           = $wpdb->get_results( $query );
                        $results           = wp_list_pluck( $results, 'term_count', 'term_count_id' );
                        $term_count = array();
                        $terms = array();
                        foreach($re as &$res_count) {
                            if( ! empty($results[$res_count->term_id] ) ) {
                                $res_count->count = $results[$res_count->term_id];
                            } elseif( $res_count->term_id == 'R__term_id__R' ) {
                            } else {
                                $res_count->count = 0;
                            }
                            if( $res_count->count > 0 ) {
                                $terms[] = $res_count->term_id;
                                $term_count[$res_count->term_id] = $res_count->count;
                            }
                        }
                    }
                    $cache_result = array('terms' => $terms, 'term_count' => $term_count);
                    br_set_cache ( $cache_name, $cache_result, 'get_attribute_values_hide_empty', BeRocket_AJAX_cache_expire, $br_options['object_cache'] );
                } else {
                    $terms                 = array();
                    $q_args                = $wp_query->query_vars;
                    $q_args['nopaging']    = true;
                    $q_args['post__in']    = '';
                    $q_args['tax_query']   = '';
                    $q_args['taxonomy']    = '';
                    $q_args['term']        = '';
                    $q_args['meta_query']  = '';
                    $q_args['attribute']   = '';
                    $q_args['title']       = '';
                    $q_args['fields']      = 'ids';
                    if ( $product_cat ) {
                        $q_args['product_cat'] = $product_cat;
                    }
                                
                    $the_query             = new WP_Query( $q_args );

                    $term_count = array();
                    foreach ( $the_query->posts as $post_id ) {
                        $curent_terms = wp_get_object_terms( $post_id, $taxonomy, array( "fields" => "ids" ) );

                        foreach ( $curent_terms as $t ) {
                            if ( ! in_array( $t, $terms ) ) {
                                $terms[] = $t;
                            }
                            if ( isset( $term_count[$t] ) ) {
                                $term_count[$t]++;
                            } else {
                                $term_count[$t] = 1;
                            }
                        }
                    }
                    $cache_result = array('terms' => $terms, 'term_count' => $term_count);
                    br_set_cache ( $cache_name, $cache_result, 'get_attribute_values_hide_empty', BeRocket_AJAX_cache_expire, $br_options['object_cache'] );
                }
            } else {
                $terms = $cache_result['terms'];
                $term_count = $cache_result['term_count'];
            }
        }
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['cache_result'] = array();
    $term_recount_log['cache_result']['terms'] = @ $terms;
    $term_recount_log['cache_result']['term_count'] = @ $term_count;
}
        if ( $hide_empty ) {

            unset( $curent_terms, $the_query );

            $args = array(
                'orderby'    => $order_by,
                'order'      => 'ASC',
                'hide_empty' => false,
            );

            if ( $taxonomy == 'product_cat' ) {
                $terms2 = self::get_product_categories( '', 0, array(), 0, 50, true );
                $terms2 = self::set_terms_on_same_level( $terms2, array(), false );
            } elseif ( ! isset($input_terms) || $input_terms === FALSE ) {
                $terms2 = get_terms( $taxonomy, $args );
            } else {
                $terms2 = $input_terms;
                unset( $input_terms );
            }
            $re = array();
            if( is_array($terms2) ) {
                foreach ( $terms2 as $t ) {
                    if( $t->term_id == 'R__term_id__R' ) {
                        @ $re[$t->term_id] = $t;
                    } elseif ( in_array( $t->term_id, $terms )  ) {
                        @ $re[$t->term_id] = $t;
                        @ $re[$t->term_id]->count = $term_count[$t->term_id];
                    }
                }
            }

            unset( $terms2 );
        } else {
            $args = array(
                'orderby'    => $order_by,
                'order'      => 'ASC',
                'hide_empty' => false,
            );
            if ( $taxonomy == 'product_cat' ) {
                $re = self::get_product_categories( '', 0, array(), 0, 50, true );
                $re = self::set_terms_on_same_level( $re, array(), false );
            } elseif ( $input_terms === FALSE ) {
                $re = get_terms( $taxonomy, $args );
            } else {
                $re = $input_terms;
                unset( $input_terms );
            }
            if( $product_cat ) {
                foreach ( $re as $key => $t ) {
                    if( isset( $term_count[$re[$key]->term_id] ) ) {
                        $re[$key]->count = $term_count[$re[$key]->term_id];
                    } else {
                        $re[$key]->count = 0;
                    }
                }
            }
        }
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['time_before_recount'] = microtime(true) - $time;
    $term_recount_log['before_recount'] = $re;
}
        if( empty($re) || ! is_array($re) || count($re) == 0 ) {
if( BeRocket_AAPF::$debug_mode ) {
    BeRocket_AAPF::$error_log['6_term_recount'][] = $term_recount_log;
}
            return $re;
        }
        if ( $count_filtering ) {
            if( class_exists('WP_Meta_Query') && class_exists('WP_Tax_Query') ) {
                if( method_exists('WC_Query', 'get_main_tax_query') ) {
                    $tax_query  = WC_Query::get_main_tax_query();
                } else {
                    $tax_query = $old_tax_query;
                }
                if( method_exists('WC_Query', 'get_main_meta_query') ) {
                    $meta_query  = WC_Query::get_main_meta_query();
                } else {
                    $meta_query = $old_meta_query;
                }
                $query_type = 'or';

                if ( 'or' === $query_type ) {
                    foreach( $tax_query as $key => $val ) {
                        if( isset( $val['relation']) ) {
                            unset($val['relation']);
                            foreach( $val as $key2 => $val2 ) {
                                if ( isset( $val2['taxonomy'] ) && $val2['taxonomy'] == $taxonomy ) {
                                    if ( isset( $tax_query[ $key ][ $key2 ] ) ) unset( $tax_query[ $key ][ $key2 ] );
                                }
                            }
                            if( count($tax_query[ $key ]) <= 1 ) {
                                unset( $tax_query[ $key ] );
                            }
                        } else {
                            if ( isset( $val['taxonomy'] ) && $val['taxonomy'] == $taxonomy ) {
                                if ( isset( $tax_query[ $key ] ) ) unset( $tax_query[ $key ] );
                            }
                        }
                    }
                }
                $queried_object = $wp_query->get_queried_object_id();
                if( ! empty($queried_object) ) {
                    $query_object = $wp_query->get_queried_object();
                    if( ! empty($query_object->taxonomy) && ! empty($query_object->slug) ) {
                        $tax_query[ $query_object->taxonomy ] = array(
                            'taxonomy' => $query_object->taxonomy,
                            'terms'    => array( $query_object->slug ),
                            'field'    => 'slug',
                        );
                    }
                }
                $meta_query      = new WP_Meta_Query( $meta_query );
                $tax_query       = new WP_Tax_Query( $tax_query );
                $meta_query_sql  = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
                $tax_query_sql   = $tax_query->get_sql( $wpdb->posts, 'ID' );
                $term_ids = wp_list_pluck( $re, 'term_id' );

                // Generate query
                $query           = array();
                $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
                $query['from']   = "FROM {$wpdb->posts}";
                $query['join']   = "
                    INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
                    INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
                    INNER JOIN {$wpdb->terms} AS terms USING( term_id )
                    " . $tax_query_sql['join'] . $meta_query_sql['join'];
                $query['where']   = "
                    WHERE {$wpdb->posts}.post_type IN ( 'product' )
                    AND {$wpdb->posts}.post_status = 'publish'
                    " . $tax_query_sql['where'] . $meta_query_sql['where'] . "
                    AND terms.term_id IN (" . implode( ',', array_map( 'absint', $term_ids ) ) . ")
                ";
                if( defined('ICL_LANGUAGE_CODE') ) {
                    $query['join'] = $query['join']." INNER JOIN {$wpdb->prefix}icl_translations as wpml_lang ON ( {$wpdb->posts}.ID = wpml_lang.element_id )";
                    $query['where'] = $query['where']." AND wpml_lang.language_code = '".ICL_LANGUAGE_CODE."' AND wpml_lang.element_type = 'post_product'";
                }
                if( ! empty($_GET['s']) ) {
                    $query['where'] .= " AND ((({$wpdb->posts}.post_title LIKE '%{$_GET['s']}%') OR ({$wpdb->posts}.post_excerpt LIKE '%{$_GET['s']}%') OR ({$wpdb->posts}.post_content LIKE '%{$_GET['s']}%')))";
                }
                $query['where'] .= $old_join_posts;
                $query['group_by'] = "GROUP BY terms.term_id";
                $query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
                $query             = implode( ' ', $query );
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['query_2'] = $query;
}
                $results           = $wpdb->get_results( $query );
                $results           = wp_list_pluck( $results, 'term_count', 'term_count_id' );
                foreach($re as &$res_count) {
                    if( ! empty($results[$res_count->term_id] ) ) {
                        $res_count->count = $results[$res_count->term_id];
                    } else {
                        $res_count->count = 0;
                    }
                }
            } else {
                $q_args = $wp_query->query_vars;
                $q_args['nopaging'] = true;
                if ( $product_cat ) {
                    $q_args['product_cat'] = $product_cat;
                }
                if ( is_array( @ $q_args['tax_query'] ) ) {
                    foreach( $q_args['tax_query'] as $key => $val ) {
                        if( isset( $val['relation']) ) {
                            unset($val['relation']);
                            foreach( $val as $key2 => $val2 ) {
                                if ( isset( $val2['taxonomy'] ) && $val2['taxonomy'] == $taxonomy ) {
                                    if ( isset( $q_args['tax_query'][ $key ][ $key2 ] ) ) unset( $q_args['tax_query'][ $key ][ $key2 ] );
                                }
                            }
                            if( count($q_args['tax_query'][ $key ]) <= 1 ) {
                                unset( $q_args['tax_query'][ $key ] );
                            }
                        } else {
                            if ( isset( $val['taxonomy'] ) && $val['taxonomy'] == $taxonomy ) {
                                if ( isset( $q_args['tax_query'][ $key ] ) ) unset( $q_args['tax_query'][ $key ] );
                            }
                        }
                    }
                }

                $q_args['taxonomy']    = '';
                $q_args['term']        = '';
                $q_args['attribute']   = '';
                $q_args['title']       = '';
                $args                  = apply_filters( 'berocket_aapf_listener_wp_query_args', array() );
                if ( isset( $args['product_tag'] ) )
                {
                    $q_args['product_tag'] = $args['product_tag'];
                }
                $q_args['fields'] = 'ids';

                $the_query = new WP_Query( $q_args );
    if( BeRocket_AAPF::$debug_mode ) {
        $term_recount_log['count_query'] = $the_query;
        $term_recount_log['inside_query'] = $wp_query;
    }
                $count_terms = array();

                //debug( "1---------------------" );
                //debug( microtime() );
                foreach ( $the_query->posts as $post ) {
                    $curent_terms = br_wp_get_object_terms( $post, $taxonomy, array( "fields" => "ids" ) );
                    foreach ( $curent_terms as $t ) {
                        if ( isset( $count_terms[$t] ) ) {
                            $count_terms[$t] += 1;
                        } else {
                            $count_terms[$t] = 1;
                        }
                    }
                }
                //debug( "2---------------------" );
                //debug( microtime() );
    if( BeRocket_AAPF::$debug_mode ) {
        $term_recount_log['count'] = $count_terms;
    }
                unset( $the_query, $curent_terms, $q_args, $post );
                if ( @ is_array( $re ) ) {
                    foreach ( $re as $i => $re_val ) {
                        @ $re[$i]->count = 0;
                        if ( isset( $count_terms[$re[$i]->term_id] ) ) {
                            $re[$i]->count = $count_terms[$re[$i]->term_id];
                        }

                        $children = get_term_children( $re[$i]->term_id, $taxonomy );
                        $children_count = 0;
                        if( is_array( $children ) ) {
                            foreach ( $children as $child ) {
                                $children_count += @ $count_terms[$child];
                            }
                        }
                        $re[$i]->count += ( $children_count );
                    }
                }
                unset( $children_count, $children, $count_terms );
            }
        }
        if( is_array($re) ) {
            $re = array_values( $re );
        }
if( BeRocket_AAPF::$debug_mode ) {
    $term_recount_log['time_after_recount'] = microtime(true) - $time;
    $term_recount_log['after_recount'] = $re;
    BeRocket_AAPF::$error_log['6_term_recount'][] = $term_recount_log;
}
        if( $taxonomy == 'product_cat' ) {
            $sort_cat = self::get_product_categories( '', 0, array(), 0, 50, true );
            $assoc_re = array();
            foreach($re as $term_re) {
                if( empty($term_re->count) ) {
                    $term_re->count = 0;
                }
                $assoc_re[$term_re->term_id] = $term_re;
            }
            self::product_cat_recount_with_child($sort_cat, $assoc_re);
            if( isset( $input_terms ) && $input_terms !== FALSE ) {
                $re = $input_terms;
            }
            foreach($re as $term_id => $term_re) {
                if( isset($assoc_re[$term_re->term_id]) ) {
                    $re[$term_id]->count = $assoc_re[$term_re->term_id]->count;
                } else {
                    unset($re[$term_id]);
                }
            }
        }
        return $re;
    }

    public static function product_cat_recount_with_child($terms, &$re) {
        $global_count = 0;
        foreach($terms as &$term) {
            $count = 0;
            if( isset($re[$term->term_id]) ) {
                $count += $re[$term->term_id]->count;
            }
            if( !empty($term->child) ) {
                $count += self::product_cat_recount_with_child($term->child, $re);
            }
            if( isset($re[$term->term_id]) ) {
                $re[$term->term_id]->count = $count;
            }
            $global_count += $count;
        }
        return $global_count;
    }

    public static function sort_terms( &$terms, $sort_data ) {
        $sort_array = array();

        if ( @ is_array( $terms ) && @ count( $terms ) ) {
            if ( @ $sort_data['attribute'] == 'product_cat' and @ $sort_data['order_values_by'] == 'Default' ) {
                foreach ( $terms as $term ) {
                    $element_of_sort = get_woocommerce_term_meta(  $term->term_id,  'order',  true );
                    if( is_array($element_of_sort) || $element_of_sort === false ) {
                        $sort_array[] = 0;
                    } else {
                        $sort_array[] = $element_of_sort;
                    }
                    if ( @ $term->child ) {
                        self::sort_terms( $term->child, $sort_data );
                    }
                }
                if( BeRocket_AAPF::$debug_mode ) {
                    BeRocket_AAPF::$error_log[$sort_data['attribute'].'_sort'] = array('array' => $sort_array, 'sort' => $terms, 'data' => $sort_data );
                }
                @ array_multisort( $sort_array, $terms, SORT_ASC, SORT_NUMERIC );
            } elseif ( ( @ $sort_data['wc_order_by'] or @ $sort_data['order_values_by'] ) ) {
                if ( @ $sort_data['wc_order_by'] == 'name' and @ $sort_data['order_values_by'] == 'Default' or @ $sort_data['order_values_by'] == 'Alpha' ) {
                    foreach ( $terms as $term ) {
                        $sort_array[] = strtolower($term->name);
                        if ( @ $term->child ) {
                            self::sort_terms( $term->child, $sort_data );
                        }
                    }
                    @ array_multisort( $sort_array, $terms, SORT_ASC, SORT_STRING );
                } elseif ( @ $sort_data['wc_order_by'] == 'name_num' and @ $sort_data['order_values_by'] == 'Default' or @ $sort_data['order_values_by'] == 'Numeric' ) {
                    foreach ( $terms as $term ) {
                        $sort_array[] = (float) $term->name;
                        if ( @ $term->child ) {
                            self::sort_terms( $term->child, $sort_data );
                        }
                    }
                    @ array_multisort( $sort_array, $terms, SORT_ASC, SORT_NUMERIC );
                }
            }
        }
    }

    public static function set_terms_on_same_level( $terms, $return_array = array(), $add_spaces = true ) {
        if ( @ is_array( $terms ) && @ count( $terms ) ) {
            foreach ( $terms as $term ) {
                if ( $add_spaces ) {
                    for ( $i = 0; $i < $term->depth; $i++ ) {
                        $term->name = "&nbsp;&nbsp;" . $term->name;
                    }
                }
                $child = @$term->child;
                unset( $term->child );

                $return_array[] = $term;

                if ( @ $child ) {
                    $return_array = self::set_terms_on_same_level( $child, $return_array, $add_spaces );
                }
            }
        } else {
            $return_array = @ $terms;
        }
        return $return_array;
    }

    public static function get_filter_products( $wp_query_product_cat, $woocommerce_hide_out_of_stock_items, $use_filters = true ) {
        global $wp_query, $wp_rewrite;
        $_POST['product_cat'] = $wp_query_product_cat;

        $old_post_terms = @ $_POST['terms'];

        add_filter( 'woocommerce_pagination_args', array( __CLASS__, 'pagination_args' ) );

        $args = apply_filters( 'berocket_aapf_listener_wp_query_args', array() );
        $tags = @ $args['product_tag'];
        $meta_query = BeRocket_AAPF::remove_out_of_stock( array() , true, $woocommerce_hide_out_of_stock_items != 'yes' );
        $args['post__in'] = array();

        if( $woocommerce_hide_out_of_stock_items == 'yes' ) {
            $args['post__in'] = BeRocket_AAPF::remove_out_of_stock( $args['post__in'] );
        }
        if ( $use_filters ) {
            $args['post__in'] = BeRocket_AAPF::limits_filter( $args['post__in'] );
            $args['post__in'] = BeRocket_AAPF::price_filter( $args['post__in'] );
            $args['post__in'] = BeRocket_AAPF::add_terms( $args['post__in'] );
        } else {
            $args = array( 'posts_per_page' => -1 );
            if ( @$_POST['product_cat'] and $_POST['product_cat'] != '-1' ) {
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => strip_tags( $_POST['product_cat'] ),
                    'operator' => 'IN'
                );
            }
        }

        $args['post_status'] = 'publish';
        $args['post_type'] = 'product';

        $wp_query = new WP_Query( $args );

        // here we get max products to know if current page is not too big
        if ( $wp_rewrite->using_permalinks() and preg_match( "~/page/([0-9]+)~", @ $_POST['location'], $mathces ) or preg_match( "~paged?=([0-9]+)~", @ $_POST['location'], $mathces ) ) {
            $args['paged'] = min( $mathces[1], $wp_query->max_num_pages );
            $wp_query = new WP_Query( $args );
        }
        if ( $wp_query->found_posts <= 1 ) {
            $args['paged'] = 0;
            $wp_query = new WP_Query( $args );
        }

        $products = array();
        if ( $wp_query->have_posts() ) {
            while ( have_posts() ) {
                the_post();
                $products[] = get_the_ID();
            }
        }

        wp_reset_query();
        if( @ $meta_query && is_array( $meta_query ) && count( $meta_query ) > 0 ) {
            $q_vars = $wp_query->query_vars;
            foreach( $q_vars['meta_query'] as $key_meta => $val_meta ) {
                if( $key_meta != 'relation' && $val_meta['key'] == '_stock_status') {
                    unset( $q_vars['meta_query'][$key_meta] );
                }
            }
            $q_vars['meta_query'] = array_merge( $q_vars['meta_query'], $meta_query );
            $wp_query->set('meta_query', $q_vars['meta_query']);
        }
        if( @ $tags ) {
            $q_vars = $wp_query->query_vars;
            $q_vars['product_tag'] = $tags;
            unset($q_vars['s']);
            $wp_query = new WP_Query( $q_vars );
        }

        $_POST['terms'] = $old_post_terms;
        return $products;
    }

    /**
     * Validating and updating widget data
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array - new merged instance
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /* Strip tags (if needed) and update the widget settings. */
        $instance['widget_type']                = strip_tags( $new_instance['widget_type'] );
        $instance['title']                      = strip_tags( $new_instance['title'] );
        $instance['attribute']                  = strip_tags( $new_instance['attribute'] );
        $instance['type']                       = strip_tags( $new_instance['type'] );
        $instance['scroll_theme']               = strip_tags( $new_instance['scroll_theme'] );
        $instance['css_class']                  = strip_tags( $new_instance['css_class'] );
        $instance['text_before_price']          = strip_tags( $new_instance['text_before_price'] );
        $instance['text_after_price']           = strip_tags( $new_instance['text_after_price'] );
        $instance['filter_type']                = strip_tags( $new_instance['filter_type'] );
        $instance['custom_taxonomy']            = strip_tags( $new_instance['custom_taxonomy'] );
        $instance['filter_by']                  = strip_tags( $new_instance['filter_by'] );
        $instance['description']                = strip_tags( $new_instance['description'] );
        $instance['parent_product_cat']         = strip_tags( $new_instance['parent_product_cat'] );
        $instance['order_values_by']            = strip_tags( $new_instance['order_values_by'] );
        $instance['show_page']                  = $new_instance['show_page'];
        $instance['cat_value_limit']            = $new_instance['cat_value_limit'];
        $instance['child_parent']               = $new_instance['child_parent'];
        $instance['child_onew_childs']          = $new_instance['child_onew_childs'];
        $instance['child_parent_previous']      = $new_instance['child_parent_previous'];
        $instance['child_parent_no_values']     = $new_instance['child_parent_no_values'];
        $instance['child_parent_no_products']   = $new_instance['child_parent_no_products'];
        $instance['search_box_count']           = $new_instance['search_box_count'];
        $instance['search_box_attributes']      = $new_instance['search_box_attributes'];
        $instance['search_box_url']             = $new_instance['search_box_url'];
        $instance['search_box_category']        = $new_instance['search_box_category'];
        $instance['search_box_link_type']       = $new_instance['search_box_link_type'];
        $instance['search_box_style']           = $new_instance['search_box_style'];
        $instance['slider_default']             = $new_instance['slider_default'];
        $instance['icon_after_title']           = $new_instance['icon_after_title'];
        $instance['icon_before_title']          = $new_instance['icon_before_title'];
        $instance['icon_after_value']           = $new_instance['icon_after_value'];
        $instance['icon_before_value']          = $new_instance['icon_before_value'];
        $instance['hide_first_last_ranges']     = $new_instance['hide_first_last_ranges'];
        $instance['parent_product_cat_current'] = $new_instance['parent_product_cat_current'];
        $instance['user_can_see']               = $new_instance['user_can_see'];
        $instance['include_exclude_select']     = $new_instance['include_exclude_select'];
        $instance['include_exclude_list']       = $new_instance['include_exclude_list'];
        if( ! is_array($instance['include_exclude_list']) ) {
            $instance['include_exclude_list'] = array();
        }
        $instance['cat_propagation']            = (int) $new_instance['cat_propagation'];
        $instance['widget_is_hide']             = (int) $new_instance['widget_is_hide'];
        $instance['is_hide_mobile']             = (int) $new_instance['is_hide_mobile'];
        $instance['hide_collapse_arrow']        = (int) $new_instance['hide_collapse_arrow'];
        $instance['selected_area_show']         = (int) $new_instance['selected_area_show'];
        $instance['selected_is_hide']           = (int) $new_instance['selected_is_hide'];
        $instance['hide_selected_arrow']        = (int) $new_instance['hide_selected_arrow'];
        $instance['child_parent_depth']         = (int) $new_instance['child_parent_depth'];
        $instance['child_onew_count']           = (int) $new_instance['child_onew_count'];
        
        $instance['product_cat']                = ( @ $new_instance['product_cat'] ) ? json_encode( $new_instance['product_cat'] ) : '';
        if ( ! $instance['child_parent_depth'] || $instance['child_parent_depth'] < 1 ) {
            $instance['child_parent_depth'] = 1;
        }
        if( $instance['type'] == 'slider' or $instance['type'] == 'tag_cloud' or ( $instance['filter_type'] == '_stock_status' and $instance['widget_type'] == 'filter' ) or ( $instance['filter_type'] == 'tag' and $instance['widget_type'] == 'filter' ) or ( $instance['filter_type'] == 'product_cat' and $instance['widget_type'] == 'filter' ) ) {
            $instance['child_parent'] = '';
        }

        if ( $instance['type'] == 'slider' or $instance['type'] == 'select' or $instance['type'] == 'tag_cloud' ) {
            $instance['values_per_row']  = 1;
        } else {
            $instance['values_per_row']  = $new_instance['values_per_row'];
        }

        if( $new_instance['height'] != 'auto' ) $new_instance['height'] = (float) $new_instance['height'];
        if( !$new_instance['height'] ) $new_instance['height'] = 'auto';
        $instance['height'] = $new_instance['height'];

        if( $new_instance['operator'] != 'OR' ) $new_instance['operator'] = 'AND';
        $instance['operator'] = $new_instance['operator'];

        if ( $instance['filter_type'] == 'tag' and $instance['type'] == 'tag_cloud' ) {
            $instance['tag_cloud_height']     = (int) $new_instance['tag_cloud_height'];
            $instance['tag_cloud_min_font']   = (int) $new_instance['tag_cloud_min_font'];
            $instance['tag_cloud_max_font']   = (int) $new_instance['tag_cloud_max_font'];
            $instance['tag_cloud_tags_count'] = (int) $new_instance['tag_cloud_tags_count'];
        }
        if ( $instance['type'] != 'slider' or $instance['type'] != 'tag_cloud' ) {
            $instance['show_product_count_per_attr'] = (int) $new_instance['show_product_count_per_attr'];
        }
        if ( $instance['type'] != 'slider' or $instance['type'] != 'tag_cloud' or $instance['type'] != 'select' ) {
            $instance['hide_child_attributes'] = (int) $new_instance['hide_child_attributes'];
        }
        if ( $instance['filter_type'] == 'product_cat' ) {
            $instance['depth_count'] = (int) $new_instance['depth_count'];
            if( $instance['depth_count'] < 0 )
                $instance['depth_count'] = 0;
        }
        if ( $instance['filter_type'] == 'attribute' and $instance['attribute'] == 'price' ) {
            $instance['use_min_price'] = (int) $new_instance['use_min_price'];
            if((int) $new_instance['min_price'] >= 0) {
                $instance['min_price'] = (int) $new_instance['min_price'];
            } else {
                $instance['min_price'] = 0;
            }
            $instance['use_max_price'] = (int) $new_instance['use_max_price'];
            if((int) $new_instance['max_price'] >= 1) {
                $instance['max_price'] = (int) $new_instance['max_price'];
            } else {
                $instance['max_price'] = 1;
            }
        }

        if( ( $instance['filter_type'] == 'attribute' or $instance['filter_type'] == 'custom_taxonomy' ) and ( $instance['type'] == 'color' or $instance['type'] == 'image' ) ) {
            $instance['use_value_with_color'] = (int) $new_instance['use_value_with_color'];
            $_POST['tax_color_name']          = $instance['attribute'];
            $_POST['type']                    = $instance['type'];
            $_POST['tax_color_set']           = $_POST['br_widget_color'];
            BeRocket_AAPF_Widget::color_listener();
        }

        $instance['price_values'] = '';
        if ( $price_values = trim( $new_instance['price_values'] ) ) {
            $price_values = explode( ",", $price_values );

            foreach ( $price_values as $price_value ) {
                $instance['price_values'][] = (float) trim( $price_value );
            }

            $instance['price_values'] = array_unique( $instance['price_values'] );
            sort( $instance['price_values'], SORT_NUMERIC );

            $instance['price_values'] = implode( ",", $instance['price_values'] );
        }

        $instance['ranges'] = array();
        if ( isset( $new_instance['ranges'] ) && is_array( $new_instance['ranges'] ) ) {
            foreach ( $new_instance['ranges'] as $range ) {
                $range = (int) $range;
                if ( $range < 1 ) {
                    $range = 1;
                } 
                $instance['ranges'][] = $range;
            }
        }

        do_action( 'berocket_aapf_admin_update', $instance, $new_instance, $old_instance );

        return apply_filters( 'berocket_aapf_admin_update_instance', $instance );
    }

    /**
     * Output admin form
     *
     * @param array $instance
     *
     * @return string|void
     */
    function form( $instance ) {
        wp_enqueue_script( 'berocket_aapf_widget-admin-colorpicker', plugins_url( '../js/colpick.js', __FILE__ ), array( 'jquery' ), BeRocket_AJAX_filters_version );
        wp_enqueue_script( 'berocket_aapf_widget-admin-script', plugins_url('../js/admin.js', __FILE__), array('jquery'), BeRocket_AJAX_filters_version );

        wp_register_style( 'berocket_aapf_widget-colorpicker-style', plugins_url( '../css/colpick.css', __FILE__ ), "", BeRocket_AJAX_filters_version );
        wp_enqueue_style( 'berocket_aapf_widget-colorpicker-style' );

        wp_register_style( 'berocket_aapf_widget-style', plugins_url('../css/admin.css', __FILE__), "", BeRocket_AJAX_filters_version );
        wp_enqueue_style( 'berocket_aapf_widget-style' );

        $default = apply_filters( 'berocket_aapf_form_defaults', self::$defaults );

        $instance          = wp_parse_args( (array) $instance, $default );
        if( ! empty($instance['product_cat']) && is_array($instance['product_cat']) ) {
            foreach($instance['product_cat'] as &$product_cat_el) {
                $product_cat_el = urldecode($product_cat_el);
            }
        }
        $attributes        = br_aapf_get_attributes();
        $categories        = self::get_product_categories( @ json_decode( $instance['product_cat'] ) );
        $categories        = self::set_terms_on_same_level( $categories );
        $tags              = get_terms( 'product_tag' );
        $custom_taxonomies = get_taxonomies( array( "_builtin" => false, "public" => true ) );

        include AAPF_TEMPLATE_PATH . "admin.php";
    }

    /**
     * Widget ajax listener
     */
    public static function listener(){
        global $wp_query, $wp_rewrite;
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );

        $wp_query = self::listener_wp_query();

        if( @ ! $br_options['ajax_request_load'] ) {
            ob_start();

            $is_have_post = $wp_query->have_posts();
            if ( $is_have_post ) {

                woocommerce_product_loop_start();
                woocommerce_product_subcategories();

                while ( have_posts() ) {
                    the_post();
                    wc_get_template_part( 'content', 'product' );
                }

                woocommerce_product_loop_end();

                wp_reset_postdata();

                $_RESPONSE['products'] = ob_get_contents();
            } else {
                echo apply_filters( 'berocket_aapf_listener_no_products_message', "<div class='no-products" . ( ( $br_options['no_products_class'] ) ? ' '.$br_options['no_products_class'] : '' ) . "'>" . $br_options['no_products_message'] . "</div>" );

                $_RESPONSE['no_products'] = ob_get_contents();
            }
            ob_end_clean();
            if( ! @ $br_options['woocommerce_removes']['ordering'] ) {
                ob_start();
                woocommerce_catalog_ordering();
                $_RESPONSE['catalog_ordering'] = ob_get_contents();
                ob_end_clean();
            }
            if( ! @ $br_options['woocommerce_removes']['result_count'] ) {
                ob_start();
                woocommerce_result_count();
                $_RESPONSE['result_count'] = ob_get_contents();
                ob_end_clean();
            }
            if( ! @ $br_options['woocommerce_removes']['pagination'] ) {
                ob_start();
                woocommerce_pagination();
                $_RESPONSE['pagination'] = ob_get_contents();
                ob_end_clean();
            }
        }
        
        if( @ $br_options['recount_products']) {
            $_RESPONSE['attributesname'] = array();
            $_RESPONSE['attributes'] = array();
            if(is_array(@$_POST['attributes'])) {
                $attributes = array_combine ( $_POST['attributes'], $_POST['cat_limit'] );
                foreach( $attributes as $attribute => $cat_limit ) {
                    if($attribute == 'price') {
                    } else {
                        $terms = FALSE;
                        if( $attribute == '_stock_status' ) {
                            $terms = array();
                            array_push($terms, (object)array('term_id' => '1', 'name' => __('In stock', 'BeRocket_AJAX_domain'), 'slug' => 'instock', 'taxonomy' => '_stock_status', 'count' => 1));
                            array_push($terms, (object)array('term_id' => '2', 'name' => __('Out of stock', 'BeRocket_AJAX_domain'), 'slug' => 'outofstock', 'taxonomy' => '_stock_status', 'count' => 1));
                        }
                        $_RESPONSE['attributesname'][] = $attribute;
                        $terms = BeRocket_AAPF_Widget::get_attribute_values( $attribute, 'id', ( ! @ $br_options['show_all_values'] ), TRUE, $terms, $cat_limit );
                        $_RESPONSE['attributes'][] = $terms;
                    }
                }
            }
        }
        $_RESPONSE = apply_filters('berocket_ajax_response_without_fix', $_RESPONSE);
        echo json_encode( $_RESPONSE );

        die();
    }

    /**
     * Widget ajax listener
     */
    public static function listener_product_count(){
        global $wp_query, $wp_rewrite;
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );

        $wp_query = self::listener_wp_query();

        $product_count = $wp_query->found_posts;
        
        echo json_encode( array( 'product_count' => $product_count ) );

        die();
    }

    public static function listener_wp_query() {
        global $wp_query, $wp_rewrite;
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );

        if ( @ $_POST['terms'] ) {
            if ( @ $br_options['slug_urls'] ) {
                foreach ( $_POST['terms'] as $post_key => $t ) {
                    if( $t[0] == 'price' ) {
                        if( preg_match( "~\*~", $t[1] ) ) {
                            if( ! isset( $_POST['price_ranges'] ) ) {
                                $_POST['price_ranges'] = array();
                            }
                            $_POST['price_ranges'][] = $t[1];
                            unset( $_POST['terms'][$post_key] );
                        }
                    } elseif( $t[0] == '_stock_status' ) {
                        $_stock_status = array( 'instock' => 1, 'outofstock' => 2);
                        $t[1] = @ $_stock_status[$t[1]];
                    } else {
                        $t[1] = get_term_by( 'slug', $t[3], $t[0] );
                        $t[1] = $t[1]->term_id;
                        $_POST['terms'][$post_key] = $t;
                    }
                }
            } else {
                foreach ( $_POST['terms'] as $post_key => $t ) {
                    if( $t[0] == 'price' ) {
                        if( preg_match( "~\*~", $t[1] ) ) {
                            if( ! isset( $_POST['price_ranges'] ) ) {
                                $_POST['price_ranges'] = array();
                            }
                            $_POST['price_ranges'][] = $t[1];
                            unset( $_POST['terms'][$post_key] );
                        }
                    }
                }
            }
        }

        add_filter( 'post_class', array( __CLASS__, 'add_product_class' ) );
        add_filter( 'woocommerce_pagination_args', array( __CLASS__, 'pagination_args' ) );

        $woocommerce_hide_out_of_stock_items = BeRocket_AAPF_Widget::woocommerce_hide_out_of_stock_items();

        $meta_query = BeRocket_AAPF::remove_out_of_stock( array() , true, $woocommerce_hide_out_of_stock_items != 'yes' );

        $args = apply_filters( 'berocket_aapf_listener_wp_query_args', array() );
        $args['post__in'] = array();

        if( $woocommerce_hide_out_of_stock_items == 'yes' ) {
            $args['post__in'] = BeRocket_AAPF::remove_out_of_stock( $args['post__in'] );
        }
        $args['post__in'] = BeRocket_AAPF::remove_hidden( $args['post__in'] );
        $args['meta_query'] = $meta_query;

        $args['post__in']       = BeRocket_AAPF::limits_filter( $args['post__in'] );
        $args['post__in']       = BeRocket_AAPF::price_filter( $args['post__in'] );
        $args['post_status']    = 'publish';
        $args['post_type']      = 'product';
        $default_posts_per_page = get_option( 'posts_per_page' );
        $args['posts_per_page'] = apply_filters( 'loop_shop_per_page', $default_posts_per_page );
        if ( @ $_POST['price_ranges'] ) {
            $price_range_query = array( 'relation' => 'OR' );
            foreach ( $_POST['price_ranges'] as $range ) {
                $range = explode( '*', $range );
                $price_range_query[] = array( 'key' => '_price', 'compare' => 'BETWEEN', 'type' => 'NUMERIC', 'value' => array( ($range[0] - 1), $range[1] ) );
            }
            $args['meta_query'][] = $price_range_query;
        }

        if( isset($_POST['product_taxonomy']) && $_POST['product_taxonomy'] != '-1' && strpos( $_POST['product_taxonomy'], '|' ) !== FALSE ) {
            $product_taxonomy = explode( '|', $_POST['product_taxonomy'] );
            $args['taxonomy'] = $product_taxonomy[0];
            $args['term'] = $product_taxonomy[1];
        }

        $wp_query = new WP_Query( $args );

        // here we get max products to know if current page is not too big
        $is_using_permalinks = $wp_rewrite->using_permalinks();
        if ( $is_using_permalinks and preg_match( "~/page/([0-9]+)~", $_POST['location'], $mathces ) or preg_match( "~paged?=([0-9]+)~", $_POST['location'], $mathces ) ) {
            $args['paged'] = min( $mathces[1], $wp_query->max_num_pages );
            $wp_query      = new WP_Query( $args );
        }
        return $wp_query;
    }

    public static function rebuild() {
        add_action('woocommerce_before_shop_loop', array( __CLASS__, 'tags_restore' ), 999999);
    }

    public static function tags_restore() {
		global $wp_query;
        $args = apply_filters( 'berocket_aapf_listener_wp_query_args', array() );
        $tags = @ $args['product_tag'];
        if( @ $tags ) {
            $q_vars = $wp_query->query_vars;
            $q_vars['product_tag'] = $tags;
            $q_vars['taxonomy'] = '';
            $q_vars['term'] = '';
            unset( $q_vars['s'] );
            $wp_query = new WP_Query( $q_vars );
        }
    }

    public static function woocommerce_before_main_content() {
        ?>||EXPLODE||<?php
        self::tags_restore();
    }

    public static function woocommerce_after_main_content() {
        ?>||EXPLODE||<?php
    }

    public static function pre_get_posts() {
        add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'woocommerce_before_main_content' ), 999999 );
        add_action( 'woocommerce_after_shop_loop', array( __CLASS__, 'woocommerce_after_main_content' ), 1 );
    }

    public static function end_clean() {
        global $wp_query, $wp_rewrite;
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );
        if ( $br_options['ajax_request_load_style'] != 'js' ) {
            $_RESPONSE['products'] = explode('||EXPLODE||', ob_get_contents());
            $_RESPONSE['products'] = $_RESPONSE['products'][1];
            ob_end_clean();

            if ( $_RESPONSE['products'] == null ) {
	            unset( $_RESPONSE['products'] );
	            ob_start();
                echo apply_filters( 'berocket_aapf_listener_no_products_message', "<p class='no-products woocommerce-info" . ( ( $br_options['no_products_class'] ) ? ' '.$br_options['no_products_class'] : '' ) . "'>" . $br_options['no_products_message'] . "</p>" );
                $_RESPONSE['no_products'] = ob_get_contents();
                ob_end_clean();
            } else {
                $_RESPONSE['products'] = str_replace( 'explode=explode#038;', '', $_RESPONSE['products'] );
                $_RESPONSE['products'] = str_replace( '&#038;explode=explode', '', $_RESPONSE['products'] );
                $_RESPONSE['products'] = str_replace( '?explode=explode', '', $_RESPONSE['products'] );
            }
        }

        if ( @ $br_options['recount_products'] ) {
            $_RESPONSE['attributesname'] = array();
            $_RESPONSE['attributes']     = array();

            if ( is_array( @ $_POST['attributes'] ) ) {
                $attributes = array_combine ( $_POST['attributes'], $_POST['cat_limit'] );
                foreach ( $attributes as $attribute => $cat_limit ) {
                    if ( $attribute == 'price' ) {
                    } else {
                        $terms = FALSE;
                        if( $attribute == '_stock_status' ) {
                            $terms = array();
                            array_push($terms, (object)array('term_id' => '1', 'name' => __('In stock', 'BeRocket_AJAX_domain'), 'slug' => 'instock', 'taxonomy' => '_stock_status', 'count' => 1));
                            array_push($terms, (object)array('term_id' => '2', 'name' => __('Out of stock', 'BeRocket_AJAX_domain'), 'slug' => 'outofstock', 'taxonomy' => '_stock_status', 'count' => 1));
                        }
                        $_RESPONSE['attributesname'][] = $attribute;
                        $terms                         = BeRocket_AAPF_Widget::get_attribute_values( $attribute, 'id', ( ! @ $br_options['show_all_values'] ), TRUE, $terms, $cat_limit );
                        $_RESPONSE['attributes'][]     = $terms;
                    }
                }
            }
        }
        if( ! @ $br_options['woocommerce_removes']['ordering'] ) {
            ob_start();
            woocommerce_catalog_ordering();
            $_RESPONSE['catalog_ordering'] = ob_get_contents();
            ob_end_clean();
        }
        if( ! @ $br_options['woocommerce_removes']['result_count'] ) {
            ob_start();
            woocommerce_result_count();
            $_RESPONSE['result_count'] = ob_get_contents();
            ob_end_clean();
        }
        if( ! @ $br_options['woocommerce_removes']['pagination'] ) {
            ob_start();
            woocommerce_pagination();
            $_RESPONSE['pagination'] = ob_get_contents();
            $_RESPONSE['pagination'] = str_replace( 'explode=explode#038;', '', @ $_RESPONSE['pagination'] );
            $_RESPONSE['pagination'] = str_replace( '&#038;explode=explode', '', @ $_RESPONSE['pagination'] );
            $_RESPONSE['pagination'] = str_replace( '?explode=explode', '', @ $_RESPONSE['pagination'] );
            ob_end_clean();
        }
        if ( $br_options['ajax_request_load_style'] == 'js' ) echo '||JSON||';
        $_RESPONSE = apply_filters('berocket_ajax_response_with_fix', $_RESPONSE);
        echo json_encode( $_RESPONSE );
        if ( $br_options['ajax_request_load_style'] == 'js' ) echo '||JSON||';

        die();
    }

    public static function start_clean() {
        $br_options = apply_filters( 'berocket_aapf_listener_br_options', BeRocket_AAPF::get_aapf_option() );
        if ( $br_options['ajax_request_load_style'] != 'js' ) {
            ob_start();
        }
    }

    public static function color_listener() {
        if ( defined('DOING_AJAX') && DOING_AJAX && !isset( $_POST ['tax_color_set'] ) && isset( $_POST ['br_widget_color'] ) ) {
            $_POST ['tax_color_set'] = $_POST ['br_widget_color'];
        }
        if( isset( $_POST ['tax_color_set'] ) ) {
            if ( current_user_can( 'manage_options' ) ) {
                foreach( $_POST['tax_color_set'] as $key => $value ) {
                    update_metadata( 'berocket_term', $key, $_POST['type'], $value );
                }
                unset( $_POST['tax_color_set'] );
            }
        } else {
            BeRocket_AAPF_Widget::color_list_view( $_POST['type'], $_POST['tax_color_name'], true );
            wp_die();
        }
    }

    public static function color_list_view( $type, $taxonomy_name, $load_script = false ) {
        $terms = get_terms( $taxonomy_name, array( 'hide_empty' => false ) );
        set_query_var( 'terms', $terms );
        set_query_var( 'type', $type );
        set_query_var( 'load_script', $load_script );
        br_get_template_part( 'color_ajax' );
    }
    
    public static function ajax_include_exclude_list() {
        if( ! empty($_POST['taxonomy_name']) ) {
            echo self::include_exclude_terms_list($_POST['taxonomy_name']);
        }
        wp_die();
    }
    
    public static function include_exclude_terms_list($taxonomy_name = false, $selected = array() ) {
        $terms = get_terms( $taxonomy_name, array( 'hide_empty' => false ) );
        set_query_var( 'taxonomy', $taxonomy_name );
        set_query_var( 'terms', $terms );
        set_query_var( 'selected', $selected );
        ob_start();
        br_get_template_part( 'include_exclude_list' );
        return ob_get_clean();
    }

    public static function get_product_categories( $current_product_cat = '', $parent = 0, $data = array(), $depth = 0, $max_count = 9, $follow_hierarchy = false ) {
        return br_get_sub_categories( $parent, 'id', array( 'return' => 'hierarchy_objects', 'max_depth' => $max_count ) );
    }

    public static function add_product_class( $classes ) {
        $classes[] = 'product';
        return apply_filters( 'berocket_aapf_add_product_class', $classes );
    }

    public static function pagination_args( $args = array() ) {
        $args['base'] = str_replace( 999999999, '%#%', self::get_pagenum_link( 999999999 ) );
        return $args;
    }

    // 99% copy of WordPress' get_pagenum_link.
    public static function get_pagenum_link( $pagenum = 1, $escape = true ) {
        global $wp_rewrite;

        $pagenum = (int) $pagenum;

        $request = remove_query_arg( 'paged', preg_replace( "~".home_url()."~", "", @$_POST['location'] ) );

        $home_root = parse_url( home_url() );
        $home_root = ( isset( $home_root['path'] ) ) ? $home_root['path'] : '';
        $home_root = preg_quote( $home_root, '|' );

        $request = preg_replace( '|^' . $home_root . '|i', '', $request );
        $request = preg_replace( '|^/+|', '', $request );

        $is_using_permalinks = $wp_rewrite->using_permalinks();
        if ( ! $is_using_permalinks ) {
            $base = trailingslashit( get_bloginfo( 'url' ) );

            if ( $pagenum > 1 ) {
                $result = add_query_arg( 'paged', $pagenum, $base . $request );
            } else {
                $result = $base . $request;
            }
        } else {
            $qs_regex = '|\?.*?$|';
            preg_match( $qs_regex, $request, $qs_match );

            if ( ! empty( $qs_match[0] ) ) {
                $query_string = $qs_match[0];
                $request      = preg_replace( $qs_regex, '', $request );
            } else {
                $query_string = '';
            }

            $request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request );
            $request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request );
            $request = ltrim( $request, '/' );

            $base = trailingslashit( get_bloginfo( 'url' ) );

            $is_using_index_permalinks = $wp_rewrite->using_index_permalinks();
            if ( $is_using_index_permalinks && ( $pagenum > 1 || '' != $request ) )
                $base .= $wp_rewrite->index . '/';

            if ( $pagenum > 1 ) {
                $request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
            }

            $result = $base . $request . $query_string;
        }

        /**
         * Filter the page number link for the current request.
         *
         * @since 2.5.0
         *
         * @param string $result The page number link.
         */
        $result = apply_filters( 'get_pagenum_link', $result );

        if ( $escape )
            return esc_url( $result );
        else
            return esc_url_raw( $result );
    }

    public static function get_terms_child_parent ( $child_parent, $attribute, $current_terms = FALSE, $child_parent_depth = 1 ) {
        if ( @ $child_parent == 'parent' ) {
            $args_terms = array(
                'orderby'    => 'id',
                'order'      => 'ASC',
                'hide_empty' => false,
                'parent'     => 0,
            );
            if( $attribute == 'product_cat' ) {
                $current_terms = self::get_product_categories( '', 0, array(), 0, 0, true );
            } else {
                $current_terms = get_terms( $attribute, $args_terms );
            }
        }
        if ( @ $child_parent == 'child' ) {
            $current_terms = array( (object) array( 'depth' => 0, 'child' => 0, 'term_id' => 'R__term_id__R', 'count' => 'R__count__R', 'slug' => 'R__slug__R', 'name' => 'R__name__R', 'taxonomy' => 'R__taxonomy__R' ) );
            $selected_terms = br_get_selected_term( $attribute );
            $selected_terms_id = array();
            foreach( $selected_terms as $selected_term ) {
                $ancestors = get_ancestors( $selected_term, $attribute );
                if( count( $ancestors ) >= ( @ $child_parent_depth - 1 ) ) {
                    if( count( $ancestors ) > ( @ $child_parent_depth - 1 ) ) {
                        $selected_term = $ancestors[count( $ancestors ) - ( @ $child_parent_depth )];
                    }
                    if ( ! in_array( $selected_term, $selected_terms_id ) ) {
                        $args_terms = array(
                            'orderby'    => 'id',
                            'order'      => 'ASC',
                            'hide_empty' => false,
                            'parent'     => $selected_term,
                        );
                        $selected_terms_id[] = $selected_term;
                        $additional_terms = get_terms( $attribute, $args_terms );
                        $current_terms = array_merge( $current_terms, $additional_terms );
                    }
                }
            }
        }
        return $current_terms;
    }
    public static function is_parent_selected($attribute, $child_parent_depth = 1) {
        $selected_terms = br_get_selected_term( $attribute );
        $selected_terms_id = array();
        foreach( $selected_terms as $selected_term ) {
            $ancestors = get_ancestors( $selected_term, $attribute );
            if( count( $ancestors ) > ( @ $child_parent_depth - 1 ) ) {
                return true;
            }
        }
        return false;
    }
    public static function old_wc_compatible($query, $new = false) {
        global $br_old_wp_query;
        if( ! isset($br_old_wp_query) ) {
            if( ! $new ) {
                $query = BeRocket_AAPF::apply_user_price( $query, true );
                $query = BeRocket_AAPF::apply_user_filters( $query, true );
                $query_vars = $query->query_vars;
            } else {
                $query_vars = array();
            }
            $query_vars['posts__in'] = apply_filters('loop_shop_post_in', array());
            $br_old_wp_query = $query_vars;
        }
        return $br_old_wp_query;
    }

}

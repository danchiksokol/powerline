<?php
$random_name = rand();
$hiden_value = false;
$is_child_parent = @ $child_parent == 'child';
$is_child_parent_or = ( @ $child_parent == 'child' || @ $child_parent == 'parent' );
if ( ! @ $child_parent_depth || @ $child_parent == 'parent' ) {
    $child_parent_depth = 0;
}
$is_first = true;
if ( @ $terms ) {
    foreach ( $terms as $term ) {
        $meta_class = ( ( @ $show_product_count_per_attr ) ? $term->count : '&nbsp;' );
        $meta_after = '';
        if ( !$is_child_parent || !$is_first ) {
            $meta_color = get_metadata( 'berocket_term', $term->term_id, $type );
        } else {
            $meta_color = 'R';
            ?>
            <li class="berocket_child_parent_sample"><ul>
            <?php
        }
        if( $type == 'color' ) {
            $meta_color = 'background-color: #'.@ $meta_color[0].';';
        } elseif( $type == 'image' ) {
            if ( @ $meta_color[0] ) {
                if ( substr( $meta_color[0], 0, 3) == 'fa-' ) {
                    $meta_class = '<i class="fa '.$meta_color[0].'"></i>&nbsp;';
                    $meta_color = '';
                } else {
                    $meta_color = 'background: url('.$meta_color[0].') no-repeat scroll 50% 50% rgba(0, 0, 0, 0);';
                    $meta_class = '&nbsp;';
                }
                $meta_after = ( ( @ $show_product_count_per_attr ) ? '<span class="berocket_aapf_count">'.$term->count.'</span>' : '' );
            } else {
                $meta_color = '';
                $meta_class = '';
            }
        }
        ?>
        <li class="<?php if ( $is_child_parent ) echo 'R__class__R '; ?><?php if( @ $hide_o_value && isset($term->count) && $term->count == 0 && ( !$is_child_parent || !$is_first ) ) { echo 'berocket_hide_o_value '; $hiden_value = true; }  if( @ $hide_sel_value && @ br_is_term_selected( $term, true, $is_child_parent_or, $child_parent_depth ) != '' ) { echo 'berocket_hide_sel_value'; $hiden_value = true; } ?> berocket_checkbox_color<?php echo ( ( ( @ $use_value_with_color ) ? ' berocket_color_with_value' : ' berocket_color_without_value' ) ) ?>">
            <span>
                <input class="checkbox_<?php echo @ $term->term_id ?>" autocomplete="off"
                       style="<?php echo @ $uo['style']['checkbox_radio'] ?>"
                       type='checkbox' id='checkbox_<?php echo @ $term->term_id ?>_<?php echo @ $random_name ?>' <?php if( @ $term->term_id) { ?>data-term_id='<?php echo @ $term->term_id ?>'<?php } ?>
                       data-term_slug='<?php echo @ urldecode($term->slug) ?>' data-filter_type='<?php echo @ $filter_type ?>' data-operator='<?php echo @ $operator ?>'
                       data-taxonomy='<?php echo @ $term->taxonomy ?>'
                       data-taxonomy-type='color'
                       <?php echo @ br_is_term_selected( $term, true, $is_child_parent_or, $child_parent_depth );?> />
                <label data-for='checkbox_<?php echo @ $term->term_id ?>' class="berocket_label_widgets<?php if( br_is_term_selected( $term, true, $is_child_parent_or, $child_parent_depth ) != '') echo ' berocket_checked'; ?>">
                    <span class="berocket_color_span_block <?php if( ! @ $meta_after ) echo 'berocket_aapf_count'; ?>" style="<?php echo $meta_color; ?>"><?php echo $meta_class; ?></span>
                    <?php echo ( ( ( @ $use_value_with_color ) ? '<span class="berocket_color_text">' . ( ( @ $icon_before_value ) ? ( ( substr( $icon_before_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_before_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_before_value.'" alt=""></i>' ) : '' ) . $term->name . ( ( @ $icon_after_value ) ? ( ( substr( $icon_after_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_after_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_after_value.'" alt=""></i>' ) : '' ) . '</span>' : '' ) ) ?><?php echo @ $meta_after; ?>
                </label>
            </span>
        </li>
        <?php
        if ( $is_child_parent && $is_first ) {
            ?>
            </ul></li>
            <?php
            $is_first = false;
        }
    } ?>
    <?php if( $is_child_parent && @ count($terms) == 1 ) {
        if( BeRocket_AAPF_Widget::is_parent_selected($attribute, $child_parent_depth - 1) ) {
            echo '<li>'.$child_parent_no_values.'</li>';
        } else {
            echo '<li>'.$child_parent_previous.'</li>';
        }
    } else {
    if( $child_parent_no_values ) {?>
        <script>
        if ( typeof(child_parent_depth) == 'undefined' || child_parent_depth < <?php echo $child_parent_depth; ?> ) {
            child_parent_depth = <?php echo $child_parent_depth; ?>;
        }
        jQuery(document).ready(function() {
            if( child_parent_depth == <?php echo $child_parent_depth; ?> ) {
                jQuery('.woocommerce-info').text('<?php echo $child_parent_no_values; ?>');
            }
        });
        </script>
    <?php }
    } ?>
        <li class="berocket_widget_show_values"<?php if( !$hiden_value ) echo 'style="display: none;"' ?>><?php _e('Show value(s)', 'BeRocket_AJAX_domain') ?><span class="show_button"></span></li>
    <div style="clear: both;"></div>
<?php } ?>
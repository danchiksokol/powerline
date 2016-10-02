<?php
/**
 * The template for displaying checkbox filters
 *
 * Override this template by copying it to yourtheme/woocommerce-filters/checkbox.php
 *
 * @author     BeRocket
 * @package     WooCommerce-Filters/Templates
 * @version  1.0.1
 */
$is_child_parent = @ $child_parent == 'child';
$is_child_parent_or = ( @ $child_parent == 'child' || @ $child_parent == 'parent' );
if ( ! @ $child_parent_depth || @ $child_parent == 'parent' ) {
    $child_parent_depth = 0;
}
$is_first = true;
$random_name = rand();
if ( $is_child_parent ) {
?>
<li class="berocket_child_parent_sample select"><ul>
    <span>
        <ul id='checkbox_<?php echo @ $terms[0]->term_id ?>_<?php echo @ $random_name ?>'
                class="<?php echo @ $uo['class']['selectbox'] ?> <?php echo @ $terms[0]->taxonomy ?>"
                data-taxonomy='<?php echo @ $terms[0]->taxonomy ?>'>
                <li data-taxonomy='<?php echo @ $terms[0]->taxonomy ?>' value=''><?php _e('Any', 'BeRocket_AJAX_domain') ?></li>
            <?php $term = $terms[0]; ?>
                <li value='<?php echo @ $term->term_id ?>' data-term_id='<?php echo @ $term->term_id ?>' autocomplete="off"
                        data-taxonomy='<?php echo @ $term->taxonomy ?>'
                        data-term_count='<?php echo @ $term->count ?>' 
                        data-term_slug='<?php echo @ urldecode($term->slug) ?>' data-filter_type='<?php echo @ $filter_type ?>'
                        data-term_name='<?php echo @ $term->name ?>' class="select_<?php echo @ $term->term_id ?>"
                        data-operator='<?php echo @ $operator ?>'
                    <?php echo @ br_is_term_selected( $term, false, $is_child_parent_or, $child_parent_depth ); ?>
                    ><?php echo @ $term->name . ( ( @ $show_product_count_per_attr ) ? ' (' . $term->count . ')' : '' ) ?></li>
        </ul>
    </span>
</ul></li>
<?php 
unset($terms[0]);
} 
    if( $is_child_parent && @ count($terms) == 0 ) {
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
    }
if ( count( $terms ) > 0 ) {
?>
<li>
    <span>
        <select id='checkbox_<?php echo @ $terms[0]->term_id ?>_<?php echo @ $random_name ?>' autocomplete="off"
                class="<?php echo @ $uo['class']['selectbox'] ?> <?php echo @ $terms[0]->taxonomy ?>"
                data-taxonomy='<?php echo @ $terms[0]->taxonomy ?>'>
            <option data-taxonomy='<?php echo @ $terms[0]->taxonomy ?>' value=''><?php _e('Any', 'BeRocket_AJAX_domain') ?></option>
            <?php foreach ( $terms as $term ): ?>
                <option value='<?php echo @ $term->term_id ?>' data-term_id='<?php echo @ $term->term_id ?>'
                        data-taxonomy='<?php echo @ $term->taxonomy ?>'
                        data-term_count='<?php echo @ $term->count ?>' 
                        data-term_slug='<?php echo @ urldecode($term->slug) ?>' data-filter_type='<?php echo @ $filter_type ?>'
                        data-term_name='<?php echo @ $term->name ?>' class="select_<?php echo @ $term->term_id ?><?php if( @ $hide_o_value && isset($term->count) && $term->count == 0 ) { echo ' berocket_hide_o_value'; $hiden_value = true; } ?>"
                        data-operator='<?php echo @ $operator ?>'
                    <?php echo @ br_is_term_selected( $term, false, $is_child_parent_or, $child_parent_depth ); ?>
                    ><?php echo @ $term->name . ( ( @ $show_product_count_per_attr ) ? ' (' . $term->count . ')' : '' ) ?></option>
            <?php endforeach; ?>
        </select>
    </span>
</li>
<?php } ?>
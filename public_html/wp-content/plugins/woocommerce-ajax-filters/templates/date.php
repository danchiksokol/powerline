<?php 
$rand = 'br_date_'.rand();
	
$query = new WP_Query( array(
    'post_type'         => 'product',
    'posts_per_page'    => 1,
    'order'             => 'ASC',
    'orderby'           => 'date'
) );
$datetime = strtotime('-30 days');
if( $query->have_posts() ) {
    $datetime = new DateTime($query->posts[0]->post_date);
    $datetime = $datetime->getTimestamp();
}

$slider_value1 = date('m/d/Y', $datetime);
$slider_value2 = date('m/d/Y', strtotime('+1 day'));
$default_1 = $slider_value1;
$default_2 = $slider_value2;
if ( @ $_POST['limits'] ) {
    foreach ( $_POST['limits'] as $p_limit ) {
        if ( $p_limit[0] == 'pa_date' ) {
            $slider_value1 = $p_limit[1];
            $slider_value2 = $p_limit[2];
        }
    }
}
?>
<li class="berocket_datepicker_fields field_1">
    <input class="br_date_filter br_start_date <?php echo $rand; ?>" data-taxonomy="date" data-term="start" data-default="<?php echo $default_1; ?>" value="<?php echo $slider_value1; ?>">
</li>
<li class="berocket_datepicker_fields field_2">
    <input class="br_date_filter br_end_date <?php echo $rand; ?>" data-taxonomy="date" data-term="end" data-default="<?php echo $default_2; ?>" value="<?php echo $slider_value2; ?>">
</li>
<li style="clear:both;">
    <div class="berocket_date_picker <?php echo $rand; ?>" 
    data-taxonomy="_date" 
    data-min="<?php echo $default_1; ?>" data-max="<?php echo $default_2; ?>" 
    data-value_1="<?php echo $slider_value1; ?>" data-value_2="<?php echo $slider_value2; ?>"
    data-value1="<?php echo str_replace('/', '', $slider_value1); ?>" data-value2="<?php echo str_replace('/', '', $slider_value2); ?>"
    data-term_slug="" data-step="1" 
    data-all_terms_name="null" 
    data-all_terms_slug="null"
    data-child_parent="" 
    data-child_parent_depth="1"
    data-fields_2="<?php echo $rand; ?>"></div>
</li>
<script>
    jQuery(document).ready(function() {
        jQuery( '.br_date_filter.<?php echo $rand; ?>' ).datepicker({
            dateFormat: 'mm/dd/yy',
            minDate: '<?php echo $default_1; ?>',
            maxDate: '<?php echo $default_2; ?>'
        });
    });
</script>
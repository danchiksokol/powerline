<?php $unique = rand( 0, time() ); 
$is_child_parent = @ $child_parent == 'child';
$is_child_parent_or = ( @ $child_parent == 'child' || @ $child_parent == 'parent' );
if ( $is_child_parent ) {
    ?>
<li class="berocket_child_parent_sample"><ul>
<li class='<?php echo @ $main_class ?>'>
    <span class='left'>
        <?php echo ( ( @ $icon_before_value ) ? ( ( substr( $icon_before_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_before_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_before_value.'" alt=""></i>' ) : '' ) . @ $text_before_price ?>
                   <input type='text' disabled id='R__slug__R_<?php echo $unique; ?>_1'
                                                 value='<?php echo @ $slider_value1 ?>'
                                                 style="<?php echo @ $uo['style']['slider_input']?>"
        /><?php echo @ $text_after_price . ( ( @ $icon_after_value ) ? ( ( substr( $icon_after_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_after_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_after_value.'" alt=""></i>' ) : '' ) ?>
    </span>
    <span class='right'>
        <?php echo ( ( @ $icon_before_value ) ? ( ( substr( $icon_before_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_before_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_before_value.'" alt=""></i>' ) : '' ) . @ $text_before_price ?>
                  <input type='text' disabled id='R__slug__R_<?php echo $unique; ?>_2'
                                                 value='<?php echo @ $slider_value2 ?>'
                                                 style="<?php echo @ $uo['style']['slider_input']?>"
        /><?php echo @ $text_after_price . ( ( @ $icon_after_value ) ? ( ( substr( $icon_after_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_after_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_after_value.'" alt=""></i>' ) : '' ) ?>
    </span>
    <div class='slide <?php echo @ $uo['class']['slider'] ?>'>
        <div class='<?php echo @ $slider_class ?>' data-taxonomy='<?php echo @ $filter_slider_id ?>'
            data-min='R__min__R' data-max='R__max__R'
            data-value1='R__value1__R' data-value2='R__value2__R'
            data-value_1='R__value1__R' data-value_2='R__value2__R'
            data-term_slug='<?php echo @ urldecode($term->slug) ?>' data-filter_type='<?php echo @ $filter_type ?>'
            data-step='<?php echo @ $step ?>' data-all_terms_name='R__allterm__R'
            data-all_terms_slug='R__sallterm__R'
            data-child_parent="<?php if ( $is_child_parent_or ) echo $child_parent ;?>"
            data-child_parent_depth="<?php if ( @ $child_parent_depth ) echo $child_parent_depth ;?>"
            data-fields_1='R__slug__R_<?php echo $unique; ?>_1'
            data-fields_2='R__slug__R_<?php echo $unique; ?>_2'></div>
    </div>
</li>
</ul></li>
<?php 
while ( isset( $all_terms_name[0] ) && $all_terms_name[0] == 'R__name__R' ) {
    array_splice( $all_terms_name, 0, 1 );
    @ $max--;
    $slider_value1--;
    $slider_value2--;
}
} 
if( !$is_child_parent || count( $all_terms_name ) > 0 ) {
?>
<li class='<?php echo @ $main_class ?>'>
    <span class='left'>
        <?php echo ( ( @ $icon_before_value ) ? ( ( substr( $icon_before_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_before_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_before_value.'" alt=""></i>' ) : '' ) . @ $text_before_price ?>
                   <input type='text' disabled id='text_<?php echo @ $filter_slider_id . $unique ?>_1'
                                                 value='<?php echo @ $slider_value1 ?>'
                                                 style="<?php echo @ $uo['style']['slider_input']?>"
        /><?php echo @ $text_after_price . ( ( @ $icon_after_value ) ? ( ( substr( $icon_after_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_after_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_after_value.'" alt=""></i>' ) : '' ) ?>
    </span>
    <span class='right'>
        <?php echo ( ( @ $icon_before_value ) ? ( ( substr( $icon_before_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_before_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_before_value.'" alt=""></i>' ) : '' ) . @ $text_before_price ?>
                  <input type='text' disabled id='text_<?php echo @ $filter_slider_id . $unique ?>_2'
                                                 value='<?php echo @ $slider_value2 ?>'
                                                 style="<?php echo @ $uo['style']['slider_input']?>"
        /><?php echo @ $text_after_price . ( ( @ $icon_after_value ) ? ( ( substr( $icon_after_value, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_after_value.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_after_value.'" alt=""></i>' ) : '' ) ?>
    </span>
    <div class='slide <?php echo @ $uo['class']['slider'] ?>'>
        <div class='<?php echo @ $slider_class ?>' data-taxonomy='<?php echo @ $filter_slider_id ?>'
            data-min='<?php echo @ $min ?>' data-max='<?php echo @ $max ?>'
            data-value1='<?php echo @ $slider_value1 ?>' data-value2='<?php echo @ $slider_value2 ?>'
            data-value_1='<?php echo @ $slider_value1 ?>' data-value_2='<?php echo @ $slider_value2 ?>'
            data-term_slug='<?php echo @ urldecode($term->slug) ?>' data-filter_type='<?php echo @ $filter_type ?>'
            data-step='<?php echo @ $step ?>' data-all_terms_name='<?php echo @ json_encode($all_terms_name); ?>'
            data-all_terms_slug='<?php echo @ json_encode($all_terms_slug); ?>'
            data-child_parent="<?php if ( $is_child_parent_or ) echo $child_parent ;?>"
            data-child_parent_depth="<?php if ( @ $child_parent_depth ) echo $child_parent_depth ;?>"
            data-fields_1='text_<?php echo @ $filter_slider_id . $unique ?>_1'
            data-fields_2='text_<?php echo @ $filter_slider_id . $unique ?>_2'></div>
    </div>
</li>
<?php } ?>
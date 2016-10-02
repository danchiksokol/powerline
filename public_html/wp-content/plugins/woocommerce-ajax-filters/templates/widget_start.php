<?php
$is_child_parent = @ $child_parent == 'child';
?>
<div class="berocket_aapf_widget-wrapper">
    <?php if( $is_child_parent ) { ?>
    <div class="berocket_child_no_values">
        <?php echo @ $child_parent_no_values; ?>
    </div>
    <div class="berocket_child_previous">
        <?php echo @ $child_parent_previous; ?>
    </div>
    <div class="berocket_child_no_products">
        <?php echo @ $child_parent_no_products; ?>
    </div>
    <?php } ?>
    <div class="berocket_aapf_widget-title_div<?php if ( @ $is_hide_mobile ) echo ' berocket_aapf_hide_mobile' ?>">
        <?php if ( ! @ $hide_collapse_arrow ) { ?>
            <span class="berocket_aapf_widget_show <?php echo ( ( @ $widget_is_hide ) ? 'show_button' : 'hide_button' ) ?> <?php echo ( ( @ $title ) ? 'mobile_hide' : '' ) ?>"><i class="fa fa-angle-left "></i></span>
        <?php } ?>
        <?php if ( @ $description ) { ?><span class="berocket_aapf_description"><i class="fa fa-info-circle"></i><div style="background-color:#<?php echo @$notuo['description']['color'].'; border:1px solid #'.@$notuo['description_border']['color'].';'?>"><h3 style="<?php echo @$uo['style']['description_title']?>"><?php echo @$title; ?></h3><p style="<?php echo @$uo['style']['description_text']?>"><?php echo $description ?></p><div class="berocket_aapf_description_arrow"  style="background-color:#<?php echo @$notuo['description']['color'].'; border:1px solid #'.@$notuo['description_border']['color'].';'?>"></div></div></span><?php } ?>
        <?php if( @ $title || @ $icon_before_title || @ $icon_after_title ) { ?><h3 class="widget-title berocket_aapf_widget-title" style="<?php echo @ $uo['style']['title'] ?>"><span><?php echo ( ( @ $icon_before_title ) ? ( ( substr( $icon_before_title, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_before_title.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_before_title.'" alt=""></i>' ) : '' ).@ $title.( ( @ $icon_after_title ) ? ( ( substr( $icon_after_title, 0, 3) == 'fa-' ) ? '<i class="fa '.$icon_after_title.'"></i>' : '<i class="fa"><img class="berocket_widget_icon" src="'.$icon_after_title.'" alt=""></i>' ) : '' ) ?></span></h3><?php } ?>
    </div>
    <ul class='berocket_aapf_widget <?php echo @ $product_count_style; ?> <?php if( @ $child_parent == 'child' ) echo $attribute.'_'.$child_parent.'_'.@ $child_parent_depth; ?> <?php if( @ $values_per_row ) echo 'berocket_values_'.$values_per_row; ?><?php if ( @ $is_hide_mobile ) echo ' berocket_aapf_hide_mobile' ?> <?php echo @ $class ?> <?php echo @ $css_class ?> <?php echo ( ( @ $type == 'tag_cloud' ) ? 'berocket_aapf_widget-tag_cloud' : '' ) ?>'
        <?php echo @ $style ?> data-scroll_theme='<?php echo @ $scroll_theme ?>' data-child_parent="<?php echo @ $child_parent; ?>" <?php if( @ $child_parent == 'child' ) echo 'data-child_parent_depth="'.@ $child_parent_depth.'"'; ?>
        data-attribute='<?php echo $attribute; ?>' data-type='<?php echo $type; ?>' data-count_show='<?php if( @ $show_product_count_per_attr ) echo 'show' ?>' data-cat_limit='<?php echo @ $cat_value_limit;  ?>'
        <?php echo ( ( @ $widget_is_hide ) ? 'style="display:none;"' : 'style="display:block;"' ) ?>>
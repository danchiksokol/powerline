<div class="<?php echo ( ( @ $is_hooked ) ? 'berocket_aapf_selected_area_hook' : 'berocket_aapf_widget-wrapper' ); ?> berocket_aapf_selected_area_block">
    <?php if ( ! @ $is_hooked ) { ?>
    <div class="berocket_aapf_widget-title_div<?php if ( @ $is_hide_mobile ) echo ' berocket_aapf_hide_mobile' ?>">
        <?php if ( ! @ $hide_selected_arrow ) { ?>
            <span class="berocket_aapf_widget_show <?php echo ( ( @ $selected_is_hide ) ? 'show_button' : 'hide_button' ) ?> <?php echo ( ( @ $title ) ? 'mobile_hide' : '' ) ?>"></span>
        <?php } ?>
        <h3 class="widget-title berocket_aapf_widget-title" style="<?php echo @ $uo['style']['title'] ?>"><?php echo @ $title ?></h3>
    </div>
    <?php } ?>
    <div class="berocket_aapf_widget berocket_aapf_widget_selected_area <?php echo ( ( @ $selected_area_show ) ? 'berocket_aapf_widget_selected_area_text' : 'berocket_aapf_widget_selected_area_hide' ); ?><?php if ( @ $is_hide_mobile && @ $is_hooked ) echo ' berocket_aapf_hide_mobile' ?>" <?php echo ( ( @ $selected_is_hide ) ? 'style="display:none;"' : 'style="display:block;"' ) ?>></div>
</div>
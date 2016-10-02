<div class="br_accordion">
    <h3><?php if( $type == 'color' ) { _e('Color pick', 'BeRocket_AJAX_domain'); } elseif( $type == 'image' ) { _e('Image pick', 'BeRocket_AJAX_domain'); } ?></h3>
    <div>
<?php if ( @ $terms ) { 
    if( $type == 'color' ) {?>
<table>
    <?php foreach( $terms as $term ) { $color_meta = get_metadata('berocket_term', $term->term_id, 'color'); ?>
        <tr>
            <td><?php echo @ $term->name ?></td>
            <td class="colorpicker_field" data-color="<?php echo ( @ $color_meta[0] ) ? $color_meta[0] : 'ffffff' ?>"></td>
            <input class="colorpicker_field_input" type="hidden" value="<?php echo @ $color_meta[0]; ?>"
                   name="br_widget_color[<?php echo $term->term_id ?>]" />
        </tr>
    <?php } ?>
    </table>
<?php
    if ( @ $load_script ) {
        ?>
        <script>
            (function ($) {
                $(document).ready(function () {
                    $('.colorpicker_field').each(function (i,o){
                        var color = $(o).data('color');
                        color = color+'';
                        color = color.replace('#', '');
                        $(o).data('color', color);
                        $(o).css('backgroundColor', '#'+$(o).data('color')).next().val($(o).data('color'));
                        $(o).colpick({
                            layout: 'hex',
                            submit: 0,
                            color: '#'+$(o).data('color'),
                            onChange: function(hsb,hex,rgb,el,bySetColor) {
                                $(el).css('backgroundColor', '#'+hex).next().val(hex);
                            }
                        });
                    });
                });
            })(jQuery);
        </script>
    <?php }
    } elseif( $type == 'image' ) {
        ?>
        <table>
    <?php foreach( $terms as $term ) { $color_meta = get_metadata('berocket_term', $term->term_id, $type); ?>
        <tr>
            <td><?php echo berocket_font_select_upload(@ $term->name, 'br_widget_color_'.$type.'_'.$term->term_id, "br_widget_color[".$term->term_id."]", @ $color_meta[0] ); ?></td>
        </tr>
    <?php } ?>
    </table>
    <?php
    }
}
?>
</div>
</div>
<script>
    jQuery(document).ready(function() {
        brjsf_accordion(jQuery( ".br_accordion" ));
    });
</script>
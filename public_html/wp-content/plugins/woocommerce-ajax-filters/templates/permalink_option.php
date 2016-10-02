<?php
$options = get_option( 'berocket_permalink_option' );
BeRocket_updater::$error_log[] = $options;
?>
<div class="br_permalink_editor">
    <input type="text" id="berocket_permalinks_variable" name="berocket_permalink_option[variable]" value="<?php echo @ $options['variable']; ?>">
    <span>/taxonomy_name</span>
    <select name="berocket_permalink_option[value]" id="berocket_permalinks_value">
        <option <?php if( @ $options['value'] == '/values' ) echo 'selected'; ?> value="/values">/values</option>
        <option <?php if( @ $options['value'] == '[values]' ) echo 'selected'; ?> value="[values]">[values]</option>
        <option <?php if( @ $options['value'] == '=values' ) echo 'selected'; ?> value="=values">=values</option>
        <option <?php if( @ $options['value'] == '=[values]' ) echo 'selected'; ?> value="=[values]">=[values]</option>
    </select>
    <select name="berocket_permalink_option[split]" id="berocket_permalinks_split">
        <option <?php if( @ $options['split'] == '/' ) echo 'selected'; ?> value="/">/</option>
        <option <?php if( @ $options['split'] == '|' ) echo 'selected'; ?> value="|">|</option>
        <option <?php if( @ $options['split'] == '&' ) echo 'selected'; ?> value="&">&</option>
    </select>
</div>
<div class="br_permalink_example">
    <code>
        <span>http://wordpress-shop.com/shop/</span><span class="berocket_permalinks_variable"><?php echo @ $options['variable']; ?></span><span>/taxonomy_name</span><span class="berocket_permalinks_value"><?php echo @ $options['value']; ?></span><span class="berocket_permalinks_split"><?php echo @ $options['split']; ?></span><span>taxonomy_name</span><span class="berocket_permalinks_value"><?php echo @ $options['value']; ?></span><span>/</span>
    </code>
</div>
<script>
jQuery('.br_permalink_editor input, .br_permalink_editor select').change(function(){
    jQuery('.br_permalink_example .'+jQuery(this).attr('id')).text(jQuery(this).val());
});
</script>
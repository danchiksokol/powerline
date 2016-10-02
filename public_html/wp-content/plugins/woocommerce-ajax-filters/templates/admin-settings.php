<div class="wrap">
    <form class="berocket_aapf_setting_form" method="post" action="options.php">
        <?php
        settings_fields('br_filters_plugin_options');
        $options = BeRocket_AAPF::get_aapf_option();
        $fonts_list = g_fonts_list();

        $designables = br_aapf_get_styled();
        $tabs_array = array('general', 'design', 'javascript', 'customcss', 'shortcode');
        ?>
        <h2 class="nav-tab-wrapper filter_settings_tabs">
            <a href="#general" class="nav-tab <?php if(@$options['br_opened_tab'] == 'general' || !in_array( @$options['br_opened_tab'], $tabs_array ) ) echo 'nav-tab-active'; ?>"><?php _e('General', 'BeRocket_AJAX_domain') ?></a>
            <a href="#design" class="nav-tab <?php if(@$options['br_opened_tab'] == 'design' ) echo 'nav-tab-active'; ?>"><?php _e('Design', 'BeRocket_AJAX_domain') ?></a>
            <a href="#javascript" class="nav-tab <?php if(@$options['br_opened_tab'] == 'javascript' ) echo 'nav-tab-active'; ?>"><?php _e('JavaScript', 'BeRocket_AJAX_domain') ?></a>
            <a href="#customcss" class="nav-tab <?php if(@$options['br_opened_tab'] == 'customcss' ) echo 'nav-tab-active'; ?>"><?php _e('Custom CSS', 'BeRocket_AJAX_domain') ?></a>
            <a href="#shortcode" class="nav-tab <?php if(@$options['br_opened_tab'] == 'shortcode' ) echo 'nav-tab-active'; ?>"><?php _e('Shortcode', 'BeRocket_AJAX_domain') ?></a>
        </h2>
        <div id="general" class="tab-item <?php if(@$options['br_opened_tab'] == 'general' || !in_array( @$options['br_opened_tab'], $tabs_array ) ) echo 'current'; ?>">
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('"No Products" message', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input size="50" name="br_filters_options[no_products_message]" type='text' value='<?php echo @$options['no_products_message']?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e('Text that will be shown if no products found', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Add position relative to products holder', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[pos_relative]" type='checkbox' value='1' <?php if( @$options['pos_relative'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Fix for correct displaying loading block', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('"No Products" class', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input size="30" name="br_filters_options[no_products_class]" type='text' value='<?php echo @$options['no_products_class']?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e('Add class and use it to style "No Products" box', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Products selector', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input size="30" name="br_filters_options[products_holder_id]" type='text' value='<?php echo @$options['products_holder_id']?$options['products_holder_id']:'ul.products'?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e("Selector for tag that is holding products. Don't change this if you don't know what it is", 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Product count selector', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input size="30" name="br_filters_options[woocommerce_result_count_class]" type='text' value='<?php echo @$options['woocommerce_result_count_class']?$options['woocommerce_result_count_class']:BeRocket_AAPF::$defaults['woocommerce_result_count_class']?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e('Selector for tag with product result count("Showing 1–8 of 61 results"). Don\'t change this if you don\'t know what it is', 'BeRocket_AJAX_domain') ?></span>
                        <div class="settings-sub-option">
                            <input name="br_filters_options[woocommerce_removes][result_count]" type='checkbox' value='1' <?php if( @$options['woocommerce_removes']['result_count'] ) echo "checked='checked'";?>/>
                            <span style="color:#666666;margin-left:2px;"><?php _e('Remove product count', 'BeRocket_AJAX_domain') ?></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Product order by selector', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input size="30" name="br_filters_options[woocommerce_ordering_class]" type='text' value='<?php echo @$options['woocommerce_ordering_class']?$options['woocommerce_ordering_class']:BeRocket_AAPF::$defaults['woocommerce_ordering_class']?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e("Selector for order by form with drop down menu. Don't change this if you don't know what it is", 'BeRocket_AJAX_domain') ?></span>
                        <div class="settings-sub-option">
                            <input name="br_filters_options[woocommerce_removes][ordering]" type='checkbox' value='1' <?php if( @$options['woocommerce_removes']['ordering'] ) echo "checked='checked'";?>/>
                            <span style="color:#666666;margin-left:2px;"><?php _e('Remove order by drop down menu', 'BeRocket_AJAX_domain') ?></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Products pagination selector', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input size="30" name="br_filters_options[woocommerce_pagination_class]" type='text' value='<?php echo @$options['woocommerce_pagination_class']?$options['woocommerce_pagination_class']:BeRocket_AAPF::$defaults['woocommerce_pagination_class']?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e("Selector for tag that is holding products. Don't change this if you don't know what it is", 'BeRocket_AJAX_domain') ?></span>
                        <div class="settings-sub-option">
                            <input name="br_filters_options[woocommerce_removes][pagination]" type='checkbox' value='1' <?php if( @$options['woocommerce_removes']['pagination'] ) echo "checked='checked'";?>/>
                            <span style="color:#666666;margin-left:2px;"><?php _e('Remove pagination', 'BeRocket_AJAX_domain') ?></span>
                        </div>
                    </td>
                </tr>
                <tr<?php if ( br_is_plugin_active( 'list-grid' ) || br_is_plugin_active( 'more-products' ) ) echo ' style="display: none;"'?>>
                    <th><?php _e( 'Products Per Page', 'BeRocket_AJAX_domain' ) ?></th>
                    <td>
                        <input name="br_filters_options[products_per_page]" value="<?php echo @ $options['products_per_page']; ?>" type="number">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Sorting control', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[control_sorting]" type='checkbox' value='1' <?php if( @$options['control_sorting'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e("Take control over WooCommerce's sorting selectbox?", 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('SEO friendly urls', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[seo_friendly_urls]" type='checkbox' value='1' <?php if( @$options['seo_friendly_urls'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e("If this option is on url will be changed when filter is selected/changed", 'BeRocket_AJAX_domain') ?></span>
                        <br>
                        <label><input name="br_filters_options[slug_urls]" type='checkbox' value='1' <?php if( @$options['slug_urls'] ) echo "checked='checked'";?>/><?php _e("Use slug in URL", 'BeRocket_AJAX_domain') ?></label>
                        <br>
                        <label><input name="br_filters_options[nice_urls]" type='checkbox' value='1' <?php if( @$options['nice_urls'] ) echo "checked='checked'";?>/><?php _e("Nice URL", 'BeRocket_AJAX_domain') ?></label>
                        <span style="color:#666666;margin-left:2px;"><?php _e("Works only with SEO friendly urls. WordPress permalinks must be set to Post name(Custom structure: /%postname%/ )", 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Turn all filters off', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[filters_turn_off]" type='checkbox' value='1' <?php if( @$options['filters_turn_off'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e("If you want to hide filters without losing current configuration just turn them off", 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Show all values', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[show_all_values]" type='checkbox' value='1' <?php if( @$options['show_all_values'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Check if you want to show not used attribute values too', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Hide values', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[hide_value][o]" type='checkbox' value='1' <?php if( @$options['hide_value']['o'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Hide values without products', 'BeRocket_AJAX_domain') ?></span><br>
                        <input name="br_filters_options[hide_value][sel]" type='checkbox' value='1' <?php if( @$options['hide_value']['sel'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Hide selected values', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Jump to first page', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[first_page_jump]" type='checkbox' value='1' <?php if( @$options['first_page_jump'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Check if you want load first page after filters change', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Scroll page to the top', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input class="berocket_scroll_shop_top" name="br_filters_options[scroll_shop_top]" type='checkbox' value='1' <?php if( @$options['scroll_shop_top'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Check if you want scroll page to the top of shop after filters change', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                    <td <?php if( ! @ $options['scroll_shop_top'] ) echo ' style="display:none;"';?>>
                        <input name="br_filters_options[scroll_shop_top_px]" type='number' value='<?php echo ( ( @ $options['scroll_shop_top_px'] ) ? $options['scroll_shop_top_px'] : BeRocket_AAPF::$defaults['scroll_shop_top_px'] ); ?>'/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('px from products top.', 'BeRocket_AJAX_domain') ?></span><br>
                        <span><?php _e('Use this to fix top scroll.', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Reload amount of products', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[recount_products]" type='checkbox' value='1' <?php if( @$options['recount_products'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Use filters on products count display', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Show selected filters', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[selected_area_show]" type='checkbox' value='1' <?php if( @$options['selected_area_show'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Show selected filters above products', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Display products', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[products_only]" type='checkbox' value='1' <?php if( @$options['products_only'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Display always products when filters selected. Use this when you have categories and subcategories on shop pages, but you want to display products on filtering', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Data cache', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <select name="br_filters_options[object_cache]">
                            <option <?php echo ( ! @ $options['object_cache'] ) ? 'selected' : '' ?> value=""><?php _e('Disable', 'BeRocket_AJAX_domain') ?></option>
                            <option <?php echo ( @ $options['object_cache'] == 'wordpress' ) ? 'selected' : '' ?> value="wordpress"><?php _e('WordPress Cache', 'BeRocket_AJAX_domain') ?></option>
                            <option <?php echo ( @ $options['object_cache'] == 'persistent' ) ? 'selected' : '' ?> value="persistent"><?php _e('Persistent Cache Plugins', 'BeRocket_AJAX_domain') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Show products count before filtering', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[ub_product_count]" type='checkbox' value='1' <?php if( @$options['ub_product_count'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Show products count before filtering, when using update button', 'BeRocket_AJAX_domain') ?></span>
                        <p>
                            <label><?php _e('Text that means products', 'BeRocket_AJAX_domain') ?></label>
                            <input name="br_filters_options[ub_product_text]" type='text' value='<?php echo @$options['ub_product_text']?>'/>
                        </p>
                        <p>
                            <label><?php _e('Text for show button', 'BeRocket_AJAX_domain') ?></label>
                            <input name="br_filters_options[ub_product_button_text]" type='text' value='<?php echo @$options['ub_product_button_text']?>'/>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Template ajax load fix', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[ajax_request_load]" type='checkbox' value='1' <?php if( @$options['ajax_request_load'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Use all plugins on ajax load(can slow down products loading)', 'BeRocket_AJAX_domain') ?></span>
                        <div class="settings-sub-option">
                            <span style="color:#666666;margin-left:2px;"><?php _e('Use', 'BeRocket_AJAX_domain') ?></span>
                            <select name="br_filters_options[ajax_request_load_style]">
                                <option <?php echo ( ! @ $options['ajax_request_load_style'] ) ? 'selected' : '' ?> value=""><?php _e('PHP', 'BeRocket_AJAX_domain') ?></option>
                                <option <?php echo ( @ $options['ajax_request_load_style'] == 'jquery' ) ? 'selected' : '' ?> value="jquery"><?php _e('JavaScript (jQuery)', 'BeRocket_AJAX_domain') ?></option>
                                <option <?php echo ( @ $options['ajax_request_load_style'] == 'js' ) ? 'selected' : '' ?> value="js"><?php _e('JavaScript', 'BeRocket_AJAX_domain') ?></option>
                            </select>
                            <span style="color:#666666;margin-left:2px;"><?php _e('for fix', 'BeRocket_AJAX_domain') ?></span>
                            <br>
                            <span style="color:#666666;margin-left:2px;">
                                <?php _e('PHP - loads the full page and cuts products from the page via PHP. Slow down server, but users take only needed information.', 'BeRocket_AJAX_domain') ?>
                            </span>
                            <br>
                            <span style="color:#666666;margin-left:2px;">
                                <?php _e('JavaScript (jQuery) - loads the full page and copy all products from the loaded page to the current page using JQuery. Slow down server and users take the full page. Works good with different themes and plugins.', 'BeRocket_AJAX_domain') ?>
                            </span>
                            <br>
                            <span style="color:#666666;margin-left:2px;">
                                <?php _e('JavaScript - loads the full page and cuts products from the page via JavaScript. Slow down server and users take the full page. Works like PHP method.', 'BeRocket_AJAX_domain') ?>
                            </span>
                        <p class="notice notice-error"><?php _e('Some features work only with JavaScript (jQuery) fix', 'BeRocket_AJAX_domain') ?></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Product per row fix', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input min='1' name="br_filters_options[product_per_row]" type='number' value='<?php echo @$options['product_per_row']?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e('Change this only if after filtering count of products per row changes.', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Thousand Separator', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[number_style][thousand_separate]" type='text' value='<?php echo @$options['number_style']['thousand_separate']?>'/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Decimal Separator', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[number_style][decimal_separate]" type='text' value='<?php echo @$options['number_style']['decimal_separate']?>'/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Number Of Decimal', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[number_style][decimal_number]" min="0" type='number' value='<?php echo @$options['number_style']['decimal_number']?>'/>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Fix for sites with AJAX', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[ajax_site]" type='checkbox' value='1' <?php if( @$options['ajax_site'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Add JavaScript files to all pages.', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Use Tags like custom taxonomy', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[tags_custom]" type='checkbox' value='1' <?php if( @$options['tags_custom'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Try to enable this if widget with tags didn\'t work.', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('DEBUG MODE', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input name="br_filters_options[debug_mode]" type='checkbox' value='1' <?php if( @$options['debug_mode'] ) echo "checked='checked'";?>/>
                        <span style="color:#666666;margin-left:2px;"><?php _e('Debug mode display additional information in JavaScript console after page load.', 'BeRocket_AJAX_domain') ?></span>
                        <p class="notice notice-error"><?php _e('Use this only if you need debug information. Disable this on the live site. This function sends some private informations to the front end and uses memory.', 'BeRocket_AJAX_domain') ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Plugin key', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <input id="berocket_product_key" size="50" name="br_filters_options[plugin_key]" type='text' value='<?php echo @$options['plugin_key']?>'/>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e('Key for plugin from BeRocket.com', 'BeRocket_AJAX_domain') ?></span>
                        <br />
                        <input class="berocket_test_account_product button-secondary" data-id="1" type="button" value="Test">
                        <div class="berocket_test_result"></div>
                    </td>
                </tr>
            </table>
        </div>
        <div id="design" class="tab-item <?php if(@$options['br_opened_tab'] == 'design' ) echo 'current'; ?>">
            <table class="wp-list-table widefat fixed posts">
                <thead>
                    <tr>
                        <th class="manage-column column-cb check-column" id="cb" scope="col">
                            <label for="cb-select-all-1" class="screen-reader-text"><?php _e('Select All', 'BeRocket_AJAX_domain') ?></label>
                            <input type="checkbox" id="cb-select-all-1" />
                        </th>
                        <th class="manage-column" scope="col"><?php _e('Element', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-family" scope="col"><?php _e('Font Family', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-weight" scope="col"><?php _e('Font-Weight', 'BeRocket_AJAX_domain') ?><br /><small><?php _e('(depends on font)', 'BeRocket_AJAX_domain') ?></small></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Font-Size', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-theme" scope="col"><?php _e('Theme', 'BeRocket_AJAX_domain') ?></th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th class="manage-column column-cb check-column" scope="col">
                            <label for="cb-select-all-2" class="screen-reader-text"><?php _e('Select All', 'BeRocket_AJAX_domain') ?></label>
                            <input type="checkbox" id="cb-select-all-2" />
                        </th>
                        <th class="manage-column" scope="col"><?php _e('Element', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-family" scope="col"><?php _e('Font Family', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-weight" scope="col"><?php _e('Font-Weight', 'BeRocket_AJAX_domain') ?><br /><small><?php _e('(depends on font)', 'BeRocket_AJAX_domain') ?></small></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Font-Size', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-theme" scope="col"><?php _e('Theme', 'BeRocket_AJAX_domain') ?></th>
                    </tr>
                    <tr>
                        <th class="manage-column admin-column-theme" scope="col" colspan="7">
                            <input type="button" value="<?php _e('Set all to theme default', 'BeRocket_AJAX_domain') ?>" class="all_theme_default button">
                            <div style="clear:both;"></div>
                        </th>
                    </tr>
                </tfoot>

                <tbody id="the-list">
                    <?php
                        $i_designable = 1;
                        foreach ( $designables as $key => $designable ) {
                            ?>
                            <tr class="type-page status-publish author-self">
                                <th class="check-column" scope="row">
                                    <label for="cb-select-<?php echo $i_designable ?>" class="screen-reader-text"><?php _e('Select Element', 'BeRocket_AJAX_domain') ?></label>
                                    <input type="checkbox" value="<?php echo $i_designable ?>" name="element[]" id="cb-select-<?php echo $i_designable ?>">
                                    <div class="locked-indicator"></div>
                                </th>
                                <td><?php echo $designable['name'] ?></td>
                                <td class="admin-column-color">
                                    <?php if ( $designable['has']['color'] ) { ?>
                                        <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles'][$key]['color'] ) ? $options['styles'][$key]['color'] : '000000' ?>"></div>
                                        <input type="hidden" value="<?php echo ( @ $options['styles'][$key]['color'] ) ? $options['styles'][$key]['color'] : '' ?>" name="br_filters_options[styles][<?php echo $key ?>][color]" />
                                        <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                                    <?php } else {
                                        _e('N/A', 'BeRocket_AJAX_domain');
                                    } ?>
                                </td>
                                <td class="admin-column-font-family">
                                    <?php if ( $designable['has']['font_family'] ) { ?>
                                        <select name="br_filters_options[styles][<?php echo $key ?>][font_family]">
                                            <option value=""><?php _e('Theme Default', 'BeRocket_AJAX_domain') ?></option>
                                            <?php foreach( $fonts_list as $font ) { ?>
                                                <option <?php echo @ ( @ $options['styles'][$key]['font_family'] == $font ) ? 'selected' : '' ?>><?php echo @ $font?></option>
                                            <?php } ?>
                                        </select>
                                    <?php } else {
                                        _e('N/A', 'BeRocket_AJAX_domain');
                                    } ?>
                                </td>
                                <td class="admin-column-font-weight">
                                    <?php if ( $designable['has']['bold'] ) { ?>
                                        <select name="br_filters_options[styles][<?php echo $key ?>][bold]">
                                            <option value=""><?php _e('Theme Default', 'BeRocket_AJAX_domain') ?></option>
                                            <optgroup label="Textual Values">
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == 'lighter' ) ? 'selected' : '' ?> value="lighter">light</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == 'normal' ) ? 'selected' : '' ?>>normal</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == 'bold' ) ? 'selected' : '' ?>>bold</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == 'bolder' ) ? 'selected' : '' ?>>bolder</option>
                                            </optgroup>
                                            <optgroup label="Numeric Values">
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '100' ) ? 'selected' : '' ?>>100</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '200' ) ? 'selected' : '' ?>>200</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '300' ) ? 'selected' : '' ?>>300</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '400' ) ? 'selected' : '' ?>>400</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '500' ) ? 'selected' : '' ?>>500</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '600' ) ? 'selected' : '' ?>>600</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '700' ) ? 'selected' : '' ?>>700</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '800' ) ? 'selected' : '' ?>>800</option>
                                                <option <?php echo ( @ $options['styles'][$key]['bold'] == '900' ) ? 'selected' : '' ?>>900</option>
                                            </optgroup>
                                        </select>
                                    <?php } else {
                                        _e('N/A', 'BeRocket_AJAX_domain');
                                    } ?>
                                </td>
                                <td class="admin-column-font-size">
                                    <?php if ( @ $designable['has']['font_size'] ) { ?>
                                        <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles][<?php echo $key ?>][font_size]" value="<?php echo ( @ $options['styles'][$key]['font_size'] ) ? $options['styles'][$key]['font_size'] : '' ?>" />
                                    <?php } else {
                                        _e('N/A', 'BeRocket_AJAX_domain');
                                    } ?>
                                </td>
                               <td class="admin-column-theme">
                                    <?php if ( $designable['has']['theme'] ) { ?>
                                        <select name="br_filters_options[styles][<?php echo $key ?>][theme]">
                                            <option value=""><?php _e('Without Theme', 'BeRocket_AJAX_domain') ?></option>
                                            <?php if ( $key != 'selectbox' ) { ?>
                                                <option value="aapf_grey1" <?php echo ( @ $options['styles'][$key]['theme'] == 'aapf_grey1' ) ? 'selected' : '' ?>>Grey</option>
                                            <?php } ?>
                                            <?php if ( $key != 'slider' and $key != 'checkbox_radio' ) { ?>
                                            <option value="aapf_grey2" <?php echo ( @ $options['styles'][$key]['theme'] == 'aapf_grey2' ) ? 'selected' : '' ?>>Grey 2</option>
                                            <?php } ?>
                                        </select>
                                    <?php } else {
                                        _e('N/A', 'BeRocket_AJAX_domain');
                                    } ?>
                                </td>
                            </tr>
                            <?php
                            $i_designable++;
                        }
                    ?>
                </tbody>
            </table>
            <table class="wp-list-table widefat fixed posts">
                <thead>
                    <tr><th colspan="9" style="text-align: center; font-size: 2em;"><?php _e('Checkbox / Radio', 'BeRocket_AJAX_domain') ?></th></tr>
                    <tr>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Element', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Border color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Border width', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Border radius', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Size', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Font color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Background', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Icon', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Theme', 'BeRocket_AJAX_domain') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="br_checkbox_radio_settings">
                        <td><?php _e('Checkbox', 'BeRocket_AJAX_domain') ?></td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['checkbox']['bcolor'] ) ? $options['styles_input']['checkbox']['bcolor'] : '000000' ?>"></div>
                            <input class="br_border_color_set" type="hidden" value="<?php echo ( @ $options['styles_input']['checkbox']['bcolor'] ) ? $options['styles_input']['checkbox']['bcolor'] : '' ?>" name="br_filters_options[styles_input][checkbox][bcolor]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-font-size">
                            <input class="br_border_width_set" type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][checkbox][bwidth]" value="<?php echo ( @ $options['styles_input']['checkbox']['bwidth'] || @ $options['styles_input']['checkbox']['bwidth'] === '0' ) ? $options['styles_input']['checkbox']['bwidth'] : '' ?>" />
                        </td>
                        <td class="admin-column-font-size">
                            <input class="br_border_radius_set" type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][checkbox][bradius]" value="<?php echo ( @ $options['styles_input']['checkbox']['bradius'] || @ $options['styles_input']['checkbox']['bradius'] === '0' ) ? $options['styles_input']['checkbox']['bradius'] : '' ?>" />
                        </td>
                        <td class="admin-column-font-size">
                            <input class="br_size_set" type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][checkbox][fontsize]" value="<?php echo ( @ $options['styles_input']['checkbox']['fontsize'] ) ? $options['styles_input']['checkbox']['fontsize'] : '' ?>" />
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['checkbox']['fcolor'] ) ? $options['styles_input']['checkbox']['fcolor'] : '000000' ?>"></div>
                            <input class="br_font_color_set" type="hidden" value="<?php echo ( @ $options['styles_input']['checkbox']['fcolor'] ) ? $options['styles_input']['checkbox']['fcolor'] : '' ?>" name="br_filters_options[styles_input][checkbox][fcolor]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['checkbox']['backcolor'] ) ? $options['styles_input']['checkbox']['backcolor'] : '000000' ?>"></div>
                            <input class="br_background_set" type="hidden" value="<?php echo ( @ $options['styles_input']['checkbox']['backcolor'] ) ? $options['styles_input']['checkbox']['backcolor'] : '' ?>" name="br_filters_options[styles_input][checkbox][backcolor]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <select name="br_filters_options[styles_input][checkbox][icon]" class="fontawesome br_icon_set">
                                <option value=""<?php if ( ! @ $options['styles_input']['checkbox']['icon'] ) echo ' selected' ?>>NONE</option>
                                <?php $radion_icon = array( 'f00c', '2713', 'f00d', 'f067', 'f055', 'f0fe', 'f14a', 'f058' );
                                foreach( $radion_icon as $r_icon ) {
                                    echo '<option value="'.$r_icon.'"'.( ( @ $options['styles_input']['checkbox']['icon'] == $r_icon ) ? ' selected' : '' ).'>&#x'.$r_icon.';</option>';
                                }?>
                            </select>
                        </td>
                        <td class="admin-column-color">
                            <select name="br_filters_options[styles_input][checkbox][theme]" class="br_theme_set_select">
                                <option value=""<?php if ( ! @ $options['styles_input']['checkbox']['theme'] ) echo ' selected' ?>>NONE</option>
                                <option data-border_color="" data-border_width="0" data-border_radius="5" data-size="" data-font_color="333333" data-background="bbbbbb" data-icon="f00c" value="black_1"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'black_1' ) echo ' selected' ?>>Black 1</option>
                                <option data-border_color="333333" data-border_width="1" data-border_radius="2" data-size="" data-font_color="333333" data-background="" data-icon="2713" value="black_2"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'black_2' ) echo ' selected' ?>>Black 2</option>
                                <option data-border_color="333333" data-border_width="2" data-border_radius="50" data-size="" data-font_color="333333" data-background="" data-icon="f058" value="black_3"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'black_3' ) echo ' selected' ?>>Black 3</option>
                                <option data-border_color="333333" data-border_width="2" data-border_radius="2" data-size="" data-font_color="333333" data-background="" data-icon="f14a" value="black_4"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'black_4' ) echo ' selected' ?>>Black 4</option>
                                <option data-border_color="" data-border_width="0" data-border_radius="5" data-size="" data-font_color="dddddd" data-background="333333" data-icon="f00c" value="white_1"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'white_1' ) echo ' selected' ?>>White 1</option>
                                <option data-border_color="dddddd" data-border_width="1" data-border_radius="2" data-size="" data-font_color="dddddd" data-background="" data-icon="2713" value="white_2"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'white_2' ) echo ' selected' ?>>White 2</option>
                                <option data-border_color="dddddd" data-border_width="2" data-border_radius="50" data-size="" data-font_color="dddddd" data-background="" data-icon="f058" value="white_3"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'white_3' ) echo ' selected' ?>>White 3</option>
                                <option data-border_color="dddddd" data-border_width="2" data-border_radius="2" data-size="" data-font_color="dddddd" data-background="" data-icon="f14a" value="white_4"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'white_4' ) echo ' selected' ?>>White 4</option>
                                <option data-border_color="" data-border_width="0" data-border_radius="5" data-size="" data-font_color="dd3333" data-background="333333" data-icon="f00c" value="red_1"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'red_1' ) echo ' selected' ?>>Red 1</option>
                                <option data-border_color="dd3333" data-border_width="1" data-border_radius="2" data-size="" data-font_color="dd3333" data-background="" data-icon="2713" value="red_2"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'red_2' ) echo ' selected' ?>>Red 2</option>
                                <option data-border_color="dd3333" data-border_width="2" data-border_radius="50" data-size="" data-font_color="dd3333" data-background="" data-icon="f058" value="red_3"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'red_3' ) echo ' selected' ?>>Red 3</option>
                                <option data-border_color="dd3333" data-border_width="2" data-border_radius="2" data-size="" data-font_color="dd3333" data-background="" data-icon="f14a" value="red_4"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'red_4' ) echo ' selected' ?>>Red 4</option>
                                <option data-border_color="" data-border_width="0" data-border_radius="5" data-size="" data-font_color="33dd33" data-background="333333" data-icon="f00c" value="green_1"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'green_1' ) echo ' selected' ?>>Green 1</option>
                                <option data-border_color="33dd33" data-border_width="1" data-border_radius="2" data-size="" data-font_color="33dd33" data-background="" data-icon="2713" value="green_2"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'green_2' ) echo ' selected' ?>>Green 2</option>
                                <option data-border_color="33dd33" data-border_width="2" data-border_radius="50" data-size="" data-font_color="33dd33" data-background="" data-icon="f058" value="green_3"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'green_3' ) echo ' selected' ?>>Green 3</option>
                                <option data-border_color="33dd33" data-border_width="2" data-border_radius="2" data-size="" data-font_color="33dd33" data-background="" data-icon="f14a" value="green_4"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'green_4' ) echo ' selected' ?>>Green 4</option>
                                <option data-border_color="" data-border_width="0" data-border_radius="5" data-size="" data-font_color="3333dd" data-background="333333" data-icon="f00c" value="blue_1"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'blue_1' ) echo ' selected' ?>>Blue 1</option>
                                <option data-border_color="3333dd" data-border_width="1" data-border_radius="2" data-size="" data-font_color="3333dd" data-background="" data-icon="2713" value="blue_2"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'blue_2' ) echo ' selected' ?>>Blue 2</option>
                                <option data-border_color="3333dd" data-border_width="2" data-border_radius="50" data-size="" data-font_color="3333dd" data-background="" data-icon="f058" value="blue_3"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'blue_3' ) echo ' selected' ?>>Blue 3</option>
                                <option data-border_color="3333dd" data-border_width="2" data-border_radius="2" data-size="" data-font_color="3333dd" data-background="" data-icon="f14a" value="blue_4"<?php if ( @ $options['styles_input']['checkbox']['theme'] == 'blue_4' ) echo ' selected' ?>>Blue 4</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="br_checkbox_radio_settings">
                        <td><?php _e('Radio', 'BeRocket_AJAX_domain') ?></td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['radio']['bcolor'] ) ? $options['styles_input']['radio']['bcolor'] : '000000' ?>"></div>
                            <input class="br_border_color_set" type="hidden" value="<?php echo ( @ $options['styles_input']['radio']['bcolor'] ) ? $options['styles_input']['radio']['bcolor'] : '' ?>" name="br_filters_options[styles_input][radio][bcolor]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-font-size">
                            <input class="br_border_width_set" type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][radio][bwidth]" value="<?php echo ( @ $options['styles_input']['radio']['bwidth'] || @ $options['styles_input']['radio']['bwidth'] === '0' ) ? $options['styles_input']['radio']['bwidth'] : '' ?>" />
                        </td>
                        <td class="admin-column-font-size">
                            <input class="br_border_radius_set" type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][radio][bradius]" value="<?php echo ( @ $options['styles_input']['radio']['bradius'] || @ $options['styles_input']['radio']['bradius'] === '0' ) ? $options['styles_input']['radio']['bradius'] : '' ?>" />
                        </td>
                        <td class="admin-column-font-size">
                            <input class="br_size_set" type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][radio][fontsize]" value="<?php echo ( @ $options['styles_input']['radio']['fontsize'] ) ? $options['styles_input']['radio']['fontsize'] : '' ?>" />
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['radio']['fcolor'] ) ? $options['styles_input']['radio']['fcolor'] : '000000' ?>"></div>
                            <input class="br_font_color_set" type="hidden" value="<?php echo ( @ $options['styles_input']['radio']['fcolor'] ) ? $options['styles_input']['radio']['fcolor'] : '' ?>" name="br_filters_options[styles_input][radio][fcolor]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['radio']['backcolor'] ) ? $options['styles_input']['radio']['backcolor'] : '000000' ?>"></div>
                            <input class="br_background_set" type="hidden" value="<?php echo ( @ $options['styles_input']['radio']['backcolor'] ) ? $options['styles_input']['radio']['backcolor'] : '' ?>" name="br_filters_options[styles_input][radio][backcolor]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <select name="br_filters_options[styles_input][radio][icon]" class="fontawesome br_icon_set">
                                <option value=""<?php if ( ! @ $options['styles_input']['radio']['icon'] ) echo ' selected' ?>>NONE</option>
                                <?php $radion_icon = array( 'f111', '2022', 'f10c', 'f192', 'f0c8', 'f055', 'f0fe', 'f14a', 'f058' );
                                foreach( $radion_icon as $r_icon ) {
                                    echo '<option value="'.$r_icon.'"'.( ( @ $options['styles_input']['radio']['icon'] == $r_icon ) ? ' selected' : '' ).'>&#x'.$r_icon.';</option>';
                                }?>
                            </select>
                        </td>
                        <td class="admin-column-color">
                            <select name="br_filters_options[styles_input][radio][theme]" class="br_theme_set_select">
                                <option value=""<?php if ( ! @ $options['styles_input']['radio']['theme'] ) echo ' selected' ?>>NONE</option>
                                <option data-border_color="" data-border_width="" data-border_radius="" data-size="" data-font_color="333333" data-background="bbbbbb" data-icon="f111" value="black_1"<?php if ( @ $options['styles_input']['radio']['theme'] == 'black_1' ) echo ' selected' ?>>Black 1</option>
                                <option data-border_color="333333" data-border_width="1" data-border_radius="2" data-size="" data-font_color="333333" data-background="" data-icon="f0c8" value="black_2"<?php if ( @ $options['styles_input']['radio']['theme'] == 'black_2' ) echo ' selected' ?>>Black 2</option>
                                <option data-border_color="333333" data-border_width="2" data-border_radius="" data-size="10" data-font_color="333333" data-background="" data-icon="f055" value="black_3"<?php if ( @ $options['styles_input']['radio']['theme'] == 'black_3' ) echo ' selected' ?>>Black 3</option>
                                <option data-border_color="" data-border_width="" data-border_radius="" data-size="" data-font_color="dddddd" data-background="333333" data-icon="f111" value="white_1"<?php if ( @ $options['styles_input']['radio']['theme'] == 'white_1' ) echo ' selected' ?>>White 1</option>
                                <option data-border_color="dddddd" data-border_width="1" data-border_radius="2" data-size="" data-font_color="dddddd" data-background="" data-icon="f0c8" value="white_2"<?php if ( @ $options['styles_input']['radio']['theme'] == 'white_2' ) echo ' selected' ?>>White 2</option>
                                <option data-border_color="dddddd" data-border_width="2" data-border_radius="" data-size="10" data-font_color="dddddd" data-background="" data-icon="f055" value="white_3"<?php if ( @ $options['styles_input']['radio']['theme'] == 'white_3' ) echo ' selected' ?>>White 3</option>
                                <option data-border_color="" data-border_width="" data-border_radius="" data-size="" data-font_color="dd3333" data-background="333333" data-icon="f111" value="red_1"<?php if ( @ $options['styles_input']['radio']['theme'] == 'red_1' ) echo ' selected' ?>>Red 1</option>
                                <option data-border_color="dd3333" data-border_width="1" data-border_radius="2" data-size="" data-font_color="dd3333" data-background="" data-icon="f0c8" value="red_2"<?php if ( @ $options['styles_input']['radio']['theme'] == 'red_2' ) echo ' selected' ?>>Red 2</option>
                                <option data-border_color="dd3333" data-border_width="2" data-border_radius="" data-size="10" data-font_color="dd3333" data-background="" data-icon="f055" value="red_3"<?php if ( @ $options['styles_input']['radio']['theme'] == 'red_3' ) echo ' selected' ?>>Red 3</option>
                                <option data-border_color="" data-border_width="" data-borderSearch Box_radius="" data-size="" data-font_color="33dd33" data-background="333333" data-icon="f111" value="green_1"<?php if ( @ $options['styles_input']['radio']['theme'] == 'green_1' ) echo ' selected' ?>>Green 1</option>
                                <option data-border_color="33dd33" data-border_width="1" data-border_radius="2" data-size="" data-font_color="33dd33" data-background="" data-icon="f0c8" value="green_2"<?php if ( @ $options['styles_input']['radio']['theme'] == 'green_2' ) echo ' selected' ?>>Green 2</option>
                                <option data-border_color="33dd33" data-border_width="2" data-border_radius="" data-size="10" data-font_color="33dd33" data-background="" data-icon="f055" value="green_3"<?php if ( @ $options['styles_input']['radio']['theme'] == 'green_3' ) echo ' selected' ?>>Green 3</option>
                                <option data-border_color="" data-border_width="" data-border_radius="" data-size="" data-font_color="3333dd" data-background="333333" data-icon="f111" value="blue_1"<?php if ( @ $options['styles_input']['radio']['theme'] == 'blue_1' ) echo ' selected' ?>>Blue 1</option>
                                <option data-border_color="3333dd" data-border_width="1" data-border_radius="2" data-size="" data-font_color="3333dd" data-background="" data-icon="f0c8" value="blue_2"<?php if ( @ $options['styles_input']['radio']['theme'] == 'blue_2' ) echo ' selected' ?>>Blue 2</option>
                                <option data-border_color="3333dd" data-border_width="2" data-border_radius="" data-size="10" data-font_color="3333dd" data-background="" data-icon="f055" value="blue_3"<?php if ( @ $options['styles_input']['radio']['theme'] == 'blue_3' ) echo ' selected' ?>>Blue 3</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="manage-column admin-column-theme" scope="col" colspan="9">
                            <input type="button" value="<?php _e('Set all to theme default', 'BeRocket_AJAX_domain') ?>" class="all_theme_default button">
                            <div style="clear:both;"></div>
                        </th>
                    </tr>
                </tfoot>
            </table>
            <table class="wp-list-table widefat fixed posts">
                <thead>
                    <tr><th colspan="10" style="text-align: center; font-size: 2em;"><?php _e('Slider', 'BeRocket_AJAX_domain') ?></th></tr>
                    <tr>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Line color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Back line color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Line height', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Line border color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Line border width', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Button size', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Button color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Button border color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Button border width', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Button border radius', 'BeRocket_AJAX_domain') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['slider']['line_color'] ) ? $options['styles_input']['slider']['line_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['slider']['line_color'] ) ? $options['styles_input']['slider']['line_color'] : '' ?>" name="br_filters_options[styles_input][slider][line_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['slider']['back_line_color'] ) ? $options['styles_input']['slider']['back_line_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['slider']['back_line_color'] ) ? $options['styles_input']['slider']['back_line_color'] : '' ?>" name="br_filters_options[styles_input][slider][back_line_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-font-size">
                            <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][slider][line_height]" value="<?php echo ( @ $options['styles_input']['slider']['line_height'] ) ? $options['styles_input']['slider']['line_height'] : '' ?>" />
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['slider']['line_border_color'] ) ? $options['styles_input']['slider']['line_border_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['slider']['line_border_color'] ) ? $options['styles_input']['slider']['line_border_color'] : '' ?>" name="br_filters_options[styles_input][slider][line_border_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-font-size">
                            <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][slider][line_border_width]" value="<?php echo ( @ $options['styles_input']['slider']['line_border_width'] || @ $options['styles_input']['slider']['line_border_width'] === '0' ) ? $options['styles_input']['slider']['line_border_width'] : '' ?>" />
                        </td>
                        <td class="admin-column-font-size">
                            <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][slider][button_size]" value="<?php echo ( @ $options['styles_input']['slider']['button_size'] || @ $options['styles_input']['slider']['button_size'] === '0' ) ? $options['styles_input']['slider']['button_size'] : '' ?>" />
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['slider']['button_color'] ) ? $options['styles_input']['slider']['button_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['slider']['button_color'] ) ? $options['styles_input']['slider']['button_color'] : '' ?>" name="br_filters_options[styles_input][slider][button_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['slider']['button_border_color'] ) ? $options['styles_input']['slider']['button_border_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['slider']['button_border_color'] ) ? $options['styles_input']['slider']['button_border_color'] : '' ?>" name="br_filters_options[styles_input][slider][button_border_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-font-size">
                            <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][slider][button_border_width]" value="<?php echo ( @ $options['styles_input']['slider']['button_border_width'] || @ $options['styles_input']['slider']['button_border_width'] === '0' ) ? $options['styles_input']['slider']['button_border_width'] : '' ?>" />
                        </td>
                        <td class="admin-column-font-size">
                            <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][slider][button_border_radius]" value="<?php echo ( @ $options['styles_input']['slider']['button_border_radius'] || @ $options['styles_input']['slider']['button_border_radius'] === '0' ) ? $options['styles_input']['slider']['button_border_radius'] : '' ?>" />
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="manage-column admin-column-theme" scope="col" colspan="10">
                            <input type="button" value="<?php _e('Set all to theme default', 'BeRocket_AJAX_domain') ?>" class="all_theme_default button">
                            <div style="clear:both;"></div>
                        </th>
                    </tr>
                </tfoot>
            </table>
            <table class="wp-list-table widefat fixed posts">
                <thead>
                    <tr><th colspan="10" style="text-align: center; font-size: 2em;"><?php _e('Product count description before filtering with Update button', 'BeRocket_AJAX_domain') ?></th></tr>
                    <tr>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Background color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Border color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Font size', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Font color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Show button font size', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Show button font color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Show button font color on mouse over', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-font-size" scope="col"><?php _e('Close button size', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Close button font color', 'BeRocket_AJAX_domain') ?></th>
                        <th class="manage-column admin-column-color" scope="col"><?php _e('Close button font color on mouse over', 'BeRocket_AJAX_domain') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['pc_ub']['back_color'] ) ? $options['styles_input']['pc_ub']['back_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['pc_ub']['back_color'] ) ? $options['styles_input']['pc_ub']['back_color'] : '' ?>" name="br_filters_options[styles_input][pc_ub][back_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['pc_ub']['border_color'] ) ? $options['styles_input']['pc_ub']['border_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['pc_ub']['border_color'] ) ? $options['styles_input']['pc_ub']['border_color'] : '' ?>" name="br_filters_options[styles_input][pc_ub][border_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-font-size">
                            <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][pc_ub][font_size]" value="<?php echo ( @ $options['styles_input']['pc_ub']['font_size'] ) ? $options['styles_input']['pc_ub']['font_size'] : '' ?>" />
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['pc_ub']['font_color'] ) ? $options['styles_input']['pc_ub']['font_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['pc_ub']['font_color'] ) ? $options['styles_input']['pc_ub']['font_color'] : '' ?>" name="br_filters_options[styles_input][pc_ub][font_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-font-size">
                            <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][pc_ub][show_font_size]" value="<?php echo ( @ $options['styles_input']['pc_ub']['show_font_size'] ) ? $options['styles_input']['pc_ub']['show_font_size'] : '' ?>" />
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['pc_ub']['show_font_color'] ) ? $options['styles_input']['pc_ub']['show_font_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['pc_ub']['show_font_color'] ) ? $options['styles_input']['pc_ub']['show_font_color'] : '' ?>" name="br_filters_options[styles_input][pc_ub][show_font_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['pc_ub']['show_font_color_hover'] ) ? $options['styles_input']['pc_ub']['show_font_color_hover'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['pc_ub']['show_font_color_hover'] ) ? $options['styles_input']['pc_ub']['show_font_color_hover'] : '' ?>" name="br_filters_options[styles_input][pc_ub][show_font_color_hover]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-font-size">
                            <input type="text" placeholder="<?php _e('Theme Default', 'BeRocket_AJAX_domain') ?>" name="br_filters_options[styles_input][pc_ub][close_size]" value="<?php echo ( @ $options['styles_input']['pc_ub']['close_size'] ) ? $options['styles_input']['pc_ub']['close_size'] : '' ?>" />
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['pc_ub']['close_font_color'] ) ? $options['styles_input']['pc_ub']['close_font_color'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['pc_ub']['close_font_color'] ) ? $options['styles_input']['pc_ub']['close_font_color'] : '' ?>" name="br_filters_options[styles_input][pc_ub][close_font_color]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                        <td class="admin-column-color">
                            <div class="colorpicker_field" data-color="<?php echo ( @ $options['styles_input']['pc_ub']['close_font_color_hover'] ) ? $options['styles_input']['pc_ub']['close_font_color_hover'] : '000000' ?>"></div>
                            <input type="hidden" value="<?php echo ( @ $options['styles_input']['pc_ub']['close_font_color_hover'] ) ? $options['styles_input']['pc_ub']['close_font_color_hover'] : '' ?>" name="br_filters_options[styles_input][pc_ub][close_font_color_hover]" />
                            <input type="button" value="<?php _e('Default', 'BeRocket_AJAX_domain') ?>" class="theme_default button">
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="manage-column admin-column-theme" scope="col" colspan="10">
                            <input type="button" value="<?php _e('Set all to theme default', 'BeRocket_AJAX_domain') ?>" class="all_theme_default button">
                            <div style="clear:both;"></div>
                        </th>
                    </tr>
                </tfoot>
            </table>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Loading products icon', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <?php echo berocket_font_select_upload('', 'br_filters_options_ajax_load_icon', 'br_filters_options[ajax_load_icon]', @ $options['ajax_load_icon'], false); ?>
                    </td>
                </tr>
            </table>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Text at load icon', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <span><?php _e('Above:', 'BeRocket_AJAX_domain') ?> </span><input name="br_filters_options[ajax_load_text][top]" type='text' value='<?php echo ( ( @ $options['ajax_load_text']['top'] ) ? $options['ajax_load_text']['top'] : '' ); ?>'/>
                    </td>
                    <td>
                        <span><?php _e('Under:', 'BeRocket_AJAX_domain') ?> </span><input name="br_filters_options[ajax_load_text][bottom]" type='text' value='<?php echo ( ( @ $options['ajax_load_text']['bottom'] ) ? $options['ajax_load_text']['bottom'] : '' ); ?>'/>
                    </td>
                    <td>
                        <span><?php _e('Before:', 'BeRocket_AJAX_domain') ?> </span><input name="br_filters_options[ajax_load_text][left]" type='text' value='<?php echo ( ( @ $options['ajax_load_text']['left'] ) ? $options['ajax_load_text']['left'] : '' ); ?>'/>
                    </td>
                    <td>
                        <span><?php _e('After:', 'BeRocket_AJAX_domain') ?> </span><input name="br_filters_options[ajax_load_text][right]" type='text' value='<?php echo ( ( @ $options['ajax_load_text']['right'] ) ? $options['ajax_load_text']['right'] : '' ); ?>'/>
                    </td>
                </tr>
            </table>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Description show and hide', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <span><?php _e('Show on:', 'BeRocket_AJAX_domain') ?> </span>
                        <select name="br_filters_options[description][show]">
                            <option <?php echo ( $options['description']['show'] == 'click' ) ? 'selected' : '' ?> value="click"><?php _e('Click', 'BeRocket_AJAX_domain') ?></option>
                            <option <?php echo ( $options['description']['show'] == 'hover' ) ? 'selected' : '' ?> value="hover"><?php _e('Mouse over icon', 'BeRocket_AJAX_domain') ?></option>
                        </select>
                    </td>
                    <td>
                        <span><?php _e('Hide on:', 'BeRocket_AJAX_domain') ?> </span>
                        <select name="br_filters_options[description][hide]">
                            <option <?php echo ( $options['description']['hide'] == 'click' ) ? 'selected' : '' ?> value="click"><?php _e('Click anywhere', 'BeRocket_AJAX_domain') ?></option>
                            <option <?php echo ( $options['description']['hide'] == 'mouseleave' ) ? 'selected' : '' ?> value="mouseleave"><?php _e('Mouse out of icon', 'BeRocket_AJAX_domain') ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Product count style', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <select name="br_filters_options[styles_input][product_count]">
                            <option <?php echo ( $options['styles_input']['product_count'] ) ? 'selected' : '' ?> value=""><?php _e('4', 'BeRocket_AJAX_domain') ?></option>
                            <option <?php echo ( $options['styles_input']['product_count'] == 'round' ) ? 'selected' : '' ?> value="round"><?php _e('(4)', 'BeRocket_AJAX_domain') ?></option>
                            <option <?php echo ( $options['styles_input']['product_count'] == 'quad' ) ? 'selected' : '' ?> value="quad"><?php _e('[4]', 'BeRocket_AJAX_domain') ?></option>
                        </select>
                    </td>
                    <td>
                        <span><?php _e('Position:', 'BeRocket_AJAX_domain') ?> </span>
                        <select name="br_filters_options[styles_input][product_count_position]">
                            <option <?php echo ( $options['styles_input']['product_count_position'] ) ? 'selected' : '' ?> value=""><?php _e('Normal', 'BeRocket_AJAX_domain') ?></option>
                            <option <?php echo ( $options['styles_input']['product_count_position'] == 'right' ) ? 'selected' : '' ?> value="right"><?php _e('Right', 'BeRocket_AJAX_domain') ?></option>
                            <option <?php echo ( $options['styles_input']['product_count_position'] == 'right2em' ) ? 'selected' : '' ?> value="right2em"><?php _e('Right from name', 'BeRocket_AJAX_domain') ?></option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div id="javascript" class="tab-item <?php if(@$options['br_opened_tab'] == 'javascript' ) echo 'current'; ?>">
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Before Update:', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <textarea style="min-width: 500px; height: 100px;" name="br_filters_options[user_func][before_update]"><?php echo @$options['user_func']['before_update'] ?></textarea>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e("If you want to add own actions on filter activation, eg: alert('1');", 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('On Update:', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <textarea style="min-width: 500px; height: 100px;" name="br_filters_options[user_func][on_update]"><?php echo @$options['user_func']['on_update'] ?></textarea>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e("If you want to add own actions right on products update. You can manipulate data here, try: data.products = 'Ha!';", 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('After Update:', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <textarea style="min-width: 500px; height: 100px;" name="br_filters_options[user_func][after_update]"><?php echo @$options['user_func']['after_update'] ?></textarea>
                        <br />
                        <span style="color:#666666;margin-left:2px;"><?php _e("If you want to add own actions after products updated, eg: alert('1');", 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
            </table>
        </div>
        <div id="customcss" class="tab-item <?php if(@$options['br_opened_tab'] == 'customcss' ) echo 'current'; ?>">
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('User custom CSS style:', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <textarea style="min-width: 500px; height: 400px;" name="br_filters_options[user_custom_css]"><?php echo @$options['user_custom_css'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Definitions:', 'BeRocket_AJAX_domain') ?></th>
                    <td>
                        <span style="color:#6666FF;margin-left:2px;">#widget#</span><span style="color:#666666;margin-left:2px;"> - <?php _e('widget block.', 'BeRocket_AJAX_domain') ?></span><br />
                        <span style="color:#6666FF    ;margin-left:2px;">#widget-title#</span><span style="color:#666666;margin-left:2px;"> - <?php _e('widget title.', 'BeRocket_AJAX_domain') ?></span>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="br_opened_tab" name="br_filters_options[br_opened_tab]" value="<?php echo @$options['br_opened_tab'] ?>">
        </div>
        <div id="shortcode" class="widget-liquid-right tab-item <?php if(@$options['br_opened_tab'] == 'shortcode' ) echo 'current'; ?>">
<?php
$attributes        = br_aapf_get_attributes();
$categories        = BeRocket_AAPF_Widget::get_product_categories( @ json_decode( $instance['product_cat'] ) );
$tags              = get_terms( 'product_tag' );
$custom_taxonomies = get_taxonomies( array( "_builtin" => false, "public" => true ) );
?>
<p>
    <label class="br_admin_center"><?php _e('Widget Type', 'BeRocket_AJAX_domain') ?></label>
    <select id="berocket_sc_widget_type" data-sc_change="0" data-sc="widget_type" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_widget_type_select br_select_menu_left">
        <option selected value="filter"><?php _e('Filter', 'BeRocket_AJAX_domain') ?></option>
        <option value="update_button"><?php _e('Update Products button', 'BeRocket_AJAX_domain') ?></option>
        <option value="reset_button"><?php _e('Reset Products button', 'BeRocket_AJAX_domain') ?></option>
        <option value="selected_area"><?php _e('Selected Filters area', 'BeRocket_AJAX_domain') ?></option>
        <option value="search_box"><?php _e('Search Box', 'BeRocket_AJAX_domain') ?></option>
    </select>
</p>

<hr />

<p>
    <label class="br_admin_center" for="berocket_sc_title"><?php _e('Title', 'BeRocket_AJAX_domain') ?> </label>
    <input class="berocket_aapf_widget_sc br_admin_full_size" id="berocket_sc_title" type="text" value="" data-sc_change="0" data-sc="title" />
</p>

<div class="berocket_aapf_admin_filter_widget_content">
    <p class="br_admin_half_size_left">
        <label class="br_admin_center"><?php _e('Filter By', 'BeRocket_AJAX_domain') ?></label>
        <select id="berocket_sc_filter_type" data-sc_change="0" data-sc="filter_type" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_filter_type_select br_select_menu_left">
            <option selected value="attribute"><?php _e('Attribute', 'BeRocket_AJAX_domain') ?></option>
            <option value="_stock_status"><?php _e('Stock status', 'BeRocket_AJAX_domain') ?></option>
            <option value="product_cat"><?php _e('Product sub-categories', 'BeRocket_AJAX_domain') ?></option>
            <option value="tag"><?php _e('Tag', 'BeRocket_AJAX_domain') ?></option>
            <option value="custom_taxonomy"><?php _e('Custom Taxonomy', 'BeRocket_AJAX_domain') ?></option>
        </select>
    </p>
    <p class="br_admin_half_size_right berocket_aapf_widget_admin_filter_type_ berocket_aapf_widget_admin_filter_type_attribute">
        <label class="br_admin_center"><?php _e('Attribute', 'BeRocket_AJAX_domain') ?></label>
        <select id="berocket_sc_attribute" data-sc_change="0" data-sc="attribute" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_filter_type_attribute_select br_select_menu_right">
            <option selected value="price"><?php _e('Price', 'BeRocket_AJAX_domain') ?></option>
            <?php foreach ( @ $attributes as $k => $v ) { ?>
                <option value="<?php echo @ $k ?>"><?php echo @ $v ?></option>
            <?php } ?>
        </select>
    </p>
    <p class="br_admin_half_size_right berocket_aapf_widget_admin_filter_type_ berocket_aapf_widget_admin_filter_type_custom_taxonomy" style="display: none;">
        <label class="br_admin_center"><?php _e('Custom Taxonomies', 'BeRocket_AJAX_domain') ?></label>
        <select id="berocket_sc_custom_taxonomy" data-sc_change="0" data-sc="custom_taxonomy" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_filter_type_custom_taxonomy_select br_select_menu_right">
            <?php foreach( $custom_taxonomies as $k => $v ){ ?>
                <option value="<?php echo @ $k ?>"><?php echo @ $v ?></option>
            <?php } ?>
        </select>
    </p>
    <div class="br_clearfix"></div>
    <p class="br_admin_three_size_left">
        <label class="br_admin_center"><?php _e('Type', 'BeRocket_AJAX_domain') ?></label>
        <select id="berocket_sc_type" data-sc_change="0" data-sc="type" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_type_select br_select_menu_left">
            <option selected value="slider">Slider</option>
        </select>
    </p>
    <p class="br_admin_three_size_left" style='display: none;'>
        <label class="br_admin_center"><?php _e('Operator', 'BeRocket_AJAX_domain') ?></label>
        <select id="berocket_sc_operator" data-sc_change="0" data-sc="operator" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_operator_select br_select_menu_left">
            <option value="AND">AND</option>
            <option selected value="OR">OR</option>
        </select>
    </p>
    <p class="berocket_aapf_order_values_by br_admin_three_size_left">
        <label class="br_admin_center"><?php _e('Values Order', 'BeRocket_AJAX_domain') ?></label>
        <select id="berocket_sc_order_values_by" data-sc_change="0" data-sc="order_values_by" class="berocket_aapf_widget_sc berocket_aapf_order_values_by_select br_select_menu_left">
            <option value=""><?php _e('Default', 'BeRocket_AJAX_domain') ?></option>
            <?php foreach ( array( 'Alpha', 'Numeric' ) as $v ) { ?>
                <option value="<?php _e( $v ) ?>"><?php _e( $v ) ?></option>
            <?php } ?>
        </select>
    </p>
    <div class="br_clearfix"></div>
    <div class="berocket_widget_color_pick">
        <?php if ( @ $instance['type'] == 'color' ) { ?>
            <?php BeRocket_AAPF_Widget::color_list_view( @ $instance['attribute'], true ); ?>
        <?php } ?>
    </div>
    <p class="berocket_aapf_widget_admin_price_attribute br_admin_half_size_left" >
        <label class="br_admin_center" for="berocket_sc_text_before_price"><?php _e('Text before price', 'BeRocket_AJAX_domain') ?> </label>
        <input data-sc_change="0" data-sc="text_before_price" class="berocket_aapf_widget_sc br_admin_full_size" id="berocket_sc_text_before_price" type="text" value="" />
    </p>
    <p class="berocket_aapf_widget_admin_price_attribute br_admin_half_size_right" >
        <label class="br_admin_center" for="berocket_sc_text_after_price"><?php _e('Text after price', 'BeRocket_AJAX_domain') ?> </label>
        <input data-sc_change="0" data-sc="text_after_price" class="berocket_aapf_widget_sc br_admin_full_size" id="berocket_sc_text_after_price" type="text" value="" />
    </p>
    <div class="br_clearfix"></div>
    <div class="berocket_aapf_product_sub_cat_current" style="display:none;"'>
        <p>
            <label>
                <input data-sc_change="0" data-sc="parent_product_cat_current" class="berocket_aapf_widget_sc berocket_aapf_product_sub_cat_current_input" type="checkbox" value="1" />
                <?php _e('Use current product category to get child', 'BeRocket_AJAX_domain') ?>
            </label>
        </p>
    </div>
    <div class="berocket_aapf_product_sub_cat_div" style="display:none;">
    <div class="br_accordion">
        <h3><?php _e('Product Category', 'BeRocket_AJAX_domain') ?></h3>
        <div>
            <p>
                <ul class="berocket_aapf_advanced_settings_categories_list">
                    <li>
                        <input type="radio" name="berocket_sc_parent_product_cat" checked value="" data-sc_change="0" data-sc="parent_product_cat" class="berocket_aapf_widget_sc berocket_sc_parent_product_cat berocket_aapf_widget_admin_height_input" />
                        <?php _e('None', 'BeRocket_AJAX_domain') ?>
                    </li>
                <?php
                foreach( $categories as $category ){
                    ?>
                    <li>
                        <?php
                        if ( @ (int)$category->depth ) for ( $depth_i = 0; $depth_i < $category->depth*3; $depth_i++ ) echo "&nbsp;";
                        ?>
                        <input type="radio" name="berocket_sc_parent_product_cat" value="<?php echo @ $category->slug ?>" data-sc_change="0" data-sc="parent_product_cat" class="berocket_aapf_widget_sc berocket_sc_parent_product_cat berocket_aapf_widget_admin_height_input" />
                        <?php echo @ $category->name ?>
                    </li>
                    <?php
                } ?>
                </ul>
            </p>
            <p>
                <label for="berocket_sc_depth_count"><?php _e('Deep level:', 'BeRocket_AJAX_domain') ?></label>
                <input data-sc_change="0" data-sc="depth_count" class="berocket_aapf_widget_sc" id="berocket_sc_depth_count" type="number" min=1 value="1" />
            </p>
        </div>
    </div>
    </div>
    <div class="br_clearfix"></div>
    <div class="br_accordion">
        <h3><?php _e('Advanced Settings', 'BeRocket_AJAX_domain') ?></h3>
        <div class='berocket_aapf_advanced_settings'>
            <p>
                <input data-sc_change="0" data-sc="widget_is_hide" class="berocket_aapf_widget_sc" id="berocket_sc_widget_is_hide" type="checkbox" value="1" />
                <label for="berocket_sc_widget_is_hide"><?php _e('Hide this widget on load?', 'BeRocket_AJAX_domain') ?></label>
            </p>
            <p class="berocket_aapf_widget_admin_non_price_tag_cloud" style="display:none;">
                <input data-sc_change="0" data-sc="show_product_count_per_attr" class="berocket_aapf_widget_sc" id="berocket_sc_show_product_count_per_attr" type="checkbox" value="1" />
                <label for="berocket_sc_show_product_count_per_attr"><?php _e('Show product count per attributes?', 'BeRocket_AJAX_domain') ?></label>
            </p>
            <p>
                <input data-sc_change="0" data-sc="hide_collapse_arrow" class="berocket_aapf_widget_sc" id="berocket_sc_hide_collapse_arrow" type="checkbox" value="1" />
                <label for="berocket_sc_hide_collapse_arrow"><?php _e('Hide collapse arrow?', 'BeRocket_AJAX_domain') ?></label>
            </p>
            <p class="berocket_aapf_widget_admin_non_price_tag_cloud_select" style="display:none;">
                <input data-sc_change="0" data-sc="hide_child_attributes" class="berocket_aapf_widget_sc" id="berocket_sc_hide_child_attributes" type="checkbox" value="1" />
                <label for="berocket_sc_hide_child_attributes"><?php _e('Hide all child values?', 'BeRocket_AJAX_domain') ?></label>
            </p>
            <p class="berocket_aapf_advanced_color_pick_settings" style='display: none;'>
                <input data-sc_change="0" data-sc="use_value_with_color" class="berocket_aapf_widget_sc" id="berocket_sc_use_value_with_color" type="checkbox" value="1" />
                <label for="berocket_sc_use_value_with_color"><?php _e('Display value with color box?', 'BeRocket_AJAX_domain') ?></label>
            </p>
            <p class="br_admin_full_size" style='display: none;'>
                <label class="br_admin_center"><?php _e('Values per row', 'BeRocket_AJAX_domain') ?></label>
                <select id="berocket_sc_values_per_row" data-sc_change="0" data-sc="values_per_row" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_values_per_row br_select_menu_left">
                    <option selected value="1">Default</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </p>
            <div class="br_accordion br_icons">
                <h3><?php _e('Icons', 'BeRocket_AJAX_domain') ?></h3>
                <div>
                    <label class="br_admin_center"><?php _e('Title Icons', 'BeRocket_AJAX_domain') ?></label>
                    <div class="br_clearfix"></div>
                    <div class="br_admin_half_size_left"><?php echo berocket_font_select_upload(__('Before', 'BeRocket_AJAX_domain'), 'berocket_sc_icon_before_title', 'berocket_sc_icon_before_title', '', TRUE, TRUE, TRUE, 'icon_before_title' ); ?></div>
                    <div class="br_admin_half_size_right"><?php echo berocket_font_select_upload(__('After', 'BeRocket_AJAX_domain'), 'berocket_sc_icon_after_title' , 'berocket_sc_icon_after_title' , '', TRUE, TRUE, TRUE, 'icon_after_title' ); ?></div>
                    <div class="br_clearfix"></div>
                    <div class="berocket_aapf_icons_select_block">
                        <label class="br_admin_center"><?php _e('Value Icons', 'BeRocket_AJAX_domain') ?></label>
                        <div class="br_clearfix"></div>
                        <div class="br_admin_half_size_left"><?php echo berocket_font_select_upload(__('Before', 'BeRocket_AJAX_domain'), 'berocket_sc_icon_before_value', 'berocket_sc_icon_before_value', '', TRUE, TRUE, TRUE, 'icon_before_value' ); ?></div>
                        <div class="br_admin_half_size_right"><?php echo berocket_font_select_upload(__('After', 'BeRocket_AJAX_domain'), 'berocket_sc_icon_after_value' , 'berocket_sc_icon_after_value' , '', TRUE, TRUE, TRUE, 'icon_after_value' ); ?></div>
                        <div class="br_clearfix"></div>
                    </div>
                </div>
            </div>
            <p>
                <label class="br_admin_center" style="text-align: left;" for="berocket_sc_description"><?php _e('Description', 'BeRocket_AJAX_domain') ?></label>
                <textarea data-sc_change="0" data-sc="description" class="berocket_aapf_widget_sc" style="resize: none; width: 100%;" id="berocket_sc_description"></textarea>
            </p>
            <p>
                <label class="br_admin_center" style="text-align: left;" for="berocket_sc_css_class"><?php _e('CSS Class', 'BeRocket_AJAX_domain') ?> </label>
                <input id="berocket_sc_css_class" type="text" value="" data-sc_change="0" data-sc="css_class" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_css_class_input br_admin_full_size" />
                <small class="br_admin_center" style="font-size: 1em;"><?php _e('(use white space for multiple classes)', 'BeRocket_AJAX_domain') ?></small>
            </p>
            <div class="berocket_aapf_widget_admin_tag_cloud_block" style="display:none;">
                <p>
                    <label for="berocket_sc_tag_cloud_height"><?php _e('Tags Cloud Height:', 'BeRocket_AJAX_domain') ?> </label>
                    <input id="berocket_sc_tag_cloud_height" type="text" value="0" data-sc_change="0" data-sc="tag_cloud_height" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_height_input" />px
                </p>
                <p>
                    <label for="berocket_sc_tag_cloud_min_font"><?php _e('Min Font Size:', 'BeRocket_AJAX_domain') ?> </label>
                    <input id="berocket_sc_tag_cloud_min_font" type="text" value="12" data-sc_change="0" data-sc="tag_cloud_min_font" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_height_input" />px
                </p>
                <p>
                    <label for="berocket_sc_tag_cloud_max_font"><?php _e('Max Font Size:', 'BeRocket_AJAX_domain') ?> </label>
                    <input id="berocket_sc_tag_cloud_max_font" type="text" value="14" data-sc_change="0" data-sc="tag_cloud_max_font" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_height_input" />px
                </p>
                <p>
                    <label for="berocket_sc_tag_cloud_tags_count"><?php _e('Max Tags Count:', 'BeRocket_AJAX_domain') ?> </label>
                    <input id="berocket_sc_tag_cloud_tags_count" type="text" value="100" data-sc_change="0" data-sc="tag_cloud_tags_count" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_height_input" />
                </p>
            </div>
            <div class="berocket_aapf_widget_admin_price_attribute">
                <div class="br_admin_half_size_left">
                    <p class="berocket_aapf_checked_show_next">
                        <input id="berocket_sc_use_min_price" type="checkbox" value="1" data-sc_change="0" data-sc="use_min_price" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_input_price_is"/>
                        <label class="br_admin_full_size" for="berocket_sc_use_min_price"><?php _e('Use min price', 'BeRocket_AJAX_domain') ?></label>
                    </p>
                    <p style="display:none">
                        <input type=number min=0 id="berocket_sc_min_price" value="0" data-sc_change="0" data-sc="min_price" class="berocket_aapf_widget_sc br_admin_full_size berocket_aapf_widget_admin_input_price">
                    </p>
                </div>
                <div class="br_admin_half_size_right">
                    <p class="berocket_aapf_checked_show_next">
                        <input id="berocket_sc_use_max_price" type="checkbox" value="1" data-sc_change="0" data-sc="use_max_price" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_input_price_is"/>
                        <label class="br_admin_full_size" for="berocket_sc_use_max_price"><?php _e('Use max price', 'BeRocket_AJAX_domain') ?></label>
                    </p>
                    <p style="display:none">
                        <input type=number min=1 id="berocket_sc_max_price"  value="1" data-sc_change="0" data-sc="max_price" class="berocket_aapf_widget_sc br_admin_full_size berocket_aapf_widget_admin_input_price">
                    </p>
                </div>
                <div class="br_clearfix"></div>
            </div>
            <p>
                <label for="berocket_sc_height"><?php _e('Filter Box Height:', 'BeRocket_AJAX_domain') ?> </label>
                <input id="berocket_sc_height" type="text" value="auto" data-sc_change="0" data-sc="height" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_height_input" />px
            </p>
            <p>
                <label for="berocket_sc_scroll_theme"><?php _e('Scroll Theme:', 'BeRocket_AJAX_domain') ?> </label>
                <select id="berocket_sc_scroll_theme" data-sc_change="0" data-sc="scroll_theme" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_scroll_theme_select br_select_menu_left">
                    <?php
                    $scroll_themes = array("light", "dark", "minimal", "minimal-dark", "light-2", "dark-2", "light-3", "dark-3", "light-thick", "dark-thick", "light-thin",
                        "dark-thin", "inset", "inset-dark", "inset-2", "inset-2-dark", "inset-3", "inset-3-dark", "rounded", "rounded-dark", "rounded-dots",
                        "rounded-dots-dark", "3d", "3d-dark", "3d-thick", "3d-thick-dark");
                    foreach( $scroll_themes as $theme ): ?>
                        <option><?php echo @ $theme; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <div class="br_aapf_child_parent_selector" style='display: none;'>
                <p>
                    <label class="br_admin_center"><?php _e('Child/Parent Limitation', 'BeRocket_AJAX_domain') ?></label>
                    <select id="child_parent" data-sc_change="0" data-sc="child_parent" class="berocket_aapf_widget_sc br_select_menu_left berocket_aapf_widget_child_parent_select">
                        <option value="" selected><?php _e('Default', 'BeRocket_AJAX_domain') ?></option>
                        <option value="depth"><?php _e('Child Count', 'BeRocket_AJAX_domain') ?></option>
                        <option value="parent"><?php _e('Parent', 'BeRocket_AJAX_domain') ?></option>
                        <option value="child"><?php _e('Child', 'BeRocket_AJAX_domain') ?></option>
                    </select>
                </p>
                <p class="berocket_aapf_widget_child_parent_depth_block" style="display: none;">
                    <label class="br_admin_full_size"><?php _e('Child depth', 'BeRocket_AJAX_domain') ?></label>
                    <input data-sc_change="0" data-sc="child_parent_depth" class="br_admin_full_size berocket_aapf_widget_sc" type="number" min="1" value="1">
                    <label><?php _e('"No values" messages', 'BeRocket_AJAX_domain') ?></label>
                    <input data-sc_change="0" data-sc="child_parent_no_values" class="br_admin_full_size berocket_aapf_widget_sc" type="text" value="">
                    <label><?php _e('"Select previous" messages', 'BeRocket_AJAX_domain') ?></label>
                    <input data-sc_change="0" data-sc="child_parent_previous" class="br_admin_full_size berocket_aapf_widget_sc" type="text" value="">
                    <label><?php _e('"No Products" messages', 'BeRocket_AJAX_domain') ?></label>
                    <input data-sc_change="0" data-sc="child_parent_no_products" class="br_admin_full_size berocket_aapf_widget_sc" type="text" value="">
                </p>
                
                
                
                
                
                
                
                
                <div class="berocket_aapf_widget_child_parent_one_widget" style="display: none;">
                    <label class="br_admin_full_size"><?php _e('Child count', 'BeRocket_AJAX_domain') ?></label>
                    <select class="br_onew_child_count_select br_select_menu_left berocket_aapf_widget_sc" data-sc_change="0" data-sc="child_onew_count">
                        <?php 
                        for($i = 1; $i < 11; $i++) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <?php 
                    for($i = 1; $i < 11; $i++) {
                        ?>
                        <div class="child_onew_childs_settings child_onew_childs_<?php echo $i; ?>"<?php if($i > 1) echo ' style="display:none;"'; ?>>
                            <h4 class="br_admin_full_size"><?php echo __('Child', 'BeRocket_AJAX_domain').' '.$i; ?></h4>
                            <div>
                                <label><?php _e('Title', 'BeRocket_AJAX_domain') ?></label>
                                <input data-sc_change="0" data-sc="title" class="br_admin_full_size berocket_aapf_childs_sc" type="text" value="">
                            </div>
                            <div>
                                <label><?php _e('"No products" messages', 'BeRocket_AJAX_domain') ?></label>
                                <input data-sc_change="0" data-sc="no_product" class="br_admin_full_size berocket_aapf_childs_sc" type="text" value="">
                            </div>
                            <div>
                                <label><?php _e('"No values" messages', 'BeRocket_AJAX_domain') ?></label>
                                <input data-sc_change="0" data-sc="no_values" class="br_admin_full_size berocket_aapf_childs_sc" type="text" value="">
                            </div>
                            <div>
                                <label><?php _e('"Select previous" messages', 'BeRocket_AJAX_domain') ?></label>
                                <input data-sc_change="0" data-sc="previous" class="br_admin_full_size berocket_aapf_childs_sc" type="text" value="">
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                
                
                
                
                
                
                
                
                
                
            </div>
        </div>
    </div>
</div>
<div class="berocket_aapf_admin_widget_selected_area" style="display: none;">
    <p>
        <label>
            <input data-sc_change="0" data-sc="selected_area_show" class="berocket_aapf_widget_sc" type="checkbox" id="berocket_sc_selected_area_show" value="1" />
            <?php _e('Show if nothing is selected', 'BeRocket_AJAX_domain') ?>
        </label>
    </p>
    <p>
        <label>
            <input data-sc_change="0" data-sc="hide_selected_arrow" class="berocket_aapf_widget_sc" type="checkbox" id="berocket_sc_hide_selected_arrow" value="1" />
            <?php _e('Hide collapse arrow?', 'BeRocket_AJAX_domain') ?>
        </label>
    </p>
    <p>
        <label>
            <input data-sc_change="0" data-sc="selected_is_hide" class="berocket_aapf_widget_sc" type="checkbox" id="berocket_sc_selected_is_hide" value="1" />
            <?php _e('Hide this widget on load?', 'BeRocket_AJAX_domain') ?>
        </label>
    </p>
</div>
<div class="berocket_aapf_admin_search_box" style="display:none;">
    <div class="br_accordion">
        <h3><?php _e('Attributes', 'BeRocket_AJAX_domain') ?></h3>
        <div>
            <label><?php _e('URL to search', 'BeRocket_AJAX_domain') ?></label>
            <select data-sc_change="0" data-sc="search_box_link_type" class="berocket_search_link_select br_select_menu_left berocket_aapf_widget_sc">
                <option value="shop_page"><?php _e('Shop page', 'BeRocket_AJAX_domain') ?></option>
                <option value="category"><?php _e('Category page', 'BeRocket_AJAX_domain') ?></option>
                <option value="url"><?php _e('URL', 'BeRocket_AJAX_domain') ?></option>
            </select>
            <p class="berocket_search_link berocket_search_link_category" style="display:none;">
                <label><?php _e('Category', 'BeRocket_AJAX_domain') ?></label>
                <select data-sc_change="0" data-sc="search_box_category" class="br_select_menu_left berocket_aapf_widget_sc">
                <?php 
                foreach( $categories as $category ){
                    echo '<option value="'.$category->slug.'">'.$category->name.'</option>';
                } ?>
                </select>
            </p>
            <p class="berocket_search_link berocket_search_link_url" style="display:none;">
                <label><?php _e('URL for search', 'BeRocket_AJAX_domain') ?></label>
                <input data-sc_change="0" data-sc="search_box_url" class="br_admin_full_size berocket_aapf_widget_sc" type="text" value="">
            </p>
            <div>
                <label><?php _e('Attributes count', 'BeRocket_AJAX_domain') ?></label>
                <select data-sc_change="0" data-sc="search_box_count" class="br_search_box_count br_select_menu_left berocket_aapf_widget_sc">
                    <?php 
                    for ( $i = 1; $i < 11; $i++ ) {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                    ?>
                </select>
            </div>
            <?php for( $i = 1; $i < 11; $i++ ) {
                echo '<div class="berocket_search_box_attribute_'.$i.'"'.(1 >= $i ? '' : ' style="display:none;"').'>';
                ?>
                <div class="br_accordion">
                    <h3><?php _e('Attribute', 'BeRocket_AJAX_domain') ?> <?php echo $i; ?></h3>
                    <div class="br_search_box_attribute_block">
                        <p>
                            <label class="br_admin_center"><?php _e('Title', 'BeRocket_AJAX_domain') ?> </label>
                            <input data-sc_change="0" data-sc="title" class="br_admin_full_size berocket_aapf_sb_attributes_sc" type="text" value=""/>
                        </p>
                        <p class="br_admin_half_size_left">
                            <label class="br_admin_center"><?php _e('Filter By', 'BeRocket_AJAX_domain') ?></label>
                            <select data-sc_change="0" data-sc="type" class="br_search_box_attribute_type br_select_menu_left berocket_aapf_sb_attributes_sc">
                                <option value="attribute"><?php _e('Attribute', 'BeRocket_AJAX_domain') ?></option>
                                <option value="tag"><?php _e('Tag', 'BeRocket_AJAX_domain') ?></option>
                                <option value="custom_taxonomy"><?php _e('Custom Taxonomy', 'BeRocket_AJAX_domain') ?></option>
                            </select>
                        </p>
                        <p class="br_admin_half_size_right br_search_box_attribute_attribute_block">
                            <label class="br_admin_center"><?php _e('Attribute', 'BeRocket_AJAX_domain') ?></label>
                            <select data-sc_change="1" data-sc="attribute" class="br_search_box_attribute_attribute br_select_menu_right berocket_aapf_sb_attributes_sc">
                                <?php foreach ( @ $attributes as $k => $v ) { ?>
                                    <option value="<?php echo @ $k ?>"><?php echo @ $v ?></option>
                                <?php } ?>
                            </select>
                        </p>
                        <p class="br_admin_half_size_right br_search_box_attribute_custom_taxonomy_block" style="display: none;">
                            <label class="br_admin_center"><?php _e('Custom Taxonomies', 'BeRocket_AJAX_domain') ?></label>
                            <select data-sc_change="1" data-sc="custom_taxonomy" class="br_search_box_attribute_custom_taxonomy br_select_menu_right berocket_aapf_sb_attributes_sc">
                                <?php foreach( $custom_taxonomies as $k => $v ){ ?>
                                    <option value="<?php echo @ $k ?>"><?php echo @ $v ?></option>
                                <?php } ?>
                            </select>
                        </p>
                        <div class="br_clearfix"></div>
                        <p>
                            <label class="br_admin_center"><?php _e('Type', 'BeRocket_AJAX_domain') ?></label>
                            <select data-sc_change="0" data-sc="visual_type" class="br_select_menu_left berocket_aapf_sb_attributes_sc">
                                <option value="select"><?php _e('Select', 'BeRocket_AJAX_domain') ?></option>
                                <option value="checkbox"><?php _e('Checkbox', 'BeRocket_AJAX_domain') ?></option>
                                <option value="radio"><?php _e('Radio', 'BeRocket_AJAX_domain') ?></option>
                                <option value="color"><?php _e('Color', 'BeRocket_AJAX_domain') ?></option>
                                <option value="image"><?php _e('Image', 'BeRocket_AJAX_domain') ?></option>
                            </select>
                        </p>
                    </div>
                </div>
                <?php
                echo '</div>';
            } ?>
            <div class="br_clearfix"></div>
        </div>
    </div>
    <div class="br_accordion">
        <h3><?php _e('Styles', 'BeRocket_AJAX_domain') ?></h3>
        <div>
            <div>
                <label><?php _e('Elements position', 'BeRocket_AJAX_domain') ?></label>
                <select data-sc_change="0" data-sc="position" class="br_select_menu_left berocket_aapf_style_sb_sc">
                    <option value="vertical"><?php _e('Vertical', 'BeRocket_AJAX_domain') ?></option>
                    <option value="horizontal"><?php _e('Horizontal', 'BeRocket_AJAX_domain') ?></option>
                </select>
            </div>
            <div>
                <label><?php _e('Search button position', 'BeRocket_AJAX_domain') ?></label>
                <select data-sc_change="0" data-sc="search_position" class="br_select_menu_left berocket_aapf_style_sb_sc">
                    <option value="before"><?php _e('Before', 'BeRocket_AJAX_domain') ?></option>
                    <option value="after"><?php _e('After', 'BeRocket_AJAX_domain') ?></option>
                    <option value="before_after"><?php _e('Before and after', 'BeRocket_AJAX_domain') ?></option>
                </select>
            </div>
            <div>
                <label><?php _e('Search button text', 'BeRocket_AJAX_domain') ?></label>
                <input data-sc_change="0" data-sc="search_text" type="text" class="br_admin_full_size berocket_aapf_style_sb_sc" value="">
            </div>
            <div>
                <label><?php _e('Background color', 'BeRocket_AJAX_domain') ?></label>
                <div class="colorpicker_field_sc" data-color="000000"></div>
                <input data-sc_change="0" data-sc="background" type="hidden" value="" class="berocket_aapf_style_sb_sc">
            </div>
            <div>
                <label><?php _e('Background transparency', 'BeRocket_AJAX_domain') ?></label>
                <select data-sc_change="0" data-sc="back_opacity" class="br_select_menu_left berocket_aapf_style_sb_sc">
                    <option value="0"><?php _e('100%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.1"><?php _e('90%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.2"><?php _e('80%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.3"><?php _e('70%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.4"><?php _e('60%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.5"><?php _e('50%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.6"><?php _e('40%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.7"><?php _e('30%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.8"><?php _e('20%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="0.9"><?php _e('10%', 'BeRocket_AJAX_domain') ?></option>
                    <option value="1"><?php _e('0%', 'BeRocket_AJAX_domain') ?></option>
                </select>
            </div>
            <div>
                <label><?php _e('Button background color', 'BeRocket_AJAX_domain') ?></label>
                <div class="colorpicker_field_sc" data-color="000000"></div>
                <input data-sc_change="0" data-sc="button_background" type="hidden" value="" class="berocket_aapf_style_sb_sc">
            </div>
            <div>
                <label><?php _e('Button background color on mouse over', 'BeRocket_AJAX_domain') ?></label>
                <div class="colorpicker_field_sc" data-color="000000"></div>
                <input data-sc_change="0" data-sc="button_background_over" type="hidden" value="" class="berocket_aapf_style_sb_sc">
            </div>
            <div>
                <label><?php _e('Button text color', 'BeRocket_AJAX_domain') ?></label>
                <div class="colorpicker_field_sc" data-color="000000"></div>
                <input data-sc_change="0" data-sc="text_color" type="hidden" value="" class="berocket_aapf_style_sb_sc">
            </div>
            <div>
                <label><?php _e('Button text color on mouse over', 'BeRocket_AJAX_domain') ?></label>
                <div class="colorpicker_field_sc" data-color="000000"></div>
                <input data-sc_change="0" data-sc="text_color_over" type="hidden" value="" class="berocket_aapf_style_sb_sc">
            </div>
        </div>
    </div>
</div>
<div class="br_accordion">
    <h3><?php _e('Widget Output Limitations', 'BeRocket_AJAX_domain') ?></h3>
    <div>
        <p>
            <label>
                <input data-sc_change="0" data-sc="is_hide_mobile" class="berocket_aapf_widget_sc" type="checkbox" id="berocket_sc_is_hide_mobile" value="1" />
                <?php _e('Hide this widget on mobile?', 'BeRocket_AJAX_domain') ?>
            </label>
        </p>
        <p>
            <label><?php _e('Product Category:', 'BeRocket_AJAX_domain') ?>
                <label class="berocket_aapf_advanced_settings_subcategory">
                    <input type="checkbox" id="berocket_sc_cat_propagation" value="1" data-sc_change="0" data-sc="cat_propagation" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_height_input" />
                    <?php _e('include subcats?', 'BeRocket_AJAX_domain') ?>
                </label>
            </label>
            <ul class="berocket_aapf_advanced_settings_categories_list">
                <?php
                $p_cat = @json_decode( $instance['product_cat'] );

                foreach( $categories as $category ){
                    $selected_category = false;
                    ?>
                    <li>
                        <?php
                        if ( @ (int)$category->depth ) for ( $depth_i = 0; $depth_i < $category->depth*3; $depth_i++ ) echo "&nbsp;";
                        ?>
                        <input type="checkbox" value="<?php echo @ $category->slug ?>" data-sc_change="0" data-sc="product_cat" class="berocket_aapf_widget_sc berocket_aapf_widget_admin_height_input" />
                        <?php echo @ $category->name ?>
                    </li>
                <?php } ?>
            </ul>
        </p>
        <div class="br_accordion">
            <h3><?php _e('Dispay widget pages', 'BeRocket_AJAX_domain') ?></h3>
            <div  style="display: none;">
                <ul>
                    <li><label>
                        <input data-sc_change="0" data-sc="show_page" class="berocket_aapf_widget_sc" type="checkbox" checked value="shop" />
                        <?php _e('shop', 'BeRocket_AJAX_domain') ?>
                    </label></li>
                    <li><label>
                        <input data-sc_change="0" data-sc="show_page" class="berocket_aapf_widget_sc" type="checkbox" checked value="product_cat" />
                        <?php _e('product category', 'BeRocket_AJAX_domain') ?>
                    </label></li>
                    <li><label>
                        <input data-sc_change="0" data-sc="show_page" class="berocket_aapf_widget_sc" type="checkbox" checked value="product_taxonomy" />
                        <?php _e('product attributes', 'BeRocket_AJAX_domain') ?>
                    </label></li>
                    <li><label>
                        <input data-sc_change="0" data-sc="show_page" class="berocket_aapf_widget_sc" type="checkbox" checked value="product_tag" />
                        <?php _e('product tags', 'BeRocket_AJAX_domain') ?>
                    </label></li>
                    <?php
                    $pages = get_pages();
                    foreach ( $pages as $page ) {
                        ?>
                        <li><label>
                            <input data-sc_change="0" data-sc="show_page" class="berocket_aapf_widget_sc" type="checkbox" value="<?php echo @ $page->ID ?>" />
                            <?php echo @ $page->post_title; ?>
                        </label></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="br_accordion">
            <h3><?php _e('Product Category Value Limitation', 'BeRocket_AJAX_domain') ?></h3>
            <div>
                <ul>
                    <li>
                        <input name="berocket_sc_cat_value_limit" data-sc_change="0" data-sc="cat_value_limit" class="berocket_aapf_widget_sc" type="radio" checked value="0"/>
                        <?php _e('Disable', 'BeRocket_AJAX_domain') ?>
                    </li>
                <?php
                foreach( $categories as $category ){
                    ?>
                    <li>
                        <?php
                        if ( @ (int)$category->depth ) for ( $depth_i = 0; $depth_i < $category->depth*3; $depth_i++ ) echo "&nbsp;";
                        ?>
                        <input name="berocket_sc_cat_value_limit" data-sc_change="0" data-sc="cat_value_limit" class="berocket_aapf_widget_sc" type="radio" value="<?php echo @ $category->slug ?>"/>
                        <?php echo @ $category->name ?>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    if( typeof(br_widget_set) == 'function' )
        br_widget_set();
</script>
<input type="button" class="get_shortcode button-secondary" value="<?php _e('Get Shortcode', 'BeRocket_AJAX_domain') ?>" />
        </div>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'BeRocket_AJAX_domain') ?>" />
        </p>
    </form>
    <h4><?php _e('WooCommerce AJAX Product Filters developed by', 'BeRocket_AJAX_domain') ?> <a href="http://berocket.com" target="_blank">BeRocket</a></h4>
</div>
<h3><?php _e( 'Tools', 'woocommerce-store-toolkit' ); ?></h3>

<h4><a href="<?php echo esc_url( add_query_arg( array( 'action' => 'relink-rogue-simple-type', '_wpnonce' => wp_create_nonce( 'woo_st_relink_rogue_simple_type' ) ) ) ); ?>"><?php _e( 'Re-link rogue Products to the Simple Product Type', 'woocommerce-store-toolkit' ); ?></a></h4>
<p class="description"><?php _e( 'Scan the WooCommerce Products catalogue for Products that do not have any Product Type assigned to them and assign them to the default Simple Product Type.', 'woocommerce-store-toolkit' ); ?></p>
<hr />

<h4><a href="<?php echo esc_url( add_query_arg( array( 'action' => 'refresh-product-transients', '_wpnonce' => wp_create_nonce( 'woo_st_refresh_product_transients' ) ) ) ); ?>"><?php _e( 'Refresh Product Transients', 'woocommerce-store-toolkit' ); ?></a></h4>
<p class="description"><?php _e( 'Clear the Product transients for all WooCommerce Products.', 'woocommerce-store-toolkit' ); ?></p>
<hr />

<form method="post">

	<h4><?php _e( 'Generate Sample Products', 'woocommerce-store-toolkit' ); ?></h4>

	<p>Number of Products to generate: <input type="text" name="limit" value="100" /></p>

	<p>Product Names: <input type="text" name="product_name" value="Sample Product %count%" /></p>
	<p class="description">Tags can be used on this field. Supported Tags include <code>%count%</code>.</p>

	<p>Product SKU: <input type="text" name="sku" value="SAMPLE-%count%" /></p>
	<p class="description">Tags can be used on this field. Supported Tags include <code>%count%</code>.</p>

	<p>Short Description: <input type="text" name="short_description" value="Short description for Sample Product %count%" /></p>
	<p class="description">Tags can be used on this field. Supported Tags include <code>%count%</code>.</p>

	<p>Description: <input type="text" name="description" value="Description for Sample Product %count%" /></p>
	<p class="description">Tags can be used on this field. Supported Tags include <code>%count%</code>.</p>

	<p><input type="submit" value="<?php _e( 'Generate Products', 'woocommerce-store-toolkit' ); ?>" class="button-primary" /></p>
	<input type="hidden" name="action" value="woo_st-generate_products" />
	<?php wp_nonce_field( 'generate_products', 'woo_st-generate_products' ); ?>

</form>
<hr />

<form method="post">

	<h4><?php _e( 'General Options', 'woocommerce-store-toolkit' ); ?></h4>

	<p><label><input type="checkbox" name="autocomplete_order" value="1"<?php checked( $autocomplete_order, 1 ); ?>><?php _e( 'Assign Completed Order Status to new Orders with 0 totals', 'woocommerce-store-toolkit' ); ?></label></p>
	<p class="description"><?php _e( 'Auto-complete Orders with 0 (zero) Order totals.', 'woocommerce-store-toolkit' ); ?></p>

	<p><label><input type="checkbox" name="unlock_variations" value="1"<?php checked( $unlock_variations, 1 ); ?>><?php _e( 'Unlock the Edit Product screen for Variations', 'woocommerce-store-toolkit' ); ?></label></p>
	<p class="description"><?php _e( 'View Product Variation data within the WordPress Administration from the Variations menu item.', 'woocommerce-store-toolkit' ); ?></p>

	<p><input type="submit" value="<?php _e( 'Save changes', 'woocommerce-store-toolkit' ); ?>" class="button-primary" /></p>
	<input type="hidden" name="action" value="woo_st-tools" />
	<?php wp_nonce_field( 'tools', 'woo_st-tools' ); ?>

</form>
<hr />
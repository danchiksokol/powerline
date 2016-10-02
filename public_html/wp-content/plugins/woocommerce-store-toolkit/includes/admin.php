<?php
// Display admin notice on screen load
function woo_st_admin_notice( $message = '', $priority = 'updated', $screen = '' ) {

	if( $priority == false || $priority == '' )
		$priority = 'updated';
	if( $message <> '' ) {
		ob_start();
		woo_st_admin_notice_html( $message, $priority, $screen );
		$output = ob_get_contents();
		ob_end_clean();
		// Check if an existing notice is already in queue
		$existing_notice = get_transient( WOO_ST_PREFIX . '_notice' );
		if( $existing_notice !== false ) {
			$existing_notice = base64_decode( $existing_notice );
			$output = $existing_notice . $output;
		}
		set_transient( WOO_ST_PREFIX . '_notice', base64_encode( $output ), MINUTE_IN_SECONDS );
		add_action( 'admin_notices', 'woo_st_admin_notice_print' );
	}

}

// HTML template for admin notice
function woo_st_admin_notice_html( $message = '', $priority = 'updated', $screen = '' ) {

	// Display admin notice on specific screen
	if( !empty( $screen ) ) {

		global $pagenow;

		if( is_array( $screen ) ) {
			if( in_array( $pagenow, $screen ) == false )
				return;
		} else {
			if( $pagenow <> $screen )
				return;
		}

	} ?>
<div id="message" class="<?php echo $priority; ?>">
	<p><?php echo $message; ?></p>
</div>
<?php

}

// Grabs the WordPress transient that holds the admin notice and prints it
function woo_st_admin_notice_print() {

	$output = get_transient( WOO_ST_PREFIX . '_notice' );
	if( $output !== false ) {
		$output = base64_decode( $output );
		echo $output;
		delete_transient( WOO_ST_PREFIX . '_notice' );
	
	}

}

// Add Store Toolkit, Docs links to the Plugins screen
function woo_st_add_settings_link( $links, $file ) {

	$this_plugin = plugin_basename( WOO_ST_RELPATH );
	if( $file == $this_plugin ) {
		$docs_url = 'http://www.visser.com.au/docs/';
		$docs_link = sprintf( '<a href="%s" target="_blank">' . __( 'Docs', 'woocommerce-store-toolkit' ) . '</a>', $docs_url );
		$settings_link = sprintf( '<a href="%s">' . __( 'Settings', 'woocommerce-store-toolkit' ) . '</a>', esc_url( add_query_arg( 'page', 'woo_st', 'admin.php' ) ) );
		array_unshift( $links, $docs_link );
		array_unshift( $links, $settings_link );
	}
	return $links;

}
add_filter( 'plugin_action_links', 'woo_st_add_settings_link', 10, 2 );

// Load CSS and jQuery scripts for Store Toolkit screen
function woo_st_enqueue_scripts( $hook ) {

	// Simple check that WooCommerce is activated
	if( class_exists( 'WooCommerce' ) ) {

		global $woocommerce;

		wp_enqueue_style( 'woocommerce_admin_styles', $woocommerce->plugin_url() . '/assets/css/admin.css' );

	}

	// Settings
	$pages = array( 'woocommerce_page_woo_st', 'edit-tags.php', 'user-edit.php', 'profile.php' );
	if( in_array( $hook, $pages ) ) {
		wp_enqueue_style( 'woo_st_styles', plugins_url( '/templates/admin/toolkit.css', WOO_ST_RELPATH ) );
		wp_enqueue_script( 'woo_st_scripts', plugins_url( '/templates/admin/toolkit.js', WOO_ST_RELPATH ), array( 'jquery' ) );
	}

}
add_action( 'admin_enqueue_scripts', 'woo_st_enqueue_scripts' );

function woo_st_permanent_delete_link( $actions, $post ) {

	// Check that the User can manage_woocommerce
	if ( ! current_user_can( apply_filters( 'woo_st_permanent_delete_capability', 'manage_woocommerce' ) ) ) {
		return $actions;
	}

	// Limit to the Product CPT screen
	if ( $post->post_type != 'product' ) {
		return $actions;
	}

	// Do not show for the Trash screen
	$post_status = ( isset( $_REQUEST['post_status'] ) ? $_REQUEST['post_status'] : false );
	if( !empty( $post_status ) ) {
		if( $post_status == 'trash' )
			return $actions;
	}

	$actions['permanent_delete'] = '<span class="delete"><a href="' . wp_nonce_url( admin_url( 'edit.php?post_type=product&ids=' . $post->ID . '&action=permanent_delete_product' ), 'woo_st-permanent_delete_' . $post->ID ) . '" title="' . esc_attr__( 'Permanently delete this product', 'woocommerce-store-toolkit' ) . '" rel="permalink">' .  __( 'Delete Permanently', 'woocommerce' ) . '</a></span>';

	return $actions;

}
add_filter( 'post_row_actions', 'woo_st_permanent_delete_link', 10, 2 );
add_filter( 'page_row_actions', 'woo_st_permanent_delete_link', 10, 2 );

function woo_st_permanent_delete_product_action() {

	if ( empty( $_REQUEST['ids'] ) ) {
		wp_die( __( 'No product to permanently delete has been supplied!', 'woocommerce-store-toolkit' ) );
	}

	// Get the original page
	$id = isset( $_REQUEST['ids'] ) ? absint( $_REQUEST['ids'] ) : '';

	check_admin_referer( 'woo_st-permanent_delete_' . $id );

	// Delete the Post
	$deleted = 0;
	if ( !empty( $id ) ) {
		wp_delete_post( $id, true );
		$deleted++;
		$post_type = 'product';
		$url = add_query_arg( array( 'post_type' => $post_type, 'action' => null, '_wpnonce' => null, 'ids' => $id, 'deleted' => $deleted ), 'edit.php' );
		wp_redirect( $url );
		exit();
	} else {
		wp_die( __( 'Permanently delete Product failed, could not find original product:', 'woocommerce' ) . ' ' . $id );
	}

}
add_action( 'admin_action_permanent_delete_product', 'woo_st_permanent_delete_product_action' );

function woo_st_permanent_delete_product_bulk_admin_footer() {

	global $post_type;

	// Check that the User can manage_woocommerce
	if ( ! current_user_can( apply_filters( 'woo_st_permanent_delete_capability', 'manage_woocommerce' ) ) ) {
		return;
	}

	$post_status = ( isset( $_REQUEST['post_status'] ) ? $_REQUEST['post_status'] : false );
	if( $post_type == 'product' && ( $post_status <> 'trash' ) ) { ?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('<option>').val('permanent_delete').text('<?php _e( 'Delete Permanently' )?>').appendTo("select[name='action']");
		jQuery('<option>').val('permanent_delete').text('<?php _e( 'Delete Permanently' )?>').appendTo("select[name='action2']");
	});
</script>
<?php
	}
	
}
add_action( 'admin_footer-edit.php', 'woo_st_permanent_delete_product_bulk_admin_footer' );

function woo_st_permanent_delete_product_bulk_action() {

	$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );
	$action = $wp_list_table->current_action();

	switch( $action ) {

		case 'permanent_delete':

			check_admin_referer( 'bulk-posts' );

			if ( empty( $_REQUEST['post'] ) ) {
				wp_die( __( 'No products to permanently delete have been supplied!', 'woocommerce-store-toolkit' ) );
			}

			$post_ids = ( isset( $_REQUEST['post'] ) ? $_REQUEST['post'] : '' );

			$deleted = 0;
			foreach( $post_ids as $post_id ) {
				wp_delete_post( $post_id, true );
				$deleted++;
			}
			$post_type = 'product';
			$url = add_query_arg( array( 'post_type' => $post_type, 'action' => null, '_wpnonce' => null, 'deleted' => $deleted, 'ids' => join( ',', $post_ids ) ), 'edit.php' );
			wp_redirect( $url );
			exit();
			break;

		default:
			return;
			break;

	}

}
add_action( 'load-edit.php', 'woo_st_permanent_delete_product_bulk_action' );

// HTML active class for the currently selected tab on the Store Toolkit screen
function woo_st_admin_active_tab( $tab_name = null, $tab = null ) {

	if( isset( $_GET['tab'] ) && !$tab )
		$tab = $_GET['tab'];
	else
		$tab = 'overview';

	$output = '';
	if( isset( $tab_name ) && $tab_name ) {
		if( $tab_name == $tab )
			$output = ' nav-tab-active';
	}
	echo $output;

}

// HTML template for each tab on the Store Toolkit screen
function woo_st_tab_template( $tab = '' ) {

	if( !$tab )
		$tab = 'overview';

	switch( $tab ) {

		case 'nuke':

			// Check if a previous nuke failed mid-drop
			$in_progress = woo_st_get_option( 'in_progress', false );
			if( !empty( $in_progress ) ) {
				$message = sprintf( __( 'It looks like a previous nuke failed to clear that dataset, this is common in large catalogues and is likely due to WordPress hitting a memory limit or server timeout. Don\'t stress, <a href="%s">retry %s nuke?</a>', 'woocommerce-store-toolkit' ), esc_url( add_query_arg( array( 'action' => 'nuke', 'dataset' => $in_progress ) ) ), ucfirst( $in_progress ) );
				woo_st_admin_notice_html( $message, 'error' );
				delete_option( WOO_ST_PREFIX . '_in_progress' );
			}

			$products = woo_st_return_count( 'product' );
			$images = woo_st_return_count( 'product_image' );
			$tags = woo_st_return_count( 'product_tag' );
			$categories = woo_st_return_count( 'product_category' );
			if( $categories ) {
				$term_taxonomy = 'product_cat';
				$args = array(
					'hide_empty' => 0
				);
				$categories_data = get_terms( $term_taxonomy, $args );
			}
			$orders = woo_st_return_count( 'order' );
			if( $orders ) {
				$order_statuses = woo_st_get_order_statuses();
			}
			$tax_rates = woo_st_return_count( 'tax_rate' );
			$download_permissions = woo_st_return_count( 'download_permission' );
			$coupons = woo_st_return_count( 'coupon' );
			$shipping_classes = woo_st_return_count( 'shipping_class' );
			$attributes = woo_st_return_count( 'attribute' );

			$brands = woo_st_return_count( 'product_brand' );
			$vendors = woo_st_return_count( 'product_vendor' );
			$credit_cards = woo_st_return_count( 'credit_card' );
			$google_product_feed = woo_st_return_count( 'google_product_feed' );

			$posts = woo_st_return_count( 'post' );
			$post_categories = woo_st_return_count( 'post_category' );
			$post_tags = woo_st_return_count( 'post_tag' );
			$links = woo_st_return_count( 'link' );
			$comments = woo_st_return_count( 'comment' );
			$media_images = woo_st_return_count( 'media_image' );

			$show_table = false;
			if( $products || $images || $tags || $categories || $orders || $credit_cards || $attributes )
				$show_table = true;
			break;

		case 'tools':
			$autocomplete_order = get_option( WOO_ST_PREFIX . '_autocomplete_order', 0 );
			$unlock_variations = get_option( WOO_ST_PREFIX . '_unlock_variations', 0 );
			break;

	}
	if( $tab ) {
		if( file_exists( WOO_ST_PATH . 'templates/admin/tabs-' . $tab . '.php' ) ) {
			include_once( WOO_ST_PATH . 'templates/admin/tabs-' . $tab . '.php' );
		} else {
			$message = sprintf( __( 'We couldn\'t load the export template file <code>%s</code> within <code>%s</code>, this file should be present.', 'woocommerce-store-toolkit' ), 'tabs-' . $tab . '.php', WOO_CD_PATH . 'templates/admin/...' );
			woo_st_admin_notice_html( $message, 'error' );
			ob_start(); ?>
<p><?php _e( 'You can see this error for one of a few common reasons', 'woocommerce-store-toolkit' ); ?>:</p>
<ul class="ul-disc">
	<li><?php _e( 'WordPress was unable to create this file when the Plugin was installed or updated', 'woocommerce-store-toolkit' ); ?></li>
	<li><?php _e( 'The Plugin files have been recently changed and there has been a file conflict', 'woocommerce-store-toolkit' ); ?></li>
	<li><?php _e( 'The Plugin file has been locked and cannot be opened by WordPress', 'woocommerce-store-toolkit' ); ?></li>
</ul>
<p><?php _e( 'Jump onto our website and download a fresh copy of this Plugin as it might be enough to fix this issue. If this persists get in touch with us.', 'woocommerce-store-toolkit' ); ?></p>
<?php
			ob_end_flush();
		}
	}

}

function woo_st_extend_woocommerce_system_status_report() {

	global $_wp_additional_image_sizes;

	$image_sizes = get_intermediate_image_sizes();
	ob_start(); ?>
<table class="wc_status_table widefat" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2" data-export-label="Templates"><?php _e( 'Image Sizes', 'woocommerce-store-toolkit' ); ?><?php echo wc_help_tip( __( 'This section shows all available WordPress Image Sizes.', 'woocommerce' ) ); ?></th>
		</tr>
	</thead>
	<tbody>
<?php if( !empty( $image_sizes ) ) { ?>
	<?php foreach( $image_sizes as $image_size ) { ?>
		<tr>
			<td><?php echo $image_size; ?></td>
			<td>
		<?php if( isset( $_wp_additional_image_sizes[$image_size] ) ) { ?>
				<?php echo print_r( $_wp_additional_image_sizes[$image_size], true ); ?>
		<?php } else { ?>
<?php
	// Check for default WordPress Image Sizes
	$size_info = array();
	switch( $image_size ) {

		case 'thumbnail':
			$size_info = array(
				'width' => get_option( 'thumbnail_size_w' ),
				'height' => get_option( 'thumbnail_size_h' ),
				'crop' => get_option( 'thumbnail_crop' )
			);
			break;

		case 'medium':
			$size_info = array(
				'width' => get_option( 'medium_size_w' ),
				'height' => get_option( 'medium_size_h' )
			);
			break;

		case 'medium_large':
			$size_info = array(
				'width' => get_option( 'medium_large_size_w' ),
				'height' => get_option( 'medium_large_size_h' )
			);

		case 'large':
			$size_info = array(
				'width' => get_option( 'large_size_w' ),
				'height' => get_option( 'large_size_h' )
			);
			break;

	}
?>
				<?php echo ( !empty( $size_info ) ? print_r( $size_info, true ) : '-' ); ?>
		<?php } ?>
			</td>
		</tr>
	<?php } ?>
<?php } else { ?>
		<tr>
			<td colspan="2"><?php _e( 'No Image Sizes were available.', 'woocommerce-store-toolkit' ); ?></td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php
	ob_end_flush();

}
add_action( 'woocommerce_system_status_report', 'woo_st_extend_woocommerce_system_status_report' );
?>
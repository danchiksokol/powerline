<?php
// Ensure cart contents update when products are added to the cart via AJAX
add_filter('add_to_cart_fragments', 'topshop_wc_header_add_to_cart_fragment');
 
function topshop_wc_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    
    ob_start(); ?>
        <a class="header-cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'topshop-premium'); ?>">
            <span class="header-cart-amount">
                <?php echo sprintf( _n( '(%d)', '(%d)', $woocommerce->cart->cart_contents_count, 'topshop-premium' ), $woocommerce->cart->cart_contents_count ); ?> - <?php echo $woocommerce->cart->get_cart_total(); ?>
            </span>
            <span class="header-cart-checkout<?php echo ( $woocommerce->cart->cart_contents_count > 0 ) ? ' cart-has-items' : ''; ?>">
                <span></span> <i class="fa fa-shopping-cart"></i>
            </span>
        </a>
    <?php
    $fragments['a.header-cart-contents'] = ob_get_clean();
    
    return $fragments;
}

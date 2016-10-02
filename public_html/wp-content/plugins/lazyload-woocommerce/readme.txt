=== Lazy Load for WooCommerce ===
Contributors: edgewebware,aibrean
Tags: lazy load, jquery, woocommerce, products, images, lazyload, front-end optimization, image load, image lazyload, lazy loading, placeholder, placeholder image
Donate link: https://edgewebware.com/plugins/
Requires at least: 4.0.0
Tested up to: 4.6.1
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lazy Load for WooCommerce includes the functionality to properly append Lazy Load into the image loop for WooCommerce (2.6.4 tested).

== Description ==
Lazy Load for WooCommerce includes the functionality to properly append Lazy Load into the image loop for WooCommerce in product listings (shop category and product listing). It has been tested against WooCommerce 2.6.4 and should work back to WooCommerce 2.1.0 (untested). This does not apply to the individual product image, but anywhere they are used in the loop (by default, the unordered list).

If you would like to send an email directly for support, contact us via the form at <a href="https://edgewebware.com/plugins/" target="_blank">https://edgewebware.com/plugins/</a>.

== Installation ==
1. Download the plugin
2. Install the plugin
3. Make sure your Catalog image dimensions are set to your preference (this is used for the dimensions in this plugin)
4. Go to WooCommerce > Settings > Products and click the "Lazy Load" option. 
5. Set your custom placeholder image (full src). This is optional as it will default to the WooCommerce Placeholder image.

To note, you will need to have jQuery running for this to work. To reduce conflicts, we have chosen not to include jQuery. To include jQuery, just use the following in your template functions file: `wp_enqueue_script('jquery');`

Additionally, we allow for you to modify the available functions for Lazy Load. To dequeue the plugin functions and use your own, use `wp_dequeue_script('lazyload-call');`. See http://www.appelsiini.net/projects/lazyload for a full rundown of options (trigger loading, effects, images in containers, nonsequential images, invisible images, etc.).

If you would like to send an email directly for support, contact us via the form at <a href="https://edgewebware.com/plugins/" target="_blank">https://edgewebware.com/plugins/</a>.

== Frequently Asked Questions ==
= Does this plugin work with the newest WP/WooCommerce version and also older versions? =
Since it's fairly basic it should. It's a very lightweight plugin. 

You will need to manually call in jQuery support if you don't already have it running (see Installation Instructions).

Your WooCommerce installation needs to support `shop_catalog` which has been an initiated image size since WooCommerce 1.6.2 at least. 

Secondarily, there should be support for WooCommerce's placeholder image (not an absolute requirement for loading since you can put in your own, but the tab may not be visible or in the same location in older versions of WooCommerce). The placeholder image function for WooCommerce has been updated to `wc_placeholder_img_src` so previous instances of `woocommerce_placeholder_img_src` have been deprecated as of 2.1.0.
= What is WooCommerce's image loop? =
We are basically replacing WooCommerce's hook of `woocommerce_template_loop_product_thumbnail` with our own (for Lazy Load). This is used in the `content-product.php` template file. If your WooCommerce theme has been customized (YOURTHEME/woocommerce/content-product.php) then in some cases this has been altered. The hook runs as part of `do_action( 'woocommerce_before_shop_loop_item_title' )`.

We've done the same in version 1.3 of our plugin with `woocommerce_subcategory_thumbnail`. 


= If I have a custom image loop, can I still use the plugin? =
It would probably be best if you were to manually configure the source LazyLoad script (<a href="http://www.appelsiini.net/projects/lazyload" target="_blank" rel="nofollow">http://www.appelsiini.net/projects/lazyload</a>) to reduce code bloat. It is possible to use our plugin and then add the class "lazy" to your image and replace the image src with your placeholder image and add `data-original` to link to your thumbnail. You would also need to add width/height to the image element.
== Screenshots ==
1. Setting up the placeholder for the category and product images that will be used for Lazy Load (it will match the shop catalog image dimensions).

== Changelog ==
= 1.4 =
* ADDED: Support for ALT tags for product images. 

= 1.3 =
* ADDED: The ability to set a category placeholder image and a product placeholder image. 
* ADDED: Lazy Load for category images.

= 1.2.1 = 
* ADDED: support note for 4.3.1
* Updated Description and Tags
* ADDED: Donate/Support link
* ADDED: FAQ
* Fixed: removed deprecated function of `woocommerce_placeholder_img_src` and replaced with the current (as of WC 2.1.0) `wc_placeholder_img_src`

= 1.2 =
* Removed manual entry of dimensions. It will now automatically use the dimensions for `shop_catalog` which is set under WooCommerce > Settings > Products > Display.

= 1.1.1 =
* Fixed: `$llwoo_image_src` so it would match the shop catalog dimensions. 

= 1.1 = 
* Tested against WP 4.3 RC1
* Tested Against WooCommerce 2.4.4
* Fixed: issue with `call-ll.js` "not a function" error

= 1.0.1 =
* ADDED: Support for placeholder images (url option in settings)
* Adjusted Plugin name (Lazy Load rather than LazyLoad)

= 1.0 =
* Initial version
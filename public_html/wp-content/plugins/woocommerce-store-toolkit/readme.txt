=== WooCommerce - Store Toolkit ===

Contributors: visser, visser.labs
Donate link: https://www.visser.com.au/donations/
Tags: woocommerce, mod, delete store, clean store, nuke, store toolkit
Requires at least: 2.9.2
Tested up to: 4.5.2
Stable tag: 1.6.4
License: GPLv2 or later

== Description ==

Store Toolkit includes a growing set of commonly-used WooCommerce administration tools aimed at web developers and store maintainers.

= Features =

Features include:

**WooCommerce maintainence/debugging tools**

* Re-link rogue Products to the Simple Product Type
* Refresh Product Transients
* Auto-complete Orders with 0 totals
* Unlock the Edit Product screen for Product Variations
* All in One SEO Pack integration
* Order Post meta box on Orders screen
* Subscription Post meta box on Subscriptions screen
* Product Post meta box on Products screen
* Coupon Post meta box on Coupons screen
* Product Category Term meta box on Edit Category screen
* User meta box on Edit User screen
* Event meta box on Edit Ticket screen
* Booking meta box on Edit Booking screen
* Generate Sample Products
* List of all registered WordPress Image Sizes on WooCommerce > System Status screen

**Nuke support for clearing WooCommerce store records**

* Products
* Variations
* Product Categories
* Product Tags
* Product Brands
* Product Vendors
* Product Images
* Product Attributes
* Orders
* Order Items
* Tax Rates
* Download Permissions
* Coupons
* Shipping Classes
* Advanced Google Product Feed
* Delete Products by Product Category
* Delete Orders by Order Status
* Bulk permanently Delete Products from the Edit Products screen

**Nuke support for clearing WordPress records**

* Posts
* Post Categories
* Post Tags
* Links
* Comments
* Media: Images

If you find yourself in the situation where you need to start over with a fresh installation of WooCommerce then a 'nuke' will do the job.

**Coming soon**

* Got more ideas? Tell me!

Want regular updates? Become a fan on Facebook!

http://www.facebook.com/visser.labs/

For more information visit: http://www.visser.com.au/woocommerce/

== Installation ==

1. Upload the folder 'woocommerce-store-toolkit' to the '/wp-content/plugins/' directory
2. Activate 'WooCommerce - Store Toolkit' through the 'Plugins' menu in WordPress

That's it!

== Usage ==

1. Open WooCommerce > Store Toolkit
2. Select which WooCommerce details you would like to remove and click Nuke

Done!

== Frequently Asked Questions ==

**Where can I request new features?**

You can vote on and request new features and extensions on our Support Forum, see http://www.visser.com.au

**Where can I report bugs or contribute to the project?**

Bugs can be reported here on WordPress.org or on our Support Forum, see http://www.visser.com.au

== Support ==

If you have any problems, questions or suggestions please join the members discussion on my WooCommerce dedicated forum.

http://www.visser.com.au/woocommerce/forums/

== Changelog ==

= 1.6.4 =
* Added: Image Sizes section to WooCommerce > System Status

= 1.6.3 =
* Added: Generate Sample Products
* Added: Product Name template for Generate Sample Products
* Added: SKU template for Generate Sample Products
* Added: Short description template for Generate Sample Products
* Added: Description template for Generate Sample Products
* Added: Nuke Shipping Classes

= 1.6.2 =
* Added: Reset Product Transients to Tools screen

= 1.6.1 =
* Added: Booking mta box support for WooCommerce Bookings

= 1.6 =
* Added: Unlock the Edit Product screen for Product Variations

= 1.5.9 =
* Added: Event meta box support for WooCommerce Events

= 1.5.8 =
* Fixed: Privilege escalation vulnerability (thanks jamesgol)

= 1.5.7 =
* Fixed: Privilege escalation vulnerability (thanks panVagenas)
* Added: Remove WooCommerce Product Transients

= 1.5.6 =
* Fixed: Attributes screen not updating after Attribute nuke
* Fixed: Delete WooCommerce Attribute Transient
* Fixed: Delete WooCommerce Featured Products Transient

= 1.5.5 =
* Added: WordPress Filter for overriding the default product_brand Term Taxonomy

= 1.5.4 =
* Added: Nuke support for Advanced Google Product Feed

= 1.5.3 =
* Fixed: Attribute nuke skipping Terms
* Added: Auto-complete Orders with 0 totals

= 1.5.2 =
* Added: Subscription Post meta box to Subscription Edit screen
* Added: User Post meta box to User Edit screen
* Added: WordPress.org translation support
* Fixed: Order nuke skipping Terms

= 1.5.1 =
* Fixed: add_query_arg() usage in Plugin
* Added: Permanently Delete Products from Edit Products screen

= 1.5 =
* Added: Delete Download Permissions on Orders nuked

= 1.4.9 =
* Fixed: Taxonomy detection prior to counts
* Added: Custom Post meta box to Product Variation Edit screen

= 1.4.8 =
* Added: Tools tab for non-nuke actions
* Added: Re-link rogue Products to Simple Product Type
* Fixed: Common white screen and 500 Internal Server Error notices
* Added: Explanation of nuke process while nuking
* Added: Retry notice after nuke fails mid-nuke

= 1.4.7 =
* Added: Product Brands support

= 1.4.6 =
* Added: User capability check 'manage_options' for Meta boxes

= 1.4.5 =
* Added: Custom User meta box to Edit User

= 1.4.4 =
* Changed: Renamed mislabeled Category Term meta
* Fixed: PHP warning on image nuke

= 1.4.3 =
* Changed: Renamed meta box template files
* Fixed: Nuke Product Images when no Products exist
* Added: Coupon Post meta to Add/Edit Coupon screen
* Added: Category Term meta to Edit Category screen

= 1.4.2 =
* Fixed: Delete both product and product_variation Post Types
* Fixed: Delete Orders in WooCommerce 2.2+
* Fixed: Remove Terms linked to Products

= 1.4.1 =
* Fixed: WooCommerce 2.2+ compatibility

= 1.4 =
* Added: Support for nuking all images within WordPress Media

= 1.3.9 =
* Fixed: Reduced memory usage when bulk deleting large catalogues

= 1.3.8 =
* Added: Order Meta widget on Orders screen
* Added: Order Cart Item widget on Orders screen

= 1.3.7 =
* Fixed: Missing icon
* Changed: Layout styling of descriptions on Nuke screen
* Added: Screenshots to Plugin page

= 1.3.6 =
* Changed: Plugin description
* Fixed: Updated URL for WooCommerce Plugin News widget

= 1.3.5 =
* Changed: Removed woo_admin_is_valid_icon
* Changed: Using default WooCommerce icons

= 1.3.4 =
* Added: Select All options to Nuke

= 1.3.3 =
* Fixed: Coupons removal

= 1.3.2 =
* Added: Per-Category Product nuking
* Added: Tabs support
* Changed: Removed Tools menu reference

= 1.3.1 =
* Added: Store Toolkit menu item under WooCommerce

= 1.3 =
* Added: Attributes support

= 1.2 =
* Changed: Cleaned up markup
* Added: Remove WooCommerce term details when removing Categories

= 1.1 =
* Fixed: Dashboard widget URL out of date

= 1.0 =
* Added: Delete Products, Product Categories, Tags and Orders
* Added: First working release of the Plugin

== Upgrade Notice == 



== Screenshots ==

1. The Store Toolkit overview screen.
2. The Nuke WooCommerce screen with 'nuke' options.
3. Additional 'nuke' options for WordPress details.

== Disclaimer ==

It is not responsible for any harm or wrong doing this Plugin may cause. Users are fully responsible for their own use. This Plugin is to be used WITHOUT warranty.
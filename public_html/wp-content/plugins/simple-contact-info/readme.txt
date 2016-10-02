=== Simple Contact Info ===
Contributors: LehaMotovilov
Donate link: 
Tags: contact info, google map, contact information, twitter, facebook, youtube, linkedin, widget, shortcode, social icons, social widget, widgets, contact, simple
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: Wordpress 3.5
Tested up to: 3.9.1
Stable tag: trunk

Write contact information, social links, google map and display on your website where you want. Do it easy!

== Description ==

You can write your contact information in admin panel and then show it on front-end through the widget or shortcode.
Also you can show social links on front-end using predefined (facebook, twitter, google+, etc.) or add your own. This plugin also has google map API which gives you an ability to show your actual position on map using your address.

= Features =

* Simple write contact information (address, phone, fax, email)
* Links to social networks (Facebook, Twitter, Google+, LinkedIn, YouTube)
* Add custom social network
* Use pack icons or upload your icons
* 4 widgets to display information
* Shortcode supported
* W3C valid widgets
* Transient cache widgets

= Supported Languages =
* Russian 
* English 
* Serbian (thanks to [Borisa Djuraskovic](http://www.webhostinghub.com/))

= Links =

* [Plugin's web page](http://lehaqs.wordpress.com/2013/04/22/simple-contact-info/)
* [Support forum](http://wordpress.org/support/plugin/simple-contact-info/)
* [Find me on Facebook](http://facebook.com/LehaMotovilov/)
* To get support or if you find bug - just write me lehaqs@gmail.com

== Frequently Asked Questions ==

= How to display Google Map =

Write your address and use widget "Simple Google Map".

= How to use social icons =

Select or upload social icons.
Use widget to display social icons with links. Or use shortcode.

= How display contact info =

Use widget "Simple Contact Info".

Display where you want in template:

`<?php echo get_option('qs_contact_phone'); ?>`
`<?php echo get_option('qs_contact_fax'); ?>`
`<?php echo get_option('qs_contact_email'); ?>`

= How display address info =

Use widget "Simple Address Info".

Display where you want in template:

`<?php echo get_option('qs_contact_country'); ?>`
`<?php echo get_option('qs_contact_state'); ?>`
`<?php echo get_option('qs_contact_city'); ?>`
`<?php echo get_option('qs_contact_street'); ?>`
`<?php echo get_option('qs_contact_zip'); ?>`

== Installation ==

1. Upload 'simple-contact-info' to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Select social icons or upload your icons.
4. Use widget to display social icons with links.
5. Read help for more information.

== Upgrade Notice ==

Dont worry, be happy. :)

== Screenshots ==

1. Contact info in admin area.
2. Social icons for widget.
3. Add custom network.
4. Widgets in admin area.
5. Widgets in frontend.

== Changelog ==

= 1.1.9 =
* Hotfix

= 1.1.8 =
* Added cache widgets for speed improvement. ( Transient )
* Small code improvement. ( WordPress PHP Coding Standards )
* Added Lat\Long and MapType for GoogleMap Widget.

= 1.1.7 =
* Support WordPress 3.9+
* Add alt to links.
* Add shortcode for custom networks.

= 1.1.6 =
* Serbian language support. Thanks to Borisa Djuraskovic.

= 1.1.5 =
* Added new icons.
* Fixed bug with http\https social links widget.
* Tested on WordPress 3.7

= 1.1.4 =
* Strict Standards error fixed.

= 1.1.3 =
* MP6 ready.
* Add translation to widgets.
* Add mobile phone.
* Fix "http/https links bug".

= 1.1.2 =
* Add Russian translation.
* Ability to change the order of social icons in widget "Simple Social Icons".
* Tested on WordPress 3.6
* Small fixes.

= 1.1.1 =
* Improved uninstall plugin, deleting options from DB.
* Add default $before_widget, $before_title etc.
* Small fixes.

= 1.1.0 =
* Support PHP 5.2 thanks Caroline Rose for feedback.
* Changed information on help page.
* W3C valid.
* Ability to add custon social network.

= 1.0.9 =
* It's security update.
* Add "Show" params to Contact widget.
* Fix install bug "headers already sent".
* Fix all notice.

= 1.0.8 =
* Add Google Map widget. Widget display a Google Map based on the address that you entered in the settings.
* Add Address widget. Widget display a address that you entered in the settings.
* Add Contact widget. Widget display a contact information(phone, fax, email) that you entered in the settings.
* Add the ability to remove custom icons.
* Improved selection of social icons.

= 1.0.7 =
* Error message if folder "upload" is not writable.
* Add shortcodes support.
* Add help page.

= 1.0.6 =
* Ability to add your own images.
* Add new icons.
* Add multilanguage support.
* Fix bug with save contact information.
* Fix small bugs.

= 1.0.5 =
* Add social icons switcher.
* Fix bug with LinkedIn.

= 1.0.4 =
* Add Widget to display social icons with links.

= 1.0.3 =
* Add LinkedIn

= 1.0.2 =
* Add Google+
* Fix images.

= 1.0.1 =
* Update readme info.
* Small fix in css.

= 1.0 =
* First version. 2013-04-05
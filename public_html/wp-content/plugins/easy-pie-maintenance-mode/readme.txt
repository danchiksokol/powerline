=== EZP Maintenance Mode ===
Contributors: bobriley
Donate link: http://easypiewp.com/donate/
Tags: maintenance, admin, administration, construction, under construction, maintenance mode, offline, unavailable, launch, wordpress maintenance mode, site maintenance
Requires at least: 3.5
Tested up to: 4.1.1
Stable tag: 1.0.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easily let website visitors know your site is undergoing maintenance.

== Description ==

Need to let your visitors know your site is undergoing maintenance? EZP Maintenance Mode makes it easy! 

### Maintenance Mode Basic Features
* **Simple.** No confusing options or complex setup.
* **Mini themes.** Choose between four professionally-designed, responsive mini-themes to display when in Maintenance Mode.
* **Pre-styled text.** Title, header, headline and message text gets styled without requiring HTML or CSS.
* **Add your own logo.** Add your own logo using the WordPress Media Library to give Maintenance Mode a personal touch.

### Advanced Features
* **Custom CSS.** Easily add CSS from the Admin page to customize a Maintenance Mode mini-theme.
* **User Mini Themes.** Greatly customize Maintenance Mode by creating your own mini-theme.

### Overview
EZP Maintenance Mode was designed to let you get to the important work of improving your site while visitors know you are performing maintenance in the shortest time possible. We've supplied four very nice looking themes to display when your site is undergoing maintenance.  Additionally, you can easily cator these to your tastes using CSS. For the advanced users, you can create your own mini theme  to be displayed when the site is undergoing maintenance.

In this way, both beginners and pros will find EZP Maintenance Mode not only easy to use but highly flexible as well.


Thanks to the developers of [bxSlider](http://bxslider.com) for their cool image viewer.

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Coming Soon Page'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `easy-pie-maintenance-mode.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `easy-pie-maintenance-mode.zip`
2. Extract the `easy-pie-maintenance-mode` directory to your computer
3. Upload the `easy-pie-maintenance-mode` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin's dashboard

== Frequently Asked Questions ==

= Why is my site is still viewable? =
Maintenance mode is only shown to visitors who are not logged in. The easiest way to check things yourself is view your site with a different browser type than the one you're logged in with (i.e. if you're logged in with Chrome, view the site in Firefox or Internet Explorer or vice versa). 

Alternatively, you can log out or view the site in incognito/private mode with an instance of the same browser type.

= What happens if a search engine hits my site while it's in maintenance mode? =

The plugin returns a '503' status with 'retry later' HTTP header when in maintenance mode. This lets search engines know that your site is temporarily down and to come back 24 hours later.

= I can't get out of maintenance mode. Help! =

Every once in a great while other plugins installed on a system can interact with Maintenance Mode to prevent access to wp-admin. If you find yourself in this unfortunate situation, use the maintenance mode manual override.

Simply add the following line to your wp-config.php file:

**define('EASY_PIE_MM_DISABLE', true);**

Afterward either uninstall or reconfigure the conflicting plugins.

If you aren't comfortable doing this or are unsure how to do this, [please contact me](mailto:support@snapcreek.com) and I'll be happy to walk you through the process.

= How do I report a bug? =

Please capture as much information you can about your system, specifically use the error log to gather new information if you are comfortable. The [EZP Error Log Guide](http://easypiewp.com/quickly-diagnose-wordpress-problems-using-error-log/) outlines how to do this.
Then, please [let me know](mailto:support@snapcreek.com) what's going on, with as much detail as you have.

== Screenshots ==
 
1. Plugin configuration
2. Site in maintenance mode when using the 'temporarily closed' mini-theme.

== Changelog ==

= 1.0.0 =
* Small UI tweaks
* Renamed to EZP Maintenance Mode
* Changed references to Snap Creek Software

= 0.6.7 =
* UI tweaks

= 0.6.6 =
* Cleaned up UI

= 0.6.5 =
* Small tweaks

= 0.6.4 =
* Bug fix for WordPress 3.5.1 compatibility

= 0.6.3 =
* Bug fixes
* Improved styling for WordPress 3.8

= 0.6.2 =
* Bugfix: User theme directory wasn't created on startup
* Bugfix: Hiding logo if not defined

= 0.6.1 =
* A couple small bug fixes

= 0.6.0 =
* Added ability to create custom mini themes
* Added ability to add custom styling to existing mini themes
* Added notification to prevent you from accidentally leaving your site in maintenance mode.
* Added captions to mini-themes
* Fixed compatibility with PHP 5.2
* Misc code cleanup

= 0.5.1 =
* Fix for PHP 5.2.x

= 0.5 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Small UI tweaks, renamed to EZP Maintenance Mode, changed references to Snap Creek Software

= 0.6.7 =
UI tweaks

= 0.6.6 =
Cleaned up UI

= 0.6.5 =
Small tweaks

= 0.6.4 =
WordPress 3.5.1 compatibility fix

= 0.6.3 =
Small bug fixes & improved styling for WordPress 3.8

= 0.6.2 =
Fixed upgrade bug that prevented viewing themes on admin panel.

= 0.6.1 =
Made screen draw smoother, small bug fixes

= 0.6.0 =
This version adds custom themes, custom CSS, a notification that your site is in maintenance mode, PHP 5.2 compatibility and small bug fixes. Note: If you have hacked an existing theme please back it up before update because the v0.5 plugin directory is completely wiped on update.

= 0.5.1 =
Small fix for PHP 5.2.x. If you aren't running PHP 5.2.x you don't need this although it won't hurt anything if you update anyway.

= 0.5 =
Initial release

=== Google Font Manager ===

Contributors: opportunex, PremiumWebServices
Donate Link: http://butlerconsulting.com/work/plugins/google-font-manager/
Tags: font, fonts, google, google fonts, manage fonts, add fonts, styles, site style, css, stylesheet, style sheet, typography
Requires at least: 3.1
Tested up to: 4.2.2
Stable tag: 1.1.4
License: GPLv3 (or higher)

Easily add Google fonts to your WordPress website. With multiple options, this is perfect for regular and advanced WordPress users alike.


== Description ==

**The Google Font Manager plugin was written to help you quickly and easily add Google fonts to your WordPress website. Designed for both regular and advanced WordPress users in mind, this is the perfect plugin to expand your website typography.** 

[vimeo http://vimeo.com/113980706]

With minimal overhead, it will not add any unnecessary "bloat" to your site; adding only what you need according to your settings. You can use this plugin to simply add Google fonts to your site and reference them in your own custom style sheets (if you are using a child theme). Or, if you are not coding your own theme, there are a variety of ways you can use the built-in functions of WordPress to make use of the fonts you add. Either way, it provides the perfect solution for adding and managing Google fonts.

**Some of the features:**

* Add as many Google Fonts as you want to your site
* Full integration with Google Fonts API
* Automatically adds fonts to Visual Editor (tinyMCE)
* Optionally adds "Web Safe Fonts" to Visual Editor 
* Customize style sheet to override theme default
* AJAX-powered, no screen refreshes! 
* Clean and fresh UI and UX design
* Fully responsive Admin (as of WP 3.8)
* Light-Weight... turn on and off options
* Resources only loaded in WP Admin when needed
* Multisite compatible with single API key

If you have any problems with the plugin after reading the FAQ, Other Notes, etc. please visit the [support forums](http://wordpress.org/support/plugin/google-font-manager/).

= Translated Languages Available =

Sorry, no translations available at this time.  We will be working on that for the next upgrade. If you'd like to contribute a translation, please let us know on the [support forums](http://wordpress.org/support/plugin/google-font-manager/).

* American English - Default... Also supports Canadian, British, Scottish, Irish, Australian and a few others (that's a joke)


== Installation ==

1. Upload this plugin to the `/wp-content/plugins/` directory and unzip it, or simply upload the zip file within your WordPress installation.

2. Activate the plugin through the 'Plugins' menu in WordPress. Or (within a multisite network) you may now Network Activate it. 

3. Click on "Google Font Manager" in your admin toolbar, located under the settings tab.

4. Follow the link and instructions provided to get your Google Fonts API key, add your API key and update settings.

5. Start previewing and adding fonts to your site.  Happy Typography!


== Upgrade Notice ==

The current update (version 1.03) is a non-critical update with minor updates to documentation only.


== Notes & Known Issues ==

This plugin has been developed for modern browsers and makes liberal use of HTML5 data attributes. It may not function as intended in older web browsers... **YOU HAVE BEEN WARNED!** 

As this plugin was developed for internal training purposes to teach new programmers how to write plugins "our way", we have full documentation available.  Although a languages folder exists in the plugin (google-font-manager/lang) no translations have been added to this version. As a training tool, we will also be utilizing it for producing an instructional video on how to add translations to your WordPress plugins.  Once that tutorial is complete, we will update the plugin with some added translations.  

Finally, and along the same lines, some of the "responsiveness" in the UI may seem lacking in the initial release.  This is for the same reason.  We'll be adding a tutorial on "How to Add Responsive Conditionals to your Plugins" and will update the plugin when that is complete.  In the meantime, have fun with it and let us know what you think!


== Screenshots ==

1. Preview all Google fonts without leaving the WP Admin.

2. Easily add and remove Google Fonts to your WordPress Site.

3. Automatic integration with the Visual Editor (tinyMCE - optional)

4. Build and customize your own CSS style sheet (no programming required).

5. Fully documented with lots of information.


== Frequently Asked Questions ==

= How do I get a Google API key? =
You will need a Google API key to make use of this plugin. Your key is free and easy to get. However, many people get confused on this.  It's really quite simple: 

    1) logged in to your Gmail account; 
    2) go here https://cloud.google.com/console; 
    3) create a project (example: "my google fonts");
    5) under "APIs & auth" click APIs and add "Web Fonts Developer API";
    4) under "APIs & auth" click credentials (create new key);
    5) copy the API key under "Key for browser applications", that's it.

= Why don't my changes appear in my site? =
Once you have selected fonts and added them to your site, you must either add them to your style sheet manually, or apply them within your blog post or pages by using the visual editor or overriding your themes style sheet by configuring options under the "Default Styles" tab (make sure you have enabled the "Style Defaults" and apply them to your site elements). 

= I have followed the instructions above and my fonts still aren't working. What can I do? =
If you have done all of the above and you still can't see any changes, you should turn on the "!important" CSS constructor, rebuild your style sheet and refresh your page.  Also, make sure to delete your cache and refresh your page - particularly if you are using a cache plugin. Please note, that not all of your website's styles can be manipulated with the "Default Style" options.  In some cases, you will have to use "inline styles" or CSS to achieve your desired result.  We are only able to provide a basic framework for you with this plugin.
 
= I am a programmer/designer and I don't need any add-ons. Can I turn them off? =
Yes.  By default, we assume that you don't know how to code or do not want to.  So, font selection in the visual editor, along with web safe fonts option are enabled by default.  This plugin allows you to turn off all of these added utilities for applying fonts. You may do so under the settings tab.

= I am running a multisite network. Can I "network enable" this plugin and use a single API key? =
Yes.  As of version 1.0.1 of the plugin, you are able to activate the plugin for all the sites in your network.  If you do this, you must enter your API key within the Network Admin (under settings) for the plugin to work.

= I have entered my API Key and nothing happens. What do I do? =
Make sure that your API key is entered into the space provided without any leading or trailing spaces.  Next, you must click the button "Update Configuration" (or "Activate Google API Key Globally" in Network Activation). Unlike many of the other options, which are set via ajax and do not require a page refresh or submit button, setting the API key requires a full form submission to complete.  If you follow these instructions and still have issues, check and make sure that you are using the correct API key ("Key for browser applications" aka "Browser Key").

Apparently, with some server configurations the curl module in PHP may be required to validate the API calls.  For more information on this you can read the posts in this support thread: http://wordpress.org/support/topic/api-wont-load-1?replies=8 

Thanks to @foundationstestprep who pinted out an error that occurs when a referrer is specified: "I couldn't get the Google Font Manager plugin to accept my Google API until I went back to Google and removed the referrers from the API key. Although I'm certain I had the referring url correct, it wouldn't work until it was removed. If you're having problems with the API key and have a referrer associated with it, try removing it to see if it helps."

= My site is hosted with HostGator and my API key won't load.  What do I do? =
I have no idea! This has been an ongoing issue for at least one user.  I suspect it has to do with the caching system HostGator forces you to use in their shared hosting environment which is adding a space to the header file.  I have wrestled with that before on HostGator, to no avail.  If you have any ideas or can figure it out, I would be very interested in a solution to this!

= I really like how this plugin works and looks. Are you for hire? =
Yes.  We make a living by doing this sort of thing.  You can learn more about us and what we can do for you by visiting our home page at: http://butlerconsulting.com.

For further information and step-by-step instructions you can go here: http://plugins.butlerconsulting.com/docs/google-font-manager/.


== Credits and include files ==

Of course a big "shout out" must be given to Matt Mullenweg and the WordPress team for making the entire world possible! This plugin makes use of jQuery (jquery.com) along with a few additional JavaScript libraries that have been written by others.  Each of these may have their own licenses, but all are "Open Source". Some of the icons were used from Windows Icons [Modern UI Icons](http://modernuiicons.com/). Additional resources:

jQuery autocomplete provided by http://jqueryui.com, 
jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/, 
A modified version of "tipsy tip roller" by Jason Frame [jason@onehackoranother.com] was added to the main jQuery file,
jQuery.LocalScroll and jQuery.ScrollTo by Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com, 
jQuery custom radiobuttons by Tomasz Wójcik (bthlabs.pl) labs@tomekwojcik.pl 
SpinBox JavaScript widget //code.stephenmorley.org http://code.stephenmorley.org/javascript/spin-box-widget/
Special thanks to Richard Bonk from PremiumWebServices http://premiumwebservices.co.uk for his TinyMCE contribution in updating to WP v3.9

== Changelog ==

= 1.0 =
* Initial release December 28th 2013, Nothing to see here. These are not the droids we're looking for... move along.

= 1.0.1 =
* Added multisite support with network admin page to apply API key globally.
* Fixed tinyMCE toolbar bug that caused other plugin options to be removed.
* Added "close panel" link to font viewer (some did not figure out to click on tab).
* Added YouTube video links for intro, api tutorial and plugin tutorial.
* Changed deactivation hook to register_uninstall_hook for settings removal.
* Updated readme.txt and help files for better readability.
* Updated the FAQ with multisite answers and more.

= 1.0.2 =
* Commented out PHP error reporting (was causing error messages from other plugins and issues to be displayed in admin).

= 1.0.3 =
* Updated tutorial videos and FAQ

= 1.0.4 =
* Updated TinyMCE toolbar code for compatibility with WordPress Version 3.9.  Special thanks to Richand Bonk from PremiumWebServices (http://premiumwebservices.co.uk) for his contribution in fixing this issue, as the author was tied up n another project.  Thanks Richard!!

= 1.1.0 =
* Updated version numbering to be in sync with other plugins.
* Added some "backwards compatibility" for WordPress prior to Version 3.9.

= 1.1.1 =
* Added call to wp_version, may cause "headers not sent" errors in some themes.
* Corrected some spelling errors in readme file.

= 1.1.2 =
* Tested and updated stable tag for compliance with WordPress 4.0.
* Added the "HostGator FAQ Comment" concerning API failure to load.
* Added license.txt (GPLv3) to package for consistency.
* Added icons for WordPress plugin repository... cool!

= 1.1.3 =
* Tested and updated stable tag for compliance with WordPress 4.0.1
* Removed http prefix to prevent sites using SSL from blocking fonts due to same origin policy.

= 1.1.4 =
* Tested and updated stable tag for WordPress 4.1.1.
* Replaced Vimeo file with updated version.


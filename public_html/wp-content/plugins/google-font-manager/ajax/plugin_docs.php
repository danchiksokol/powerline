<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the help document text elements.
 */
 
?>

<h2>
    Plugin Documentation - How to use this plugin. 
</h2>

<p>
    Currently, <a href="http://www.google.com/fonts" target="_blank">Google fonts</a> has <span class='countfonts'>0</span> fonts available for both public and commercial use. You may utilize them in your websites and other 
    applications. Using these fonts can extend your website designs, enabling you to achieve a unique look and feel to your site. After all "a picture is worth 1000 words" and typography allows you to paint pictures with words.
</p>

<p>
    This plugin was written to help you quickly and easily add Google fonts to your WordPress website. It was designed with both the experienced programmer and standard WordPress users in mind. With minimal overhead, it will not add 
    any unnecessary "bloat" to your site; adding only what you need according to your settings. You can use this plugin to simply add Google fonts to your site and reference them in your own custom style sheets (if you are using a 
    child theme). Or, if you are not coding your own theme, there are a variety of ways you can use the built-in functions of WordPress to make use of the fonts you add. Either way, it provides the perfect solution for adding Google 
    fonts to your website.
</p>

<h3>
    Finding, Previewing &amp; Adding Fonts. 
</h3>

<p class="indent">
    This plugin makes it super easy for you to find, preview and add <a href="http://www.google.com/fonts" target="_blank">Google fonts</a> to your website. Finding a font that is perfect for your website couldn't be easier! Simply click on 
    the "Preview Fonts" tab and a list of the <span class='countfonts'>0</span> available Google fonts will appear. To preview what each font looks like, simply click on the font name. The preview window will slide out and display the font, 
    showing you how it will look in several different variations. If you like the font, you can click the "Add This Font" button within the preview window or use the "Google Font Selector" by typing the name of the font you wish to add. 
    It's that simple! 
</p>

<h3>
    Getting your API Key. 
</h3>

<p class="indent">
    In order to use this plugin you will need to <a href="https://cloud.google.com/console" target="_blank">register a "project" with Google and get an API (Application Program Interface) key</a>. The API key is free to obtain and simple to get. 
    However, some people are confused as to how to obtain an API key and how to use one. The easiest way for you to understand this is to watch the video located in the upper right hand corner of your screen. It is really quite simple and straight
    forward. Once you have an API key, simply enter it into the space provided in the settings and you're off to the races! 
</p>

<h3>
    Options for regular users. 
</h3>

<p class="indent">
    For the average WordPress user, we have incorporated two ways for you to use the Google fonts you select in your website. The first way is turned on by default. The second way must be enabled, but gives you a great deal of modular control over 
    how your newly embedded fonts are applied. First, you must add one, or many, of the <span class='countfonts'>0</span> Google fonts to your site. Adding fonts is quite simple. However, be sure to not add too many as each one will add  some loading 
    time to your site. No more than 5 fonts is recommended You start by typing the name of the font you want in the "Google Font Selector" form field (located in the upper-right corner "meta box") and select it from the drop-down. This adds the font 
    to your site by linking the Google font style sheet in your website header (no programming required). 
</p>

<p class="indent">
    Once your fonts have been selected, by default they are "automagically"  added to the WordPress Visual Editor (tinyMCE). This is the same WYSIWYG (what you see is what you get) editor that you are probably familiar with for creating your content in 
    posts and pages. The only difference is that you will now find a "Font Family" option in the editor added by the plugin (you may turn off this feature if you want). You can apply any selected font to your content by highlighting the text selection 
    and choosing the font you want to apply form the font family dropdown. 
</p>

<p class="indent">
    The second way you can apply fonts is by enabling the "Style Defaults" in the settings. This is turned off by default and you must enable it. Once you do, you will be able to click on the tab labeled "Default Styles". From there you are able to select font choices to be applied 
    to each of the basic content types, like the "body" tag, paragraphs, header tags (&#60;h1&#62;, &#60;h2&#62;, &#60;h3&#62;, etc.) and other text elements. You may also click on the "advanced arrow" and apply further style properties like <strong>bold</strong>, <em>italic</em>, 
    color choices and the like <em>(keep in mind these options will overried the styles that came with your theme)</em>. 
</p>

<h3>
    Basic use (for programmers). 
</h3>

<p class="indent">
    If you are using your own style sheets and comfortable with writing CSS, LESS or SASS, you can make immediate use of this plugin. Just add new fonts to your site in the same way as described above. Once added, simply reference the font name in your CSS file likes so: 
</p>

<pre>
    <strong>body { font-family: 'Open Sans'; } or  p { font-family: 'Open Sans'; }</strong>
</pre>

<p class="indent">
    To extend the font properties, you may do so in the usual way by adding additional CSS conditions to your code (i.e. "font-weight: bold;"). To help you further identify the available properties, variations and subsets that come with the fonts you have chosen you can use the 
    "Font Options Inspector". This feature lists the variations and subsets of each font. To do this, simply select one of your fonts from the drop-down-box and a list of variations and subsets will be retrieved via the Google font API. Then, you can use them in your CSS code: 
</p>

<pre>
    <strong>body { font-family: 'Open Sans'; font-style: italic; font-weight: 300; }</strong>
</pre>

<p class="note indent">
    <em><strong>NOTE:</strong> If you are an advanced user who is directly editing your style sheet (as with a child theme), you will not want to enable the "Style Defaults" option. If you do, you may have to use the "!important" constructor in your CSS to override the default settings added by 
    the plugin. This is because the "Style Defaults" are applied by the plugin directly to your website header after your themes style.css sheet is loaded.</em>
</p>

<h3>
    Full Documentation &amp; Resources. 
</h3>

<p class="indent">
    The Google Font Manager WordPress plugin was written as a learning exercise to demonstrate our methods for writing plugins.  We utilize this plugin at ButlerConsulting.com to teach our programmers how to approach plugin development.  As such, the end product represents our best in UI 
    (user interface) and UX (user experience) design while demonstrating our approach to writing plugins.  
</p>

<p class="indent">
    As with any programming, there are multiple ways to approach a problem and arrive at a solution.  Some solutions are more efficient than others and not all programmers will agree that our methods represent "best practices".  We are good at what we do but we are not infallible. If you are 
    an experienced programmer, and you see something we could or should improve, please let us know.
</p>

<p class="indent">
    You may access full documentation via the "<a href="<?php echo plugins_url( '../readme.txt' , plugin_basename(__FILE__) ); ?>" target="_blank">readme.txt</a>" provided with the plugin.  For more information you may visit the following resource links:
    
    <ul class="indent">
        <li><strong>Blog about the plugin:</strong> <a href="http://butlerconsulting.com/work/plugins/google-font-manager/" target="_blank">http://butlerconsulting.com/work/plugins/google-font-manager/</a></li>
        <li><strong>Behind the scenes:</strong> <a href="http://plugins.butlerconsulting.com/google-font-manager/" target="_blank">http://plugins.butlerconsulting.com/google-font-manager/</a></li>
        <li><strong>Technical Documentation:</strong> <a href="http://plugins.butlerconsulting.com/docs/google-font-manager/" target="_blank">http://plugins.butlerconsulting.com/docs/google-font-manager/</a></li>
        <li><strong>WordPress Repository:</strong> <a href="http://wordpress.org/plugins/google-font-manager/" target="_blank">http://wordpress.org/ plugins/google-font-manager/</a></li>
        <li><strong>WordPress Support Forum:</strong> <a href="http://wordpress.org/support/plugin/google-font-manager/" target="_blank">http://wordpress.org/support/plugin/google-font-manager/</a></li>
        <li><strong>GitHub Repository:</strong> <a href="https://github.com/butler-consulting/google-font-manager/" target="_blank">https://github.com/butler-consulting/google-font-manager/</a></li>
        <li><strong>Google Font API:</strong> <a href="https://developers.google.com/fonts/docs/developer_api/" target="_blank">https://developers.google.com/fonts/docs/developer_api/</a></li>
    </ul>
     
</p>

<div class="clear"></div>

<br />
<br />
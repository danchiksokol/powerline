<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the network admin page for setting the Google Font API key globally.
 */
 
//exit if accessed directly
if(!defined('ABSPATH')) exit;

$google_api_key = wp_googlefonts_getTheKey();

?>

<div class="wrap">
    
    <div id="google_fonts_selector">
        
        <img id="pluginlogo" src="<?php echo plugins_url( '../css/images/wp_googlefontmgr.png' , plugin_basename(__FILE__) ); ?>" />
        
        <div id="poststuff">
            
            <div id="post-body" class="metabox-holder columns-2">
            
                <div id="postbox-container-1" class="postbox-container">
                    
                    <div id="side-sortables" class="meta-box-sortables">
                        
                        <div id="wp_googlefontmgr_nextwork" class="postbox">
                            
                            <h3>
                                <span>Getting your API key from Google:</span>
                            </h3>
                            <div class="inside">
                                
                                <div id="wp_googlefontmgr_settings_dialog">
                                    
                                    <p class="small"><em>In order to use the font manager, we need to connect with your Google Developer API account. This will enable you to access the Google Fonts API. An Google Developer API key is free and easy to get as long as you have a Gmail account.</em> <a target='_blank' href='https://code.google.com/apis/console'>Click Here to Get Your Google API Key!</a></p> 
                                    
                                </div>
                                
                                <p align="center">
                                    <iframe src="//player.vimeo.com/video/83986921" width="235" height="132" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </p>
                        
                            </div>
                        </div>
                        
                        <div class="clear"></div>
                        
                        <div id="links_resources" class="postbox">
                            <h3>
                                <span>Additional Rsources &amp; Links:</span>
                            </h3>
                            <div class="inside">
                                
                                <div id="links_and_stuff">
                                    
                                    <ul>
                                        <li><a href="http://butlerconsulting.com/work/plugins/google-font-manager/" target="_blank"><strong>Blog about the plugin (home page)</strong></a></li>
                                         <li><a href="http://wordpress.org/support/plugin/google-font-manager/" target="_blank"><strong>WordPress Support Forum</strong></a></li>
                                        <li><a href="https://github.com/butler-consulting/google-font-manager/" target="_blank"><strong>GitHub Repository</strong></a></li>
                                        <li><a href="https://developers.google.com/fonts/docs/developer_api/" target="_blank"><strong>Google Font API</strong></a></li>
                                    </ul>
                                    
                                </div>
                        
                                <div class="clear"></div>
                        
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div id="postbox-container-2" class="postbox-container">
                
                    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    
                        <div id="advanced-sortables" class="meta-box-sortables ui-sortable">
                            
                            <div id="font_filters">
                            
                                <div id="font_head">
                                    <h3>Google Font Manager - Network Activation</h3>
                                </div>
                                <div id="template_reset">
                                    <div id="mainbar" class="mainbar">
                                        <div id="mainbar_info" class="mainbar-button subdued" title="Author Info">
                                            <img src="<?php echo plugins_url( '../css/images/mainbar_info.png' , plugin_basename(__FILE__) ); ?>" />
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div id="fonts_container">
                                
                                <div id="font_content">
                                
                                    <br />
                                    
                                    <div id="font_data_container">
                                        
                                        <form id="globalgoogleapi" method="post" action="" name="globalgoogleapi">
                                        
                                        <h2>Activate your Google API key globally.  This option will enable all websites in your network to share the same API key. Be sure to read the important "network notes" below before using this option.</h2>
                                        
                                        <div id="wp_googlefontmgr_settings_dialog">
                                            <p>
                                                <h4>Add your Google API Developer Key:</h4>
                                                <input id="wp_googlefontmgr_globalkey" name="wp_googlefontmgr_globalkey" value="<?php echo $google_api_key; ?>" type="text" style="width: 95%;" />
                                            </p>
                                        </div>
                                        
                                        <input type="button" class="button button-primary" value="Activate Google API key Globally" />
                                        
                                        <div class="clear"></div>

                                        <br />
                                        <br />
                                        
                                        <p>
                                            <strong>Network Notes:</strong> In most cases, activation of your Google Developer API key network-wide will not cause any issues.  However, if you are running a very large multi-site network, it is possible
                                            (however remote) to reach data access limits (quota) imposed by Google - something to be mindful of. Make sure to comply with the terms of service as set forth here: 
                                            <a href="https://developers.google.com/terms/" target="_blank">https://developers.google.com/terms/</a>.
                                        </p>
                                        
                                        </form>
                                        
                                    </div>
                                
                                </div>
                                
                            </div>
                            
                            <br class="clear" />
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                <br class="clear" />
                
            </div>
            
            <div class="clear"></div>

        </div>

        
        <div class="clear"></div>
        
    </div>

</div>

<div id="loadajax" style="display: none !important;">
    <div class="loadertext">
        <table cellpadding="2" cellspacing="2">
            <tr>
                <td><img class="ajaxloadimg" src="<?php echo plugins_url( '../css/images/ajax-loader.gif' , plugin_basename(__FILE__) ); ?>" /></td>
                <td><p></p></td>
            </tr>
        </table>
    </div>
</div>

<div id="popwarning" style="display: none !important;">
    <div class="warntitle">
        <p></p>
    </div>
    <div class="warncontent">
        <p></p>
    </div>
    <div class="warnaction" align="right">
        <table cellpadding="2" cellspacing="2">
            <tr>
                <td><div class="btnbox"><a class="button button-primary" href="javascript:void(0)" data-ref="" onclick="cancelme()">I Understand</a></div></td>
                <td><div class="btnbox"><a class="button" href="javascript:void(0)" data-ref="" onclick="cancelme()">Close</a></div>
                </td>
            </tr>
        </table>
    </div>
</div>

<div id="rusureok" style="display: none !important;">
    <div class="rusure">
        <p></p>
        <div class="rsurebtns" align="center">
            <table cellpadding="2" cellspacing="2">
                <tr>
                    <td><div class="btnbox"><a id="confirm" class="button button-primary" href="#" onclick="handleRUsure(jQuery(this).attr('data-action'))" data-action="">OK</a></div></td>
                    <td><div class="btnbox"><a id="cancelme" class="button" href="#" onclick="cancelme()">Cancel</a></div></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div id="aboutus" style="display: none !important;">
    <div id="aboutplugin" class="abouttext">
        <span class="closewin" onclick="cancelme();"></span>
        <table cellpadding="2" cellspacing="2">
            <tr>
                <td>
                <div id="logo" align="center">
                    <a class="author-link" href="http://butlerconsulting.com/" target="_blank">
                        <img src="<?php echo plugins_url( '../css/images/logo.png' , plugin_basename(__FILE__) ); ?>" />
                    </a>
                </div>
                <p id="plugin-about">
                    <em>This plugin was developed by Thomas S. Butler (<a href="http://butlerconsulting.com" target="_blank">http://butlerconsulting.com</a>) and is distributed freely under terms of the 
                    GNU General Public License (v2 or higher).  The developer is not an employee, contractor or representative of Google Inc. All product names and company logos incorporated into this
                    work are the trademarks of their respective owners. Use of copyrighted material is subject to any terms specified by the owner of said material. You may access full disclaimers, license and 
                    other important information in the readme.txt file provided with this plugin, or you may visit this plugin's website at: 
                    <a href="http://butlerconsulting.com/work/plugins/google-font-manager/" target="_blank">http://butlerconsulting.com/work/plugins/google-font-manager/</a>.</em>
                </p>
                <div id="about-author">
                    <div onclick="window.open('http://butlerconsulting.com/');">
                        <img class="avatar avatar-80 photo" height="80" width="80" src="http://1.gravatar.com/avatar/5ef637cd8d0b2924f616fafb69d2e760?s=80&d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D80&r=G" alt="" />
                        <div class="author-content">
                            <h4>About the Author</h4>
                            <p id="about-the-author">
                                Thomas S. Butler is the founder of ButlerConsulting.com. As a seasoned web developer, he is focused on getting the job done. With a veracious appetite for 
                                learning new things and keeping up with the pace of technology, he is amply suited to take on your next project.
                            </p>
                        </div>
                    </div>
                </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<div id="response-div"></div>
<div id="notification"></div>
<div id="confirmation"></div>
<div id="notice-overlay"></div>

<script type="text/javascript">
//rusure actions
function handleRUsure(action){
    if(action == "nukeIT") { 
        var data = { action: 'wp_googlefontmgr_killfonts', font: "Open Sans", remove: "all" };
    	jQuery.post(ajaxurl, data, function(response) {
    		jQuery("#response-div").html(response);
    	});
    }
    if(action == "updateStyle") { setTheStylesheet(); }
    jQuery("#confirmation").fadeOut("fast");
    jQuery("#notice-overlay").fadeOut("slow");
    jQuery("#confirmation").html("");
    jQuery("#popwarning p").html("");
    jQuery("#rusureok p").html(""); 
} 
//cancel warnings box
function cancelme(){
    jQuery("#confirmation").removeClass("about");
    jQuery("#confirmation").fadeOut("fast");
    jQuery("#notice-overlay").fadeOut("slow");
    jQuery("#confirmation").html("");
    jQuery("#popwarning p").html("");
    jQuery("#rusureok p").html(""); 
}
//submit notifications
function notifyuser(msg) {
	jQuery("#notification").empty();
	jQuery("#notification").html(msg);
	jQuery("#notification").fadeIn('slow');
	var timerId = setTimeout(function() { 
        jQuery("#notification").fadeOut('slow'); 
    }, 3500);
}
jQuery(document).ready(function() {

    //handle about us window
    jQuery("#mainbar_info").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        jQuery("#confirmation").html(jQuery("#aboutus").html());
        jQuery("#confirmation").addClass("about");
        jQuery("#notice-overlay").fadeIn("slow");
        jQuery("#confirmation").fadeIn("slow");
        jQuery("#confirm").focus();
    });
    //handle google api form submission
    jQuery("#globalgoogleapi input.button").on("click", function(){ 
        if(jQuery("#wp_googlefontmgr_globalkey").val() == ""){
            //if form fields check fails
            jQuery("#rusureok #confirm").attr("data-action", "closeme");
            jQuery("#rusureok p").html("Please enter the API key provided to you by Google. <strong>An API Key is required to use the font utility.</strong>");
            jQuery("#confirmation").html(jQuery("#rusureok").html());
            jQuery("#notice-overlay").fadeIn("slow");
            jQuery("#confirmation").fadeIn("slow");
            jQuery("#confirm").focus();
        } else {
            //load ajax spinner
            jQuery("#loadajax p").html("Validating your Google Developer API Key, one moment, please stand by...");
            jQuery("#confirmation").html(jQuery("#loadajax").html());
            jQuery("#notice-overlay").fadeIn("slow");
            jQuery("#confirmation").fadeIn("slow");
            //kill any remaining messages
            jQuery(".message").fadeOut("slow");
            //set the filename
            
            var data = {
        		action: 'wp_googlefontmgr_globalapi',
        		wp_googlefontmgr_globalkey: jQuery("#wp_googlefontmgr_globalkey").val()
        	};
        
        	jQuery.post(ajaxurl, data, function(response) {
        		jQuery("#response-div").html(response);
                var timerId = setTimeout(function() { 
                    jQuery("#notice-overlay").fadeOut("slow");
                    jQuery("#confirmation").fadeOut("slow");
                    jQuery("#loadajax p, #confirmation").html("");
                }, 1500);
        	});
            
        }
    });
    
});
</script>
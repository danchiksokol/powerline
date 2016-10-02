<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the google font library tools.
 */
 
//exit if accessed directly
if(!defined('ABSPATH')) exit;

?>
                    
<div id="font_filters">
    <div id="font_head">
        <h3>Google Font Manager</h3>
    </div>
    <div id="template_reset">
        <div id="mainbar" class="mainbar">
            <div id="mainbar_apply" class="mainbar-button subdued persist" title="Apply to Text Elements">
                <img src="<?php echo plugins_url( 'css/images/mainbar_text.png' , plugin_basename(__FILE__) ); ?>" />
            </div>
            <div id="mainbar_help" class="mainbar-button subdued persist" title="Help Files">
                <img src="<?php echo plugins_url( 'css/images/mainbar_help.png' , plugin_basename(__FILE__) ); ?>" />
            </div>
            <div id="mainbar_info" class="mainbar-button subdued" title="Author Info">
                <img src="<?php echo plugins_url( 'css/images/mainbar_info.png' , plugin_basename(__FILE__) ); ?>" />
            </div>
            <div class="mainbar_seperator"></div>
            <div id="mainbar_nukeit" class="mainbar-button subdued" title="Nuke All Fonts">
                <img src="<?php echo plugins_url( 'css/images/mainbar_nukeit.png' , plugin_basename(__FILE__) ); ?>" />
            </div>
            <div id="mainbar_settings" class="mainbar-button subdued" title="Settings &amp; Options">
                <img src="<?php echo plugins_url( 'css/images/mainbar_settings.png' , plugin_basename(__FILE__) ); ?>" />
            </div>
        </div>
    </div>
</div>

<div id="fonts_container">
    
    <div id="font_content">
    
        <br />
        
        <div id="font_data_container">
            
            <?php include dirname( __FILE__ ) .'/ajax/google_fonts.php'; ?>
            
            <?php if(!$google_api_key || !googlefontmgr_check_api($google_api_key)): ?>
            <div id="temporary_link_info">
                        
                <p>
                    The Google Font Manager plugin for WordPress was created as an instructional tool for new team members at <a href="http://butlerconsulting.com/" target="_blank">ButlerConsulting.com</a>. 
                    A primary reason for its development was to demonstrate "best practices" for how we want new plugins to be built. For this reason, it is over documented (to say the least) and provides a great deal
                    of useful information on how to build plugins for WordPress. If you are interested in learning more, you can visit these links:  
                    
                    <br /><br />
                    
                    <a href="http://butlerconsulting.com/work/plugins/google-font-manager/" target="_blank"><strong>Blog about the plugin (home page)</strong></a>,
                    <a href="http://plugins.butlerconsulting.com/google-font-manager/" target="_blank"><strong>Behind the scenes (how it was made)</strong></a>,
                    <a href="http://plugins.butlerconsulting.com/docs/google-font-manager/" target="_blank"><strong>Technical Documentation</strong></a>,
                    <a href="http://wordpress.org/plugins/google-font-manager/" target="_blank"><strong>WordPress Repository</strong></a>,
                    <a href="http://wordpress.org/support/plugin/google-font-manager/" target="_blank"><strong>WordPress Support Forum</strong></a>,
                    <a href="https://github.com/butler-consulting/google-font-manager/" target="_blank"><strong>GitHub Repository</strong></a>,
                    <a href="https://developers.google.com/fonts/docs/developer_api/" target="_blank"><strong>Google Font API</strong></a>
                </p>
                
            </div>
            
            <div class="clear"></div>
            <?php endif; ?>
            
        </div>
    
    </div>
    
</div>
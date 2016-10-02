<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the sidebar elements and form controls.
 */
 
global $is_networkactive;

//exit if accessed directly
if(!defined('ABSPATH')) exit;
 
//get google api key
$google_api_key = wp_googlefonts_getTheKey();

//get current font lists
$fontdata = get_option("wp_googlefontmgr_fonts");

//get option settings
$editorfonts = get_option("wp_googlefontmgr_editorfonts", 1);
$websafefonts = get_option("wp_googlefontmgr_safefonts", 1);
$styledefaults = get_option("wp_googlefontmgr_styledefaults", 0);

?>

<div class="clear"></div>

<div id="wp_googlefontmgr_settings" class="postbox">
    <h3>
        <span>Configuration Options &amp; Settings:</span>
    </h3>
    <div class="inside">
        <form id="googleapi" method="post" action="" name="googleapi">
        <div id="wp_googlefontmgr_settings_dialog">
            <p>
                <label for="material">Google API Developer Key:</label>
                <p class="small"><em>In order to use the font manager, we need to connect with your Google Developer API account. This will enable you to access the Google Fonts API. An Google Developer API key is free and easy to get as long as you have a Gmail account.</em></p>
                <label>Enter your API Key here:</label>
                <input id="wp_googlefontmgr_apikey" name="wp_googlefontmgr_apikey" value="<?php echo $google_api_key; ?>" <?php if($is_networkactive): ?>type="password" disabled="disabled"<?php else: ?>type="text"<?php endif; ?> />
                <br />
                <?php if($is_networkactive): ?>
                <strong id="browsefonts">API set globally by Network Admin.</strong>
                <?php else: ?>
                <a id="browsefonts" target='_blank' href='https://code.google.com/apis/console'>Click Here to Get Your Google API Key!</a>
                <?php endif; ?>
            </p>
        </div>

        <p class="clear"></p>
        
        <br />
        
        <div id="template_preview_options">
        <p>
            <label for="iosconrols">Visual Editor Options:</label>
            <p class="small"><em>With these options you are able to enable/disable font selectors in the visual editor and override template styles (enabled by default).</em></p>
            <div class="iosconrols">
                <ul>
                    <li id="enable_editorfonts" style="overflow: hidden;" class="ios-switch">
                        <label>Editor Fonts:</label>
                        <div class="jquery-switch-wrapper">
                            <a class="jquery-switch" rel="enable_editorfonts-input" name="enable_editorfonts_input" href="#"></a>
                        </div>
                        <input id="enable_editorfonts_input" type="radio" <?php if($editorfonts == 1): ?>checked="checked" value="1"<?php else: ?>value="0"<?php endif; ?> name="enable_editorfonts-input" style="position: absolute; top: -200px; left: -200px;" />
                    </li>
                    <li id="enable_safefonts" style="overflow: hidden;" class="ios-switch">
                        <label>Websafe Fonts:</label>
                        <div class="jquery-switch-wrapper">
                            <a class="jquery-switch" rel="enable_safefonts" name="enable_safefonts" href="#"></a>
                        </div>
                        <input id="enable_safefonts_input" type="radio" <?php if($websafefonts == 1): ?>checked="checked" value="1"<?php else: ?>value="0"<?php endif; ?> name="enable_safefonts-input" style="position: absolute; top: -200px; left: -200px;" />
                    </li>
                    <li id="enable_styledefaults" style="overflow: hidden;" class="ios-switch">
                        <label>Style Defaults:</label>
                        <div class="jquery-switch-wrapper">
                            <a class="jquery-switch" rel="enable_styledefaults" name="enable_styledefaults" href="#"></a>
                        </div>
                        <input id="enable_styledefaults_input" type="radio" <?php if($styledefaults == 1): ?>checked="checked" value="1"<?php else: ?>value="0"<?php endif; ?> name="enable_styledefaults-input" style="position: absolute; top: -200px; left: -200px;" />
                    </li>
                </ul>
            </div>
        </p>
        </div>
        
        <div class="clear"></div>
        <input type="button" class="button button-primary" value="Update Configuration" />
        <div class="clear"></div>
        
        </form>
        
    </div>
</div>

<div class="clear"></div>

<?php if($google_api_key && googlefontmgr_check_api($google_api_key)): ?>

<div id="wp_googlefontmgr_options">

    <div id="wp_googlefontmgr_selector" class="postbox">
        <h3>
            <span>Google Font Selector:</span>
        </h3>
        <div class="inside">
            <div id="font_selector_form">
                
                <?php echo "<h4>A total of <span class='countfonts'>0</span> fonts are available!</h4>"; ?>
                
                <input id="fontfinder" type="text" value="" placeholder="Start Typing" disabled="disabled" />
                
                <div id="thefontlist">
                    <?php 
                            
                        if(!$fontdata) {
                            echo "<p class='small'>You have not added any fonts to this template yet. Start by typing the name of the font you want to add in the box above, 
                                select the font from the list and that's it.</p>";
                        } else {
                            
                            echo "<p class='small'>Currently selected fonts:</p>";
                            
                            $array = explode(",", $fontdata);
                            foreach($array as $value) {
                                echo "<span class='fonlist " .strtolower(str_replace(" ", "-", $value)). "' data-font='$value'>" .$value. "<span class='delfont'></span></span>"; 
                            }
                                
                        }
                    
                    ?>
                </div>
                
            </div>
            
            <div class="clear"></div>
        </div>
    </div>
    
    <div id="wp_googlefontmgr_inspector" class="postbox">
        <h3>
            <span>Font Options Inspector:</span>
        </h3>
        <div class="inside">
            
            <div id="template_preview_options">
            
                <p class="small">The font options inspector allows you to view the variations and sizes available for each of the fonts you have added to your site.  
                Select a font from the list to view the details.</p>
                
                <p>
                    <select id="font_inspector_select" name="font_inspector_select">
                    <option value="" selected="selected">Select a Font to Inspect</option>
                    <?php 
                        if($fontdata) {
                            //get a list of all selected fonts
                            $array = explode(",", $fontdata);
                            foreach($array as $value) {
                                $value = str_replace('"', "", $value);
                                $value = str_replace("'", "", $value);
                                echo '<option value="' .$value. '">' .$value. '</option>';
                            } 
                        }
                    ?>
                    </select>
                    <select id="font_select_holder" name="font_select_holder" style="display: none;">
                    <?php 
                        if($fontdata) {
                            //get a list of all selected fonts
                            $array = explode(",", $fontdata);
                            foreach($array as $value) {
                                $value = str_replace('"', "", $value);
                                $value = str_replace("'", "", $value);
                                echo '<option value="font-family:\'' .$value. '\'">' .$value. '</option>';
                            } 
                        }
                    ?>
                    </select>
                </p>
                
                <div id="loaddata" style="display: none;">
                    <div class="loadertext">
                        <table cellpadding="2" cellspacing="2">
                            <tr>
                                <td><img class="ajaxloadimg" src="<?php echo plugins_url( 'css/images/ajax-loader.gif' , plugin_basename(__FILE__) ); ?>" /></td>
                                <td><p>Getting font data...</p></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div id="elementdtata"></div>
                
            </div>
    
            <div class="clear"></div>
    
        </div>
    </div>
    
</div>

<div class="clear"></div>

<?php endif; ?>

<div id="wp_googlefontmgr_helpfiles" style="display: none;">

    <div id="wp_googlefontmgr_selector" class="postbox">
        <h3>
            <span>Instructional Videos:</span>
        </h3>
        <div class="inside">
            <div id="video_helpfile">

                <div class="inside">
            
                    <div id="template_preview_options">
                    
                        <p class="small">Getting your Google API key.</p>
                        
                        <p>
                            <iframe src="//player.vimeo.com/video/83986921" width="235" height="132" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </p>
                        
                        <div class="clear"></div>
                        
                        <p class="small">Using this Plugin.</p>
                        
                        <p>
                            <iframe src="//player.vimeo.com/video/83987309" width="235" height="132" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </p>
                        
                    </div>
        
                <div class="clear"></div>
        
            </div>
                
                
            </div>
            
            <div class="clear"></div>
        </div>
    </div>
    
    <?php if($google_api_key && googlefontmgr_check_api($google_api_key)): ?>
    
    <div id="links_resources" class="postbox">
        <h3>
            <span>Additional Rsources &amp; Links:</span>
        </h3>
        <div class="inside">
            
            <div id="links_and_stuff">
            
                <p class="small">
                    This plugin was created as an instructional tool for new team members at <a href="http://butlerconsulting.com/" target="_blank">ButlerConsulting.com</a>. 
                    in order to show them how we want new WordPress plugins to be built. Therefore, it is very much "over documented" to say the least.  Here are the links:
                </p>
                
                <ul>
                    <li><a href="http://butlerconsulting.com/work/plugins/google-font-manager/" target="_blank"><strong>Blog about the plugin (home page)</strong></a></li>
                    <li><a href="http://plugins.butlerconsulting.com/google-font-manager/" target="_blank"><strong>Behind the scenes (how it was made)</strong></a></li>
                    <li><a href="http://plugins.butlerconsulting.com/docs/google-font-manager/" target="_blank"><strong>Technical Documentation</strong></a></li>
                    <li><a href="http://wordpress.org/plugins/google-font-manager/" target="_blank"><strong>WordPress Repository</strong></a></li>
                    <li><a href="http://wordpress.org/support/plugin/google-font-manager/" target="_blank"><strong>WordPress Support Forum</strong></a></li>
                    <li><a href="https://github.com/butler-consulting/google-font-manager/" target="_blank"><strong>GitHub Repository</strong></a></li>
                    <li><a href="https://developers.google.com/fonts/docs/developer_api/" target="_blank"><strong>Google Font API</strong></a></li>
                </ul>
                
            </div>
    
            <div class="clear"></div>
    
        </div>
    </div>
    
    <?php endif; ?>
    
</div>

<div class="clear"></div>

<script type="text/javascript">
jQuery(document).ready(function() {
    
    //handle google api form submission
    jQuery("#googleapi input.button").on("click", function(){ 
        if(jQuery("#wp_googlefontmgr_apikey").val() == ""){
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
        		action: 'wp_googlefontmgr_key',
        		wp_googlefontmgr_apikey: jQuery("#wp_googlefontmgr_apikey").val()
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
    
    <?php if(!$google_api_key || !googlefontmgr_check_api($google_api_key)): ?>
    jQuery("#wp_googlefontmgr_settings").fadeIn();
    jQuery("#mainbar_settings").addClass("active");
    jQuery("#mainbar_apply").addClass("disabled");
    jQuery("#mainbar_nukeit").addClass("disabled");
    <?php endif; ?>
    
});
</script>
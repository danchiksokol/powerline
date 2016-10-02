<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file sets options for the use and application of fonts.
 */
 
//exit if accessed directly
if(!defined('ABSPATH')) exit;


?>

<script type="text/javascript">
    <?php
        
        if(isset($_POST["element"])) {
         
            if($_POST["element"] == "enable_editorfonts") {
                //update editor font properties
                if($_POST["val"] == 0) {   
                    echo 'jQuery("#enable_editorfonts_input").val(1);';
                    echo 'jQuery("#enable_editorfonts_input").attr("checked", true);';
                    update_option("wp_googlefontmgr_editorfonts", 1);
                } else {    
                    echo 'jQuery("#enable_editorfonts_input").val(0);';
                    echo 'jQuery("#enable_editorfonts_input").removeAttr("checked");';
                    echo 'jQuery("#enable_safefonts").find("a.jquery-switch").removeClass("jquery-switch-on");';
                    update_option("wp_googlefontmgr_editorfonts", 0);
                    update_option("wp_googlefontmgr_safefonts", 0);
                }
            }
            
            if($_POST["element"] == "enable_safefonts") {
                //update websafe font properties
                if($_POST["val"] == 0) {   
                    echo 'jQuery("#enable_safefonts_input").val(1);';
                    echo 'jQuery("#enable_safefonts_input").attr("checked", true);';
                    echo 'jQuery("#enable_editorfonts").find("a.jquery-switch").addClass("jquery-switch-on");';
                    update_option("wp_googlefontmgr_safefonts", 1);
                    update_option("wp_googlefontmgr_editorfonts", 1);
                } else {    
                    echo 'jQuery("#enable_safefonts_input").val(0);';
                    echo 'jQuery("#enable_safefonts_input").removeAttr("checked");';
                    update_option("wp_googlefontmgr_safefonts", 0);
                }
            }
            
            if($_POST["element"] == "enable_styledefaults" || $_POST["element"] == "enable_styledefaultz") {
                //update style editor defaults
                if($_POST["val"] == 0) {   
                    echo 'jQuery("#enable_styledefaults_input, #enable_styledefaultz_input").val(1);';
                    echo 'jQuery("#enable_styledefaultz label").html("Disable Style Defaults:");';
                    echo 'jQuery("#enable_styledefaults_input, #enable_styledefaultz_input").attr("checked", true);';
                    echo 'jQuery("#enable_styledefaults, #enable_styledefaultz").find("a.jquery-switch").addClass("jquery-switch-on");';
                    echo 'jQuery(".advancefont").removeClass("disabled");';
                    echo 'jQuery("#setfont_styles select").prop("disabled",false);';
                    update_option("wp_googlefontmgr_styledefaults", 1);
                } else {    
                    echo 'jQuery("#enable_styledefaultz label").html("Enable Style Defaults:");';
                    echo 'jQuery("#enable_styledefaults_input, #enable_styledefaultz_input").val(0);';
                    echo 'jQuery("#enable_styledefaults_input, #enable_styledefaultz_input").removeAttr("checked");';
                    echo 'jQuery("#enable_styledefaults, #enable_styledefaultz").find("a.jquery-switch").removeClass("jquery-switch-on");';
                    echo 'jQuery("li.ios-style").removeAttr("style");';
                    echo 'jQuery("#setfont_styles .extended-styles").hide();';
                    echo 'jQuery(".advancefont, .extended-styles").removeClass("open");';
                    echo 'jQuery(".advancefont").addClass("disabled");';
                    echo 'jQuery("#setfont_styles select").prop("disabled",true);';
                    echo 'jQuery("#setfont_styles select").val("default");';
                    echo 'jQuery("#google_font_stylechange").val(0);';
                    echo 'jQuery("#google_font_updatestyle").hide();';
                    update_option("wp_googlefontmgr_styledefaults", 0);
                }
            }
        }
        
        if(isset($_POST["stylesheet"])) {
            
        	update_option('wp_googlefontmgr_styleopts', $_POST["stylesheet"]);
            echo 'jQuery("#google_font_stylechange").val(0);';
            echo 'jQuery("#google_font_updatestyle").fadeOut("slow");';
            echo 'jQuery("#testpage").attr("src","'. plugins_url( '/font_testpage.php' , plugin_basename(__FILE__) ). '");';
        }
        
    ?>
</script>
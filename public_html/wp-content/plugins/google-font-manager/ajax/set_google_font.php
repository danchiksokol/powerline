<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file updates the template with font choices.
 */
 
//exit if accessed directly
if(!defined('ABSPATH')) exit;

$fontcount = 0;
$errormessage = "";
$font = urlencode($_POST["font"]);

//get current font lists
$fontdata = get_option("wp_googlefontmgr_fonts");

$test_data = wp_remote_get("https://fonts.googleapis.com/css?family=$font");

//test font to make sure it exists
if($test_data['response']['code'] !== 200 && !isset($_POST["remove"])){
    
    $font = urldecode($font);
    
    if($test_data['response']['code'] === 400){
        
        $errormessage = "<div class='error message'><p><strong>ERROR:</strong> Missing font family: $font. The requested font family is not available.</p></div>";
        
    } else {
        
        $errormessage = "<div class='error message'><p><strong>ERROR:</strong> Something has gone wrong with your font request. Google returned an error.</p></div>";
        
    }
    
} else {
    
    $font = urldecode($font);
    
    if($fontdata) {
        
        //get current font count
        $fontcount = substr_count($fontdata, ",") +1;
    
        if(isset($_POST["remove"])) {
            
            //remove font to the list
            if($fontcount > 1 && $_POST["remove"] != "all"){
                
                $fonts = explode(",", $fontdata);
                while(($i = array_search($font, $fonts)) !== false) {
                    unset($fonts[$i]);
                }
                
                $fontdata = implode(",", $fonts);
                update_option("wp_googlefontmgr_fonts", $fontdata);
                delete_option('wp_googlefontmgr_styleopts');
                
            } else {
                delete_option("wp_googlefontmgr_fonts");
            }   
            
        } else {
            
            //add to font list
            $fontlist = explode(',',$fontdata);
            if (!in_array($font, $fontlist)) {
                $fontdata .= ",$font";
                update_option("wp_googlefontmgr_fonts", $fontdata);
            } else {
                $errormessage = "<div class='error message'><p><strong>ERROR:</strong> $font is already in your font list!</p></div>";
            }
            
        }
    } else {
        
        if($font != "none"){
            update_option("wp_googlefontmgr_fonts", $font);
        }
        
    }
}

$fontdata = get_option("wp_googlefontmgr_fonts");


?>

<script type="text/javascript">
    
    <?php 
    
    if($fontdata && !isset($_POST["remove"]) && !$errormessage) {
        //load temporary font stylesheet
        $cssname = "wp-fontster-" .strtolower(str_replace("-", " ", $font));
        echo 'var stylesheet = "<link rel=\'stylesheet\' id=\'' .$cssname. '\'  href=\'//fonts.googleapis.com/css?family=' .urlencode($font). '\' type=\'text/css\' media=\'all\' />";';
        echo 'var fontitem = \'<div id="listfont_' .strtolower(str_replace(" ", "-", $font)). '" class="fontlist-item" data-font="' .$font. '"><p class="heading" data-font="' .$font. '">' .urldecode($font). '<span class="delfont"></span></p><h2 style=\"font-family:' .$font. '\">Grumpy wizards make toxic brew for the evil Queen and Jack.</h2></div>\';';
        echo 'var listitem = "<span class=\'fonlist ' .strtolower(str_replace(" ", "-", $font)). '\' data-font=\'' .$font. '\'>' .$font. '<span class=\'delfont\'></span></span>";'; 
        echo 'var formitem = "<option value=\'' .$font. '\'>' .$font. '</option>";';
        echo 'var formelem = "<option value=\"font-family:\'' .$font. '\'\">' .$font. '</option>";';
        echo 'if(!jQuery("#' .$cssname. '-css").length) { jQuery("head").append(stylesheet); }';
        echo 'jQuery("#myfontlist").prepend(fontitem);';
        echo 'jQuery("#thefontlist").append(listitem);';
        echo 'jQuery("#font_inspector_select").append(formitem);';
        echo 'jQuery("#font_select_holder").append(formelem);';
        //add item to font select dropdown
        echo 'jQuery("ul.fontSelectUl").prepend(\'<li class="' .strtolower(str_replace(" ", "-", $font)). '" style="font-family: ' .$font. ';">' .$font. '</li>\');';
        //remove no item message
        echo 'jQuery("p.nonemsg").remove();';
    }
    
    if(isset($_POST["remove"])) {
        //remove font from dropdown
        $cssname = "wp-fontster-" .strtolower(str_replace("-", " ", $font). "-css");
        echo 'jQuery("ul.fontSelectUl li.'.strtolower(str_replace(" ", "-", $font)).'").remove();';
        echo 'jQuery("#'.$cssname.', .'.strtolower(str_replace(" ", "-", $font)).'").remove();';
        echo 'jQuery("#font_inspector_select option[value=\'' .$font. '\'], #font_select_holder option[value=\'font-family:\'' .$font. '\'\']").remove();';
        echo 'jQuery("#font_inspector_select").val(""); jQuery("#elementdtata").empty();';
        //remove existing font and replace with default
        echo 'jQuery("#inner_container div").each(function(){
            if(jQuery(this).attr("style")) {
                var currstyle = jQuery(this).attr("style");
                if(jQuery.trim(jQuery(this).css("font-family")) == "'.$font.'") {
                    alert(jQuery(this).css("font-family"));
                    jQuery(this).removeAttr("style");
                    var newcss = currstyle.replace("'.$font.'", "Arial,Helvetica,sans-serif");
                    jQuery(this).attr("style",newcss);
                }
            }
        });';
    }
    
    if($errormessage){
        //load error messages
        echo 'jQuery("#advanced-sortables").prepend("' .$errormessage. '");';
        echo 'var timerId = setTimeout(function() { jQuery(".message").fadeOut("slow"); }, 4000);';
    }
    
    if(!$fontdata) {
        echo 'jQuery("#myfontlist, #thefontlist, #elementdtata").empty();';
        echo 'var nonemsg = "<p class=\'nonemsg\'>You have not added any fonts to this template yet. You may add up to five custom fonts for use in any template. Use the form located on the right to select the fonts you want to add. Click the preview tab to browse through available fonts and see what each one looks like.</p>";';
        echo 'jQuery("#myfontlist").prepend(nonemsg);';
        echo 'var intromsg = "<p class=\'intromsg small\'>You have not added any fonts to this template yet. Start by typing the name of the font you want to add in the box above, select the font from the list and that\'s it.</p>";';
        echo 'jQuery("#thefontlist").prepend(intromsg);';
        echo 'jQuery("#fontfinder, #font_inspector_select").val("");';
        echo 'jQuery("#font_inspector_select option[value!=\'\'], #font_select_holder option").remove();';
    }
    
    echo 'jQuery("#testpage").attr("src","'. plugins_url( '/font_testpage.php' , plugin_basename(__FILE__) ). '");';
    
    ?>
    //clear font finder value
    jQuery("#fontfinder").val("");
    setCurrentStyles();
    
</script>
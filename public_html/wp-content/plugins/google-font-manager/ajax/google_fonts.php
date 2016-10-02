<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the google font library tools (the main "guts of the plugin").
 */

//exit if accessed directly
if(!defined('ABSPATH')) exit;

$fontcount = 0;
//get current font lists
$fontdata = get_option("wp_googlefontmgr_fonts");

?>
                        
<?php 
    
    $errors = false;
    $google_api_key = wp_googlefonts_getTheKey();
    
    //error checking - validate apikey
    if(!$google_api_key) { 
        $errors = true;
        echo "<h1>In order to make use of this plugin, you are going to need a Google API Key. 
                Click on the settings icon on the top toolbar to get and enter your Google API credentials.</h1>"; 
    } else {
        
        $api_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=";
    	$api_data = wp_remote_get($api_url . $google_api_key);
    	
        //return codes if valid or not
        if($api_data['response']['code'] !== 200){
            $errors = true;
            echo "<h1>Oops! It appears that your Google API Key is incorrect or invalid. 
                Click on the settings icon on the top toolbar and update your Google API credentials.</h1>"; 
        } 
        
    }
    
    echo '<div id="fontloader-errors">';
    // display error message to users
    if ( version_compare( phpversion(), '5.2', '<' ) ) {
        $errors = true;
        echo "<h3>Sorry, this function requires PHP 5.2 or higher. Please check with your site administrator.</h3>";
    }
    
    if(!function_exists("json_decode")){
        $errors = true;
        echo "<h3>Sorry, this function requires PHP json_decode() function.  Please check with your site administrator.</h3>";
    }
    echo '</div>';

    //if no errors, get the content
    if(!$errors) : 
    
	// transient caching
	if ( false === ( $font_list = get_transient( 'wp_googlefontmgr_manager_cache' ) ) ) {
		
        $api_data = wp_remote_get($api_url . $google_api_key);
		$response = $api_data['response'];
		$body =  json_decode($api_data['body'], true);
		
		if(200 === $response['code']){
			$font_list = $body;
			set_transient( 'wp_googlefontmgr_manager_cache', $font_list, 60*60*12 );
		}
	}
    
    if(isset($font_list) && count($font_list) == 0){
		echo "<b>Error: Can not connect to Google Web Fonts API, please double check your API Key and Try Again!</b>";
	} else {
	   
       
    //load font styles
    $fontselectdrop = "";
    $fontdata = get_option("wp_googlefontmgr_fonts");
    if($fontdata) {
        //load fonts for use in plugin
        $array = explode(",", $fontdata);
        foreach($array as $value) {
            $cssname = "google-font-manager-" .strtolower(str_replace(" ", "-", $value));
            wp_enqueue_style($cssname,'//fonts.googleapis.com/css?family='.$value);
            $fontselectdrop .='<li class="' .strtolower(str_replace(" ", "-", $value)). '" style="font-family: ' .$value. ';">' .$value. '</li>';
        }
    }
    //echo  get_option("wp_googlefontmgr_styleopts", "");     
       
?>

<div id="font_elements">
    
    <div id="font_selector">
        <div id="selected_fonts_tab" class="fonttabs selected" data-tab="#selector_tab">Selected Fonts</div>
        <div id="preview_fonts_tab" class="fonttabs" data-tab="#preview_tab">Preview Fonts</div>
        <div id="default_styles_tab" class="fonttabs" data-tab="#styles_tab">Default styles</div>
        <div id="documentation_tab" class="fonttabs" data-tab="#docs_tab">How to Use</div>
        <div id="selector_tab" class="tabsbox selected">
        
            <div id="selectedfonts">
                <h3>Fonts applied to your website:</h3>
                
                <div id="myfontlist">
                    <?php 
                    
                    if(!$fontdata) {
                        echo "<p class='nonemsg'>You have not added any fonts to this template yet. You may add up to five custom fonts for use in any template. Use the form located on the right to select 
                            the fonts you want to add. Click the preview tab to browse through available fonts and see what each one looks like.</p>";
                    } else {
                        
                        $array = explode(",", $fontdata);
                        foreach($array as $value) {
                            echo '<div id="listfont_' .strtolower(str_replace(" ", "-", $value)). '" class="fontlist-item" data-font="' .$value. '">
                                    <p class="heading" data-font="' .$value. '">' .$value. '<span class="delfont"></span></p>
                                    <h2 style="font-family:' .$value. '">Grumpy wizards make toxic brew for the evil Queen and Jack.</h2>
                                </div>';
                        }
                        
                    }
                    
                    
                    ?>
                </div>
                
                <div class="clear"></div>
                <br /><br />
                
            </div>
        
        </div>
        <div id="preview_tab" class="tabsbox">
        
            <h3>To preview what each font looks like, simply click on the font you want to view and the "font viewer tab" will open and display the characters for you.  
            This allows you to see what the font will look like in action on your site.</h3>
            
            <?php 
	
                $google_fontlist = "";
                $autocomplete = "";
                
                foreach($font_list['items'] as $font){
            
            		$link_url = "http://www.google.com/webfonts/specimen/" . urlencode($font['family']);
            		$font_name =  $font['family'];
            		$font_family = "$font_name";
                    
            		$google_fontlist .= "<span class='fonlist $font_family' data-font='$font_family'>" . $font_name  . "</span>"; 
                    $autocomplete .= '"' .$font_name. '",';
                    
            		$font_name = str_replace(" ", "-", $font['family']);
            	
            	}
                
                echo '<div id="font_list_container">';
                echo $google_fontlist;
                echo '</div>';
                  
            	 
            ?>
            
        </div>
        <div id="styles_tab" class="tabsbox">
        
            <?php require_once dirname( __FILE__ ) .'/style_defaults.php'; ?>
            
        </div>
        <div id="docs_tab" class="tabsbox">
        
            <?php require_once dirname( __FILE__ ) .'/plugin_docs.php'; ?>
            
        </div>
        
    </div>
    <iframe id="testpage" src="<?php echo plugins_url( '/font_testpage.php' , plugin_basename(__FILE__) ); ?>" width="0" height="0"></iframe>
    
</div>

<?php } endif; ?>

<script type="text/javascript">
    
    //remote add font function
    function addTheFont(font){
        <?php if(!$google_api_key || !googlefontmgr_check_api($google_api_key)): ?>
        //if google apikey is not set
        jQuery("#fontfinder").prop("disabled",true);
        jQuery("#rusureok #confirm").attr("data-action", "closeme");
        jQuery("#rusureok p").html("Please enter the API key provided to you by Google. <strong>An API Key is required to use the font utility.</strong>");
        jQuery("#confirmation").html(jQuery("#rusureok").html());
        jQuery("#notice-overlay").fadeIn("slow");
        jQuery("#confirmation").fadeIn("slow");
        jQuery("#confirm").focus();
        //hide the fontview panel
        jQuery("#fontviewer").animate({right:'-720px'}, {queue: false, duration: 800});
        jQuery("#fontviewer").removeClass("open");
        //open the settings panel
        jQuery("#wp_googlefontmgr_options").hide(); 
        jQuery("#wp_googlefontmgr_settings").fadeIn();
        jQuery("#mainbar_settings").addClass("active");
        <?php else: ?>
        jQuery("#fontfinder").prop("disabled",false);
        var data = { action: 'wp_googlefontmgr_setfonts', font: font };
    	jQuery.post(ajaxurl, data, function(response) {
    		jQuery("#response-div").html(response);
    	});
        var timerId = setTimeout(function() { 
            jQuery("#fontviewer").animate({right:'-720px'}, {queue: false, duration: 800});
            jQuery("#fontviewer").removeClass("open");
        }, 500);
        jQuery("#mainbar_apply").removeClass("disabled");
        jQuery("#mainbar_nukeit").removeClass("disabled");
        <?php endif; ?>
    }
    //clear font finder value
    jQuery("#fontfinder").val("");
    //open fontviewer and display new fonts
    jQuery("#fonts_container, #wp_googlefontmgr_options").on("click", ".fonlist, .fontlist-item, .fontvar", function(){
        //set the font value in preview
        var fontvalue = jQuery(this).attr("data-font");
        var urlstr = "<?php echo plugins_url( 'font_viewer.php' , plugin_basename(__FILE__) ); ?>?font=" + fontvalue;
        jQuery("#fontview_panel").attr("src",urlstr);
        //open the fonviewer panel
        if(!jQuery("#fontviewer").hasClass("open")){
            jQuery("#fontviewer").animate({right:'-65px'}, {queue: false, duration: 800});
            jQuery("#fontviewer").addClass("open");
        }
    });
    //remove font from the list
    jQuery("#fonts_container, #thefontlist").on("click", ".delfont", function(e){
        e.preventDefault();
        e.stopPropagation();
        //get font data and remove item
        var fontvalue = jQuery(this).parent().attr("data-font");
        var data = { action: 'wp_googlefontmgr_killfonts', font: fontvalue, remove: 1 };
    	jQuery.post(ajaxurl, data, function(response) {
    		jQuery("#response-div").html(response);
    	});
        //remove current item display
        var cssname = "#wp-fontster-" + fontvalue.replace(/\s+/g, '-').toLowerCase();
        var itemname = "#listfont_" + fontvalue.replace(/\s+/g, '-').toLowerCase();
        jQuery("#thefontlist span." + fontvalue.replace(/\s+/g, '-').toLowerCase()).remove();
        jQuery(itemname).remove();
        jQuery(cssname).remove();
    });
    <?php if(!$google_api_key || !googlefontmgr_check_api($google_api_key)): ?>
    //if google apikey is empty open the settings panel
    var timerId = setTimeout(function() {
        jQuery("#wp_googlefontmgr_options").hide(); 
        jQuery("#wp_googlefontmgr_settings").fadeIn();
        jQuery("#mainbar_settings").addClass("active");
    }, 1000);
    <?php else: ?>
        //set up the autocomplete form
        var availableFonts = [<?php echo $autocomplete; ?>];
        jQuery("#fontfinder").autocomplete({ 
            source: availableFonts, 
            select: function(e,ui) {
                var selectedObj = ui.item;
                var data = { action: 'wp_googlefontmgr_setfonts', font: selectedObj.value };
            	jQuery.post(ajaxurl, data, function(response) {
            		jQuery("#response-div").html(response);
            	});
            }
        });
        //set the available font count
        jQuery("span.countfonts").html(<?php echo count($font_list['items']); ?>);
        <?php if($fontdata && $fontselectdrop): ?>
        //add font items to font select dropdown
        var timerId = setTimeout(function() { 
            jQuery("ul.fontSelectUl").prepend('<?php echo $fontselectdrop; ?>');
        }, 2000);
        <?php endif; ?>
        jQuery("#fontfinder").prop("disabled",false);
    <?php endif; ?>
     
</script>
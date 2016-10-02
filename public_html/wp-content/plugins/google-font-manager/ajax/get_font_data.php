<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file gets and displays the relevant font data for each google font.
 */
 
//exit if accessed directly
if(!defined('ABSPATH')) exit;
      
$errormessage = "";
$font = urlencode($_POST["font"]);

$google_api_key = wp_googlefonts_getTheKey();
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

    //error checking - validate apikey
    if(!$google_api_key) { 
        $errors = true;
        echo "<h1>In order to use this option, you are going to need a Google API Key. 
                Click on the settings icon on the top toolbar to get and enter your Google API credentials.</h1>"; 
    } else {
        
        $api_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=";
    	$api_data = wp_remote_get($api_url . $google_api_key);
        
        $data = json_decode($api_data['body'],true);
        
        echo "<p class='subdued' align='center'><em>(Click on variants to inspect in previewer)</em></p>";
        
        $items = $data['items'];
        foreach ($items as $item) {
            
            if($font == $item['family']) {
                
                $str = '<strong>Variants:</strong>';
                foreach ($item['variants'] as $variant) {
                  $str .= ' <span class="fontvar" data-font="'.$font.'&variant='.$variant.'">' .$variant. '</span>, ';
                }
                echo rtrim($str,', ').'<br /><br />';
                $str = "";
                $str.= '<strong>Subsets:</strong>';
                foreach ($item['subsets'] as $subset) {
                  $str .= ' '.$subset. ', ';
                  //$str .= ' <span class="fontvar" data-link="//fonts.googleapis.com/css?family='.$font.'&subset='.$subset.'">' .$subset. '</span>, ';
                }
                echo rtrim($str,', ').'<br />';
                
            }

        }
    }
}

?>
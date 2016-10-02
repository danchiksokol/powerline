<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file displays the current default styles applied.
 */
 
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );  
global $wpdb,  $post, $current_user;

//if user is not logged in... abort the call
if ( !is_user_logged_in() ) {
    wp_die('You are not authorized to perform any functions.'); exit(); 
}


?>

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Thomas Butler" />
    <?php 
        //get main theme style (in case of child theme)
        echo '<link rel="stylesheet" type="text/css" href="' .get_template_directory_uri(). '/style.css" />';
        //get child theme style (may be duplicate if no child theme - no big deal)
        echo '<link rel="stylesheet" type="text/css" href="' .get_stylesheet_directory_uri(). '/style.css" />';
        //load font styles
        $fontdata = get_option("wp_googlefontmgr_fonts");
        if($fontdata) {
            //load fonts for use in plugin
            $fontselectdrop = "";
            $array = explode(",", $fontdata);
            foreach($array as $value) {
                echo '<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=' .$value. '" />';
            }
        }
        
    ?>
    <style>
    <?php 
    
        //get option settings
        $styledefaults = get_option("wp_googlefontmgr_styledefaults", 0);    
        
        if($styledefaults) {
            $stylesheet = get_option("wp_googlefontmgr_styleopts", "");    
            if($styledefaults != "") {
                echo stripslashes($stylesheet);
            }
        } 
        
    ?>
    </style>
	<title>Google Font Manager (test page)</title>
</head>

<body>
<div class="testpage">

    This is some text in the body

    <p>this is a paragraph of text</p>
    
    <h1>This is Heading1</h1>
    <h2>This is Heading2</h2>
    <h3>This is Heading3</h3>
    <h4>This is Heading4</h4>
    <h5>This is Heading5</h5>
    <h6>This is Heading6</h6>
    
    <ul>
        <li>List item one</li>
        <li>List item two</li>
        <li>List item three</li>
    </ul>

</div>
<script type="text/javascript">
    
    if (typeof setCurrentStyles == 'function') { 
        var timerId = setTimeout(function() { window.parent.setCurrentStyles(); }, 100);
    }
   
</script>
</body>
</html>
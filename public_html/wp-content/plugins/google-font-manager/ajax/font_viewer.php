<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file allows you to preview fons with Google Fonts.
 */

    $fontface = "Open Sans";
    if(isset($_GET["font"])) {
        $fontface = $_GET["font"];
    }
    if(isset($_GET["variant"])) {
        $variant = $_GET["variant"];
    }
?>

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Thomas Butler" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=<?php echo urlencode($fontface); ?><?php if(isset($_GET["variant"])) { echo ":" .urlencode($variant); } ?>" />
    <style>
    body {
        font-family: '<?php echo urldecode($fontface); ?>';
    }
    .fontviewer {
        font-size: 13px;
        font-style: normal;
        width: 640px;
    }
    .fontviewer h1 {
        font-size: 64px;
        line-height: 73px;
        margin-bottom: 25px;
    }
    .fontviewer p {
        font-size: 17px;
        line-height: 26px;
        margin-bottom: 35px;
    }
    .fontviewer p.weights {
        border-style: dotted;
        border-width: 0 0 1px;
        color: #ADADAD;
        font-size: 13px;
        letter-spacing: 2px;
        margin-bottom: 35px;
        font-style: normal !important;
        margin-top: 45px;
    }
    .fontviewer p.pullquote {
        border-style: solid;
        border-width: 0 0 0 3px;
        font-size: 17px;
        font-weight: 700;
        line-height: 26px;
        margin-bottom: 35px;
        padding-left: 15px;
    }
    .fontviewer p.variations {
        font-size: 17px;
        font-weight: 400;
        line-height: 26px;
        margin-bottom: 0px;
        padding-left: 15px;
    }
    .fontviewer p.map {
        font-size: 27px;
        font-style: normal;
        font-weight: 400;
        line-height: 54px;
        margin-bottom: 0;
        margin-top: 0;
        text-align: justify;
    }
    .fontviewer p.heading {
        border-style: dotted;
        border-width: 0 0 1px;
        color: #000000;
        font-size: 13px;
        letter-spacing: 2px;
        margin-bottom: 35px;
    }
    .fontviewer p.intro {
        font-size: 21px;
        line-height: 28px;
        margin-bottom: 35px;
    }
    .fontviewer .inverse {
        background-color: #333333;
        color: #FFFFFF;
    }
    .fontviewer p.inverse-big {
        margin-bottom: 0;
        padding: 0px 30px 0px 30px;
    }
    .fontviewer p.inverse-med {
        font-size: 15px;
        margin-bottom: 0;
        padding: 0px 30px 0px 30px;
    }
    .fontviewer p.inverse-small {
        font-size: 13px;
        padding: 0 30px 30px;
    }
    .fontviewer p.inverse-heading {
        font-size: 15px;
        letter-spacing: 2px;
        margin-bottom: 0;
        margin-top: 50px;
        padding: 30px 30px 0;
    }
    .fontviewer .addfont {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0.65);
        border-radius: 3px;
        font-family: Arial,Helvetica,sans-serif;
        font-weight: bold;
        font-style: normal !important;
        color: #DDDDDD !important;
        cursor: pointer;
        display: inline-block;
        height: 20px;
        padding: 8px 12px 5px 12px;
        position: fixed;
        text-align: center;
        right: 40px;
        bottom: 10px;
        width: auto;
    }
    .fontviewer .addfont:hover {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0.95);
        color: #FFFFFF !important;
    }
    .closepanel {
        float: right;
        font-family: Arial,Helvetica,sans-serif !important;
        font-weight: bold;
        font-size: 12px !important;
        cursor: pointer;
    }
    .closepanel:hover {
        text-decoration: underline;
    }
    </style>
	<title>Google Font Manager (Font Viewer)</title>
</head>

<body>
<div class="fontviewer">

    <div class="container" style="width: 600px">
        
        <p class="heading"><?php echo urldecode($fontface); ?><?php if(isset($_GET["variant"])) { echo ":" .urldecode($variant); } ?><span class="closepanel" onclick="window.parent.closePanel();">close panel</span></p>
        
        <h1>Grumpy wizards make toxic brew for the evil Queen and Jack.</h1>
        
        <p class="intro">
            Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.   
        </p>
        
        <p class="pullquote">
            "The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked." 
        </p>
        
        <p>
            Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.  The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked.
        <br />
        </p>
        
        <p class="weights">VARIATIONS</p>
        
        <p class="variations">Normal: Grumpy wizards are silly.</p>
        <p class="variations">Italic: <em>Grumpy wizards are silly.</em></p>
        <p class="variations">Bold: <strong>Grumpy wizards are silly.</strong></p>
        <p class="variations">Bold Italic: <strong><em>Grumpy wizards are silly.<em></strong></p>
        
        <p class="weights">CHARACTERS</p>
        
        <div align="center">
            <p class="map">A B C D E F G H I J K L M N O P Q R S T U V X Y Z</p>
            <p class="map">a b c d e f g h i j k l m n o p q r s t u v x y z</p>
            <p class="map">1 2 3 4 5 6 7 8 9 0 - = _ + < > ? / . , : &amp; &trade; &copy; "</p>
        </div>
        
        <div class="inverse">
        
            <p class="inverse-heading">WHITE on BLACK</p>
            
            <p class="inverse-big">
                Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.   
            </p>
            
            <p class="inverse-med">
                 Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.   
            </p>
            
            <p class="inverse-small">
                Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections.   
            <br />
            </p>
            
        </div>
        <?php if(!isset($_GET["variant"])): ?>
        <div class="addfont" onclick="window.parent.addTheFont('<?php echo $fontface; ?>');">Add This Font</div>
        <?php endif; ?>
    </div>
    
</div>
</body>
</html>
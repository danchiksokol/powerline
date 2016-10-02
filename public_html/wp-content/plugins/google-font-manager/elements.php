<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the control buttons, message boxes and ajax containers.
 */
 
//exit if accessed directly
if(!defined('ABSPATH')) exit;

?>

<div id="loadajax" style="display: none !important;">
    <div class="loadertext">
        <table cellpadding="2" cellspacing="2">
            <tr>
                <td><img class="ajaxloadimg" src="<?php echo plugins_url( 'css/images/ajax-loader.gif' , plugin_basename(__FILE__) ); ?>" /></td>
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

<div id="google_font_updatestyle" style="display: none;" onclick="setTheStylesheet();">Update Style Sheet!</div>

<div id="response-div"></div>
<div id="notification"></div>
<div id="confirmation"></div>
<div id="notice-overlay"></div>
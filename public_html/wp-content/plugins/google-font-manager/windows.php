<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the pop-up windows for element and form control.
 */
 
//exit if accessed directly
if(!defined('ABSPATH')) exit;

?>

<div id="fontviewer">
    <div id="viewertab" title="Preview Fonts"></div>
    <iframe id="fontview_panel" src="<?php echo plugins_url( 'ajax/font_viewer.php' , plugin_basename(__FILE__) ); ?>" width="675" height="98%"></iframe>
</div>

<div id="aboutus" style="display: none !important;">
    <div id="aboutplugin" class="abouttext">
        <span class="closewin" onclick="cancelme();"></span>
        <table cellpadding="2" cellspacing="2">
            <tr>
                <td>
                <div id="logo" align="center">
                    <a class="author-link" href="http://butlerconsulting.com/" target="_blank">
                        <img src="<?php echo plugins_url( 'css/images/logo.png' , plugin_basename(__FILE__) ); ?>" />
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
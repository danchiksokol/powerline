<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the basic HTML framework for the plugin's display.
 */
 
//exit if accessed directly
if(!defined('ABSPATH')) exit;

?>
<div class="wrap">
    
    <div id="google_fonts_selector">
        
        <img id="pluginlogo" src="<?php echo plugins_url( 'css/images/wp_googlefontmgr.png' , plugin_basename(__FILE__) ); ?>" />
        
        <div id="poststuff" style="display: none;">
            
            <div id="post-body" class="metabox-holder columns-2">
            
                <div id="postbox-container-1" class="postbox-container">
                    
                    <div id="side-sortables" class="meta-box-sortables">
                        
                        <?php require_once dirname( __FILE__ ) .'/controls.php'; ?>
                        
                    </div>
                </div>
                
                <div id="postbox-container-2" class="postbox-container">
                
                    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    
                        <div id="advanced-sortables" class="meta-box-sortables ui-sortable">
                            
                            <?php include dirname( __FILE__ ) .'/fonts.php'; ?>
                            
                            <br class="clear" />
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                <br class="clear" />
                
            </div>
            
            <div class="clear"></div>

        </div>

        <?php require_once dirname( __FILE__ ) .'/elements.php'; ?>
        <?php require_once dirname( __FILE__ ) .'/windows.php'; ?>
        
        <div class="clear"></div>
        
    </div>

</div>


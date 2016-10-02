<?php

/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file enables you to set the style defaults for creating the embedded style sheet.
 */

?>

<h3>
    This option set allows you to assign your selected Google fonts to each of the default elements that appear in your theme like the body (default), paragraphs, header tags (&#60;h1&#62;, &#60;h2&#62;, &#60;h3&#62;, etc.) and other elements such as list items (&#60;li&#62;, &#60;ol&#62;) and blockquotes.
    The "Style Defaults" option must be turned on in your settings in order for these function to be enabled.  
</h3>

<p class="note">
    <em><strong>NOTE:</strong> If you are an advanced user who is directly editing your style sheet (as with a child theme), you will not want to enable this option.  If you do, you may 
    have to use the "!important" constructor to override these default settings in your CSS, as they are added after your themes's default style sheet is loaded.</em>
</p>

<input type="hidden" id="google_font_stylechange" value="0" />
<div id="setfont_styles" class="iosconrols">
    <ul>
        <li id="enable_styledefaultz" class="ios-switch">
            <label><?php if($styledefaults == 1): ?>Disable Style Defaults:<?php else: ?>Enable Style Defaults:<?php endif; ?></label>
            <div class="jquery-switch-wrapper">
                <a class="jquery-switch" rel="enable_styledefaultz" name="enable_styledefaultz" href="#"></a>
            </div>
            <input id="enable_styledefaultz_input" type="radio" <?php if($styledefaults == 1): ?>checked="checked" value="1"<?php else: ?>value="0"<?php endif; ?> name="enable_styledefaultz-input" style="position: absolute; top: -200px; left: -200px;" />
        </li>
        <li id="enable_important" class="ios-switch">
            <label>Use !important in CSS:</label>
            <div class="jquery-switch-wrapper">
                <a class="jquery-switch" rel="enable_important" name="enable_important" href="#"></a>
            </div>
            <input id="enable_important_input" type="radio" name="enable_important-input" style="position: absolute; top: -200px; left: -200px;" />
        </li>
    </ul>
    <ul>
        <li class="ios-style">
            <label>Body Tag <span class="cody">(&#60;body&#62;)</span></label>
            <select id="body_select" name="body_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
                <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="body_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-body_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-body_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
        <li class="ios-style">
            <label>Paragraphs <span class="cody">(&#60;p&#62;)</span></label>
            <select id="p_select" name="p_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
            <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="p_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-p_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-p_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
        <li class="ios-style">
            <label>Heading One <span class="cody">(&#60;h1&#62;)</span></label>
            <select id="h1_select" name="h1_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
            <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="h1_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-h1_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-h1_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
        <li class="ios-style">
            <label>Heading Two <span class="cody">(&#60;h2&#62;)</span></label>
            <select id="h2_select" name="h2_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
            <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="h2_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-h2_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-h2_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
        <li class="ios-style">
            <label>Heading Three <span class="cody">(&#60;h3&#62;)</span></label>
            <select id="h3_select" name="h3_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
            <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="h3_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-h3_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-h3_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
        <li class="ios-style">
            <label>Heading Four <span class="cody">(&#60;h4&#62;)</span></label>
            <select id="h4_select" name="h4_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
            <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="h4_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-h4_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-h4_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
        <li class="ios-style">
            <label>Heading Five <span class="cody">(&#60;h5&#62;)</span></label>
            <select id="h5_select" name="h5_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
            <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="h5_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-h5_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-h5_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
        <li class="ios-style">
            <label>Heading Six <span class="cody">(&#60;h6&#62;)</span></label>
            <select id="h6_select" name="h6_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
            <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="h6_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-h6_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-h6_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
        <li class="ios-style lastone">
            <label>Lists <span class="cody">(&#60;ul&#62; &amp; &#60;ol&#62;)</span></label>
            <select id="li_select" name="li_select" class="assign-style" <?php if($styledefaults == 0): ?>disabled="disabled"<?php endif; ?>>
            <option value="default" selected="selected">Theme Default</option>
            </select>
            <span class="advancefont<?php if($styledefaults == 0): ?> disabled<?php endif; ?>" title="Advanced Options"></span>
        </li>
        <li id="li_select_extend" class="extended-styles">
            <div class="font-advanced-options">
                <input class="colorhold" type="checkbox" value="color: #000000" style="display: none !important;" data-item="color" />
                <input class="sizehold" type="checkbox" value="font-size: 18px" style="display: none !important;" data-item="font-size" />
                <input class="heighthold" type="checkbox" value="line-height: 20px" style="display: none !important;" data-item="line-height" />
                <div class="checkboxy colorpick"><input type="text" value="#bada55" class="font-color" /></div>
                <div class="checkboxy option"><input type="checkbox" value="font-wieght: bold" data-item="font-wieght" /> bold</div>
                <div class="checkboxy option"><input type="checkbox" value="font-style: italic" data-item="font-style" /> italic</div>
                <div class="checkboxy option"><input type="checkbox" value="font-variant: small-caps" data-item="font-variant" /> small-caps</div>
                <div class="checkboxy option"><input type="checkbox" value="text-transform: uppercase" data-item="text-transform" /> uppercase</div>
                <div class="checkboxy option spinbox">font-size: <span id="fontsize-li_select_extend" data-name="fontsize"><input type="text" name="number" class="fontsize" value="0" /></span>px</div>
                <div class="checkboxy option spinbox">line-height: <span id="lineheight-li_select_extend" data-name="lineheight"><input type="text" class="lineheight" name="number" value="0" /></span>px</div>
            </div>
            <div class="clear"></div>
        </li>
    </ul>
</div>
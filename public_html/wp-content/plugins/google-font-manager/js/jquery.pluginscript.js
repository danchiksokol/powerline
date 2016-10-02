/**
 * @author Thomas S. Butler
 * @link http://butlerconsulting.com
 * @copyright 2013-2014 All Rights Reserved. Google Font Manager - A WordPress Plugin.
 * @abstract: This file contains the jQuery and JavaScript functions for the plugin.
 */
var ajaxLoading = false; 
//submit notifications
function notifyuser(msg) {
	jQuery("#notification").empty();
	jQuery("#notification").html(msg);
	jQuery("#notification").fadeIn('slow');
	var timerId = setTimeout(function() { 
        jQuery("#notification").fadeOut('slow'); 
    }, 3500);
};
//default ajax function
function go_ajax(callpage,callback) {
    var ajaxisLoading = false;
    if(!ajaxisLoading) {
        ajaxisLoading = true;
        jQuery.ajax( {
          url: callpage,
          success: function(responseText) {
                jQuery("#"+callback).html(responseText);
                //jQuery("#"+callback).find("script").each(function(i) {
                    //eval(jQuery(this).text());
                //});
                ajaxisLoading = false;
            }
        });
    }
}
//tipsy tip roller
// tipsy, facebook style tooltips for jquery
// version 1.0.0a
// (c) 2008-2010 jason frame [jason@onehackoranother.com]
// releated under the MIT license
(function($) {
    $.fn.tipsy = function(options) {
        options = $.extend({}, $.fn.tipsy.defaults, options);
        return this.each(function() {
            var opts = $.fn.tipsy.elementOptions(this, options);
            $(this).hover(function() {
                $.data(this, 'cancel.tipsy', true);
                var tip = $.data(this, 'active.tipsy');
                if (!tip) {
                    tip = $('<div class="tipsy"><div class="tipsy-inner"/></div>');
                    tip.css({position: 'absolute', zIndex: 100000});
                    $.data(this, 'active.tipsy', tip);
                }
                if ($(this).attr('title') || typeof($(this).attr('original-title')) != 'string') {
                    $(this).attr('original-title', $(this).attr('title') || '').removeAttr('title');
                }
                var title;
                if (typeof opts.title == 'string') {
                    title = $(this).attr(opts.title == 'title' ? 'original-title' : opts.title);
                } else if (typeof opts.title == 'function') {
                    title = opts.title.call(this);
                }
                tip.find('.tipsy-inner')[opts.html ? 'html' : 'text'](title || opts.fallback);
                var pos = $.extend({}, $(this).offset(), {width: this.offsetWidth, height: this.offsetHeight});
                tip.get(0).className = 'tipsy'; // reset classname in case of dynamic gravity
                tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).appendTo(document.body);
                var actualWidth = tip[0].offsetWidth, actualHeight = tip[0].offsetHeight;
                var gravity = (typeof opts.gravity == 'function') ? opts.gravity.call(this) : opts.gravity;
                switch (gravity.charAt(0)) {
                    case 'n':
                        tip.css({top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-north');
                        break;
                    case 's':
                        tip.css({top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-south');
                        break;
                    case 'e':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}).addClass('tipsy-east');
                        break;
                    case 'w':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}).addClass('tipsy-west');
                        break;
                }
                if (opts.fade) {
                    tip.css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: 0.8});
                } else {
                    tip.css({visibility: 'visible'});
                }
            }, function() {
                $.data(this, 'cancel.tipsy', false);
                var self = this;
                setTimeout(function() {
                    if ($.data(this, 'cancel.tipsy')) return;
                    var tip = $.data(self, 'active.tipsy');
                    if(tip) {
                        if(opts.fade) {
                            tip.stop().fadeOut(function() { $(this).remove(); });
                        } else {
                            tip.remove();
                        }
                    }
                }, 100);
            });          
        });   
    };
    // Overwrite this method to provide options on a per-element basis.
    // For example, you could store the gravity in a 'tipsy-gravity' attribute:
    // return $.extend({}, options, {gravity: $(ele).attr('tipsy-gravity') || 'n' });
    // (remember - do not modify 'options' in place!)
    $.fn.tipsy.elementOptions = function(ele, options) {
        return $.metadata ? $.extend({}, options, $(ele).metadata()) : options;
    };
    $.fn.tipsy.defaults = {
        fade: false,
        fallback: '',
        gravity: 'n',
        html: false,
        title: 'title'
    };
    $.fn.tipsy.autoNS = function() {
        return $(this).offset().top > ($(document).scrollTop() + $(window).height() / 2) ? 's' : 'n';
    };
    $.fn.tipsy.autoWE = function() {
        return $(this).offset().left > ($(document).scrollLeft() + $(window).width() / 2) ? 'e' : 'w';
    };
})(jQuery);
//rusure actions
function handleRUsure(action){
    if(action == "nukeIT") { 
        var data = { action: 'wp_googlefontmgr_killfonts', font: "Open Sans", remove: "all" };
    	jQuery.post(ajaxurl, data, function(response) {
    		jQuery("#response-div").html(response);
    	});
    }
    if(action == "updateStyle") { setTheStylesheet(); }
    jQuery("#confirmation").fadeOut("fast");
    jQuery("#notice-overlay").fadeOut("slow");
    jQuery("#confirmation").html("");
    jQuery("#popwarning p").html("");
    jQuery("#rusureok p").html(""); 
} 
//cancel warnings box
function cancelme(){
    jQuery("#confirmation").removeClass("about");
    jQuery("#confirmation").fadeOut("fast");
    jQuery("#notice-overlay").fadeOut("slow");
    jQuery("#confirmation").html("");
    jQuery("#popwarning p").html("");
    jQuery("#rusureok p").html(""); 
}
//update style sheet function
function setTheStylesheet(){
    var styleitems = "";
    if(jQuery("#enable_important .jquery-switch-on").length == 0) { important = ""; } else { important = " !important"; }
    jQuery("#setfont_styles li select").each(function(){
        var currid = jQuery(this).attr("id");
        var htmlelem = currid.replace("_select", "");
        if(jQuery(this).val() != "default"){
            if(htmlelem == "li"){ htmlelem = "ul li, ol li"; }
            var optionslist = htmlelem + '{ ' +  jQuery(this).val() + important + ";";
            var optcontianer = "#" + currid + "_extend";
            //get checked option values
            jQuery(optcontianer + " :checkbox:checked").each(function(){
                if(jQuery(this).val() != "undefined"){
                    optionslist = optionslist + " " + jQuery(this).val() + important + ";";
                }
            });
            optionslist = optionslist + " }";
            //set the final style sheet
            styleitems = styleitems + optionslist;
        }
    });
    var data = { action: 'wp_googlefontmgr_setstyle', stylesheet: styleitems };
	jQuery.post(ajaxurl, data, function(response) {
		jQuery("#elementdtata").html(response);
	});
}
//update style warning
function updateStyleWarn(){
    jQuery("#rusureok #confirm").attr("data-action", "updateStyle");
    jQuery("#rusureok p").html("You have made changes to your style sheet but you have not updated it? <strong>Would you like to update it now?</strong>");
    jQuery("#confirmation").html(jQuery("#rusureok").html());
    jQuery("#notice-overlay").fadeIn("slow");
    jQuery("#confirmation").fadeIn("slow");
    jQuery("#confirm").focus();
    return false;
}
//convert RGB colors to hex
var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 
function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    if(rgb === null) { return hex(FFFFFF); } else {
    return hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]); }
}
function hex(x) {
  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}
//check for numeric value
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
//populate font dropdowns
function setCurrentStyles() {
    //clone font options to form
    jQuery("#setfont_styles li select option[value!='default'], li.extended-styles.cloneme .font-advanced-options").remove();
    jQuery("#font_select_holder option").clone().appendTo("#setfont_styles li select");  
    //set form values based on current style
    jQuery("#setfont_styles li select").each(function(){
        var currid = jQuery(this).attr("id");
        var htmlelem = currid.replace("_select", "");
            //get and set font family
            var curfont = jQuery("#testpage").contents().find(htmlelem).css("font-family");
            var curfont = curfont.replace(/'/g, "");
            var curfont = curfont.replace(/"/g, "");
            var curfont = "'" + curfont + "'";
            jQuery("#"+currid).val("font-family:"+curfont);
            var optcontianer = "#" + currid + "_extend";
            //get checked option values
            jQuery(optcontianer + " :checkbox").each(function(){
                var dataitem = jQuery(this).attr("data-item");
                var curoption = jQuery("#testpage").contents().find(htmlelem).css(dataitem);
                var optionStr = dataitem + ": " + curoption;
                var optionsID = "#" + currid + "_extend";
                if(dataitem == "color"){
                    //if option is rgb value convert to hex
                    if(curoption && curoption.indexOf("rgb") >= 0) { curoption = "#" + rgb2hex(curoption); }
                    jQuery(optionsID + " a.wp-color-result").css("background-color",curoption);
                    jQuery(optionsID + " input.font-color.wp-color-picker").val(curoption);
                    jQuery(optionsID + " input.colorhold").val("color: " + curoption);
                } 
                if(dataitem == "font-size"){
                    if(curoption && curoption.indexOf("em") != 1) {
                        var curoption = curoption.replace("px", "");
                        if(isNumeric(curoption)) { 
                            var curoption = Math.round(curoption);
                            jQuery(optionsID).find("input.sizehold").val("font-size: " + curoption + "px");
                            jQuery(optionsID).find("input.fontsize").val(curoption);
                        }
                    }
                }
                if(dataitem == "line-height"){
                    if(curoption && curoption.indexOf("em") != 1) {
                        var curoption = curoption.replace("px", "");
                        if(isNumeric(curoption)) { 
                            var curoption = Math.round(curoption); 
                            jQuery(optionsID).find("input.heighthold").val("line-height: " + curoption + "px");
                            jQuery(optionsID).find("input.lineheight").val(curoption);
                        }
                    }
                }
                if(jQuery(this).val() == optionStr) {
                    jQuery(this).prop('checked', true);
                } else {
                    jQuery(this).prop('checked', false);
                }
                //alert(currid + " checking element: " + htmlelem + " for value: " + dataitem + " with result: " + curoption);
                //optionslist = optionslist + " " + jQuery(this).val() + important + ";";
            });
    });
    
    //update clone id for spinboxes
    jQuery(".checkboxy.option.spinbox").each(function(){
        var thisid= jQuery(this).find("span").attr("data-name") + "-" + jQuery(this).parent().closest("li").attr("id");
        if(!jQuery(thisid).hasClass("spinBox")) {
            var spinbox = new SpinBox(document.getElementById(thisid), {minimum: 10, maximum: 120});
        }
        jQuery(".spinBox span").removeAttr("id");
        //alert(thisid);
    });
    resetEmptyDropdowns();    
} 
//reset empty font selectors
function resetEmptyDropdowns(){
    jQuery("#setfont_styles li select").each(function(){
        if(!jQuery(this).val()) { jQuery(this).val("default"); }
    });
}
//manually close view panel
//font viewer slide function
function closePanel() {
    jQuery("#viewertab").parent().animate({right:'-720px'}, {queue: false, duration: 800});
    jQuery("#viewertab").parent().removeClass("open");
}
//general jQuery scripts
jQuery(document).ready(function(){
    //hover text for element options
    jQuery(".additem-button, .editor-button").hover(function() {
        var hovertext = jQuery(this).attr("data-ref");
        if(jQuery(this).hasClass("disabled")) { jQuery("#descriptor").addClass("disabled"); }
        jQuery("#descriptor").text("(" + hovertext + ")");
    }, function() {
        jQuery("#descriptor").text("");
        jQuery("#descriptor").removeClass("disabled"); 
    });
    //editbar persistence
    jQuery(".editor-button, .mainbar-button").live("click", function() {
        var newimg = jQuery(this).attr("data-img");
        var curimg = jQuery("#" + jQuery(this).attr("id") + " img").attr("src");
        if(jQuery(this).hasClass("persist") && !jQuery(this).hasClass("active")) { 
            jQuery(this).addClass("active"); 
        } else {
            jQuery(this).removeClass("active");
        }
        //image swap if exists
        if(newimg){
            jQuery(this).attr("data-img", curimg);
            jQuery("#" + jQuery(this).attr("id") + " img").attr("src", newimg);
        }
    });
    //font tabs functions
    jQuery("#fonts_container").on("click", ".fonttabs", function(){
        jQuery(".mainbar-button").removeClass("active");
        jQuery(".fonttabs, .tabsbox").removeClass("selected");
        jQuery(jQuery(this).attr("data-tab")).addClass("selected");
        //handle default style selection
        if(jQuery(this).attr("id") == "default_styles_tab"){
            if(jQuery("#google_font_stylechange").val() == 0) { setCurrentStyles(); }
            jQuery("#mainbar_apply").addClass("active");
            jQuery("#wp_googlefontmgr_settings, #wp_googlefontmgr_helpfiles").hide();
            jQuery("#wp_googlefontmgr_options").fadeIn("slow");
        } else {
            jQuery("#mainbar_apply").removeClass("active");
        } 
        //handle documentation selection
        if(jQuery(this).attr("id") == "documentation_tab"){
            jQuery("#mainbar_help").addClass("active");
            jQuery("#wp_googlefontmgr_settings, #wp_googlefontmgr_options").hide();
            jQuery("#wp_googlefontmgr_helpfiles").fadeIn("slow");
            
        } else {
            jQuery("#mainbar_help").removeClass("active");
            jQuery("#wp_googlefontmgr_settings, #wp_googlefontmgr_helpfiles").hide();
            jQuery("#wp_googlefontmgr_options").fadeIn("slow");
        }   
        jQuery(this).addClass("selected");
    });
    //tipsy for image rollovers
    jQuery('#viewertab').tipsy({gravity: 'e', fade: true});
    jQuery('.mainbar-button, .advancefont').tipsy({gravity: 's', fade: true});
    //stop labels from being clicked on
    jQuery("div.iosconrols label").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        return false;
    });
    //ios style button controls
    jQuery(".iosconrols .ios-switch input").radiobutton({
		className: "jquery-switch",
		checkedClass: "jquery-switch-on"
	});
    //handle setting onclick
    jQuery("#mainbar_settings").on("click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        if(jQuery("#wp_googlefontmgr_settings").is(":visible")){
            jQuery("#wp_googlefontmgr_settings, #wp_googlefontmgr_helpfiles, #div.updated").hide(); 
            jQuery("#wp_googlefontmgr_options").fadeIn();
            jQuery("#mainbar_settings").removeClass("active");
        } else {
            jQuery(".mainbar-button").removeClass("active");
            jQuery("#wp_googlefontmgr_options, #wp_googlefontmgr_helpfiles").hide(); 
            jQuery("#wp_googlefontmgr_settings").fadeIn();
            jQuery("#mainbar_settings").addClass("active");
            jQuery(".fonttabs, .tabsbox").removeClass("selected");
            jQuery("#selected_fonts_tab, #selector_tab").addClass("selected"); 
        }
    });
    //font viewer slide function
    jQuery("#viewertab").on("click", function() {
        if(jQuery(this).parent().hasClass("open")){
            jQuery(this).parent().animate({right:'-720px'}, {queue: false, duration: 800});
            jQuery(this).parent().removeClass("open");
        } else {
            jQuery(this).parent().animate({right:'-65px'}, {queue: false, duration: 800});
            jQuery(this).parent().addClass("open");
        }
    });
    //handle the nuke option
    jQuery("#mainbar_nukeit").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        if(jQuery(this).hasClass("disabled")){
            return false;
        } else {
            jQuery("#rusureok #confirm").attr("data-action", "nukeIT");
            jQuery("#rusureok p").html("Are you sure you want to remove all of your current font selections? <strong>WARNING! This action cannot be undone.</strong>");
            jQuery("#confirmation").html(jQuery("#rusureok").html());
            jQuery("#notice-overlay").fadeIn("slow");
            jQuery("#confirmation").fadeIn("slow");
            jQuery("#confirm").focus();
        }
    });
    //font selector select box
    jQuery("#font_inspector_select").on("change", function(e){
        e.preventDefault();
        e.stopPropagation();
        jQuery("#elementdtata").html(jQuery("#loaddata").html());
        if(jQuery(this).val()){
            var data = { action: 'wp_googlefontmgr_inspector', font: jQuery(this).val() };
        	jQuery.post(ajaxurl, data, function(response) {
        		jQuery("#elementdtata").html(response);
        	});
        } else {
            jQuery("#elementdtata").empty();
        }
    });
    //handle option toggles
    jQuery(".ios-switch").on("click", function(e){
        e.stopPropagation();
        var data = { action: 'wp_googlefontmgr_setoptions', element: jQuery(this).attr("id"), val: jQuery(this).find("input").val() };
    	jQuery.post(ajaxurl, data, function(response) {
    		jQuery("#response-div").html(response);
    	});
    });
    //handle default style selector
    jQuery("#mainbar_apply").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        if(jQuery(this).hasClass("disabled")){
            return false;
        } else {
            jQuery(".mainbar-button").removeClass("active");
            if(jQuery("#default_styles_tab").hasClass("selected")){
                jQuery(this).removeClass("active");
                jQuery(".fonttabs, .tabsbox").removeClass("selected");
                jQuery("#default_styles_tab, #styles_tab").removeClass("selected"); 
                jQuery("#selected_fonts_tab, #selector_tab").addClass("selected"); 
                jQuery("#wp_googlefontmgr_helpfiles, #wp_googlefontmgr_settings").hide();
                jQuery("#wp_googlefontmgr_options").fadeIn("slow");
            } else {
                jQuery(this).addClass("active");
                jQuery(".fonttabs, .tabsbox").removeClass("selected");
                jQuery("#default_styles_tab, #styles_tab").addClass("selected"); 
                jQuery("#wp_googlefontmgr_helpfiles, #wp_googlefontmgr_settings").hide();
                jQuery("#wp_googlefontmgr_options").fadeIn("slow");
            }
            if(jQuery("#google_font_stylechange").val() == 0) { setCurrentStyles(); }
        }
    });
    //handle documentation selector
    jQuery("#mainbar_help").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        jQuery(".mainbar-button").removeClass("active");
        if(jQuery("#documentation_tab").hasClass("selected")){
            jQuery(this).removeClass("active");
            jQuery(".fonttabs, .tabsbox").removeClass("selected");
            jQuery("#documentation_tab, #styles_tab").removeClass("selected"); 
            jQuery("#selected_fonts_tab, #selector_tab").addClass("selected"); 
            jQuery("#wp_googlefontmgr_settings, #wp_googlefontmgr_helpfiles").hide();
            jQuery("#wp_googlefontmgr_options").fadeIn("slow");
        } else {
            jQuery(this).addClass("active");
            jQuery(".fonttabs, .tabsbox").removeClass("selected");
            jQuery("#documentation_tab, #docs_tab").addClass("selected"); 
            jQuery("#wp_googlefontmgr_settings, #wp_googlefontmgr_options").hide();
            jQuery("#wp_googlefontmgr_helpfiles").fadeIn("slow");
        }
    });
    //handle about us window
    jQuery("#mainbar_info").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        jQuery("#confirmation").html(jQuery("#aboutus").html());
        jQuery("#confirmation").addClass("about");
        jQuery("#notice-overlay").fadeIn("slow");
        jQuery("#confirmation").fadeIn("slow");
        jQuery("#confirm").focus();
    });
    //toggle advaced font options
    jQuery(".advancefont").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        if(!jQuery(this).hasClass("disabled")){     
            if(jQuery(this).parent().next("li.extended-styles").hasClass("open")){
                jQuery(this).parent().next("li.extended-styles").removeClass("open");
                jQuery(this).parent("li").removeAttr("style");
                jQuery(this).removeClass("open");
            } else {
                jQuery(this).parent().next("li.extended-styles").addClass("open");
                jQuery(this).parent("li").css("background","rgba(0,0,0,0.05)");
                jQuery(this).addClass("open");
            }
        } else {
            return false;
        }
    });
    //set up the color picker
    var myOptions = { hide: true, palettes: true };
    jQuery(".font-color").wpColorPicker(myOptions);
    //handle color changes
    jQuery(".wp-color-result, .wp-picker-default").on("click", function() {
        //find and set variables
        var colorchange = false;
        var parentid = "#" + jQuery(this).parent().closest("li").attr("id");
        var curcolor = jQuery(this).parent().find("input.font-color.wp-color-picker").val();
        var curelem = "#" + jQuery(parentid).prev("li").find("select").attr("id");
        //check if values changed
        if(jQuery(parentid).find("input.colorhold").val() !== "color: " + curcolor) {
            jQuery(parentid).find("input.colorhold").val("color: " + curcolor); 
            jQuery(parentid).find("input.colorhold").attr("checked","checked");
            colorchange = true;
        } 
        //if changed update the elements
        if(jQuery(curelem).val() != "default" && colorchange) { 
            jQuery("#google_font_stylechange").val(1); 
            jQuery("#google_font_updatestyle").fadeIn("slow"); 
        }
    });
    //handle fontsize changes
    jQuery(".checkboxy.option.spinbox input").on("change", function() {
        //find and set variables
        var fontchange = false;
        var parentid = "#" + jQuery(this).parent().closest("li").attr("id");
        var curelem = "#" + jQuery(parentid).prev("li").find("select").attr("id");
        //check if values changed
        if(jQuery(this).hasClass("fontsize")) {
            var cursize = jQuery(this).parent().find("input.fontsize").val();
            if(jQuery(parentid).find("input.sizehold").val() !== "font-size: " + cursize + "px") {
                jQuery(parentid).find("input.sizehold").val("font-size: " + cursize + "px"); 
                jQuery(parentid).find("input.sizehold").attr("checked","checked");
                fontchange = true;
            } 
        }
        if(jQuery(this).hasClass("lineheight")) {
            var cursize = jQuery(this).parent().find("input.lineheight").val();
            if(jQuery(parentid).find("input.heighthold").val() !== "line-height: " + cursize + "px") {
                jQuery(parentid).find("input.heighthold").val("line-height: " + cursize + "px"); 
                jQuery(parentid).find("input.heighthold").attr("checked","checked");
                fontchange = true;
            } 
        }
        //if changed update the elements
        if(jQuery(curelem).val() != "default" && fontchange) { 
            jQuery("#google_font_stylechange").val(1); 
            jQuery("#google_font_updatestyle").fadeIn("slow"); 
        }
    });
    //handle style font select
    jQuery("#setfont_styles select").on("change", function() {
        jQuery("#google_font_stylechange").val(1); 
        jQuery("#google_font_updatestyle").fadeIn("slow"); 
    });
    //handle style checkboxes
    jQuery(".extended-styles input[type=checkbox]").on("change", function() {
        var parentid = "#" + jQuery(this).parent().closest("li").attr("id");
        var curcolor = jQuery(this).parent().find("input.font-color.wp-color-picker").val();
        var curelem = "#" + jQuery(parentid).prev("li").find("select").attr("id");
        if(jQuery(curelem).val() != "default") { 
            jQuery("#google_font_stylechange").val(1); 
            jQuery("#google_font_updatestyle").fadeIn("slow"); 
        }
    });
    //clear font finder and inspector value
    jQuery("#fontfinder, #font_inspector_select").val("");
    //set default style update params
    jQuery("#google_font_stylechange").val(0); 
    jQuery("#google_font_updatestyle").hide();
    //bind window unload for warning
    jQuery(window).bind("beforeunload", function(){
        if(jQuery("#google_font_stylechange").val() == 1) {
            return updateStyleWarn();
        }
    });
    //on load, fade in content
    var timerId = setTimeout(function () { jQuery("#poststuff").fadeIn(); }, 750);
});
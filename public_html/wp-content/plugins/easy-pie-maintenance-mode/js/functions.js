/*
  EZP Maintenance Mode Plugin
  Copyright (C) 2016, Snap Creek LLC
  website: snapcreek.com contact: support@snapcreek.com

  EZP Maintenance Mode Plugin is distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA
  
  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

easyPieMMResizeSlides = function() {
    jQuery("#easy-pie-mm-bxslider-pager").parent().css("height", "77px");
};

easyPie = { };
easyPie.MM = { };

easyPie.MM.toggleAdvancedBox  = function() {
    
    jQuery('#easy-pie-mm-advanced').toggle();
    easyPie.MM.setCookie("advancedDisplay", jQuery("#easy-pie-mm-advanced").css("display"));
}

easyPie.MM.setCookie = function setCookie(c_name, value, exdays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

easyPie.MM.getCookie = function(c_name)
{
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1)
    {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1)
    {
        c_value = null;
    }
    else
    {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1)
        {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}
    

jQuery(document).ready(function($) {
    $("#theme-section img").css({"display":"block"});        
    
    var displayIndex = $("#easy-pie-mm-theme").attr("displayIndex");
                
    var easyPieMMScrubSlides  = function() {
                       
        var displayIndex = $("#easy-pie-mm-theme").attr("displayIndex");   
        
        //   $("#easy-pie-mm-bxslider-pager img").css("border-right", "1px solid #CCC").css("border-left", "1px solid #CCC").css("margin-top", "-10px").css("margin-left", "-2px");
        
        
        $("#easy-pie-mm-bxslider-pager img").each(function(key,value){
            
            var idx = $(this).attr("idx");
              
            if(displayIndex != idx) {
           
                $(this).parent().css({
                    opacity: 0.4 
                });   
            }
            else {
                $(this).parent().css({
                    opacity: 1.0
                });   
            }
        });
    };
    
    var slider = $('#easy-pie-mm-bxslider').bxSlider(
    {
        captions: true,
        controls: false,
        pagerCustom: "#easy-pie-mm-bxpager",
        slideWidth: 550,
        startSlide: displayIndex       
    });
    
    $('#easy-pie-mm-bxslider-pager').bxSlider(
    {
        controls: true,
        
        infiniteLoop: true,
        maxSlides: 4,
        moveSlides: 1,        
        pager: false,        
        slideMargin: 17,
        slideWidth: 125,
        startSlide: displayIndex,
        
        onSlideNext: easyPieMMScrubSlides,
        onSlidePrev: easyPieMMScrubSlides
    });
    
    

    easyPieMMScrubSlides();   
    
    $("#easy-pie-mm-bxslider-pager").on("click", "img", function(e) {

        e.preventDefault();        
        var idx = $(this).attr("idx");        
        
        $("#easy-pie-mm-theme").attr("displayIndex", idx);
        
        $(this).parent().siblings().css({
            opacity: 0.4
        });
        $(this).parent().fadeTo("slow", 1.0);
        
        slider.goToSlide(idx);
    });
    
    easyPieMMResizeSlides();
    
    
    
    // New Media uploader logic
    var custom_uploader;
 
    $('#easy-pie-mm-upload-logo-button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#easy-pie-mm-field-logo').val(attachment.url);
            $('#easy-pie-mm-field-logo-preview').css("display", "block");
            $('#easy-pie-mm-field-logo-preview').attr("src", attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();                
    });
    
    var advancedDisplay = easyPie.MM.getCookie("advancedDisplay");
            
    if(advancedDisplay != null) {
            
        $("#easy-pie-mm-advanced").css("display", advancedDisplay);
    }     
});

jQuery( window ).resize(function() {    
    easyPieMMResizeSlides();
});


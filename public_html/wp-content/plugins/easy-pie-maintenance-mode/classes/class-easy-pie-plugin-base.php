<?php

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

if (!class_exists('Easy_Pie_Plugin_Base')) {
    
    /**
     * Base class of EZP plugins
     *
     * @author Snap Creek Software <support@snapcreek.com>
     * @copyright 2013 Synthetic Thought LLC
     */
    class Easy_Pie_Plugin_Base {

        protected $plugin_slug;
        
        function __construct($plugin_slug) {
            
            $this->plugin_slug = $plugin_slug;
        }
        //Use WordPress Debugging log file. file is written to wp-content/debug.log
        //trace with tail command to see real-time issues.
        function debug($message) {

            if (WP_DEBUG === true) {
                if (is_array($message) || is_object($message)) {
                    error_log($this->plugin_slug . ":" . print_r($message, true));
                } else {
                    error_log($this->plugin_slug . ":" . $message);
                }
            }
        }
        
        function _e($text) {
            
            _e($text, $this->plugin_slug);
        }
        
        function __($text) {
            
            return __($text, $this->plugin_slug);
        }        
    }
}
?>
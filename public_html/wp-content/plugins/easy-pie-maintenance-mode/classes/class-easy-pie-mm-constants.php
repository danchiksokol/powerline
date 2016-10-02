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

if (!class_exists('Easy_Pie_MM_Constants')) {

    /**
     * Constants for EZP Maintenance Mode Plugin
     *
     * @author Snap Creek Software <support@snapcreek.com>
     * @copyright 2013 Synthetic Thought LLC
     */
    class Easy_Pie_MM_Constants 
	{
        //const OPTIONS_GROUP_NAME = 'easy-pie-mm-options-group';

        const OPTION_NAME = 'easy-pie-mm-options';
        const MAIN_PAGE_KEY = 'easy-pie-mm-main-page';
        const PLUGIN_SLUG = 'easy-pie-maintenance-mode';
        const PLUGIN_VERSION = "1.0.0"; // RSR Version

        /* Pseudo constants */

        public static $PLUGIN_DIR;

        public static function init() {

            $__dir__ = dirname(__FILE__);
            
            self::$PLUGIN_DIR = $__dir__ . "../" . self::PLUGIN_SLUG;
        }

    }

    Easy_Pie_MM_Constants::init();
}
?>
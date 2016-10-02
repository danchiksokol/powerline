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

require_once("class-easy-pie-mm-constants.php");

if (!class_exists('Easy_Pie_MM_Utility')) {

    /**
     * Utility methods for EZP Maintenance Mode Plugin
     *
     * @author Snap Creek Software <support@snapcreek.com>
     * @copyright 2013 Synthetic Thought LLC
     */
    class Easy_Pie_MM_Utility {

        // Pseudo-constants
        public static $MINI_THEMES_USER_DIRECTORY;
        public static $MINI_THEMES_STANDARD_DIRECTORY;
        public static $MINI_THEMES_USER_URL;
        public static $MINI_THEMES_STANDARD_URL;
        public static $MINI_THEMES_IMAGES_URL;

        public static function init() {

            $__dir__ = dirname(__FILE__);

            self::$MINI_THEMES_STANDARD_DIRECTORY = $__dir__ . "/../mini-themes/";
            self::$MINI_THEMES_USER_DIRECTORY = (WP_CONTENT_DIR . "/" . Easy_Pie_MM_Constants::PLUGIN_SLUG . "/mini-themes/");

            self::$MINI_THEMES_STANDARD_URL = plugins_url() . "/" . Easy_Pie_MM_Constants::PLUGIN_SLUG . "/mini-themes/";
            self::$MINI_THEMES_USER_URL = content_url() . "/" . Easy_Pie_MM_Constants::PLUGIN_SLUG . "/mini-themes/";

            self::$MINI_THEMES_IMAGES_URL = plugins_url() . "/" . Easy_Pie_MM_Constants::PLUGIN_SLUG . "/images/";
        }

        public static function _e($text) {

            _e($text, Easy_Pie_MM_Constants::PLUGIN_SLUG);
        }

        public static function __($text) {

            return __($text, Easy_Pie_MM_Constants::PLUGIN_SLUG);
        }

        public static function get_manifest_by_key($key) {

            $manifests = self::get_manifests();

            foreach ($manifests as $manifest) {

                if ($manifest->key == $key) {

                    return $manifest;
                }
            }

            return null;
        }

        public static function get_manifests() {

            $user_manifest_array = self::get_manifests_in_directory(self::$MINI_THEMES_USER_DIRECTORY, self::$MINI_THEMES_USER_URL);
            $standard_manifest_array = self::get_manifests_in_directory(self::$MINI_THEMES_STANDARD_DIRECTORY, self::$MINI_THEMES_STANDARD_URL);

            $combined_manifest_array = &$user_manifest_array;

            // stuff in user manifest array can override standard manifests
            foreach ($standard_manifest_array as $sman) {

                $contains = false;

                foreach ($combined_manifest_array as $man) {

                    if ($sman->key == $man->key) {
                        $contains = true;
                        break;
                    }
                }

                if (!$contains) {
                    array_push($combined_manifest_array, $sman);
                }
            }
            return $combined_manifest_array;
        }

        public static function get_manifests_in_directory($directory, $mini_theme_base_url) {

            $manifest_array = array();
            $dirs = glob($directory . "*", GLOB_ONLYDIR);

            if ($dirs != FALSE) {

                sort($dirs);

                foreach ($dirs as $dir) {

                    $manifest = null;
                    $manifest_path = $dir . "/manifest.json";

                    if (file_exists($manifest_path)) {

                        $manifest_text = file_get_contents($manifest_path);

                        if ($manifest_text != false) {

                            $manifest = json_decode($manifest_text);
                        } else {

                            self::debug(self::__("problem reading manifest in ") . $dir . "(" . $dirs . ")");
                        }
                    } else {

                        // Manifest not present so assumption is they just want a generic mini-theme
                        $manifest = new stdClass();

                        self::add_property($manifest, 'title', basename($dir));
                        self::add_property($manifest, 'page', 'index.html');
                        self::add_property($manifest, 'description', 'User Mini Theme');
                        self::add_property($manifest, 'author_name', '');
                        self::add_property($manifest, 'website_url', '');
                        self::add_property($manifest, 'google_plus_author_url', '');
                        self::add_property($manifest, 'original_release_date', '2013/01/01');
                        self::add_property($manifest, 'latest_version_date', '2013/01/01');
                        self::add_property($manifest, 'version', '1.0.0');
                        self::add_property($manifest, 'release_notes', '');
                        self::add_property($manifest, 'screenshot', self::$MINI_THEMES_IMAGES_URL . "user-defined.png");
                        self::add_property($manifest, 'autodownload', false);
                        self::add_property($manifest, 'responsive', true);
                    }

                    if ($manifest != null) {

                        // RSR TODO: Have a way to give each item a unique key if it conflicts..?
                        self::add_property($manifest, 'key', basename($dir));
                        self::add_property($manifest, 'dir', $dir);
                        self::add_property($manifest, 'manifest_path', $manifest_path);
                        self::add_property($manifest, 'mini_theme_url', $mini_theme_base_url . $manifest->key);

                        array_push($manifest_array, $manifest);
                    }
                }
            }

            return $manifest_array;
        }

        private static function add_property(&$obj, $property, $value) {

            $obj = (array) $obj;
            $obj[$property] = $value;
            $obj = (object) $obj;
        }

        public static function debug($message) {

            if (WP_DEBUG === true) {
                if (is_array($message) || is_object($message)) {
                    error_log(Easy_Pie_MM_Constants::PLUGIN_SLUG . ":" . print_r($message, true));
                } else {
                    error_log(Easy_Pie_MM_Constants::PLUGIN_SLUG . ":" . $message);
                }
            }
        }

    }

    Easy_Pie_MM_Utility::init();
}
?>
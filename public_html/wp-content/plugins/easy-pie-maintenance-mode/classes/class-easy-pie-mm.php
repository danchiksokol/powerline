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

require_once("class-easy-pie-utility.php");
require_once("class-easy-pie-plugin-base.php");
require_once("class-easy-pie-mm-constants.php");
require_once("class-easy-pie-mm-utility.php");

if (!class_exists('Easy_Pie_MM')) {

    /**
     * Main class of EZP Maintenance Mode Plugin
     *
     * @author Snap Creek Software <support@snapcreek.com>
     * @copyright 2013 Synthetic Thought LLC
     */
    class Easy_Pie_MM extends Easy_Pie_Plugin_Base {

        // Variables        
        private $options;

        /**
         * Constructor
         */
        function __construct($plugin_file_path) {

            parent::__construct(Easy_Pie_MM_Constants::PLUGIN_SLUG);

            // Pseudo-constant intialization

            $this->add_class_action('plugins_loaded', 'plugins_loaded_handler');

            // RSR TODO - is_admin() just says if admin panel is attempting to be displayed - NOT to see if someone is an admin
            if (is_admin() == true) {

                if ($this->get_option_value("enabled") == true) {

                    $this->add_class_action("admin_notices", "display_admin_notice");
                }

                //- Hook Handlers
                register_activation_hook($plugin_file_path, array('Easy_Pie_MM', 'activate'));
                register_deactivation_hook($plugin_file_path, array('Easy_Pie_MM', 'deactivate'));
                register_uninstall_hook($plugin_file_path, array('Easy_Pie_MM', 'uninstall'));

                //- Actions
                $this->add_class_action('admin_init', 'admin_init_handler');
                $this->add_class_action('admin_menu', 'add_to_admin_menu');
            } else if ($this->get_option_value("enabled") == true) {

                $this->add_class_action('template_redirect', 'display_maintenance_page');
            }
        }

        function add_class_action($tag, $method_name) {

            return add_action($tag, array($this, $method_name));
        }

        public function display_admin_notice() {

            echo "<div class='updated'><a href='" . admin_url() . "options-general.php?page=" . Easy_Pie_MM_Constants::PLUGIN_SLUG . "'>" . $this->__("Maintenance Mode is On") . "</a></div>";
        }

        /**
         * Display the maintenance page
         */
        public function display_maintenance_page() {

            if ((!defined('EASY_PIE_MM_DISABLE') || (EASY_PIE_MM_DISABLE == false))) {

                // For now 
                if (!is_user_logged_in()) {

                    header('HTTP/1.1 503 Service Temporarily Unavailable');
                    header('Status: 503 Service Temporarily Unavailable');
                    header('Retry-After: 86400'); // RSR TODO: Put in the retry time later

                    $key = $this->get_option_value("page_template_key");
                    $active_manifest_path = $this->get_option_value("active_manifest_path");

                    if (($active_manifest_path == null) || (strpos($active_manifest_path, $key) == false)) {

                        // Manifest path doesn't match the key so update it
                        $manifest = Easy_Pie_MM_Utility::get_manifest_by_key($key);

                        if ($manifest != null) {

                            $active_manifest_path = $manifest->manifest_path;
                            Easy_Pie_Utility::set_option($this->options, 'active_manifest_path', $active_manifest_path);
                        } else {

                            $this->debug("Couldn't find manifest for key " . $key);
                        }
                    } else {

                        $manifest = Easy_Pie_MM_Utility::load_manifest($active_manifest_path);
                    }

                    // $filename = $manifest->dir . "/" . $manifest->page;

                    $contents = file_get_contents($manifest->dir . "/" . $manifest->page);
                    $contents = $this->replace_page_template_fields($contents, $manifest->mini_theme_url);

                    if ($contents != false) {

                        echo $contents;
                    } else {

                        $this->debug($this->__("Problem reading template ") . $key);
                    }

                    exit();
                }
            }
        }

        private function replace_page_template_fields($contents, $mini_theme_url) {

            // rsr todo replace value per http://stackoverflow.com/questions/7980741/efficient-way-to-replace-placeholders-with-variables
            $option_array = get_option(Easy_Pie_MM_Constants::OPTION_NAME);

            $headline = $option_array['headline'];
            $header = $option_array['header'];
            $message = $option_array['message'];
            $title = $option_array['title'];
            $logo_url = $option_array['logo_url'];
            $css = $option_array['css'];

            $values = array(
                '{{headline}}' => $headline,
                '{{header}}' => $header,
                '{{message}}' => $message,
                '{{title}}' => $title,
                '{{logo_url}}' => $logo_url,
                '{{css}}' => $css,
                './' => $mini_theme_url . "/"
            );

            return strtr($contents, $values);
        }

        // <editor-fold defaultstate="collapsed" desc="Hook Handlers">
        public static function activate() {

            Easy_Pie_MM_Utility::debug("activate");
        }

        public static function deactivate() {

            Easy_Pie_MM_Utility::debug("deactivate");
        }

        public static function uninstall() {

            Easy_Pie_MM_Utility::debug("uninstall");
        }

        // </editor-fold>

        public function enqueue_scripts() {

            $jsRoot = plugins_url() . "/" . Easy_Pie_MM_Constants::PLUGIN_SLUG . "/js";

            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery.bxslider', $jsRoot . "/jquery.bxslider.min.js", array("jquery"), Easy_Pie_MM_Constants::PLUGIN_VERSION);
            wp_enqueue_script("easy_pie_mm_functions", $jsRoot . "/functions.js", array("jquery", "jquery.bxslider"), Easy_Pie_MM_Constants::PLUGIN_VERSION);

            wp_enqueue_media();
        }

        /**
         *  enqueue_styles
         *  Loads the required css links only for this plugin  */
        public function enqueue_styles() {
            
            $styleRoot = plugins_url() . "/" . Easy_Pie_MM_Constants::PLUGIN_SLUG . "/styles";
            
            wp_register_style('jquery.bxslider.css', $styleRoot . '/jquery.bxslider.css', array(), Easy_Pie_MM_Constants::PLUGIN_VERSION);
            wp_enqueue_style('jquery.bxslider.css');

            wp_register_style('easy-pie-styles.css', $styleRoot . '/easy-pie-styles.css', array(), Easy_Pie_MM_Constants::PLUGIN_VERSION);
            wp_enqueue_style('easy-pie-styles.css');
        }

        // <editor-fold defaultstate="collapsed" desc=" Action Handlers ">
        public function plugins_loaded_handler() {

            $this->init_localization();
            $this->upgrade_processing();
            $this->init_options();
        }

        public function init_localization() {

            load_plugin_textdomain(Easy_Pie_MM_Constants::PLUGIN_SLUG, false, Easy_Pie_MM_Constants::PLUGIN_SLUG . '/languages/');
        }

        public function admin_init_handler() {

            register_setting(Easy_Pie_MM_Constants::MAIN_PAGE_KEY, Easy_Pie_MM_Constants::OPTION_NAME, array($this, 'validate_options'));

            $this->init_user_theme_directory();
            $this->add_settings_sections();
            $this->add_filters();
        }

        private function add_filters() {

            add_filter('plugin_action_links', array($this, 'get_action_links'), 10, 2);
        }

        function get_action_links($links, $file) {

            if ($file == "easy-pie-maintenance-mode/easy-pie-maintenance-mode.php") {

                $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=' . Easy_Pie_MM_Constants::PLUGIN_SLUG . '">Settings</a>';

                array_unshift($links, $settings_link);
            }

            return $links;
        }

        private function get_option_value($subkey) {

            $optionArray = get_option(Easy_Pie_MM_Constants::OPTION_NAME);

            return $optionArray[strtolower($subkey)];
        }

        private function init_user_theme_directory() {

            if (file_exists(Easy_Pie_MM_Utility::$MINI_THEMES_USER_DIRECTORY) == FALSE) {

                $dirCreate = mkdir(Easy_Pie_MM_Utility::$MINI_THEMES_USER_DIRECTORY, 0755, true);

                Easy_Pie_MM_Utility::debug(Easy_Pie_MM_Utility::__("Tried to create ") . Easy_Pie_MM_Utility::$MINI_THEMES_USER_DIRECTORY . "=" . $dirCreate);
            }
        }

        // <editor-fold defaultstate="collapsed" desc=" Settings Logic ">

        function upgrade_processing() {
            // RSR TODO: In future versions compare where we are at with what's in the system and take action            
        }

        function init_options() {

            $this->options = get_option(Easy_Pie_MM_Constants::OPTION_NAME);

            if ($this->options == false) {

                $this->options = array();
            }

            Easy_Pie_Utility::set_option($this->options, 'plugin_version', Easy_Pie_MM_Constants::PLUGIN_VERSION);

            Easy_Pie_Utility::set_default_option($this->options, 'enabled', false);
            Easy_Pie_Utility::set_default_option($this->options, 'page_template_key', "plain");
            Easy_Pie_Utility::set_default_option($this->options, 'title', null);
            Easy_Pie_Utility::set_default_option($this->options, 'header', null);
            Easy_Pie_Utility::set_default_option($this->options, 'headline', null);
            Easy_Pie_Utility::set_default_option($this->options, 'message', null);
            Easy_Pie_Utility::set_default_option($this->options, 'logo_url', null);
            Easy_Pie_Utility::set_default_option($this->options, 'active_manifest_path', null);
            Easy_Pie_Utility::set_default_option($this->options, 'css', null);

            update_option(Easy_Pie_MM_Constants::OPTION_NAME, $this->options);
        }

        public function add_settings_sections() {

            $section_id = 'easy-pie-mm-control-section';
            add_settings_section($section_id, 'Control', array($this, 'render_control_section'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY);
            add_settings_field('easy-pie-mm-mode-on', $this->__('Enabled'), array($this, 'render_checkbox_field'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY, $section_id, array('id' => 'easy-pie-mm-mode-on', 'subkey' => 'enabled'));

            $section_id = 'easy-pie-mm-theme-section';
            add_settings_section($section_id, $this->__('Visuals'), array($this, 'render_theme_section'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY);
            add_settings_field('easy-pie-mm-theme', $this->__('Mini-theme'), array($this, 'render_active_theme_selector'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY, $section_id, array('id' => 'easy-pie-mm-theme', 'subkey' => 'page_template_key'));

            $section_id = 'easy-pie-mm-template_fields-section';
            add_settings_section($section_id, $this->__('Fields'), array($this, 'render_template_fields_section'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY);
            add_settings_field('easy-pie-mm-field-title', $this->__('Title'), array($this, 'render_text_field'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY, $section_id, array('id' => 'easy-pie-mm-field-title', 'subkey' => 'title'));
            add_settings_field('easy-pie-mm-field-header', $this->__('Header'), array($this, 'render_text_field'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY, $section_id, array('id' => 'easy-pie-mm-field-header', 'subkey' => 'header'));
            add_settings_field('easy-pie-mm-field-headline', $this->__('Headline'), array($this, 'render_text_field'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY, $section_id, array('id' => 'easy-pie-mm-field-headline', 'subkey' => 'headline'));
            add_settings_field('easy-pie-mm-field-message', $this->__('Message'), array($this, 'render_text_area'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY, $section_id, array('id' => 'easy-pie-mm-field-message', 'subkey' => 'message', 'size' => 80));
            add_settings_field('easy-pie-mm-field-logo', $this->__('Logo'), array($this, 'render_logo_field'), Easy_Pie_MM_Constants::MAIN_PAGE_KEY, $section_id, array('id' => 'easy-pie-mm-field-logo', 'subkey' => 'logo_url'));
        }

        public function render_text_field($args) {
            $options = get_option(Easy_Pie_MM_Constants::OPTION_NAME);
            $subkey = $args['subkey'];
            $id = $args['id'];
            $optionExpression = Easy_Pie_MM_Constants::OPTION_NAME . "[" . $subkey . "]";
            $currentValue = $options[$subkey];
            $size = 66;

            if (array_key_exists('size', $args)) {
                $size = $args['size'];
            }
            ?>
            <div>
                <input id="<?php echo $id; ?>" name='<?php echo $optionExpression; ?>' size="<?php echo $size; ?>" value="<?php echo $currentValue; ?>"/>
            </div>            
            <?php
        }

        public function render_text_area($args) {
            $options = get_option(Easy_Pie_MM_Constants::OPTION_NAME);
            $subkey = $args['subkey'];
            $id = $args['id'];
            $optionExpression = Easy_Pie_MM_Constants::OPTION_NAME . "[" . $subkey . "]";
            $currentValue = $options[$subkey];
            ?>
            <div>
                <textarea cols="66" rows="5" id="<?php echo $id; ?>" name='<?php echo $optionExpression; ?>'><?php echo $currentValue; ?></textarea>
                <p><small><?php $this->_e("HTML tags are allowed. e.g. Add &lt;br/&gt; for break."); ?></small></p>
            </div>             
            <?php
        }

        // RSR: Why the hell do we need to set value to 1?
        public function render_checkbox_field($args) {
            $options = get_option(Easy_Pie_MM_Constants::OPTION_NAME);
            $subkey = $args['subkey'];
            $id = $args['id'];

            if (array_key_exists('small_text', $args)) {

                $small_text = $args['small_text'];
            }


            $optionExpression = Easy_Pie_MM_Constants::OPTION_NAME . "[" . $subkey . "]";
            $currentValue = $options[$subkey];

            $checkedText = checked(1, $options[$subkey], false);
            ?>
            <div>
                <input style="margin-right:5px;" value="1" id="<?php echo $id; ?>" type="checkbox" name="<?php echo $optionExpression; ?>" <?php echo $checkedText; ?> >Yes</input>
                <?php
                if (isset($small_text)) {
                    echo "<p><small>" . $small_text . "</small></p>";
                }
                ?>
            </div>            
            <?php
        }

        public function render_logo_field() {
            $options = get_option(Easy_Pie_MM_Constants::OPTION_NAME);
            $optionExpression = Easy_Pie_MM_Constants::OPTION_NAME . "[logo_url]";
            $currentValue = $options["logo_url"];
            ?>

            <div>
                <input id="easy-pie-mm-field-logo" type="text" name="<?php echo $optionExpression; ?>" size="58" value="<?php echo $currentValue; ?>" />
                <input id="easy-pie-mm-upload-logo-button" type="button" value="Upload" />

                <?php
                if (empty($currentValue)) {
                    $displayModifier = "display:none;";
                } else {
                    $displayModifier = "";
                }
                ?>

                <div >
                    <img id="easy-pie-mm-field-logo-preview" src="<?php echo $currentValue; ?>" style="<?php echo $displayModifier; ?>max-height:170px;max-width:170px;box-shadow: 1px 7px 20px -4px rgba(34,34,34,1);padding: 5px;border: black solid 1px;margin-top: 14px;"/>
                </div>                                                             
            </div>

            <?php
        }

        public function render_control_section() {
            //         echo 'TODO: Theme is used to change what is displayed. Blah blah blah..';
        }

        public function render_theme_section() {
            //       echo 'TODO: Theme is used to change what is displayed. Blah blah blah..';
            echo '<div id="theme-section">';
        }

        public function render_template_fields_section() {
            //       echo 'TODO: Theme is used to change what is displayed. Blah blah blah..';
            echo "</div>";
            echo '<small >' . $this->__("All fields are optional") . '</small>';
        }

        private function get_template_path($page_template_key) {


            $__dir__ = dirname(__FILE__);


            return $__dir__ . "../mini-themes/" . $page_template_key;
        }

        public function render_active_theme_selector($args) {

            $options = get_option(Easy_Pie_MM_Constants::OPTION_NAME);
            $subkey = $args['subkey'];
            $id = $args['id'];
            $optionExpression = Easy_Pie_MM_Constants::OPTION_NAME . "[" . $subkey . "]";
            $currentValue = $options[$subkey];
            ?>

            <ul id="easy-pie-mm-bxslider">

                <?php
                $displayIndex = 0;
                $startingIndex = 0;

                $manifests = Easy_Pie_MM_Utility::get_manifests();

                foreach ($manifests as $manifest) {
                    //  $slidePath = plugins_url("../mini-themes/" . $manifest->key . "/" . $manifest->screenshot, __FILE__);
                    $upper_screenshot = strtoupper($manifest->screenshot);

                    if ($manifest->author_name == '') {

                        $caption_text = $this->__('User Defined:') . $manifest->title;
                    } else {

                        $caption_text = $manifest->title . ' ' . $this->__('by') . " <a style='color:#DDD' target='_blank' href='" . $manifest->website_url . "'>" . $manifest->author_name . "</a>";
                    }


                    if (strpos($upper_screenshot, 'HTTP') === 0) {
                        // It's an absolute path
                        $slidePath = $manifest->screenshot;
                    } else {
                        // Relative path
                        $slidePath = $manifest->mini_theme_url . "/" . $manifest->screenshot;
                    }

                    if ($manifest->key == $currentValue) {
                        $startingIndex = $displayIndex;
                    }
                    ?>
                    <li>                                                
                        <img style="display:none" idx="<?php echo $displayIndex; ?>" src="<?php echo $slidePath ?>" title="<?php echo $caption_text; ?>" onclick="jQuery('#<?php echo $id; ?>').attr('value', '<?php echo $manifest->key; ?>');" />
                    </li>
                    <?php
                    $displayIndex++;
                }
                ?>
                <!--                ... (repeat for every image in the gallery)-->
            </ul>

            <!-- THUMBNAIL SLIDER -->
            <ul id="easy-pie-mm-bxslider-pager">

                <?php
                $displayIndex = 0;
                $startingIndex = 0;

                foreach ($manifests as $manifest) {

                    // $slidePath = $manifest->mini_theme_url . "/" . $manifest->screenshot;

                    $upper_screenshot = strtoupper($manifest->screenshot);

                    if (strpos($upper_screenshot, 'HTTP') === 0) {
                        // It's an absolute path
                        $slidePath = $manifest->screenshot;
                    } else {
                        // Relative path
                        $slidePath = $manifest->mini_theme_url . "/" . $manifest->screenshot;
                    }

                    if ($manifest->key == $currentValue) {
                        $startingIndex = $displayIndex;
                    }
                    ?>
                    <li>                                                
                        <img style="display:none" idx="<?php echo $displayIndex; ?>" src="<?php echo $slidePath ?>" onclick="jQuery('#<?php echo $id; ?>').attr('value', '<?php echo $manifest->key; ?>');" />
                    </li>
                    <?php
                    $displayIndex++;
                }
                ?>                
            </ul>

            <input displayIndex="<?php echo $startingIndex; ?>" style="visibility:hidden" id="<?php echo $id; ?>" name="<?php echo $optionExpression; ?>" value="<?php echo $currentValue; ?>"/>
            <?php
        }

        public function validate_options($raw_input_array) {

            // Create our array for storing the validated options  
            //$output = array();
            $output = get_option(Easy_Pie_MM_Constants::OPTION_NAME);

            $this->scrub_checkbox_value($raw_input_array, 'enabled');
            $this->scrub_checkbox_value($raw_input_array, '503_redirect');

            // Loop through each of the incoming options  
            foreach ($raw_input_array as $key => $value) {

                // Check to see if the current option has a value. If so, process it.  
                if (isset($raw_input_array[$key])) {

                    // Strip all HTML and PHP tags and properly handle quoted strings  
                    //$output[$key] = strip_tags(stripslashes($raw_input_array[$key]));
                    $output[$key] = $raw_input_array[$key];
                }
            }

            //  return apply_filters(Easy_Pie_MM_Constants::MAIN_PAGE_KEY, $output, $raw_input_array);
            return $output;
        }

        private function scrub_checkbox_value(&$array, $key) {

            if (!array_key_exists($key, $array)) {

                $array[$key] = false;
            }
        }

        // </editor-fold>

        public function add_to_admin_menu() {

            // RSR TODO: Localize main page title and menu entry
            //$page_hook_suffix = add_options_page("EZP Maintenance Mode", "Maintenance Mode", "manage_options", Easy_Pie_MM_Constants::MAIN_PAGE_KEY, array($this, 'display_options_page'));
            $page_hook_suffix = add_options_page("EZP Maintenance Mode", "Maintenance Mode", "manage_options", Easy_Pie_MM_Constants::PLUGIN_SLUG, array($this, 'display_options_page'));

            add_action('admin_print_scripts-' . $page_hook_suffix, array($this, 'enqueue_scripts'));

            //Apply Styles
            add_action('admin_print_styles-' . $page_hook_suffix, array($this, 'enqueue_styles'));
        }

        // </editor-fold>

        function display_options_page() {

            $__dir__ = dirname(__FILE__);

            include($__dir__ . '/../pages/page-options.php');
        }

    }

}
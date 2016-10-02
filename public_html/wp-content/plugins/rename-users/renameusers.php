<?php
/**
 * Plugin Name: Rename Users
 * Plugin URI: http://ifs-net.de
 * Description: Allow Admins to rename user login names
 * Version: 1.2
 * Author: Florian Schiessl
 * Author URI: http://ifs-net.de
 * License: A "Slug" license name e.g. GPL2
 * Text Domain: renameusers
 * Domain Path: /languages/
 */

// recreate pot file? excute this in the plugin's directory  
// xgettext --language=PHP --from-code=utf-8 --keyword=__ *.php -o languages/renameusers.pot

// Load translations and text domain
add_action('init', 'renameusers_load_textdomain');

function renameusers_load_textdomain() {
    load_plugin_textdomain('renameusers', false, dirname(plugin_basename(__FILE__)) . "/languages/");
}

// Add to admin's menu
add_action('admin_menu', 'renameusers_admin_add_page');

function renameusers_admin_add_page() {
    add_users_page(
            __('Rename Usernames', 'renameusers'), __('Rename Usernames', 'renameusers'), 'edit_users', 'renameusers', 'renameusers_options_page'
    );
}

/**
 * Display option page
 */
function renameusers_options_page() {
    $results = renameusers_load_user();

    if ($results === true)
        return;
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php esc_html_e('Rename Usernames', 'renameusers'); ?></h2>
        <?php settings_errors(); ?>
        <form method="post" action="">
            <?php wp_nonce_field('renameusers_nonce'); ?>
            <table class="form-table">
                <?php
                $opts = array(
                    'userlogin' => __('User login name', 'renameusers'),
                    'userlogin_new' => __('New user login name and nice name', 'renameusers'),
                );

                foreach ($opts as $slug => $title) {
                    $value = '';
                    if (!empty($results['renameusers_' . $slug]))
                        $value = esc_attr($results['renameusers_' . $slug]);
                    echo "<tr valign='top'><th scope='row'>{$title}</th><td><input class='regular-text' type='text' name='renameusers_{$slug}' value='{$value}'></td></tr>\n";
                }
                ?>
            </table>
            <?php submit_button(__('rename', 'renameusers')); ?>
        </form>
    </div>
    <?php
}

/**
 * This function renames an user account (or returns to options page in case of an error)
 * @global type $wpdb
 * @return boolean
 */
function renameusers_load_user() {
    if ('POST' != $_SERVER['REQUEST_METHOD'])
        return false;

    $error = false;

    check_admin_referer('renameusers_nonce');

    // remove the magic quotes
    $_POST = stripslashes_deep($_POST);

    if (empty($_POST['renameusers_userlogin'])) {
        add_settings_error('renameusers', 'required_userlogin', __('No username was entered - please enter a valid username', 'renameusers'), 'error');
        $error = true;
    } else {

        // Load user from Database
        // get_user_by doesnt work if wrong characters are inside user login name
        global $wpdb;
        if (!$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_login like '%s'",$_POST['renameusers_userlogin']))) {
            add_settings_error('renameusers', 'user_does_not_exist', __('Username does not exist', 'renameusers'), 'error');
            $error = true;
        }
    }

    if (empty($_POST['renameusers_userlogin_new'])) {
        add_settings_error('renameusers', 'required_userlogin', __('No new username was entered - please enter a valid username', 'renameusers'), 'error');
        $error = true;
    } else {
        // now we have to check if the new user name is 
        // a) another than the old one
        // b) allowed for wordpress
        // c) still not registrated
        $user_new_sanitized = sanitize_user($_POST['renameusers_userlogin_new']);
        if ($user_new_sanitized == $_POST['renameusers_userlogin']) {
            add_settings_error('renameusers', 'new_user_login_is_old_login', __('New user name has to be different from actual user name', 'renameusers'), 'error');
            $error = true;
        } else {
            if ($user_new_sanitized != ($_POST['renameusers_userlogin_new'])) {
                add_settings_error('renameusers', 'new_user_login_forbidden', __('New user name is not allowed for wordpress', 'renameusers'), 'error');
                $error = true;
            }
            if (get_user_by('user_login', $user_new_sanitized)) {
                add_settings_error('renameusers', 'new_user_login_in_use', __('New user name is already used', 'renameusers'), 'error');
                $error = true;
            }
        }
    }
    // any errors? return to main page - and continue otherwise
    if ($error) {
        return $_POST;
    } else {

        // Rename user data
        $sql_query = $wpdb->prepare("UPDATE $wpdb->users SET user_login = '%s', user_nicename = '%s' WHERE ID = %d", $user_new_sanitized, $user_new_sanitized, $user->ID);
        if ($wpdb->query($sql_query)) {
            // Send email
            $subject = sprintf(
                    __('Your username at %3$s was renamed from %1$s to %2$s','renameusers'), $user->user_login, $user_new_sanitized, get_bloginfo('name'));
            $content = sprintf(
                    __('Hello,

this is a system message from the website %3$s
Your login and user name has been changed by an administrator.

Username / Loginname (new): %1$s
Log in with this user at %4$s

You do not know your password any more? Request a new password at:
%2$s

See you soon at %3$s', 'renameusers'), $user_new_sanitized, get_bloginfo('wpurl') . '/wp-login.php?action=lostpassword', get_bloginfo('name'), get_bloginfo('wpurl'));

            if (!wp_mail($user->user_email, $subject, $content, $headers)) {
                add_settings_error('renameusers', 'new_user_login_in_use', __('Email could not be sent to' . $user->user_email, 'renameusers'), 'error');
            }
        } else {
            add_settings_error('renameusers', 'sql_update_error', __('User Data could not be updated - aborted!', 'renameusers'), 'error');
            return $_POST;
        }
        //print $sql_query;

        $message = sprintf(__('User login (new: %1$s) and nice name are updated now. An email was sent to the account owner (%2$s).', 'renameusers'), $user_new_sanitized, $user->user_email);

        add_settings_error('renameusers', 'plugin_active', $message, 'renameusers', 'updated');

        return $_POST;
    }
}

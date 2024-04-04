<?php

namespace SEVEN_TECH\Communications\Admin;

class AdminEmail
{

    public function register_custom_submenu_page()
    {
        add_submenu_page('seven-tech-communications', 'Edit Email Settings', 'Edit Email', 'manage_options', 'seven-tech-email-settings', [$this, 'create_section'], 5);
        add_action('admin_init', [$this, 'register_section']);
    }

    public function create_section()
    {
        include_once SEVEN_TECH_COMMUNICATIONS . 'Admin/includes/admin-edit-email.php';
    }

    public function register_section()
    {
        add_settings_section('seven-tech-admin-email', 'Edit Email Settings', [$this, 'section_description'], 'seven-tech-email-settings');
        register_setting('seven-tech-admin-email-group', 'smtp_username');
        register_setting('seven-tech-admin-email-group', 'smtp_host');
        register_setting('seven-tech-admin-email-group', 'smtp_auth');
        register_setting('seven-tech-admin-email-group', 'smtp_port');
        register_setting('seven-tech-admin-email-group', 'smtp_password');
        register_setting('seven-tech-admin-email-group', 'smtp_secure');
        add_settings_field('smtp_host', 'Host', [$this, 'smtp_host'], 'seven-tech-email-settings', 'seven-tech-admin-email');
        add_settings_field('smtp_port', 'Port', [$this, 'smtp_port'], 'seven-tech-email-settings', 'seven-tech-admin-email');
        add_settings_field('smtp_username', 'Username', [$this, 'smtp_username'], 'seven-tech-email-settings', 'seven-tech-admin-email');
        add_settings_field('smtp_password', 'Password', [$this, 'smtp_password'], 'seven-tech-email-settings', 'seven-tech-admin-email');
        add_settings_field('smtp_auth', 'Auth', [$this, 'smtp_auth'], 'seven-tech-email-settings', 'seven-tech-admin-email');
        add_settings_field('smtp_secure', 'Secure', [$this, 'smtp_secure'], 'seven-tech-email-settings', 'seven-tech-admin-email');
    }

    function section_description()
    {
        echo 'Edit your email SMTP settings to send messages from your website below.';
    }

    function smtp_username()
    {
        $smtp_username = esc_attr(get_option('smtp_username'));
        echo '<input class="admin-input" type="text" name="smtp_username" value="' . $smtp_username . '" />';
    }

    function smtp_password()
    {
        $smtp_password = esc_attr(get_option('smtp_password'));
        echo '<input class="admin-input" type="text" name="smtp_password" value="' . $smtp_password . '" />';
    }

    function smtp_port()
    {
        $smtp_port = esc_attr(get_option('smtp_port'));
        echo '<input class="admin-input" type="text" name="smtp_port" value="' . $smtp_port . '" />';
    }

    function smtp_host()
    {
        $smtp_host = esc_attr(get_option('smtp_host'));
        echo '<input class="admin-input" type="text" name="smtp_host" value="' . $smtp_host . '" />';
    }

    function smtp_auth()
    {
        $smtpAuth = esc_attr(get_option('smtp_auth'));
        echo '<input class="admin-input" type="text" name="smtp_auth" value="' . $smtpAuth . '" />';
    }

    function smtp_secure()
    {
        $smtpSecure = esc_attr(get_option('smtp_secure'));
        echo '<input class="admin-input" type="text" name="smtp_secure" value="' . $smtpSecure . '" />';
    }
}

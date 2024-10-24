<?php

namespace SEVEN_TECH\Communications\Admin;

class Gateway
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_custom_submenu_page']);
    }

    function register_custom_submenu_page()
    {
        add_submenu_page('seven-tech-communications', 'Edit Email SMTP Settings', 'Edit Gateway Email', 'manage_options', 'seven-tech-gateway-email-settings', [$this, 'create_section'], 5);
        add_action('admin_init', [$this, 'register_section']);
    }

    function create_section()
    {
        include_once SEVEN_TECH_COMMUNICATIONS . 'Admin/includes/admin-edit-email-gateway.php';
    }

    function register_section()
    {
        add_settings_section('seven-tech-admin-gateway-email', '', [$this, 'section_description'], 'seven-tech-gateway-email-settings');
        register_setting('seven-tech-gateway-email-group', 'gateway_smtp_username');
        register_setting('seven-tech-gateway-email-group', 'gateway_smtp_host');
        register_setting('seven-tech-gateway-email-group', 'gateway_smtp_auth');
        register_setting('seven-tech-gateway-email-group', 'gateway_smtp_port');
        register_setting('seven-tech-gateway-email-group', 'gateway_smtp_password');
        register_setting('seven-tech-gateway-email-group', 'gateway_smtp_secure');
        register_setting('seven-tech-gateway-email-group', 'gateway_email');
        register_setting('seven-tech-gateway-email-group', 'gateway_name');
        add_settings_field('gateway_smtp_host', 'Host', [$this, 'gateway_smtp_host'], 'seven-tech-gateway-email-settings', 'seven-tech-admin-gateway-email');
        add_settings_field('gateway_smtp_port', 'Port', [$this, 'gateway_smtp_port'], 'seven-tech-gateway-email-settings', 'seven-tech-admin-gateway-email');
        add_settings_field('gateway_smtp_username', 'Username', [$this, 'gateway_smtp_username'], 'seven-tech-gateway-email-settings', 'seven-tech-admin-gateway-email');
        add_settings_field('gateway_smtp_password', 'Password', [$this, 'gateway_smtp_password'], 'seven-tech-gateway-email-settings', 'seven-tech-admin-gateway-email');
        add_settings_field('gateway_smtp_auth', 'Auth', [$this, 'gateway_smtp_auth'], 'seven-tech-gateway-email-settings', 'seven-tech-admin-gateway-email');
        add_settings_field('gateway_smtp_secure', 'Secure', [$this, 'gateway_smtp_secure'], 'seven-tech-gateway-email-settings', 'seven-tech-admin-gateway-email');
        add_settings_field('gateway_email', 'Email', [$this, 'gateway_email'], 'seven-tech-gateway-email-settings', 'seven-tech-admin-gateway-email');
        add_settings_field('gateway_name', 'Name', [$this, 'gateway_name'], 'seven-tech-gateway-email-settings', 'seven-tech-admin-gateway-email');
    }

    function section_description()
    {
        echo 'Edit your contact email SMTP settings to send messages from your website below.';
    }

    function gateway_smtp_username()
    {
        $smtp_username = esc_attr(get_option('gateway_smtp_username'));
        echo '<input class="admin-input" type="text" name="gateway_smtp_username" value="' . $smtp_username . '" />';
    }

    function gateway_smtp_password()
    {
        $smtp_password = esc_attr(get_option('gateway_smtp_password'));
        echo '<input class="admin-input" type="text" name="gateway_smtp_password" value="' . $smtp_password . '" />';
    }

    function gateway_smtp_port()
    {
        $smtp_port = esc_attr(get_option('gateway_smtp_port'));
        echo '<input class="admin-input" type="text" name="gateway_smtp_port" value="' . $smtp_port . '" />';
    }

    function gateway_smtp_host()
    {
        $smtp_host = esc_attr(get_option('gateway_smtp_host'));
        echo '<input class="admin-input" type="text" name="gateway_smtp_host" value="' . $smtp_host . '" />';
    }

    function gateway_smtp_auth()
    {
        $smtpAuth = esc_attr(get_option('gateway_smtp_auth'));
        echo '<input class="admin-input" type="text" name="gateway_smtp_auth" value="' . $smtpAuth . '" />';
    }

    function gateway_smtp_secure()
    {
        $smtpSecure = esc_attr(get_option('gateway_smtp_secure'));
        echo '<input class="admin-input" type="text" name="gateway_smtp_secure" value="' . $smtpSecure . '" />';
    }

    function gateway_email()
    {
        $gateway_email = esc_attr(get_option('gateway_email'));
        echo '<input class="admin-input" type="text" name="gateway_email" value="' . $gateway_email . '" />';
    }

    function gateway_name()
    {
        $gateway_name = esc_attr(get_option('gateway_name'));
        echo '<input class="admin-input" type="text" name="gateway_name" value="' . $gateway_name . '" />';
    }
}

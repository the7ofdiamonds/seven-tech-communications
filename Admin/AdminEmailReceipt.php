<?php

namespace SEVEN_TECH\Communications\Admin;

class AdminEmailReceipt
{

    public function __construct()
    {
    }

    function register_custom_submenu_page()
    {
        add_submenu_page('seven-tech-communications', 'Edit Email SMTP Settings', 'Edit Receipt Email', 'manage_options', 'seven-tech-receipt-email-settings', [$this, 'create_section'], 5);
        add_action('admin_init', [$this, 'register_section']);
    }

    function create_section()
    {
        include_once SEVEN_TECH_COMMUNICATIONS . 'Admin/includes/admin-edit-email-receipt.php';
    }

    function register_section()
    {
        add_settings_section('seven-tech-receipt-email', 'Edit Receipt Email Settings', [$this, 'section_description'], 'seven-tech-receipt-email-settings');
        register_setting('seven-tech-receipt-email-group', 'receipt_smtp_username');
        register_setting('seven-tech-receipt-email-group', 'receipt_smtp_host');
        register_setting('seven-tech-receipt-email-group', 'receipt_smtp_auth');
        register_setting('seven-tech-receipt-email-group', 'receipt_smtp_port');
        register_setting('seven-tech-receipt-email-group', 'receipt_smtp_password');
        register_setting('seven-tech-receipt-email-group', 'receipt_smtp_secure');
        register_setting('seven-tech-receipt-email-group', 'receipt_email');
        register_setting('seven-tech-receipt-email-group', 'receipt_name');
        add_settings_field('receipt_smtp_host', 'Host', [$this, 'receipt_smtp_host'], 'seven-tech-receipt-email-settings', 'seven-tech-receipt-email');
        add_settings_field('receipt_smtp_port', 'Port', [$this, 'receipt_smtp_port'], 'seven-tech-receipt-email-settings', 'seven-tech-receipt-email');
        add_settings_field('receipt_smtp_username', 'Username', [$this, 'receipt_smtp_username'], 'seven-tech-receipt-email-settings', 'seven-tech-receipt-email');
        add_settings_field('receipt_smtp_password', 'Password', [$this, 'receipt_smtp_password'], 'seven-tech-receipt-email-settings', 'seven-tech-receipt-email');
        add_settings_field('receipt_smtp_auth', 'Auth', [$this, 'receipt_smtp_auth'], 'seven-tech-receipt-email-settings', 'seven-tech-receipt-email');
        add_settings_field('receipt_smtp_secure', 'Secure', [$this, 'receipt_smtp_secure'], 'seven-tech-receipt-email-settings', 'seven-tech-receipt-email');
        add_settings_field('receipt_email', 'Email', [$this, 'receipt_email'], 'seven-tech-receipt-email-settings', 'seven-tech-receipt-email');
        add_settings_field('receipt_name', 'Name', [$this, 'receipt_name'], 'seven-tech-receipt-email-settings', 'seven-tech-receipt-email');
    }

    function section_description()
    {
        echo 'Edit your receipt email SMTP settings to send messages from your website below.';
    }

    function receipt_smtp_username()
    {
        $smtp_username = esc_attr(get_option('receipt_smtp_username'));
        echo '<input class="admin-input" type="text" name="receipt_smtp_username" value="' . $smtp_username . '" />';
    }

    function receipt_smtp_password()
    {
        $smtp_password = esc_attr(get_option('receipt_smtp_password'));
        echo '<input class="admin-input" type="text" name="receipt_smtp_password" value="' . $smtp_password . '" />';
    }

    function receipt_smtp_port()
    {
        $smtp_port = esc_attr(get_option('receipt_smtp_port'));
        echo '<input class="admin-input" type="text" name="receipt_smtp_port" value="' . $smtp_port . '" />';
    }

    function receipt_smtp_host()
    {
        $smtp_host = esc_attr(get_option('receipt_smtp_host'));
        echo '<input class="admin-input" type="text" name="receipt_smtp_host" value="' . $smtp_host . '" />';
    }

    function receipt_smtp_auth()
    {
        $smtpAuth = esc_attr(get_option('receipt_smtp_auth'));
        echo '<input class="admin-input" type="text" name="receipt_smtp_auth" value="' . $smtpAuth . '" />';
    }

    function receipt_smtp_secure()
    {
        $smtpSecure = esc_attr(get_option('receipt_smtp_secure'));
        echo '<input class="admin-input" type="text" name="receipt_smtp_secure" value="' . $smtpSecure . '" />';
    }

    function receipt_email()
    {
        $receipt_email = esc_attr(get_option('receipt_email'));
        echo '<input class="admin-input" type="text" name="receipt_email" value="' . $receipt_email . '" />';
    }

    function receipt_name()
    {
        $receipt_name = esc_attr(get_option('receipt_name'));
        echo '<input class="admin-input" type="text" name="receipt_name" value="' . $receipt_name . '" />';
    }
}

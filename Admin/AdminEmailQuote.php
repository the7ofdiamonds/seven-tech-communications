<?php

namespace SEVEN_TECH\Communications\Admin;

class AdminEmailQuote
{

    public function __construct()
    {
    }

    function register_custom_submenu_page()
    {
        add_submenu_page('seven-tech-communications', 'Edit Quote Email Settings', 'Edit Quote Email', 'manage_options', 'seven-tech-quote-email-settings', [$this, 'create_section'], 5);
        add_action('admin_init', [$this, 'register_section']);
    }

    function create_section()
    {
        include_once SEVEN_TECH_COMMUNICATIONS . 'Admin/includes/admin-edit-email-quote.php';
    }

    function register_section()
    {
        add_settings_section('seven-tech-quote-email', 'Edit Quote Email Settings', [$this, 'section_description'], 'seven-tech-quote-email-settings');
        register_setting('seven-tech-quote-email-group', 'quote_smtp_username');
        register_setting('seven-tech-quote-email-group', 'quote_smtp_host');
        register_setting('seven-tech-quote-email-group', 'quote_smtp_auth');
        register_setting('seven-tech-quote-email-group', 'quote_smtp_port');
        register_setting('seven-tech-quote-email-group', 'quote_smtp_password');
        register_setting('seven-tech-quote-email-group', 'quote_smtp_secure');
        register_setting('seven-tech-quote-email-group', 'quote_email');
        register_setting('seven-tech-quote-email-group', 'quote_name');
        add_settings_field('quote_smtp_host', 'Host', [$this, 'quote_smtp_host'], 'seven-tech-quote-email-settings', 'seven-tech-quote-email');
        add_settings_field('quote_smtp_port', 'Port', [$this, 'quote_smtp_port'], 'seven-tech-quote-email-settings', 'seven-tech-quote-email');
        add_settings_field('quote_smtp_username', 'Username', [$this, 'quote_smtp_username'], 'seven-tech-quote-email-settings', 'seven-tech-quote-email');
        add_settings_field('quote_smtp_password', 'Password', [$this, 'quote_smtp_password'], 'seven-tech-quote-email-settings', 'seven-tech-quote-email');
        add_settings_field('quote_smtp_auth', 'Auth', [$this, 'quote_smtp_auth'], 'seven-tech-quote-email-settings', 'seven-tech-quote-email');
        add_settings_field('quote_smtp_secure', 'Secure', [$this, 'quote_smtp_secure'], 'seven-tech-quote-email-settings', 'seven-tech-quote-email');
        add_settings_field('quote_email', 'Email', [$this, 'quote_email'], 'seven-tech-quote-email-settings', 'seven-tech-quote-email');
        add_settings_field('quote_name', 'Name', [$this, 'quote_name'], 'seven-tech-quote-email-settings', 'seven-tech-quote-email');
    }

    function section_description()
    {
        echo 'Edit your quote email SMTP settings to send messages from your website below.';
    }

    function quote_smtp_username()
    {
        $smtp_username = esc_attr(get_option('quote_smtp_username'));
        echo '<input class="admin-input" type="text" name="quote_smtp_username" value="' . $smtp_username . '" />';
    }

    function quote_smtp_password()
    {
        $smtp_password = esc_attr(get_option('quote_smtp_password'));
        echo '<input class="admin-input" type="text" name="quote_smtp_password" value="' . $smtp_password . '" />';
    }

    function quote_smtp_port()
    {
        $smtp_port = esc_attr(get_option('quote_smtp_port'));
        echo '<input class="admin-input" type="text" name="quote_smtp_port" value="' . $smtp_port . '" />';
    }

    function quote_smtp_host()
    {
        $smtp_host = esc_attr(get_option('quote_smtp_host'));
        echo '<input class="admin-input" type="text" name="quote_smtp_host" value="' . $smtp_host . '" />';
    }

    function quote_smtp_auth()
    {
        $smtpAuth = esc_attr(get_option('quote_smtp_auth'));
        echo '<input class="admin-input" type="text" name="quote_smtp_auth" value="' . $smtpAuth . '" />';
    }

    function quote_smtp_secure()
    {
        $smtpSecure = esc_attr(get_option('quote_smtp_secure'));
        echo '<input class="admin-input" type="text" name="quote_smtp_secure" value="' . $smtpSecure . '" />';
    }

    function quote_email()
    {
        $quote_email = esc_attr(get_option('quote_email'));
        echo '<input class="admin-input" type="text" name="quote_email" value="' . $quote_email . '" />';
    }

    function quote_name()
    {
        $quote_name = esc_attr(get_option('quote_name'));
        echo '<input class="admin-input" type="text" name="quote_name" value="' . $quote_name . '" />';
    }
}

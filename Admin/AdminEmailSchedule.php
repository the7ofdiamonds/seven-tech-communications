<?php

namespace SEVEN_TECH\Communications\Admin;

class AdminEmailSchedule
{

    public function __construct()
    {
    }

    function register_custom_submenu_page()
    {
        add_submenu_page('seven-tech-communications', 'Edit Email SMTP Settings', 'Edit Schedule Email', 'manage_options', 'seven-tech-schedule-email-settings', [$this, 'create_section'], 5);
        add_action('admin_init', [$this, 'register_section']);
    }

    function create_section()
    {
        include_once SEVEN_TECH_COMMUNICATIONS . 'Admin/includes/admin-edit-email-schedule.php';
    }

    function register_section()
    {
        add_settings_section('seven-tech-schedule-email', 'Edit Schedule Email Settings', [$this, 'section_description'], 'seven-tech-schedule-email-settings');
        register_setting('seven-tech-schedule-email-group', 'schedule_smtp_username');
        register_setting('seven-tech-schedule-email-group', 'schedule_smtp_host');
        register_setting('seven-tech-schedule-email-group', 'schedule_smtp_auth');
        register_setting('seven-tech-schedule-email-group', 'schedule_smtp_port');
        register_setting('seven-tech-schedule-email-group', 'schedule_smtp_password');
        register_setting('seven-tech-schedule-email-group', 'schedule_smtp_secure');
        register_setting('seven-tech-schedule-email-group', 'schedule_email');
        register_setting('seven-tech-schedule-email-group', 'schedule_name');
        add_settings_field('schedule_smtp_host', 'Host', [$this, 'schedule_smtp_host'], 'seven-tech-schedule-email-settings', 'seven-tech-schedule-email');
        add_settings_field('schedule_smtp_port', 'Port', [$this, 'schedule_smtp_port'], 'seven-tech-schedule-email-settings', 'seven-tech-schedule-email');
        add_settings_field('schedule_smtp_username', 'Username', [$this, 'schedule_smtp_username'], 'seven-tech-schedule-email-settings', 'seven-tech-schedule-email');
        add_settings_field('schedule_smtp_password', 'Password', [$this, 'schedule_smtp_password'], 'seven-tech-schedule-email-settings', 'seven-tech-schedule-email');
        add_settings_field('schedule_smtp_auth', 'Auth', [$this, 'schedule_smtp_auth'], 'seven-tech-schedule-email-settings', 'seven-tech-schedule-email');
        add_settings_field('schedule_smtp_secure', 'Secure', [$this, 'schedule_smtp_secure'], 'seven-tech-schedule-email-settings', 'seven-tech-schedule-email');
        add_settings_field('schedule_email', 'Email', [$this, 'schedule_email'], 'seven-tech-schedule-email-settings', 'seven-tech-schedule-email');
        add_settings_field('schedule_name', 'Name', [$this, 'schedule_name'], 'seven-tech-schedule-email-settings', 'seven-tech-schedule-email');
    }

    function section_description()
    {
        echo 'Edit your schedule email SMTP settings to send messages from your website below.';
    }

    function schedule_smtp_username()
    {
        $smtp_username = esc_attr(get_option('schedule_smtp_username'));
        echo '<input class="admin-input" type="text" name="schedule_smtp_username" value="' . $smtp_username . '" />';
    }

    function schedule_smtp_password()
    {
        $smtp_password = esc_attr(get_option('schedule_smtp_password'));
        echo '<input class="admin-input" type="text" name="schedule_smtp_password" value="' . $smtp_password . '" />';
    }

    function schedule_smtp_port()
    {
        $smtp_port = esc_attr(get_option('schedule_smtp_port'));
        echo '<input class="admin-input" type="text" name="schedule_smtp_port" value="' . $smtp_port . '" />';
    }

    function schedule_smtp_host()
    {
        $smtp_host = esc_attr(get_option('schedule_smtp_host'));
        echo '<input class="admin-input" type="text" name="schedule_smtp_host" value="' . $smtp_host . '" />';
    }

    function schedule_smtp_auth()
    {
        $smtpAuth = esc_attr(get_option('schedule_smtp_auth'));
        echo '<input class="admin-input" type="text" name="schedule_smtp_auth" value="' . $smtpAuth . '" />';
    }

    function schedule_smtp_secure()
    {
        $smtpSecure = esc_attr(get_option('schedule_smtp_secure'));
        echo '<input class="admin-input" type="text" name="schedule_smtp_secure" value="' . $smtpSecure . '" />';
    }

    function schedule_email()
    {
        $schedule_email = esc_attr(get_option('schedule_email'));
        echo '<input class="admin-input" type="text" name="schedule_email" value="' . $schedule_email . '" />';
    }

    function schedule_name()
    {
        $schedule_name = esc_attr(get_option('schedule_name'));
        echo '<input class="admin-input" type="text" name="schedule_name" value="' . $schedule_name . '" />';
    }
}

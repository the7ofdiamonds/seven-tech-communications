<?php

namespace SEVEN_TECH\Communications\Admin;

class AdminAbout
{

    public function __construct()
    {
    }

    function register_custom_submenu_page()
    {
        add_submenu_page('seven-tech-communications', 'Add Mission Statement', 'Add Mission', 'manage_options', 'seven-tech-about', [$this, 'create_section'], 1);
        add_action('admin_init', [$this, 'register_section']);
    }

    function create_section()
    {
        include_once SEVEN_TECH_COMMUNICATIONS . 'Admin/includes/admin-edit-about.php';
    }

    function register_section()
    {
        add_settings_section('seven-tech-communications-about', 'Add Mission Statement', [$this, 'section_description'], 'seven-tech-about');
        register_setting('seven-tech-communications-about-group', 'mission-statement');
        add_settings_field('mission-statement', 'Add Mission Statement', [$this, 'mission_statement'], 'seven-tech-about', 'seven-tech-communications-about');
    }

    function section_description()
    {
        echo 'Add your mission statement';
    }

    function mission_statement()
    { ?>
        <textarea name="mission-statement"><?php echo esc_textarea(get_option('mission-statement')); ?></textarea>
<?php
    }
}

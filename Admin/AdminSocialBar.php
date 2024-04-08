<?php

namespace SEVEN_TECH\Communications\Admin;

class AdminSocialBar
{

    public function __construct()
    {
    }

    function register_custom_submenu_page()
    {
        add_submenu_page('seven-tech-communications', 'Add Social Media', 'Add Social', 'manage_options', 'seven-tech-social-bar', [$this, 'create_section'], 4);
        add_action('admin_init', [$this, 'register_section']);
    }

    function create_section()
    {
        include_once SEVEN_TECH_COMMUNICATIONS . 'Admin/includes/admin-add-social-bar.php';
    }

    function register_section()
    {
        register_setting('seven-tech-communications-social-group', 'facebook_link');
        register_setting('seven-tech-communications-social-group', 'twitter_link');
        register_setting('seven-tech-communications-social-group', 'linkedin_link');
        register_setting('seven-tech-communications-social-group', 'instagram_link');
        add_settings_section('seven-tech-communications-social', 'Add Social Media Links', [$this, 'section_description'], 'seven-tech-social-bar');
        add_settings_field('facbook_link', 'Facebook', [$this, 'admin_facebook_input'], 'seven-tech-social-bar', 'seven-tech-communications-social');
        add_settings_field('twitter_link', 'Twitter', [$this, 'admin_twitter_input'], 'seven-tech-social-bar', 'seven-tech-communications-social');
        add_settings_field('linkedin_link', 'linkedin', [$this, 'admin_linkedin_input'], 'seven-tech-social-bar', 'seven-tech-communications-social');
        add_settings_field('instagram_link', 'instagram', [$this, 'admin_instagram_input'], 'seven-tech-social-bar', 'seven-tech-communications-social');
        add_settings_field('contact_email', 'Contact Email', [$this, 'admin_contact_email'], 'seven-tech-social-bar', 'seven-tech-communications-social');
    }

    function section_description()
    {
        echo 'Add social media links to your website so visitors can follow you there';
    }

    function admin_facebook_input()
    {
        $facebook_link = esc_attr(get_option('facebook_link'));
        echo '<input type="text" name="facebook_link" value="' . $facebook_link . '" />';
    }

    function admin_twitter_input()
    {
        $twitter_link = esc_attr(get_option('twitter_link'));
        echo '<input type="text" name="twitter_link" value="' . $twitter_link . '" />';
    }

    function admin_linkedin_input()
    {
        $linkedin_link = esc_attr(get_option('linkedin_link'));
        echo '<input type="text" name="linkedin_link" value="' . $linkedin_link . '" />';
    }

    function admin_instagram_input()
    {
        $instagram_link = esc_attr(get_option('instagram_link'));
        echo '<input type="text" name="instagram_link" value="' . $instagram_link . '" />';
    }

    function admin_contact_email()
    {
        $contact_email = esc_attr(get_option('contact_email'));
        echo '<input type="text" name="contact-email" value="' . $contact_email . '" />';
    }
}

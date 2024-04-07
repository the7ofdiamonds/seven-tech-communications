<?php

get_header();

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

include SEVEN_TECH . 'includes/react.php';

if (is_plugin_active('seven-tech-portfolio/SEVEN_TECH_Portfolio.php')) {
    echo do_shortcode('[seven-tech-portfolio]');
}

get_footer();

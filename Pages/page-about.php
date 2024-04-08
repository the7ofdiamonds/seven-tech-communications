<?php
get_header();

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}
?>

<div class='about'>
    <?php
    include SEVEN_TECH_COMMUNICATIONS . 'includes/react.php';

    if (is_plugin_active('seven-tech-location/SEVEN_TECH_Location.php')) {
        echo do_shortcode('[seven-tech-locations]');
    }

    if (is_plugin_active('seven-tech-schedule/SEVEN_TECH_Schedule.php')) {
        echo do_shortcode('[seven-tech-schedule]');
    }
    ?>
</div>

<?php
get_footer();
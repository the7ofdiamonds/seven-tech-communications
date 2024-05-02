<?php
get_header();

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}
?>

<div class="managing-member">
    <?php
    include SEVEN_TECH_COMMUNICATIONS . 'includes/react.php';

    if (is_plugin_active('seven-tech-portfolio/SEVEN_TECH_Portfolio.php')) {
        echo do_shortcode('[seven-tech-portfolio]');
    }
    ?>
</div>

<?php
get_footer();

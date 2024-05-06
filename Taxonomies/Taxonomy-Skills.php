<?php

use SEVEN_TECH\Communications\Taxonomies\Skills;

$currentURL = $_SERVER['REQUEST_URI'];
$urlPosition = explode('/', $currentURL);
$taxonomy = isset($urlPosition[1]) ? $urlPosition[1] : '';
$term = isset($urlPosition[2]) ? $urlPosition[2] : '';

$skills = new Skills;
$postType = 'portfolio';
$hasTaxonomy = $skills->getPostTypesWithSkills($postType);
$hasTerm = $skills->getPostTypesWithSkill($postType, $term);

if (($hasTaxonomy || $hasTerm) && !function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

get_header();

?>
<div class="skills">
    <?php
    include SEVEN_TECH_COMMUNICATIONS . 'includes/react.php';

    if (($hasTaxonomy || $hasTerm) && is_plugin_active('seven-tech-portfolio/SEVEN_TECH_Portfolio.php')) {
        echo do_shortcode('[seven-tech-portfolio]');
    }
    ?>
</div>
<?php
get_footer();

<?php

use SEVEN_TECH\Communications\Post_Types\Post_Types;

$currentURL = $_SERVER['REQUEST_URI'];
$urlPosition = explode('/', $currentURL);
$taxonomy = isset($urlPosition[1]) ? $urlPosition[1] : '';
$term = isset($urlPosition[2]) ? $urlPosition[2] : '';

$post_types = new Post_Types;
$postType = 'portfolio';
$hasTaxonomy = $post_types->getPostTypeWithTaxonomy($postType, $taxonomy);
$hasTerm = $post_types->getPostTypeWithTerm($postType, $taxonomy, $term);

if (($hasTaxonomy || $hasTerm) && !function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

get_header();

?>
<div class="technologies">
    <?php
    include SEVEN_TECH_COMMUNICATIONS . 'includes/react.php';

    if (($hasTaxonomy || $hasTerm) && is_plugin_active('seven-tech-portfolio/SEVEN_TECH_Portfolio.php')) {
        echo do_shortcode('[seven-tech-portfolio]');
    }
    ?>
</div>
<?php
get_footer();

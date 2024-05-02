<?php
if (!is_user_logged_in()) {
    $fullUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    wp_redirect('/login' . '?redirectTo=' . $fullUrl);
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use SEVEN_TECH\Communications\User\User;

$user = new User;

$currentURL = $_SERVER['REQUEST_URI'];
$urlPosition = explode('/', $currentURL);

$hasPosts = $user->userHasPostsOfType($urlPosition[1], $urlPosition[2]);

if (!$hasPosts && !function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

get_header();
?>

<div class="investor">
    <?php
    include SEVEN_TECH_COMMUNICATIONS . 'includes/react.php';

    if (is_plugin_active('seven-tech-portfolio/SEVEN_TECH_Portfolio.php')) {
        echo do_shortcode('[seven-tech-portfolio]');
    }
    ?>
</div>

<?php
get_footer();

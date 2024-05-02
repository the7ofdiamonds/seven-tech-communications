<?php
if (!is_user_logged_in()) {
    $fullUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    wp_redirect('/login' . '?redirectTo=' . $fullUrl);
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = wp_get_current_user();
$roles = $user->roles;

$user_allowed = false;

foreach ($roles as $role) {
    if (
        $role == 'administrator' ||
        $role == 'employee' ||
        $role == 'executive' ||
        $role == 'founder' ||
        $role == 'freelancer' ||
        $role == 'investor' ||
        $role == 'managing-member' ||
        $role == 'team'
    ) {
        $user_allowed = true;
        break;
    }
}

get_header();

if ($user_allowed) {
    include_once SEVEN_TECH_COMMUNICATIONS . 'includes/react.php';
} else {
    include_once SEVEN_TECH_COMMUNICATIONS . 'includes/access-denied.php'; 
}

get_footer();

<?php

namespace SEVEN_TECH\Communications\Shortcodes;

class Shortcodes
{
    public function __construct()
    {
        add_shortcode('seven-tech-social-bar', [$this, 'social_bar_shortcode']);
    }

    function social_bar_shortcode() {
        include SEVEN_TECH_COMMUNICATIONS . 'includes/part-social-bar.php';
    }
}

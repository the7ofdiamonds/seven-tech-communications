<?php

namespace SEVEN_TECH\Communications;

/**
 * @package SEVEN_TECH\Communications
 */
/*
Plugin Name: SEVEN TECH Communications
Plugin URI: 
Description: Communications.
Version: 1.0.0
Author: THE7OFDIAMONDS.TECH
Author URI: http://THE7OFDIAMONDS.TECH
License: 
Text Domain: seven-tech
*/

/*
Licensing Info is needed
*/

defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');
define('SEVEN_TECH_COMMUNICATIONS', WP_PLUGIN_DIR . '/seven-tech-communications/');
define('SEVEN_TECH_COMMUNICATIONS_URL', WP_PLUGIN_URL . '/seven-tech-communications/');

require_once SEVEN_TECH_COMMUNICATIONS . 'vendor/autoload.php';

use SEVEN_TECH\Communications\Admin\Admin;

class SEVEN_TECH_Communications
{
    public function __construct()
    {
        $admin = new Admin;
// Add social medaia and bar to this plugin
        add_action('admin_init', function () use ($admin) {
            $admin;
        });
    }

    function activate()
    {
        flush_rewrite_rules();
    }
}

$seven_tech_communications = new SEVEN_TECH_Communications();
register_activation_hook(__FILE__, array($seven_tech_communications, 'activate'));

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

use SEVEN_TECH\Communications\API\API;
use SEVEN_TECH\Communications\CSS\CSS;
use SEVEN_TECH\Communications\CSS\Customizer\Customizer;
use SEVEN_TECH\Communications\CSS\Customizer\BorderRadius;
use SEVEN_TECH\Communications\CSS\Customizer\Color;
use SEVEN_TECH\Communications\CSS\Customizer\Shadow;
use SEVEN_TECH\Communications\CSS\Customizer\SocialBar;
use SEVEN_TECH\Communications\JS\JS;
use SEVEN_TECH\Communications\Pages\Pages;
use SEVEN_TECH\Communications\Post_Types\Founders\Founders;
use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Roles\Roles;
use SEVEN_TECH\Communications\Router\Router;
use SEVEN_TECH\Communications\Shortcodes\Shortcodes;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;
use SEVEN_TECH\Communications\Templates\Templates;

class SEVEN_TECH_Communications
{
    private $pages;
    private $router;

    public function __construct()
    {
        $plugin = plugin_basename(__FILE__);
        add_filter("plugin_action_links_{$plugin}", [$this, 'settings_link']);

        $admin = new Admin;

        add_action('admin_init', function () use ($admin) {
            $admin;
        });

        add_action('rest_api_init', function () {
            new API();
        });

        $pages = new Pages;
        $posttypes = new Post_Types;
        $taxonomies = new Taxonomies;
        $css = new CSS;
        $js = new JS;
        $templates = new Templates(
            $css,
            $js,
        );
        $router = new Router(
            $pages,
            $posttypes,
            $taxonomies,
            $templates
        );

        add_action('init', function () use ($posttypes, $taxonomies, $router) {
            $posttypes->custom_post_types();
            $taxonomies->custom_taxonomy();
            $router->load_page();
            $router->react_rewrite_rules();
            new Shortcodes;
        });

        $this->router = new Router(
            $pages,
            $posttypes,
            $taxonomies,
            $templates
        );
        $this->pages = new Pages;

        add_action('wp_head', function () {
            (new SocialBar)->load_css();
            (new CSS)->load_social_bar_css();
        });

        add_action('customize_register', function ($wp_customize) {
            (new Customizer)->register_customizer_panel($wp_customize);
            (new BorderRadius)->seven_tech_border_radius_section($wp_customize);
            (new Color)->seven_tech_color_section($wp_customize);
            (new Shadow)->seven_tech_shadow_section($wp_customize);
            (new SocialBar)->seven_tech_social_bar_section($wp_customize);
        });
    }

    function activate()
    {
        $this->router->react_rewrite_rules();
        $this->pages->add_pages();
        (new Founders)->addFounderPages();
    }

    function deactivate()
    {
        flush_rewrite_rules();
    }

    public function settings_link($links)
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=seven-tech-communications') . '">Settings</a>';
        array_push($links, $settings_link);

        return $links;
    }
}

$seven_tech_communications = new SEVEN_TECH_Communications();
register_activation_hook(__FILE__, array($seven_tech_communications, 'activate'));
register_deactivation_hook(__FILE__, array($seven_tech_communications, 'deactivate'));

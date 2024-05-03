<?php

namespace SEVEN_TECH\Communications\Templates;

use SEVEN_TECH\Communications\CSS\CSS;
use SEVEN_TECH\Communications\JS\JS;

class Templates
{
    private $css;
    private $js;
    private $pluginDir;
    private $cssDir;
    private $jsDir;

    public function __construct(
        CSS $css,
        JS $js,
    ) {
        $this->css = $css;
        $this->js = $js;
        $this->pluginDir = SEVEN_TECH_COMMUNICATIONS;
        $this->cssDir = SEVEN_TECH_COMMUNICATIONS . 'dist/css/';
        $this->jsDir = SEVEN_TECH_COMMUNICATIONS . 'dist/js/';
    }

    function get_front_page_template($frontpage_template, $sections)
    {
        if (is_front_page()) {
            $frontpage_template = $this->pluginDir . 'Pages/front-page.php';

            if (file_exists($frontpage_template)) {
                foreach ($sections as $section) {
                    add_action('wp_head', function () use ($section) {
                        $this->css->load_front_page_css($section);
                    });
                    add_action('wp_footer', function () use ($section) {
                        $this->js->load_front_page_react($section);
                    });
                }

                return $frontpage_template;
            } else {
                error_log('Front Page Template does not exist.');
            }
        }

        return $frontpage_template;
    }

    function get_custom_page_template($template, $custom_page)
    {

        if (isset($custom_page['file_name'])) {
            $filename = $custom_page['file_name'];
            $filename_css = "{$this->cssDir}{$filename}.css";
            $filename_js = "{$this->jsDir}{$filename}.js";

            if (file_exists($filename_css)) {
                add_action('wp_head', function () use ($filename) {
                    $this->css->load_pages_css($filename);
                });
            }

            if (file_exists($filename_js)) {
                add_action('wp_footer', function () use ($filename) {
                    $this->js->load_pages_react($filename);
                });
            }
        }

        if (isset($custom_page['page_name'])) {
            $template = "{$this->pluginDir}Pages/page-{$custom_page['page_name']}.php";

            if (file_exists($template)) {
                return $template;
            }
        }

        return $template;
    }

    function get_protected_page_template($template_include, $protected_page)
    {
        $template = $this->pluginDir . 'Pages/page-protected.php';

        if (file_exists($template)) {
            $filename = $protected_page['file_name'];
            $filename_css = "{$this->cssDir}{$filename}.css";
            $filename_js = "{$this->jsDir}{$filename}.js";

            if (file_exists($filename_css)) {
                add_action('wp_head', function () use ($filename) {
                    $this->css->load_pages_css($filename);
                });
            }

            if (file_exists($filename_js)) {
                add_action('wp_footer', function () use ($filename) {
                    $this->js->load_pages_react($filename);
                });
            }

            return $template;
        } else {
            error_log('Protected Page Template does not exist.');
        }

        return $template_include;
    }

    function get_page_template($template_include, $page)
    {
        $filename = $page['file_name'];
        $filename_css = "{$this->cssDir}{$filename}.css";
        $filename_js = "{$this->jsDir}{$filename}.js";

        if (file_exists($filename_css)) {
            add_action('wp_head', function () use ($filename) {
                $this->css->load_pages_css($filename);
            });
        }

        if (file_exists($filename_js)) {
            add_action('wp_footer', function () use ($filename) {
                $this->js->load_pages_react($filename);
            });
        }

        $template = $this->pluginDir . 'Pages/page.php';;

        if (file_exists($template)) {
            return $template;
        }

        return $template_include;
    }

    public function get_taxonomy_page_template($template_include, $taxonomy, $filename)
    {
        $taxonomy_template = "{$this->pluginDir}Taxonomies/Taxonomy-{$taxonomy['name']}.php";

        if (file_exists($taxonomy_template)) {
            $filename_css = "{$this->cssDir}{$filename}.css";
            $filename_js = "{$this->jsDir}{$filename}.js";

            if (file_exists($filename_css)) {
                add_action('wp_head', function () use ($filename) {
                    $this->css->load_pages_css($filename);
                });
            }

            if (file_exists($filename_js)) {
                add_action('wp_footer', function () use ($filename) {
                    $this->js->load_pages_react($filename);
                });
            }

            return $taxonomy_template;
        } else {
            error_log('Taxonomy Page Template does not exist.');
        }

        return $template_include;
    }

    function get_archive_page_template($archive_template, $post_type)
    {
        if (is_post_type_archive($post_type['name'])) {
            $archive_template = "{$this->pluginDir}Post_Types/{$post_type['dir']}/archive-{$post_type['slug']}.php";

            if (file_exists($archive_template)) {
                $filename = $post_type['archive_page'];
                $filename_css = "{$this->cssDir}{$filename}.css";
                $filename_js = "{$this->jsDir}{$filename}.js";

                if (file_exists($filename_css)) {
                    add_action('wp_head', function () use ($filename) {
                        $this->css->load_pages_css($filename);
                    });
                }

                if (file_exists($filename_js)) {
                    add_action('wp_footer', function () use ($filename) {
                        $this->js->load_pages_react($filename);
                    });
                }

                return $archive_template;
            } else {
                error_log('Archive Page Template does not exist.');
            }
        }

        return $archive_template;
    }

    function get_single_page_template($single_template, $post_type)
    {
        if (is_singular($post_type['name'])) {
            $single_template = "{$this->pluginDir}Post_Types/{$post_type['dir']}/single-{$post_type['slug']}.php";

            if (file_exists($single_template)) {
                $filename = $post_type['single_page'];
                $filename_css = "{$this->cssDir}{$filename}.css";
                $filename_js = "{$this->jsDir}{$filename}.js";

                if (file_exists($filename_css)) {
                    add_action('wp_head', function () use ($filename) {
                        $this->css->load_pages_css($filename);
                    });
                }

                if (file_exists($filename_js)) {
                    add_action('wp_footer', function () use ($filename) {
                        $this->js->load_pages_react($filename);
                    });
                }

                return $single_template;
            } else {
                error_log("{$post_type['name']} Single Page Template does not exist.");
            }
        }

        return $single_template;
    }
}

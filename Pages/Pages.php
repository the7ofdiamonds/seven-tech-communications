<?php

namespace SEVEN_TECH\Communications\Pages;

class Pages
{
    public $front_page_react;
    public $custom_pages;
    public $protected_pages;
    public $pages_list;
    public $pages;

    public function __construct()
    {
        $this->front_page_react = [
            'About',
        ];

        $this->custom_pages = [
            [
                'regex' => '#^/about#',
                'file_name' => 'About',
                'page_name' => 'about'
            ],
            [
                'regex' => '#^/([a-zA-Z-]+)/([a-zA-Z-]+)/resume#',
                'page_name' => 'resume',
            ]
        ];

        $this->protected_pages = [];

        $this->pages = [
            [
                'url' => 'contact',
                'regex' => '#^/contact#',
                'file_name' => 'Contact',
            ],
            [
                'url' => 'faq',
                'regex' => '#^/faq#',
                'file_name' => 'FAQ',
            ],
            [
                'url' => 'support',
                'regex' => '#^/support#',
                'file_name' => 'Support',
            ],
            [
                'url' => 'skills',
                'regex' => '#^/skills#',
                'file_name' => 'Skills',
            ]
        ];

        $this->pages_list = [
            [
                'title' => 'ABOUT',
            ],
            [
                'title' => 'CONTACT',
            ],
            [
                'title' => 'FAQ',
            ],
            [
                'title' => 'SUPPORT',
            ]
        ];
    }

    function add_pages()
    {
        if (!empty($this->pages_list)) {
            global $wpdb;

            foreach ($this->pages_list as $page) {
                if (!empty($page['title'])) {
                    $page_exists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type = 'page'", $page['title']));

                    if (!$page_exists) {
                        $page_data = array(
                            'post_title'   => $page['title'],
                            'post_type'    => 'page',
                            'post_content' => '',
                            'post_status'  => 'publish',
                        );

                        wp_insert_post($page_data);

                        error_log($page['title'] . ' page added.');
                    }
                }
            }
        }
    }

    function is_user_logged_in()
    {
        return isset($_SESSION['idToken']);
    }
}

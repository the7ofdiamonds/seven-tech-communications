<?php

namespace SEVEN_TECH\Communications\Post_Types;

use  WP_Query;

class Post_Types
{
    public $post_types_list;

    public function __construct()
    {
        $this->post_types_list = [
            [
                'name' => 'founders',
                'menu_icon' => '',
                'menu_position' => 11,
                'title' => 'FOUNDERS',
                'singular' => 'Founder',
                'plural' => 'Founders',
                'archive_page' => 'founders',
                'single_page' => 'founder',
                'file_name' => "Founders",
                'slug' => 'founders',
                'dir' => 'Founders'
            ],
            [
                'name' => 'team',
                'menu_icon' => '',
                'menu_position' => 12,
                'title' => 'TEAM',
                'singular' => 'Team Member',
                'plural' => 'Team',
                'archive_page' => 'Team',
                'single_page' => 'Team-Member',
                'file_name' => "Team",
                'slug' => 'team',
                'dir' => 'Team'
            ],
        ];
    }

    function customPostTypes()
    {
        if (is_array($this->post_types_list)) {
            foreach ($this->post_types_list as $post_type) {
                $labels = array(
                    'name' => $post_type['title'],
                    'singular_name' => $post_type['singular'],
                    'add_new' => 'Add ' . $post_type['singular'],
                    'all_items' => $post_type['plural'],
                    'add_new_item' => 'Add New ' . $post_type['singular'],
                    'edit_item' => 'Edit ' . $post_type['singular'],
                    'new_item' => 'New ' . $post_type['singular'],
                    'view_item' => 'View ' . $post_type['singular'],
                    'search_item' => 'Search ' . $post_type['plural'],
                    'not_found' => 'No ' . $post_type['plural'] . ' were Found',
                    'not_found_in_trash' => 'No ' . $post_type['singular'] . ' found in trash',
                    'parent_item_colon' => 'Parent ' . $post_type['singular']
                );

                $args = array(
                    'labels' => $labels,
                    'show_ui' => true,
                    'menu_icon' => $post_type['menu_icon'],
                    'show_in_rest' => true,
                    'show_in_nav_menus' => true,
                    'public' => true,
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'rewrite' => array(
                        'with_front' => false,
                        'slug'       => $post_type['slug']
                    ),
                    'hierarchical' => true,
                    'supports' => [
                        'title',
                        'editor',
                        'excerpt',
                        'thumbnail',
                        'custom-fields',
                        'revisions',
                        'page-attributes',
                    ],
                    'taxonomies' => array('category', 'post_tag'),
                    'menu_position' => $post_type['menu_position'],
                    'exclude_from_search' => false
                );

                register_post_type($post_type['name'], $args);
            }
        }
    }

    function getPostTypeWithTerm($post_type, $taxonomy, $term)
    {
        $args = array(
            'post_type' => $post_type,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $term
                )
            ),
        );

        $query = new WP_Query($args);
        $posts = $query->posts;

        if (empty($posts)) {
            return '';
        }

        return $posts;
    }
}

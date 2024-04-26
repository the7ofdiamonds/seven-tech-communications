<?php

namespace SEVEN_TECH\Communications\Post_Types;

use  WP_Query;

use SEVEN_TECH\Communications\Role\Role;

class Post_Types
{
    public $post_types_list;
    private $pluginDir;
    private $role;
    private $roleNames;

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

        $this->pluginDir = SEVEN_TECH_COMMUNICATIONS;
        $this->role = new role;
        $this->roleNames = (new Role)->getRoleNames();
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

    function addRolePages()
    {
        $args = [
            'role__in' => $this->roleNames
        ];
        $users = get_users($args);

        if (!is_array($users)) {
            return '';
        }

        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if ($user_data == false) {
                continue;
            }

            $first_name = $user_data->first_name;
            $last_name = $user_data->last_name;

            $post_title = $first_name . ' ' . $last_name;
            $post_slug = $user_data->nicename;

            if (empty($post_slug)) {
                $post_slug = preg_replace('/[^a-zA-Z]/', "", $post_title);
            }

            $roles = $this->role->getOrderedRoles($user_data->roles);
            $slug = $this->role->getRoleSlug($roles[0]);

            if ($slug == '') {
                continue;
            }

            $postType = '';

            foreach ($this->post_types_list as $post_type) {
                if ($post_type['slug'] == $slug) {
                    $postType = $post_type['name'];
                    break;
                }
            }

            if ($postType == '') {
                continue;
            }

            $args = array(
                'post_author'   => $user->ID,
                'post_title'    => $post_title,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => $postType,
                'post_name'     => $post_slug,
            );

            $query = new WP_Query($args);

            $existing_post = $query->posts;

            if (!empty($existing_post)) {
                continue;
            }

            $role_page = wp_insert_post($args);

            if (!is_int($role_page)) {
                error_log('There was an error creating team member page.');
                continue;
            }
        }
    }

    function checkRegisteredPostTypes()
    {
        if (is_array($this->post_types_list)) {
            foreach ($this->post_types_list as $post_type) {
                $archive_template = "{$this->pluginDir}Post_Types/{$post_type['dir']}/archive-{$post_type['name']}.php";
                $single_template = "{$this->pluginDir}Post_Types/{$post_type['dir']}/single-{$post_type['name']}.php";

                if (!file_exists($archive_template)) {
                    error_log("{$post_type['name']} Archive Page needs to be created at {$archive_template}");
                    continue;
                }

                if (!file_exists($single_template)) {
                    error_log("{$post_type['name']} Single Page needs to be created at {$single_template}");
                    continue;
                }
            }
        }
    }
}

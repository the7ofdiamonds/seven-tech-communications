<?php

namespace SEVEN_TECH\Post_Types\Founders;

use Exception;

class Founders
{
    public function __construct()
    {
    }

    function extractNameFromString($inputString)
    {
        // Use a regular expression to remove non-alphabetic characters
        $nameOnly = preg_replace('/[^A-Za-z]/', '', $inputString);

        // Convert the result to lowercase
        $lowercaseName = strtolower($nameOnly);

        return $lowercaseName;
    }

    function add_founder_pages()
    {
        try {
            $users = get_users(array(
                'role__in' => array(
                    'founder',
                )
            ));

            if (!empty($users)) {
                foreach ($users as $user) {
                    $user_data = get_userdata($user->ID);
                    $first_name = $user_data->first_name;
                    $last_name = $user_data->last_name;

                    // Extract a cleaned and lowercase name
                    $post_title = $first_name . ' ' . $last_name;
                    $post_slug = strtolower(preg_replace('/[^a-zA-Z]/', '', $post_title)); // Remove non-letter characters

                    // Check if a post with this slug already exists
                    $existing_post = get_page_by_path($post_slug, OBJECT, 'founders');

                    if (is_null($existing_post)) {
                        // Create a new team member page
                        $args = array(
                            'post_title'    => $post_title,
                            'post_content'  => '',
                            'post_status'   => 'publish',
                            'post_type'     => 'founders',
                            'post_name'     => $post_slug, // Set the post name to the slug
                        );

                        $team_member_page = wp_insert_post($args);

                        if (!is_wp_error($team_member_page)) {
                            // Success
                        } else {
                            throw new Exception("Failed to create team member page: " . $team_member_page->get_error_message(), $team_member_page->get_error_code());
                        }
                    } else {
                        // A post with the same slug already exists, skip creation.
                    }
                }
            } else {
                throw new Exception("No Founders found.", 404);
            }
        } catch (Exception $e) {
            error_log(("Error: " . $e->getMessage())); // Log the error message
        }
    }

    function getFoundersList()
    {
        try {
            $founders = [];
            $users = get_users([
                'role__in' => [
                    'founder'
                ]
            ]);

            if (is_array($users)) {
                foreach ($users as $user) {
                    $user_data = get_userdata($user->ID);

                    if (empty($user_data->user_url)) {
                        $founder = array(
                            'id' => $user_data->ID,
                            'first_name' => $user_data->first_name,
                            'last_name' => $user_data->last_name,
                        );

                        $founders[] = $founder;
                    }
                }

                return $founders;
            } else {
                throw new Exception("No Founders at this time.", 404);
            }
        } catch (Exception $e) {
            error_log($e);
            return $e;
        }
    }

    function getFounders()
    {
        $founders = [];
        $users = get_users([
            'role__in' => [
                'founder'
            ]
        ]);

        if ($users) {
            foreach ($users as $user) {
                $user_data = get_userdata($user->ID);

                if (!empty($user_data->user_url)) {
                    $founder = array(
                        'id' => $user_data->ID,
                        'first_name' => $user_data->first_name,
                        'last_name' => $user_data->last_name,
                        'email' => $user_data->user_email,
                        'role' => $user_data->roles,
                        'author_url' => $user_data->user_url,
                        'avatar_url' => get_avatar_url($user_data->ID, ['size' => 384])
                    );

                    $founders[] = $founder;
                }
            }

            return $founders;
        } else {
            throw new Exception("No Founders at this time.", 404);
        }
    }

    function getFounderSkills($post_id)
    {
        if ($post_id) {
            $taxonomies = get_post_taxonomies($post_id);
            $skills = [];

            foreach ($taxonomies as $taxonomy) {
                $terms = get_the_terms($post_id, $taxonomy);

                if ($terms && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $skills[] = $term;
                    }
                }
            }

            return $skills;
        }
    }

    function getFounderSocialNetworks($post_id)
    {
        $github_link = get_post_meta($post_id, 'github_link', true);
        $linkedin_link = get_post_meta($post_id, 'linkedin_link', true);
        $facebook_link = get_post_meta($post_id, 'facebook_link', true);
        $instagram_link = get_post_meta($post_id, 'instagram_link', true);
        $x_link = get_post_meta($post_id, 'x_link', true);
        $hacker_rank_link = get_post_meta($post_id, 'hacker_rank_link', true);

        $social_networks = [
            [
                'name' => 'GitHub',
                'icon' => 'github',
                'link' => $github_link
            ],
            [
                'name' => 'LinkedIn',
                'icon' => 'linkedin',
                'link' => $linkedin_link
            ],
            [
                'name' => 'Facebook',
                'icon' => 'facebook',
                'link' => $facebook_link
            ],
            [
                'name' => 'Instagram',
                'icon' => 'instagram',
                'link' => $instagram_link
            ],
            [
                'name' => 'X',
                'icon' => 'x-twitter',
                'link' => $x_link
            ],
            [
                'name' => 'Hacker Rank',
                'icon' => 'hackerrank',
                'link' => $hacker_rank_link
            ],
        ];

        return $social_networks;
    }

    function getFounder($slug)
    {
        $post_type = 'founders';
        $post = get_page_by_path($slug, OBJECT, $post_type);
        $user = get_user_by('ID', $post->post_author);

        if ($user) {
            $user_data = get_userdata($user->ID);

            $founder = array(
                'id' => $user_data->ID,
                'fullName' => $user_data->first_name . ' ' . $user_data->last_name,
                'email' => $user_data->user_email,
                'title' => $user_data->roles,
                'greeting' => get_the_author_meta('description', 1),
                'author_url' => $user_data->user_url,
                'avatar_url' => get_avatar_url($user_data->ID, ['size' => 384]),
                'skills' => $this->getFounderSkills($post->ID),
                'social_networks' => $this->getFounderSocialNetworks($post->ID),
                'founder_resume' => get_post_meta($post->ID, 'founder_resume', true)
            );

            return $founder;
        } else {
            throw new Exception("No Founders found.", 404);
        }
    }
}

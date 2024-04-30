<?php

namespace SEVEN_TECH\Communications\Taxonomies;

use Exception;

use SEVEN_TECH\Communications\Media\Media;

class Taxonomies
{
    public $taxonomies_list;
    private $media;

    public function __construct()
    {
        $post_types = ['portfolio', 'founders'];

        $this->taxonomies_list = [
            [
                'name' => 'Skills',
                'singular' => 'Skill',
                'plural' => 'Skills',
                'slug' => 'skills',
                'menu_position' => 3,
                'post_types' => $post_types
            ],
            [
                'name' => 'Frameworks',
                'singular' => 'Framework',
                'plural' => 'Frameworks',
                'slug' => 'frameworks',
                'menu_position' => 3,
                'post_types' => $post_types
            ],
            [
                'name' => 'Technologies',
                'singular' => 'Technology',
                'plural' => 'Technologies',
                'slug' => 'technologies',
                'menu_position' => 3,
                'post_types' => $post_types
            ]
        ];

        $this->media = new Media;
    }

    function customTaxonomy()
    {
        if (is_array($this->taxonomies_list)) {
            foreach ($this->taxonomies_list as $taxonomy) {
                $labels = array(
                    'name' => $taxonomy['name'],
                    'singular_name' => $taxonomy['singular'],
                    'search_items' => 'Search ' . $taxonomy['plural'],
                    'add_new_item' => 'Add ' . $taxonomy['singular'],
                    'all_items' => 'All ' . $taxonomy['plural'],
                    'new_item_name' => $taxonomy['singular'] . ' Name',
                    'not_found' => $taxonomy['singular'] . ' Not Found',
                    'not_found_in_trash' => 'No ' . $taxonomy['plural'] . ' found in trash',
                    'parent_item' => null,
                    'parent_item_colon' => null,
                    'edit_item' => 'Edit ' . $taxonomy['singular'],
                    'update_item' => 'Update ' . $taxonomy['singular'],
                    'add_new_item' => 'Add New ' . $taxonomy['singular'],
                    'add_or_remove_items' => 'Add or remove ' . $taxonomy['plural'],
                    'choose_from_most_used' => 'Choose from most used ' . $taxonomy['plural']
                );

                $args = array(
                    'hierarchical' => false,
                    'labels' => $labels,
                    'show_ui' => true,
                    'show_in_rest' => true,
                    'show_in_nav_menus' => true,
                    'public' => true,
                    'has_archive' => true,
                    'publicly_queryable' => true,
                    'query_var' => true,
                    'rewrite' => array(
                        'with_front' => false,
                        'slug' => $taxonomy['slug']
                    ),
                    'menu_position' => $taxonomy['menu_position'],
                    'exclude_from_search' => false,
                    'show_admin_column' => true,
                    'update_count_callback' => '_update_post_term_count',
                );

                register_taxonomy($taxonomy['name'], $taxonomy['post_types'], $args);
            }

            new Skills;
            new Frameworks;
            new Technologies;
        }
    }

    function getTaxonomyPostTypes($taxonomy)
    {
        try {

            if (is_array($this->taxonomies_list)) {
                $postTypes = [];

                foreach ($this->taxonomies_list as $item) {
                    if ($item['name'] === $taxonomy) {
                        $postTypes = $item['post_types'];
                        break;
                    }
                }

                return $postTypes;
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at getTaxonomyPostTypes');
            return $response;
        }
    }

    function getPostTypeTaxonomies($post_type, $taxonomy)
    {
        try {
            if (empty($post_type)) {
                throw new Exception('Post ID is required.', 400);
            }

            if (empty($taxonomy)) {
                throw new Exception('Taxonomy is required.', 400);
            }

            $taxonomies = get_object_taxonomies($post_type, 'objects');

            $taxonomy_data = [];

            foreach ($taxonomies as $tax) {
                $terms = get_terms([
                    'taxonomy'   => $tax->name,
                    'hide_empty' => false,
                ]);

                if ($tax->name === $taxonomy) {
                    foreach ($terms as $term) {
                        $faIcon = get_term_meta($term->term_id, 'fa_icon', true);
                        $iconURL = get_term_meta($term->term_id, 'icon_url', true);

                        $term_link = get_term_link($term);

                        $taxonomy_data[] = [
                            'id' => $term->term_id,
                            'title' => $term->name,
                            'icon' => [
                                'name' => $term->name,
                                'description' => $term->description,
                                'fa_icon' => $faIcon,
                                'icon_url' => $this->media->getURL('icons', $iconURL)
                            ],
                            'url' => $term_link
                        ];
                    }
                }
            }

            return $taxonomy_data;
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at getPostTypeTaxonomies');
            return $response;
        }
    }

    function getPostTaxonomy($post_id, $taxonomy)
    {
        try {
            if (empty($post_id)) {
                throw new Exception('Post ID is required to get Taxonomy.', 400);
            }

            $terms = get_the_terms($post_id, $taxonomy);

            if (!is_array($terms) || $terms == false || is_wp_error($terms)) {
                return '';
            }

            foreach ($terms as $term) {
                $faIcon = get_term_meta($term->term_id, 'fa_icon', true);
                $iconURL = get_term_meta($term->term_id, 'icon_url', true);

                $skills[] = [
                    'id' => $term->term_id,
                    'name' => $term->name,
                    'slug' => $term->slug,
                    'fa_icon' => $faIcon,
                    'icon_url' => $this->media->getURL('icons', $iconURL),
                    'url' => "/skills/{$term->slug}"
                ];
            }

            return $skills;
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at getPostTaxonomies');
            return $response;
        }
    }

    function getTaxonomyTerm($slug, $taxonomy)
    {
        try {
            $term = get_term_by('slug', $slug, $taxonomy);

            if ($term == false) {
                return '';
            }

            $faIcon = get_term_meta($term->term_id, 'fa_icon', true);
            $iconURL = get_term_meta($term->term_id, 'icon_url', true);

            $term_link = get_term_link($term);

            $taxTerm = [
                'id' => $term->term_id,
                'title' => $term->name,
                'description' => $term->description,
                'icon' => [
                    'name' => $term->name,
                    'fa_icon' => $faIcon,
                    'icon_url' => $this->media->getURL('icons', $iconURL)
                ],
                'url' => $term_link
            ];

            return $taxTerm;
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();
            $response = $errorMessage . ' ' . $errorCode;

            error_log($response . ' at getTaxonomyTerm');
            return $response;
        }
    }
}

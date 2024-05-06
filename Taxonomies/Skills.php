<?php

namespace SEVEN_TECH\Communications\Taxonomies;

use Exception;

use SEVEN_TECH\Communications\Post_Types\Post_Types;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;

class Skills
{
    private $taxonomy;
    private $taxonomies;
    private $postTypes;
    private $post_types;

    public function __construct()
    {
        $this->taxonomy = 'Skills';

        add_filter("manage_edit-{$this->taxonomy}_columns", [$this, 'edit_columns']);
        add_action("manage_{$this->taxonomy}_custom_column", [$this, 'manage_columns'], 10, 3);
        add_action("{$this->taxonomy}_add_form_fields", [$this, 'add_fields']);
        add_action("{$this->taxonomy}_edit_form_fields", [$this, 'edit_fields'], 10, 2);
        add_action("created_{$this->taxonomy}", [$this, 'save_fields']);
        add_action("edited_{$this->taxonomy}", [$this, 'save_fields']);

        $this->taxonomies = new Taxonomies;
        $this->postTypes = $this->taxonomies->getTaxonomyPostTypes($this->taxonomy);
        $this->post_types = new Post_Types;
    }

    function edit_columns($columns)
    {
        if (!empty($columns)) {
            $columns['fa_icon'] = 'FA Icon';
            $columns['icon_url'] = 'Icon URL';
        }

        return $columns;
    }

    function manage_columns($content, $column_name, $term_id)
    {
        switch ($column_name) {
            case 'fa_icon':
                $fa_icon = get_term_meta($term_id, 'fa_icon', true);
                echo esc_html($fa_icon);
                break;
            case 'icon_url':
                $icon_url = get_term_meta($term_id, 'icon_url', true);
                echo esc_url($icon_url);
                break;
        }
    }

    function add_fields()
    {
?>
        <div class="form-field">
            <label for="fa_icon">Font Awesome Icon</label>
            <input type="text" name="fa_icon" id="fa_icon">
            <p>Add Font Awesome Icon</p>
        </div>

        <div class="form-field">
            <label for="icon_url">Icon URL</label>
            <input type="text" name="icon_url" id="icon_url">
            <p>Add Icon URL</p>
        </div>
    <?php
    }

    function edit_fields($term, $taxonomy)
    {
        $faIcon = get_term_meta($term->term_id, 'fa_icon', true);
        $iconURL = get_term_meta($term->term_id, 'icon_url', true);
    ?>
        <tr class="form-field">
            <th scope="row"> <label for="fa_icon">Font Awesome Icon</label></th>
            <td><input type="text" name="fa_icon" id="fa_icon" value="<?php echo esc_attr($faIcon); ?>">
                <p class="description">Add Font Awesome Icon.</p>
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row"><label for="icon_url">Icon URL</label></th>
            <td><input type="text" name="icon_url" id="icon_url" value="<?php echo esc_attr($iconURL); ?>" size="40">
                <p class="description">Add Icon URL</p>
            </td>
        </tr>
<?php
    }

    function save_fields($term_id)
    {
        if (isset($_POST['fa_icon'])) {
            update_term_meta($term_id, 'fa_icon', sanitize_text_field($_POST['fa_icon']));
        }

        if (isset($_POST['icon_url'])) {
            update_term_meta($term_id, 'icon_url', sanitize_text_field($_POST['icon_url']));
        }
    }

    function getSkill($slug)
    {
        if (empty($slug)) {
            throw new Exception('Slug is required to get Skills.', 400);
        }

        return $this->taxonomies->getTaxonomyTerm($slug, $this->taxonomy);
    }

    function getSkills($postType)
    {
        return $this->taxonomies->getPostTypeTaxonomies($postType, $this->taxonomy);
    }

    function getPostSkills($post_id)
    {
        if (empty($post_id)) {
            throw new Exception('Post ID is required to get Skills.', 400);
        }

        return $this->taxonomies->getPostTaxonomy($post_id, $this->taxonomy);
    }

    function getPostSkillsBySlug($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->postTypes);

        if (empty($post)) {
            return '';
        }

        return $this->getPostSkills($post->ID);
    }

    function getPostTypesWithSkill($postType, $term){
        error_log($term);
        $this->post_types->getPostTypeWithTerm($postType, $this->taxonomy, $term);
    }

    function getPostTypesWithSkills($postType){
        return $this->post_types->getPostTypeWithTaxonomy($postType, $this->taxonomy);
    }
}

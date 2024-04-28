<?php

namespace SEVEN_TECH\Communications\Taxonomies;

use Exception;

use SEVEN_TECH\Communications\Media\Media;
use SEVEN_TECH\Communications\Taxonomies\Taxonomies;

class Skills
{
    private $media;
    private $post_types;
    private $taxonomies;

    public function __construct()
    {
        $this->media = new Media;
        $this->post_types = ['founders'];

        add_filter('manage_edit-Skills_columns', [$this, 'edit_columns']);
        add_action('manage_Skills_custom_column', [$this, 'manage_columns'], 10, 3);
        add_action('Skills_add_form_fields', [$this, 'add_fields']);
        add_action('Skills_edit_form_fields', [$this, 'edit_fields'], 10, 2);
        add_action('created_Skills', [$this, 'save_fields']);
        add_action('edited_Skills', [$this, 'save_fields']);

        $this->taxonomies = new Taxonomies;
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

    function getSkills()
    {
        // Could be other post types
        return $this->taxonomies->get_post_type_taxonomy('founders', 'Skills');
    }

    function getPostSkills($post_id)
    {
        if (empty($post_id)) {
            throw new Exception('Post ID is required to get skills.', 400);
        }

        $taxonomies = get_post_taxonomies($post_id);

        if (!is_array($taxonomies)) {
            return '';
        }

        $skills = [];

        foreach ($taxonomies as $taxonomy) {
            $terms = get_the_terms($post_id, $taxonomy);

            if (!is_array($terms) || $terms == false || is_wp_error($terms)) {
                continue;
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
        }

        return $skills;
    }

    function getPostSkillsBySlug($slug)
    {
        $post = get_page_by_path($slug, OBJECT, $this->post_types);

        if (empty($post)) {
            return '';
        }

        return $this->getPostSkills($post->ID);
    }
}

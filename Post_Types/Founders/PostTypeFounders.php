<?php

namespace SEVEN_TECH\Post_Types\Founders;

use Exception;

use SEVEN_TECH\Media\Media;

/**
 * @package SEVEN TECH
 */

class PostTypeFounders
{
    private $admin;
    private $founders;
    private $post_id;
    private $founder_user_id;
    private $user_data;
    private $current_user;

    public function __construct()
    {
        $this->current_user = wp_get_current_user();
        $this->admin = $this->current_user->has_cap('administrator');

        add_action('load-post-new.php', [$this, 'show_founder_select']);
        add_action('load-post.php', [$this, 'get_founder']);

        add_action('add_meta_boxes', [$this, 'add_post_meta_boxes']);

        add_action('save_post', [$this, 'save_post_founder_user_id']);
        add_action('save_post', [$this, 'save_post_github_link']);
        add_action('save_post', [$this, 'save_post_linkedin_link']);
        add_action('save_post', [$this, 'save_post_facebook_link']);
        add_action('save_post', [$this, 'save_post_instagram_link']);
        add_action('save_post', [$this, 'save_post_x_link']);
        add_action('save_post', [$this, 'save_post_hacker_rank_link']);
        add_action('save_post', [$this, 'save_post_resume']);
    }

    function user_has_role($role, $user_id)
    {
        $user = get_userdata($user_id);
        $roles = $user->roles;
        error_log(print_r($user));
        if (in_array($role, $roles, true)) {
            return true;
        } else {
            return false;
        }
    }

    function show_founder_select()
    {
        $this->founders = (new Founders)->getFoundersList();

        if (is_array($this->founders) && !empty($this->founders)) {
            $this->founder_user_id = $this->founders[0]['id'];

            add_meta_box(
                "post_metadata_founder_select",
                "Founder Select",
                [$this, 'post_meta_box_founder_select'],
                "founders",
                "side",
                "low"
            );
    
            return $this->user_data = get_userdata($this->founder_user_id);
        } else {
            return;
        }
    }

    function get_founder()
    {
        if (!empty($_GET['post'])) {
            $this->post_id = absint($_GET['post']);

            if ($this->post_id) {
                $this->founder_user_id = get_post_meta($this->post_id, 'founder_user_id', true);
                $this->user_data = get_userdata($this->founder_user_id);
            }
        }
    }

    function add_post_meta_boxes()
    {
        add_meta_box(
            "post_metadata_founder_info",
            "Founder Info",
            [$this, 'post_meta_box_founder_info'],
            "founders",
            "side",
            "low"
        );

        add_meta_box(
            "post_metadata_github_link",
            "GitHub Link",
            [$this, 'post_meta_box_github_link'],
            "founders",
            "normal",
            "low"
        );

        add_meta_box(
            "post_metadata_linkedin_link",
            "LinkedIn Link",
            [$this, 'post_meta_box_linkedin_link'],
            "founders",
            "normal",
            "low"
        );

        add_meta_box(
            "post_metadata_facebook_link",
            "Facebook Link",
            [$this, 'post_meta_box_facebook_link'],
            "founders",
            "normal",
            "low"
        );

        add_meta_box(
            "post_metadata_instagram_link",
            "Instagram Link",
            [$this, 'post_meta_box_instagram_link'],
            "founders",
            "normal",
            "low"
        );

        add_meta_box(
            "post_metadata_x_link",
            "Instagram Link",
            [$this, 'post_meta_box_x_link'],
            "founders",
            "normal",
            "low"
        );

        add_meta_box(
            "post_metadata_hacker_rank_link",
            "Hacker Rank Link",
            [$this, 'post_meta_box_hacker_rank_link'],
            "founders",
            "normal",
            "low"
        );

        add_meta_box(
            'post_metadata_resume',
            'Founder Resume',
            [$this, 'post_meta_box_resume'],
            'founders',
            'normal',
            'low'
        );
    }

    function post_meta_box_founder_select()
    {
        if ($this->admin) {
?>
            <select name="founder_select">
                <?php
                foreach ($this->founders as $founder) {
                ?>
                    <option value="<?php echo esc_attr($founder['id']); ?>">
                        <?php echo $founder['first_name'] . ' ' . $founder['last_name']; ?>
                    </option>
                <?php
                }
                ?>
            </select>
        <?php
        }
    }

    function post_meta_box_founder_info()
    {
        $avatar_url = get_avatar_url($this->user_data->ID, ['size' => 384]);
        $first_name = $this->user_data->first_name;
        $last_name = $this->user_data->last_name;
        $email = $this->user_data->user_email;
        $roles = $this->user_data->roles;
        ?>
        <div>
            <div>
                <img src="<?php echo $avatar_url; ?>" alt="">
            </div>
            <div>
                <p><?php echo $first_name . ' ' . $last_name; ?></p>
            </div>
            <div>
                <h4>Roles</h4>
                <?php
                foreach ($roles as $role) {
                    echo $role;
                }
                ?>
            </div>
            <div>
                <h4>Email:</h4><?php echo $email; ?>
            </div>
        </div>
    <?php
    }

    function post_meta_box_github_link()
    {
        $custom = get_post_custom($this->post_id);
        $field = isset($custom["github_link"][0]) ? esc_url($custom["github_link"][0]) : '';

        echo '<input type="text" name="github_link" value="' . $field . '" placeholder="GitHub Link">';
    }

    function post_meta_box_linkedin_link()
    {
        $custom = get_post_custom($this->post_id);
        $field = isset($custom["linkedin_link"][0]) ? esc_url($custom["linkedin_link"][0]) : '';

        echo '<input type="text" name="linkedin_link" value="' . $field . '" placeholder="LinkedIn Link">';
    }

    function post_meta_box_facebook_link()
    {
        $custom = get_post_custom($this->post_id);
        $field = isset($custom["facebook_link"][0]) ? esc_url($custom["facebook_link"][0]) : '';

        echo '<input type="text" name="facebook_link" value="' . $field . '" placeholder="Facebook Link">';
    }

    function post_meta_box_instagram_link()
    {
        $custom = get_post_custom($this->post_id);
        $field = isset($custom["instagram_link"][0]) ? esc_url($custom["instagram_link"][0]) : '';

        echo '<input type="text" name="instagram_link" value="' . $field . '" placeholder="Instagram Link">';
    }

    function post_meta_box_x_link()
    {
        $custom = get_post_custom($this->post_id);
        $field = isset($custom["x_link"][0]) ? esc_url($custom["x_link"][0]) : '';

        echo "<input type=\"text\" name=\"x_link\" value=\"" . $field . "\" placeholder=\"x Link\">";
    }

    function post_meta_box_hacker_rank_link()
    {
        $custom = get_post_custom($this->post_id);
        $field = isset($custom["hacker_rank_link"][0]) ? esc_url($custom["hacker_rank_link"][0]) : '';

        echo "<input type=\"text\" name=\"hacker_rank_link\" value=\"" . $field . "\" placeholder=\"Hacker Rank Link\">";
    }

    function post_meta_box_resume()
    {
        $custom = get_post_custom($this->post_id);
        $resume_url = isset($custom['founder_resume'][0]) ? esc_url($custom['founder_resume'][0]) : '';
    ?>
        <label for="founder_resume">Upload Founder Resume (PDF):</label>
        <input type="file" id="founder_resume" name="founder_resume" accept=".pdf">
<?php
        if ($resume_url) {
            echo '<p>Current Resume: <a href="' . $resume_url . '" target="_blank">' . $resume_url . '</a></p>';
        }
    }

    function save_post_founder_user_id()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        update_post_meta($this->post_id, "founder_user_id", sanitize_text_field($this->founder_user_id));
    }

    function save_post_github_link()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $github_link = isset($_POST["github_link"]) ? sanitize_text_field($_POST["github_link"]) : '';
        update_post_meta($this->post_id, "github_link", $github_link);
    }

    function save_post_linkedin_link()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $linkedin_link = isset($_POST["linkedin_link"]) ? sanitize_text_field($_POST["linkedin_link"]) : '';
        update_post_meta($this->post_id, "linkedin_link", sanitize_text_field($linkedin_link));
    }

    function save_post_facebook_link()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $facebook_link = isset($_POST["facebook_link"]) ? sanitize_text_field($_POST["facebook_link"]) : '';
        update_post_meta($this->post_id, "facebook_link", sanitize_text_field($facebook_link));
    }

    function save_post_instagram_link()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $instagram_link = isset($_POST["instagram_link"]) ? sanitize_text_field($_POST["instagram_link"]) : '';
        update_post_meta($this->post_id, "instagram_link", sanitize_text_field($instagram_link));
    }

    function save_post_x_link()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $x_link = isset($_POST["x_link"]) ? sanitize_text_field($_POST["x_link"]) : '';
        update_post_meta($this->post_id, "x_link", sanitize_text_field($x_link));
    }

    function save_post_hacker_rank_link()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $hacker_rank_link = isset($_POST["hacker_rank_link"]) ? sanitize_text_field($_POST["hacker_rank_link"]) : '';
        update_post_meta($this->post_id, "hacker_rank_link", sanitize_text_field($hacker_rank_link));
    }

    function save_post_resume($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_FILES['founder_resume']['tmp_name']) && !empty($_FILES['founder_resume']['tmp_name'])) {
            $pdf_subdir = '/resume';
            $file = $_FILES['founder_resume'];
            $filename = '/Resume_' . $post_id . '.pdf';

            $founder_resume_url = (new Media)->upload($pdf_subdir, $file, $filename);

            update_post_meta($post_id, 'founder_resume', esc_url($founder_resume_url));
        }
    }
}

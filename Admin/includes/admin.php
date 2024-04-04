<?php
require_once SEVEN_TECH_COMMUNICATIONS . 'Admin/Admin.php';

use SEVEN_TECH\Communications\Admin\Admin;

$admin_communication = new Admin();

global $wpdb;
$table_name = 'orb_communication_types';
$nonce_action = 'handle_communication_form_submission';

if (isset($_POST)) {
    $admin_communication->handle_communication_form_submission($_POST);
}

settings_errors();
?>

<section class="orb-services-admin">
    <?php settings_errors(); ?>
    <form method="post" action="/wp-admin/admin.php?page=seven-tech-communications">
        <?php settings_fields('seven-tech-communications-types-group'); ?>
        <?php do_settings_sections('seven-tech-communications'); ?>
        <?php submit_button(); ?>
    </form>
</section>

<script>
    jQuery(document).ready(function($) {
        $('.remove-button').on('click', function() {
            var typeToRemove = $(this).data('type');
            var confirmation = confirm('Are you sure you want to remove this communication type?');

            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'remove_communication_type',
                        communication_type: typeToRemove,
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
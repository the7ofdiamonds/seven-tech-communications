<section class="orb-services-admin">
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php settings_fields('seven-tech-communications-email-group'); ?>
        <?php do_settings_sections('seven-tech-email-settings'); ?>
        <?php submit_button(); ?>
    </form>
</section>
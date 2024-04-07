<?php
$facebook = esc_attr(get_option('facebook_link'));
$twitter = esc_attr(get_option('twitter_link'));
$contact_email = esc_attr(get_option('contact_email'));
$linkedin = esc_attr(get_option('linkedin_link'));
$instagram = esc_attr(get_option('instagram_link'));
?>

<div class="social-bar">
    <a href="<?php print $facebook ?>" target="_blank">
        <i class="fa fa-facebook fa-fw"></i>
    </a>

    <a href="<?php print $twitter ?>" target="_blank">
        <i class="fa fa-twitter fa-fw"></i>
    </a>

    <a href="mailto:<?php print $contact_email ?>" target="_blank">
        <i class="fa fa-envelope fa-fw"></i>
    </a>

    <a href="<?php print $linkedin ?>" target="_blank">
        <i class="fa fa-linkedin fa-fw"></i>
    </a>

    <a href="<?php print $instagram ?>" target="_blank">
        <i class="fa fa-instagram fa-fw"></i>
    </a>
</div>
<?php

namespace SEVEN_TECH\Communications\CSS\Customizer;

class SocialBar
{

    public function __construct()
    {
    }

    function seven_tech_social_bar_section($wp_customize)
    {
        $wp_customize->add_section(
            'social_bar_settings',
            array(
                'priority'       => 9,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'title'          => __('Social Bar', 'the-house-forever-wins'),
                'description'    =>  __('Social Bar Settings', 'the-house-forever-wins'),
                'panel'  => 'seven_tech_settings',
            )
        );

        $wp_customize->add_setting('social_bar_box_shadow', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(
            'social_bar_box_shadow',
            array(
                'type' => 'input',
                'label' => __('Social Bar Box Shadow', 'the-house-forever-wins'),
                'section' => 'social_bar_settings',
            )
        );

        $wp_customize->add_setting('social_bar_background_color', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(
            'social_bar_background_color',
            array(
                'type' => 'input',
                'label' => __('Social Bar Background Color', 'the-house-forever-wins'),
                'section' => 'social_bar_settings',
            )
        );

        $wp_customize->add_setting('social_bar_icon_color', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(
            'social_bar_icon_color',
            array(
                'type' => 'input',
                'label' => __('Social Bar Icon Color', 'the-house-forever-wins'),
                'section' => 'social_bar_settings',
            )
        );
    }

    function load_css()
    {
?>
        <style>
            :root {
                --seven-tech-box-social-bar-shadow: <?php
                                                    if (empty(get_theme_mod('social_bar_box_shadow'))) {
                                                        echo esc_html('0.25em -0.25em 0.25em rgba(0, 0, 0, 0.5), 0.25em 0.25em 0.25em rgba(0, 0, 0, 0.5)');
                                                    } else {
                                                        echo  esc_html(get_theme_mod('social_bar_box_shadow'));
                                                    }
                                                    ?>;
                --seven-tech-box-social-bar-background-color: <?php
                                                                if (empty(get_theme_mod('social_bar_background_color'))) {
                                                                    echo esc_html('white');
                                                                } else {
                                                                    echo esc_html(get_theme_mod('social_bar_background_color'));
                                                                }
                                                                ?>;
                --seven-tech-box-social-bar-icon-color: <?php
                                                        if (empty(get_theme_mod('social_bar_icon_color'))) {
                                                            echo esc_html('black');
                                                        } else {
                                                            echo esc_html(get_theme_mod('social_bar_icon_color'));
                                                        }
                                                        ?>;
            }
        </style>
<?php
    }
}

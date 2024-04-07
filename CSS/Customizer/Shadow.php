<?php

namespace SEVEN_TECH\Communications\CSS\Customizer;

class Shadow
{
    public function __construct()
    {
    }

    function seven_tech_shadow_section($wp_customize)
    {
        $wp_customize->add_section(
            'seven_tech_shadow_settings',
            array(
                'priority'       => 9,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'title'          => __('Shadows', 'the-house-forever-wins'),
                'description'    =>  __('Shadow Settings', 'the-house-forever-wins'),
                'panel'  => 'seven_tech_settings',
            )
        );

        $wp_customize->add_setting('seven_tech_card_shadow', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(
            'seven_tech_card_shadow',
            array(
                'type' => 'input',
                'label' => __('Card Box Shadow', 'the-house-forever-wins'),
                'section' => 'seven_tech_shadow_settings',
            )
        );

        $wp_customize->add_setting('seven_tech_button_shadow', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(
            'seven_tech_button_shadow',
            array(
                'type' => 'input',
                'label' => __('Button Box Shadow', 'the-house-forever-wins'),
                'section' => 'seven_tech_shadow_settings',
            )
        );

        $wp_customize->add_setting('seven_tech_input_shadow', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(
            'seven_tech_input_shadow',
            array(
                'type' => 'input',
                'label' => __('Input Box Shadow', 'the-house-forever-wins'),
                'section' => 'seven_tech_shadow_settings',
            )
        );
    }

    function load_css()
    {
?>
        <style>
            :root {
                --seven-tech-card-shadow: <?php
                                            if (empty(get_theme_mod('seven_tech_card_shadow'))) {
                                                echo esc_html('0 0 0.5em rgba(0, 0, 0, 0.85)');
                                            } else {
                                                echo esc_html(get_theme_mod('seven_tech_card_shadow'));
                                            } ?>;
                --seven-tech-btn-shadow: <?php
                                            if (empty(get_theme_mod('seven_tech_button_shadow'))) {
                                                echo esc_html('0 0 0.5em rgba(0, 0, 0, 0.85)');
                                            } else {
                                                echo esc_html(get_theme_mod('seven_tech_button_shadow'));
                                            } ?>;
                --seven-tech-input-shadow: <?php
                                            if (empty(get_theme_mod('seven_tech_input_shadow'))) {
                                                echo esc_html('0 0 0.5em rgba(0, 0, 0, 0.85)');
                                            } else {
                                                echo esc_html(get_theme_mod('seven_tech_input_shadow'));
                                            } ?>;

            }
        </style>
<?php
    }
}

<?php

namespace SEVEN_TECH\Communications\CSS\Customizer;

class BorderRadius
{
    public function __construct()
    {
    }

    function seven_tech_border_radius_section($wp_customize)
    {
        $wp_customize->add_section(
            'seven_tech_border_radius_settings',
            array(
                'priority'       => 9,
                'capability'     => 'edit_theme_options',
                'theme_supports' => '',
                'title'          => __('Border Radius', 'the-house-forever-wins'),
                'description'    =>  __('Border Radius Settings', 'the-house-forever-wins'),
                'panel'  => 'seven_tech_settings',
            )
        );

        $wp_customize->add_setting('seven_tech_border_radius', array(
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control(
            'seven_tech_border_radius',
            array(
                'type' => 'input',
                'label' => __('Border Radius', 'the-house-forever-wins'),
                'section' => 'seven_tech_border_radius_settings',
            )
        );
    }

    function load_css()
    {
?>
        <style>
            :root {
                --seven-tech-border-radius: <?php
                                            if (empty(get_theme_mod('seven_tech_border_radius'))) {
                                                echo esc_html('0.5em');
                                            } else {
                                                echo esc_html(get_theme_mod('seven_tech_border_radius'));
                                            } ?>;
            }
        </style>
<?php
    }
}

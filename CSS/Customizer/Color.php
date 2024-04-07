<?php

namespace SEVEN_TECH\Communications\CSS\Customizer;

class Color
{
	public function __construct()
	{
	}

	function seven_tech_color_section($wp_customize)
	{
		$wp_customize->add_section(
			'seven_tech_color_settings',
			array(
				'priority'       => 9,
				'capability'     => 'edit_theme_options',
				'theme_supports' => '',
				'title'          => __('Colors', 'the-house-forever-wins'),
				'description'    =>  __('Color Settings', 'the-house-forever-wins'),
				'panel'  => 'seven_tech_settings',
			)
		);

		$wp_customize->add_setting('seven_tech_primary_color', array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control(
			'seven_tech_primary_color',
			array(
				'type' => 'input',
				'label' => __('Primary Color', 'the-house-forever-wins'),
				'section' => 'seven_tech_color_settings',
			)
		);

		$wp_customize->add_setting('seven_tech_secondary_color', array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control(
			'seven_tech_secondary_color',
			array(
				'type' => 'input',
				'label' => __('Secondary Color', 'the-house-forever-wins'),
				'section' => 'seven_tech_color_settings',
			)
		);

		$wp_customize->add_setting('seven_tech_tertiary_color', array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control(
			'seven_tech_tertiary_color',
			array(
				'type' => 'input',
				'label' => __('Tertiary Color', 'the-house-forever-wins'),
				'section' => 'seven_tech_color_settings',
			)
		);

		$wp_customize->add_setting('seven_tech_quaternary_color', array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control(
			'seven_tech_quaternary_color',
			array(
				'type' => 'input',
				'label' => __('Quaternary Color', 'the-house-forever-wins'),
				'section' => 'seven_tech_color_settings',
			)
		);

		$wp_customize->add_setting('seven_tech_success_color', array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control(
			'seven_tech_success_color',
			array(
				'type' => 'input',
				'label' => __('Success Color', 'the-house-forever-wins'),
				'section' => 'seven_tech_color_settings',
			)
		);

		$wp_customize->add_setting('seven_tech_error_color', array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control(
			'seven_tech_error_color',
			array(
				'type' => 'input',
				'label' => __('Error Color', 'the-house-forever-wins'),
				'section' => 'seven_tech_color_settings',
			)
		);

		$wp_customize->add_setting('seven_tech_caution_color', array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control(
			'seven_tech_caution_color',
			array(
				'type' => 'input',
				'label' => __('Caution Color', 'the-house-forever-wins'),
				'section' => 'seven_tech_color_settings',
			)
		);

		$wp_customize->add_setting('seven_tech_info_color', array(
			'sanitize_callback' => 'sanitize_text_field',
		));

		$wp_customize->add_control(
			'seven_tech_info_color',
			array(
				'type' => 'input',
				'label' => __('Info Color', 'the-house-forever-wins'),
				'section' => 'seven_tech_color_settings',
			)
		);
	}

	function load_css()
	{
?>
		<style>
			:root {
				--seven-tech-color-primary: <?php
											if (empty(get_theme_mod('seven_tech_primary_color'))) {
												echo esc_html('#fff');
											} else {
												echo esc_html(get_theme_mod('seven_tech_primary_color'));
											} ?>;
				--seven-tech-color-secondary: <?php
												if (empty(get_theme_mod('seven_tech_secondary_color'))) {
													echo esc_html('#000');
												} else {
													echo esc_html(get_theme_mod('seven_tech_secondary_color'));
												} ?>;
				--seven-tech-color-tertiary: <?php
												if (empty(get_theme_mod('seven_tech_tertiary_color'))) {
													echo esc_html('red');
												} else {
													echo esc_html(get_theme_mod('seven_tech_tertiary_color'));
												} ?>;
				--seven-tech-color-quaternary: <?php
												if (empty(get_theme_mod('seven_tech_quaternary_color'))) {
													echo esc_html('#2ed341');
												} else {
													echo esc_html(get_theme_mod('seven_tech_quaternary_color'));
												} ?>;
				--seven-tech-color-success: <?php
											if (empty(get_theme_mod('seven_tech_success_color'))) {
												echo esc_html('green');
											} else {
												echo esc_html(get_theme_mod('seven_tech_success_color'));
											} ?>;
				--seven-tech-color-error: <?php
											if (empty(get_theme_mod('seven_tech_error_color'))) {
												echo esc_html('red');
											} else {
												echo esc_html(get_theme_mod('seven_tech_error_color'));
											} ?>;
				--seven-tech-color-caution: <?php
											if (empty(get_theme_mod('seven_tech_caution_color'))) {
												echo esc_html('yellow');
											} else {
												echo esc_html(get_theme_mod('seven_tech_caution_color'));
											} ?>;
				--seven-tech-color-info: <?php
											if (empty(get_theme_mod('seven_tech_info_color'))) {
												echo esc_html('blue');
											} else {
												echo esc_html(get_theme_mod('seven_tech_info_color'));
											} ?>;
			}
		</style>
<?php
	}
}

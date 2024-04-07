<?php

namespace SEVEN_TECH\Communications\CSS\Customizer;

class Customizer
{
	public function __construct()
	{
	}

	function register_customizer_panel($wp_customize)
	{
		add_theme_support('customizer');
		$wp_customize->add_panel(
			'seven_tech_settings',
			array(
				'title' => __('SEVEN TECH Settings', 'the-house-forever-wins'),
				'priority' => 10,
			)
		);
	}
}

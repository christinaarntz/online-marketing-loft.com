<?php
/**
 * Color Customizer Options
 *
 * @package shark_business_pro
 */

// theme color content type control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[theme_color]', array(
	'default'          	=> shark_business_pro_theme_option('theme_color'),
	'sanitize_callback' => 'shark_business_pro_sanitize_select',
) );

$wp_customize->add_control( 'shark_business_pro_theme_options[theme_color]', array(
	'label'             => esc_html__( 'Theme Color Options', 'shark-business-pro' ),
	'section'           => 'colors',
	'type'				=> 'radio',
	'choices'			=> array( 
		'default' 	=> esc_html__( 'Default', 'shark-business-pro' ),
		'black' 	=> esc_html__( 'Black', 'shark-business-pro' ),
		'red' 		=> esc_html__( 'Red', 'shark-business-pro' ),
		'green' 	=> esc_html__( 'Green', 'shark-business-pro' ),
		'yellow' 	=> esc_html__( 'Yellow', 'shark-business-pro' ),
		'gredient' 	=> esc_html__( 'Purple Gredient', 'shark-business-pro' ),
		'custom' 	=> esc_html__( 'Custom', 'shark-business-pro' ),
	),
) );

$wp_customize->add_setting( 'shark_business_pro_theme_options[colorscheme]', array(
	'default'           => shark_business_pro_theme_option('colorscheme'),
	'sanitize_callback' => 'sanitize_hex_color', // The hue is stored as a positive integer.
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shark_business_pro_theme_options[colorscheme]', array(
	'label'    => esc_html__( 'Theme Color', 'shark-business-pro' ),
	'section'  => 'colors',
	'active_callback'	=> 'shark_business_pro_theme_color_custom_enable',
) ) );
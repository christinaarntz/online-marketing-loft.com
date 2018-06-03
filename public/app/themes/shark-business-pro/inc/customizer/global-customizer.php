<?php
/**
 * Global Customizer Options
 *
 * @package shark_business_pro
 */

// Add Global section
$wp_customize->add_section( 'shark_business_pro_global_section', array(
	'title'             => esc_html__( 'Global Setting','shark-business-pro' ),
	'description'       => esc_html__( 'Global Setting Options', 'shark-business-pro' ),
	'panel'             => 'shark_business_pro_theme_options_panel',
) );

// header sticky setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[enable_sticky_header]', array(
	'default'           => shark_business_pro_theme_option( 'enable_sticky_header' ),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[enable_sticky_header]', array(
	'label'             => esc_html__( 'Make Header Sticky', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_global_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// breadcrumb setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[enable_breadcrumb]', array(
	'default'           => shark_business_pro_theme_option( 'enable_breadcrumb' ),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[enable_breadcrumb]', array(
	'label'             => esc_html__( 'Enable Breadcrumb', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_global_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// site layout setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[site_layout]', array(
	'sanitize_callback'   => 'shark_business_pro_sanitize_select',
	'default'             => shark_business_pro_theme_option('site_layout'),
) );

$wp_customize->add_control(  new Shark_Business_Pro_Radio_Image_Control ( $wp_customize, 'shark_business_pro_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'shark-business-pro' ),
	'section'             => 'shark_business_pro_global_section',
	'choices'			  => shark_business_pro_site_layout(),
) ) );

// loader setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[enable_loader]', array(
	'default'           => shark_business_pro_theme_option( 'enable_loader' ),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[enable_loader]', array(
	'label'             => esc_html__( 'Enable Loader', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_global_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// loader type control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[loader_type]', array(
	'default'          	=> shark_business_pro_theme_option('loader_type'),
	'sanitize_callback' => 'shark_business_pro_sanitize_select',
) );

$wp_customize->add_control( 'shark_business_pro_theme_options[loader_type]', array(
	'label'             => esc_html__( 'Loader Type', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_global_section',
	'type'				=> 'select',
	'choices'			=> shark_business_pro_get_spinner_list(),
) );

// header typography type control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[header_typography]', array(
	'default'          	=> shark_business_pro_theme_option('header_typography'),
	'sanitize_callback' => 'shark_business_pro_sanitize_select',
) );

$wp_customize->add_control( 'shark_business_pro_theme_options[header_typography]', array(
	'label'             => esc_html__( 'Heading Typography', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_global_section',
	'type'				=> 'select',
	'choices'			=> shark_business_pro_header_typography(),
) );

// body typography type control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[body_typography]', array(
	'default'          	=> shark_business_pro_theme_option('body_typography'),
	'sanitize_callback' => 'shark_business_pro_sanitize_select',
) );

$wp_customize->add_control( 'shark_business_pro_theme_options[body_typography]', array(
	'label'             => esc_html__( 'Body Typography', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_global_section',
	'type'				=> 'select',
	'choices'			=> shark_business_pro_body_typography(),
) );

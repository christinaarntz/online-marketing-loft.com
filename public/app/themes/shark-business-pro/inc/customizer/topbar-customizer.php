<?php
/**
 * Topbar Customizer Options
 *
 * @package shark_business_pro
 */

// Add topbar section
$wp_customize->add_section( 'shark_business_pro_topbar_section', array(
	'title'             => esc_html__( 'Top Bar Section','shark-business-pro' ),
	'description'       => sprintf( '%1$s <a class="menu_locations" href="#"> %2$s </a> %3$s', esc_html__( 'Note: To show social menu.', 'shark-business-pro' ), esc_html__( 'Click Here', 'shark-business-pro' ), esc_html__( 'to create menu.', 'shark-business-pro' ) ),
	'panel'             => 'shark_business_pro_theme_options_panel',
) );

// topbar enable setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[enable_topbar]', array(
	'default'           => shark_business_pro_theme_option('enable_topbar'),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[enable_topbar]', array(
	'label'             => esc_html__( 'Enable Topbar', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_topbar_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// topbar address control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[topbar_address]', array(
	'default'			=> shark_business_pro_theme_option('topbar_address'),
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Shark_Business_Pro_Dropdown_Chosen_Control( $wp_customize, 'shark_business_pro_theme_options[topbar_address]', array(
	'label'             => esc_html__( 'Address', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_topbar_section',
	'type'				=> 'text',
) ) );

// topbar phone control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[topbar_phone]', array(
	'default'			=> shark_business_pro_theme_option('topbar_phone'),
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Shark_Business_Pro_Dropdown_Chosen_Control( $wp_customize, 'shark_business_pro_theme_options[topbar_phone]', array(
	'label'             => esc_html__( 'Phone No', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_topbar_section',
	'type'				=> 'text',
) ) );

// topbar email control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[topbar_email]', array(
	'default'			=> shark_business_pro_theme_option('topbar_email'),
	'sanitize_callback' => 'sanitize_email',
) );

$wp_customize->add_control( new Shark_Business_Pro_Dropdown_Chosen_Control( $wp_customize, 'shark_business_pro_theme_options[topbar_email]', array(
	'label'             => esc_html__( 'Email ID', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_topbar_section',
	'type'				=> 'email',
) ) );

// topbar social menu enable setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[show_social_menu]', array(
	'default'           => shark_business_pro_theme_option('show_social_menu'),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[show_social_menu]', array(
	'label'             => esc_html__( 'Show Social Menu', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_topbar_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// topbar search enable setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[show_top_search]', array(
	'default'           => shark_business_pro_theme_option('show_top_search'),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[show_top_search]', array(
	'label'             => esc_html__( 'Show Search', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_topbar_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );
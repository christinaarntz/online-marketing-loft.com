<?php
/**
 * Page Customizer Options
 *
 * @package shark_business_pro
 */

// Add excerpt section
$wp_customize->add_section( 'shark_business_pro_page_section', array(
	'title'             => esc_html__( 'Page Setting','shark-business-pro' ),
	'description'       => esc_html__( 'Page Setting Options', 'shark-business-pro' ),
	'panel'             => 'shark_business_pro_theme_options_panel',
) );

// sidebar layout setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[sidebar_page_layout]', array(
	'sanitize_callback'   => 'shark_business_pro_sanitize_select',
	'default'             => shark_business_pro_theme_option('sidebar_page_layout'),
) );

$wp_customize->add_control(  new Shark_Business_Pro_Radio_Image_Control ( $wp_customize, 'shark_business_pro_theme_options[sidebar_page_layout]', array(
	'label'               => esc_html__( 'Sidebar Layout', 'shark-business-pro' ),
	'section'             => 'shark_business_pro_page_section',
	'choices'			  => shark_business_pro_sidebar_position(),
) ) );

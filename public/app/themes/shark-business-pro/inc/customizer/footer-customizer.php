<?php
/**
 * Footer Customizer Options
 *
 * @package shark_business_pro
 */

// Add footer section
$wp_customize->add_section( 'shark_business_pro_footer_section', array(
	'title'             => esc_html__( 'Footer Section','shark-business-pro' ),
	'description'       => esc_html__( 'Footer Setting Options', 'shark-business-pro' ),
	'panel'             => 'shark_business_pro_theme_options_panel',
) );

// slide to top enable setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[slide_to_top]', array(
	'default'           => shark_business_pro_theme_option('slide_to_top'),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[slide_to_top]', array(
	'label'             => esc_html__( 'Show Slide to Top', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_footer_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// copyright text
$wp_customize->add_setting( 'shark_business_pro_theme_options[copyright_text]',
	array(
		'default'       		=> shark_business_pro_theme_option('copyright_text'),
		'sanitize_callback'		=> 'shark_business_pro_santize_allow_tags',
	)
);
$wp_customize->add_control( 'shark_business_pro_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'shark-business-pro' ),
		'section'    			=> 'shark_business_pro_footer_section',
		'type'		 			=> 'textarea',
    )
);


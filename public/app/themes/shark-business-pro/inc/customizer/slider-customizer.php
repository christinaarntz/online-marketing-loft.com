<?php
/**
 * Slider Customizer Options
 *
 * @package shark_business_pro
 */

// Add slider section
$wp_customize->add_section( 'shark_business_pro_slider_section', array(
	'title'             => esc_html__( 'Slider Section','shark-business-pro' ),
	'description'       => esc_html__( 'Slider Setting Options', 'shark-business-pro' ),
	'panel'             => 'shark_business_pro_theme_options_panel',
) );

// slider menu enable setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[enable_slider]', array(
	'default'           => shark_business_pro_theme_option('enable_slider'),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[enable_slider]', array(
	'label'             => esc_html__( 'Enable Slider', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_slider_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// slider social menu enable setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_entire_site]', array(
	'default'           => shark_business_pro_theme_option('slider_entire_site'),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[slider_entire_site]', array(
	'label'             => esc_html__( 'Show Entire Site', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_slider_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// slider arrow control enable setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_arrow]', array(
	'default'           => shark_business_pro_theme_option('slider_arrow'),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[slider_arrow]', array(
	'label'             => esc_html__( 'Show Arrow Controller', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_slider_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// slider wave border enable setting and control.
$wp_customize->add_setting( 'shark_business_pro_theme_options[enable_slider_wave]', array(
	'default'           => shark_business_pro_theme_option('enable_slider_wave'),
	'sanitize_callback' => 'shark_business_pro_sanitize_switch',
) );

$wp_customize->add_control( new Shark_Business_Pro_Switch_Control( $wp_customize, 'shark_business_pro_theme_options[enable_slider_wave]', array(
	'label'             => esc_html__( 'Enable Slider Wave Border', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_slider_section',
	'on_off_label' 		=> shark_business_pro_show_options(),
) ) );

// slider content type control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_content_type]', array(
	'default'          	=> shark_business_pro_theme_option('slider_content_type'),
	'sanitize_callback' => 'shark_business_pro_sanitize_select',
) );

$wp_customize->add_control( 'shark_business_pro_theme_options[slider_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_slider_section',
	'type'				=> 'select',
	'choices'			=> array( 
		'page' 		=> esc_html__( 'Page', 'shark-business-pro' ),
		'post' 		=> esc_html__( 'Post', 'shark-business-pro' ),
		'custom' 	=> esc_html__( 'Custom', 'shark-business-pro' ),
	),
) );

// slider count control and setting
$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_count]', array(
	'default'          	=> shark_business_pro_theme_option('slider_count'),
	'sanitize_callback' => 'shark_business_pro_sanitize_number_range',
	'validate_callback' => 'shark_business_pro_validate_slider_count',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'shark_business_pro_theme_options[slider_count]', array(
	'label'             => esc_html__( 'Number of Latest Blog', 'shark-business-pro' ),
	'description'       => esc_html__( 'Note: Min 1 & Max 10. Please refresh the page to see the change.', 'shark-business-pro' ),
	'section'           => 'shark_business_pro_slider_section',
	'type'				=> 'number',
	'input_attrs'		=> array(
		'min'	=> 1,
		'max'	=> 10,
		),
) );

for ( $i = 1; $i <= shark_business_pro_theme_option('slider_count'); $i++ ) :

	// slider pages drop down chooser control and setting
	$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_content_page_' . $i . ']', array(
		'sanitize_callback' => 'shark_business_pro_sanitize_page_post',
	) );

	$wp_customize->add_control( new Shark_Business_Pro_Dropdown_Chosen_Control( $wp_customize, 'shark_business_pro_theme_options[slider_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'shark-business-pro' ), $i ),
		'section'           => 'shark_business_pro_slider_section',
		'choices'			=> shark_business_pro_page_choices(),
		'active_callback'	=> 'shark_business_pro_slider_content_page_enable',
	) ) );

	// slider posts drop down chooser control and setting
	$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_content_post_' . $i . ']', array(
		'sanitize_callback' => 'shark_business_pro_sanitize_page_post',
	) );

	$wp_customize->add_control( new Shark_Business_Pro_Dropdown_Chosen_Control( $wp_customize, 'shark_business_pro_theme_options[slider_content_post_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Post %d', 'shark-business-pro' ), $i ),
		'section'           => 'shark_business_pro_slider_section',
		'choices'			=> shark_business_pro_post_choices(),
		'active_callback'	=> 'shark_business_pro_slider_content_post_enable',
	) ) );

	// slider title drop down chooser control and setting
	$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_custom_title_' . $i . ']', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'shark_business_pro_theme_options[slider_custom_title_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Input Title %d', 'shark-business-pro' ), $i ),
		'section'           => 'shark_business_pro_slider_section',
		'type'				=> 'text',
		'active_callback'	=> 'shark_business_pro_slider_content_custom_enable',
	) );

	// slider link drop down chooser control and setting
	$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_custom_link_' . $i . ']', array(
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'shark_business_pro_theme_options[slider_custom_link_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Input Link %d', 'shark-business-pro' ), $i ),
		'section'           => 'shark_business_pro_slider_section',
		'type'				=> 'url',
		'active_callback'	=> 'shark_business_pro_slider_content_custom_enable',
	) );

	// slider link drop down chooser control and setting
	$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_custom_description_' . $i . ']', array(
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'shark_business_pro_theme_options[slider_custom_description_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Input Description %d', 'shark-business-pro' ), $i ),
		'section'           => 'shark_business_pro_slider_section',
		'type'				=> 'textarea',
		'active_callback'	=> 'shark_business_pro_slider_content_custom_enable',
	) );

	// Client additional image setting and control.
	$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_custom_image_' . $i . ']', array(
		'sanitize_callback' => 'shark_business_pro_sanitize_image',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shark_business_pro_theme_options[slider_custom_image_' . $i . ']',
			array(
			'label'       		=> sprintf( esc_html__( 'Select Image %d', 'shark-business-pro' ), $i ),
			'description' 		=> sprintf( esc_html__( 'Recommended size: %1$dpx x %2$dpx ', 'shark-business-pro' ), 1920, 1080 ),
			'section'     		=> 'shark_business_pro_slider_section',
			'active_callback'	=> 'shark_business_pro_slider_content_custom_enable',
	) ) );

	// slider hr control and setting
	$wp_customize->add_setting( 'shark_business_pro_theme_options[slider_custom_hr_' . $i . ']', array(
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( new Shark_Business_Pro_Horizontal_Line( $wp_customize, 'shark_business_pro_theme_options[slider_custom_hr_' . $i . ']', array(
		'section'           => 'shark_business_pro_slider_section',
		'active_callback'	=> 'shark_business_pro_slider_content_custom_enable',
	) ) );

endfor;
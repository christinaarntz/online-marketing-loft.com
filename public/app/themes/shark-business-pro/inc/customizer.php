<?php
/**
 * Shark Business Pro Theme Customizer
 *
 * @package shark_business_pro
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shark_business_pro_customize_register( $wp_customize ) {
	// Load custom control functions.
	require get_template_directory() . '/inc/customizer/controls.php';

	// Load callback functions.
	require get_template_directory() . '/inc/customizer/callbacks.php';

	// Load validation functions.
	require get_template_directory() . '/inc/customizer/validate.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'shark_business_pro_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'shark_business_pro_customize_partial_blogdescription',
		) );
	}

	// Add panel for common Home Page Settings
	$wp_customize->add_panel( 'shark_business_pro_theme_options_panel' , array(
	    'title'      => esc_html__( 'Theme Options','shark-business-pro' ),
	    'description'=> esc_html__( 'Shark Business Pro Theme Options.', 'shark-business-pro' ),
	    'priority'   => 100,
	) );

	// color settings
	require get_template_directory() . '/inc/customizer/color-customizer.php';

	// topbar settings
	require get_template_directory() . '/inc/customizer/topbar-customizer.php';

	// slider settings
	require get_template_directory() . '/inc/customizer/slider-customizer.php';

	// footer settings
	require get_template_directory() . '/inc/customizer/footer-customizer.php';
	
	// blog/archive settings
	require get_template_directory() . '/inc/customizer/blog-customizer.php';

	// single settings
	require get_template_directory() . '/inc/customizer/single-customizer.php';

	// page settings
	require get_template_directory() . '/inc/customizer/page-customizer.php';

	// global settings
	require get_template_directory() . '/inc/customizer/global-customizer.php';

}
add_action( 'customize_register', 'shark_business_pro_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function shark_business_pro_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function shark_business_pro_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function shark_business_pro_customize_preview_js() {
	wp_enqueue_script( 'shark-business-pro-customizer', get_template_directory_uri() . '/assets/js/customizer' . shark_business_pro_min() . '.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'shark_business_pro_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function shark_business_pro_customize_control_js() {
	// Choose from select jquery.
	wp_enqueue_style( 'jquery-chosen', get_template_directory_uri() . '/assets/css/chosen' . shark_business_pro_min() . '.css' );
	wp_enqueue_script( 'jquery-chosen', get_template_directory_uri() . '/assets/js/chosen' . shark_business_pro_min() . '.js', array( 'jquery' ), '1.4.2', true );

	// admin script
	wp_enqueue_style( 'shark-business-pro-admin-style', get_template_directory_uri() . '/assets/css/admin' . shark_business_pro_min() . '.css' );
	wp_enqueue_script( 'shark-business-pro-admin-script', get_template_directory_uri() . '/assets/js/admin' . shark_business_pro_min() . '.js', array( 'jquery', 'jquery-chosen' ), '1.0.0', true );

	wp_enqueue_style( 'shark-business-pro-customizer-style', get_template_directory_uri() . '/assets/css/customizer' . shark_business_pro_min() . '.css' );
	wp_enqueue_script( 'shark-business-pro-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls' . shark_business_pro_min() . '.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'shark_business_pro_customize_control_js' );

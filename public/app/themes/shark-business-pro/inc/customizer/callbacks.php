<?php
/**
 * Callbacks functions
 *
 * @package shark_business_pro
 */

if ( ! function_exists( 'shark_business_pro_theme_color_custom_enable' ) ) :
	/**
	 * Check if theme color custom enabled
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function shark_business_pro_theme_color_custom_enable( $control ) {
		return 'custom' == $control->manager->get_setting( 'shark_business_pro_theme_options[theme_color]' )->value();
	}
endif;

if ( ! function_exists( 'shark_business_pro_slider_content_post_enable' ) ) :
	/**
	 * Check if slider content type is post.
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function shark_business_pro_slider_content_post_enable( $control ) {
		return 'post' == $control->manager->get_setting( 'shark_business_pro_theme_options[slider_content_type]' )->value();
	}
endif;

if ( ! function_exists( 'shark_business_pro_slider_content_page_enable' ) ) :
	/**
	 * Check if slider content type is page.
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function shark_business_pro_slider_content_page_enable( $control ) {
		return 'page' == $control->manager->get_setting( 'shark_business_pro_theme_options[slider_content_type]' )->value();
	}
endif;

if ( ! function_exists( 'shark_business_pro_slider_content_custom_enable' ) ) :
	/**
	 * Check if slider content type is custom.
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function shark_business_pro_slider_content_custom_enable( $control ) {
		return 'custom' == $control->manager->get_setting( 'shark_business_pro_theme_options[slider_content_type]' )->value();
	}
endif;

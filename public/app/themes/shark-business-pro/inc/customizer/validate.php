<?php
/**
 * Validation functions
 *
 * @package shark_business_pro
 */

if ( ! function_exists( 'shark_business_pro_validate_excerpt_count' ) ) :
	/**
	 * Check if the input value is valid integer.
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return string Whether the value is valid to the current preview.
	 */
	function shark_business_pro_validate_excerpt_count( $validity, $value ){
		$value = intval( $value );
		if ( empty( $value ) || ! is_numeric( $value ) ) {
			$validity->add( 'required', esc_html__( 'You must supply a valid number.', 'shark-business-pro' ) );
		} elseif ( $value < 1 ) {
			$validity->add( 'min_slider', esc_html__( 'Minimum no of Excerpt Lenght is 1', 'shark-business-pro' ) );
		} elseif ( $value > 50 ) {
			$validity->add( 'max_slider', esc_html__( 'Maximum no of Excerpt Lenght is 50', 'shark-business-pro' ) );
		}
		return $validity;
	}
endif;

if ( ! function_exists( 'shark_business_pro_validate_slider_count' ) ) :
	/**
	 * Check if the input value is valid integer.
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return string Whether the value is valid to the current preview.
	 */
	function shark_business_pro_validate_slider_count( $validity, $value ){
		$value = intval( $value );
		if ( empty( $value ) || ! is_numeric( $value ) ) {
			$validity->add( 'required', esc_html__( 'You must supply a valid number.', 'shark-business-pro' ) );
		} elseif ( $value < 1 ) {
			$validity->add( 'min_slider', esc_html__( 'Minimum no of Slider is 1', 'shark-business-pro' ) );
		} elseif ( $value > 10 ) {
			$validity->add( 'max_slider', esc_html__( 'Maximum no of Slider is 10', 'shark-business-pro' ) );
		}
		return $validity;
	}
endif;
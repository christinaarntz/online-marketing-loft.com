<?php
/**
 * Default Theme Customizer Values
 *
 * @package shark_business_pro
 */

function shark_business_pro_get_default_theme_options() {
	$shark_business_pro_default_options = array(
		// default options

		// Top Bar
		'enable_topbar'			=> true,
		'show_social_menu'		=> false,
		'show_top_search'		=> true,
		'topbar_address'		=> esc_html__( 'Wall Street, New York', 'shark-business-pro' ),
		'topbar_phone'			=> esc_html__( '+00 0 0000000', 'shark-business-pro' ),
		'topbar_email'			=> 'abc@sharkthemes.com',

		// Slider
		'enable_slider'			=> true,
		'slider_entire_site'	=> false,
		'enable_slider_wave'	=> false,
		'slider_arrow'			=> true,
		'slider_content_type'	=> 'page',
		'slider_count'			=> 3,

		// Footer
		'slide_to_top'			=> true,
		'copyright_text'		=> esc_html__( 'Copyright &copy; Shark Business Pro Theme | All Rights Reserved.', 'shark-business-pro' ) . sprintf( esc_html__( ' Shark Business Pro by %1$s Shark Themes %2$s', 'shark-business-pro' ), '<a href="' . esc_url( 'http://sharkthemes.com/' ) . '" target="_blank">','</a>' ),

		// blog / archive
		'latest_blog_title'		=> esc_html__( 'Blogs', 'shark-business-pro' ),
		'excerpt_count'			=> 25,
		'pagination_type'		=> 'numeric',
		'sidebar_layout'		=> 'right-sidebar',
		'column_type'			=> 'column-2',
		'show_date'				=> true,
		'show_category'			=> true,
		'show_author'			=> true,
		'show_comment'			=> true,

		// single post
		'sidebar_single_layout'	=> 'right-sidebar',
		'show_single_date'		=> true,
		'show_single_category'	=> true,
		'show_single_tags'		=> true,
		'show_single_author'	=> true,

		// page
		'sidebar_page_layout'	=> 'right-sidebar',

		// global
		'enable_loader'			=> true,
		'enable_breadcrumb'		=> true,
		'enable_sticky_header'	=> false,
		'loader_type'			=> 'spinner-dots',
		'site_layout'			=> 'full',
		'header_typography'		=> 'default',
		'body_typography'		=> 'default',

		// theme color
		'theme_color'			=> 'default',
		'colorscheme'			=> '#1d1d1d',
	);

	$output = apply_filters( 'shark_business_pro_default_theme_options', $shark_business_pro_default_options );
	return $output;
}
<?php
/**
 * Options functions
 *
 * @package shark_business_pro
 */

if ( ! function_exists( 'shark_business_pro_show_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function shark_business_pro_show_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'shark-business-pro' ),
            'off'       => esc_html__( 'No', 'shark-business-pro' )
        );
        return apply_filters( 'shark_business_pro_show_options', $arr );
    }
endif;

if ( ! function_exists( 'shark_business_pro_page_choices' ) ) :
    /**
     * List of pages for page choices.
     * @return Array Array of page ids and name.
     */
    function shark_business_pro_page_choices() {
        $pages = get_pages();
        $choices = array();
        $choices[0] = esc_html__( 'None', 'shark-business-pro' );
        foreach ( $pages as $page ) {
            $choices[ $page->ID ] = $page->post_title;
        }
        return $choices;
    }
endif;

if ( ! function_exists( 'shark_business_pro_post_choices' ) ) :
    /**
     * List of posts for post choices.
     * @return Array Array of post ids and name.
     */
    function shark_business_pro_post_choices() {
        $posts = get_posts( array( 'numberposts' => -1 ) );
        $choices = array();
        $choices[0] = esc_html__( 'None', 'shark-business-pro' );
        foreach ( $posts as $post ) {
            $choices[ $post->ID ] = $post->post_title;
        }
        return $choices;
    }
endif;

if ( ! function_exists( 'shark_business_pro_category_choices' ) ) :
    /**
     * List of categories for category choices.
     * @return Array Array of category ids and name.
     */
    function shark_business_pro_category_choices() {
        $args = array(
                'type'          => 'post',
                'child_of'      => 0,
                'parent'        => '',
                'orderby'       => 'name',
                'order'         => 'ASC',
                'hide_empty'    => 0,
                'hierarchical'  => 0,
                'taxonomy'      => 'category',
            );
        $categories = get_categories( $args );
        $choices = array();
        $choices[0] = esc_html__( 'None', 'shark-business-pro' );
        foreach ( $categories as $category ) {
            $choices[ $category->term_id ] = $category->name;
        }
        return $choices;
    }
endif;

if ( ! function_exists( 'shark_business_pro_site_layout' ) ) :
    /**
     * site layout
     * @return array site layout
     */
    function shark_business_pro_site_layout() {
        $shark_business_pro_site_layout = array(
            'full'    => get_template_directory_uri() . '/assets/uploads/full.png',
            'boxed'   => get_template_directory_uri() . '/assets/uploads/boxed.png',
        );

        $output = apply_filters( 'shark_business_pro_site_layout', $shark_business_pro_site_layout );

        return $output;
    }
endif;

if ( ! function_exists( 'shark_business_pro_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidebar position
     */
    function shark_business_pro_sidebar_position() {
        $shark_business_pro_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/uploads/right.png',
            'left-sidebar'  => get_template_directory_uri() . '/assets/uploads/left.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/uploads/full.png',
        );

        $output = apply_filters( 'shark_business_pro_sidebar_position', $shark_business_pro_sidebar_position );

        return $output;
    }
endif;

if ( ! function_exists( 'shark_business_pro_get_spinner_list' ) ) :
    /**
     * List of spinner icons options.
     * @return array List of all spinner icon options.
     */
    function shark_business_pro_get_spinner_list() {
        $arr = array(
            'spinner-two-way'       => esc_html__( 'Two Way', 'shark-business-pro' ),
            'spinner-umbrella'      => esc_html__( 'Umbrella', 'shark-business-pro' ),
            'spinner-dots'          => esc_html__( 'Dots', 'shark-business-pro' ),
            'spinner-one-way'       => esc_html__( 'One Way', 'shark-business-pro' ),
        );
        return apply_filters( 'shark_business_pro_spinner_list', $arr );
    }
endif;

if ( ! function_exists( 'shark_business_pro_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function shark_business_pro_selected_sidebar() {
        $shark_business_pro_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'shark-business-pro' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar 1', 'shark-business-pro' ),
            'optional-sidebar-2'    => esc_html__( 'Optional Sidebar 2', 'shark-business-pro' ),
            'optional-sidebar-3'    => esc_html__( 'Optional Sidebar 3', 'shark-business-pro' ),
            'optional-sidebar-4'    => esc_html__( 'Optional Sidebar 4', 'shark-business-pro' ),
        );

        $output = apply_filters( 'shark_business_pro_selected_sidebar', $shark_business_pro_selected_sidebar );

        return $output;
    }
endif;

if ( ! function_exists( 'shark_business_pro_header_typography' ) ) :
    /**
     * header typography options
     * @return array header typography
     */
    function shark_business_pro_header_typography() {
        $shark_business_pro_header_typography = array(
            'default'              => esc_html__( 'Default', 'shark-business-pro' ),
            'header-font-1'        => esc_html__( 'Rajdhani', 'shark-business-pro' ),
            'header-font-2'        => esc_html__( 'Roboto', 'shark-business-pro' ),
            'header-font-3'        => esc_html__( 'Philosopher', 'shark-business-pro' ),
            'header-font-4'        => esc_html__( 'Slabo 27px', 'shark-business-pro' ),
            'header-font-5'        => esc_html__( 'Dosis', 'shark-business-pro' ),
        );

        $output = apply_filters( 'shark_business_pro_header_typography', $shark_business_pro_header_typography );

        return $output;
    }
endif;

if ( ! function_exists( 'shark_business_pro_body_typography' ) ) :
    /**
     * body typography options
     * @return array body typography
     */
    function shark_business_pro_body_typography() {
        $shark_business_pro_body_typography = array(
            'default'            => esc_html__( 'Default', 'shark-business-pro' ),
            'body-font-1'        => esc_html__( 'News Cycle', 'shark-business-pro' ),
            'body-font-2'        => esc_html__( 'Pontano Sans', 'shark-business-pro' ),
            'body-font-3'        => esc_html__( 'Gudea', 'shark-business-pro' ),
            'body-font-4'        => esc_html__( 'Quattrocento', 'shark-business-pro' ),
            'body-font-5'        => esc_html__( 'Khand', 'shark-business-pro' ),
        );

        $output = apply_filters( 'shark_business_pro_body_typography', $shark_business_pro_body_typography );

        return $output;
    }
endif;

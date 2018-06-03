<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package shark_business_pro
 */

/**
 * Load theme updater functions.
 * Action is used so that child themes can easily disable.
 */
function shark_business_pro_pro_theme_updater() {
    if( is_admin() ) {
        require get_template_directory() . '/inc/updater/theme-updater.php';
    }
}
add_action( 'after_setup_theme', 'shark_business_pro_pro_theme_updater' );

if( ! function_exists( 'shark_business_pro_check_enable_status' ) ):
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function shark_business_pro_body_classes( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		$site_layout = shark_business_pro_theme_option( 'site_layout' );
		$classes[] = esc_attr( $site_layout );

		$sidebar_layout = shark_business_pro_sidebar_layout();
		if ( is_404() )
			$sidebar_layout = 'no-sidebar';
		$classes[] = esc_attr( $sidebar_layout );

		$header_typography = shark_business_pro_theme_option('header_typography', 'default' );
		$classes[] = ( 'default' == $header_typography ) ? '' :  esc_attr( $header_typography );

		$body_typography = shark_business_pro_theme_option('body_typography', 'default' );
		$classes[] = ( 'default' == $body_typography ) ? '' :  esc_attr( $body_typography );

		return $classes;
	}
endif;
add_filter( 'body_class', 'shark_business_pro_body_classes' );

/**
 * Add customizer defaults.
 */
require get_template_directory() . '/inc/customizer/default.php';

/**
 * Add options.
 */
require get_template_directory() . '/inc/options.php';

if( ! function_exists( 'shark_business_pro_theme_option' ) ):
	/**
	 * Merge values from default options array and values from customizer
	 *
	 * @return customizer value
	 */
	function shark_business_pro_theme_option( $controler, $default = null ) {
		if ( empty( $controler ) )
			return;

		$shark_business_pro_default_options = shark_business_pro_get_default_theme_options();
	  	$output = wp_parse_args( get_theme_mod( 'shark_business_pro_theme_options' ), $shark_business_pro_default_options ) ;

	  	return ! empty( $output[$controler] ) ? $output[$controler] : $default;
	}
endif;

if( ! function_exists( 'shark_business_pro_check_enable_status' ) ):
	/**
	 * Check status of content.
	 *
	 * @return boolean
	 */
  	function shark_business_pro_check_enable_status( $content_enable = true, $entire_site = false ){
		// Content status.
		$content_status = shark_business_pro_theme_option( $content_enable );
		$entire_site 	= shark_business_pro_theme_option( $entire_site );

		if ( $content_status && $entire_site ) :
			return true;
		elseif ( $content_status && ! $entire_site ) :
			if ( ! is_home() && is_front_page() )
				return true;
			else
				return false;
		else :
			return false;
		endif;
  	}
endif;
add_filter( 'shark_business_pro_section_status', 'shark_business_pro_check_enable_status', 10, 2 );

/**
 * Display custom color CSS.
 */
function shark_business_pro_colors_css_wrap() {
    if ( 'custom' != shark_business_pro_theme_option('theme_color') ) {
        return;
    }

    require_once get_template_directory() . '/inc/colors.php';
    $color = shark_business_pro_theme_option('colorscheme');
    ?>
    <style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-color="' . esc_attr( $color ) . '"'; } ?>>
        <?php echo shark_business_pro_custom_colors_css(); ?>
    </style>
<?php }
add_action( 'wp_head', 'shark_business_pro_colors_css_wrap' );

if ( ! function_exists( 'shark_business_pro_custom_style' ) ) :
	/**
	 * custom css enqueue
	 */
	function shark_business_pro_custom_style() {
		$css = '';

		if ( 'infinite' == shark_business_pro_theme_option( 'pagination_type' ) ) {
			$css .= '
			.blog-loader {
				text-align: center;
			}
			.site-main nav.pagination.navigation {
				display:none;
			}';
		}
		
		wp_add_inline_style( 'shark-business-pro-style', $css );
	}
endif;
add_action( 'wp_enqueue_scripts', 'shark_business_pro_custom_style', 10 );

/**
 * Add construct hooks.
 */
require get_template_directory() . '/inc/construct.php';

/**
 * Add sanitization functions.
 */
require get_template_directory() . '/inc/sanitize.php';

/**
 * Add widgets.
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Add template hooks.
 */
require get_template_directory() . '/inc/template-hooks/template-hooks.php';

/**
 * Add metabox.
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Add breadcrumb.
 */
require get_template_directory() . '/inc/breadcrumb.php';


if ( ! function_exists( 'shark_business_pro_excerpt_length' ) ) :
	/**
	 * excerpt length
	 * 
	 * @return excerpt length value
	 */
	function shark_business_pro_excerpt_length( $length ){
		if ( is_admin() ) {
			return $length;
		}

		$length = shark_business_pro_theme_option( 'excerpt_count', 25 );
		return absint( $length );
	}
endif;
add_filter( 'excerpt_length', 'shark_business_pro_excerpt_length', 999 );

if ( ! function_exists( 'shark_business_pro_pagination' ) ) :
	/**
	 * blog/archive pagination.
	 *
	 * @return pagination type value
	 */
	function shark_business_pro_pagination() {
		$pagination = shark_business_pro_theme_option( 'pagination_type' );
		if ( $pagination == 'default' ) :
			the_posts_navigation();
		elseif ( in_array( $pagination, array( 'infinite', 'numeric' ) ) ) :
			the_posts_pagination( array(
			    'mid_size' => 4,
			    'prev_text' => shark_business_pro_get_svg( array( 'icon' => 'angle-left' ) ),
			    'next_text' => shark_business_pro_get_svg( array( 'icon' => 'angle-right' ) ),
			) );
		endif;
	}
endif;
add_action( 'shark_business_pro_pagination_action', 'shark_business_pro_pagination', 10 );

if ( ! function_exists( 'shark_business_pro_breadcrumb' ) ) :
	/**
	 *  breadcrumb.
	 *
	 * @param  array $args Arguments
	 */
	function shark_business_pro_breadcrumb( $args = array() ) {
		/**
		 * Add breadcrumb.
		 *
		 */
		// Bail if Breadcrumb disabled.
		if ( ! shark_business_pro_theme_option( 'enable_breadcrumb' ) ) {
			return;
		}

		$args = array(
			'show_on_front'   => false,
			'show_title'      => true,
			'show_browse'     => false,
		);
		breadcrumb_trail( $args );      

		return;
	}
endif;
add_action( 'shark_business_pro_breadcrumb', 'shark_business_pro_breadcrumb' , 10 );

if ( ! function_exists( 'shark_business_pro_sidebar_layout' ) ) :
	/**
	 * sidebar layout
	 * 
	 * @return sidebar layout 
	 */
	function shark_business_pro_sidebar_layout(){
		$sidebar = 'sidebar-1';

		if ( is_singular() ) {
			$sidebar = get_post_meta( get_the_ID(), 'shark-business-pro-selected-sidebar', true );
			$sidebar = ! empty( $sidebar ) ? $sidebar : 'sidebar-1';
		} elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {
			$sidebar = get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'shark-business-pro-selected-sidebar', true );
			$sidebar = ! empty( $sidebar ) ? $sidebar : 'sidebar-1';
		}

		if ( is_active_sidebar( $sidebar ) ) :
			if ( is_single() ) :
				$post_layout = get_post_meta( get_the_ID(), 'shark-business-pro-sidebar-position', true );
				if ( ! empty( $post_layout ) ) {
					return $post_layout;
				} else {
					return shark_business_pro_theme_option( 'sidebar_single_layout' );
				}
			elseif ( is_page() ) :
				$page_layout = get_post_meta( get_the_ID(), 'shark-business-pro-sidebar-position', true );
				if ( ! empty( $page_layout ) ) {
					return $page_layout;
				} else {
					return shark_business_pro_theme_option( 'sidebar_page_layout' );
				}
			else :
				return shark_business_pro_theme_option( 'sidebar_layout' );
			endif;
		else :
			return 'no-sidebar';
		endif;
	}
endif;

/**
 * Add SVG definitions to the footer.
 */
function shark_business_pro_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/svg-icons.svg';

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
add_action( 'wp_footer', 'shark_business_pro_include_svg_icons', 9999 );

/**
 * Return SVG markup.
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function shark_business_pro_get_svg( $args = array() ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', 'shark-business-pro' );
	}

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'shark-business-pro' );
	}

	// Set defaults.
	$defaults = array(
		'icon'        => '',
		'title'       => '',
		'desc'        => '',
		'class'       => '',
		'fallback'    => false,
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Set aria hidden.
	$aria_hidden = ' aria-hidden="true"';

	// Set ARIA.
	$aria_labelledby = '';

	/*
	 * Shark Themes doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
	 *
	 * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
	 *
	 * Example 1 with title: <?php echo shark_business_pro_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
	 *
	 * Example 2 with title and description: <?php echo shark_business_pro_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
	 *
	 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
	 */
	if ( $args['title'] ) {
		$aria_hidden     = '';
		$unique_id       = uniqid();
		$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

		if ( $args['desc'] ) {
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		}
	}

	// Begin SVG markup.
	$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . ' ' . esc_attr( $args['class'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

	// Display the title.
	if ( $args['title'] ) {
		$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

		// Display the desc only if the title is already set.
		if ( $args['desc'] ) {
			$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
	}

	/*
	 * Display the icon.
	 *
	 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
	 *
	 * See https://core.trac.wordpress.org/ticket/38387.
	 */
	$svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';

	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
	}

	$svg .= '</svg>';

	return $svg;
}

/**
 * Add dropdown icon if menu item has children.
 *
 * @param  string $title The menu item's title.
 * @param  object $item  The current menu item.
 * @param  array  $args  An array of wp_nav_menu() arguments.
 * @param  int    $depth Depth of menu item. Used for padding.
 * @return string $title The menu item's title with dropdown icon.
 */
function shark_business_pro_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
	if ( 'primary' === $args->theme_location ) {
		foreach ( $item->classes as $value ) {
			if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
				$title = $title . shark_business_pro_get_svg( array( 'icon' => 'angle-down' ) );
			}
		}
	}

	return $title;
}
add_filter( 'nav_menu_item_title', 'shark_business_pro_dropdown_icon_to_menu_link', 10, 4 );

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function shark_business_pro_social_links_icons() {
	// Supported social links icons.
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'envelope-o',
		'medium.com'      => 'medium',
		'pinterest.com'   => 'pinterest-p',
		'getpocket.com'   => 'get-pocket',
		'reddit.com'      => 'reddit-alien',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat-ghost',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'yelp.com'        => 'yelp',
		'youtube.com'     => 'youtube',
	);

	/**
	 * Filter Shark Themes social links icons.
	 *
	 * @since Shark Business Pro 1.0.0
	 *
	 * @param array $social_links_icons Array of social links icons.
	 */
	return apply_filters( 'shark_business_pro_social_links_icons', $social_links_icons );
}

/**
 * Display SVG icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function shark_business_pro_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Get supported social icons.
	$social_icons = shark_business_pro_social_links_icons();

	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . shark_business_pro_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'shark_business_pro_nav_menu_social_icons', 10, 4 );

/**
 * Fallback function call for menu
 * @param  Mixed $args Menu arguments
 * @return String $output Return or echo the add menu link.       
 */
function shark_business_pro_menu_fallback_cb( $args ){
    if ( ! current_user_can( 'edit_theme_options' ) ){
	    return;
   	}
    // see wp-includes/nav-menu-template.php for available arguments
    $link = $args['link_before']
        	. '<a href="' .esc_url( admin_url( 'nav-menus.php' ) ) . '">' . $args['before'] . esc_html__( 'Add a menu','shark-business-pro' ) . $args['after'] . '</a>'
        	. $args['link_after'];

   	if ( FALSE !== stripos( $args['items_wrap'], '<ul' ) || FALSE !== stripos( $args['items_wrap'], '<ol' )
	){
		$link = "<li>$link</li>";
	}
	$output = sprintf( $args['items_wrap'], $args['menu_id'], $args['menu_class'], $link );
	if ( ! empty ( $args['container'] ) ){
		$output = sprintf( '<%1$s class="%2$s" id="%3$s">%4$s</%1$s>', $args['container'], $args['container_class'], $args['container_id'], $output );
	}
	if ( $args['echo'] ){
		echo $output;
	}
	return $output;
}

/**
 * Display SVG icons as per the link.
 *
 * @param  string   $social_link        Theme mod value rendered
 * @return string  SVG icon HTML
 */
function shark_business_pro_return_social_icon( $social_link ) {
	// Get supported social icons.
	$social_icons = shark_business_pro_social_links_icons();

	// Check in the URL for the url in the array.
	foreach ( $social_icons as $attr => $value ) {
		if ( false !== strpos( $social_link, $attr ) ) {
			return shark_business_pro_get_svg( array( 'icon' => esc_attr( $value ) ) );
		}
	}
}

if ( ! function_exists( 'shark_business_pro_trim_content' ) ) :
	/**
	 * custom excerpt function
	 * 
	 * @since Shark Business Pro 1.0.0
	 * @return  no of words to display
	 */
	function shark_business_pro_trim_content( $length = 30, $post_obj = null ) {
		global $post;
		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}

		$length = absint( $length );
		if ( $length < 1 ) {
			$length = 30;
		}

		$source_content = $post_obj->post_content;
		if ( ! empty( $post_obj->post_excerpt ) ) {
			$source_content = $post_obj->post_excerpt;
		}

		$source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );

	   return apply_filters( 'shark_business_pro_trim_content', $trimmed_content );
	}
endif;


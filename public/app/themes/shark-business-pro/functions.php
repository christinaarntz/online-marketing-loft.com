<?php
/**
 * Shark Business Pro functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package shark_business_pro
 */

if ( ! function_exists( 'shark_business_pro_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function shark_business_pro_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Shark Business Pro, use a find and replace
		 * to change 'shark-business-pro' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'shark-business-pro', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 700, 500, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' 	=> esc_html__( 'Primary Menu', 'shark-business-pro' ),
			'social' 	=> esc_html__( 'Social Menu', 'shark-business-pro' ),
			'footer' 	=> esc_html__( 'Footer Menu', 'shark-business-pro' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'shark_business_pro_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add theme support for page excerpt.
		add_post_type_support( 'page', 'excerpt' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 400,
			'flex-width'  => true,
			'flex-height' => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		// Enable support for footer widgets.
		add_theme_support( 'footer-widgets', 4 );

		// Load Footer Widget Support.
		require_if_theme_supports( 'footer-widgets', get_template_directory() . '/inc/footer-widget.php' );
	}
endif;
add_action( 'after_setup_theme', 'shark_business_pro_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shark_business_pro_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shark_business_pro_content_width', 819 );
}
add_action( 'after_setup_theme', 'shark_business_pro_content_width', 0 );

if ( ! function_exists( 'shark_business_pro_fonts_url' ) ) :
/**
 * Register Google fonts
 *
 * @return string Google fonts URL for the theme.
 */
function shark_business_pro_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Oxygen, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Oxygen font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Oxygen:300,400,500';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Montserrat:200,300,400,500,600,700';
	}

	/* header font */

	/* translators: If there are characters in your language that are not supported by Rajdhani, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Rajdhani font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Rajdhani: 200,300,400,500,600,700';
	}

	/* translators: If there are characters in your language that are not supported by Roboto, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Roboto: 200,300,400,500,600,700';
	}

	/* translators: If there are characters in your language that are not supported by Philosopher, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Philosopher font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Philosopher: 200,300,400,500,600,700';
	}

	/* translators: If there are characters in your language that are not supported by Slabo 27px, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Slabo 27px font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Slabo 27px: 200,300,400,500,600,700';
	}

	/* translators: If there are characters in your language that are not supported by Dosis, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Dosis font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Dosis: 200,300,400,500,600,700';
	}

	/* Body Font */

	/* translators: If there are characters in your language that are not supported by News Cycle, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'News Cycle font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'News Cycle: 300,400,500';
	}

	/* translators: If there are characters in your language that are not supported by Pontano Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Pontano Sans font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Pontano Sans: 300,400,500';
	}

	/* translators: If there are characters in your language that are not supported by Gudea, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Gudea font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Gudea: 300,400,500';
	}

	/* translators: If there are characters in your language that are not supported by Quattrocento, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Quattrocento font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Quattrocento: 300,400,500';
	}

	/* translators: If there are characters in your language that are not supported by Khand, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Khand font: on or off', 'shark-business-pro' ) ) {
		$fonts[] = 'Khand: 300,400,500';
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $fonts ) ),
		'subset' => urlencode( $subsets ),
	);

	if ( $fonts ) {
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}
endif;

/**
 * Add preconnect for Google Fonts.
 *
 * @since Shark Business Pro 1.0.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function shark_business_pro_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'shark-business-pro-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'shark_business_pro_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shark_business_pro_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'shark-business-pro' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'shark-business-pro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebars( 4, array(
		'name'          => esc_html__( 'Optional Sidebar %d', 'shark-business-pro' ),
		'id'            => 'optional-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'shark-business-pro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Home Page Area', 'shark-business-pro' ),
		'id'            => 'home-page-area',
		'description'   => esc_html__( 'Add widgets here.', 'shark-business-pro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="section-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'About Page Area', 'shark-business-pro' ),
		'id'            => 'about-page-area',
		'description'   => esc_html__( 'Add widgets here.', 'shark-business-pro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="section-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Service Page Area', 'shark-business-pro' ),
		'id'            => 'service-page-area',
		'description'   => esc_html__( 'Add widgets here.', 'shark-business-pro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="section-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'shark_business_pro_widgets_init' );

/**
 * Function to detect SCRIPT_DEBUG on and off.
 * @return string If on, empty else return .min string.
 */
function shark_business_pro_min() {
	return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
}

/**
 * Enqueue scripts and styles.
 */
function shark_business_pro_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'shark-business-pro-fonts', shark_business_pro_fonts_url(), array(), null );

	// slick
	wp_enqueue_style( 'jquery-slick', get_template_directory_uri() . '/assets/css/slick' . shark_business_pro_min() . '.css' );

	// slick theme
	wp_enqueue_style( 'jquery-slick-theme', get_template_directory_uri() . '/assets/css/slick-theme' . shark_business_pro_min() . '.css' );

	// font awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome' . shark_business_pro_min() . '.css' );

	wp_enqueue_style( 'shark-business-pro-style', get_stylesheet_uri() );

	if ( ! in_array( shark_business_pro_theme_option( 'theme_color', 'default' ), array( 'default', 'custom' ) ) ) :
		wp_enqueue_style( 'shark-business-pro-colors', get_template_directory_uri() . '/assets/css/' . shark_business_pro_theme_option( 'theme_color', 'red' )  . shark_business_pro_min() . '.css', array( 'shark-business-pro-style' ), '1.0' );
	endif;

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/assets/js/html5' . shark_business_pro_min() . '.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'shark-business-pro-navigation', get_template_directory_uri() . '/assets/js/navigation' . shark_business_pro_min() . '.js', array(), '20151215', true );

	$shark_business_pro_l10n = array(
		'quote'          => shark_business_pro_get_svg( array( 'icon' => 'quote-right' ) ),
		'expand'         => esc_html__( 'Expand child menu', 'shark-business-pro' ),
		'collapse'       => esc_html__( 'Collapse child menu', 'shark-business-pro' ),
		'icon'           => shark_business_pro_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),
	);
	wp_localize_script( 'shark-business-pro-navigation', 'shark_business_pro_l10n', $shark_business_pro_l10n );

	wp_enqueue_script( 'shark-business-pro-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix' . shark_business_pro_min() . '.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery-slick', get_template_directory_uri() . '/assets/js/slick' . shark_business_pro_min() . '.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'shark-business-pro-custom', get_template_directory_uri() . '/assets/js/custom' . shark_business_pro_min() . '.js', array( 'jquery' ), '20151215', true );

	if ( 'infinite' == shark_business_pro_theme_option( 'pagination_type' ) ) {
		wp_enqueue_script( 'shark-business-pro-infinite', get_template_directory_uri() . '/assets/js/infinite' . shark_business_pro_min() . '.js', array( 'jquery' ), '', true );
	}
}
add_action( 'wp_enqueue_scripts', 'shark_business_pro_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
* TGM plugin additions.
*/
require get_template_directory() . '/inc/tgm-plugin/tgm-hook.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * WooCommerce plugin compatibility.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * OCDI plugin demo importer compatibility.
 */
if ( class_exists( 'OCDI_Plugin' ) ) {
    require get_template_directory() . '/inc/demo-import.php';
}

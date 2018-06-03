<?php
/**
 * Functions which construct the theme by hooking into WordPress
 *
 * @package shark_business_pro
 */


/*------------------------------------------------
            HEADER HOOK
------------------------------------------------*/

if ( ! function_exists( 'shark_business_pro_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_doctype() { ?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php }
endif;
add_action( 'shark_business_pro_doctype_action', 'shark_business_pro_doctype', 10 );

if ( ! function_exists( 'shark_business_pro_head' ) ) :
	/**
	 * head Codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_head() { ?>
		<head>
			<meta charset="<?php bloginfo( 'charset' ); ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
			<link rel="profile" href="http://gmpg.org/xfn/11">
			<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
				<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
			<?php endif; ?>
			<?php wp_head(); ?>
		</head>
	<?php }
endif;
add_action( 'shark_business_pro_head_action', 'shark_business_pro_head', 10 );

if ( ! function_exists( 'shark_business_pro_body_start' ) ) :
	/**
	 * Body start codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_body_start() { ?>
		<body <?php body_class(); ?>>
	<?php }
endif;
add_action( 'shark_business_pro_body_start_action', 'shark_business_pro_body_start', 10 );


if ( ! function_exists( 'shark_business_pro_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_page_start() { ?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'shark-business-pro' ); ?></a>
	<?php }
endif;
add_action( 'shark_business_pro_page_start_action', 'shark_business_pro_page_start', 10 );


if ( ! function_exists( 'shark_business_pro_loader' ) ) :
	/**
	 * loader html codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_loader() { 
		if ( ! shark_business_pro_theme_option( 'enable_loader' ) )
			return;
		
		$loader = shark_business_pro_theme_option( 'loader_type' )
		?>
		<div id="loader">
            <div class="loader-container">
               	<?php echo shark_business_pro_get_svg( array( 'icon' => esc_attr( $loader ) ) ); ?>
            </div>
        </div><!-- #loader -->
	<?php }
endif;
add_action( 'shark_business_pro_page_start_action', 'shark_business_pro_loader', 20 );


if ( ! function_exists( 'shark_business_pro_top_bar' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_top_bar() { 
		if ( ! shark_business_pro_theme_option( 'enable_topbar' ) )
			return;

		$address 	= shark_business_pro_theme_option( 'topbar_address' );
		$phone 		= shark_business_pro_theme_option( 'topbar_phone' );
		$email 		= shark_business_pro_theme_option( 'topbar_email' );
		?>
		<div id="top-menu">
            <?php 
            echo shark_business_pro_get_svg( array( 'icon' => 'up', 'class' => 'dropdown-icon' ) );
            echo shark_business_pro_get_svg( array( 'icon' => 'down', 'class' => 'dropdown-icon' ) ); 
            ?>
            
            <div class="wrapper">
                <div class="secondary-menu">
                	<ul class="menu">
                		<?php if ( ! empty( $address ) ) : ?>
	                		<li>
	                			<?php 
                        		echo shark_business_pro_get_svg( array( 'icon' => 'location-o' ) ); 
		                        echo esc_html( $address ); 
		                        ?>
	                		</li>
	                	<?php endif;
	                	
	                	if ( ! empty( $phone ) ) : ?>
	                		<li><a href="<?php echo esc_url( 'tel:' . $phone ); ?>">
	                			<?php 
                        		echo shark_business_pro_get_svg( array( 'icon' => 'phone-o' ) ); 
		                        echo esc_html( $phone ); 
		                        ?>
	                		</a></li>
                		<?php endif;
	                	
	                	if ( ! empty( $email ) ) : ?>
	                		<li><a href="<?php echo esc_url( 'mailto:' . $email ); ?>">
	                			<?php 
                        		echo shark_business_pro_get_svg( array( 'icon' => 'envelope-o' ) ); 
		                        echo esc_html( $email ); 
		                        ?>
	                		</a></li>
	                	<?php endif; ?>
                	</ul>
                </div><!-- .secondary-menu -->

	            <?php if ( shark_business_pro_theme_option( 'show_top_search' ) ) : ?>
		            <div id="top-search" class="social-menu">
	                	<ul>
	                		<li>
	                			<div id="search"><?php get_search_form(); ?></div>
	                			<a href="#" class="search">
	                				<?php echo shark_business_pro_get_svg( array( 'icon' => 'search' ) ); ?>
	            				</a>
	                		</li>
	                	</ul>
	                </div>
	            <?php endif;

	            if ( shark_business_pro_theme_option( 'show_social_menu' ) && has_nav_menu( 'social' ) ) : ?>
	                <div class="social-menu">
	                    <?php  
	                	wp_nav_menu( array(
	                		'theme_location'  	=> 'social',
	                		'container' 		=> false,
	                		'menu_class'      	=> 'menu',
	                		'depth'           	=> 1,
	            			'link_before' 		=> '<span class="screen-reader-text">',
							'link_after' 		=> '</span>',
	                	) );
	                	?>
	                </div><!-- .social-menu -->
                <?php endif; ?>
            </div><!-- .wrapper -->
        </div><!-- #top-menu -->
	<?php }
endif;
add_action( 'shark_business_pro_page_start_action', 'shark_business_pro_top_bar', 20 );


if ( ! function_exists( 'shark_business_pro_header_start' ) ) :
	/**
	 * Header starts html codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_header_start() { 
		$sticky_header = shark_business_pro_theme_option( 'enable_sticky_header' ) ? 'sticky-header' : ''; 
		?>
		<header id="masthead" class="site-header <?php echo esc_attr( $sticky_header ); ?>">
		<div class="wrapper">
	<?php }
endif;
add_action( 'shark_business_pro_header_start_action', 'shark_business_pro_header_start', 10 );


if ( ! function_exists( 'shark_business_pro_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_site_branding() { ?>
		<div class="site-menu">
            <div class="container">
				<div class="site-branding pull-left">
					<?php
					// site logo
					the_custom_logo();
					?>
					<div class="site-details">
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php endif;

						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
						<?php endif; ?>
					</div><!-- .site-details -->
				</div><!-- .site-branding -->
	<?php }
endif;
add_action( 'shark_business_pro_site_branding_action', 'shark_business_pro_site_branding', 10 );


if ( ! function_exists( 'shark_business_pro_primary_nav' ) ) :
	/**
	 * Primary nav codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_primary_nav() { ?>
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
            <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'shark-business-pro' ); ?></span>
            <svg viewBox="0 0 40 40" class="icon-menu">
                <g>
                    <rect y="7" width="40" height="2"/>
                    <rect y="19" width="40" height="2"/>
                    <rect y="31" width="40" height="2"/>
                </g>
            </svg>
            <?php echo shark_business_pro_get_svg( array( 'icon' => 'close' ) ); ?>
        </button>
		<nav id="site-navigation" class="main-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
        			'container' => false,
        			'menu_class' => 'menu nav-menu',
        			'menu_id' => 'primary-menu',
        			'fallback_cb' => 'shark_business_pro_menu_fallback_cb',
				) );
			?>
		</nav><!-- #site-navigation -->
		</div><!-- .container -->
        </div><!-- .site-menu -->
	<?php }
endif;
add_action( 'shark_business_pro_primary_nav_action', 'shark_business_pro_primary_nav', 10 );


if ( ! function_exists( 'shark_business_pro_header_ends' ) ) :
	/**
	 * Header ends codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_header_ends() { ?>
		</div><!-- .wrapper -->
		</header><!-- #masthead -->
	<?php }
endif;
add_action( 'shark_business_pro_header_ends_action', 'shark_business_pro_header_ends', 10 );


if ( ! function_exists( 'shark_business_pro_site_content_start' ) ) :
	/**
	 * Site content start codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_site_content_start() { ?>
		<div id="content" class="site-content">
	<?php }
endif;
add_action( 'shark_business_pro_site_content_start_action', 'shark_business_pro_site_content_start', 10 );


/**
 * Display custom header title in frontpage and blog
 */
function shark_business_pro_custom_header_title() {
	if ( is_home() && is_front_page() ) : 
		$title = shark_business_pro_theme_option( 'latest_blog_title', 'Blogs' ); ?>
		<h2><?php echo esc_html( $title ); ?></h2>
	<?php elseif ( is_singular() || ( is_home() && ! is_front_page() ) ): ?>
		<h2><?php single_post_title(); ?></h2>
	<?php elseif ( class_exists( 'WooCommerce' ) && is_shop() ) : ?>
    	<h2><?php woocommerce_page_title(); ?></h2>
    <?php elseif ( is_archive() ) : 
		the_archive_title( '<h2>', '</h2>' );
	elseif ( is_search() ) : ?>
		<h2><?php printf( esc_html__( 'Search Results for: %s', 'shark-business-pro' ), get_search_query() ); ?></h2>
	<?php elseif ( is_404() ) :
		echo '<h2>' . esc_html__( 'Oops! That page can&#39;t be found.', 'shark-business-pro' ) . '</h2>';
	endif;
}


if ( ! function_exists( 'shark_business_pro_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_add_breadcrumb() {
		// Bail if Breadcrumb disabled.
		if ( ! shark_business_pro_theme_option( 'enable_breadcrumb' ) ) {
			return;
		}
		
		// Bail if Home Page.
		if ( ! is_home() && is_front_page() ) {
			return;
		}

		echo '<div id="breadcrumb-list" >';
				/**
				 * shark_business_pro_breadcrumb hook
				 *
				 * @hooked shark_business_pro_breadcrumb -  10
				 *
				 */
				do_action( 'shark_business_pro_breadcrumb' );
		echo '</div><!-- #breadcrumb-list -->';
		return;
	}
endif;


if ( ! function_exists( 'shark_business_pro_custom_header' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Shark Business Pro 1.0.0
	 *
	 */
	function shark_business_pro_custom_header() {
		if ( ! is_home() && is_front_page() ) {
			return;
		}
		
		if ( is_singular() && has_post_thumbnail() ) :
			$image = get_the_post_thumbnail_url( get_the_id(), 'full' );
		elseif ( class_exists( 'WooCommerce' ) && is_shop() && has_post_thumbnail( get_option( 'woocommerce_shop_page_id' ) ) ) :
			$image = get_the_post_thumbnail_url( get_option( 'woocommerce_shop_page_id' ), 'full' );
		else : 
			$image = get_header_image() ? get_header_image() : get_template_directory_uri() . '/assets/uploads/banner.jpg';
		endif; ?>

        <div class="inner-header-image" style="background-image: url( '<?php echo esc_url( $image ); ?>' )">
        	<div class="overlay"></div>
        	<div class="wrapper">
                <div class="custom-header-content">
                    <?php echo shark_business_pro_custom_header_title(); ?>
                    <div class="separator"></div>
                    <?php shark_business_pro_add_breadcrumb(); ?>
                </div><!-- .custom-header-content -->
        	</div><!-- .wrapper -->
        </div><!-- .custom-header-content-wrapper -->
		<?php
	}
endif;
add_action( 'shark_business_pro_site_content_start_action', 'shark_business_pro_custom_header', 20 );


/*------------------------------------------------
            FOOTER HOOK
------------------------------------------------*/

if ( ! function_exists( 'shark_business_pro_site_content_ends' ) ) :
	/**
	 * Site content ends codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_site_content_ends() { ?>
		</div><!-- #content -->
	<?php }
endif;
add_action( 'shark_business_pro_site_content_ends_action', 'shark_business_pro_site_content_ends', 10 );


if ( ! function_exists( 'shark_business_pro_footer_start' ) ) :
	/**
	 * Footer start codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_footer_start() { ?>
		<footer id="colophon" class="site-footer">
	<?php }
endif;
add_action( 'shark_business_pro_footer_start_action', 'shark_business_pro_footer_start', 10 );


if ( ! function_exists( 'shark_business_pro_site_info' ) ) :
	/**
	 * Site info codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_site_info() { 
		$copyright = shark_business_pro_theme_option('copyright_text');
		?>
		<div class="site-info">
            <div class="wrapper">
            	<?php if ( ! empty( $copyright ) ) : ?>
	                <div class="copyright">
	                    <p>
		                    <?php echo shark_business_pro_santize_allow_tags( $copyright ); ?>
	                    </p>
	                </div><!-- .copyright -->
	            <?php endif; 

	            if ( ! empty( $copyright ) ) : ?>
	                <div class="powered-by">
	                    <?php
							wp_nav_menu( array(
								'theme_location' => 'footer',
			        			'container' => false,
			        			'menu_class' => 'menu nav-menu',
			        			'menu_id' => 'footer-menu',
			        			'fallback_cb' => 'shark_business_pro_menu_fallback_cb',
							) );
						?>
	                </div><!-- .powered-by -->
	            <?php endif; ?>
            </div><!-- .wrapper -->    
        </div><!-- .site-info -->
	<?php }
endif;
add_action( 'shark_business_pro_site_info_action', 'shark_business_pro_site_info', 10 );


if ( ! function_exists( 'shark_business_pro_footer_ends' ) ) :
	/**
	 * Footer ends codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_footer_ends() { ?>
		</footer><!-- #colophon -->
	<?php }
endif;
add_action( 'shark_business_pro_footer_ends_action', 'shark_business_pro_footer_ends', 10 );


if ( ! function_exists( 'shark_business_pro_slide_to_top' ) ) :
	/**
	 * Footer ends codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_slide_to_top() { ?>
		<div class="backtotop">
            <?php echo shark_business_pro_get_svg( array( 'icon' => 'up' ) ); ?>
        </div><!-- .backtotop -->
	<?php }
endif;
add_action( 'shark_business_pro_footer_ends_action', 'shark_business_pro_slide_to_top', 20 );


if ( ! function_exists( 'shark_business_pro_page_ends' ) ) :
	/**
	 * Page ends codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_page_ends() { ?>
		</div><!-- #page -->
	<?php }
endif;
add_action( 'shark_business_pro_page_ends_action', 'shark_business_pro_page_ends', 10 );


if ( ! function_exists( 'shark_business_pro_body_html_ends' ) ) :
	/**
	 * Body & Html ends codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_body_html_ends() { ?>
		</body>
		</html>
	<?php }
endif;
add_action( 'shark_business_pro_body_html_ends_action', 'shark_business_pro_body_html_ends', 10 );

if ( ! function_exists( 'shark_business_pro_infinite_loader' ) ) :
	/**
	 * infinite loader codes
	 *
	 * @since Shark Business Pro 1.0.0
	 */
	function shark_business_pro_infinite_loader() { 
		global $post;
		if ( 'infinite' == shark_business_pro_theme_option( 'pagination_type' ) ) :
			if ( count( $post ) > 0 ) {
				echo '<div class="blog-loader">' . shark_business_pro_get_svg( array( 'icon' => 'spinner-umbrella' ) ) . '</div>';
			}
		endif;
	}
endif;
add_action( 'shark_business_pro_infinite_loader_action', 'shark_business_pro_infinite_loader', 10 );

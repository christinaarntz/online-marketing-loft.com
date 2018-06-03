<?php
/**
 * Template Name: Service Page
 * The template for displaying service page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package shark_business_pro
 */

get_header(); ?>

<div class="single-template-wrapper wrapper page-section">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div>

<?php 
if ( is_active_sidebar( 'service-page-area' ) ) :
	dynamic_sidebar( 'service-page-area' );
endif;

get_footer();

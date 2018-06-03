<?php
/**
 * Slider hook
 *
 * @package shark_business_pro
 */

if ( ! function_exists( 'shark_business_pro_add_slider_section' ) ) :
    /**
    * Add slider section
    *
    *@since Shark Business Pro 1.0.0
    */
    function shark_business_pro_add_slider_section() {

        // Check if slider is enabled on frontpage
        $slider_enable = apply_filters( 'shark_business_pro_section_status', 'enable_slider', 'slider_entire_site' );

        if ( ! $slider_enable )
            return false;

        // Get slider section details
        $section_details = array();
        $section_details = apply_filters( 'shark_business_pro_filter_slider_section_details', $section_details );

        if ( empty( $section_details ) ) 
            return;

        // Render slider section now.
        shark_business_pro_render_slider_section( $section_details );
    }
endif;
add_action( 'shark_business_pro_primary_content_action', 'shark_business_pro_add_slider_section', 10 );


if ( ! function_exists( 'shark_business_pro_get_slider_section_details' ) ) :
    /**
    * slider section details.
    *
    * @since Shark Business Pro 1.0.0
    * @param array $input slider section details.
    */
    function shark_business_pro_get_slider_section_details( $input ) {

        // Content type.
        $slider_content_type  = shark_business_pro_theme_option( 'slider_content_type' );
        $slider_count  = shark_business_pro_theme_option( 'slider_count', 3 );
        $content = array();
        switch ( $slider_content_type ) {

            case 'custom':
                for ( $i = 1; $i <= $slider_count; $i++ ) :
                    $custom['title']        =  shark_business_pro_theme_option( 'slider_custom_title_' . $i );
                    $custom['url']          =  shark_business_pro_theme_option( 'slider_custom_link_' . $i );
                    $custom['image']        =  shark_business_pro_theme_option( 'slider_custom_image_' . $i );
                    $custom['excerpt']      =  shark_business_pro_theme_option( 'slider_custom_description_' . $i );

                    array_push( $content, $custom );
                endfor;
            break;

            case 'page':
                $page_ids = array();

                for ( $i = 1; $i <= $slider_count; $i++ )  :
                    $page_ids[] = shark_business_pro_theme_option( 'slider_content_page_' . $i );;
                endfor;
                
                $args = array(
                    'post_type'         => 'page',
                    'post__in'          =>  ( array ) $page_ids,
                    'posts_per_page'    => absint( $slider_count ),
                    'orderby'           => 'post__in',
                    );                    
            break;

            case 'post':
                $post_ids = array();

                for ( $i = 1; $i <= $slider_count; $i++ )  :
                    $post_ids[] = shark_business_pro_theme_option( 'slider_content_post_' . $i );;
                endfor;
                
                $args = array(
                    'post_type'         => 'post',
                    'post__in'          =>  ( array ) $post_ids,
                    'posts_per_page'    => absint( $slider_count ),
                    'orderby'           => 'post__in',
                    );                    
            break;

            default:
            break;
        }

        if ( in_array( $slider_content_type, array( 'page', 'post' ) ) ) {

            // Run The Loop.
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['title']     = get_the_title();
                    $page_post['url']       = get_the_permalink();
                    $page_post['excerpt']   = shark_business_pro_trim_content( 25 );
                    $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : '';

                    // Push to the main array.
                    array_push( $content, $page_post );
                endwhile;
            endif;
            wp_reset_postdata();
        }
            
        if ( ! empty( $content ) )
            $input = $content;
       
        return $input;
    }
endif;
// slider section content details.
add_filter( 'shark_business_pro_filter_slider_section_details', 'shark_business_pro_get_slider_section_details' );


if ( ! function_exists( 'shark_business_pro_render_slider_section' ) ) :
  /**
   * Start slider section
   *
   * @return string slider content
   * @since Shark Business Pro 1.0.0
   *
   */
   function shark_business_pro_render_slider_section( $content_details = array() ) {
        if ( empty( $content_details ) )
            return;

        $slider_control = shark_business_pro_theme_option( 'slider_arrow' );
        ?>
    	<div id="custom-header">
            <div class="section-content banner-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1200, "dots": false, "arrows":<?php echo $slider_control ? 'true' : 'false'; ?>, "autoplay": true, "fade": true, "draggable": true }'>
                <?php foreach ( $content_details as $content ) : ?>
                    <div class="custom-header-content-wrapper slide-item">
                        <?php if ( ! empty( $content['image'] ) ) : ?>
                            <img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>">
                        <?php endif; ?>
                        <div class="overlay"></div>
                        <div class="wrapper">
                            <div class="custom-header-content">
                                <?php if ( ! empty( $content['title'] ) ) : ?>
                                    <h2><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                <?php endif; 

                                if ( ! empty( $content['excerpt'] ) ) : ?>
                                    <p><?php echo wp_kses_post( $content['excerpt'] ); ?></p>
                                <?php endif; ?>
                                <div class="separator"></div>
                            </div><!-- .custom-header-content -->
                        </div>
                    </div><!-- .custom-header-content-wrapper -->
                <?php endforeach; ?>
            </div><!-- .wrapper -->

            <?php if ( shark_business_pro_theme_option( 'enable_slider_wave', false ) ) : ?>
                <div class="wave-saperator">
                    <?php echo shark_business_pro_get_svg( array( 'icon' => 'wave' ) ); ?>
                </div>
            <?php endif; ?>
        </div><!-- #custom-header -->
    <?php 
    }
endif;
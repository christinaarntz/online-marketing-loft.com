<?php
/**
 * Recent Widget
 *
 * @package shark_business_pro
 */

if ( ! class_exists( 'Shark_Business_Pro_Recent_Widget' ) ) :

     
    class Shark_Business_Pro_Recent_Widget extends WP_Widget {
        /**
         * Sets up the widgets name etc
         */
        public function __construct() {
            $st_widget_recent = array(
                'classname'   => 'recent_widget',
                'description' => esc_html__( 'Compatible Area: Homepage, About page, Service Page', 'shark-business-pro' ),
            );
            parent::__construct( 'shark_business_pro_recent_widget', esc_html__( 'ST: Recent Widget', 'shark-business-pro' ), $st_widget_recent );
        }

        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */
        public function widget( $args, $instance ) {
            // outputs the content of the widget
            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }

            $title   = ( ! empty( $instance['title'] ) ) ? ( $instance['title'] ) : '';
            $title   = apply_filters( 'widget_title', $title, $instance, $this->id_base );
            $sub_title   = ( ! empty( $instance['sub_title'] ) ) ? ( $instance['sub_title'] ) : '';
            $count   = isset( $instance['count'] ) ? $instance['count'] : 3;
            $column  = isset( $instance['column'] ) ? $instance['column'] : 'column-3';
            $excerpt_length  = isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 20;
            $content_type  = isset( $instance['content_type'] ) ? $instance['content_type'] : 'recent';
            $content_details = array();

            switch ($content_type) {
                case 'post':
                    $post_ids = array();
                    for ( $i = 1; $i <= $count; $i++ ) :
                        if ( ! empty( $instance['post_id_' . $i] ) ) :
                            $post_ids[]  = $instance['post_id_' . $i];
                        endif;
                    endfor;
                    $query_args = array(
                    'post_type'         => 'post',
                    'post__in'          => ( array ) $post_ids,
                    'posts_per_page'    => absint( $count ),
                    'orderby'           => 'post__in',
                    'ignore_sticky_posts' => true,
                    ); 
                break;

                case 'recent':
                    $query_args = array(
                    'post_type'         => 'post',
                    'posts_per_page'    => absint( $count ),
                    'ignore_sticky_posts' => true,
                    ); 
                break;

                case 'category':
                    $cat_id = ! empty( $instance['cat_id'] ) ? $instance['cat_id'] : '';
                    $query_args = array(
                        'post_type'         => 'post',
                        'posts_per_page'    => absint( $count ),
                        'cat'               => absint( $cat_id ),
                        'ignore_sticky_posts' => true,
                        ); 
                break;
                
                default:
                break;
            }

            $query = new WP_Query( $query_args );

            echo $args['before_widget'];
            ?>

                <div id="popular-posts" class="page-section relative">
                    <div class="wrapper">
                        <?php if ( ! empty( $title ) || ! empty( $sub_title ) ) : ?>
                            <div class="section-header align-center">
                                <?php if ( ! empty( $title ) ) :
                                    echo $args['before_title'] . esc_html( $title ) . $args['after_title']; ?>
                                    <div class="separator"></div>
                                <?php endif;
                                
                                if ( ! empty( $sub_title ) ) : ?>
                                    <p class="section-description"><?php echo wp_kses_post( $sub_title ); ?></p>
                                <?php endif; ?>
                            </div><!-- .section-header -->
                        <?php endif; ?>

                        <div class="section-content <?php echo esc_attr( $column ); ?>">
                            <?php if ( $query -> have_posts() ) : 
                                while ( $query -> have_posts() ) : $query -> the_post(); ?>
                                    <article class="hentry">
                                        <div class="post-wrapper">
                                            <?php if ( has_post_thumbnail() ) : ?>
                                                <div class="featured-image">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
                                                    </a>
                                                </div><!-- .recent-image -->
                                            <?php endif; ?>

                                            <div class="entry-container">
                                                <header class="entry-header">
                                                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                                    
                                                    <?php shark_business_pro_posted_on(); ?>
                                                </header>

                                                <div class="entry-content">
                                                    <p><?php echo esc_html( shark_business_pro_trim_content( absint( $excerpt_length ) ) ); ?></p>
                                                </div><!-- .entry-content -->

                                                <div class="entry-meta">
                                                    <?php shark_business_pro_entry_footer(); ?>
                                                </div><!-- .entry-meta -->
                                            </div><!-- .entry-container -->
                                        </div><!-- .post-wrapper -->
                                    </article>
                                <?php endwhile; 
                            endif;
                            wp_reset_postdata(); ?>
                        </div><!-- .section-content -->
                    </div><!-- .wrapper -->
                </div><!-- #popular-posts -->

            <?php
            echo $args['after_widget'];
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form( $instance ) {
            $title      = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'shark-business-pro' );
            $sub_title   = isset( $instance['sub_title'] ) ? $instance['sub_title'] : esc_html__( 'Quickly and simply build a personalized website to showcase your latest blogs with Recent Widget', 'shark-business-pro' );
            $count      = isset( $instance['count'] ) ? $instance['count'] : 3;
            $column     = isset( $instance['column'] ) ? $instance['column'] : 'column-3';
            $excerpt_length = isset( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 20;
            $content_type   = isset( $instance['content_type'] ) ? $instance['content_type'] : 'recent';
            $cat_id     = isset( $instance['cat_id'] ) ? $instance['cat_id'] : '';

            $page_options = shark_business_pro_page_choices();
            $post_options = shark_business_pro_post_choices();
            $category_options = shark_business_pro_category_choices();
            $content_type_options = array(
                'recent'    => esc_html__( 'Recent Posts', 'shark-business-pro' ),
                'post'      => esc_html__( 'Post', 'shark-business-pro' ),
                'category'  => esc_html__( 'Category', 'shark-business-pro' ),
            );
            $column_options = array(
                'column-2'  => esc_html__( 'Two Column', 'shark-business-pro' ),
                'column-3'  => esc_html__( 'Three Column', 'shark-business-pro' ),
                'column-4'  => esc_html__( 'Four Column', 'shark-business-pro' ),
            );
            ?>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>"><?php esc_html_e( 'Sub Title:', 'shark-business-pro' ); ?></label>
                <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('sub_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sub_title' ) ); ?>" ><?php echo esc_html( $sub_title ); ?></textarea>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'column' ) ); ?>"><?php esc_html_e( 'Column Layout', 'shark-business-pro' ); ?></label>
                <select class="widfat" id="<?php echo esc_attr( $this->get_field_id( 'column' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'column' ) ); ?>" style="width:100%">
                    <?php foreach ( $column_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $column, $key, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'No of Recent Posts:', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('count') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="2" max="12" value="<?php echo absint( $count ); ?>" />
                <small><?php esc_html_e( 'Note: Min 2 & Max 12. Please save the settings to see the change.', 'shark-business-pro' ); ?></small>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php esc_html_e( 'Excerpt Length:', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('excerpt_length') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" min="5" max="50" value="<?php echo absint( $excerpt_length ); ?>" />
                <small><?php esc_html_e( 'Note: Min 5 & Max 50.', 'shark-business-pro' ); ?></small>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'content_type' ) ); ?>"><?php esc_html_e( 'Content Type', 'shark-business-pro' ); ?></label>
                <select class="content-type widfat" id="<?php echo esc_attr( $this->get_field_id( 'content_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_type' ) ); ?>" style="width:100%">
                    <?php foreach ( $content_type_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $content_type, $key, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <hr style = "height: 2px;">
            
            <div class="post <?php echo ( 'post' == $content_type ) ? 'block' : 'none' ?>" >
               <?php for ( $i = 1; $i <= $count; $i++ ) : 
                    $post_id = isset( $instance['post_id_' . $i] ) ? $instance['post_id_' . $i] : ''; ?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'post_id_' . $i ) ); ?>"><?php printf( esc_html__( 'Select Post %d', 'shark-business-pro' ), $i ); ?></label>
                        <select class="shark-business-pro-widget-chosen-select widfat" id="<?php echo esc_attr( $this->get_field_id( 'post_id_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_id_' . $i ) ); ?>">
                            <?php foreach ( $post_options as $post_option => $value ) : ?>
                                <option value="<?php echo absint( $post_option ); ?>" <?php selected( $post_id, $post_option, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                <?php endfor; ?>
            </div>

            <div class="category <?php echo ( 'category' == $content_type ) ? 'block' : 'none' ?>" >
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'cat_id' ) ); ?>"><?php echo esc_html__( 'Select Category', 'shark-business-pro' ); ?></label>
                    <select class="shark-business-pro-widget-chosen-select widfat" id="<?php echo esc_attr( $this->get_field_id( 'cat_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat_id' ) ); ?>">
                        <?php foreach ( $category_options as $category_option => $value ) : ?>
                            <option value="<?php echo absint( $category_option ); ?>" <?php selected( $cat_id, $category_option, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>

        <?php }

        /**
        * Processing widget options on save
        *
        * @param array $new_instance The new options
        * @param array $old_instance The previous options
        */
        public function update( $new_instance, $old_instance ) {
            // processes widget options to be saved
            $instance                   = $old_instance;
            $instance['title']          = sanitize_text_field( $new_instance['title'] );
            $instance['sub_title']      = wp_kses_post( $new_instance['sub_title'] );
            $instance['count']          = absint( $new_instance['count'] );
            $instance['excerpt_length'] = absint( $new_instance['excerpt_length'] );
            $instance['column']         = sanitize_key( $new_instance['column'] );      
            $instance['content_type']   = sanitize_key( $new_instance['content_type'] );
            for ( $i = 1; $i <= $new_instance['count']; $i++ ) :
                $instance['post_id_' . $i]   = shark_business_pro_sanitize_page_post( $new_instance['post_id_' . $i] );
            endfor;
            $instance['cat_id']         = shark_business_pro_sanitize_category( $new_instance['cat_id'] );
           
            return $instance;
        }
    }
endif;

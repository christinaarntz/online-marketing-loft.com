<?php
/**
 * Latest Post Widget
 *
 * @package shark_business_pro
 */

if ( ! class_exists( 'Shark_Business_Pro_Latest_Post_Widget' ) ) :

     
    Class Shark_Business_Pro_Latest_Post_Widget extends WP_Widget {
        /**
         * Sets up the widgets name etc
         */
        public function __construct() {
            $widget_popular_post = array(
                'classname'   => 'widget_latest_post',
                'description' => esc_html__( 'Compatible Area: Sidebar, Footer', 'shark-business-pro' ),
            );
            parent::__construct( 'latest_post', esc_html__( 'ST : Latest Posts Widget', 'shark-business-pro' ), $widget_popular_post );
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

            $title  = ( ! empty( $instance['title'] ) ) ? ( $instance['title'] ) : '';
            $title  = apply_filters( 'widget_title', $title, $instance, $this->id_base );
            $count  = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
            $content_type   = isset( $instance['content_type'] ) ? $instance['content_type'] : 'recent';
            $cat_id     = isset( $instance['cat_id'] ) ? $instance['cat_id'] : '';

            switch ($content_type) {
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

            echo $args['before_widget'];
            echo '<ul>';
                if ( ! empty( $title ) ) {
                    echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
                }

            $query = new WP_Query( $query_args );
            if ( $query -> have_posts() ) : while ( $query -> have_posts() ) : $query -> the_post();
            ?>

                <li class="latest-post clear">
                    <div class="post-image">
                        <a href="<?php the_permalink(); ?>">
                            <?php 
                            if ( has_post_thumbnail() ) :
                                the_post_thumbnail( 'thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) );
                            endif; 
                            ?>
                        </a>
                    </div><!-- .post-image-->
                    <div class="post-content">
                        <div class="post-title">
                            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        </div><!-- .post-title -->
                         <div class="entry-meta">
                            <?php echo date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) ); ?>
                        </div>
                    </div><!-- .post-content -->
                </li>

            <?php
            endwhile; endif;
            echo '</ul>';
            echo $args['after_widget'];
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form( $instance ) {
            $title      = isset( $instance['title'] ) ? ( $instance['title'] ) : esc_html__( 'Latest Posts', 'shark-business-pro' );
            $count     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
            $content_type   = isset( $instance['content_type'] ) ? $instance['content_type'] : 'recent';
            $cat_id     = isset( $instance['cat_id'] ) ? $instance['cat_id'] : '';
            $category_options = shark_business_pro_category_choices();
            $content_type_options = array(
                'recent'    => esc_html__( 'Recent Posts', 'shark-business-pro' ),
                'category'  => esc_html__( 'Category', 'shark-business-pro' ),
            );
           ?>

           <p>
               <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'shark-business-pro' ); ?></label>
               <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
           </p>

           <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'shark-business-pro' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" max="7" value="<?php echo absint( $count ); ?>" size="3" />
           </p>

           <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'content_type' ) ); ?>"><?php esc_html_e( 'Content Type', 'shark-business-pro' ); ?></label>
                <select class="content-type widfat" id="<?php echo esc_attr( $this->get_field_id( 'content_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_type' ) ); ?>" style="width:100%">
                    <?php foreach ( $content_type_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $content_type, $key, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

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

           <?php
        }

        /**
        * Processing widget options on save
        *
        * @param array $new_instance The new options
        * @param array $old_instance The previous options
        */
        public function update( $new_instance, $old_instance ) {
            // processes widget options to be saved
            $instance           = $old_instance;
            $instance['title']  = sanitize_text_field( $new_instance['title'] );
            $instance['number'] = absint( $new_instance['number'] );
            $instance['content_type'] = sanitize_key( $new_instance['content_type'] );
            $instance['cat_id']         = shark_business_pro_sanitize_category( $new_instance['cat_id'] );

            return $instance;
        }
    }
endif;

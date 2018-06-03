<?php
/**
 * Author Widget
 *
 * @package shark_business_pro
 */

if ( ! class_exists( 'Shark_Business_Pro_Author_Widget' ) ) :

     
    class Shark_Business_Pro_Author_Widget extends WP_Widget {
        /**
         * Sets up the widgets name etc
         */
        public function __construct() {
            $st_widget_author = array(
                'classname'   => 'author_widget',
                'description' => esc_html__( 'Compatible Area: Homepage, About Page, Service Page, Sidebar, Footer', 'shark-business-pro' ),
            );
            parent::__construct( 'shark_business_pro_author_widget', esc_html__( 'ST: Author Widget', 'shark-business-pro' ), $st_widget_author );
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
            $content_type  = isset( $instance['content_type'] ) ? $instance['content_type'] : 'page';
            $social_link  = isset( $instance['social_link'] ) ? $instance['social_link'] : '';
            $content_details = array();

            switch ($content_type) {
                case 'page':
                    $page_id  = isset( $instance['page_id'] ) ? $instance['page_id'] : '';
                    $query_args = array(
                        'post_type' => 'page',
                        'page_id' => absint( $page_id ),
                        'posts_per_page' => 1,
                    );
                break;

                case 'post':
                    $post_id  = isset( $instance['post_id'] ) ? $instance['post_id'] : '';
                    $query_args = array(
                        'post_type' => 'post',
                        'p' => absint( $post_id ),
                        'ignore_sticky_posts' => true,
                        'posts_per_page' => 1,
                    );
                break;

                case 'custom':
                    $details['title']  = isset( $instance['author_title'] ) ? $instance['author_title'] : '';
                    $details['content']  = isset( $instance['author_content'] ) ? $instance['author_content'] : '';
                    $details['image']  = isset( $instance['author_image_url'] ) ? $instance['author_image_url'] : '';
                    array_push( $content_details , $details );
                break;
                
                default:
                break;
            }

            if ( in_array( $content_type, array( 'page', 'post' ) ) ) :
                $query = new WP_Query( $query_args );
                if ( $query -> have_posts() ) : while ( $query -> have_posts() ) : $query -> the_post();
                    $details['title']  = get_the_title();
                    $details['content'] = get_the_content();
                    $details['image']  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'thumbnail' ) : '';
                    array_push( $content_details , $details );
                endwhile; endif;
                wp_reset_postdata();
            endif;

            if ( empty( $content_details ) )
                return;

            echo $args['before_widget'];

            foreach ( $content_details as $content ) : ?>
                <div id="message-from-author" class="page-section relative">
                    <div class="wrapper">
                        <div class="section-content">
                            <?php if ( ! empty( $content['image'] ) ) : ?>
                                <div class="author-thumbnail">
                                    <img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>">
                                </div><!-- .author-thumbnail -->
                            <?php endif; 

                            if ( ! empty( $title ) ) :
                                echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
                            endif;

                            if ( ! empty( $content['content'] ) ) : ?>
                                <div class="entry-content">
                                    <p><?php echo wp_kses_post( $content['content'] ); ?></p>
                                </div><!-- .entry-content -->
                            <?php endif; 

                            if ( ! empty( $content['title'] ) ) : ?>
                                <header class="entry-header">
                                    <h2 class="entry-title"><?php echo esc_html( $content['title'] ); ?></h2>
                                </header>
                            <?php endif;

                            if ( ! empty( $social_link ) ) : 
                                $social_link = explode( '|', $social_link ); ?>

                                <div class="separator"></div>

                                <div class="share-message">
                                    <ul class="social-icons">
                                        <?php foreach ( $social_link as $social ) : ?>
                                            <li>
                                                <a href="<?php echo esc_url( $social ); ?>" target="_blank"><?php echo shark_business_pro_return_social_icon( $social ); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div><!-- .share-message -->
                            <?php endif; ?>
                        </div><!-- .section-content -->
                    </div><!-- .wrapper -->
                </div><!-- #message-from-author -->
            <?php endforeach;

            echo $args['after_widget'];
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form( $instance ) {
            $title       = isset( $instance['title'] ) ? ( $instance['title'] ) : esc_html__( 'Author', 'shark-business-pro' );
            $content_type   = isset( $instance['content_type'] ) ? $instance['content_type'] : 'page';
            $page_id        = isset( $instance['page_id'] ) ? $instance['page_id'] : '';
            $post_id        = isset( $instance['post_id'] ) ? $instance['post_id'] : '';
            $author_title    = isset( $instance['author_title'] ) ? $instance['author_title'] : '';
            $author_content  = isset( $instance['author_content'] ) ? $instance['author_content'] : '';
            $author_image_url  = isset( $instance['author_image_url'] ) ? $instance['author_image_url'] : '';
            $social_link  = isset( $instance['social_link'] ) ? $instance['social_link'] : '';

            $page_options = shark_business_pro_page_choices();
            $post_options = shark_business_pro_post_choices();
            $content_type_options = array(
                'page'      => esc_html__( 'Page', 'shark-business-pro' ),
                'post'      => esc_html__( 'Post', 'shark-business-pro' ),
                'custom'    => esc_html__( 'Custom', 'shark-business-pro' ), 
            );
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'content_type' ) ); ?>"><?php esc_html_e( 'Content Type', 'shark-business-pro' ); ?></label>
                <select class="content-type widfat" id="<?php echo esc_attr( $this->get_field_id( 'content_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_type' ) ); ?>" style="width:100%">
                    <?php foreach ( $content_type_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $content_type, $key, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <div class="page <?php echo ( 'page' == $content_type ) ? 'block' : 'none' ?>" >
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'page_id' ) ); ?>"><?php esc_html_e( 'Select Page', 'shark-business-pro' ); ?></label>
                    <select class="shark-business-pro-widget-chosen-select widfat" id="<?php echo esc_attr( $this->get_field_id( 'page_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_id' ) ); ?>">
                        <?php foreach ( $page_options as $page_option => $value ) : ?>
                            <option value="<?php echo absint( $page_option ); ?>" <?php selected( $page_id, $page_option, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>
            
            <div class="post <?php echo ( 'post' == $content_type ) ? 'block' : 'none' ?>" >
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'post_id' ) ); ?>"><?php esc_html_e( 'Select Post', 'shark-business-pro' ); ?></label>
                    <select class="shark-business-pro-widget-chosen-select widfat" id="<?php echo esc_attr( $this->get_field_id( 'post_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_id' ) ); ?>">
                        <?php foreach ( $post_options as $post_option => $value ) : ?>
                            <option value="<?php echo absint( $post_option ); ?>" <?php selected( $post_id, $post_option, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>


            <div class="custom <?php echo ( 'custom' == $content_type ) ? 'block' : 'none' ?>" >
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'author_title' ) ); ?>"><?php esc_html_e( 'Author Title', 'shark-business-pro' ); ?></label>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('author_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'author_title' ) ); ?>" type="text" value="<?php echo esc_attr( $author_title ); ?>" />
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'author_content' ) ); ?>"><?php esc_html_e( 'Author Description', 'shark-business-pro' ); ?></label>
                    <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('author_content') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'author_content' ) ); ?>" ><?php echo esc_attr( $author_content ); ?></textarea>
                </p>

                <div>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'author_image_url' ) ); ?>"><?php esc_html_e( 'Author Image', 'shark-business-pro' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'author_image_url' ); ?>" name="<?php echo $this->get_field_name( 'author_image_url' ); ?>" type="text" value="<?php echo esc_url( $author_image_url ); ?>" />
                    <button class="button upload_image_button" style="margin:15px 0 0;"><?php esc_html_e( 'Upload Image', 'shark-business-pro' ); ?></button>
                    <p><small><?php esc_html_e( 'Note: Recomended size 200x200 px. When you change the image, please make some changes in any other input field to save changes.', 'shark-business-pro' ) ?></small><p>

                    <?php
                    $full_author_image_url = '';
                    if ( ! empty( $author_image_url ) ) {
                        $full_author_image_url = $author_image_url;
                    }

                    $wrap_style = '';
                    if ( empty( $full_author_image_url ) ) {
                        $wrap_style = ' style="display:none;" ';
                    }
                    ?>
                    <div class="tpiw-preview-wrap" <?php echo esc_attr( $wrap_style ); ?>>
                        <img src="<?php echo esc_url( $full_author_image_url ); ?>" alt="<?php esc_attr_e('Preview', 'shark-business-pro'); ?>" style="max-width: 100%;"  />
                    </div><!-- .tpiw-preview-wrap -->

                </div>
           </div>

            <div class="widget_multi_input" >
                <label for="<?php echo esc_attr( $this->get_field_id( 'social_link' ) ); ?>"><?php esc_html_e( 'Social Links:', 'shark-business-pro' ); ?></label>
                <input type="hidden" id="<?php echo esc_attr( $this->get_field_id('social_link') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'social_link' ) ); ?>" value="<?php echo esc_attr( $social_link ); ?>" class="widget_multi_value_field" />
                <div class="widget_multi_fields">
                    <div class="set">
                        <input type="text" value="" class="widget_multi_single_field"/>
                        <span class="widget_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
                    </div>
                </div>
                <a href="#" class="button widget_multi_add_field"><?php esc_html_e( 'Add Social Link', 'shark-business-pro' ); ?></a>

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
            $instance['content_type']   = sanitize_key( $new_instance['content_type'] );
            $instance['page_id']        = shark_business_pro_sanitize_page_post( $new_instance['page_id'] );
            $instance['post_id']        = shark_business_pro_sanitize_page_post( $new_instance['post_id'] );
            $instance['author_title']    = sanitize_text_field( $new_instance['author_title'] );
            $instance['author_content']  = wp_kses_post( $new_instance['author_content'] );
            $instance['author_image_url'] = esc_url_raw( $new_instance['author_image_url'] );
            $instance['social_link']      = sanitize_text_field( $new_instance['social_link'] );

            return $instance;
        }
    }
endif;

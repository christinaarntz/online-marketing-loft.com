<?php
/**
 * Introduction Widget
 *
 * @package shark_business_pro
 */

if ( ! class_exists( 'Shark_Business_Pro_Introduction_Widget' ) ) :

     
    class Shark_Business_Pro_Introduction_Widget extends WP_Widget {
        /**
         * Sets up the widgets name etc
         */
        public function __construct() {
            $st_widget_introduction = array(
                'classname'   => 'introduction_widget',
                'description' => esc_html__( 'Compatible Area: Homepage, About Page, Sidebar, Footer', 'shark-business-pro' ),
            );
            parent::__construct( 'shark_business_pro_introduction_widget', esc_html__( 'ST: Introduction Widget', 'shark-business-pro' ), $st_widget_introduction );
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
            $image_align   = isset( $instance['image_align'] ) ? $instance['image_align'] : 'right';
            $content_type  = isset( $instance['content_type'] ) ? $instance['content_type'] : 'page';
            $read_more  = isset( $instance['read_more'] ) ? $instance['read_more'] : esc_html__( 'Read More', 'shark-business-pro' );
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
                    $details['title']  = isset( $instance['intro_title'] ) ? $instance['intro_title'] : '';
                    $details['url']  = isset( $instance['intro_link'] ) ? $instance['intro_link'] : '#';
                    $details['content']  = isset( $instance['intro_content'] ) ? $instance['intro_content'] : '';
                    $details['image']  = isset( $instance['intro_image_url'] ) ? $instance['intro_image_url'] : '';
                    array_push( $content_details , $details );
                break;
                
                default:
                break;
            }

            if ( in_array( $content_type, array( 'page', 'post' ) ) ) :
                $query = new WP_Query( $query_args );
                if ( $query -> have_posts() ) : while ( $query -> have_posts() ) : $query -> the_post();
                    $details['title']  = get_the_title();
                    $details['url']    = get_the_permalink();
                    $details['content'] = shark_business_pro_trim_content( 30 );
                    $details['image']  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : '';
                    array_push( $content_details , $details );
                endwhile; endif;
                wp_reset_postdata();
            endif;

            if ( empty( $content_details ) )
                return;

            echo $args['before_widget'];
            ?>

                <div id="introduction" class="page-section relative <?php echo ( 'left' == $image_align ) ? 'left-align' : 'right-align'; ?>">
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
                        <?php endif; 

                        foreach ( $content_details as $content ) : ?>
                            <article class="hentry">
                                <div class="post-wrapper">
                                    <div class="entry-container">
                                        <?php if ( ! empty( $content['title'] ) ) : ?>
                                            <header class="entry-header">
                                                <h2 class="entry-title">
                                                    <a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a>
                                                </h2>
                                            </header>
                                        <?php endif; 

                                        if ( ! empty( $content['content'] ) ) : ?>
                                            <div class="entry-content">
                                                <?php echo wp_kses_post( $content['content'] ); ?>
                                            </div><!-- .entry-content -->
                                        <?php endif; ?>
                                        <div class="read-more">
                                            <a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $read_more ); ?></a>
                                        </div>
                                    </div><!-- .entry-container -->
                                    <?php if ( ! empty( $content['image'] ) ) : ?>
                                        <div class="featured-image">
                                            <a href="<?php echo esc_url( $content['url'] ) ?>"><img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>"></a>
                                        </div><!-- .featured-image -->
                                    <?php endif; ?>
                                </div><!-- .post-wrapper -->
                            </article>
                        <?php endforeach; ?>
                    </div><!-- .wrapper -->
                </div><!-- #introduction -->

            <?php
            echo $args['after_widget'];
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form( $instance ) {
            $title       = isset( $instance['title'] ) ? ( $instance['title'] ) : esc_html__( 'Introduction', 'shark-business-pro' );
            $sub_title   = isset( $instance['sub_title'] ) ? $instance['sub_title'] : esc_html__( 'Quickly and simply build a personalized website and provide brief introduction with Introduction Widget', 'shark-business-pro' );

            $image_align    = isset( $instance['image_align'] ) ? $instance['image_align'] : 'right';
            $content_type   = isset( $instance['content_type'] ) ? $instance['content_type'] : 'page';
            $page_id        = isset( $instance['page_id'] ) ? $instance['page_id'] : '';
            $post_id        = isset( $instance['post_id'] ) ? $instance['post_id'] : '';
            $intro_title    = isset( $instance['intro_title'] ) ? $instance['intro_title'] : '';
            $intro_link     = isset( $instance['intro_link'] ) ? $instance['intro_link'] : '';
            $intro_content  = isset( $instance['intro_content'] ) ? $instance['intro_content'] : '';
            $intro_image_url  = isset( $instance['intro_image_url'] ) ? $instance['intro_image_url'] : '';
            $read_more  = isset( $instance['read_more'] ) ? $instance['read_more'] : esc_html__( 'Read More', 'shark-business-pro' );

            $page_options = shark_business_pro_page_choices();
            $post_options = shark_business_pro_post_choices();
            $image_align_options = array(
                'right'     => esc_html__( 'Right Align', 'shark-business-pro' ),
                'left'      => esc_html__( 'Left Align', 'shark-business-pro' ),
            );
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
                <label for="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>"><?php esc_html_e( 'Sub Title:', 'shark-business-pro' ); ?></label>
                <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('sub_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sub_title' ) ); ?>" ><?php echo esc_html( $sub_title ); ?></textarea>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'image_align' ) ); ?>"><?php esc_html_e( 'Image Alignment', 'shark-business-pro' ); ?></label>
                <select class="widfat" id="<?php echo esc_attr( $this->get_field_id( 'image_align' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_align' ) ); ?>" style="width:100%">
                    <?php foreach ( $image_align_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $image_align, $key, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
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
                    <label for="<?php echo esc_attr( $this->get_field_id( 'intro_title' ) ); ?>"><?php esc_html_e( 'Introduction Title', 'shark-business-pro' ); ?></label>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('intro_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'intro_title' ) ); ?>" type="text" value="<?php echo esc_attr( $intro_title ); ?>" />
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'intro_link' ) ); ?>"><?php esc_html_e( 'Introduction Link', 'shark-business-pro' ); ?></label>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('intro_link') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'intro_link' ) ); ?>" type="url" value="<?php echo esc_url( $intro_link ); ?>" />
                    <small><?php esc_html_e( 'Note: Please make sure input full url with http://', 'shark-business-pro' ); ?></small>
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'intro_content' ) ); ?>"><?php esc_html_e( 'Introduction Description', 'shark-business-pro' ); ?></label>
                    <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('intro_content') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'intro_content' ) ); ?>" ><?php echo esc_attr( $intro_content ); ?></textarea>
                </p>

                <div>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'intro_image_url' ) ); ?>"><?php esc_html_e( 'Introduction Image', 'shark-business-pro' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'intro_image_url' ); ?>" name="<?php echo $this->get_field_name( 'intro_image_url' ); ?>" type="text" value="<?php echo esc_url( $intro_image_url ); ?>" />
                    <button class="button upload_image_button" style="margin:15px 0 0;"><?php esc_html_e( 'Upload Image', 'shark-business-pro' ); ?></button>
                    <p><small><?php esc_html_e( 'Note: Recomended size is 600x600 px. When you change the image, please make some changes in any other input field to save changes.', 'shark-business-pro' ) ?></small><p>

                    <?php
                    $full_intro_image_url = '';
                    if ( ! empty( $intro_image_url ) ) {
                        $full_intro_image_url = $intro_image_url;
                    }

                    $wrap_style = '';
                    if ( empty( $full_intro_image_url ) ) {
                        $wrap_style = ' style="display:none;" ';
                    }
                    ?>
                    <div class="tpiw-preview-wrap" <?php echo esc_attr( $wrap_style ); ?>>
                        <img src="<?php echo esc_url( $full_intro_image_url ); ?>" alt="<?php esc_attr_e('Preview', 'shark-business-pro'); ?>" style="max-width: 100%;"  />
                    </div><!-- .tpiw-preview-wrap -->

                </div>
           </div>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'read_more' ) ); ?>"><?php esc_html_e( 'Read More Text:', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('read_more') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'read_more' ) ); ?>" type="text" value="<?php echo esc_attr( $read_more ); ?>" />
            </p>

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
            $instance['image_align']    = sanitize_key( $new_instance['image_align'] );
            $instance['content_type']   = sanitize_key( $new_instance['content_type'] );
            $instance['page_id']        = shark_business_pro_sanitize_page_post( $new_instance['page_id'] );
            $instance['post_id']        = shark_business_pro_sanitize_page_post( $new_instance['post_id'] );
            $instance['intro_title']    = sanitize_text_field( $new_instance['intro_title'] );
            $instance['intro_link']     = esc_url_raw( $new_instance['intro_link'] );
            $instance['intro_content']  = wp_kses_post( $new_instance['intro_content'] );
            $instance['intro_image_url'] = esc_url_raw( $new_instance['intro_image_url'] );

            $instance['read_more']      = sanitize_text_field( $new_instance['read_more'] );
           
            return $instance;
        }
    }
endif;

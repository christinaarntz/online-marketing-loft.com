<?php
/**
 * Counter Widget
 *
 * @package shark_business_pro
 */

if ( ! class_exists( 'Shark_Business_Pro_Counter_Widget' ) ) :

     
    class Shark_Business_Pro_Counter_Widget extends WP_Widget {
        /**
         * Sets up the widgets name etc
         */
        public function __construct() {
            $st_widget_counter = array(
                'classname'   => 'counter_widget',
                'description' => esc_html__( 'Compatible Area: Homepage, About Page, Service Page', 'shark-business-pro' ),
            );
            parent::__construct( 'shark_business_pro_counter_widget', esc_html__( 'ST: Counter Widget', 'shark-business-pro' ), $st_widget_counter );
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
            $counter_image_url   = ( ! empty( $instance['counter_image_url'] ) ) ? ( $instance['counter_image_url'] ) : '';
            $content_details = array();

            $content_details = array();

            for ( $i = 1; $i <= 4; $i++ ) {
                if ( ! empty( $instance['label_' . $i] ) && ! empty( $instance['value_' . $i] )  ) :
                    $counter['label'] = $instance['label_' . $i];
                    $counter['value'] = $instance['value_' . $i];

                    array_push( $content_details, $counter );
                endif;
            }

            echo $args['before_widget'];
            ?>
                <div class="page-section counter-widget relative"
                    <?php if ( ! empty( $counter_image_url ) ) : ?> 
                        style="background-image: url('<?php echo esc_url( $counter_image_url ); ?>');"
                    <?php endif; ?>>
                    <div class="overlay"></div>
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

                        <div class="section-content column-<?php echo absint( count( $content_details ) ); ?>">
                            <?php foreach ( $content_details as $content ) : ?>
                                <article class="hentry">
                                    <div class="counter">
                                        <div class="counter-value"><?php echo esc_html( $content['value'] ); ?></div>
                                        <h5 class="counter-label"><?php echo esc_html( $content['label'] ); ?></h5>
                                    </div><!-- .counter -->
                                </article>
                            <?php endforeach; ?>
                        </div><!-- .section-content -->
                    </div><!-- .wrapper -->
                </div><!-- #counter -->

            <?php
            echo $args['after_widget'];
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form( $instance ) {
            $title      = isset( $instance['title'] ) ? ( $instance['title'] ) : esc_html__( 'Counter', 'shark-business-pro' );
            $sub_title   = isset( $instance['sub_title'] ) ? ( $instance['sub_title'] ) : esc_html__( 'Counter Widget provides you to create counter section for the page.', 'shark-business-pro' );
            $counter_image_url   = ! empty( $instance['counter_image_url'] ) ? $instance['counter_image_url'] : '';
            ?>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>"><?php esc_html_e( 'Sub Title:', 'shark-business-pro' ); ?></label>
                <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('sub_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sub_title' ) ); ?>" ><?php echo esc_html( $sub_title ); ?></textarea>
            </p>

            <?php for ( $i = 1; $i <= 4; $i++ ) : 
                 $label = isset( $instance['label_' . $i] ) ? ( $instance['label_' . $i] ) : esc_html__( 'Counter Label', 'shark-business-pro' );
                 $value = isset( $instance['value_' . $i] ) ? ( $instance['value_' . $i] ) : esc_html__( '500+', 'shark-business-pro' );
            ?>
                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'label_' . $i ) ); ?>"><?php printf( esc_html__( 'Label %d:', 'shark-business-pro' ), $i ); ?></label>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('label_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label_' . $i ) ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>" />
                </p>

                <p>
                    <label for="<?php echo esc_attr( $this->get_field_id( 'value_' . $i ) ); ?>"><?php printf( esc_html__( 'Value %d:', 'shark-business-pro' ), $i ); ?></label>
                    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('value_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'value_' . $i ) ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
                </p>
                <hr>
            <?php endfor; ?>

            <div>
                <label for="<?php echo esc_attr( $this->get_field_id( 'counter_image_url' ) ); ?>"><?php esc_html_e( 'Counter Background Image', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'counter_image_url' ); ?>" name="<?php echo $this->get_field_name( 'counter_image_url' ); ?>" type="text" value="<?php echo esc_url( $counter_image_url ); ?>" />
                <button class="button upload_image_button" style="margin:15px 0 0;"><?php esc_html_e( 'Upload Image', 'shark-business-pro' ); ?></button>
                <p><small><?php esc_html_e( 'Note: Recomended size 1920x700px. When you change the image, please make some changes in any other input field to save changes.', 'shark-business-pro' ) ?></small><p>

                <?php
                $full_counter_image_url = '';
                if ( ! empty( $counter_image_url ) ) {
                    $full_counter_image_url = $counter_image_url;
                }

                $wrap_style = '';
                if ( empty( $full_counter_image_url ) ) {
                    $wrap_style = ' style="display:none;" ';
                }
                ?>
                <div class="tpiw-preview-wrap" <?php echo esc_attr( $wrap_style ); ?>>
                    <img src="<?php echo esc_url( $full_counter_image_url ); ?>" alt="<?php esc_attr_e('Preview', 'shark-business-pro'); ?>" style="max-width: 100%;"  />
                </div><!-- .tpiw-preview-wrap -->

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
            $instance['counter_image_url']  = esc_url_raw( $new_instance['counter_image_url'] );
            for ( $i = 1; $i <= 4; $i++ ) {
                $instance['label_' . $i]    = sanitize_text_field( $new_instance['label_' . $i] );
                $instance['value_' . $i]    = sanitize_text_field( $new_instance['value_' . $i] );
            }
           
            return $instance;
        }
    }
endif;

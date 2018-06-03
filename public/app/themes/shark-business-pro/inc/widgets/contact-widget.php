<?php
/**
 * Contact Widget
 *
 * @package shark_business_pro
 */

if ( ! class_exists( 'Shark_Business_Pro_Contact_Widget' ) ) :

     
    class Shark_Business_Pro_Contact_Widget extends WP_Widget {
        /**
         * Sets up the widgets name etc
         */
        public function __construct() {
            $st_widget_contact = array(
                'classname'   => 'contact_widget',
                'description' => esc_html__( 'Compatible Area: Sidebar, Footer', 'shark-business-pro' ),
            );
            parent::__construct( 'shark_business_pro_contact_widget', esc_html__( 'ST: Contact Widget', 'shark-business-pro' ), $st_widget_contact );
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
            $address = isset( $instance['address'] ) ? $instance['address'] : '';
            $phone   = isset( $instance['phone'] ) ? explode( '|', $instance['phone'] ) : array();
            $email   = isset( $instance['email'] ) ? explode( '|', $instance['email'] ) : array();

            echo $args['before_widget'];

            if ( ! empty( $title ) ) {
                echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
            } ?>

            <div class="contact-details">
                <?php if ( ! empty( $address ) ) : ?>
                    <div class="contact-address">
                        <?php 
                        echo shark_business_pro_get_svg( array( 'icon' => 'location-o' ) ); 
                        echo esc_html( $address ); 
                        ?>
                    </div>
                <?php endif; 

                if ( ! empty( $phone ) ) : ?>
                    <div class="contact-phone">
                        <?php echo shark_business_pro_get_svg( array( 'icon' => 'phone-o' ) );
                        foreach ( $phone as $call ) : ?>
                            <a href="tel:<?php echo esc_attr( $call ); ?>"><?php echo esc_html( $call ); ?></a>
                        <?php endforeach; ?>                          
                    </div>
                <?php endif; 

                if ( ! empty( $email ) ) : ?>
                    <div class="contact-email">
                        <?php echo shark_business_pro_get_svg( array( 'icon' => 'envelope-o' ) );
                        foreach ( $email as $emailid ) : ?>
                            <a href="mailto:<?php echo esc_attr( $emailid ); ?>"><?php echo esc_html( $emailid ); ?></a>
                        <?php endforeach; ?>                          
                    </div>
                <?php endif; ?>
            </div>

            <?php
            echo $args['after_widget'];
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form( $instance ) {
            $title    = isset( $instance['title'] ) ? ( $instance['title'] ) : esc_html__( 'Contact', 'shark-business-pro' );
            $address  = isset( $instance['address'] ) ? $instance['address'] : '';
            $phone    = isset( $instance['phone'] ) ? $instance['phone'] : '';
            $email    = isset( $instance['email'] ) ? $instance['email'] : '';
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Full Address:', 'shark-business-pro' ); ?></label>
                <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('address') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>"><?php echo esc_html( $address ); ?></textarea>
            </p>

            <div class="widget_multi_input" >
                <label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e( 'Phone:', 'shark-business-pro' ); ?></label>
                <input type="hidden" id="<?php echo esc_attr( $this->get_field_id('phone') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" value="<?php echo esc_attr( $phone ); ?>" class="widget_multi_value_field" />
                <div class="widget_multi_fields">
                    <div class="set">
                        <input type="text" value="" class="widget_multi_single_field"/>
                        <span class="widget_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
                    </div>
                </div>
                <a href="#" class="button widget_multi_add_field"><?php esc_html_e( 'Add Phone No', 'shark-business-pro' ); ?></a>
            </div>

            <div class="widget_multi_input" >
                <label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email:', 'shark-business-pro' ); ?></label>
                <input type="hidden" id="<?php echo esc_attr( $this->get_field_id('email') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" value="<?php echo esc_attr( $email ); ?>" class="widget_multi_value_field" />
                <div class="widget_multi_fields">
                    <div class="set">
                        <input type="text" value="" class="widget_multi_single_field"/>
                        <span class="widget_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
                    </div>
                </div>
                <a href="#" class="button widget_multi_add_field"><?php esc_html_e( 'Add Email ID', 'shark-business-pro' ); ?></a>
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
            $instance['address']        = sanitize_text_field( $new_instance['address'] );
            $instance['phone']          = sanitize_text_field( $new_instance['phone'] );
            $instance['email']          = sanitize_text_field( $new_instance['email'] );

            return $instance;
        }
    }
endif;

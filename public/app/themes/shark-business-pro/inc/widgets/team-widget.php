<?php
/**
 * Team Widget
 *
 * @package shark_business_pro
 */

if ( ! class_exists( 'Shark_Business_Pro_Team_Widget' ) ) :

     
    class Shark_Business_Pro_Team_Widget extends WP_Widget {
        /**
         * Sets up the widgets name etc
         */
        public function __construct() {
            $st_widget_team = array(
                'classname'   => 'team_widget',
                'description' => esc_html__( 'Compatible Area: Homepage, About Page, Service Page, Sidebar', 'shark-business-pro' ),
            );
            parent::__construct( 'shark_business_pro_team_widget', esc_html__( 'ST: Team Widget', 'shark-business-pro' ), $st_widget_team );
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
            $sub_title   = ! empty( $instance['sub_title'] ) ? ( $instance['sub_title'] ) : '';
            $count   = isset( $instance['count'] ) ? $instance['count'] : 3;
            $column  = isset( $instance['column'] ) ? $instance['column'] : 'column-3';
            $content_type  = isset( $instance['content_type'] ) ? $instance['content_type'] : 'page';
            $content_details = array();
            $position = array();
            $social_link = array();

            switch ($content_type) {
                case 'page':
                    $page_ids = array();
                    for ( $i = 1; $i <= $count; $i++ ) :
                        if ( ! empty( $instance['page_id_' . $i] ) ) :
                            $page_ids[] = $instance['page_id_' . $i];
                            $position[] = ! empty( $instance['team_page_position_' . $i] ) ? $instance['team_page_position_' . $i] : '';
                            $social_link[] = ! empty( $instance['team_page_social_link_' . $i] ) ? $instance['team_page_social_link_' . $i] : '';
                        endif;
                    endfor;
                    $query_args = array(
                    'post_type'         => 'page',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => absint( $count ),
                    'orderby'           => 'post__in',
                    ); 
                break;

                case 'post':
                    $post_ids = array();
                    for ( $i = 1; $i <= $count; $i++ ) :
                        if ( ! empty( $instance['post_id_' . $i] ) ) :
                            $post_ids[]  = $instance['post_id_' . $i];
                            $position[] = ! empty( $instance['team_post_position_' . $i] ) ? $instance['team_post_position_' . $i] : '';
                            $social_link[] = ! empty( $instance['team_post_social_link_' . $i] ) ? $instance['team_post_social_link_' . $i] : '';
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

                case 'custom':
                    for ( $i = 1; $i <= $count; $i++ ) :
                        $details['title']  = ! empty( $instance['team_title_' . $i] ) ? $instance['team_title_' . $i] : '';
                        $details['position'] = ! empty( $instance['team_position_' . $i] ) ? $instance['team_position_' . $i] : '';
                        $details['url']  = ! empty( $instance['team_link_' . $i] ) ? $instance['team_link_' . $i] : '#';
                        $details['image']  = ! empty( $instance['team_image_' . $i] ) ? $instance['team_image_' . $i] : '';
                        $details['excerpt'] = ! empty( $instance['team_content_' . $i] ) ? $instance['team_content_' . $i] : '';
                        $details['social']  = ! empty( $instance['team_social_link_' . $i] ) ? $instance['team_social_link_' . $i] : '';
                        array_push( $content_details , $details );
                    endfor;
                break;

                case 'category':
                    $cat_id = ! empty( $instance['cat_id'] ) ? $instance['cat_id'] : '';
                    $query_args = array(
                        'post_type'         => 'post',
                        'posts_per_page'    => absint( $count ),
                        'cat'               => absint( $cat_id ),
                        'ignore_sticky_posts' => true,
                        ); 
                    for ( $i = 1; $i <= $count; $i++ ) :
                        $position[] = ! empty( $instance['team_cat_position_' . $i] ) ? $instance['team_cat_position_' . $i] : '';
                        $social_link[] = ! empty( $instance['team_cat_social_link_' . $i] ) ? $instance['team_cat_social_link_' . $i] : '';
                    endfor;
                break;
                
                default:
                break;
            }

            $i = 0;
            if ( 'custom' !== $content_type ) :
                $query = new WP_Query( $query_args );
                if ( $query -> have_posts() ) : while ( $query -> have_posts() ) : $query -> the_post();
                    $details['title']  = get_the_title();
                    $details['position']  = ! empty( $position[$i] ) ? $position[$i] : ''; 
                    $details['social']  = ! empty( $social_link[$i] ) ? $social_link[$i] : ''; 
                    $details['url']    = get_the_permalink();
                    $details['excerpt'] = shark_business_pro_trim_content( 15 );
                    $details['image']  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'thumbnail' ) : '';
                    array_push( $content_details , $details );
                    $i++;
                endwhile; endif;
                wp_reset_postdata();
            endif;

            if ( empty( $content_details ) )
                return;

            echo $args['before_widget'];
            ?>

                <div class="page-section team-section relative">
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
                            <?php foreach ( $content_details as $content ) : ?>
                                <article class="hentry">
                                    <div class="post-wrapper">
                                        <?php if ( ! empty( $content['image'] ) ) : ?>
                                            <div class="team-image">
                                                <a href="<?php echo esc_url( $content['url'] ); ?>">
                                                    <img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ) ?>">
                                                </a>
                                            </div><!-- .team-image -->
                                        <?php endif; ?>

                                        <div class="entry-container">
                                            <?php if ( ! empty( $content['title'] ) ) : ?>
                                                <header class="entry-header">
                                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                                    <div class="separator"></div>
                                                </header>
                                            <?php endif; 

                                            if ( ! empty( $content['position'] ) ) : ?>
                                                <h6 class="position"><?php echo esc_html( $content['position'] ); ?></h6>
                                            <?php endif;

                                            if ( ! empty( $content['excerpt'] ) ) : ?>
                                                <div class="entry-content">
                                                    <?php echo wp_kses_post( $content['excerpt'] ); ?>
                                                </div><!-- .entry-content -->
                                            <?php endif;

                                            if ( ! empty( $content['social'] ) ) : 
                                                $social_links = explode( '|', $content['social'] ); ?>
                                                <div class="share-message">
                                                    <ul class="social-icons">
                                                        <?php foreach ( $social_links as $social ) : ?>
                                                            <li>
                                                                <a href="<?php echo esc_url( $social ); ?>" target="_blank"><?php echo shark_business_pro_return_social_icon( $social ); ?></a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div><!-- .share-message -->
                                            <?php endif; ?>
                                        </div><!-- .entry-container -->
                                    </div><!-- .post-wrapper -->
                                </article>
                            <?php endforeach; ?>
                        </div><!-- .section-content -->
                    </div><!-- .wrapper -->
                </div><!-- #team-posts -->

            <?php
            echo $args['after_widget'];
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form( $instance ) {
            $title      = isset( $instance['title'] ) ? ( $instance['title'] ) : esc_html__( 'Team', 'shark-business-pro' );
            $sub_title      = isset( $instance['sub_title'] ) ? ( $instance['sub_title'] ) : esc_html__( 'Team widget allows you to display your valuable team members', 'shark-business-pro' );
            $count      = isset( $instance['count'] ) ? $instance['count'] : 3;
            $column     = isset( $instance['column'] ) ? $instance['column'] : 'column-3';
            $content_type   = isset( $instance['content_type'] ) ? $instance['content_type'] : 'page';
            $cat_id     = isset( $instance['cat_id'] ) ? $instance['cat_id'] : '';

            $page_options = shark_business_pro_page_choices();
            $post_options = shark_business_pro_post_choices();
            $category_options = shark_business_pro_category_choices();
            $content_type_options = array(
                'page'      => esc_html__( 'Page', 'shark-business-pro' ),
                'post'      => esc_html__( 'Post', 'shark-business-pro' ),
                'category'  => esc_html__( 'Category', 'shark-business-pro' ),
                'custom'    => esc_html__( 'Custom', 'shark-business-pro' ),
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
                <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'No of Team Posts:', 'shark-business-pro' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('count') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" min="2" max="12" value="<?php echo absint( $count ); ?>" />
                <small><?php esc_html_e( 'Note: Min 2 & Max 12. Please save the settings to see the change.', 'shark-business-pro' ); ?></small>
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

            <div class="page <?php echo ( 'page' == $content_type ) ? 'block' : 'none' ?>" >
                <?php for ( $i = 1; $i <= $count; $i++ ) : 
                    $page_id = isset( $instance['page_id_' . $i] ) ? $instance['page_id_' . $i] : '';
                    $team_page_position = isset( $instance['team_page_position_' . $i] ) ? $instance['team_page_position_' . $i] : '';
                    $team_page_social_link = isset( $instance['team_page_social_link_' . $i] ) ? $instance['team_page_social_link_' . $i] : ''; ?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'page_id_' . $i ) ); ?>"><?php printf( esc_html__( 'Select Page %d', 'shark-business-pro' ), $i ); ?></label>
                        <select class="shark-business-pro-widget-chosen-select widfat" id="<?php echo esc_attr( $this->get_field_id( 'page_id_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'page_id_' . $i ) ); ?>">
                            <?php foreach ( $page_options as $page_option => $value ) : ?>
                                <option value="<?php echo absint( $page_option ); ?>" <?php selected( $page_id, $page_option, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>

                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'team_page_position_' . $i ) ); ?>"><?php printf( esc_html__( 'Team Postion %d', 'shark-business-pro' ), $i ); ?></label>
                        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('team_page_position_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_page_position_' . $i ) ); ?>" type="text" value="<?php echo esc_attr( $team_page_position ); ?>" />
                    </p>

                    <div class="widget_multi_input" >
                        <label for="<?php echo esc_attr( $this->get_field_id( 'team_page_social_link_' . $i ) ); ?>"><?php printf( esc_html__( 'Social Links %d', 'shark-business-pro' ), $i ); ?></label>
                        <input type="hidden" id="<?php echo esc_attr( $this->get_field_id('team_page_social_link_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_page_social_link_' . $i ) ); ?>" value="<?php echo esc_attr( $team_page_social_link ); ?>" class="widget_multi_value_field" />
                        <div class="widget_multi_fields">
                            <div class="set">
                                <input type="text" value="" class="widget_multi_single_field"/>
                                <span class="widget_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
                            </div>
                        </div>
                        <a href="#" class="button widget_multi_add_field"><?php esc_html_e( 'Add Social Link', 'shark-business-pro' ); ?></a>

                    </div>
                    <hr>
                <?php endfor; ?>
            </div>
            
            <div class="post <?php echo ( 'post' == $content_type ) ? 'block' : 'none' ?>" >
               <?php for ( $i = 1; $i <= $count; $i++ ) : 
                    $post_id = isset( $instance['post_id_' . $i] ) ? $instance['post_id_' . $i] : '';
                    $team_post_position = isset( $instance['team_post_position_' . $i] ) ? $instance['team_post_position_' . $i] : '';
                    $team_post_social_link = isset( $instance['team_post_social_link_' . $i] ) ? $instance['team_post_social_link_' . $i] : ''; ?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'post_id_' . $i ) ); ?>"><?php printf( esc_html__( 'Select Post %d', 'shark-business-pro' ), $i ); ?></label>
                        <select class="shark-business-pro-widget-chosen-select widfat" id="<?php echo esc_attr( $this->get_field_id( 'post_id_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_id_' . $i ) ); ?>">
                            <?php foreach ( $post_options as $post_option => $value ) : ?>
                                <option value="<?php echo absint( $post_option ); ?>" <?php selected( $post_id, $post_option, $echo = true ) ?> ><?php echo esc_html( $value ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>

                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'team_post_position_' . $i ) ); ?>"><?php printf( esc_html__( 'Team Postion %d', 'shark-business-pro' ), $i ); ?></label>
                        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('team_post_position_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_post_position_' . $i ) ); ?>" type="text" value="<?php echo esc_attr( $team_post_position ); ?>" />
                    </p>

                    <div class="widget_multi_input" >
                        <label for="<?php echo esc_attr( $this->get_field_id( 'team_post_social_link_' . $i ) ); ?>"><?php printf( esc_html__( 'Social Links %d', 'shark-business-pro' ), $i ); ?></label>
                        <input type="hidden" id="<?php echo esc_attr( $this->get_field_id('team_post_social_link_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_post_social_link_' . $i ) ); ?>" value="<?php echo esc_attr( $team_post_social_link ); ?>" class="widget_multi_value_field" />
                        <div class="widget_multi_fields">
                            <div class="set">
                                <input type="text" value="" class="widget_multi_single_field"/>
                                <span class="widget_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
                            </div>
                        </div>
                        <a href="#" class="button widget_multi_add_field"><?php esc_html_e( 'Add Social Link', 'shark-business-pro' ); ?></a>

                    </div>
                    <hr>
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

                <?php for ( $i = 1; $i <= $count; $i++ ) : 
                    $team_cat_position = isset( $instance['team_cat_position_' . $i] ) ? $instance['team_cat_position_' . $i] : '';
                    $team_cat_social_link = isset( $instance['team_cat_social_link_' . $i] ) ? $instance['team_cat_social_link_' . $i] : ''; ?>

                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( 'team_cat_position_' . $i ) ); ?>"><?php printf( esc_html__( 'Team Postion %d', 'shark-business-pro' ), $i ); ?></label>
                        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('team_cat_position_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_cat_position_' . $i ) ); ?>" type="text" value="<?php echo esc_attr( $team_cat_position ); ?>" />
                    </p>

                    <div class="widget_multi_input" >
                        <label for="<?php echo esc_attr( $this->get_field_id( 'team_cat_social_link_' . $i ) ); ?>"><?php printf( esc_html__( 'Social Links %d', 'shark-business-pro' ), $i ); ?></label>
                        <input type="hidden" id="<?php echo esc_attr( $this->get_field_id('team_cat_social_link_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_cat_social_link_' . $i ) ); ?>" value="<?php echo esc_attr( $team_cat_social_link ); ?>" class="widget_multi_value_field" />
                        <div class="widget_multi_fields">
                            <div class="set">
                                <input type="text" value="" class="widget_multi_single_field"/>
                                <span class="widget_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
                            </div>
                        </div>
                        <a href="#" class="button widget_multi_add_field"><?php esc_html_e( 'Add Social Link', 'shark-business-pro' ); ?></a>
                    </div>
                    <hr>
                <?php endfor; ?>
            </div>

            <div class="custom <?php echo ( 'custom' == $content_type ) ? 'block' : 'none' ?>" >
                <?php for ( $i = 1; $i <= $count; $i++ ) : 
                    $team_title = isset( $instance['team_title_' . $i] ) ? $instance['team_title_' . $i] : '';
                    $team_position = isset( $instance['team_position_' . $i] ) ? $instance['team_position_' . $i] : '';
                    $team_content = isset( $instance['team_content_' . $i] ) ? $instance['team_content_' . $i] : '';
                    $team_link = isset( $instance['team_link_' . $i] ) ? $instance['team_link_' . $i] : '';
                    $team_image = isset( $instance['team_image_' . $i] ) ? $instance['team_image_' . $i] : ''; 
                    $team_social_link = isset( $instance['team_social_link_' . $i] ) ? $instance['team_social_link_' . $i] : ''; 
                    ?>
                    <button class="shark-business-pro-accordion"><?php printf( esc_html__( 'Team %d', 'shark-business-pro' ), $i ); ?></button>
                    <div class="shark-business-pro-panel">
                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'team_title_' . $i ) ); ?>"><?php printf( esc_html__( 'Team Title %d', 'shark-business-pro' ), $i ); ?></label>
                            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('team_title_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_title_' . $i ) ); ?>" type="text" value="<?php echo esc_attr( $team_title ); ?>" />
                        </p>

                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'team_position_' . $i ) ); ?>"><?php printf( esc_html__( 'Team Position %d', 'shark-business-pro' ), $i ); ?></label>
                            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('team_position_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_position_' . $i ) ); ?>" type="text" value="<?php echo esc_attr( $team_position ); ?>" />
                        </p>

                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'team_content_' . $i ) ); ?>"><?php printf( esc_html__( 'Team Description %d', 'shark-business-pro' ), $i ); ?></label>
                            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id('team_content_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_content_' . $i ) ); ?>" ><?php echo esc_attr( $team_content ); ?></textarea>
                        </p>

                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'team_link_' . $i ) ); ?>"><?php printf( esc_html__( 'Team Link %d', 'shark-business-pro' ), $i ); ?></label>
                            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('team_link_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_link_' . $i ) ); ?>" type="url" value="<?php echo esc_url( $team_link ); ?>" />
                            <small><?php esc_html_e( 'Note: Please make sure input full url with http://', 'shark-business-pro' ); ?></small>
                        </p>

                        <div>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'team_image_' . $i ) ); ?>"><?php printf( esc_html__( 'Team Image %d', 'shark-business-pro' ), $i ); ?></label>
                            <input class="widefat" id="<?php echo $this->get_field_id( 'team_image_' . $i ); ?>" name="<?php echo $this->get_field_name( 'team_image_' . $i ); ?>" type="text" value="<?php echo esc_url( $team_image ); ?>" />
                            <button class="button upload_image_button" style="margin:15px 0 0;"><?php esc_html_e( 'Upload Image', 'shark-business-pro' ); ?></button>
                            <p><small><?php esc_html_e( 'Note: Recomended size is 150x150 px. When you change the image, please make some changes in any other input field to save changes.', 'shark-business-pro' ) ?></small><p>

                            <?php
                            $full_team_image_url = '';
                            if ( ! empty( $team_image ) ) {
                                $full_team_image_url = $team_image;
                            }

                            $wrap_style = '';
                            if ( empty( $full_team_image_url ) ) {
                                $wrap_style = ' style="display:none;" ';
                            }
                            ?>
                            <div class="tpiw-preview-wrap" <?php echo esc_attr( $wrap_style ); ?>>
                                <img src="<?php echo esc_url( $full_team_image_url ); ?>" alt="<?php esc_attr_e('Preview', 'shark-business-pro'); ?>" style="max-width: 100%;"  />
                            </div><!-- .tpiw-preview-wrap -->
                        </div>

                        <div class="widget_multi_input" >
                            <label for="<?php echo esc_attr( $this->get_field_id( 'team_social_link_' . $i ) ); ?>"><?php printf( esc_html__( 'Social Links %d', 'shark-business-pro' ), $i ); ?></label>
                            <input type="hidden" id="<?php echo esc_attr( $this->get_field_id('team_social_link_' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'team_social_link_' . $i ) ); ?>" value="<?php echo esc_attr( $team_social_link ); ?>" class="widget_multi_value_field" />
                            <div class="widget_multi_fields">
                                <div class="set">
                                    <input type="text" value="" class="widget_multi_single_field"/>
                                    <span class="widget_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
                                </div>
                            </div>
                            <a href="#" class="button widget_multi_add_field"><?php esc_html_e( 'Add Social Link', 'shark-business-pro' ); ?></a>
                        </div>
                    </div>
                    <hr style = "height: 2px;">
                <?php endfor; ?>
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
            $instance['column']         = sanitize_key( $new_instance['column'] );      
            $instance['content_type']   = sanitize_key( $new_instance['content_type'] );
            for ( $i = 1; $i <= $new_instance['count']; $i++ ) :
                // page
                $instance['page_id_' . $i]   = shark_business_pro_sanitize_page_post( $new_instance['page_id_' . $i] );
                $instance['team_page_position_' . $i]   = sanitize_text_field( $new_instance['team_page_position_' . $i] );
                $instance['team_page_social_link_' . $i]   = sanitize_text_field( $new_instance['team_page_social_link_' . $i] );
                // post
                $instance['post_id_' . $i]   = shark_business_pro_sanitize_page_post( $new_instance['post_id_' . $i] );
                $instance['team_post_position_' . $i]   = sanitize_text_field( $new_instance['team_post_position_' . $i] );
                $instance['team_post_social_link_' . $i]   = sanitize_text_field( $new_instance['team_post_social_link_' . $i] );
                // category
                $instance['team_cat_position_' . $i]   = sanitize_text_field( $new_instance['team_cat_position_' . $i] );
                $instance['team_cat_social_link_' . $i]   = sanitize_text_field( $new_instance['team_cat_social_link_' . $i] );
                // custom
                $instance['team_title_' . $i]   = sanitize_text_field( $new_instance['team_title_' . $i] );
                $instance['team_position_' . $i]   = sanitize_text_field( $new_instance['team_position_' . $i] );
                $instance['team_social_link_' . $i]   = sanitize_text_field( $new_instance['team_social_link_' . $i] );
                $instance['team_content_' . $i]   = wp_kses_post( $new_instance['team_content_' . $i] );
                $instance['team_link_' . $i]   = esc_url_raw( $new_instance['team_link_' . $i] );
                $instance['team_image_' . $i]   = esc_url_raw( $new_instance['team_image_' . $i] );
            endfor;
            $instance['cat_id']         = shark_business_pro_sanitize_category( $new_instance['cat_id'] );
           
            return $instance;
        }
    }
endif;

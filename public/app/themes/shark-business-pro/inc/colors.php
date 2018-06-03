<?php
/**
 * theme color
 *
 * @package shark_business_pro
 */

/**
 * Generate the CSS for the current custom color.
 */
function shark_business_pro_custom_colors_css() {
    $color_value = shark_business_pro_theme_option('colorscheme');
    
    $css = '
    a,
#masthead.site-header.sticky-header.nav-shrink .site-title a, 
.site-title a,
.main-navigation a,
.main-navigation ul.menu li.current-menu-item > a,
#masthead.site-header.sticky-header.nav-shrink .main-navigation a, 
#masthead.site-header.sticky-header.nav-shrink .main-navigation ul li.menu-item-has-children svg, 
#masthead.site-header.sticky-header.nav-shrink .main-navigation a svg,
.section-title,
article .entry-title a,
.our-services article.hentry .fa,
.counter-widget .section-title,
.counter .counter-value,
.counter h5.counter-label,
.cta-section .read-more:hover a,
.loader-container svg, 
.blog-loader svg,
.main-navigation ul li.menu-item-has-children svg,
.widget .tagcloud a:hover,
.entry-meta > span a:hover, 
.entry-meta > span a:focus,
span.cat-links a:hover, 
span.cat-links a:focus, 
span.posted-on a:hover, 
span.posted-on time:hover, 
span.posted-on a:focus, 
span.posted-on time:focus,
.contact_widget .contact-details svg,
.main-navigation .current_page_item > a,
.main-navigation .current-menu-item > a,
.main-navigation .current_page_ancestor > a,
.main-navigation .current-menu-ancestor > a
{
    color: ' . esc_attr( $color_value ) . ';
    fill: ' . esc_attr( $color_value ) . ';

}
#masthead.site-header.sticky-header .main-navigation ul li.menu-item-has-children svg,
.secondary-menu ul li svg
{
    fill: #fff;
}
.team-section .social-icons li a svg,
.testimonial-slider article .social-icons li a svg,
.main-navigation a:hover,
.main-navigation ul li.menu-item-has-children a:hover svg
{
    fill: #333;
    color: #333;
}
.team-section .position,
.testimonial-slider article .position,
article .entry-title a:hover,
a:hover, 
a:focus, 
a:active
{
    color: #333;
}
.secondary-menu,
.secondary-menu a,
#colophon .entry-content, 
.footer-widgets-area .widget, 
.footer-widgets-area a, 
.footer-widgets-area p,
#colophon .widget_latest_post .entry-meta, 
#colophon .widget_latest_post .post-content .entry-meta > span.posted-on,
#colophon article .entry-title a, 
#colophon .widget_recent_entries span.post-date,
.site-info a:hover,
#masthead.site-header.sticky-header .main-navigation .current_page_item > a,
#masthead.site-header.sticky-header .main-navigation .current-menu-item > a,
#masthead.site-header.sticky-header .main-navigation .current_page_ancestor > a,
#masthead.site-header.sticky-header .main-navigation .current-menu-ancestor > a
{
    color: #fff;
}

/* Background */

#top-menu,
.pagination .page-numbers.current,
.reply a,
.custom-header-content .separator,
.our-services article.hentry:hover .fa,
.read-more:hover,
.cta-section .overlay,
.testimonial-slider .slick-prev, 
.testimonial-slider .slick-next,
.backtotop,
.menu-toggle,
.slick-prev:hover, 
.slick-next:hover, 
.slick-prev:focus, 
.slick-next:focus,
.main-navigation ul.sub-menu,
#secondary .widget-title, 
#secondary .widgettitle,
input[type="submit"],
form.search-form button.search-submit,
.widget_search form.search-form button.search-submit
{
    background-color: ' . esc_attr( $color_value ) . ';
}
.separator,
.team-section article .entry-header .separator,
.backtotop:hover,
.cta-section,
#respond input[type="submit"]:hover, 
#respond input[type="submit"]:focus
{
    background-color: #333;
}
#colophon,
.site-info
{
    background-color: #1d1d1d;
}
.slick-prev, .slick-next
{
    background-color: rgba( 0,0,0,0.1 );
}
/* Border */

#search.search-open,
.our-services article.hentry .fa,
.post-navigation, 
.posts-navigation, 
.post-navigation, 
.posts-navigation,
#respond input[type="submit"]:hover, 
#respond input[type="submit"]:focus
{
    border-color: #333;
}
a:hover, 
a:focus, 
a:active,
.read-more,
.our-services article.hentry:hover .fa,
.widget .tagcloud a:hover,
#respond input[type="submit"]
{
    border-color: ' . esc_attr( $color_value ) . ';
}

/* Shadow */

.testimonial-slider article .testimonial-image img,
.team-section .team-image img
{
    box-shadow: 0px 0px 5px 0px #333;
}

/* Responsive */

@media screen and (max-width: 1023px) {
    .main-navigation,
    .main-navigation ul.nav-menu,
    .main-navigation ul.sub-menu
    {
        background-color: ' . esc_attr( $color_value ) . ';
    }
    .main-navigation a,
    .main-navigation ul.menu li.current-menu-item > a
    {
        color: #fff;
    }
}

@media screen and (min-width: 1024px) {
    .main-navigation ul.sub-menu li:hover > a, 
    .main-navigation ul.sub-menu li:focus > a 
    {
        background-color: ' . esc_attr( $color_value ) . ';
    }
}

/* Woocommerce */

.woocommerce ul.products li.product .woocommerce-loop-category__title, 
.woocommerce ul.products li.product .woocommerce-loop-product__title, 
.woocommerce ul.products li.product h3
{
    color: ' . esc_attr( $color_value ) . ';
}

.woocommerce #respond input#submit, 
.woocommerce a.button, 
.woocommerce button.button, 
.woocommerce input.button,
.woocommerce #respond input#submit.alt, 
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt,
.woocommerce .widget_price_filter .price_slider_amount .button,
.woocommerce ul.products li.product .button
{
    color: ' . esc_attr( $color_value ) . ';
    border-color: ' . esc_attr( $color_value ) . ';
}
.woocommerce #respond input#submit:hover, 
.woocommerce a.button:hover, 
.woocommerce button.button:hover, 
.woocommerce input.button:hover,
.woocommerce #respond input#submit.alt:hover, 
.woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, 
.woocommerce input.button.alt:hover,
.woocommerce .widget_price_filter .price_slider_amount .button:hover,
.woocommerce ul.products li.product .button:hover {
    background-color: ' . esc_attr( $color_value ) . ';
    color: #fff;
}
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range
{
    background-color: ' . esc_attr( $color_value ) . ';
}
.woocommerce-pagination svg
{
    fill: ' . esc_attr( $color_value ) . ';
}
.woocommerce nav.woocommerce-pagination ul li a:focus, 
.woocommerce nav.woocommerce-pagination ul li a:hover,
.woocommerce nav.woocommerce-pagination ul li a:hover svg
{
    border-color: #333;
    color: #333;
    fill: #333;
}';

    return apply_filters( 'shark_business_pro_custom_colors_css', $css );
}
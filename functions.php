<?php

/**
 * Enqueue parent styles.
 *
 * @since 1.0
 */
function themizzerables_enqueue_styles() {
    global $wp_customize;
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' )
    );
    if ( (! is_admin() || isset( $wp_customize ) ) &&
        ( true == is_category() && false == get_theme_mod( 'show_category_archive_headers', false ) ) ||
        ( 'page' == get_post_type() && false == get_theme_mod( 'show_page_headers', false ) )
    ) {
        wp_enqueue_style( 'themizzerables-headers',
            get_stylesheet_directory_uri() . '/headers.css',
            array( 'child-style' ) );
    }
}
add_action( 'wp_enqueue_scripts', 'themizzerables_enqueue_styles' );

/**
 * Register widget areas.
 *
 * @since 1.0
 */
function themizzerables_widgets_init() {
    unregister_sidebar( 'sidebar-1' );

    register_sidebar( array(
        'name'          => __( 'Above Sidebar Menu', 'twentyfifteen' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar above the menu.', 'twentyfifteen' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>'
    ) );

    register_sidebar( array(
        'name'          => __( 'Below Sidebar Menu', 'twentyfifteen' ),
        'id'            => 'sidebar-2',
        'description'   => __( 'Add widgets here to appear in your sidebar below the menu.', 'twentyfifteen' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>'
    ) );
}
add_action( 'widgets_init', 'themizzerables_widgets_init', 11 );

/**
 * Add customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize customizer object.
 */
function themizzerables_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'show_category_archive_headers', array(
        'default'   => false
    ) );
    $wp_customize->add_setting( 'show_page_headers', array(
        'default'   => false
    ) );
    $wp_customize->add_section( 'themizzerables_headers', array(
        'title'     => __( 'Headers', 'themizzerables' ),
        'priority'  => 30
    ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_category_archive_headers', array(
        'label'     => __( 'Show Category Archive Headers' ),
        'description'   => __( 'Will still show on small screens.' ),
        'type'      => 'checkbox',
        'section'   => 'themizzerables_headers',
        'settings'  => 'show_category_archive_headers'
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_page_headers', array(
        'label'     => __( 'Show Page Headers' ),
        'description'   => __( 'Will still show on small screens.' ),
        'type'      => 'checkbox',
        'section'   => 'themizzerables_headers',
        'settings'  => 'show_page_headers'
    ) ) );
}
add_action( 'customize_register', 'themizzerables_customize_register' );
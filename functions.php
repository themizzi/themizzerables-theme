<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

/**
 * Register widget area.
 * 
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
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
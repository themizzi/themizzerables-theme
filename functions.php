<?php
/**
 * The Mizzerables Theme
 *
 * @package themizzerables
 * @author  Joe Mizzi <themizzi@me.com>
 */
/**
 * Enqueue parent styles.
 *
 * @since   1.0
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
    if ( true == get_theme_mod( 'match_gigpress_widget_to_theme', true ) &&
        is_active_widget( false, false, 'gigpress' ) ) {
        $css = include plugin_dir_path( __FILE__ ) . 'gigpress.css.php';
        wp_add_inline_style( 'child-style', $css );
    }
    if ( (! is_admin() || isset($wp_customize ) ) &&
         true == get_theme_mod( 'add_additional_social_icons', true ) &&
         has_nav_menu( 'social' ) ) {
        wp_enqueue_style( 'font-awesome',
            '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
        wp_enqueue_style( 'themizzerables-social',
            get_stylesheet_directory_uri() . '/social.css', array(
            'font-awesome' ) );
    }
}
add_action( 'wp_enqueue_scripts', 'themizzerables_enqueue_styles' );

/**
 * Register widget areas.
 *
 * @since   1.0
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
 * @since   1.0
 * @param   WP_Customize_Manager $wp_customize customizer object.
 */
function themizzerables_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'show_category_archive_headers', array(
        'default'   => false
    ) );
    $wp_customize->add_setting( 'filter_category_archive_titles', array(
        'default'   => true
    ) );
    $wp_customize->add_setting( 'show_page_headers', array(
        'default'   => false
    ) );
    $wp_customize->add_setting( 'match_gigpress_widget_to_theme', array(
        'default'   => true
    ) );
    $wp_customize->add_setting( 'add_additional_social_icons', array(
        'default'   => true
    ) );
    $wp_customize->add_section( 'themizzerables_headers', array(
        'title'     => __( 'Headers', 'themizzerables' ),
        'priority'  => 30
    ) );
    $wp_customize->add_section( 'themizzerables_gigpress', array(
        'title'     => __( 'GigPress', 'themizzerables' ),
        'priority'  => 31
    ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_category_archive_headers', array(
        'label'     => __( 'Show Category Archive Headers' ),
        'description'   => __( 'Will still show on small screens.' ),
        'type'      => 'checkbox',
        'section'   => 'themizzerables_headers',
        'settings'  => 'show_category_archive_headers'
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'filter_category_archive_titles', array(
        'label'     => __( 'Filter Category Archive Titles' ),
        'type'      => 'checkbox',
        'section'   => 'themizzerables_headers',
        'settings'  => 'filter_category_archive_titles'
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'show_page_headers', array(
        'label'     => __( 'Show Page Headers' ),
        'description'   => __( 'Will still show on small screens.' ),
        'type'      => 'checkbox',
        'section'   => 'themizzerables_headers',
        'settings'  => 'show_page_headers'
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'match_gigpress_widget_to_theme', array(
        'label'     => __( 'Match GigPress Widget to Theme' ),
        'type'      => 'checkbox',
        'section'   => 'themizzerables_gigpress',
        'settings'  => 'match_gigpress_widget_to_theme'
    ) ) );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'add_additional_social_icons', array (
        'label'     => __( 'Add Additional Social Icons' ),
        'type'      => 'checkbox',
        'section'   => 'nav',
        'settings'  => 'add_additional_social_icons'
    ) ) );
}
add_action( 'customize_register', 'themizzerables_customize_register', 999 );

/**
 * Filter the category title
 *
 * @since   1.0
 * @param   $title
 * @return  string
 */
function filter_category_archive_titles( $title ) {
    if ( get_theme_mod( 'filter_category_archive_titles', true ) && 0 === strpos( $title, 'Category: ' ) ) {
        $title = substr( $title, 10);
    }
    return $title   ;
}
add_filter( 'get_the_archive_title', 'filter_category_archive_titles' );

/**
 * Auto update
 *
 * @since 1.0
 */
function themizzerables_check_for_update( $transient ) {
    if ( ! defined( 'THEMIZZERABLES_THEME_LATEST_VERSION' ) ) {
        $result = wp_remote_get(
            'https://raw.githubusercontent.com/themizzi/themizzerables-theme/master/style.css'
        );
        $body   = wp_remote_retrieve_body( $result );
        if (is_wp_error( $body )
            || wp_remote_retrieve_response_code( $result ) != 200
        ) {
            return $transient;
        }
        $matches = array();
        preg_match( '/Version:\s*(.*)/', $body, $matches );

        if (count( $matches ) > 1) {
            define( 'THEMIZZERABLES_THEME_LATEST_VERSION', $matches[1] );
        } else {
            return $transient;
        }
    }

    $old_version = wp_get_theme( 'themizzerables-theme-master' )->get( 'Version' );
    if ( THEMIZZERABLES_THEME_LATEST_VERSION > $old_version ) {
        $transient->response['themizzerables-theme'] = [
            'slug'          => 'themizzerables-theme-master',
            'new_version'   => THEMIZZERABLES_THEME_LATEST_VERSION,
            'url'           => 'http://themizzerables.com',
            'package'       => 'https://github.com/themizzi/themizzerables-theme/archive/master.zip'
        ];
    }
    return $transient;
}
add_filter ('site_transient_update_themes', 'themizzerables_check_for_update');
<?php
/**
 * Prevent switching to Home Finder on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Home Finder 1.0
 */
function fundor_switch_theme() {
    switch_theme( WP_DEFAULT_THEME );
    unset( $_GET['activated'] );
    add_action( 'admin_notices', 'fundor_upgrade_notice' );
}

add_action( 'after_switch_theme', 'fundor_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Home Finder on WordPress versions prior to 4.7.
 *
 * @since Home Finder 1.0
 *
 * @global string $wp_version WordPress version.
 */
function fundor_upgrade_notice() {
    $message = sprintf( esc_html__( 'Fundor requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'fundor' ), $GLOBALS['wp_version'] );
    printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Home Finder 1.0
 *
 * @global string $wp_version WordPress version.
 */
function fundor_customize() {
    wp_die( sprintf( esc_html__( 'Fundor requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'fundor' ), $GLOBALS['wp_version'] ), '', array(
        'back_link' => true,
    ) );
}

add_action( 'load-customize.php', 'fundor_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Home Finder 1.0
 *
 * @global string $wp_version WordPress version.
 */
function fundor_preview() {
    if (isset( $_GET['preview'] )) {
        wp_die( sprintf( esc_html__( 'Fundor requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'fundor' ), $GLOBALS['wp_version'] ) );
    }
}

add_action( 'template_redirect', 'fundor_preview' );

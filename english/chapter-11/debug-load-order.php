// Enable only in development — never in production
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    $hooks_to_track = [
        'muplugins_loaded',
        'plugins_loaded',
        'after_setup_theme',
        'init',
        'wp_loaded',
        'wp',
        'template_redirect',
        'wp_head',
        'wp_footer',
        'shutdown',
    ];

    foreach ( $hooks_to_track as $hook ) {
        add_action( $hook, function() use ( $hook ): void {
            error_log( date( 'H:i:s.u' ) . " — hook: {$hook}" );
        } );
    }
}

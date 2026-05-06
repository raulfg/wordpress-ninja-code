add_action( 'wp_enqueue_scripts', function(): void {
    wp_enqueue_script(
        'ninja-portfolio',
        get_template_directory_uri() . '/dist/portfolio.js',
        [],
        NINJA_THEME_VERSION,
        true
    );

    // Código a ejecutar antes del script
    wp_add_inline_script(
        'ninja-portfolio',
        'window.NinjaConfig = ' . wp_json_encode( [
            'apiUrl'    => esc_url( rest_url( 'ninja-portfolio/v1/' ) ),
            'nonce'     => wp_create_nonce( 'wp_rest' ),
            'isLoggedIn' => is_user_logged_in(),
            'userId'    => get_current_user_id(),
        ] ) . ';',
        'before' // Posición: 'before' o 'after' (por defecto 'after')
    );

    // Código a ejecutar después del script
    wp_add_inline_script(
        'ninja-portfolio',
        'NinjaPortfolio.init( window.NinjaConfig );',
        'after'
    );
} );

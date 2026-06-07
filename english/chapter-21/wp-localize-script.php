add_action( 'wp_enqueue_scripts', 'ninja_enqueue_assets' );

function ninja_enqueue_assets(): void {
    wp_enqueue_script(
        'ninja-portfolio',
        get_theme_file_uri( 'build/portfolio.js' ),
        [],
        '1.0.0',
        [ 'in_footer' => true ]
    );

    wp_localize_script(
        'ninja-portfolio',
        'ninjaPortfolio',
        [
            'apiUrl'   => rest_url( 'ninja/v1/portfolio' ),
            'nonce'    => wp_create_nonce( 'wp_rest' ),
            'perPage'  => get_option( 'posts_per_page' ),
            'isLogged' => is_user_logged_in(),
        ]
    );
}

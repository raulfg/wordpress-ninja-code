add_action( 'wp_enqueue_scripts', 'ninjatheme_enqueue_scripts' );

function ninjatheme_enqueue_scripts(): void {
    wp_enqueue_script(
        'ninjatheme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.0.0',
        true
    );

    wp_localize_script( 'ninjatheme-main', 'ninjaConfig', [
        'apiUrl' => rest_url( 'wp/v2/' ),
        'nonce'  => wp_create_nonce( 'wp_rest' ),
    ] );
}

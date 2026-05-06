function ninjatheme_enqueue_assets(): void {
    wp_enqueue_style(
        'ninjatheme-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );

    wp_enqueue_style(
        'ninjatheme-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [ 'ninjatheme-style' ],
        '1.0.0'
    );

    wp_enqueue_script(
        'ninjatheme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [ 'jquery' ],
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'ninjatheme_enqueue_assets' );

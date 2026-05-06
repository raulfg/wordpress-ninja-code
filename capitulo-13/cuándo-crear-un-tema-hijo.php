function ninjatheme_child_enqueue_assets(): void {
    // Encolar el CSS del padre correctamente, con su versión.
    wp_enqueue_style(
        'ninjatheme-parent-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'ninjatheme' )->get( 'Version' )
    );

    // Encolar el CSS del hijo.
    wp_enqueue_style(
        'ninjatheme-child-style',
        get_stylesheet_uri(),
        [ 'ninjatheme-parent-style' ],
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'ninjatheme_child_enqueue_assets' );

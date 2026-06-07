function ninjatheme_child_enqueue_assets(): void {
    // Enqueue the parent CSS correctly, with its version.
    wp_enqueue_style(
        'ninjatheme-parent-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'ninjatheme' )->get( 'Version' )
    );

    // Enqueue the child CSS.
    wp_enqueue_style(
        'ninjatheme-child-style',
        get_stylesheet_uri(),
        [ 'ninjatheme-parent-style' ],
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'ninjatheme_child_enqueue_assets' );

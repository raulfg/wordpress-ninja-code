add_action( 'after_setup_theme', function(): void {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'editor-styles' );     // Applies the editor CSS
    add_theme_support( 'wp-block-styles' );   // Core block styles
    add_theme_support( 'responsive-embeds' ); // Embeds with aspect ratio

    // Block themes need this explicit support for Gutenberg
    add_theme_support( 'block-templates' );

    load_theme_textdomain( 'ninjatheme', get_template_directory() . '/languages' );
} );

add_action( 'wp_enqueue_scripts', function(): void {
    $asset = require get_template_directory() . '/build/index.asset.php';

    wp_enqueue_style(
        'ninjatheme-style',
        get_stylesheet_uri(),
        [],
        $asset['version']
    );

    wp_enqueue_style(
        'ninjatheme-main',
        get_template_directory_uri() . '/build/index.css',
        [ 'ninjatheme-style' ],
        $asset['version']
    );

    wp_enqueue_script(
        'ninjatheme-main',
        get_template_directory_uri() . '/build/index.js',
        $asset['dependencies'],
        $asset['version'],
        true
    );
} );

// Styles applied in the editor (editor-styles)
add_action( 'after_setup_theme', function(): void {
    add_editor_style( 'build/index.css' );
} );

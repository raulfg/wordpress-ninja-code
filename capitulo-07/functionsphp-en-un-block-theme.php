add_action( 'after_setup_theme', function(): void {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'editor-styles' );     // Aplica el CSS del editor
    add_theme_support( 'wp-block-styles' );   // Estilos de bloque del core
    add_theme_support( 'responsive-embeds' ); // Embeds con aspect ratio

    // Los block themes necesitan este soporte explícito para Gutenberg
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

// Estilos aplicados en el editor (editor-styles)
add_action( 'after_setup_theme', function(): void {
    add_editor_style( 'build/index.css' );
} );

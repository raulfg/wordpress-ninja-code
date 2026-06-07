add_action( 'wp_enqueue_scripts', 'ninja_enqueue_assets' );

function ninja_enqueue_assets(): void {
    $asset = require get_theme_file_path( 'build/portfolio.asset.php' );

    wp_enqueue_script(
        'ninja-portfolio',
        get_theme_file_uri( 'build/portfolio.js' ),
        $asset['dependencies'],
        $asset['version'],
        [ 'in_footer' => true ]
    );

    wp_enqueue_style(
        'ninja-portfolio-style',
        get_theme_file_uri( 'build/portfolio.css' ),
        [],
        $asset['version']
    );
}

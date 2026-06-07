add_action( 'wp_enqueue_scripts', function(): void {
    if ( ! is_post_type_archive( 'portfolio' ) && ! is_tax( 'portfolio-category' ) ) {
        return;
    }

    $asset = require get_template_directory() . '/build/portfolio.asset.php';

    wp_enqueue_script(
        'ninjatheme-portfolio',
        get_template_directory_uri() . '/build/portfolio.js',
        $asset['dependencies'],
        $asset['version'],
        [ 'in_footer' => true ]
    );

    // Pass the current context data to the script
    $current_category = '';
    if ( is_tax( 'portfolio-category' ) ) {
        $term             = get_queried_object();
        $current_category = $term->slug ?? '';
    }

    wp_add_inline_script(
        'ninjatheme-portfolio',
        'window.ninjaPortfolio = ' . wp_json_encode( [
            'apiUrl'          => rest_url( 'ninjatheme/v1/portfolio' ),
            'nonce'           => wp_create_nonce( 'wp_rest' ),
            'currentCategory' => $current_category,
            'perPage'         => 12,
            'i18n'            => [
                'loading'  => __( 'Loading projects...', 'ninjatheme' ),
                'noMore'   => __( 'You have reached the end.', 'ninjatheme' ),
                'error'    => __( 'Error loading projects.', 'ninjatheme' ),
                'loadMore' => __( 'Load more', 'ninjatheme' ),
            ],
        ] ),
        'before'
    );
} );

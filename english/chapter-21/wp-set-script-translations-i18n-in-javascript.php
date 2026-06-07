add_action( 'wp_enqueue_scripts', function(): void {
    wp_enqueue_script(
        'ninja-portfolio-filter',
        get_template_directory_uri() . '/dist/portfolio-filter.js',
        [ 'wp-i18n' ],
        NINJA_THEME_VERSION,
        true
    );

    // Connect translations: text domain + language + path to .json files
    wp_set_script_translations(
        'ninja-portfolio-filter',
        'ninjatheme',
        get_template_directory() . '/languages'
    );
} );

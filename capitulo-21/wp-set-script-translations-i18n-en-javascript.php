add_action( 'wp_enqueue_scripts', function(): void {
    wp_enqueue_script(
        'ninja-portfolio-filter',
        get_template_directory_uri() . '/dist/portfolio-filter.js',
        [ 'wp-i18n' ],
        NINJA_THEME_VERSION,
        true
    );

    // Conectar traducciones: texto dominio + idioma + ruta de archivos .json
    wp_set_script_translations(
        'ninja-portfolio-filter',
        'ninjatheme',
        get_template_directory() . '/languages'
    );
} );

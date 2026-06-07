add_action( 'admin_enqueue_scripts', 'ninja_enqueue_admin_assets' );

function ninja_enqueue_admin_assets( string $hook_suffix ): void {
    // Solo en la página específica del plugin
    if ( 'toplevel_page_ninja-settings' !== $hook_suffix ) {
        return;
    }

    wp_enqueue_script(
        'ninja-admin',
        get_theme_file_uri( 'build/admin.js' ),
        [ 'wp-api-fetch' ],
        '1.0.0',
        [ 'in_footer' => true ]
    );
}

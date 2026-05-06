add_action( 'acf/init', 'ninjatheme_register_options_pages' );

function ninjatheme_register_options_pages(): void {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( [
        'page_title' => 'Configuración del tema',
        'menu_title' => 'Configuración',
        'menu_slug'  => 'ninjatheme-settings',
        'capability' => 'manage_options',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-settings',
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'Redes sociales',
        'menu_title'  => 'Redes sociales',
        'parent_slug' => 'ninjatheme-settings',
    ] );
}

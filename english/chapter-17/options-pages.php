add_action( 'acf/init', 'ninjatheme_register_options_pages' );

function ninjatheme_register_options_pages(): void {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( [
        'page_title' => 'Theme settings',
        'menu_title' => 'Settings',
        'menu_slug'  => 'ninjatheme-settings',
        'capability' => 'manage_options',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-settings',
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'Social networks',
        'menu_title'  => 'Social networks',
        'parent_slug' => 'ninjatheme-settings',
    ] );
}

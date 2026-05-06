add_action( 'admin_menu', function () {
    // Menú de ajustes del sitio: disponible para administradores de sitio
    add_theme_page(
        'NinjaTheme — Ajustes del sitio',
        'NinjaTheme',
        'manage_options',
        'ninjatheme-settings',
        'ninjatheme_settings_page'
    );

    // Menú de ajustes de red: solo para Super Admin
    if ( is_multisite() && is_super_admin() ) {
        add_submenu_page(
            'settings.php',  // Aparece en Ajustes de red
            'NinjaTheme — Red',
            'NinjaTheme Red',
            'manage_network_options',
            'ninjatheme-network-settings',
            'ninjatheme_network_settings_page'
        );
    }
} );

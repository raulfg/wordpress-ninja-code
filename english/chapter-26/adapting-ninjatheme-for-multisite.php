add_action( 'admin_menu', function () {
    // Site settings menu: available to site administrators
    add_theme_page(
        'NinjaTheme — Site Settings',
        'NinjaTheme',
        'manage_options',
        'ninjatheme-settings',
        'ninjatheme_settings_page'
    );

    // Network settings menu: Super Admin only
    if ( is_multisite() && is_super_admin() ) {
        add_submenu_page(
            'settings.php',  // Appears under Network Settings
            'NinjaTheme — Network',
            'NinjaTheme Network',
            'manage_network_options',
            'ninjatheme-network-settings',
            'ninjatheme_network_settings_page'
        );
    }
} );

// Frontend: scripts y estilos del sitio público
add_action( 'wp_enqueue_scripts', function (): void { /* ... */ } );

// Admin: assets del panel de administración
add_action( 'admin_enqueue_scripts', function ( string $hook_suffix ): void {
    // $hook_suffix identifica qué pantalla del admin está cargando
    // Ejemplos: 'post.php', 'post-new.php', 'edit.php', 'settings_page_miplugin'
    if ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) {
        wp_enqueue_script( 'mi-editor-script', /* ... */ );
    }
} );

// Login: assets de la pantalla de login
add_action( 'login_enqueue_scripts', function (): void { /* ... */ } );

// En el <head> del frontend (también wp_print_styles)
add_action( 'wp_head', function (): void { /* ... */ } );

// Antes de </body> en el frontend
add_action( 'wp_footer', function (): void { /* ... */ } );

// En el <head> del admin
add_action( 'admin_head', function (): void { /* ... */ } );

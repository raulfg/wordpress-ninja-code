// Frontend: scripts and styles for the public site
add_action( 'wp_enqueue_scripts', function (): void { /* ... */ } );

// Admin: assets for the administration panel
add_action( 'admin_enqueue_scripts', function ( string $hook_suffix ): void {
    // $hook_suffix identifies which admin screen is loading
    // Examples: 'post.php', 'post-new.php', 'edit.php', 'settings_page_myplugin'
    if ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) {
        wp_enqueue_script( 'my-editor-script', /* ... */ );
    }
} );

// Login: assets for the login screen
add_action( 'login_enqueue_scripts', function (): void { /* ... */ } );

// In the frontend <head> (also wp_print_styles)
add_action( 'wp_head', function (): void { /* ... */ } );

// Before </body> on the frontend
add_action( 'wp_footer', function (): void { /* ... */ } );

// In the admin <head>
add_action( 'admin_head', function (): void { /* ... */ } );

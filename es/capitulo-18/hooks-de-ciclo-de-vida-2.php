// Preferir uninstall.php sobre register_uninstall_hook para mayor control
// Crear el archivo uninstall.php en la raíz del plugin

// uninstall.php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die; // Acceso directo bloqueado
}

// Opción controlada por el usuario: ¿borrar datos al desinstalar?
$delete_data = get_option( 'npe_delete_data_on_uninstall', false );

if ( $delete_data ) {
    global $wpdb;

    // Eliminar la tabla de analítica
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}npe_analytics" );

    // Eliminar todas las opciones del plugin
    $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'npe_%'" );

    // Eliminar todos los post meta del plugin
    $wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '_npe_%'" );

    // En Multisite: repetir para cada sitio de la red
    if ( is_multisite() ) {
        $sites = get_sites( [ 'number' => 0 ] );
        foreach ( $sites as $site ) {
            switch_to_blog( $site->blog_id );
            $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'npe_%'" );
            $wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '_npe_%'" );
            restore_current_blog();
        }
    }
}

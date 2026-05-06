function mi_plugin_flush_products_cache(): void
{
    delete_transient( 'mi_plugin_products_v1' );
}

// Desde el admin, con nonce para seguridad
add_action( 'admin_post_mi_plugin_flush_cache', function (): void {
    check_admin_referer( 'mi_plugin_flush_cache' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'No tienes permiso para realizar esta acción.' );
    }

    mi_plugin_flush_products_cache();

    wp_redirect( add_query_arg( 'flushed', '1', wp_get_referer() ) );
    exit;
} );

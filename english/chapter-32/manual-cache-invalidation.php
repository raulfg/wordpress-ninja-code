<?php

function my_plugin_flush_products_cache(): void
{
    delete_transient( 'my_plugin_products_v1' );
}

// From the admin, with nonce for security
add_action( 'admin_post_my_plugin_flush_cache', function (): void {
    check_admin_referer( 'my_plugin_flush_cache' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'You do not have permission to perform this action.' );
    }

    my_plugin_flush_products_cache();

    wp_redirect( add_query_arg( 'flushed', '1', wp_get_referer() ) );
    exit;
} );

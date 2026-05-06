function ninja_rest_get_projects( WP_REST_Request $request ): WP_REST_Response {
    $cache_key = 'projects_' . md5( serialize( $request->get_params() ) );
    $group     = 'ninja_rest';

    $cached = wp_cache_get( $cache_key, $group );

    if ( false !== $cached ) {
        return new WP_REST_Response( $cached );
    }

    $data = ninja_build_projects_response( $request );

    wp_cache_set( $cache_key, $data, $group, 300 ); // 5 minutos

    return new WP_REST_Response( $data );
}

// Invalidar todo el grupo de caché al actualizar el portfolio
add_action( 'save_post_portfolio', function(): void {
    wp_cache_flush_group( 'ninja_rest' ); // Requiere Redis object cache
} );

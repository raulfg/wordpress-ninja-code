function ninja_get_featured_portfolio( int $limit = 6 ): array {
    $cache_key = 'ninja_featured_portfolio_' . $limit;
    $cached    = get_transient( $cache_key );

    if ( false !== $cached ) {
        return $cached;
    }

    $query = new WP_Query( [
        'post_type'              => 'portfolio',
        'post_status'            => 'publish',
        'posts_per_page'         => $limit,
        'meta_key'               => '_proyecto_destacado',
        'meta_value'             => '1',
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ] );

    $results = $query->posts;

    set_transient( $cache_key, $results, HOUR_IN_SECONDS );

    return $results;
}

// Invalidar el caché cuando cambia un proyecto
add_action( 'save_post_portfolio', function( int $post_id ): void {
    // Eliminar todos los transients de portfolio destacado
    // La forma más segura es usar un sufijo para identificarlos
    global $wpdb;
    $wpdb->query(
        "DELETE FROM {$wpdb->options}
         WHERE option_name LIKE '_transient_ninja_featured_portfolio_%'
            OR option_name LIKE '_transient_timeout_ninja_featured_portfolio_%'"
    );
} );

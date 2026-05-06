function ninja_get_featured_with_category_cached(): array {
    $cache_key   = 'ninja_featured_with_category';
    $cache_group = 'ninja_portfolio';

    $cached = wp_cache_get( $cache_key, $cache_group );

    if ( false !== $cached ) {
        return $cached;
    }

    $results = ninja_get_featured_with_category();
    wp_cache_set( $cache_key, $results, $cache_group, 10 * MINUTE_IN_SECONDS );

    return $results;
}

// Invalidar el caché al guardar o actualizar un proyecto destacado
add_action( 'save_post_portfolio', function( int $post_id ): void {
    $is_featured = get_post_meta( $post_id, '_npe_is_featured', true );
    if ( $is_featured ) {
        wp_cache_delete( 'ninja_featured_with_category', 'ninja_portfolio' );
    }
} );

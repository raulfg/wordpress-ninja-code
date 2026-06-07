function ninja_get_portfolio_cards(): array {
    $cache_key = 'ninja_portfolio_cards';
    $cached    = get_transient( $cache_key );

    if ( false !== $cached ) {
        return $cached;
    }

    $posts = get_posts( [
        'post_type'              => 'portfolio',
        'posts_per_page'         => 12,
        'post_status'            => 'publish',
        'update_post_meta_cache' => true,
    ] );

    $cards = array_map( function( WP_Post $post ): array {
        return [
            'id'       => $post->ID,
            'title'    => get_the_title( $post ),
            'url'      => get_permalink( $post ),
            'cliente'  => get_field( 'proyecto_cliente', $post->ID ),
            'year'     => get_field( 'proyecto_year', $post->ID ),
            'thumb'    => get_the_post_thumbnail_url( $post->ID, 'portfolio-card' ),
        ];
    }, $posts );

    set_transient( $cache_key, $cards, 30 * MINUTE_IN_SECONDS );

    return $cards;
}

// Invalidate the transient when a project is saved
add_action( 'save_post_portfolio', function(): void {
    delete_transient( 'ninja_portfolio_cards' );
} );

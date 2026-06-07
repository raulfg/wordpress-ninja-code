function ninja_get_related_posts( int $post_id, string $taxonomy, int $limit = 3 ): array {
    $terms = get_the_terms( $post_id, $taxonomy );

    if ( ! $terms || is_wp_error( $terms ) ) {
        return [];
    }

    $term_ids = wp_list_pluck( $terms, 'term_id' );

    $query = new WP_Query( [
        'post_type'           => get_post_type( $post_id ),
        'post_status'         => 'publish',
        'posts_per_page'      => $limit,
        'post__not_in'        => [ $post_id ],
        'tax_query'           => [
            [
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ],
        ],
        'no_found_rows'       => true,  // Importante: ver explicación abajo
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ] );

    return $query->posts;
}

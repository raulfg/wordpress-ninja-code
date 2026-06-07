function ninja_execute_get_projects( array $args = [] ): array {
    $query_args = [
        'post_type'      => 'portfolio',
        'post_status'    => 'publish',
        'posts_per_page' => (int) ( $args['limit'] ?? 10 ),
    ];

    if ( ! empty( $args['category'] ) ) {
        $query_args['tax_query'] = [
            [
                'taxonomy' => 'portfolio-category',
                'field'    => 'slug',
                'terms'    => sanitize_key( $args['category'] ),
            ],
        ];
    }

    if ( ! empty( $args['featured'] ) ) {
        $query_args['meta_query'] = [
            [
                'key'   => '_npe_is_featured',
                'value' => '1',
            ],
        ];
    }

    $posts = get_posts( $query_args );

    return array_map( function( WP_Post $post ): array {
        return [
            'id'       => $post->ID,
            'title'    => get_the_title( $post ),
            'url'      => get_permalink( $post ),
            'client'   => (string) get_post_meta( $post->ID, '_npe_client_name', true ),
            'year'     => (int) get_post_meta( $post->ID, '_npe_project_year', true ),
            'featured' => (bool) get_post_meta( $post->ID, '_npe_is_featured', true ),
        ];
    }, $posts );
}

add_action( 'rest_api_init', 'ninjatheme_register_routes' );

function ninjatheme_register_routes(): void {
    register_rest_route(
        'ninjatheme/v1',
        '/portfolio',
        [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'ninjatheme_get_portfolio',
            'permission_callback' => '__return_true',
            'args'                => [
                'per_page' => [
                    'default'           => 10,
                    'validate_callback' => fn( $v ) => is_numeric( $v ) && $v > 0 && $v <= 100,
                    'sanitize_callback' => 'absint',
                ],
                'page' => [
                    'default'           => 1,
                    'validate_callback' => fn( $v ) => is_numeric( $v ) && $v > 0,
                    'sanitize_callback' => 'absint',
                ],
            ],
        ]
    );
}

function ninjatheme_get_portfolio( WP_REST_Request $request ): WP_REST_Response|WP_Error {
    $query = new WP_Query( [
        'post_type'      => 'portfolio',
        'post_status'    => 'publish',
        'posts_per_page' => $request->get_param( 'per_page' ),
        'paged'          => $request->get_param( 'page' ),
    ] );

    if ( ! $query->have_posts() ) {
        return new WP_REST_Response( [], 200 );
    }

    $items = array_map( function( WP_Post $post ) {
        return [
            'id'           => $post->ID,
            'title'        => get_the_title( $post ),
            'slug'         => $post->post_name,
            'link'         => get_permalink( $post ),
            'project_url'  => get_post_meta( $post->ID, 'project_url', true ),
            'client_name'  => get_post_meta( $post->ID, 'client_name', true ),
            'thumbnail'    => get_the_post_thumbnail_url( $post, 'large' ),
        ];
    }, $query->posts );

    $response = new WP_REST_Response( $items, 200 );
    $response->header( 'X-WP-Total', $query->found_posts );
    $response->header( 'X-WP-TotalPages', $query->max_num_pages );

    return $response;
}

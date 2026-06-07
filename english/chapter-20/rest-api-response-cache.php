add_action( 'rest_api_init', function (): void {
    register_rest_route( 'ninja-portfolio/v1', '/projects', [
        'methods'             => 'GET',
        'callback'            => 'ninja_rest_get_projects',
        'permission_callback' => '__return_true',
        'args'                => [
            'featured' => [
                'type'    => 'boolean',
                'default' => false,
            ],
            'category' => [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_key',
            ],
        ],
    ] );
} );

function ninja_rest_get_projects( WP_REST_Request $request ): WP_REST_Response {
    // Build a unique cache key based on the request parameters
    $cache_key = 'ninja_rest_projects_' . md5( serialize( $request->get_params() ) );
    $cached    = get_transient( $cache_key );

    if ( false !== $cached ) {
        return new WP_REST_Response( $cached );
    }

    // Run the expensive query
    $query_args = [
        'post_type'      => 'portfolio',
        'post_status'    => 'publish',
        'posts_per_page' => 20,
    ];

    if ( $request->get_param( 'featured' ) ) {
        $query_args['meta_query'] = [ [ 'key' => '_npe_is_featured', 'value' => '1' ] ];
    }

    if ( $category = $request->get_param( 'category' ) ) {
        $query_args['tax_query'] = [ [
            'taxonomy' => 'portfolio-category',
            'field'    => 'slug',
            'terms'    => $category,
        ] ];
    }

    $posts = get_posts( $query_args );
    $data  = array_map( 'ninja_format_project_for_api', $posts );

    // Cache for 5 minutes
    set_transient( $cache_key, $data, 5 * MINUTE_IN_SECONDS );

    return new WP_REST_Response( $data );
}

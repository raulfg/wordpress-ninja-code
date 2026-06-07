// Original REST endpoint — keep during migration
add_action( 'rest_api_init', function(): void {
    register_rest_route( 'ninja-portfolio/v1', '/featured', [
        'methods'             => 'GET',
        'callback'            => 'ninja_rest_get_featured_projects',
        'permission_callback' => '__return_true',
        'args'                => [
            'limit' => [
                'type'    => 'integer',
                'default' => 6,
                'minimum' => 1,
                'maximum' => 24,
            ],
        ],
    ] );
} );

function ninja_rest_get_featured_projects( WP_REST_Request $request ): array {
    return ninja_query_featured_projects( (int) $request->get_param( 'limit' ) );
}

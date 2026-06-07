add_action( 'rest_api_init', function(): void {
    add_filter( 'rest_portfolio_query', function( array $args, WP_REST_Request $request ): array {
        $featured = $request->get_param( 'featured' );

        if ( null !== $featured ) {
            $args['meta_query'] = array_merge(
                $args['meta_query'] ?? [],
                [
                    [
                        'key'   => '_npe_is_featured',
                        'value' => filter_var( $featured, FILTER_VALIDATE_BOOLEAN ) ? '1' : '',
                    ],
                ]
            );
        }

        return $args;
    }, 10, 2 );

    // Declare the parameter so it appears in the API documentation
    add_filter( 'rest_portfolio_collection_params', function( array $params ): array {
        $params['featured'] = [
            'description' => 'Filter by featured projects.',
            'type'        => 'boolean',
        ];
        return $params;
    } );
} );

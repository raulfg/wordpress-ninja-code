register_rest_route(
    'ninjatheme/v1',
    '/portfolio/(?P<id>\d+)',
    [
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'ninjatheme_get_portfolio_item',
        'permission_callback' => '__return_true',
        'args'                => [
            'id' => [
                'required'          => true,
                'validate_callback' => fn( $value ) => is_numeric( $value ) && $value > 0,
                'sanitize_callback' => 'absint',
            ],
        ],
    ]
);

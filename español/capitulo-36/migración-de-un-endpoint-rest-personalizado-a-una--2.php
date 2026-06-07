add_action( 'wp_abilities_api_init', function(): void {
    wp_register_ability( 'ninja-portfolio/get-featured-projects', [
        'label'       => 'Obtener proyectos destacados',
        'description' => 'Devuelve la lista de proyectos marcados como destacados.',
        'category'    => 'ninja-portfolio',
        'annotations' => [
            'readonly'    => true,
            'destructive' => false,
            'idempotent'  => true,
        ],
        'meta' => [
            'show_in_rest'       => true,
            'input_schema'       => [
                'type'       => 'object',
                'properties' => [
                    'limit' => [
                        'type'    'integer',
                        'default' => 6,
                        'minimum' => 1,
                        'maximum' => 24,
                    ],
                ],
            ],
            'output_schema'      => [
                'type'  => 'array',
                'items' => [
                    'type'       => 'object',
                    'properties' => [
                        'id'     => [ 'type' => 'integer' ],
                        'title'  => [ 'type' => 'string' ],
                        'url'    => [ 'type' => 'string', 'format' => 'uri' ],
                        'client' => [ 'type' => 'string' ],
                    ],
                ],
            ],
            'permission_callback' => '__return_true',
        ],
        'execute_callback' => function( array $args ): array {
            return ninja_query_featured_projects( $args['limit'] ?? 6 );
        },
    ] );
} );

add_action( 'wp_abilities_api_init', 'ninja_register_portfolio_abilities' );

function ninja_register_portfolio_abilities(): void {
    wp_register_ability(
        'ninja-portfolio/get-projects',
        [
            'label'            => __( 'Get portfolio projects', 'ninja-portfolio' ),
            'description'      => __( 'Returns a list of portfolio projects with their metadata.', 'ninja-portfolio' ),
            'category'         => 'content',
            'input_schema'     => [
                'type'       => 'object',
                'properties' => [
                    'category' => [
                        'type'        => 'string',
                        'description' => 'Portfolio category slug to filter results.',
                    ],
                    'featured' => [
                        'type'        => 'boolean',
                        'description' => 'If true, returns only projects marked as featured.',
                    ],
                    'limit'    => [
                        'type'        => 'integer',
                        'description' => 'Maximum number of projects to return. Default: 10.',
                        'default'     => 10,
                    ],
                ],
            ],
            'output_schema'    => [
                'type'  => 'array',
                'items' => [
                    'type'       => 'object',
                    'properties' => [
                        'id'       => [ 'type' => 'integer' ],
                        'title'    => [ 'type' => 'string' ],
                        'url'      => [ 'type' => 'string', 'format' => 'uri' ],
                        'client'   => [ 'type' => 'string' ],
                        'year'     => [ 'type' => 'integer' ],
                        'featured' => [ 'type' => 'boolean' ],
                    ],
                ],
            ],
            'execute_callback' => 'ninja_execute_get_projects',
            'permission_callback' => '__return_true', // Public read
            'meta'             => [
                'show_in_rest'  => true,
                'annotations'   => [
                    'readonly'    => true,
                    'destructive' => false,
                    'idempotent'  => true,
                ],
            ],
        ]
    );
}

add_action( 'wp_abilities_api_init', 'ninja_register_portfolio_abilities' );

function ninja_register_portfolio_abilities(): void {
    wp_register_ability(
        'ninja-portfolio/get-projects',
        [
            'label'            => __( 'Obtener proyectos del portfolio', 'ninja-portfolio' ),
            'description'      => __( 'Devuelve una lista de proyectos del portfolio con sus metadatos.', 'ninja-portfolio' ),
            'category'         => 'content',
            'input_schema'     => [
                'type'       => 'object',
                'properties' => [
                    'category' => [
                        'type'        => 'string',
                        'description' => 'Slug de la categoría de portfolio para filtrar resultados.',
                    ],
                    'featured' => [
                        'type'        => 'boolean',
                        'description' => 'Si es true, devuelve solo proyectos marcados como destacados.',
                    ],
                    'limit'    => [
                        'type'        => 'integer',
                        'description' => 'Número máximo de proyectos a devolver. Por defecto: 10.',
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
            'permission_callback' => '__return_true', // Lectura pública
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

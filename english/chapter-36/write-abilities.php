wp_register_ability(
    'ninja-portfolio/create-project',
    [
        'label'       => __( 'Create portfolio project', 'ninja-portfolio' ),
        'description' => __( 'Creates a new project in the portfolio with the provided data.', 'ninja-portfolio' ),
        'category'    => 'content',
        'input_schema' => [
            'type'       => 'object',
            'required'   => [ 'title' ],
            'properties' => [
                'title'       => [
                    'type'        => 'string',
                    'description' => 'Project title.',
                    'minLength'   => 1,
                    'maxLength'   => 200,
                ],
                'description' => [
                    'type'        => 'string',
                    'description' => 'Project description (limited HTML allowed).',
                ],
                'client'      => [
                    'type'        => 'string',
                    'description' => 'Client name.',
                ],
                'year'        => [
                    'type'        => 'integer',
                    'description' => 'Year the project was completed.',
                    'minimum'     => 2000,
                    'maximum'     => 2100,
                ],
                'category'    => [
                    'type'        => 'string',
                    'description' => 'Portfolio category slug.',
                ],
                'featured'    => [
                    'type'        => 'boolean',
                    'description' => 'Whether the project should be marked as featured.',
                    'default'     => false,
                ],
            ],
        ],
        'output_schema' => [
            'type'       => 'object',
            'properties' => [
                'id'      => [ 'type' => 'integer', 'description' => 'ID of the created post.' ],
                'url'     => [ 'type' => 'string', 'format' => 'uri' ],
                'success' => [ 'type' => 'boolean' ],
            ],
        ],
        'execute_callback'    => 'ninja_execute_create_project',
        'permission_callback' => function(): bool {
            return current_user_can( 'edit_posts' );
        },
        'meta' => [
            'show_in_rest'  => true,
            'annotations'   => [
                'readonly'    => false,
                'destructive' => false,
                'idempotent'  => false,
            ],
        ],
    ]
);

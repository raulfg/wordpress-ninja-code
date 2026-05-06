wp_register_ability(
    'ninja-portfolio/create-project',
    [
        'label'       => __( 'Crear proyecto de portfolio', 'ninja-portfolio' ),
        'description' => __( 'Crea un nuevo proyecto en el portfolio con los datos proporcionados.', 'ninja-portfolio' ),
        'category'    => 'content',
        'input_schema' => [
            'type'       => 'object',
            'required'   => [ 'title' ],
            'properties' => [
                'title'       => [
                    'type'        => 'string',
                    'description' => 'Título del proyecto.',
                    'minLength'   => 1,
                    'maxLength'   => 200,
                ],
                'description' => [
                    'type'        => 'string',
                    'description' => 'Descripción del proyecto (HTML permitido limitado).',
                ],
                'client'      => [
                    'type'        => 'string',
                    'description' => 'Nombre del cliente.',
                ],
                'year'        => [
                    'type'        => 'integer',
                    'description' => 'Año de realización del proyecto.',
                    'minimum'     => 2000,
                    'maximum'     => 2100,
                ],
                'category'    => [
                    'type'        => 'string',
                    'description' => 'Slug de la categoría de portfolio.',
                ],
                'featured'    => [
                    'type'        => 'boolean',
                    'description' => 'Si el proyecto debe marcarse como destacado.',
                    'default'     => false,
                ],
            ],
        ],
        'output_schema' => [
            'type'       => 'object',
            'properties' => [
                'id'      => [ 'type' => 'integer', 'description' => 'ID del post creado.' ],
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

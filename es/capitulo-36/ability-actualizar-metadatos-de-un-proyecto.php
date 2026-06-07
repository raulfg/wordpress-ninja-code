private function register_update_project(): void {
    wp_register_ability( 'ninja-portfolio/update-project', [
        'label'       => __( 'Actualizar proyecto', 'ninja-portfolio' ),
        'description' => __( 'Actualiza los metadatos de un proyecto existente. Solo modifica los campos proporcionados.', 'ninja-portfolio' ),
        'category'    => 'ninja-portfolio',
        'input_schema' => [
            'type'     => 'object',
            'required' => [ 'id' ],
            'properties' => [
                'id'          => [ 'type' => 'integer', 'description' => 'ID del proyecto a actualizar.' ],
                'title'       => [ 'type' => 'string' ],
                'description' => [ 'type' => 'string' ],
                'client'      => [ 'type' => 'string' ],
                'year'        => [ 'type' => 'integer', 'minimum' => 2000, 'maximum' => 2100 ],
                'featured'    => [ 'type' => 'boolean' ],
                'category'    => [ 'type' => 'string', 'description' => 'Slug de la categoría.' ],
            ],
        ],
        'output_schema' => [
            'type'       => 'object',
            'properties' => [
                'success' => [ 'type' => 'boolean' ],
                'id'      => [ 'type' => 'integer' ],
            ],
        ],
        'execute_callback' => [ $this, 'execute_update_project' ],
        'permission_callback' => function(): bool {
            return current_user_can( 'edit_posts' );
        },
        'meta' => [
            'show_in_rest'  => true,
            'annotations'   => [ 'readonly' => false, 'destructive' => false, 'idempotent' => true ],
        ],
    ] );
}

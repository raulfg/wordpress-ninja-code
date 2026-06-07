private function register_get_project(): void {
    wp_register_ability( 'ninja-portfolio/get-project', [
        'label'       => __( 'Obtener proyecto por ID o slug', 'ninja-portfolio' ),
        'description' => __( 'Devuelve los datos completos de un proyecto, incluyendo todos sus metadatos.', 'ninja-portfolio' ),
        'category'    => 'ninja-portfolio',
        'input_schema' => [
            'type'       => 'object',
            'properties' => [
                'id'   => [ 'type' => 'integer', 'description' => 'ID del post.' ],
                'slug' => [ 'type' => 'string',  'description' => 'Slug del post.' ],
            ],
        ],
        'output_schema' => [
            'type'       => 'object',
            'properties' => [
                'id'          => [ 'type' => 'integer' ],
                'title'       => [ 'type' => 'string' ],
                'description' => [ 'type' => 'string' ],
                'url'         => [ 'type' => 'string', 'format' => 'uri' ],
                'client'      => [ 'type' => 'string' ],
                'year'        => [ 'type' => 'integer' ],
                'categories'  => [ 'type' => 'array', 'items' => [ 'type' => 'string' ] ],
                'featured'    => [ 'type' => 'boolean' ],
                'thumbnail'   => [ 'type' => 'string', 'format' => 'uri' ],
            ],
        ],
        'execute_callback'    => [ $this, 'execute_get_project' ],
        'permission_callback' => '__return_true',
        'meta' => [
            'show_in_rest'  => true,
            'annotations'   => [ 'readonly' => true, 'destructive' => false, 'idempotent' => true ],
        ],
    ] );
}

public function execute_get_project( array $args ): array {
    $post = null;

    if ( ! empty( $args['id'] ) ) {
        $post = get_post( (int) $args['id'] );
    } elseif ( ! empty( $args['slug'] ) ) {
        $posts = get_posts( [
            'name'        => sanitize_title( $args['slug'] ),
            'post_type'   => 'portfolio',
            'post_status' => 'publish',
            'numberposts' => 1,
        ] );
        $post = $posts[0] ?? null;
    }

    if ( ! $post || 'portfolio' !== $post->post_type ) {
        return [];
    }

    $terms = get_the_terms( $post->ID, 'portfolio-category' ) ?: [];

    return [
        'id'          => $post->ID,
        'title'       => get_the_title( $post ),
        'description' => wp_strip_all_tags( $post->post_content ),
        'url'         => get_permalink( $post ),
        'client'      => (string) get_post_meta( $post->ID, '_npe_client_name', true ),
        'year'        => (int) get_post_meta( $post->ID, '_npe_project_year', true ),
        'featured'    => (bool) get_post_meta( $post->ID, '_npe_is_featured', true ),
        'categories'  => wp_list_pluck( $terms, 'name' ),
        'thumbnail'   => (string) get_the_post_thumbnail_url( $post->ID, 'large' ),
    ];
}

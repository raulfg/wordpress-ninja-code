private function register_get_stats(): void {
    wp_register_ability( 'ninja-portfolio/get-stats', [
        'label'       => __( 'Portfolio statistics', 'ninja-portfolio' ),
        'description' => __( 'Returns general portfolio statistics: total projects, breakdown by category and year.', 'ninja-portfolio' ),
        'category'    => 'ninja-portfolio',
        'input_schema' => [ 'type' => 'object', 'properties' => [] ],
        'output_schema' => [
            'type'       => 'object',
            'properties' => [
                'total'        => [ 'type' => 'integer' ],
                'featured'     => [ 'type' => 'integer' ],
                'by_category'  => [
                    'type'  => 'array',
                    'items' => [
                        'type'       => 'object',
                        'properties' => [
                            'name'  => [ 'type' => 'string' ],
                            'count' => [ 'type' => 'integer' ],
                        ],
                    ],
                ],
                'by_year'      => [
                    'type'  => 'array',
                    'items' => [
                        'type'       => 'object',
                        'properties' => [
                            'year'  => [ 'type' => 'integer' ],
                            'count' => [ 'type' => 'integer' ],
                        ],
                    ],
                ],
            ],
        ],
        'execute_callback'    => [ $this, 'execute_get_stats' ],
        'permission_callback' => '__return_true',
        'meta' => [
            'show_in_rest'  => true,
            'annotations'   => [ 'readonly' => true, 'destructive' => false, 'idempotent' => true ],
        ],
    ] );
}

public function execute_get_stats(): array {
    $total    = wp_count_posts( 'portfolio' )->publish;
    $featured = (int) ( new \WP_Query( [
        'post_type'      => 'portfolio',
        'post_status'    => 'publish',
        'meta_key'       => '_npe_is_featured',
        'meta_value'     => '1',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ] ) )->found_posts;

    $categories = get_terms( [
        'taxonomy'   => 'portfolio-category',
        'hide_empty' => true,
    ] );

    $by_category = array_map( fn( \WP_Term $t ) => [
        'name'  => $t->name,
        'count' => (int) $t->count,
    ], $categories ?: [] );

    return [
        'total'       => (int) $total,
        'featured'    => $featured,
        'by_category' => $by_category,
        'by_year'     => [], // Can be extended with a GROUP BY query on post_meta
    ];
}

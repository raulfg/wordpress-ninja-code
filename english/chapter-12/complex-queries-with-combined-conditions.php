$args = [
    'post_type'      => 'portfolio',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'orderby'        => 'meta_value_num',
    'meta_key'       => '_proyecto_year',
    'order'          => 'DESC',

    // Filter by taxonomy
    'tax_query'  => [
        'relation' => 'AND',
        [
            'taxonomy' => 'portfolio-category',
            'field'    => 'slug',
            'terms'    => [ 'web', 'mobile' ],
            'operator' => 'IN',
        ],
        [
            'taxonomy' => 'portfolio-technology',
            'field'    => 'slug',
            'terms'    => 'react',
            'operator' => 'AND', // The post MUST have this term
        ],
    ],

    // Filter by metadata
    'meta_query' => [
        'relation' => 'AND',
        'year_clause' => [
            'key'     => '_proyecto_year',
            'value'   => [ 2023, 2024, 2025 ],
            'compare' => 'IN',
            'type'    => 'NUMERIC',
        ],
        'destacado_clause' => [
            'key'     => '_proyecto_destacado',
            'value'   => '1',
            'compare' => '=',
        ],
    ],
];

$query = new WP_Query( $args );

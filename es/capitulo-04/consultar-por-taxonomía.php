// Entradas de la categoría con slug "tutoriales"
$query = new WP_Query( [
    'post_type'      => 'post',
    'category_name'  => 'tutoriales',
    'posts_per_page' => 10,
] );

// Sintaxis tax_query — más flexible, funciona con cualquier taxonomía
$query = new WP_Query( [
    'post_type'  => 'post',
    'tax_query'  => [
        [
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => [ 'tutoriales', 'guias' ],
            'operator' => 'IN',
        ],
    ],
] );

// Últimos 6 proyectos del portfolio
$portfolio = new WP_Query( [
    'post_type'      => 'portfolio',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
] );

// Proyectos de una categoría específica
$portfolio_branding = new WP_Query( [
    'post_type'  => 'portfolio',
    'posts_per_page' => 9,
    'tax_query'  => [
        [
            'taxonomy' => 'portfolio-category',
            'field'    => 'slug',
            'terms'    => 'branding',
        ],
    ],
] );

// Proyectos con metadato específico (cliente concreto)
$proyectos_cliente = new WP_Query( [
    'post_type'  => 'portfolio',
    'meta_query' => [
        [
            'key'     => '_npe_client_name',
            'value'   => 'Empresa XYZ',
            'compare' => '=',
        ],
    ],
] );

// Múltiples tipos en un solo listado
$mixed = new WP_Query( [
    'post_type'      => [ 'post', 'portfolio', 'case-study' ],
    'posts_per_page' => 10,
] );

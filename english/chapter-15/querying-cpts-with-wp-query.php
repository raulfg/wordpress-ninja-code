// Last 6 portfolio projects
$portfolio = new WP_Query( [
    'post_type'      => 'portfolio',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
] );

// Projects from a specific category
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

// Projects with a specific meta value (specific client)
$client_projects = new WP_Query( [
    'post_type'  => 'portfolio',
    'meta_query' => [
        [
            'key'     => '_npe_client_name',
            'value'   => 'Company XYZ',
            'compare' => '=',
        ],
    ],
] );

// Multiple post types in a single listing
$mixed = new WP_Query( [
    'post_type'      => [ 'post', 'portfolio', 'case-study' ],
    'posts_per_page' => 10,
] );

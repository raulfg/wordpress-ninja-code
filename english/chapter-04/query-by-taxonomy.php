// Posts from the category with slug "tutorials"
$query = new WP_Query( [
    'post_type'      => 'post',
    'category_name'  => 'tutorials',
    'posts_per_page' => 10,
] );

// tax_query syntax — more flexible, works with any taxonomy
$query = new WP_Query( [
    'post_type'  => 'post',
    'tax_query'  => [
        [
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => [ 'tutorials', 'guides' ],
            'operator' => 'IN',
        ],
    ],
] );

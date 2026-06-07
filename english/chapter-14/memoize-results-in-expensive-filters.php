// Without memoization: the query runs on every call
add_filter( 'npe_get_featured_count', function(): int {
    return (int) (new WP_Query( [
        'post_type'      => 'portfolio',
        'post_status'    => 'publish',
        'meta_key'       => '_npe_is_featured',
        'meta_value'     => '1',
        'posts_per_page' => -1,
        'no_found_rows'  => false,
        'fields'         => 'ids',
    ] ))->found_posts;
} );

// With memoization: the query runs only once per request
add_filter( 'npe_get_featured_count', function(): int {
    static $count = null;

    if ( null === $count ) {
        $count = (int) (new WP_Query( [
            'post_type'      => 'portfolio',
            'post_status'    => 'publish',
            'meta_key'       => '_npe_is_featured',
            'meta_value'     => '1',
            'posts_per_page' => -1,
            'no_found_rows'  => false,
            'fields'         => 'ids',
        ] ))->found_posts;
    }

    return $count;
} );

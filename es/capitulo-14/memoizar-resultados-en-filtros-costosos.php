// Sin memoizar: la query se ejecuta por cada llamada
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

// Con memoización: la query se ejecuta solo una vez por request
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

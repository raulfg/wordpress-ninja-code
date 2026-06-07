add_action( 'save_post', function ( int $post_id, WP_Post $post ) {
    if ( 'publish' !== $post->post_status || wp_is_post_revision( $post_id ) ) {
        return;
    }

    $next_url = defined( 'NEXTJS_URL' ) ? NEXTJS_URL : '';
    $secret   = defined( 'REVALIDATION_SECRET' ) ? REVALIDATION_SECRET : '';

    wp_remote_post(
        "{$next_url}/api/revalidate?secret={$secret}",
        [
            'headers'     => [ 'Content-Type' => 'application/json' ],
            'body'        => wp_json_encode( [ 'path' => '/' ] ),
            'timeout'     => 5,
            'blocking'    => false,
        ]
    );
}, 10, 2 );

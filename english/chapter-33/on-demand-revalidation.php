add_action( 'save_post', function( int $post_id, WP_Post $post ): void {
    if ( 'publish' !== $post->post_status ) {
        return;
    }
    if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
        return;
    }

    $next_url      = get_option( 'ninja_nextjs_url' ); // e.g. https://my-frontend.vercel.app
    $secret        = get_option( 'ninja_revalidation_secret' );
    $slug          = $post->post_name;
    $post_type     = $post->post_type;

    // Calculate the Next.js path for this post
    $path = match ( $post_type ) {
        'post'      => "/blog/{$slug}",
        'portfolio' => "/portfolio/{$slug}",
        'page'      => "/{$slug}",
        default     => null,
    };

    if ( ! $path ) {
        return;
    }

    wp_remote_post(
        "{$next_url}/api/revalidate?secret={$secret}",
        [
            'timeout'     => 5,
            'blocking'    => false, // Do not wait for the response
            'headers'     => [ 'Content-Type' => 'application/json' ],
            'body'        => wp_json_encode( [ 'path' => $path ] ),
        ]
    );
}, 10, 2 );

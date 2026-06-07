// Correct: use template_redirect for access restrictions
add_action( 'template_redirect', function(): void {
    if ( is_singular( 'portfolio' ) && ! is_user_logged_in() ) {
        wp_redirect( wp_login_url( get_permalink() ) );
        exit;
    }
} );

// Incorrect: using pre_get_posts for access restrictions
// (the post is still accessible directly via URL)
add_action( 'pre_get_posts', function( WP_Query $query ): void {
    if ( $query->is_singular( 'portfolio' ) && ! is_user_logged_in() ) {
        // This only excludes the post from the loop, it does not restrict access
        $query->set( 'post__not_in', [ get_queried_object_id() ] );
    }
} );

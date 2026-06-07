// For authenticated users
add_action( 'wp_ajax_ninja_save_favorite', 'ninja_save_favorite' );

// For unauthenticated users (and also for authenticated users if registered here)
add_action( 'wp_ajax_nopriv_ninja_save_favorite', 'ninja_save_favorite' );

function ninja_save_favorite(): void {
    // Verify nonce before doing anything else
    check_ajax_referer( 'ninja-favorite-nonce', 'nonce' );

    $post_id = filter_input( INPUT_POST, 'post_id', FILTER_VALIDATE_INT );

    if ( ! $post_id ) {
        wp_send_json_error( [ 'message' => 'Invalid post ID.' ], 400 );
    }

    // Business logic
    $result = ninja_toggle_favorite( get_current_user_id(), $post_id );

    wp_send_json_success( [ 'favorite' => $result ] );
}

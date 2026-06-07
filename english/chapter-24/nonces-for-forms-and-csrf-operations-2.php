// In the callback that renders the meta box
function ninja_portfolio_meta_box( WP_Post $post ): void {
    wp_nonce_field( 'ninja_portfolio_save_' . $post->ID, 'ninja_portfolio_nonce' );
    // ... form fields
}

// In save_post
add_action( 'save_post_portfolio', function( int $post_id ): void {
    // 1. Verify nonce
    if ( ! isset( $_POST['ninja_portfolio_nonce'] ) ||
         ! wp_verify_nonce( $_POST['ninja_portfolio_nonce'], 'ninja_portfolio_save_' . $post_id ) ) {
        return;
    }

    // 2. Prevent autosaves
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // 3. Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // 4. Save
    if ( isset( $_POST['proyecto_url'] ) ) {
        update_post_meta(
            $post_id,
            '_proyecto_url',
            esc_url_raw( wp_unslash( $_POST['proyecto_url'] ) )
        );
    }
} );

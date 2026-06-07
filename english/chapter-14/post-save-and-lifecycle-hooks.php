// Run logic when a post is published for the first time
add_action( 'transition_post_status', function ( string $new_status, string $old_status, WP_Post $post ): void {
    if ( 'publish' !== $new_status || 'publish' === $old_status ) {
        return; // First publication only
    }
    if ( 'post' !== $post->post_type ) {
        return;
    }

    // Notify, generate sitemap, update search index...
    do_action( 'ninja_post_published_first_time', $post );

}, 10, 3 );

// save_post: save metadata with nonce verification
add_action( 'save_post_portfolio', function ( int $post_id, WP_Post $post, bool $update ): void {
    // Ignore autosaves and revisions
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( wp_is_post_revision( $post_id ) ) return;

    // Verify nonce (the field must be in the metabox)
    if ( ! isset( $_POST['ninja_portfolio_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['ninja_portfolio_nonce'], 'ninja_portfolio_save' ) ) return;

    // Verify permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Save the meta value
    if ( isset( $_POST['proyecto_url'] ) ) {
        update_post_meta(
            $post_id,
            '_proyecto_url',
            esc_url_raw( wp_unslash( $_POST['proyecto_url'] ) )
        );
    }

}, 10, 3 );

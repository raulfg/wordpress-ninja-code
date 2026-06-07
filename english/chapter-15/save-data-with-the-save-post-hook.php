add_action( 'save_post_portfolio', 'ninjatheme_save_portfolio_meta' );

function ninjatheme_save_portfolio_meta( int $post_id ): void {
	// 1. Verify the nonce
	if (
		! isset( $_POST['ninjatheme_portfolio_nonce'] ) ||
		! wp_verify_nonce( $_POST['ninjatheme_portfolio_nonce'], 'ninjatheme_portfolio_save' )
	) {
		return;
	}

	// 2. Verify user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// 3. Ignore autosaves
	if ( wp_is_post_autosave( $post_id ) ) {
		return;
	}

	// 4. Ignore revisions
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	// Sanitize and save
	if ( isset( $_POST['portfolio_project_url'] ) ) {
		update_post_meta(
			$post_id,
			'_npe_project_url',
			esc_url_raw( $_POST['portfolio_project_url'] )
		);
	}

	if ( isset( $_POST['portfolio_client_name'] ) ) {
		update_post_meta(
			$post_id,
			'_npe_client_name',
			sanitize_text_field( $_POST['portfolio_client_name'] )
		);
	}
}

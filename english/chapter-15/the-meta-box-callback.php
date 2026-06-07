function ninjatheme_portfolio_meta_box_html( WP_Post $post ): void {
	wp_nonce_field( 'ninjatheme_portfolio_save', 'ninjatheme_portfolio_nonce' );

	$project_url = get_post_meta( $post->ID, '_npe_project_url', true );
	$client_name = get_post_meta( $post->ID, '_npe_client_name', true );
	?>
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="portfolio_project_url">Project URL</label>
			</th>
			<td>
				<input
					type="url"
					id="portfolio_project_url"
					name="portfolio_project_url"
					value="<?php echo esc_url( $project_url ); ?>"
					class="regular-text"
				/>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="portfolio_client_name">Client</label>
			</th>
			<td>
				<input
					type="text"
					id="portfolio_client_name"
					name="portfolio_client_name"
					value="<?php echo esc_attr( $client_name ); ?>"
					class="regular-text"
				/>
			</td>
		</tr>
	</table>
	<?php
}

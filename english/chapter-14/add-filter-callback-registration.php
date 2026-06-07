// Add an author signature at the end of each post's content
add_filter( 'the_content', 'ninja_add_author_signature', 20 );

function ninja_add_author_signature( string $content ): string
{
	if ( ! is_single() || ! in_the_loop() ) {
		return $content;
	}

	$author_id   = get_the_author_meta( 'ID' );
	$author_name = get_the_author_meta( 'display_name' );
	$author_bio  = get_the_author_meta( 'description' );

	if ( empty( $author_bio ) ) {
		return $content;
	}

	$firma = sprintf(
		'<div class="author-signature"><strong>%s</strong><p>%s</p></div>',
		esc_html( $author_name ),
		esc_html( $author_bio )
	);

	return $content . $firma;
}

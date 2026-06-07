// Añadir una firma al final del contenido de cada post
add_filter( 'the_content', 'ninja_añadir_firma_autor', 20 );

function ninja_añadir_firma_autor( string $content ): string
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

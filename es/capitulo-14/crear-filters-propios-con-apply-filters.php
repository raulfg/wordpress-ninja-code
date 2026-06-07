/**
 * Genera el extracto para las tarjetas de artículo.
 *
 * @param int $post_id ID del post.
 * @param int $length  Número de palabras del extracto.
 * @return string El extracto filtrado.
 */
function ninja_get_card_excerpt( int $post_id, int $length = 30 ): string
{
	$excerpt = wp_trim_words( get_the_excerpt( $post_id ), $length );

	/**
	 * Filters the excerpt used in article cards.
	 *
	 * @param string $excerpt The trimmed excerpt.
	 * @param int    $post_id The post ID.
	 * @param int    $length  The word count requested.
	 */
	return apply_filters( 'ninja_card_excerpt', $excerpt, $post_id, $length );
}

/**
 * Generates the excerpt for article cards.
 *
 * @param int $post_id Post ID.
 * @param int $length  Number of words in the excerpt.
 * @return string The filtered excerpt.
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

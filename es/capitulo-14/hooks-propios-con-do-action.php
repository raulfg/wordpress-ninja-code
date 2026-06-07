/**
 * Renderiza la cabecera del artículo.
 *
 * @param WP_Post $post El post actual.
 */
function ninja_render_article_header( WP_Post $post ): void
{
	/**
	 * Fires before the article header is rendered.
	 *
	 * @param WP_Post $post The current post object.
	 */
	do_action( 'ninja_before_article_header', $post );

	echo '<header class="article-header">';
	the_title( '<h1 class="article-title">', '</h1>' );

	/**
	 * Fires inside the article header, after the title.
	 *
	 * @param WP_Post $post The current post object.
	 */
	do_action( 'ninja_article_header_after_title', $post );

	echo '</header>';

	/**
	 * Fires after the article header is rendered.
	 *
	 * @param WP_Post $post The current post object.
	 */
	do_action( 'ninja_after_article_header', $post );
}

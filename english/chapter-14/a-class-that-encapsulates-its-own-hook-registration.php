class NinjaContentManager
{
	public function __construct()
	{
		add_filter( 'the_content',    [ $this, 'add_author_signature' ], 20 );
		add_filter( 'the_excerpt',    [ $this, 'truncate_excerpt' ], 10 );
		add_filter( 'excerpt_more',   [ $this, 'custom_excerpt_more' ] );
		add_action( 'save_post_post', [ $this, 'update_reading_time' ], 10, 2 );
	}

	public function add_author_signature( string $content ): string
	{
		if ( ! is_single() || ! in_the_loop() ) {
			return $content;
		}

		$bio = get_the_author_meta( 'description' );

		if ( empty( $bio ) ) {
			return $content;
		}

		return $content . sprintf(
			'<aside class="author-bio"><p>%s</p></aside>',
			esc_html( $bio )
		);
	}

	public function truncate_excerpt( string $excerpt ): string
	{
		return wp_trim_words( $excerpt, 25 );
	}

	public function custom_excerpt_more( string $more ): string
	{
		return sprintf(
			'&hellip; <a href="%s" class="read-more">%s</a>',
			esc_url( get_permalink() ),
			esc_html__( 'Continue reading', 'ninja-theme' )
		);
	}

	public function update_reading_time( int $post_id, WP_Post $post ): void
	{
		$word_count    = str_word_count( wp_strip_all_tags( $post->post_content ) );
		$reading_time  = (int) ceil( $word_count / 200 );

		update_post_meta( $post_id, '_ninja_reading_time', $reading_time );
	}
}

// In functions.php:
new NinjaContentManager();

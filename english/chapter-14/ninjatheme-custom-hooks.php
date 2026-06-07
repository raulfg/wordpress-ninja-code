// In an external plugin: insert a banner before post content
add_action( 'ninjatheme_before_post_content', function ( int $post_id ): void {
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    $reading_time = (int) get_post_meta( $post_id, '_ninja_reading_time', true );

    if ( $reading_time > 0 ) {
        printf(
            '<p class="reading-time">%s</p>',
            esc_html( sprintf(
                /* translators: %d: number of minutes */
                _n( 'Reading time: %d minute', 'Reading time: %d minutes', $reading_time, 'my-plugin' ),
                $reading_time
            ) )
        );
    }
} );

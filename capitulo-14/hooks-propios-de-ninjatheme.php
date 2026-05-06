// En un plugin externo: insertar banner antes del contenido de posts
add_action( 'ninjatheme_before_post_content', function ( int $post_id ): void {
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    $reading_time = (int) get_post_meta( $post_id, '_ninja_reading_time', true );

    if ( $reading_time > 0 ) {
        printf(
            '<p class="reading-time">%s</p>',
            esc_html( sprintf(
                /* translators: %d: número de minutos */
                _n( 'Lectura de %d minuto', 'Lectura de %d minutos', $reading_time, 'mi-plugin' ),
                $reading_time
            ) )
        );
    }
} );

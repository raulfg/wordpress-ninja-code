add_action( 'wp_head', function(): void {
    if ( ! is_singular() || ! has_post_thumbnail() ) {
        return;
    }

    $thumbnail_id  = get_post_thumbnail_id();
    $image_src     = wp_get_attachment_image_src( $thumbnail_id, 'large' );

    if ( $image_src ) {
        printf(
            '<link rel="preload" as="image" href="%s">%s',
            esc_url( $image_src[0] ),
            "\n"
        );
    }
} );

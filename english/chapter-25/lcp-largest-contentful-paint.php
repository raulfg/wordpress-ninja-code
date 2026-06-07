add_filter( 'wp_preload_resources', function( array $resources ): array {
    if ( is_singular( 'portfolio' ) ) {
        // Preload the project's featured image
        $thumbnail_id = get_post_thumbnail_id();
        if ( $thumbnail_id ) {
            $image_src = wp_get_attachment_image_src( $thumbnail_id, 'large' );
            if ( $image_src ) {
                $resources[] = [
                    'rel'  => 'preload',
                    'href' => $image_src[0],
                    'as'   => 'image',
                ];
            }
        }
    }
    return $resources;
} );

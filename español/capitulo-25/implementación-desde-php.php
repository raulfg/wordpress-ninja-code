add_action( 'wp_head', function(): void {
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    $post        = get_post();
    $author      = get_userdata( $post->post_author );
    $image_id    = get_post_thumbnail_id( $post );
    $image_url   = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';

    $schema = [
        '@context'         => 'https://schema.org',
        '@type'            => 'BlogPosting',
        'headline'         => get_the_title( $post ),
        'datePublished'    => get_the_date( DATE_W3C, $post ),
        'dateModified'     => get_the_modified_date( DATE_W3C, $post ),
        'author'           => [
            '@type' => 'Person',
            'name'  => $author ? $author->display_name : '',
            'url'   => $author ? get_author_posts_url( $author->ID ) : '',
        ],
        'publisher'        => [
            '@type' => 'Organization',
            'name'  => get_bloginfo( 'name' ),
            'url'   => home_url(),
        ],
        'description'      => wp_strip_all_tags( get_the_excerpt( $post ) ),
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => get_permalink( $post ),
        ],
    ];

    if ( $image_url ) {
        $schema['image'] = $image_url;
    }

    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
    );
} );

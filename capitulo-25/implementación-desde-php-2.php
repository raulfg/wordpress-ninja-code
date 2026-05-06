add_action( 'wp_head', function(): void {
    if ( ! is_singular( 'portfolio' ) ) {
        return;
    }

    $post      = get_post();
    $client    = get_post_meta( $post->ID, '_portfolio_client', true );
    $year      = get_post_meta( $post->ID, '_portfolio_year', true );
    $image_url = get_the_post_thumbnail_url( $post, 'large' );

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'CreativeWork',
        'name'        => get_the_title( $post ),
        'url'         => get_permalink( $post ),
        'description' => wp_strip_all_tags( get_the_excerpt( $post ) ),
        'dateCreated' => $year ?: get_the_date( 'Y', $post ),
        'creator'     => [
            '@type' => 'Organization',
            'name'  => get_bloginfo( 'name' ),
        ],
    ];

    if ( $client ) {
        $schema['sourceOrganization'] = [
            '@type' => 'Organization',
            'name'  => $client,
        ];
    }

    if ( $image_url ) {
        $schema['image'] = $image_url;
    }

    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
    );
} );

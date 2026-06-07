add_action( 'wp_head', function(): void {
    if ( ! is_singular() && ! is_category() && ! is_tag() ) {
        return;
    }

    $items = [];

    // Inicio
    $items[] = [
        '@type'    => 'ListItem',
        'position' => 1,
        'name'     => esc_html( get_bloginfo( 'name' ) ),
        'item'     => home_url( '/' ),
    ];

    // Categoría o taxonomía (si aplica)
    if ( is_singular( 'post' ) ) {
        $cats = get_the_category();
        if ( $cats ) {
            $items[] = [
                '@type'    => 'ListItem',
                'position' => 2,
                'name'     => esc_html( $cats[0]->name ),
                'item'     => esc_url( get_category_link( $cats[0]->term_id ) ),
            ];
            $items[] = [
                '@type'    => 'ListItem',
                'position' => 3,
                'name'     => esc_html( get_the_title() ),
                'item'     => esc_url( get_permalink() ),
            ];
        }
    } elseif ( is_category() ) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => esc_html( single_cat_title( '', false ) ),
            'item'     => esc_url( get_category_link( get_queried_object_id() ) ),
        ];
    }

    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
} );

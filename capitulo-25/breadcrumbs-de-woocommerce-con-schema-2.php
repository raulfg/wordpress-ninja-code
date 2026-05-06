add_action( 'wp_head', function(): void {
    if ( ! is_woocommerce() && ! is_product_category() ) {
        return;
    }

    $items     = [];
    $position  = 1;
    $crumbs    = WC()->query->get_breadcrumb();

    foreach ( $crumbs as $crumb ) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => wp_strip_all_tags( $crumb[0] ),
            'item'     => $crumb[1] ?? '',
        ];
        $position++;
    }

    if ( empty( $items ) ) {
        return;
    }

    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode( [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
    );
} );

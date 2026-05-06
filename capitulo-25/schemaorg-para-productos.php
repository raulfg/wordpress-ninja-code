add_action( 'wp_head', function(): void {
    if ( ! is_singular( 'product' ) ) {
        return;
    }

    global $product;

    if ( ! $product instanceof WC_Product ) {
        $product = wc_get_product( get_the_ID() );
    }

    if ( ! $product ) {
        return;
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Product',
        'name'     => $product->get_name(),
        'sku'      => $product->get_sku(),
        'description' => wp_strip_all_tags( $product->get_short_description() ),
        'image'    => wp_get_attachment_url( $product->get_image_id() ),
        'url'      => get_permalink( $product->get_id() ),
        'offers'   => [
            '@type'         => 'Offer',
            'price'         => $product->get_price(),
            'priceCurrency' => get_woocommerce_currency(),
            'availability'  => $product->is_in_stock()
                ? 'https://schema.org/InStock'
                : 'https://schema.org/OutOfStock',
            'url'           => get_permalink( $product->get_id() ),
        ],
    ];

    // Añadir valoraciones si las hay
    if ( $product->get_rating_count() > 0 ) {
        $schema['aggregateRating'] = [
            '@type'       => 'AggregateRating',
            'ratingValue' => $product->get_average_rating(),
            'reviewCount' => $product->get_rating_count(),
        ];
    }

    // Añadir marca si tiene el atributo
    $brand = $product->get_attribute( 'pa_marca' );
    if ( $brand ) {
        $schema['brand'] = [
            '@type' => 'Brand',
            'name'  => $brand,
        ];
    }

    printf(
        '<script type="application/ld+json">%s</script>' . "\n",
        wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
    );
} );

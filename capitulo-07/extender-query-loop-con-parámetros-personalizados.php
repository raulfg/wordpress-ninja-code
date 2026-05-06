add_filter( 'query_loop_block_query_vars', function( array $query, WP_Block $block, int $page ): array {
    // Solo para el CPT portfolio
    if ( 'portfolio' !== ( $query['post_type'] ?? 'post' ) ) {
        return $query;
    }

    // Si el bloque tiene el atributo personalizado 'soloDestacados'
    if ( ! empty( $block->context['query']['soloDestacados'] ) ) {
        $query['meta_query'] = [
            [
                'key'   => '_proyecto_destacado',
                'value' => '1',
            ],
        ];
    }

    return $query;
}, 10, 3 );

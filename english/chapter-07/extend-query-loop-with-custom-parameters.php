add_filter( 'query_loop_block_query_vars', function( array $query, WP_Block $block, int $page ): array {
    // Only for the portfolio CPT
    if ( 'portfolio' !== ( $query['post_type'] ?? 'post' ) ) {
        return $query;
    }

    // If the block has the custom attribute 'soloDestacados'
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

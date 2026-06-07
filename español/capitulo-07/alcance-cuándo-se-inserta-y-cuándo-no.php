register_block_type( 'ninjatheme/portfolio-meta-sidebar', [
    'render_callback' => 'ninjatheme_render_portfolio_meta',
    'block_hooks'     => [
        'core/post-content' => 'before',
    ],
    'provides_context' => [],
] );

// Filtrar qué instancias del hook se activan
add_filter( 'hooked_block_types', function( array $hooked_blocks, string $relative_position, string $anchor_block_type, array $context ): array {
    // Solo insertar en entradas de tipo portfolio
    if ( 'core/post-content' === $anchor_block_type && 'before' === $relative_position ) {
        // Verificar si el template actual es para el CPT portfolio
        $template = $context['templateSlug'] ?? '';
        if ( str_starts_with( $template, 'single-portfolio' ) ) {
            $hooked_blocks[] = 'ninjatheme/portfolio-meta-sidebar';
        }
    }

    return $hooked_blocks;
}, 10, 4 );

register_block_type( 'ninjatheme/portfolio-meta-sidebar', [
    'render_callback' => 'ninjatheme_render_portfolio_meta',
    'block_hooks'     => [
        'core/post-content' => 'before',
    ],
    'provides_context' => [],
] );

// Filter which hook instances are activated
add_filter( 'hooked_block_types', function( array $hooked_blocks, string $relative_position, string $anchor_block_type, array $context ): array {
    // Only insert in portfolio post type entries
    if ( 'core/post-content' === $anchor_block_type && 'before' === $relative_position ) {
        // Check if the current template is for the portfolio CPT
        $template = $context['templateSlug'] ?? '';
        if ( str_starts_with( $template, 'single-portfolio' ) ) {
            $hooked_blocks[] = 'ninjatheme/portfolio-meta-sidebar';
        }
    }

    return $hooked_blocks;
}, 10, 4 );

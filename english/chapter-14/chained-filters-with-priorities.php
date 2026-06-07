// Content passes through several filters before being displayed

// Priority 5: add schema markup at the beginning
add_filter( 'the_content', function( string $content ): string {
    if ( ! is_singular( 'portfolio' ) ) {
        return $content;
    }
    return npe_get_schema_markup() . $content;
}, 5 );

// Priority 10 (default): clean up problematic HTML
add_filter( 'the_content', function( string $content ): string {
    return wp_kses_post( $content );
}, 10 );

// Priority 20: add lazy loading to images
add_filter( 'the_content', function( string $content ): string {
    return str_replace( '<img ', '<img loading="lazy" ', $content );
}, 20 );

// Priority 100: process plugin shortcodes (after everything above)
add_filter( 'the_content', function( string $content ): string {
    return npe_process_portfolio_shortcodes( $content );
}, 100 );

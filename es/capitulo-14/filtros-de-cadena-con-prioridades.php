// El contenido pasa por varios filtros antes de mostrarse

// Prioridad 5: añadir schema markup al principio
add_filter( 'the_content', function( string $content ): string {
    if ( ! is_singular( 'portfolio' ) ) {
        return $content;
    }
    return npe_get_schema_markup() . $content;
}, 5 );

// Prioridad 10 (por defecto): limpiar HTML problemático
add_filter( 'the_content', function( string $content ): string {
    return wp_kses_post( $content );
}, 10 );

// Prioridad 20: añadir lazy loading a las imágenes
add_filter( 'the_content', function( string $content ): string {
    return str_replace( '<img ', '<img loading="lazy" ', $content );
}, 20 );

// Prioridad 100: procesar shortcodes del plugin (después de todo lo anterior)
add_filter( 'the_content', function( string $content ): string {
    return npe_process_portfolio_shortcodes( $content );
}, 100 );

// Sobreescribir el título SEO generado por Yoast
add_filter( 'wpseo_title', function( string $title ): string {
    if ( is_singular( 'portfolio' ) ) {
        return get_the_title() . ' — Portfolio | NinjaTheme';
    }
    return $title;
} );

// Sobreescribir la meta description
add_filter( 'wpseo_metadesc', function( string $description ): string {
    if ( is_singular( 'portfolio' ) && '' === $description ) {
        $excerpt = get_post_field( 'post_excerpt', get_the_ID() );
        return wp_strip_all_tags( $excerpt );
    }
    return $description;
} );

// Sobreescribir la URL canónica
add_filter( 'wpseo_canonical', function( string $canonical ): string {
    if ( is_singular( 'portfolio' ) ) {
        return home_url( '/portfolio/' . get_post_field( 'post_name' ) . '/' );
    }
    return $canonical;
} );

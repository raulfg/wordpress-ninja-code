add_filter( 'wpseo_breadcrumb_links', function( array $links ): array {
    if ( is_singular( 'portfolio' ) ) {
        $post    = get_post();
        $section = get_post_meta( $post->ID, '_portfolio_section', true );

        $links = [
            [ 'url' => home_url( '/' ),           'text' => 'Home' ],
            [ 'url' => home_url( '/portfolio/' ),  'text' => 'Portfolio' ],
        ];

        if ( $section ) {
            $links[] = [
                'url'  => home_url( '/portfolio/' . sanitize_title( $section ) . '/' ),
                'text' => $section,
            ];
        }

        $links[] = [ 'url' => get_permalink( $post ), 'text' => get_the_title( $post ) ];
    }

    return $links;
} );

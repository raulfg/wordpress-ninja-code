add_action( 'wp_head', function () {
    if ( ! is_singular() ) {
        return;
    }

    // Polylang: pll_the_languages() in array mode returns all languages
    if ( function_exists( 'pll_the_languages' ) ) {
        $languages = pll_the_languages( [ 'raw' => 1 ] );
        foreach ( $languages as $lang ) {
            printf(
                '<link rel="alternate" hreflang="%s" href="%s" />' . "\n",
                esc_attr( $lang['locale'] ),
                esc_url( $lang['url'] )
            );
        }
    }
} );

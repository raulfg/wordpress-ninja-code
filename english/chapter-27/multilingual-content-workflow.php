// Mark a translation as outdated when the original changes
add_action( 'save_post', function( int $post_id ): void {
    if ( ! function_exists( 'pll_get_post_translations' ) ) {
        return;
    }

    // Only for the network's default language
    if ( pll_get_post_language( $post_id ) !== pll_default_language() ) {
        return;
    }

    $translations = pll_get_post_translations( $post_id );
    $default_lang = pll_default_language();

    foreach ( $translations as $lang => $translated_id ) {
        if ( $lang === $default_lang || ! $translated_id ) {
            continue;
        }
        // Mark the translation as outdated
        update_post_meta( $translated_id, '_translation_outdated', '1' );
    }
} );

// Clear the flag when saving the updated translation
add_action( 'save_post', function( int $post_id ): void {
    if ( ! function_exists( 'pll_get_post_language' ) ) {
        return;
    }
    if ( pll_get_post_language( $post_id ) === pll_default_language() ) {
        return;
    }
    delete_post_meta( $post_id, '_translation_outdated' );
} );

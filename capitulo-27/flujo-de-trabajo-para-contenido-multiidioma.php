// Marcar una traducción como desactualizada cuando cambia el original
add_action( 'save_post', function( int $post_id ): void {
    if ( ! function_exists( 'pll_get_post_translations' ) ) {
        return;
    }

    // Solo para el idioma por defecto de la red
    if ( pll_get_post_language( $post_id ) !== pll_default_language() ) {
        return;
    }

    $translations = pll_get_post_translations( $post_id );
    $default_lang = pll_default_language();

    foreach ( $translations as $lang => $translated_id ) {
        if ( $lang === $default_lang || ! $translated_id ) {
            continue;
        }
        // Marcar la traducción como desactualizada
        update_post_meta( $translated_id, '_translation_outdated', '1' );
    }
} );

// Limpiar la marca al guardar la traducción actualizada
add_action( 'save_post', function( int $post_id ): void {
    if ( ! function_exists( 'pll_get_post_language' ) ) {
        return;
    }
    if ( pll_get_post_language( $post_id ) === pll_default_language() ) {
        return;
    }
    delete_post_meta( $post_id, '_translation_outdated' );
} );

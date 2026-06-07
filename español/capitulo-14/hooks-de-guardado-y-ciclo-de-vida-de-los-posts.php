// Ejecutar lógica al publicar una entrada por primera vez
add_action( 'transition_post_status', function ( string $new_status, string $old_status, WP_Post $post ): void {
    if ( 'publish' !== $new_status || 'publish' === $old_status ) {
        return; // Solo primera publicación
    }
    if ( 'post' !== $post->post_type ) {
        return;
    }

    // Notificar, generar sitemap, actualizar índice de búsqueda...
    do_action( 'ninja_post_published_first_time', $post );

}, 10, 3 );

// save_post: guardar metadatos con verificación de nonce
add_action( 'save_post_portfolio', function ( int $post_id, WP_Post $post, bool $update ): void {
    // Ignorar autoguardados y revisiones
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( wp_is_post_revision( $post_id ) ) return;

    // Verificar nonce (el campo debe estar en el metabox)
    if ( ! isset( $_POST['ninja_portfolio_nonce'] ) ) return;
    if ( ! wp_verify_nonce( $_POST['ninja_portfolio_nonce'], 'ninja_portfolio_save' ) ) return;

    // Verificar permisos
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Guardar el metadato
    if ( isset( $_POST['proyecto_url'] ) ) {
        update_post_meta(
            $post_id,
            '_proyecto_url',
            esc_url_raw( wp_unslash( $_POST['proyecto_url'] ) )
        );
    }

}, 10, 3 );
